<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Section extends CI_Controller {
	
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
		$this->sectionList();
	}
	
	public function sectionList()
	{

		$data['title']					= "Sections";

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] = array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] = array('Sections');
		$data['breadcrumb']        = $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['dataTableData'] 			= $this->home_model->get_sections(TABLE_COUNT);

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('sections/section_list',$data);
	}

	public function sectionDataTablelist()
	{
		$dataOptn 		= $this->input->get();
	    $dataTableData 	= $this->home_model->get_sections(TABLE_RESULT,$dataOptn);
	      // ******** Encrypt Data from multidimensional array ******//
	    $enc_arr['id']  = 'id_encrypt';
	    $dataTableArray['data'] = encrypt_key_in_array($dataTableData,$enc_arr);
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
	
	public function add_section()
	{
		
		$data = array();
		$validation_config = array(
				  array(
                     'field'   => 'section', 
                     'label'   => 'section name', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title						= 'Add section';
		$data['ctrler']				= 'section';
		$data['title']				= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('Sections', base_url('sections'));
		$data['breadcrumb_data'][] 	= array('Add Section');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']			= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('sections/add_section',$data);
		}
		else
		{
			$project_name 						= bsnprm_value(BSN_WEBSITE_NAME);
			
			$arrAccountData['section'] 		= trim($this->input->post('section'));

			$title 							= $arrAccountData['section'].'|'.$project_name;
			$keyword 						= $arrAccountData['section'].','.$project_name;

			$arrAccountData['description'] 	= trim($this->input->post('description'));
			$arrAccountData['page_url'] 	= trim($this->input->post('page_url'));
			$arrAccountData['page_title'] 	= ($this->input->post('page_title'))?trim($this->input->post('page_title')):$arrAccountData['section'];
			
			$arrAccountData['image_alt'] 	= ($this->input->post('image_alt'))?trim($this->input->post('image_alt')):$arrAccountData['section'];
			$arrAccountData['image_title'] 	= ($this->input->post('image_title'))?trim($this->input->post('image_title')):$arrAccountData['section'];

			$arrAccountData['meta_title'] 	=($this->input->post('meta_title'))?trim($this->input->post('meta_title')):$title;
			$arrAccountData['meta_keyword'] = ($this->input->post('meta_keyword'))?trim($this->input->post('meta_keyword')):$keyword;
			$arrAccountData['meta_description'] = ($this->input->post('meta_description'))?trim($this->input->post('meta_description')):$arrAccountData['description'];

			//Check whether user upload picture
            if(!empty($_FILES['picture']['name']))
            {

				$urlString = dirname(FCPATH);
		
                $config['upload_path'] 		= $urlString.'/'.SECTIONS_IMAGE_PATH;
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif';
                $config['file_name'] 		= $arrAccountData['page_url'];
               
               
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
               
                if($this->upload->do_upload('picture'))
                {

                    $uploadData = $this->upload->data();

                    
                    $picture = $uploadData['file_name'];
                     $arrAccountData['image_url'] 	= SECTIONS_IMAGE_PATH.$picture;

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

          
         
			$arrAccountData['status'] 	= STATUS_ACTIVE;
			$arrAccountData['created_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['updated_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['created_dt'] 		= date('Y-m-d H:i:s');
			$arrAccountData['updated_dt'] 		= date('Y-m-d H:i:s');

			$section_id	= insert('sections',$arrAccountData);
			
			$section_id = $this->crm_auth->encrypt_openssl($section_id);
			$this->session->set_flashdata('success', 'section added successfully');
			redirect(site_url('section-detail-'.$section_id));
			exit;
		}
	}
	
	public function edit_section($section_id = '')
	{
		
		$section_id = $this->crm_auth->decrypt_openssl($section_id);
		$data = array();

		$validation_config = array(
				  array(
                     'field'   => 'section', 
                     'label'   => 'section name', 
                     'rules'   => 'trim|required'
                  )
            );
		$this->form_validation->set_rules($validation_config);
		
	
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		$data['scontent']['section_id'] 	= $section_id;
		$data['section'] 					= $this->home_model->getsectionDataByID($data['scontent']);
		$data['section_id'] 				= $section_id;
		$esection_id 						= $this->crm_auth->encrypt_openssl($section_id);
		
		
		// automatically push current page to last record of breadcrumb
		$title						= 'Edit Section';
		$data['ctrler']				= 'section';
		$data['title']				= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('Sections', base_url('sections'));
		$data['breadcrumb_data'][] 	= array($data['section']['section'].' Details', base_url('section-detail-'.$esection_id));
		$data['breadcrumb_data'][] = array('Edit Section');
		$data['breadcrumb']        = $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('sections/edit_section',$data);
		}
		else
		{
				
			$project_name 						= bsnprm_value(BSN_WEBSITE_NAME);
			
			$section_id 						= trim($this->input->post('id'));
			$arrAccountData['section'] 			= trim($this->input->post('section'));
			$title 								= $arrAccountData['section'].'|'.$project_name;
			$keyword 							= $arrAccountData['section'].','.$project_name;

			$arrAccountData['description'] 		= trim($this->input->post('description'));
			$arrAccountData['page_url'] 		= trim($this->input->post('page_url'));
			$arrAccountData['page_title'] 		= ($this->input->post('page_title'))?trim($this->input->post('page_title')):$arrAccountData['section'];
			
			$arrAccountData['image_alt'] 		= ($this->input->post('image_alt'))?trim($this->input->post('image_alt')):$arrAccountData['section'];
			$arrAccountData['image_title'] 		= ($this->input->post('image_title'))?trim($this->input->post('image_title')):$arrAccountData['section'];

			$arrAccountData['meta_title'] 		= ($this->input->post('meta_title'))?trim($this->input->post('meta_title')):$title;
			$arrAccountData['meta_keyword'] 	= ($this->input->post('meta_keyword'))?trim($this->input->post('meta_keyword')):$keyword;
			$arrAccountData['meta_description'] = ($this->input->post('meta_description'))?trim($this->input->post('meta_description')):$arrAccountData['description'];

			
           

			$arrAccountData['status'] 		= STATUS_ACTIVE;
			$arrAccountData['updated_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['updated_dt'] 		= date('Y-m-d H:i:s');

			update('id', $section_id, $arrAccountData, 'sections');
	
			$section_id = $this->crm_auth->encrypt_openssl($section_id);
		
			echo json_encode(array('success'=>true,"message"=>"Section updated successfully","linkn"=>base_url()."section-detail-".$this->crm_auth->encrypt_openssl($this->input->post('id'))));
		}
	}

	public function sectionDetail($section_id = '')
	{		
		$section_id = $this->crm_auth->decrypt_openssl($section_id);
		$data = array();
		$data['section_id']  				= $section_id;
		$data['ctrl']  						= "section";
		$data['section'] 					= $this->home_model->getsectionDataByID($data);
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Sections', base_url('sections'));
		$data['breadcrumb_data'][] 			= array('Section Detail');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']					= array();
		$data['scontent']['section_id'] 	= $section_id;
		$data['title']						= $data['section']['section'];
		
		$this->load->view('sections/section_detail',$data);
	}
	
	public function checksectionAvailability()
	{   
		$id 		= $this->input->post('id');
		$section 	= $this->input->post('section');
		$result 	= checkAvailability('section',$section,'sections','id',$id);
		
		if($result){
			$status = $section." is already taken.Please try another one.";
		}
		else
		{
			$status = true;
		}
		echo json_encode($status);
		exit;	
	}

	public function sectionImageUpload()
	{
		
		$section_id = $this->input->post('id');
		$page_url 	= $this->input->post('page_url');
		$image_url 	= $this->input->post('image_url');
		
		 if(!empty($_FILES['picture']['name']))
            {

				$urlString = dirname(FCPATH);
				 unlink($urlString.'/'.$image_url);
                $config['upload_path'] 		= $urlString.'/'.SECTIONS_IMAGE_PATH;
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif';
                $config['file_name'] 		= $page_url;
               
               
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                
               
                if($this->upload->do_upload('picture'))
                {

                    $uploadData 					= $this->upload->data();

                    $picture 						= $uploadData['file_name'];

            		$arrAccountData['image_url'] 	= SECTIONS_IMAGE_PATH.$picture;

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
			
			update('id', $section_id, $arrAccountData, 'sections');
		
			$section_id = $this->crm_auth->encrypt_openssl($section_id);

			$this->session->set_flashdata('success', 'section added successfully');
			redirect(site_url('section-detail-'.$section_id));
			exit;

	}

	public function section_active()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
			status_to_update($chkId,'id','sections',STATUS_ACTIVE);
		}
			$success = true;
			$message = 'Section Updated successfully';
			$linkn   =  base_url('sections');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function section_deactive()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		   status_to_update($chkId,'id','sections',STATUS_INACTIVE);
		}
			$success = true;
			$message = 'Section Updated successfully';
			$linkn   =  base_url('sections');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function section_export()
	{
        $fileName 		= SECTION_FILENAME;
		$path 			= SAMPLE_EXCEL_PATH;
        $excelData 		= list_data('id,section,description,page_url,page_title,image_url,image_title,image_alt,meta_title,meta_keyword,meta_description,status', 'sections'); 
        $headerData 	= gettableColumns('sections');
        $excel_header	= get_header_data($headerData,$excelData);
       
        export_to_excel($fileName,$excelData,$excel_header,$path);

    }

    public function section_export_update($fileName = '')
	{
		$type           = 'update';
        $fileName 		= $fileName;
		$path 			= SECTIONS_EXCEL_PATH;
        $excelData 		= list_data('id,section,description,page_url,page_title,image_url,image_title,image_alt,meta_title,meta_keyword,meta_description,status', 'sections'); 
        $headerData 	= gettableColumns('sections');
        $excel_header	= get_header_data($headerData,$excelData);
       
        export_to_excel($fileName,$excelData,$excel_header,$path,$type);
        return true;

    }

    public function section_import()
    {
    	$data 				= array();

    	$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title								= 'Import section';
		$data['ctrler']						= 'section';
		$data['title']						= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Sections', base_url('sections'));
		$data['breadcrumb_data'][] 			= array('Import Section');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$entity_name 						= 'sections';
		$view_name	 						= 'excel';
		$data['excelData'] 					= get_excel_import_data($entity_name,$view_name);
		
  		$this->load->view('excel/excel_import_view',$data);
    }

}