<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entities extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
    
		if($this->session->userdata('prs_id') == '')
		{
			redirect('/login', 'refresh');
			exit;
		}
    }
	
	public function index()
	{
		$this->entitiesList();
	}
	
	public function entitiesList()
	{

		$data['title']					= "Entities";

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 		= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 		= array('Entities');
		$data['breadcrumb']        		= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['dataTableData'] 			= $this->home_model->get_entities(TABLE_COUNT);

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('excel/entities/entities_list',$data);
	}

	public function entitiesDataTablelist()
	{
		$dataOptn = $this->input->get();
	    $dataTableData = $this->home_model->get_entities(TABLE_RESULT,$dataOptn);
	      // ******** Encrypt Data from multidimensional array ******//
	    $enc_arr['id']    			= 'id_encrypt';

	    $dataTableArray['data'] 	= encrypt_key_in_array($dataTableData,$enc_arr);
	      // ******** Encrypt Data from multidimensional array ******//
	    if(isset($dataOptn['columns']))
	        {
	           // *********** Get Data Count **********//
	              $dataTableArray['draw']             = $dataOptn['draw'];
	              $dataTableArray['recordsTotal']     = $dataOptn['table_data_count'];
	              $dataTableArray['recordsFiltered']  = $dataOptn['table_data_count'];
	          // *********** Get Data Count **********//
	      	}
	    echo json_encode($dataTableArray);
	}
	
	public function add_entities()
	{
		
		$data = array();
		$validation_config = array(
				  array(
                     'field'   => 'name', 
                     'label'   => 'Entities name', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title								= 'Add Entities';
		$data['ctrler']						= 'entities';
		$data['title']						= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Entities', base_url('entities'));
		$data['breadcrumb_data'][] 			= array('Add Entities');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']			= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('excel/entities/add_entities',$data);
		}
		else
		{
		
			
			$arrAccountData['name'] 			 = trim($this->input->post('name'));
			$arrAccountData['display_name'] 	 = trim($this->input->post('display_name'));
			$arrAccountData['order'] 		 	 = trim($this->input->post('order'));
			$arrAccountData['use_excels'] 	 	 = trim($this->input->post('use_excels'));
			$arrAccountData['excel_identifier'] 	 = trim($this->input->post('excel_identifier'));
			$arrAccountData['function_after_add'] 	 = trim($this->input->post('function_after_add'));
			$arrAccountData['function_after_edit'] 	 = trim($this->input->post('function_after_edit'));
			$arrAccountData['function_after_delete'] = trim($this->input->post('function_after_delete'));
			$arrAccountData['views'] 			 	 = trim($this->input->post('views'));
			$arrAccountData['columns_attributes'] 	 = trim($this->input->post('columns_attributes'));
         
			$arrAccountData['status'] 			= STATUS_ACTIVE;
			$arrAccountData['created_by'] 			= $this->session->userdata('prs_id');
			$arrAccountData['updated_by'] 			= $this->session->userdata('prs_id');
			$arrAccountData['created_dt'] 			= date('Y-m-d H:i:s');
			$arrAccountData['updated_dt'] 			= date('Y-m-d H:i:s');

			$entities_id	= insert('adm_et_entities',$arrAccountData);
			
			$entities_id = $this->crm_auth->encrypt_openssl($entities_id);
			$this->session->set_flashdata('success', 'Entities added successfully');
			redirect(site_url('entities-detail-'.$entities_id));
			exit;
		}
	}
	
	public function edit_entities($entities_id = '')
	{
		
		$entities_id = $this->crm_auth->decrypt_openssl($entities_id);
		$data = array();

		$validation_config = array(
				  array(
                     'field'   => 'name', 
                     'label'   => 'Entities name', 
                     'rules'   => 'trim|required'
                  )
            );
		$this->form_validation->set_rules($validation_config);
		
	
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		$data['scontent']['entities_id'] 	= $entities_id;
		$data['entities'] 					= $this->home_model->getentitiesDataByID($data['scontent']);
		$data['entities_id'] 				= $entities_id;
		$eentities_id 						= $this->crm_auth->encrypt_openssl($entities_id);
		
		
		// automatically push current page to last record of breadcrumb
		$title						= 'Edit Entities';
		$data['ctrler']				= 'entities';
		$data['title']				= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('Entities', base_url('entities'));
		$data['breadcrumb_data'][] 	= array($data['entities']['name'].' Details', base_url('entities-detail-'.$eentities_id));
		$data['breadcrumb_data'][] 	= array('Edit Entities');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('excel/entities/edit_entities',$data);
		}
		else
		{
			$entities_id 						 = $this->input->post('id');
			$arrAccountData['name'] 			 = trim($this->input->post('name'));
			$arrAccountData['display_name'] 	 = trim($this->input->post('display_name'));
			$arrAccountData['order'] 		 	 = trim($this->input->post('order'));
			$arrAccountData['use_excels'] 	 	 = trim($this->input->post('use_excels'));
			$arrAccountData['excel_identifier']  = trim($this->input->post('excel_identifier'));
			$arrAccountData['function_after_add'] 	 = trim($this->input->post('function_after_add'));
			$arrAccountData['function_after_edit'] 	 = trim($this->input->post('function_after_edit'));
			$arrAccountData['function_after_delete'] = trim($this->input->post('function_after_delete'));
			$arrAccountData['views'] 			 	 = trim($this->input->post('views'));
			$arrAccountData['columns_attributes'] 	 = trim($this->input->post('columns_attributes'));

			$arrAccountData['status'] 			 = STATUS_ACTIVE;
			$arrAccountData['updated_by'] 			 = $this->session->userdata('prs_id');
			$arrAccountData['updated_dt'] 			 = date('Y-m-d H:i:s');
			
			update('id', $entities_id, $arrAccountData, 'adm_et_entities');
		
			$entities_id = $this->crm_auth->encrypt_openssl($entities_id);
			
			echo json_encode(array('success'=>true,"message"=>"Entities updated successfully","linkn"=>base_url()."entities-detail-".$entities_id));
		}
	}

	public function entitiesDetail($entities_id = '')
	{		
		$entities_id = $this->crm_auth->decrypt_openssl($entities_id);
		$data = array();
		$data['entities_id']  				= $entities_id;
		$data['entities'] 					= $this->home_model->getentitiesDataByID($data);

		$data['ctrl']  						= "entities";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Entities', base_url('entities'));
		$data['breadcrumb_data'][] 			= array('Entities Detail');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']					= array();
		$data['scontent']['entities_id'] 	= $entities_id;
		$data['title']						= $data['entities']['name'];
		
		$this->load->view('excel/entities/entities_detail',$data);
	}
	
	public function checkentitiesAvailability()
	{   
		$id 			= $this->input->post('id');
		$entities 		= $this->input->post('name');
		$result 		= checkAvailability('name',$entities,'adm_et_entities','id',$id);
		
		if($result){
			$status = $entities." is already taken.Please try another one.";
		}
		else
		{
			$status = true;
		}
		echo json_encode($status);
		exit;	
	}

	public function entities_active()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		     status_to_update($chkId,'id','adm_et_entities',STATUS_ACTIVE);
		}
			$success = true;
			$message = 'Entities Updated successfully';
			$linkn   =  base_url('entities');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function entities_deactive()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		   status_to_update($chkId,'id','adm_et_entities',STATUS_INACTIVE);
		}
			$success = true;
			$message = 'Entities Updated successfully';
			$linkn   =  base_url('entities');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}
	  
}