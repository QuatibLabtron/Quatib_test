<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Crm_auth
{
	private $user_data;
	private $agent_data;
	private $breadcrumb;
	private $user_sub_arr;
	public  $CI;
	public function __construct()
	{
		$this->CI 			= &get_instance();
		$this->breadcrumb 	= array();
		$this->agent_data 	= array();
	}
	
	function base64url_encode($data) { 
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	} 

	function base64url_decode($data) { 
	  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
	} 
	
	function encrypt_openssl($string) 
	{
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = URL_ENCRYPT_KEY; 
		$secret_iv 	= URL_ENCRYPT_IV;
		// hash
	   $key = hash('sha256', $secret_key);
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	   $iv = substr(hash('sha256', $secret_iv), 0, 16);
		
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = $this->base64url_encode($output);
		
		return $output;
	}
	
	function decrypt_openssl($string) {
		
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$secret_key = URL_ENCRYPT_KEY;
		$secret_iv = URL_ENCRYPT_IV;
		// hash
		$key = hash('sha256', $secret_key);
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		
		$string1 = $this->base64url_decode($string);
		$output = openssl_decrypt($string1, $encrypt_method, $key, 0, $iv);
			
		return $output;
	}

	function ci_breadcrumbs($breadcrumb_array)
    {
        $crumb_html =               ' <ul class="page-breadcrumb">';
        for($i = 0; $i < count($breadcrumb_array); $i++)
        {
            if(array_key_exists(1, $breadcrumb_array[$i]))
                $crumb_html .=  '<li><a href="'.$breadcrumb_array[$i][1].'">'.$breadcrumb_array[$i][0].'</a> <i class="fa fa-circle"></i> </li>  ';
            else
                $crumb_html .=  ' <li><span>'.$breadcrumb_array[$i][0].'</span> </li>';
        }
       $crumb_html .=  '</ul>';
       return $crumb_html;
    }

	function push_breadcrumb($name, $url = '#', $append = TRUE)
	{
		$entry = array('name' => $name, 'url' => $url);
		if ($append)
			$this->breadcrumb[] = $entry;
		else
			array_unshift($this->breadcrumb, $entry);
	}

	function get_breadcrumb()
	{
		return $this->breadcrumb;   
	}

	function sendEmail($arrEmailData = array())
	{
		$email_from_addr		= isset($arrEmailData['admin_email_from'])?$arrEmailData['admin_email_from']:$this->CI->config->item('admin_email_from');
		$email_from_name		= isset($arrEmailData['admin_from_name'])?$arrEmailData['admin_from_name']:$this->CI->config->item('admin_from_name');
		
		
		$email_message			= $arrEmailData['email_content'];
		$email_template			= $arrEmailData['email_template'];
		$email_template_data	= $arrEmailData['email_template_data'];
		$subject				= $arrEmailData['email_subject'];
	
		//Find and replace values in email
		$find 					= array("#NAME#", "#EMAIL#", "#COMPANYNAME#");
		$replace    			= array($arrEmailData['name'], $arrEmailData['email'], $this->CI->config->item('admin_from_name'));
		$email_message_string 	= str_replace($find, $replace, $email_message);
		$email					= $arrEmailData['email'];
		$cc_email				= '';
		
		$bcc_email				= $arrEmailData['email_bcc'];
		if(isset($arrEmailData['email_bcc']) && empty($arrEmailData['email_bcc']))
		{
			$bcc_email				= '';
		}
		if(isset($arrEmailData['email_cc']) && !empty($arrEmailData['email_cc']))
		{
			$cc_email				= $arrEmailData['email_cc'];
		}
			$smtp_user				= $this->CI->config->item('mail_smtp_user');
			$smtp_pass				= $this->CI->config->item('mail_smtp_pass');
			$smtp_host				= ($arrEmailData['smtp_host'])?$arrEmailData['smtp_host']:$this->CI->config->item('mail_smtp_host');
			$smtp_port				= ($arrEmailData['smtp_port'])?$arrEmailData['smtp_port']:$this->CI->config->item('mail_smtp_port');
		
		if(isset($arrEmailData['smtp_user']) && !empty($arrEmailData['smtp_user']))
		{
			$smtp_user				= $arrEmailData['smtp_user'];
		}
		if(isset($arrEmailData['smtp_pass']) && !empty($arrEmailData['smtp_pass']))
		{
			$smtp_pass				= $arrEmailData['smtp_pass'];
		}
	
		
		if(!empty($email))
		{	
			if(is_array($email))
			{
				$member_email 			= $email;
			}
			else
			{
				$member_email 			= array($email);
			}
			
			if($this->CI->config->item('mail_is_smtp'))
			{
				$email_config 	= array(
								  'protocol' 	=> 'smtp',
								  'smtp_host' 	=> $smtp_host,
								  'smtp_user' 	=> $smtp_user,
								  'smtp_pass' 	=> $smtp_pass,
								  'smtp_port' 	=> $smtp_port,
								  //'smtp_crypto'	=> 'tls',
								   //'smtp_keepalive' => TRUE,
								  'smtp_timeout' =>'120',
								  'mailtype'	=> 'html',
								  'charset'		=> 'utf-8',
								  'crlf' 		=> "\r\n",
								  'newline' 	=> "\r\n"
								);	
			}
			else
			{
				$email_config 	= array(
								  'protocol' 	=> 'mail',
								  'smtp_port' 	=> $this->CI->config->item('mail_smtp_port'),
								  'smtp_crypto'	=> '',
								  'smtp_keepalive' => TRUE,
								  'smtp_timeout' =>'120',
								  'mailtype'	=> 'html',
								  'charset'		=> 'utf-8',
								  'crlf' 		=> "\r\n",
								  'newline' 	=> "\r\n"
								);	
			}
			
			$this->CI->load->library('email');
			$this->CI->email->initialize($email_config);
			$this->CI->email->clear(TRUE);  
			$this->CI->email->set_mailtype('html');		
			$this->CI->email->set_newline("\r\n");
			$this->CI->email->from($email_from_addr,$email_from_name);  
			$this->CI->email->to($member_email); 
			//cc_email
			if(isset($cc_email) && !empty($cc_email))
			{
				$this->CI->email->cc($cc_email);
			}
			
			//bcc_email
			if(isset($bcc_email) && !empty($bcc_email))
			{
				$this->CI->email->bcc($bcc_email);
			}
			
			if(isset($arrEmailData['attachment']) && !empty($arrEmailData['attachment']))
			{
				$this->CI->email->attach($arrEmailData['attachment']); 
			}
			if(isset($arrEmailData['attachment_flg']) && $arrEmailData['attachment_flg'] == YES)
			{
				foreach ($arrEmailData['attachment_array'] as $key => $value) 
				{
					$this->CI->email->attach($value); 
				}
			}
			$this->CI->email->subject($subject);
			if(!empty($email_template))
			{
				$data['emailData'] = $email_template_data;
				$email_message_string = $this->CI->load->view('./emailtemplate/'.$email_template, $data , true);
			}
			
			$this->CI->email->message($email_message_string);  
			$this->CI->email->send();
			/*print_r($this->CI->email->print_debugger());
			exit;*/
			
		}
	}
}
?>