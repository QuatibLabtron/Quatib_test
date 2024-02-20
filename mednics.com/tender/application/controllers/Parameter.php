<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	controller name always in small latter,
*/
class Parameter extends CI_Controller {

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
    }
	
	function index()
	{
		$data['title']					= "General Parameters";
		$data['global_asset_version']   = global_asset_version();
		$this->load->view('settings/parameter_list',$data);
	}
  
	function gen_parameter()
	{
		$data['title']					= "General Parameters";
		$data['post']					= $this->home_model->getParameterList();
		$data['gen_group']				= $this->input->post('gen_group');
   		$data['global_asset_version']   = global_asset_version();
		$this->load->view('settings/parameter_result',$data);
	}
	public function editparam()
	{
		$sql="SELECT gen_id,gen_name,gen_value,gen_group,gen_order,status,gen_crdt_dt
			  FROM `tender_gen_prm` where gen_id=".$this->input->post('gen_id')."";
		$result=$this->db->query($sql);
		foreach ($result->result() as $row)
		{
		  foreach($row as $kk => $vv)
		  {
			echo $vv."##";
		  }
		}
	}
	
	public function paraminserts()
	{  
   
		if($this->input->post('gen_id') ==""){

			$value    	= $this->home_model->get_value_no( $this->input->post('gen_group'));
 
	      	$arrData = array(
		        'gen_name'    => $this->input->post('gen_name'),
		        'gen_value'   => $value,
		        'gen_group'   => $this->input->post('gen_group'),
		        'gen_order'   => $this->input->post('gen_order'),
		        'status'  => '1',
		        'gen_crdt_dt' => date('Y-m-d H:i:s')
		         );

	      	$gen_id =  insert('tender_gen_prm', $arrData);

			echo json_encode(array("success"=>true,"message"=>"Save Successfully","linkn"=>base_url().'parameter-list'));
		}		
		else{

			 $arrData = array(
		        'gen_name'    => $this->input->post('gen_name'),
		        'gen_group'   => $this->input->post('gen_group'),
		        'gen_order'   => $this->input->post('gen_order'),
		        'status'  => '1' );

		      update('gen_id', $this->input->post('gen_id'), $arrData, 'tender_gen_prm');

			echo json_encode(array("success"=>true,"message"=>"Update Successfully","linkn"=>base_url().'parameter-list'));
		}
	}

	public function addNewCategory()
	{

		$data=$this->parameter_model->ParameterInsert();
		echo json_encode(array("success"=>true,"message"=>"Save Successfully"));
	}
	
    public function delete()
	{
		$gen_id = $this->input->post('gen_id');
		
		if($gen_id == "")
		{
			echo json_encode(array("success"=>false,"message"=>"Some Error Accurs"));
		}
		else
		{
			$arrData = array('status'  => 1);
      		update('gen_id', $gen_id, $arrData, 'tender_gen_prm');
			echo json_encode(array("success"=>true,"message"=>"Data Delete Successfully"));
		}
    
	}

	public function business_parameter_list()
	{
	   	$data['title']					= "Business Parameters";
	   	$data['global_asset_version']   =  global_asset_version();
	    $data['business_parameter']		=  list_data('*', 'tender_bsn_prm');
	   
	    $this->load->view('settings/business_parameter_list',$data);
	}
	    
	public function businessParameter_update()
	{
		$arrData = array('bpm_value'  => $this->input->post('bpm_value') );
		$check 	 = update('bpm_id', $this->input->post('bpm_id'), $arrData, 'tender_bsn_prm');

      	if($check != '')
      	{
        	$response = array('success' => True, 'message'=>'', 'linkn'=>base_url('business-parameter'));
         	echo json_encode($response);
      	}
      	else
      	{
        	$response = array('success' => false, 'message'=>'');
         	echo json_encode($response);
      	}
	}
    
}