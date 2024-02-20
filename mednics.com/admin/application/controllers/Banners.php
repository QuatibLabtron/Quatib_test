<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banners extends CI_Controller {
	
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
		$this->bannersList();
	}
	
	public function bannersList()
	{

		$data['title']					= "Banners";

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 		= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 		= array('Banners');
		$data['breadcrumb']        		= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['dataTableData'] 			= $this->home_model->get_banners(TABLE_COUNT);

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('banners/banners_list',$data);
	}

	public function bannersDataTablelist()
	{
		$dataOptn 						= $this->input->get();
	    $dataTableData 					= $this->home_model->get_banners(TABLE_RESULT,$dataOptn);
	      // ******** Encrypt Data from multidimensional array ******//
	    $enc_arr['id']    				= 'id_encrypt';

	    $dataTableArray['data'] 		= encrypt_key_in_array($dataTableData,$enc_arr);
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
	
	public function add_banners()
	{
		
		$data = array();
		$validation_config = array(
				  array(
                     'field'   => 'name', 
                     'label'   => 'Banners name', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title								= 'Add Banners';
		$data['ctrler']						= 'Banners';
		$data['title']						= $title;

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Banners', base_url('banners'));
		$data['breadcrumb_data'][] 			= array('Add Banners');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']			= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('banners/add_banners',$data);
		}
		else
		{
			$project_name 						= bsnprm_value(BSN_WEBSITE_NAME);
			
			$arrAccountData['name'] 			= trim($this->input->post('name'));
			$arrAccountData['order'] 			= trim($this->input->post('order'));

			$title 								= $arrAccountData['name'].'|'.$project_name;
			$keyword 							= $arrAccountData['name'].','.$project_name;
			
			$arrAccountData['image_alt'] 		= ($this->input->post('image_alt'))?trim($this->input->post('image_alt')):$arrAccountData['name'];
			$arrAccountData['image_title'] 		= ($this->input->post('image_title'))?trim($this->input->post('image_title')):$arrAccountData['name'];

			//Check whether user upload picture
            if(!empty($_FILES['picture']['name']))
            {

				$urlString = dirname(FCPATH);
		
                $config['upload_path'] 		= $urlString.'/'.BANNER_IMAGE_PATH;
                $config['allowed_types'] 	= 'jpg|jpeg|png|gif';
                $config['file_name'] 		= $arrAccountData['name'];
               
                //Load upload library and initialize configuration
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
               
                if($this->upload->do_upload('picture'))
                {
                    $uploadData 					= $this->upload->data();
                    $picture 						= $uploadData['file_name'];
                    $arrAccountData['image_url'] 	= BANNER_IMAGE_PATH.$picture;
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

			$banners_id	= insert('banners',$arrAccountData); 

			$banners_id = $this->crm_auth->encrypt_openssl($banners_id);
			$this->session->set_flashdata('success', 'Banners added successfully');
			redirect(site_url('banners-detail-'.$banners_id));
			exit;
		}
	}
	
	public function edit_banners($banners_id = '')
	{
		
		$banners_id = $this->crm_auth->decrypt_openssl($banners_id);
		$data 		= array();

		$validation_config = array(
				  array(
                     'field'   => 'name', 
                     'label'   => 'Banners name', 
                     'rules'   => 'trim|required'
                  )
            );
		$this->form_validation->set_rules($validation_config);
		
	
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		$data['scontent']['banners_id'] 	= $banners_id;
		$data['banners'] 					= $this->home_model->getbannersDataByID($data['scontent']);
		$data['banners_id'] 				= $banners_id;
		$ebanners_id 						= $this->crm_auth->encrypt_openssl($banners_id);
		
		
		// automatically push current page to last record of breadcrumb
		$title						= 'Edit Banners';
		$data['ctrler']				= 'Banners';
		$data['title']				= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('Banners', base_url('banners'));
		$data['breadcrumb_data'][] 	= array($data['banners']['name'].' Details', base_url('banners-detail-'.$ebanners_id));
		$data['breadcrumb_data'][] 	= array('Edit Banners');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('banners/edit_banners',$data);
		}
		else
		{
				
			$project_name 						= bsnprm_value(BSN_WEBSITE_NAME);
			
			$banners_id 						= trim($this->input->post('id'));
			$arrAccountData['name'] 			= trim($this->input->post('name'));
			$arrAccountData['order'] 			= trim($this->input->post('order'));
			$title 								= $arrAccountData['name'].'|'.$project_name;
			$keyword 							= $arrAccountData['name'].','.$project_name;
			
			$arrAccountData['image_alt'] 		= ($this->input->post('image_alt'))?trim($this->input->post('image_alt')):$arrAccountData['name'];
			$arrAccountData['image_title'] 	 	= ($this->input->post('image_title'))?trim($this->input->post('image_title')):$arrAccountData['name'];


			$arrAccountData['status'] 		= STATUS_ACTIVE;
			$arrAccountData['updated_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['updated_dt'] 		= date('Y-m-d H:i:s');

			update('id', $banners_id, $arrAccountData, 'banners');
			
			$banners_id = $this->crm_auth->encrypt_openssl($banners_id);
			echo json_encode(array('success'=>true,"message"=>"Banners updated successfully","linkn"=>base_url()."banners-detail-".$banners_id));
		}
	}

	public function bannersDetail($banners_id = '')
	{
		$banners_id = $this->crm_auth->decrypt_openssl($banners_id);
		$data = array();
		$data['banners_id']  				= $banners_id;
		$data['banners'] 					= $this->home_model->getbannersDataByID($data);

		$data['ctrl']  						= "Detail";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Banners', base_url('banners'));
		$data['breadcrumb_data'][] 			= array('Banners Detail');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']					= array();
		$data['scontent']['banners_id'] 	= $banners_id;
		$data['title']						= $data['banners']['name'];
		
		$this->load->view('banners/banners_detail',$data);
	}
	
	public function checkbannersAvailability()
	{
		$id 			= $this->input->post('id');
		$banners 		= $this->input->post('name');
		$result 		= checkAvailability('name',$banners,'banners','id',$id);
		
		if($result){
			$status = $banners." is already taken.Please try another one.";
		}
		else
		{
			$status = true;
		}
		echo json_encode($status);
		exit;	
	}

	public function bannersImageUpload()
	{
		$banners_id = $this->input->post('id');
		$page_url 	= $this->input->post('page_url');
		$image_url 	= $this->input->post('image_url');
		
		if(!empty($_FILES['picture']['name']))
        {

			$urlString = dirname(FCPATH);
			 unlink($urlString.'/'.$image_url);
            $config['upload_path'] 		= $urlString.'/'.BANNER_IMAGE_PATH;
            $config['allowed_types'] 	= 'jpg|jpeg|png|gif';
            $config['file_name'] 		= $page_url;
                 
            //Load upload library and initialize configuration
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
           
            if($this->upload->do_upload('picture'))
            {
                $uploadData = $this->upload->data();
                $picture = $uploadData['file_name']; 
        		$arrAccountData['image_url'] 	= BANNER_IMAGE_PATH.$picture;
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
		

		$this->home_model->updatebanners($arrAccountData,$banners_id);
		
		//TRACK USER Activity
	
		$banners_id = $this->crm_auth->encrypt_openssl($banners_id);

		$this->session->set_flashdata('success', 'Banners added successfully');
		redirect(site_url('banners-detail-'.$banners_id));
		exit;
	}

	public function banners_active()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
			status_to_update($chkId,'id','banners',STATUS_ACTIVE);
		}
			$success = true;
			$message = 'Banners Updated successfully';
			$linkn   =  base_url('banners');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function banners_deactive()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		    status_to_update($chkId,'id','banners',STATUS_INACTIVE);
		}
			$success = true;
			$message = 'Banners Updated successfully';
			$linkn   =  base_url('banners');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}
	  
	
}