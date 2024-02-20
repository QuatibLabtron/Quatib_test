<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Captchabg_model extends CI_Model {

        private $image;
        private $color;
        public $width;
        public $height;

      public  function __construct($width = 120,$height = 60,$background = "#4F5B93",$color = "#ffffff"){
           
          parent::__construct();
		   
            // Create captcha image, Set height & width, text color when object is initialized
            $this->image = imagecreatetruecolor($width, $height);
            $this->width = intval($width);
            $this->height = intval($height);
            $color = $this->decimal_color($color); // Get decimal color value from hex color value
            $this->color = $this->true_color($color); // Set true color from decimal color

            $background = $this->decimal_color($background);
            $background = $this->true_color($background);

            // Fill background color to image
            imagefill($this->image, 0, 0, $background);
        }

        /*****************************************************************
        | Function to add noise to captcha image
        ** @param : (hex) Noise color
        ******************************************************************/
        public function captcha_noise($color = "#8892BF"){
            $font_color = $this->decimal_color($color);
            $font_color = $this->true_color($font_color);

            // Loop x co-ordinates of image
            for($r = 0; $r < $this->width; $r++) {
                // Loop y co-ordinates of image
                for($c = 0; $c < $this->height; $c++) {
                    // Add noise on step of 1 pixel,  skipping one pixel and noise to next pixel
                    if (mt_rand(0,1) == 1)
                        imagesetpixel($this->image, $r, $c, $font_color);
                }
            }
        }

        /*****************************************************************
        | Function to blur captcha image
        * @param : (int) Number of times image should be blurred
        ******************************************************************/
        public function captcha_blur($count = 3){
            $count = intval($count) > 10 ? 10 : $count;
            for($i = 1; $i <= $count; $i++){
                imagefilter($this->image, IMG_FILTER_GAUSSIAN_BLUR);
            }
        }

        /*****************************************************************
        | Function to return created captcha image
        ******************************************************************/
        public function captcha_image(){
            $this->captcha_text();
            ob_start();
            header("Content-Type: image/jpeg");
            imagejpeg($this->image,NULL,100);
            $captcha = ob_get_clean();

            imagedestroy($this->image);
            return $captcha;
        }
        /*****************************************************************
        | Function to blur captcha image
        * @param : (hex) Hexadecimal color value
        ******************************************************************/
        private function decimal_color($color){
            $color = strpos($color, "#") !== FALSE ? substr($color, 1) : $color;

            if(strlen($color) === 6){
                $red = substr($color, 0,2);
                $green = substr($color, 2,2);
                $blue = substr($color, 4,2);
            }else{
                $red = substr($color, 0,1).substr($color, 0,1);
                $green = substr($color, 1,1).substr($color, 1,1);
                $blue = substr($color, 2,1).substr($color, 1,1);
            }
            $red = hexdec($red);
            $green = hexdec($green);
            $blue = hexdec($blue);

            return ["red" => $red, "green" => $green, "blue" => $blue];
        }

        /*****************************************************************
        | Function to convert decimal color to true color
        * @param : (array) Array of decimal color value for red,green,blue
        ******************************************************************/
        private function true_color($color){
            return imagecolorallocate($this->image, $color["red"], $color["green"], $color["blue"]);
        }

        /*****************************************************************
        | Function to generate random string for captcha
        * @param : (int)Length of characters
        ******************************************************************/
        private function random_string($length){
            //$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			 $characters = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $random_string = "";

            for($i = 0; $i < $length; $i++){
                $random_string .= $characters[mt_rand(0,strlen($characters) - 1)];
            }

            return $random_string;
        }

        /*****************************************************************
        | Function to add random string to captcha image
        ******************************************************************/
        private function captcha_text(){
         $font_file = APPPATH.CAPCHA_FONT_PATH.'/monofont.ttf';
		//echo dirname(__FILE__);
		//exit;
		   //realpath(dirname(__FILE__)."/sketch_block.ttf");
		   
            $font_size = $this->height * 0.6;
            $font_color = $this->color;
            $random_string = $this->random_string(3);

            $ttf_box = imagettfbbox($font_size, 0, $font_file, $random_string);
            $xr = abs( max( $ttf_box[2], $ttf_box[4] ) );
            $xy = abs( max( $ttf_box[5], $ttf_box[7] ) );
            $x = ( $this->width - $xr ) / 2;
            $y = ( $this->height + $xy ) / 2;

            imagettftext($this->image, $font_size, 0, $x, $y, $font_color, $font_file, $random_string);
$this->session->set_userdata('captcha', $random_string);
            //$_SESSION["captcha"] = $random_string;

        }
		
		
		
    }


