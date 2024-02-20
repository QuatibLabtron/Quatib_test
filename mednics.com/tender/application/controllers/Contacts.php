<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends CI_Controller {
	
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
		$this->contactsList();
	}

/***********************************************************
			STANDARD FUNCTIONS
************************************************************/
	
	public function contactsList()
	{

		$data['title']					= "Contacts";

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 		= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 		= array('Contacts');
		$data['breadcrumb']        		= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['dataTableData'] 			= $this->home_model->getAllContacts(TABLE_COUNT);

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('contacts/contacts_list',$data);
	}

	public function contactsDataTablelist()
	{
		$dataOptn 					= $this->input->get();
	    $dataTableData 				= $this->home_model->getAllContacts(TABLE_RESULT,$dataOptn);
	      // ******** Encrypt Data from multidimensional array ******//
	    $enc_arr['id']    			= 'id_encrypt';
	   /* $enc_arr['contact_id'] = 'contact_id_encrypt';*/
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

	public function contactsDetail($contacts_id = '')
	{
		$contacts_id 						= $this->crm_auth->decrypt_openssl($contacts_id);
		$data 								= array();
		$data['contacts_id']  				= $contacts_id;
		$data['contacts'] 					= $this->home_model->getcontactsDataByID($data);
		
		$data['ctrl']  						= "Detail";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Contacts', base_url('contacts'));
		$data['breadcrumb_data'][] 			= array('Contacts Detail');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']					= array();
		$data['scontent']['contacts_id'] 	= $contacts_id;
		$data['title']						= $data['contacts']['cont_name'];

		$this->load->view('contacts/contacts_detail',$data);
	}
	
	public function add_contacts()
	{
		$data 									= array();
		$validation_config 						= array(
				  array(
                     'field'   => 'cont_firstname', 
                     'label'   => 'Contacts first name', 
                     'rules'   => 'trim|required'
                  ),
                  array(
                     'field'   => 'cont_primaryemail', 
                     'label'   => 'Contacts primary email', 
                     'rules'   => 'trim|required'
                  ),
            );

		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 			= global_asset_version();
		$data['ci_asset_versn'] 				= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title									= 'Add Contacts';
		$data['ctrler']							= 'Contacts';
		$data['title']							= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 				= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 				= array('Contacts', base_url('contacts'));
		$data['breadcrumb_data'][] 				= array('Add Contacts');
		$data['breadcrumb']        				= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('contacts/add_contacts',$data);
		}
		else
		{

			$arrAccountData['cont_type'] 			= trim($this->input->post('cont_type'));
			$arrAccountData['cont_sal'] 			= trim($this->input->post('cont_sal'));
			$arrAccountData['cont_firstname'] 		= trim($this->input->post('cont_firstname'));
			$arrAccountData['cont_lastname'] 		= trim($this->input->post('cont_lastname'));
			$arrAccountData['cont_orgid'] 			= trim($this->input->post('cont_orgid'));
			$arrAccountData['cont_primaryemail'] 	= trim($this->input->post('cont_primaryemail'));
			$arrAccountData['cont_secondaryemail'] 	= trim($this->input->post('cont_secondaryemail'));
			$arrAccountData['cont_mobilephone'] 	= trim($this->input->post('cont_mobilephone'));
			$arrAccountData['cont_altphone'] 		= trim($this->input->post('cont_altphone'));
			$arrAccountData['cont_leadsource'] 		= trim($this->input->post('cont_leadsource'));
			$arrAccountData['cont_assignedto'] 		= trim($this->input->post('cont_assignedto'));
			$arrAccountData['cont_assignedid'] 		= trim($this->input->post('cont_assignedid'));
			$arrAccountData['cont_department'] 		= trim($this->input->post('cont_department'));
			$arrAccountData['cont_desc'] 			= trim($this->input->post('cont_desc'));
			$arrAccountData['cont_comment'] 		= trim($this->input->post('cont_comment'));
			$arrAccountData['status'] 				= STATUS_ACTIVE;
			$arrAccountData['created_by'] 			= $this->session->userdata('prs_id');
			$arrAccountData['updated_by'] 			= $this->session->userdata('prs_id');
			$arrAccountData['created_dt'] 			= date('Y-m-d H:i:s');
			$arrAccountData['updated_dt'] 			= date('Y-m-d H:i:s');

			$contacts_id	= insert('tender_contact',$arrAccountData);

			//********* TRACK USER Activity *********//
			$this->contact_activity($arrAccountData,TENDER_ACTIVITY_CREATE, $contacts_id);
			//********* TRACK USER Activity *********//

			$econtacts_id 	= $this->crm_auth->encrypt_openssl($contacts_id);
			$this->session->set_flashdata('success', 'Contacts added successfully');
			redirect(site_url('contacts-detail-'.$econtacts_id));
			exit;
		}
	}
	
	public function edit_contacts($contacts_id = '')
	{
		
		$contacts_id 			= $this->crm_auth->decrypt_openssl($contacts_id);
		$data 					= array();

		$validation_config 		= array(
				  array(
                     'field'   => 'cont_firstname', 
                     'label'   => 'Contacts first name', 
                     'rules'   => 'trim|required'
                  ),
                  array(
                     'field'   => 'cont_primaryemail', 
                     'label'   => 'Contacts primary email', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);
		
	
		$data['global_asset_version'] 			= global_asset_version();
		$data['ci_asset_versn'] 				= ci_asset_versn();
		$data['scontent']['contacts_id'] 		= $contacts_id;
		$data['contacts'] 						= $this->home_model->getcontactsDataByID($data['scontent']);
		$data['contacts_id'] 					= $contacts_id;
		$econtacts_id 							= $this->crm_auth->encrypt_openssl($contacts_id);
		
		
		// automatically push current page to last record of breadcrumb
		$title							= 'Edit Contacts';
		$data['ctrler']					= 'Contacts';
		$data['title']					= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 		= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 		= array('Contacts', base_url('contacts'));
		$data['breadcrumb_data'][] 		= array($data['contacts']['cont_name'].' Details', base_url('contacts-detail-'.$econtacts_id));
		$data['breadcrumb_data'][] 		= array('Edit Contacts');
		$data['breadcrumb']        		= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('contacts/edit_contacts',$data);
		}
		else
		{
			
			$contacts_id 							= trim($this->input->post('cont_id'));
			$arrAccountData['cont_type'] 			= trim($this->input->post('cont_type'));
			$arrAccountData['cont_sal'] 			= trim($this->input->post('cont_sal'));
			$arrAccountData['cont_firstname'] 		= trim($this->input->post('cont_firstname'));
			$arrAccountData['cont_lastname'] 		= trim($this->input->post('cont_lastname'));
			$arrAccountData['cont_orgid'] 			= trim($this->input->post('cont_orgid'));
			$arrAccountData['cont_primaryemail'] 	= trim($this->input->post('cont_primaryemail'));
			$arrAccountData['cont_secondaryemail'] 	= trim($this->input->post('cont_secondaryemail'));
			$arrAccountData['cont_mobilephone'] 	= trim($this->input->post('cont_mobilephone'));
			$arrAccountData['cont_altphone'] 		= trim($this->input->post('cont_altphone'));
			$arrAccountData['cont_leadsource'] 		= trim($this->input->post('cont_leadsource'));
			$arrAccountData['cont_department'] 		= trim($this->input->post('cont_department'));
			$arrAccountData['cont_desc'] 			= trim($this->input->post('cont_desc'));
			$arrAccountData['cont_comment'] 		= trim($this->input->post('cont_comment'));
			$arrAccountData['cont_assignedto'] 		= trim($this->input->post('cont_assignedto'));
			$arrAccountData['cont_assignedid'] 		= trim($this->input->post('cont_assignedid'));
			$arrAccountData['status'] 			= STATUS_ACTIVE;
			$arrAccountData['updated_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['updated_dt'] 		= date('Y-m-d H:i:s');

			//********* TRACK USER Activity *********//
			$this->contact_activity($arrAccountData,TENDER_ACTIVITY_UPDATE, $contacts_id);
			//********* TRACK USER Activity *********//

			update('cont_id', $contacts_id, $arrAccountData, 'tender_contact');

			$econtacts_id 							= $this->crm_auth->encrypt_openssl($contacts_id);
			
			echo json_encode(array('success'=>true,"message"=>"Contacts updated successfully","linkn"=>base_url()."contacts-detail-".$econtacts_id));
		}
	}

	public function contacts_active()
	{
		$chkId 		= $this->input->post('chkId');

    	if($chkId)
		{
		    status_to_update($chkId,'cont_id','tender_contact',STATUS_ACTIVE);
		}
			$success = true;
			$message = 'Contacts Updated successfully';
			$linkn   =  base_url('contacts');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function contacts_deactive()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		    status_to_update($chkId,'cont_id','tender_contact',STATUS_INACTIVE);
		}
			$success = true;
			$message = 'Contacts Updated successfully';
			$linkn   =  base_url('contacts');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

/***********************************************************
			ADDTIONAL FUNCTIONS
************************************************************/
	
	public function checkcontactsAvailability()
	{
		$id 			= $this->input->post('cont_id');
		$contacts 		= $this->input->post('cont_name');
		$result 		= checkAvailability('cont_name',$contacts,'tender_contact','cont_id',$id);

		
		if($result)
		{
			$status = $contacts." is already taken.Please try another one.";
		}
		else
		{
			$status = true;
		}
		echo json_encode($status);
		exit;
	}

	public function checkcontactsEmailAvailability()
	{
		$id 			= $this->input->post('cont_id');
		$contacts 		= $this->input->post('cont_primaryemail');
		/*$result 		= checkAvailability('cont_primaryemail',$contacts,'tender_contact','cont_id',$id);
		
		if($result){
			$status = $contacts." is already taken.Please try another one.";
		}
		else
		{
			$status = true;
		}
		echo json_encode($status);
		exit;*/
         $result = $this->home_model->validateContactsData('cont_primaryemail',$contacts,$id);
		
		if($result == 1){
			
			$status = true;
		}
		else
		{
			$status = $contacts." is already exist.Please try another one.";
		}
		echo json_encode($status);
		exit;	
	}

	public function contact_activity($postData = array(), $type, $id)
	{
		$data['scontent']['contacts_id'] = $id;
		$contacts						 = $this->home_model->getcontactsDataByID($data['scontent']);
		$dataContactsql 				 = "select * from tender_contact where cont_id = ".$id;
		$dataContact 					 = executeSqlQuery($dataContactsql,'row_array');

		$tda_activity_details			 = ''; 

		if($type === TENDER_ACTIVITY_UPDATE)
		{
			if($postData['cont_type'] !== $dataContact['cont_type'])
			{
				$gen_name 				= 'Contact Type';
				$previous_value 		= get_gen_name($dataContact['cont_type'],'tender_contact_type');
				$new_value 				= get_gen_name($postData['cont_type'],'tender_contact_type');
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";

			}
			if($postData['cont_sal'] !== $dataContact['cont_sal'])
			{
				$gen_name 				= 'Salutation';
				$previous_value 		= get_gen_name($dataContact['cont_sal'],'tender_salutation');
				$new_value 				= get_gen_name($postData['cont_sal'],'tender_salutation');
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";
			}
			if($postData['cont_firstname'] !== $dataContact['cont_firstname'])
			{
				$gen_name 				='First Name';
				$previous_value 		= $dataContact['cont_firstname'];
				$new_value 				= $postData['cont_firstname'];
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";

			}
			if($postData['cont_lastname'] !== $dataContact['cont_lastname'])
			{
				$gen_name 				= 'Last Name';
				$previous_value 		= $dataContact['cont_lastname'];
				$new_value 				= $postData['cont_lastname'];
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";
			}
			if($postData['cont_primaryemail'] !== $dataContact['cont_primaryemail'])
			{
				$gen_name 				= 'Primary Email ID';
				$previous_value 		= $dataContact['cont_primaryemail'];
				$new_value 				= $postData['cont_primaryemail'];
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";
			}
			if($postData['cont_secondaryemail'] !== $dataContact['cont_secondaryemail'])
			{
				$gen_name 				= 'Secondary Email ID';
				$previous_value 		= $dataContact['cont_secondaryemail'];
				$new_value 				= $postData['cont_secondaryemail'];
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";
			}
			if($postData['cont_mobilephone'] !== $dataContact['cont_mobilephone'])
			{
				$gen_name 				= 'Mobile Number';
				$previous_value 		= $dataContact['cont_mobilephone'];
				$new_value 				= $postData['cont_mobilephone'];
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";
			}
			if($postData['cont_altphone'] !== $dataContact['cont_altphone'])
			{
				$gen_name 				= 'Alternate number';
				$previous_value 		= $dataContact['cont_altphone'];
				$new_value 				= $postData['cont_altphone'];
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";
			}
			if($postData['cont_leadsource'] !== $dataContact['cont_leadsource'])
			{
				$gen_name 				= 'Lead Source';
				$previous_value 		= get_gen_name($dataContact['cont_leadsource'],'tender_lead_source');
				$new_value 				= get_gen_name($postData['cont_leadsource'],'tender_lead_source');
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";
			}
			if($postData['cont_orgid'] !== $dataContact['cont_orgid'])
			{
				$gen_name 				= 'Organisation';
				$previous_value 		= field_data('org_name','tender_organisation', $dataContact['cont_orgid']);
				$new_value 				= field_data('org_name','tender_organisation', $dataContact['cont_orgid']);
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";
			}
			if($postData['cont_department'] !== $dataContact['cont_department'])
			{
				$gen_name 				= 'Department';
				$previous_value 		= $dataContact['cont_department'];
				$new_value 				= $postData['cont_department'];
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";
			}
			if($postData['cont_comment'] !== $dataContact['cont_comment'])
			{
				$gen_name 				= 'Comment';
				$previous_value 		= $dataContact['cont_comment'];
				$new_value 				= $postData['cont_comment'];
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";
			}
			if($postData['cont_desc'] !== $dataContact['cont_desc'])
			{
				$gen_name 				= 'Description';
				$previous_value 		= $dataContact['cont_desc'];
				$new_value 				= $postData['cont_desc'];
				$tda_activity_details	.= "<strong>".$gen_name.": </strong>".$previous_value."<b> to </b>".$new_value."<br>";
			}
			
			$tda_activity_details		.= "<br>";
			
		}

		$econtacts_id 					 			= $this->crm_auth->encrypt_openssl($id);
		
		$tda_activity_details						.= 'for <a href="'.base_url().'contacts-detail-'.$econtacts_id.'">'.$contacts['salutation'].$contacts['cont_name'].' </a>';

		$arrActivityData							= array();
		$arrActivityData['tda_activity'] 			= $type;
		$arrActivityData['tda_activity_details']	= $tda_activity_details;

		$arrActivityData['tda_type'] 				= TENDER_ACTIVITY_CONTACT;
		$arrActivityData['tda_prs_id'] 				= $this->session->userdata('prs_id');
		$arrActivityData['tda_date'] 				= date('Y-m-d H:i:s');

		insert('tender_activity',$arrActivityData);
	}
}