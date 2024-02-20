<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datatypes extends CI_Controller {
	
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
		$this->datatypesList();
	}
	
	public function datatypesList()
	{

		$data['title']					= "Data Types";

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 		= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 		= array('Data Types');
		$data['breadcrumb']        		= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['dataTableData'] 			= $this->home_model->get_datatypes(TABLE_COUNT);

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('excel/datatypes/datatypes_list',$data);
	}

	public function datatypesDataTablelist()
	{
		$dataOptn = $this->input->get();
	    $dataTableData = $this->home_model->get_datatypes(TABLE_RESULT,$dataOptn);
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
	
	public function add_datatypes()
	{
		
		$data = array();
		$validation_config = array(
				  array(
                     'field'   => 'name', 
                     'label'   => 'Data Types name', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title								= 'Add Data Types';
		$data['ctrler']						= 'datatypes';
		$data['title']						= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Data Types', base_url('datatypes'));
		$data['breadcrumb_data'][] 			= array('Add Data Types');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']			= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('excel/datatypes/add_datatypes',$data);
		}
		else
		{
		
			
			$arrAccountData['name'] 			 = trim($this->input->post('name'));
			$arrAccountData['table_column_type'] = trim($this->input->post('table_column_type'));
			$arrAccountData['type'] 		 	 = trim($this->input->post('type'));
			$arrAccountData['lowest_limit'] 	 = trim($this->input->post('lowest_limit'));
			$arrAccountData['highest_limit'] 	 = trim($this->input->post('highest_limit'));
			$arrAccountData['decimal_places'] 	 = trim($this->input->post('decimal_places'));
			$arrAccountData['length'] 			 = trim($this->input->post('length'));
         
			$arrAccountData['status'] 			= STATUS_ACTIVE;
			$arrAccountData['created_by'] 			= $this->session->userdata('prs_id');
			$arrAccountData['updated_by'] 			= $this->session->userdata('prs_id');
			$arrAccountData['created_dt'] 			= date('Y-m-d H:i:s');
			$arrAccountData['updated_dt'] 			= date('Y-m-d H:i:s');

			$datatypes_id	= insert('adm_et_data_types',$arrAccountData);
			
			$datatypes_id = $this->crm_auth->encrypt_openssl($datatypes_id);
			$this->session->set_flashdata('success', 'Data Types added successfully');
			redirect(site_url('datatypes-detail-'.$datatypes_id));
			exit;
		}
	}
	
	public function edit_datatypes($datatypes_id = '')
	{
		
		$datatypes_id = $this->crm_auth->decrypt_openssl($datatypes_id);
		$data = array();

		$validation_config = array(
				  array(
                     'field'   => 'name', 
                     'label'   => 'Data Types name', 
                     'rules'   => 'trim|required'
                  )
            );
		$this->form_validation->set_rules($validation_config);
		
	
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		$data['scontent']['datatypes_id'] 	= $datatypes_id;
		$data['datatypes'] 					= $this->home_model->getdatatypesDataByID($data['scontent']);
		$data['datatypes_id'] 				= $datatypes_id;
		$edatatypes_id 						= $this->crm_auth->encrypt_openssl($datatypes_id);
		
		
		// automatically push current page to last record of breadcrumb
		$title						= 'Edit Data Types';
		$data['ctrler']				= 'datatypes';
		$data['title']				= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('Data Types', base_url('datatypes'));
		$data['breadcrumb_data'][] 	= array($data['datatypes']['name'].' Details', base_url('datatypes-detail-'.$edatatypes_id));
		$data['breadcrumb_data'][] 	= array('Edit Data Types');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('excel/datatypes/edit_datatypes',$data);
		}
		else
		{
			$datatypes_id 						 = $this->input->post('id');
			$arrAccountData['name'] 			 = trim($this->input->post('name'));
			$arrAccountData['table_column_type'] = trim($this->input->post('table_column_type'));
			$arrAccountData['type'] 		 	 = trim($this->input->post('type'));
			$arrAccountData['lowest_limit'] 	 = trim($this->input->post('lowest_limit'));
			$arrAccountData['highest_limit'] 	 = trim($this->input->post('highest_limit'));
			$arrAccountData['decimal_places'] 	 = trim($this->input->post('decimal_places'));
			$arrAccountData['length'] 			 = trim($this->input->post('length'));

			$arrAccountData['status'] 			 = STATUS_ACTIVE;
			$arrAccountData['updated_by'] 			 = $this->session->userdata('prs_id');
			$arrAccountData['updated_dt'] 			 = date('Y-m-d H:i:s');
			
			

			update('id', $datatypes_id, $arrAccountData, 'adm_et_data_types');
			
			$datatypes_id = $this->crm_auth->encrypt_openssl($datatypes_id);
			
			echo json_encode(array('success'=>true,"message"=>"Data Types updated successfully","linkn"=>base_url()."datatypes-detail-".$datatypes_id));
		}
	}

	public function datatypesDetail($datatypes_id = '')
	{
		$datatypes_id 					= $this->crm_auth->decrypt_openssl($datatypes_id);
		$data 							= array();
		$data['datatypes_id']  			= $datatypes_id;
		$data['datatypes'] 				= $this->home_model->getdatatypesDataByID($data);

		$data['ctrl']  						= "datatypes";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Data Types', base_url('datatypes'));
		$data['breadcrumb_data'][] 			= array('Data Types Detail');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']					= array();
		$data['scontent']['datatypes_id'] 	= $datatypes_id;
		$data['title']						= $data['datatypes']['name'];
		
		$this->load->view('excel/datatypes/datatypes_detail',$data);
	}
	
	public function checkdatatypesAvailability()
	{   
		$id 			= $this->input->post('id');
		$datatypes 		= $this->input->post('name');
		$result 		= checkAvailability('name',$datatypes,'adm_et_data_types','id',$id);
		
		if($result){
			$status = $datatypes." is already taken.Please try another one.";
		}
		else
		{
			$status = true;
		}
		echo json_encode($status);
		exit;	
	}

	public function datatypes_active()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		   status_to_update($chkId,'id','adm_et_data_types',STATUS_ACTIVE);
		}
			$success = true;
			$message = 'Data Types Updated successfully';
			$linkn   =  base_url('datatypes');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function datatypes_deactive()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		   status_to_update($chkId,'id','adm_et_data_types',STATUS_INACTIVE);
		}
			$success = true;
			$message = 'Data Types Updated successfully';
			$linkn   =  base_url('datatypes');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}
	  
}