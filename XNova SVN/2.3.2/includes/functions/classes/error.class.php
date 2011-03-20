<?php

 //version 1
  
  class error extends filters
  {
  	
  	var $errors = array();
  	
  	protected  function addError ($errormsg)
  	{
  	
  	  $this->errors[] = $errormsg;
  	
  	} //addError
  	
  	protected  function displayError ()
  	{

          $iheight     = count($this->errors) * 20 + 10;
          $iheight     = ($iheight < 130) ? 130 : $iheight;

          $image       = imagecreate(600, $iheight);

          $errorsign   = imagecreatefromjpeg('./gfx/errorsign.jpg');
          imagecopy($image, $errorsign, 1, 1, 1, 1, 180, 120);

          $bgcolor     = imagecolorallocate($image, 255, 255, 255);

          $stringcolor = imagecolorallocate($image, 0, 0, 0);

          for ($i = 0; $i < count($this->errors); $i++)
          {
      
            $imx = ($i == 0) ? $i * 20 + 5 : $i * 20;


            $msg = 'Error[' . $i . ']: ' . $this->errors[$i];

            imagestring($image, 5, 190, $imx, $msg, $stringcolor);
      
  	  }
      
          imagepng($image);

          imagedestroy($image);
  		
  	} //displayError
  	
  	protected function isError ()
  	{
  	
  	  if (count($this->errors) == 0)
  	  {
  	  	
  	  	return FALSE;
  	  	
  	  }
  	  else
  	  {
  	  	
  	  	return TRUE;
  	  	
  	  }
  	
  	} //isError
  	
  } //class: error
  
?>