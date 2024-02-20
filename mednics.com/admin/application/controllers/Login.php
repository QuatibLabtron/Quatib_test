<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();	
	}

	public function loginView()
	{
		$data['title']				= "Login";
		
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$data['ref']= $_SERVER['HTTP_REFERER'];	
		}
		else
		{
			$data['ref']= base_url().'dashboard';
		}

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('login',$data);
	}

	public function checklogin()
	{
		$ref=$this->input->post('ref');
		$rememberme=$this->input->post('rememberme');         
		if(isset($_COOKIE['labtron_usr_username']) and  isset($_COOKIE['labtron_usr_password']))
		{ 
			
			$email = get_cookie('labtron_usr_username');
			$pwd   = get_cookie('labtron_usr_password');

			 $_POST['usr_username'] = $email;
			 $_POST['usr_password'] = $pwd;

			$value='1';  
			log_message('error','>>checklogin - cookie  function check value'.$value );

			log_message('error','>>email'.$_POST['usr_username'] );
			log_message('error','>>password'.$_POST['usr_password'] );
		}
		else
		{
			$value='0';
			log_message('error','>>checklogin - cookie  function check value'.$value ); 

		} 
		$user_data= $this->home_model->getUserData($value);
		if(isset($user_data) || !empty($user_data))
		{
						//Start of Condition to set the coookie in the client browser
			if(!isset($_COOKIE['labtron_usr_username']) and !isset($_COOKIE['labtron_usr_password']))
			{ 
				log_message('error','>>checklogin - set cookie  function ');    
				if($rememberme == 1) 
				{
					log_message('error','>>checklogin - inside set cookie  function ');  
					set_cookie('labtron_usr_username', $user_data->usr_username, 3600*24*30*12*10);
					set_cookie('labtron_usr_password', $user_data->usr_password , 3600*24*30*12*10 );

					log_message('error','>>checklogin - Cookie is Set - Email: '.$user_data->usr_username. ', usr_password: '.$user_data->usr_password);

				}
			}
	                    //End of Condition to set the coookie in the client browser
			$newdata = array(
				   'prs_id' 		=> $user_data->prs_id,
                   'prs_name' 		=> $user_data->prs_name,
				   'prs_email'  	=> $user_data->prs_email,
				   'prs_mob'  		=> $user_data->prs_mob,
				   'prs_status' 	=> $user_data->status,
				   'usr_ref'  		=> $user_data->prs_username,
				   'prs_dpt_id' 	=> $user_data->prs_dpt_id,
				   'is_logged_in'	=> TRUE );
				
			$this->session->set_userdata($newdata);

			$pos = strrpos($ref, '/');
			$last = $pos === false ? $ref : substr($ref, $pos + 1);
			if($last==base_url() || $last=='logout')
			{
				$ref=base_url().'dashboard';
			}
			

			if(isset($_COOKIE['labtron_usr_username']) and  isset($_COOKIE['labtron_usr_password']))
			{
				log_message('error','>>checklogin - cookie  function return true' );       
				echo json_encode(array("success"=>true,"message"=>'Login Sucess' ,'linkn'=>$ref));
				exit;
			} 
			else
			{	
				log_message('error','>>checklogin - cookie  function jsoncode' );
				echo json_encode(array("success"=>true,"message"=>'Login Sucess' ,"email"=>base64_encode($user_data->prs_email),'linkn'=>base_url().'dashboard'));
				exit;
			}
		}else{
			if(isset($_COOKIE['labtron_usr_username']) and  isset($_COOKIE['labtron_usr_password']))
			{
				return false;
				exit;
			} 
			else
			{
				echo json_encode(array('success'=>false,'message'=>'Email or password not match.'));
				exit;
			}
		}
	}
	
	public function logout()
	{
		$newdata = array(
		   'prs_id'			=> '',
		   'prs_name'  		=> '',
		   'prs_email'  	=> '',
		   'prs_mob'  		=> '',
		   'prs_status' 	=> '',
		   'usr_ref'  		=> '',
		   'prs_dpt_id'		=> '',
		   'is_logged_in' 	=> TRUE );

		$this->session->unset_userdata($newdata);

		$this->session->sess_destroy();

		//unset cookie on 'logout controller'

		delete_cookie('labtron_usr_username');
		delete_cookie('labtron_usr_password'); 

	    redirect('','refresh'); 
	}
	public function googleAuth(){
        $data['title']				= "Google Authentication";
        $data['check'] = $this->home_model->checkGoogleSecretKey(base64_decode($this->input->get("value")));
        $pdata = $this->input->post();
        $code=$this->input->post('code');
        if(isset($code)){
            $this->checkAuthentication($pdata);
        }
        $this->load->view('googleAuth',$data);
    }
    public function checkAuthentication($pdata){
        $email = $pdata['email'];
        $code = $pdata['code'];
        $this->load->library('GoogAuth');
        $ga = new GoogAuth();
        $secret_key = $this->home_model->getGoogleSecretKey($email);
        $checkResult = $ga->verifyCode($secret_key, $code, 2);
        
         if ($checkResult) {
             $user_data= $this->home_model->getUserAuthData($email);
             //print_r($user_data);exit;
             $newdata = array(
				   'prs_id' 		=> $user_data->prs_id,
                   'prs_name' 		=> $user_data->prs_name,
				   'prs_email'  	=> $user_data->prs_email,
				   'prs_mob'  		=> $user_data->prs_mob,
				  //'status'     	=> $user_data->status,
				   'usr_ref'  		=> $user_data->prs_username,
				   'prs_dpt_id' 	=> $user_data->prs_dpt_id,
				   'is_logged_in'	=> TRUE );
			 $this->session->set_userdata($newdata);
             redirect(base_url('dashboard')); 
         }
        else{
            $this->session->set_flashdata('login_error', '<i class="fa fa-exclamation-triangle"></i> Incorrect code submitted, Enter Correct Code.');
			redirect(base_url('googleAuth?value='.base64_encode($email))); 
        }
    }
	
}

?>
