<?php
//version 1
  require('./includes/functions/classes/filter.class.php');
  require('./includes/functions/classes/error.class.php');

  class captchas extends error
  {
    var $Length;
    var $CaptchaString;
    var $fontpath;
    var $fonts;
    var $seguridad=array("noise"=> 6,
                         "blur" => 2 );


    public function captcha($length = 6)
    {

      header('Content-type: image/png');

      
      $this->Length   = $length;
      
      //$this->fontpath = dirname($_SERVER['SCRIPT_FILENAME']) . '/fonts/';
      $this->fontpath = './styles/fonts/';
      $this->fonts    = $this->getFonts();
      
      if (function_exists('imagettftext') == FALSE)
      {
            $this->addError('');
            $this->displayError();
            die();
      }

      if ($this->fonts == FALSE)
      {
            $this->addError('No fonts available!');
            $this->displayError();
            die();
      }
      $this->stringGen();
      $this->makeCaptcha();
    } 
    
    private function getFonts ()
    {
    
      $fonts = array();
    
      if ($handle = @opendir($this->fontpath))
      {
            while (($file = readdir($handle)) !== FALSE)
            {
                  $extension = strtolower(substr($file, strlen($file) - 3, 3));
                  if ($extension == 'ttf')
                  {
                        $fonts[] = $file;
                  }
            }
            closedir($handle);
      }
      else
      {
            return FALSE;
      }
      
      if (count($fonts) == 0)
      {
            return FALSE;
      }
      else
      {
            return $fonts;
      }
    }
    
    function getRandFont ()
    {
    
      return $this->fontpath . $this->fonts[mt_rand(0, count($this->fonts) - 1)];
    
    } //getRandFont

    function stringGen ()
    {

          $uppercase  = range('A', 'Z');
          //$lowercase  = range('a', 'z');
          $numeric    = range(1, 9);

          $CharPool   = array_merge($uppercase, $numeric);
          $PoolLength = count($CharPool) - 1;

          for ($i = 0; $i < $this->Length; $i++)
          {
                $this->CaptchaString .= $CharPool[mt_rand(0, $PoolLength)];
          }

    } //StringGen

    private function makeCaptcha ()
    {

      $imagelength = $this->Length * 25 + 16;
      $imageheight = 75;

      $image       = imagecreate($imagelength, $imageheight);

      //$bgcolor     = imagecolorallocate($image, 222, 222, 222);
      $bgcolor     = imagecolorallocate($image, 255, 255, 255);

      $stringcolor = imagecolorallocate($image, 0, 0, 0);

      //$filter      = new filters;

      $this->signs($image, $this->getRandFont());

      for ($i = 0; $i < strlen($this->CaptchaString); $i++)
      {
      
        imagettftext($image, 25, mt_rand(-15, 15), $i * 25 + 10,
                     mt_rand(30, 70),
                     $stringcolor,
                     $this->getRandFont(),
                     $this->CaptchaString{$i});
      
      }

      $this->noise($image, $this->seguridad["noise"]);
      $this->blur($image, $this->seguridad["blur"]);

      imagepng($image);
      
      imagedestroy($image);

    } //MakeCaptcha

    public function getCaptchaString ()
    {

      return $this->CaptchaString;

    } //GetCaptchaString
    
  } //class: captcha

?>
