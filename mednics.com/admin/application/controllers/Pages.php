<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {
	
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
		$this->pagesList();
	}
	
	public function pagesList()
	{
		$data['title']					= "Pages";

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] = array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] = array('Pages');
		$data['breadcrumb']        = $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['dataTableData'] 			= $this->home_model->get_pages(TABLE_COUNT);

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('pages/pages_list',$data);
	}

	public function pagesDataTablelist()
	{
		$dataOptn = $this->input->get();
	    $dataTableData = $this->home_model->get_pages(TABLE_RESULT,$dataOptn);
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
	
	public function add_pages()
	{
		
		$data = array();
		$validation_config = array(
				  array(
                     'field'   => 'name', 
                     'label'   => 'Pages name', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title						= 'Add Pages';
		$data['ctrler']				= 'Pages';
		$data['title']				= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('Pages', base_url('pages'));
		$data['breadcrumb_data'][] 	= array('Add Pages');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']			= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('pages/add_pages',$data);
		}
		else
		{
			$project_name 						= bsnprm_value(BSN_WEBSITE_NAME);
			
			$arrAccountData['name'] 			= trim($this->input->post('name'));

			$title 								= $arrAccountData['name'].'|'.$project_name;
			$keyword 							= $arrAccountData['name'].','.$project_name;

			$arrAccountData['description'] 		= trim($this->input->post('description'));

			$arrAccountData['page_url'] 		= trim($this->input->post('page_url'));
			$arrAccountData['page_title'] 		= ($this->input->post('page_title'))?trim($this->input->post('page_title')):$arrAccountData['name'];
			

			$arrAccountData['meta_title'] 		= ($this->input->post('meta_title'))?trim($this->input->post('meta_title')):$title;
			$arrAccountData['meta_keyword'] 	= ($this->input->post('meta_keyword'))?trim($this->input->post('meta_keyword')):$keyword;
			$arrAccountData['meta_description'] = ($this->input->post('meta_description'))?trim($this->input->post('meta_description')):$arrAccountData['description'];

			
          
         
			$arrAccountData['status'] 		= STATUS_ACTIVE;
			$arrAccountData['created_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['updated_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['created_dt'] 		= date('Y-m-d H:i:s');
			$arrAccountData['updated_dt'] 		= date('Y-m-d H:i:s');

			$pages_id	= insert('pages',$arrAccountData);
			
			$pages_id = $this->crm_auth->encrypt_openssl($pages_id);
			$this->session->set_flashdata('success', 'pages added successfully');
			redirect(site_url('pages-detail-'.$pages_id));
			exit;
		}
	}
	
	public function edit_pages($pages_id = '')
	{
		
		$pages_id = $this->crm_auth->decrypt_openssl($pages_id);
		$data = array();

		$validation_config = array(
				  array(
                     'field'   => 'name', 
                     'label'   => 'Pages name', 
                     'rules'   => 'trim|required'
                  )
            );
		$this->form_validation->set_rules($validation_config);
		
	
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		$data['scontent']['pages_id'] 		= $pages_id;
		$data['pages'] 						= $this->home_model->getpagesDataByID($data['scontent']);
		$data['pages_id'] 					= $pages_id;
		$epages_id 							= $this->crm_auth->encrypt_openssl($pages_id);
		
		
		// automatically push current page to last record of breadcrumb
		$title						= 'Edit Pages';
		$data['ctrler']				= 'Pages';
		$data['title']				= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('Pages', base_url('pages'));
		$data['breadcrumb_data'][] 	= array($data['pages']['name'].' Details', base_url('pages-detail-'.$epages_id));
		$data['breadcrumb_data'][] 	= array('Edit Pages');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('pages/edit_pages',$data);
		}
		else
		{
				
			$project_name 						= bsnprm_value(BSN_WEBSITE_NAME);
			
			$pages_id 							= trim($this->input->post('id'));
			$arrAccountData['name'] 			= trim($this->input->post('name'));
			$title 								= $arrAccountData['name'].'|'.$project_name;
			$keyword 							= $arrAccountData['name'].','.$project_name;

			$arrAccountData['description'] 		= trim($this->input->post('description'));

			$arrAccountData['page_url'] 		= trim($this->input->post('page_url'));
			$arrAccountData['page_title'] 		= ($this->input->post('page_title'))?trim($this->input->post('page_title')):$arrAccountData['name'];

			$arrAccountData['meta_title'] 		= ($this->input->post('meta_title'))?trim($this->input->post('meta_title')):$title;
			$arrAccountData['meta_keyword'] 	= ($this->input->post('meta_keyword'))?trim($this->input->post('meta_keyword')):$keyword;
			$arrAccountData['meta_description'] = ($this->input->post('meta_description'))?trim($this->input->post('meta_description')):$arrAccountData['description'];
			

			$arrAccountData['status'] 			= STATUS_ACTIVE;
			$arrAccountData['updated_by'] 			= $this->session->userdata('prs_id');
			$arrAccountData['updated_dt'] 			= date('Y-m-d H:i:s');
			
			update('id', $pages_id, $arrAccountData, 'pages');
		
			$pages_id 							= $this->crm_auth->encrypt_openssl($pages_id);

			echo json_encode(array('success'=>true,"message"=>"pages updated successfully","linkn"=>base_url()."pages-detail-".$pages_id));
		}
	}

	public function pagesDetail($pages_id = '')
	{		
		$pages_id 							= $this->crm_auth->decrypt_openssl($pages_id);
		$data 								= array();
		$data['pages_id']  					= $pages_id;
		$data['pages'] 						= $this->home_model->getpagesDataByID($data);

		$data['ctrl']  						= "Pages";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Pages', base_url('pages'));
		$data['breadcrumb_data'][] 			= array('Pages Detail');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']					= array();
		$data['scontent']['pages_id'] 		= $pages_id;
		$data['title']						= $data['pages']['name'];
		
		$this->load->view('pages/pages_detail',$data);
	}
	
	public function checkpagesAvailability()
	{   
		$id 			= $this->input->post('id');
		$pages 			= $this->input->post('name');
		$result 		= checkAvailability('name',$pages,'pages','id',$id);
		
		if($result)
		{
			$status 	= $pages." is already taken.Please try another one.";
		}
		else
		{
			$status 	= true;
		}

		echo json_encode($status);
		exit;	
	}

	public function pages_active()
	{
		$chkId 		 = $this->input->post('chkId');
    	if($chkId)
		{
		    status_to_update($chkId,'id','pages',STATUS_ACTIVE);
		}
			$success = true;
			$message = 'pages Updated successfully';
			$linkn   =  base_url('pages');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function pages_deactive()
	{
		$chkId 		= $this->input->post('chkId');
    	if($chkId)
		{
		  status_to_update($chkId,'id','pages',STATUS_INACTIVE);
		}
			$success = true;
			$message = 'pages Updated successfully';
			$linkn   =  base_url('pages');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function pages_export()
	{
        $fileName 		= PAGES_FILENAME;
		$path 			= SAMPLE_EXCEL_PATH;
        $excelData 		= list_data('id, name, description, page_url, page_title, meta_title, meta_keyword, meta_description,status', 'pages'); 
        $headerData 	= gettableColumns('pages');
        $excel_header	= get_header_data($headerData,$excelData);
       
        export_to_excel($fileName,$excelData,$excel_header,$path);

    }

    public function pages_export_update($fileName = '')
	{
		$type           = 'update';
        $fileName 		= $fileName;
		$path 			= PAGES_EXCEL_PATH;
        $excelData 		= list_data('id, name, description, page_url, page_title, meta_title, meta_keyword, meta_description,status', 'pages');
        $headerData 	= gettableColumns('pages');
        $excel_header	= get_header_data($headerData,$excelData);
       
        export_to_excel($fileName,$excelData,$excel_header,$path,$type);
        return true;

    }

    public function pages_import()
    {
    	$data 				= array();

    	$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title								= 'Import pages';
		$data['ctrler']						= 'pages';
		$data['title']						= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Pages', base_url('pages'));
		$data['breadcrumb_data'][] 			= array('Import Pages');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$entity_name 						= 'pages';
		$view_name	 						= 'excel';
		$data['excelData'] 					= get_excel_import_data($entity_name,$view_name);
		
  		$this->load->view('excel/excel_import_view',$data);
    }

	  
}