<?php
//version 1
class PhpQuickProfiler {
	
	public $output = array();
	public $config = '';
	
	public function __construct($startTime, $config = 'includes/functions/') {
		global $svn_root;
		$this->startTime = $startTime;
		$this->config = $config;
		require_once($svn_root.$config.'classes/Console.php');
	}
	
	/*-------------------------------------------
	     FORMAT THE DIFFERENT TYPES OF LOGS
	-------------------------------------------*/
	
	public function gatherConsoleData() {
		$logs = Console::getLogs();
		if($logs['console']) {
			foreach($logs['console'] as $key => $log) {
				if($log['type'] == 'log') {
					$logs['console'][$key]['data'] = print_r($log['data'], true);
				}
				elseif($log['type'] == 'memory') {
					$logs['console'][$key]['data'] = $this->getReadableFileSize($log['data']);
				}
				elseif($log['type'] == 'speed') {
					$logs['console'][$key]['data'] = $this->getReadableTime(($log['data'] - $this->startTime)*1000);
				}
			}
		}
		$this->output['logs'] = $logs;
	}
	
	/*-------------------------------------------
	    AGGREGATE DATA ON THE FILES INCLUDED
	-------------------------------------------*/
	
	public function gatherFileData() {
		$files = get_included_files();
		$fileList = array();
		$fileTotals = array(
			"count" => count($files),
			"size" => 0,
			"largest" => 0,
		);

		foreach($files as $key => $file) {
			$size = filesize($file);
			$fileList[] = array(
					'name' => $file,
					'size' => $this->getReadableFileSize($size)
				);
			$fileTotals['size'] += $size;
			if($size > $fileTotals['largest']) $fileTotals['largest'] = $size;
		}
		
		$fileTotals['size'] = $this->getReadableFileSize($fileTotals['size']);
		$fileTotals['largest'] = $this->getReadableFileSize($fileTotals['largest']);
		$this->output['files'] = $fileList;
		$this->output['fileTotals'] = $fileTotals;
	}
	
	/*-------------------------------------------
	     MEMORY USAGE AND MEMORY AVAILABLE
	-------------------------------------------*/
	
	public function gatherMemoryData() {
		$memoryTotals = array();
		$memoryTotals['used'] = $this->getReadableFileSize(memory_get_peak_usage());
		$memoryTotals['total'] = ini_get("memory_limit");
		$this->output['memoryTotals'] = $memoryTotals;
	}
	
	/*--------------------------------------------------------
	     QUERY DATA -- DATABASE OBJECT WITH LOGGING REQUIRED
	----------------------------------------------------------*/
	
	public function gatherQueryData() {
		$queryTotals = array();
		$queryTotals['count'] = 0;
		$queryTotals['time'] = 0;
		$queries = array();
		if($this->db != '') {
			$queryTotals['count'] += $this->db->queryCount;
			foreach($this->db->queries as $key => $query) {
				if($query["error"]=="No" && preg_match("/select/i",$query['sql'])){
					$query = $this->attemptToExplainQuery($query);
				}
				
				$queryTotals['time'] += $query['time'];
				$query['time'] = $this->getReadableTime($query['time']);
				$queries[] = $query;
			}
		}
		$queryTotals['time'] = $this->getReadableTime($queryTotals['time']);
		$this->output['queries'] = $queries;
		$this->output['queryTotals'] = $queryTotals;
		
	}
	
	/*--------------------------------------------------------
	     CALL SQL EXPLAIN ON THE QUERY TO FIND MORE INFO
	----------------------------------------------------------*/
	
	function attemptToExplainQuery($query) {
		try {
			$sql = 'EXPLAIN '.$query['sql'];
			$rs = $this->db->query($sql,$query['table']);
			
		}catch(Exception $e) {}
		
		if($rs) {
			$row = mysql_fetch_array($rs, MYSQL_ASSOC);
			$query['explain'] = $row;
		}else{
			$query['explain']=FALSE;
		}
		return $query;
	}
	
	/*-------------------------------------------
	     SPEED DATA FOR ENTIRE PAGE LOAD
	-------------------------------------------*/
	
	public function gatherSpeedData() {
		$speedTotals = array();
		$speedTotals['total'] = $this->getReadableTime(($this->getMicroTime() - $this->startTime)*1000);
		$speedTotals['allowed'] = ini_get("max_execution_time");
		$this->output['speedTotals'] = $speedTotals;
	}
	
	/*-------------------------------------------
	     HELPER FUNCTIONS TO FORMAT DATA
	-------------------------------------------*/
	
	function getMicroTime() {
		$time = microtime();
		$time = explode(' ', $time);
		return $time[1] + $time[0];
	}
	
	public function getReadableFileSize($size, $retstring = null) {
        	// adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
	       $sizes = array('bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

	       if ($retstring === null) { $retstring = '%01.2f %s'; }

		$lastsizestring = end($sizes);

		foreach ($sizes as $sizestring) {
	       	if ($size < 1024) { break; }
	           if ($sizestring != $lastsizestring) { $size /= 1024; }
	       }
	       if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; } // Bytes aren't normally fractional
	       return sprintf($retstring, $size, $sizestring);
	}
	
	public function getReadableTime($time) {
		$ret = $time;
		$formatter = 0;
		$formats = array('ms', 's', 'm');
		if($time >= 1000 && $time < 60000) {
			$formatter = 1;
			$ret = ($time / 1000);
		}
		if($time >= 60000) {
			$formatter = 2;
			$ret = ($time / 1000) / 60;
		}
		$ret = number_format($ret,3,'.','') . ' ' . $formats[$formatter];
		return $ret;
	}
	
	/*---------------------------------------------------------
	     DISPLAY TO THE SCREEN -- CALL WHEN CODE TERMINATING
	-----------------------------------------------------------*/
	
	public function display($db = '', $master_db = '') {
		$this->db = $db;
		$this->master_db = $master_db;
		$this->gatherConsoleData();
		$this->gatherFileData();
		$this->gatherMemoryData();
		$this->gatherQueryData();
		$this->gatherSpeedData();
		$this->displayPqp();
	}

        private function displayPqp() {

        $cssUrl = './styles/css/pQp.css';

        echo "<script type='text/javascript'>
                var PQP_DETAILS = true;
                var PQP_HEIGHT = 'short';

                addEvent(window, 'load', loadCSS);

                function changeTab(tab) {
                        var pQp = document.getElementById('pQp');
                        hideAllTabs();
                        addClassName(pQp, tab, true);
                }

                function hideAllTabs() {
                        var pQp = document.getElementById('pQp');
                        removeClassName(pQp, 'console');
                        removeClassName(pQp, 'speed');
                        removeClassName(pQp, 'queries');
                        removeClassName(pQp, 'memory');
                        removeClassName(pQp, 'files');
                }

                function toggleDetails(){
                        var container = document.getElementById('pqp-container');

                        if(PQP_DETAILS){
                                addClassName(container, 'hideDetails', true);
                                PQP_DETAILS = false;
                        }
                        else{
                                removeClassName(container, 'hideDetails');
                                PQP_DETAILS = true;
                        }
                }
                function toggleHeight(){
                        var container = document.getElementById('pqp-container');

                        if(PQP_HEIGHT == 'short'){
                                addClassName(container, 'tallDetails', true);
                                PQP_HEIGHT = 'tall';
                        }
                        else{
                                removeClassName(container, 'tallDetails');
                                PQP_HEIGHT = 'short';
                        }
                }

                function loadCSS() {
                        var sheet = document.createElement('link');
                        sheet.setAttribute('rel', 'stylesheet');
                        sheet.setAttribute('type', 'text/css');
                        sheet.setAttribute('href', '$cssUrl');
                        document.getElementsByTagName('head')[0].appendChild(sheet);
                        //setTimeout(function(){document.getElementById('pqp-container').style.display = 'block'}, 10);
                }

                function addClassName(objElement, strClass, blnMayAlreadyExist){
                   if ( objElement.className ){
                      var arrList = objElement.className.split(' ');
                      if ( blnMayAlreadyExist ){
                         var strClassUpper = strClass.toUpperCase();
                         for ( var i = 0; i < arrList.length; i++ ){
                            if ( arrList[i].toUpperCase() == strClassUpper ){
                               arrList.splice(i, 1);
                               i--;
                             }
                           }
                      }
                      arrList[arrList.length] = strClass;
                      objElement.className = arrList.join(' ');
                   }
                   else{
                      objElement.className = strClass;
                      }
                }

                function removeClassName(objElement, strClass){
                   if ( objElement.className ){
                      var arrList = objElement.className.split(' ');
                      var strClassUpper = strClass.toUpperCase();
                      for ( var i = 0; i < arrList.length; i++ ){
                         if ( arrList[i].toUpperCase() == strClassUpper ){
                            arrList.splice(i, 1);
                            i--;
                         }
                      }
                      objElement.className = arrList.join(' ');
                   }
                }


                function addEvent( obj, type, fn ) {
                  if ( obj.attachEvent ) {
                    obj['e'+type+fn] = fn;
                    obj[type+fn] = function() { obj['e'+type+fn]( window.event ) };
                    obj.attachEvent('on'+type, obj[type+fn] );
                  }
                  else{
                    obj.addEventListener( type, fn, false );
                  }
                }
        </script>";

        echo '<div id="pqp-container" class="pQp" style="display:none;position:fixed;bottom:0px;">';

        $logCount = count($this->output['logs']['console']);
        $fileCount = count($this->output['files']);
        $memoryUsed = $this->output['memoryTotals']['used'];
        $queryCount = $this->output['queryTotals']['count'];
        $speedTotal = $this->output['speedTotals']['total'];
        $porcentaje=($memoryUsed*1024*100);
        $porcentaje2=ini_get("memory_limit")*1024;
        $porcentajes=number_format($porcentaje/$porcentaje2,2,',','.');
        echo <<<PQPTABS
        <div id="pQp" class="console">
        <table id="pqp-metrics" cellspacing="0">
        <tr>
                <td class="green" onclick="changeTab('console');">
                        <var>$logCount</var>
                        <h4>Consola</h4>
                </td>
                <td class="blue" onclick="changeTab('speed');">
                        <var>$speedTotal</var>
                        <h4>Tiempo de Carga</h4>
                </td>
                <td class="purple" onclick="changeTab('queries');">
                        <var>$queryCount Queries</var>
                        <h4>Base de Datos</h4>
                </td>
                <td class="orange" onclick="changeTab('memory');">
                        <var>$memoryUsed </var>
                        <h4>$porcentajes% de Memoria</h4>
                </td>
                <td class="red" onclick="changeTab('files');">
                        <var>{$fileCount} Archivos</var>
                        <h4>Adjuntos</h4>
                </td>
        </tr>
        </table>
PQPTABS;

        echo '<div id="pqp-console" class="pqp-box">';

        if($logCount ==  0) {
                echo '<h3>Este grupo no tiene registro.</h3>';
        }
        else {
                echo '<table class="side" cellspacing="0">
                        <tr>
                                <td class="alt1"><var>'.$this->output['logs']['logCount'].'</var><h4>Logs</h4></td>
                                <td class="alt2"><var>'.$this->output['logs']['errorCount'].'</var> <h4>Errores</h4></td>
                        </tr>
                        <tr>
                                <td class="alt3"><var>'.$this->output['logs']['memoryCount'].'</var> <h4>Memoria</h4></td>
                                <td class="alt4"><var>'.$this->output['logs']['speedCount'].'</var> <h4>Velocidad</h4></td>
                        </tr>
                        </table>
                        <table class="main" cellspacing="0">';

                        $class = '';
                        foreach($this->output['logs']['console'] as $log) {
                                echo '<tr class="log-'.$log['type'].'">
                                        <td class="type">'.$log['type'].'</td>
                                        <td class="'.$class.'">';
                                if($log['type'] == 'log') {
                                        echo '<div><pre>'.$log['data'].'</pre></div>';
                                }
                                elseif($log['type'] == 'memory') {
                                        echo '<div><pre>'.$log['data'].'</pre> <em>'.$log['dataType'].'</em>: '.$log['name'].' </div>';
                                }
                                elseif($log['type'] == 'speed') {
                                        echo '<div><pre>'.$log['data'].'</pre> <em>'.$log['name'].'</em></div>';
                                }
                                elseif($log['type'] == 'error') {
                                        echo '<div><em>Line '.$log['line'].'</em> : '.$log['data'].' <pre>'.$log['file'].'</pre></div>';
                                }
                                echo '</td></tr>';
                                if($class == '') $class = 'alt';
                                else $class = '';
                        }

                        echo '</table>';
        }

        echo '</div>';

        echo '<div id="pqp-speed" class="pqp-box">';

        if($this->output['logs']['speedCount'] ==  0) {
                echo '<h3>Este grupo no tiene registro.</h3>';
        }
        else {
                echo '<table class="side" cellspacing="0">
                          <tr><td><var>'.$this->output['speedTotals']['total'].'</var><h4>Load Time</h4></td></tr>
                          <tr><td class="alt"><var>'.$this->output['speedTotals']['allowed'].'</var> <h4>Max. Tiempo de Ejecución</h4></td></tr>
                         </table>
                        <table class="main" cellspacing="0">';

                        $class = '';
                        foreach($this->output['logs']['console'] as $log) {
                                if($log['type'] == 'speed') {
                                        echo '<tr class="log-'.$log['type'].'">
                                        <td class="'.$class.'">';
                                        echo '<div><pre>'.$log['data'].'</pre> <em>'.$log['name'].'</em></div>';
                                        echo '</td></tr>';
                                        if($class == '') $class = 'alt';
                                        else $class = '';
                                }
                        }

                        echo '</table>';
        }

        echo '</div>';

        echo '<div id="pqp-queries" class="pqp-box">';

        if($this->output['queryTotals']['count'] ==  0) {
                echo '<h3>Este grupo no tiene registro.</h3>';
        }
        else {
                echo '<table class="side" cellspacing="0">
                          <tr><td><var>'.$this->output['queryTotals']['count'].'</var><h4>Total de Queries</h4></td></tr>
                          <tr><td class="alt"><var>'.$this->output['queryTotals']['time'].'</var> <h4>Tiempo Total</h4></td></tr>
                          <tr><td><var>0</var> <h4>Duplicados</h4></td></tr>
                         </table>
                        <table class="main" cellspacing="0">';

                        $class = '';
                        foreach($this->output['queries'] as $query){
                                if($query['error']=='Si'){
                                    $color='red';
                                }else{
                                    $color='';
                                }
                                echo '<tr>
                                        <td class="'.$class.'" style="background-color:'.$color.'">'.$query['sql'];
                                            echo '<em>
                                                        Archivo: <b>'.$query['file'].'</b> &middot;
                                                        Linea: <b>'.$query['line'].'</b> &middot;
                                                        Error:  <b>'.$query['error'].'</b>
                                                        Fetch:  <b>'.$query['fetch'].'</b>
                                                </em>';
                                if($query['explain']) {
                                                echo '<em>
                                                        Possible keys: <b>'.$query['explain']['possible_keys'].'</b> &middot;
                                                        Key Used: <b>'.$query['explain']['key'].'</b> &middot;
                                                        Type: <b>'.$query['explain']['type'].'</b> &middot;
                                                        Rows: <b>'.$query['explain']['rows'].'</b> &middot;
                                                        Speed: <b>'.$query['time'].'</b>
                                                </em>';
                                }
                                echo '</td></tr>';
                                if($class == '') $class = 'alt';
                                else $class = '';
                        }

                        echo '</table>';
        }

        echo '</div>';

        echo '<div id="pqp-memory" class="pqp-box">';
        if($this->output['logs']['memoryCount'] ==  0) {
                echo '<h3>Este grupo no tiene registro.</h3>';
        }
        else {
                echo '<table class="side" cellspacing="0">
                          <tr><td><var>'.$this->output['memoryTotals']['used'].'</var><h4>Used Memory</h4></td></tr>
                          <tr><td class="alt"><var>'.$this->output['memoryTotals']['total'].'</var> <h4>Total Available</h4></td></tr>
                         </table>
                        <table class="main" cellspacing="0">';

                        $class = '';
                        foreach($this->output['logs']['console'] as $log) {
                                if($log['type'] == 'memory') {
                                        echo '<tr class="log-'.$log['type'].'">';
                                        echo '<td class="'.$class.'"><b>'.$log['data'].'</b> <em>'.$log['dataType'].'</em>: '.$log['name'].'</td>';
                                        echo '</tr>';
                                        if($class == '') $class = 'alt';
                                        else $class = '';
                                }
                        }

                        echo '</table>';
        }

        echo '</div>';

        echo '<div id="pqp-files" class="pqp-box">';

        if($this->output['fileTotals']['count'] ==  0) {
                echo '<h3>Este grupo no tiene registro.</h3>';
        }
        else {
                echo '<table class="side" cellspacing="0">
                                <tr><td><var>'.$this->output['fileTotals']['count'].'</var><h4>Total de archivos</h4></td></tr>
                                <tr><td class="alt"><var>'.$this->output['fileTotals']['size'].'</var> <h4>Tamaño total</h4></td></tr>
                                <tr><td><var>'.$this->output['fileTotals']['largest'].'</var> <h4>Largest</h4></td></tr>
                         </table>
                        <table class="main" cellspacing="0">';

                        $class ='';
                        foreach($this->output['files'] as $file) {
                                echo '<tr><td class="'.$class.'"><b>'.$file['size'].'</b> '.$file['name'].'</td></tr>';
                                if($class == '') $class = 'alt';
                                else $class = '';
                        }

                        echo '</table>';
        }

        echo '</div>';

        echo '<table id="pqp-footer" cellspacing="0">
                        <tr>
                                <td class="actions">
                                        <a href="#" style="color:red"   onclick=control_debug();  >Debug Log</a>
                                        <a href="#" onclick="toggleDetails();return false">Details</a>
                                        <a class="heightToggle" href="#" onclick="toggleHeight();return false">Height</a>
                                </td>
                        </tr>
                </table>';

        echo '</div></div>';

        }
	
}

?>