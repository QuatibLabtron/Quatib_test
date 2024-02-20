<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {
	
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
		$this->categoriesList();
	}
	
	public function categoriesList()
	{

		$data['title']					= "Categories";

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] = array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] = array('Categories');
		$data['breadcrumb']        = $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['dataTableData'] 			= $this->home_model->get_categories(TABLE_COUNT);

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('categories/categories_list',$data);
	}

	public function categoriesDataTablelist()
	{
		$dataOptn = $this->input->get();
	    $dataTableData = $this->home_model->get_categories(TABLE_RESULT,$dataOptn);
	      // ******** Encrypt Data from multidimensional array ******//
	    $enc_arr['id']    			= 'id_encrypt';
	    $enc_arr['section_id']    	= 'section_id_encrypt';
	    $enc_arr['category_id']    	= 'category_id_encrypt';
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
	
	public function add_categories()
	{
		
		$data = array();
		$validation_config = array(
				  array(
                     'field'   => 'name', 
                     'label'   => 'Categories name', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title						= 'Add Categories';
		$data['ctrler']				= 'Categories';
		$data['title']				= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('Categories', base_url('categories'));
		$data['breadcrumb_data'][] 	= array('Add Categories');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']			= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('categories/add_categories',$data);
		}
		else
		{
			$project_name 						= bsnprm_value(BSN_WEBSITE_NAME);
			
			$arrAccountData['name'] 			= trim($this->input->post('name'));

			$title 								= $arrAccountData['name'].'|'.$project_name;
			$keyword 							= $arrAccountData['name'].','.$project_name;

			$arrAccountData['description'] 		= trim($this->input->post('description'));

			$arrAccountData['section'] 			= $this->input->post('section');
			$arrAccountData['parent_id'] 		= trim($this->input->post('parent_id'));
			$arrAccountData['level'] 			= trim($this->input->post('level'));

			$arrAccountData['url_title'] 		= ($this->input->post('url_title'))?trim($this->input->post('url_title')):str_replace(" ","-",$arrAccountData['name']);

			$arrAccountData['page_url'] 		= trim($this->input->post('page_url'));
			$arrAccountData['page_title'] 		= ($this->input->post('page_title'))?trim($this->input->post('page_title')):$arrAccountData['name'];
			
			$arrAccountData['image_alt'] 		= ($this->input->post('image_alt'))?trim($this->input->post('image_alt')):$arrAccountData['name'];
			$arrAccountData['image_title'] 		= ($this->input->post('image_title'))?trim($this->input->post('image_title')):$arrAccountData['name'];

			$arrAccountData['meta_title'] 		= ($this->input->post('meta_title'))?trim($this->input->post('meta_title')):$title;
			$arrAccountData['meta_keyword'] 	= ($this->input->post('meta_keyword'))?trim($this->input->post('meta_keyword')):$keyword;
			$arrAccountData['meta_description'] = ($this->input->post('meta_description'))?trim($this->input->post('meta_description')):$arrAccountData['description'];

			//Check whether user upload picture
            if(!empty($_FILES['picture']['name']))
            {

				$urlString = dirname(FCPATH);
		
                $config['upload_path'] 		= $urlString.'/'.CATEGORIES_IMAGE_PATH;
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif';
                $config['file_name'] 		= $arrAccountData['url_title'];
               
               
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
               
                if($this->upload->do_upload('picture'))
                {

                    $uploadData 					= $this->upload->data();
                    $picture 						= $uploadData['file_name'];
                    $arrAccountData['image_url'] 	= CATEGORIES_IMAGE_PATH.$picture;

                }
                else
                {
                	
                    $picture = '';
                }
            }
            else
            {
                $picture = '';
            }

          
         
			$arrAccountData['status'] 		= STATUS_ACTIVE;
			$arrAccountData['created_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['updated_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['created_dt'] 		= date('Y-m-d H:i:s');
			$arrAccountData['updated_dt'] 		= date('Y-m-d H:i:s');

			$categories_id	= insert('categories',$arrAccountData);
			
			$categories_id = $this->crm_auth->encrypt_openssl($categories_id);
			$this->session->set_flashdata('success', 'Categories added successfully');
			redirect(site_url('categories-detail-'.$categories_id));
			exit;
		}
	}
	
	public function edit_categories($categories_id = '')
	{
		
		$categories_id = $this->crm_auth->decrypt_openssl($categories_id);
		$data = array();

		$validation_config = array(
				  array(
                     'field'   => 'name', 
                     'label'   => 'Categories name', 
                     'rules'   => 'trim|required'
                  )
            );
		$this->form_validation->set_rules($validation_config);
		
	
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		$data['scontent']['categories_id'] 	= $categories_id;
		$data['categories'] 				= $this->home_model->getcategoriesDataByID($data['scontent']);
		$data['categories_id'] 				= $categories_id;
		$ecategories_id 					= $this->crm_auth->encrypt_openssl($categories_id);
		
		
		// automatically push current page to last record of breadcrumb
		$title						= 'Edit Categories';
		$data['ctrler']				= 'Categories';
		$data['title']				= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('Categories', base_url('categories'));
		$data['breadcrumb_data'][] 	= array($data['categories']['name'].' Details', base_url('categories-detail-'.$ecategories_id));
		$data['breadcrumb_data'][] 	= array('Edit Categories');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('categories/edit_categories',$data);
		}
		else
		{
				
			$project_name 						= bsnprm_value(BSN_WEBSITE_NAME);
			
			$categories_id 						= trim($this->input->post('id'));
			$arrAccountData['name'] 			= trim($this->input->post('name'));
			$title 								= $arrAccountData['name'].'|'.$project_name;
			$keyword 							= $arrAccountData['name'].','.$project_name;

			$arrAccountData['description'] 		= trim($this->input->post('description'));

			
			$arrAccountData['section'] 			= $this->input->post('section');
			$arrAccountData['parent_id'] 		= trim($this->input->post('parent_id'));
			$arrAccountData['level'] 			= trim($this->input->post('level'));
			
			$arrAccountData['url_title'] 		= ($this->input->post('url_title'))?trim($this->input->post('url_title')):str_replace(" ","-",$arrAccountData['name']);

			$arrAccountData['page_url'] 		= trim($this->input->post('page_url'));
			$arrAccountData['page_title'] 		= ($this->input->post('page_title'))?trim($this->input->post('page_title')):$arrAccountData['name'];
			
			$arrAccountData['image_alt'] 		= ($this->input->post('image_alt'))?trim($this->input->post('image_alt')):$arrAccountData['name'];
			$arrAccountData['image_title'] 	 	= ($this->input->post('image_title'))?trim($this->input->post('image_title')):$arrAccountData['name'];

			$arrAccountData['meta_title'] 		= ($this->input->post('meta_title'))?trim($this->input->post('meta_title')):$title;
			$arrAccountData['meta_keyword'] 	= ($this->input->post('meta_keyword'))?trim($this->input->post('meta_keyword')):$keyword;
			$arrAccountData['meta_description'] = ($this->input->post('meta_description'))?trim($this->input->post('meta_description')):$arrAccountData['description'];

			
           

			$arrAccountData['status'] 		= STATUS_ACTIVE;
			$arrAccountData['updated_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['updated_dt'] 		= date('Y-m-d H:i:s');
			

			update('id', $categories_id, $arrAccountData, 'categories');

			echo json_encode(array('success'=>true,"message"=>"categories updated successfully","linkn"=>base_url()."categories-detail-".$categories_id));
		}
	}

	public function categoriesDetail($categories_id = '')
	{
		$categories_id = $this->crm_auth->decrypt_openssl($categories_id);
		$data = array();
		$data['categories_id']  			= $categories_id;
		$data['categories'] 				= $this->home_model->getcategoriesDataByID($data);

		$data['ctrl']  						= "Detail";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Categories', base_url('categories'));
		$data['breadcrumb_data'][] 			= array('Categories Detail');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']					= array();
		$data['scontent']['categories_id'] 	= $categories_id;
		$data['title']						= $data['categories']['name'];
		
		$this->load->view('categories/categories_detail',$data);
	}
	
	public function checkcategoriesAvailability()
	{
		$id 			= $this->input->post('id');
		$categories 	= $this->input->post('name');
		$result 		= checkAvailability('name',$categories,'categories','id',$id);
		
		if($result){
			$status = $categories." is already taken.Please try another one.";
		}
		else
		{
			$status = true;
		}
		echo json_encode($status);
		exit;	
	}

	public function check_category_level()
	{
		$category_id 			= $this->input->post('category_id');
		$sdata['categories_id'] = $category_id;
		$categories 			= $this->home_model->getcategoriesDataByID($sdata);
		$level 					= $categories['level'] + 1;
		echo json_encode(array('success'=>true,"level"=>$level));
	}

	public function categoriesImageUpload()
	{
		$categories_id = $this->input->post('id');
		$page_url 	= $this->input->post('page_url');
		$image_url 	= $this->input->post('image_url');
		
		if(!empty($_FILES['picture']['name']))
        {

			$urlString = dirname(FCPATH);
			 unlink($urlString.'/'.$image_url);
            $config['upload_path'] 		= $urlString.'/'.CATEGORIES_IMAGE_PATH;
            $config['allowed_types'] 	= 'jpg|jpeg|png|gif';
            $config['file_name'] 		= $page_url;
           
           
            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            
           
            if($this->upload->do_upload('picture'))
            {

                $uploadData = $this->upload->data();

                
                $picture = $uploadData['file_name'];
                 
        		$arrAccountData['image_url'] 	= CATEGORIES_IMAGE_PATH.$picture;

            }
            else
            {
            	
                $picture = '';
            }
        }
        else
        {
            $picture = '';
        }

        $arrAccountData['status'] 		= STATUS_ACTIVE;
		$arrAccountData['updated_by'] 		= $this->session->userdata('prs_id');
		$arrAccountData['updated_dt'] 		= date('Y-m-d H:i:s');
		
		update('id', $categories_id, $arrAccountData, 'categories');

	
		$categories_id = $this->crm_auth->encrypt_openssl($categories_id);

		$this->session->set_flashdata('success', 'Categories images updated successfully');
		redirect(site_url('categories-detail-'.$categories_id));
		exit;
	}

	public function categories_active()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		    status_to_update($chkId,'id','categories',STATUS_ACTIVE);
		}
			$success = true;
			$message = 'Categories Updated successfully';
			$linkn   =  base_url('categories');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function categories_deactive()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		    status_to_update($chkId,'id','categories',STATUS_INACTIVE);
		}
			$success = true;
			$message = 'Categories Updated successfully';
			$linkn   =  base_url('categories');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}
	  
	public function categories_export()
	{
		
        $fileName 	  = CATEGORIES_FILENAME;
		$path 		  = SAMPLE_EXCEL_PATH;
        $excelData 	  = list_data('id,name,parent_id,level,section,description,status,page_url,page_title,image_url,image_title,image_alt,meta_title,meta_keyword,meta_description,url_title', 'categories');
        $headerData   = gettableColumns('categories');
        $excel_header = get_header_data($headerData,$excelData);
       
        export_to_excel($fileName,$excelData,$excel_header,$path);

    }

    public function categories_import()
    {
    	$data 				= array();

    	$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title								= 'Import Categories';
		$data['ctrler']						= 'categories';
		$data['title']						= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('Categories', base_url('categories'));
		$data['breadcrumb_data'][] 	= array('Import Categories');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$entity_name 		= 'categories';
		$view_name	 		= 'excel';
		$data['excelData'] 	= get_excel_import_data($entity_name,$view_name);

  		$this->load->view('excel/excel_import_view',$data);
    }
	  
}