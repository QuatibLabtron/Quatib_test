<?php

class Form_access extends CI_Controller { 

	public function __construct()
    {
         parent::__construct();
        if($this->session->userdata('prs_id') == '')
		{
			redirect('/login', 'refresh');
			exit;
		}
		if($this->session->userdata('prs_dpt_id') != ADMIN_DEPARTMENT)
		{
			redirect('dashboard', 'refresh');
			exit;
		}
		$this->load->model('form_access_model');
    }
	
	function index()
	{
		$data['global_asset_version']   = global_asset_version();
		$this->load->view('settings/form_access',$data);
	}
	
	function det($USR)
	{
		//$this->home_model->add_usage('','','','');
		//$res=$this->form_access_model->display_class_access($USR);
		
		$res=$this->form_access_model->display_access($USR);
		echo $res;
		
		
	}
	
	function update()
	{
		//$this->home_model->add_usage('','','','');
		$res=$this->form_access_model->change_access();
		$res=$this->form_access_model->display_access($_REQUEST['USR_id']);
		echo $res."@".$_REQUEST['mod'];;
	}
}
?>