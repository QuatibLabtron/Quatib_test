<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    class Captchabg extends CI_Controller {



 public function __construct()
        {
                parent::__construct();
				//echo $this->load->view('maintenance','',true);exit;
                $this->load->model('Captchabg_model');
				$this->load->model('Main_model');
			
        }
public function captcha_page(){
	
	$data = common_data();
	
		 if($this->input->post('captcha') === $this->session->userdata('captcha')){
        $data['success'] = "Verified";
    }else{
        $data['success'] = "Not Verified";
    }

	//$this->session->set_userdata('captcha_status')= $success;
	
        $this->load->view('captcha',$data);
	
}
		
  public  function load_captcha_image(){
	  $config=array('width'=>'180','height'=>'30','background'=>'#354b51');
		 $this->load->model('Captchabg_model');	
			//session_start();
			
$captcha = new Captchabg_model(90,50,'#e9c00a','#062039');
//$captcha->captcha_noise(); // Add noise to captcha image
//$captcha->captcha_blur(); // Blur captcha image

echo $captcha->captcha_image();
			
		}
    }


