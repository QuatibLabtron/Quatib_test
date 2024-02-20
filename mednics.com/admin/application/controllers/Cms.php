<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {

	
	public function dashboard()
	{
		
		if($this->session->userdata('prs_id') == '')
		{
			redirect('/login', 'refresh');
			exit;
		}

		$data = array();
	
		$data['title']	= "Dashboard";

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('dashboard',$data);
	}
}
