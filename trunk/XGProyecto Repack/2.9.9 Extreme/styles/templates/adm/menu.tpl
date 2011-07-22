<head>

<title>Administração</title>
	
<meta name="title" content="CSS/JavaScript Cascading Menu" />
<meta name="author" content="Programmer Central" />

<meta http-equiv="Content-Type" content="text/html; charset='UTF-8'" />
<img src="../styles/images/xgp-logo.png"/>
<script type="text/javascript">
(function()
{
  if (window.addEventListener)
  {
    window.addEventListener("load", setup_menu, false);    
  }
  else
  {
    window.attachEvent("onload", setup_menu);
  }
})();

function setup_menu()
{
  var elems = document.getElementById("menu").getElementsByTagName("h4");
  
  for (var i = 0; i < elems.length; i++)
  {    	  
    setup_link(elems[i]);
  }
}

function setup_link(elem)
{
  var parts = elem.id.split("_");
  
  if (parts.length > 0)
  {	  
    document.getElementById(elem.id).onclick = function(){show_or_hide(parts[0]);};
  }
}

function show_or_hide(e)
{
  var element = document.getElementById(e);
			
  if (element.style.display === 'block')
  {	    
    element.style.display = 'none';
  }
  else
  {	    
    element.style.display = 'block';
  }		
}
</script>

<style type="text/css">
.menu
{
  width: 75%;    
}

.menu div
{    
  margin: 3px;
  text-align: center;    
  border: 1px solid black;
  display: none;
  width: 100%;
}

.menu div p
{
  margin: 2px;
}

.title
{
  width: 100%;
  line-height: 35px;    
  margin: 3px;
  text-align: center;    
  border: 1px solid black;
  cursor: pointer;
}
</style>

</head>

<body>

<div class="menu" id="menu">
  <h4 class="title" id="option1_link">General</h4>
  <div id="option1">
    <p>{ConfigTable}</p>
  </div>
	
  <h4 class="title" id="option2_link">Observation</h4>
  <div id="option2">
    <p>{ViewTable}</p>
  </div>
	
  <h4 class="title" id="option3_link">Edit Menu</h4>
  <div id="option3">
    <p>{EditTable}</p>
  </div>
	
  <h4 class="title" id="option4_link">Tools</h4>
  <div id="option4">
    <p>{ToolsTable}</p>
    <tr>
        <th><a href="Loteria-C.php" target="Hauptframe">Loteria</a></th>
    </tr>

  </div>

</div>

</body>