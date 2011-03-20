<?php
//version 2.3
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class proteccion_noob{
    var $prin;
    var $prin_porcent_down  ;
    var $prin_porcent_up    ;

    var $seco;

    var $mission;
    var $vacation;
    var $onlinetime;

    function check_punt(){
        return $var;
    }

    function check_status(){

        if($this->vacation!=0){
            $array["var_lang_fleet"]      = "fl_in_vacation_player";
            $array["var_lang_galax"]      = "gl_v";

            $array["var_status"]    = true;
            
        }else{
            $array["var_status"]    = false;
        }
        
        return $array;
    }

    public function check(){

        $this->prin_porcent_down  = $this->prin*   .2;
        $this->prin_porcent_up    = $this->prin*    5;
        
        if($this->prin>100 && $this->seco>100){
            $status=$this->check_status();
            if($this->mission==1 || $this->mission==2 || $this->mission==6 || $this->mission==9 || $this->mission==10){
                if($status["var_status"]){
                    //fl_in_vacation_player
                    $return["lang_f"]     =$status["var_lang_fleet"];"El contrario esta en modo vacaciones.";
                    $return["lang_g"]     =$status["var_lang_galax"];
                    $return["status"]     =true;
                }elseif($this->prin_porcent_down>$this->seco){
                    //DEBIL
                    //fl_week_player
                    $return["lang_f"]     ="fl_week_player";//"El contrario es demasiado debil";
                    $return["lang_g"]     ="gl_w";

                    $return["status"]   =true;//"El contrario es demasiado debil";

                }elseif($this->prin_porcent_up<$this->seco){
                    //FUERTE
                    //fl_strong_player
                    $return["lang_f"]     ="fl_strong_player";//"El contrario es demasiado fuerte";
                    $return["lang_g"]     ="gl_s";

                    $return["status"]     =true;
                }else{
                    //$return="PUEDES ATACAR";
                    $return["status"]     =false;
                }
            }else{
                //$return="PUEDES HACERLO";
                $return["status"]         =false;
            }
        }else{
            //ESTAS PROTEGIDO xD
            $return["lang_f"]     ="fl_week_player";//Tu puntuacion o la del contrario no supera los 100";
            $return["lang_g"]     ="gl_w";
                    
            $return["status"]   =true;
        }

        return $return;

        
    }


}

?>
