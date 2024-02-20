<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class Organisations extends CI_Controller {
	
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
		$this->organisationsList();
	}

/***********************************************************
			STANDARD FUNCTIONS
************************************************************/

	public function organisationsList()
	{
		$data['title']					= "Organisations";

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 		= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 		= array('Organisations');
		$data['breadcrumb']        		= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['dataTableData'] 			= $this->home_model->getAllOrganisations(TABLE_COUNT);

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('organisations/organisations_list',$data);
	}

	public function organisationsDataTablelist()
	{
		$dataOptn 					= $this->input->get();
	    $dataTableData 				= $this->home_model->getAllOrganisations(TABLE_RESULT,$dataOptn);
	      // ******** Encrypt Data from multidimensional array ******//
	    $enc_arr['id']    			= 'id_encrypt';
	   /* $enc_arr['organisation_id'] = 'organisation_id_encrypt';*/
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

	public function organisationsDetail($organisations_id = '')
	{
		$organisations_id 					= $this->crm_auth->decrypt_openssl($organisations_id);
		$data = array();
		$data['organisations_id']  			= $organisations_id;
		$data['organisations'] 				= $this->home_model->getorganisationsDataByID($data);

		$data['dataTableData'] 				= $this->home_model->getAllContacts(TABLE_COUNT);

		$data['ctrl']  						= "Detail";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Organisations', base_url('organisations'));
		$data['breadcrumb_data'][] 			= array('Organisations Detail');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']					= array();
		$data['scontent']['organisations_id'] 	= $organisations_id;
		$data['title']						= $data['organisations']['org_name'];
		
		$this->load->view('organisations/organisations_detail',$data);
	}
	
	public function add_organisations()
	{
		$data 									= array();
		$validation_config 						= array(
				  array(
                     'field'   => 'org_name', 
                     'label'   => 'Organisations name', 
                     'rules'   => 'trim|required'
                  ),
            );

		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 			= global_asset_version();
		$data['ci_asset_versn'] 				= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title									= 'Add Organisations';
		$data['ctrler']							= 'Organisations';
		$data['title']							= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 				= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 				= array('Organisations', base_url('organisations'));
		$data['breadcrumb_data'][] 				= array('Add Organisations');
		$data['breadcrumb']        				= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['scontent']						= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('organisations/add_organisations',$data);
		}
		else
		{
			$this->db->trans_start();
			
			$arrAccountData['org_name'] 			= trim($this->input->post('org_name'));
			$arrAccountData['org_primaryemail'] 	= trim($this->input->post('org_primaryemail'));
			$arrAccountData['org_secondaryemail'] 	= trim($this->input->post('org_secondaryemail'));
			$arrAccountData['org_tertiaryemail'] 	= trim($this->input->post('org_tertiaryemail'));
			$arrAccountData['org_primaryphone'] 	= trim($this->input->post('org_primaryphone'));
			$arrAccountData['org_altphone'] 		= trim($this->input->post('org_altphone'));
			$arrAccountData['org_fax'] 				= trim($this->input->post('org_fax'));
			$arrAccountData['org_website'] 			= trim($this->input->post('org_website'));
			$arrAccountData['org_assignedto'] 		= trim($this->input->post('org_assignedto'));
			$arrAccountData['org_assignedid'] 		= trim($this->input->post('org_assignedid'));
			$arrAccountData['org_industry'] 		= trim($this->input->post('org_industry'));
			$arrAccountData['org_cst'] 				= trim($this->input->post('org_cst'));
			$arrAccountData['org_vat'] 				= trim($this->input->post('org_vat'));
			$arrAccountData['org_billingadd'] 		= trim($this->input->post('org_billingadd'));
			$arrAccountData['org_billingpob'] 		= trim($this->input->post('org_billingpob'));
			$arrAccountData['org_billingcity'] 		= trim($this->input->post('org_billingcity'));
			$arrAccountData['org_billingstate'] 	= trim($this->input->post('org_billingstate'));
			$arrAccountData['org_billingpoc'] 		= trim($this->input->post('org_billingpoc'));
			$arrAccountData['org_billingcountry'] 	= trim($this->input->post('org_billingcountry'));
			$arrAccountData['org_shippingadd'] 		= trim($this->input->post('org_shippingadd'));
			$arrAccountData['org_shippingpob'] 		= trim($this->input->post('org_shippingpob'));
			$arrAccountData['org_shippingcity'] 	= trim($this->input->post('org_shippingcity'));
			$arrAccountData['org_shippingstate'] 	= trim($this->input->post('org_shippingstate'));
			$arrAccountData['org_shippingpoc'] 		= trim($this->input->post('org_shippingpoc'));
			$arrAccountData['org_shippingcountry'] 	= trim($this->input->post('org_shippingcountry'));
			$arrAccountData['org_desc'] 			= trim($this->input->post('org_desc'));
			$arrAccountData['org_comment'] 			= trim($this->input->post('org_comment'));

			$arrAccountData['status'] 				= STATUS_ACTIVE;
			$arrAccountData['created_by'] 			= $this->session->userdata('prs_id');
			$arrAccountData['created_dt'] 			= date('Y-m-d H:i:s');

			$organisations_id	= insert('tender_organisation',$arrAccountData);
			$this->db->trans_complete();

			//********* TRACK USER Activity *********//
			$this->organisation_activity($arrAccountData,TENDER_ACTIVITY_CREATE, $organisations_id);
			//********* TRACK USER Activity *********//
			
			$organisations_id 	= $this->crm_auth->encrypt_openssl($organisations_id);
			$this->session->set_flashdata('success', 'Organisations added successfully');
			redirect(site_url('organisations-detail-'.$organisations_id));
			exit;
		}
	}
	
	public function edit_organisations($organisations_id = '')
	{
		$organisations_id 		= $this->crm_auth->decrypt_openssl($organisations_id);
		$data 					= array();

		$validation_config 		= array(
				  array(
                     'field'   => 'org_name', 
                     'label'   => 'Organisations name', 
                     'rules'   => 'trim|required'
                  )
            );
		$this->form_validation->set_rules($validation_config);
		
	
		$data['global_asset_version'] 				= global_asset_version();
		$data['ci_asset_versn'] 					= ci_asset_versn();
		$data['scontent']['organisations_id'] 		= $organisations_id;
		$data['organisations'] 						= $this->home_model->getorganisationsDataByID($data['scontent']);
		$data['organisations_id'] 					= $organisations_id;
		$eorganisations_id 							= $this->crm_auth->encrypt_openssl($organisations_id);
		
		
		// automatically push current page to last record of breadcrumb
		$title							= 'Edit Organisations';
		$data['ctrler']					= 'Organisations';
		$data['title']					= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 		= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 		= array('Organisations', base_url('organisations'));
		$data['breadcrumb_data'][] 		= array($data['organisations']['org_name'].' Details', base_url('organisations-detail-'.$eorganisations_id));
		$data['breadcrumb_data'][] 		= array('Edit Organisations');
		$data['breadcrumb']        		= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('organisations/edit_organisations',$data);
		}
		else
		{
				
			$organisations_id 						= trim($this->input->post('org_id'));
			$arrAccountData['org_name'] 			= trim($this->input->post('org_name'));
			$arrAccountData['org_primaryemail'] 	= trim($this->input->post('org_primaryemail'));
			$arrAccountData['org_secondaryemail'] 	= trim($this->input->post('org_secondaryemail'));
			$arrAccountData['org_tertiaryemail'] 	= trim($this->input->post('org_tertiaryemail'));
			$arrAccountData['org_primaryphone'] 	= trim($this->input->post('org_primaryphone'));
			$arrAccountData['org_altphone'] 		= trim($this->input->post('org_altphone'));
			$arrAccountData['org_fax'] 				= trim($this->input->post('org_fax'));
			$arrAccountData['org_website'] 			= trim($this->input->post('org_website'));
			$arrAccountData['org_assignedto'] 		= trim($this->input->post('org_assignedto'));
			$arrAccountData['org_assignedid'] 		= trim($this->input->post('org_assignedid'));
			$arrAccountData['org_industry'] 		= trim($this->input->post('org_industry'));
			$arrAccountData['org_cst'] 				= trim($this->input->post('org_cst'));
			$arrAccountData['org_vat'] 				= trim($this->input->post('org_vat'));
			$arrAccountData['org_billingadd'] 		= trim($this->input->post('org_billingadd'));
			$arrAccountData['org_billingpob'] 		= trim($this->input->post('org_billingpob'));
			$arrAccountData['org_billingcity'] 		= trim($this->input->post('org_billingcity'));
			$arrAccountData['org_billingstate'] 	= trim($this->input->post('org_billingstate'));
			$arrAccountData['org_billingpoc'] 		= trim($this->input->post('org_billingpoc'));
			$arrAccountData['org_billingcountry'] 	= trim($this->input->post('org_billingcountry'));
			$arrAccountData['org_shippingadd'] 		= trim($this->input->post('org_shippingadd'));
			$arrAccountData['org_shippingpob'] 		= trim($this->input->post('org_shippingpob'));
			$arrAccountData['org_shippingcity'] 	= trim($this->input->post('org_shippingcity'));
			$arrAccountData['org_shippingstate'] 	= trim($this->input->post('org_shippingstate'));
			$arrAccountData['org_shippingpoc'] 		= trim($this->input->post('org_shippingpoc'));
			$arrAccountData['org_shippingcountry'] 	= trim($this->input->post('org_shippingcountry'));
			$arrAccountData['org_desc'] 			= trim($this->input->post('org_desc'));
			$arrAccountData['org_comment'] 			= trim($this->input->post('org_comment'));

			$arrAccountData['status'] 				= STATUS_ACTIVE;
			$arrAccountData['updated_by'] 			= $this->session->userdata('prs_id');
			$arrAccountData['updated_dt'] 			= date('Y-m-d H:i:s');


			//********* TRACK USER Activity *********//
			$this->organisation_activity($arrAccountData,TENDER_ACTIVITY_UPDATE, $organisations_id);
			//********* TRACK USER Activity *********//
			
			$organisation_id  = update('org_id', $organisations_id, $arrAccountData, 'tender_organisation');

			$organisations_id = $this->crm_auth->encrypt_openssl($organisations_id);
			
			echo json_encode(array('success'=>true,"message"=>"Organisations updated successfully","linkn"=>base_url()."organisations-detail-".$organisations_id));
		}
	}

/***********************************************************
			ADDTIONAL FUNCTIONS
************************************************************/	

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
	
	public function checkorganisationsAvailability()
	{
		$id 			= $this->input->post('org_id');
		$organisations 	= $this->input->post('org_name');
		$result 		= $this->home_model->validateOrganistaionData('org_name',$organisations,$id);

		if($result == 1){
			
			$status = true;
		}
		else
		{
			$status = $organisations." is already exist.Please try another one.";
		}

		echo json_encode($status);
		exit;	
	}

	public function checkorganisationsEmailAvailability()
	{
		$id 			= $this->input->post('org_id');
		$organisations 	= $this->input->post('org_primaryemail');
		$result 		= $this->home_model->validateOrganistaionData('org_primaryemail',$organisations,$id);
		
		if($result == 1){
			
			$status = true;
		}
		else
		{
			$status = $organisations." is already exist.Please try another one.";
		}
		echo json_encode($status);
		exit;	
	}

	public function organisations_active()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		    status_to_update($chkId,'org_id','tender_organisation',STATUS_ACTIVE);
		}
			$success = true;
			$message = 'Organisations Updated successfully';
			$linkn   =  base_url('organisations');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function organisations_deactive()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		    status_to_update($chkId,'org_id','tender_organisation',STATUS_INACTIVE);
		}
			$success = true;
			$message = 'Organisations Updated successfully';
			$linkn   =  base_url('organisations');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}
	 
  	public function organisation_activity($postData = array(), $type, $id)
	{
		$data['scontent']['organisations_id'] 	= $id;
		$organisations 							= $this->home_model->getorganisationsDataByID($data['scontent']);
		$dataOrgsql 				 			= "select * from tender_organisation where org_id = ".$id;
		$dataOrg 								= executeSqlQuery($dataOrgsql,'row_array');

		$tda_activity_details			 		= ''; 

		if($type === TENDER_ACTIVITY_UPDATE)
		{
			if($postData['org_name'] !== $dataOrg['org_name'])
			{
				$gen_name 				='Name';
				$previous_value 		= $dataOrg['org_name'];
				$new_value 				= $postData['org_name'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";

			}
			if($postData['org_primaryemail'] !== $dataOrg['org_primaryemail'])
			{
				$gen_name 				= 'Primary Email ID';
				$previous_value 		= $dataOrg['org_primaryemail'];
				$new_value 				= $postData['org_primaryemail'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if($postData['org_secondaryemail'] !== $dataOrg['org_secondaryemail'])
			{
				$gen_name 				= 'Secondary Email ID';
				$previous_value 		= $dataOrg['org_secondaryemail'];
				$new_value 				= $postData['org_secondaryemail'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if($postData['org_tertiaryemail'] !== $dataOrg['org_tertiaryemail'])
			{
				$gen_name 				= 'Tertiary Email ID';
				$previous_value 		= $dataOrg['org_tertiaryemail'];
				$new_value 				= $postData['org_tertiaryemail'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if($postData['org_primaryphone'] !== $dataOrg['org_primaryphone'])
			{
				$gen_name 				= 'Mobile Number';
				$previous_value 		= $dataOrg['org_primaryphone'];
				$new_value 				= $postData['org_primaryphone'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if($postData['org_altphone'] !== $dataOrg['org_altphone'])
			{
				$gen_name 				= 'Alternate number';
				$previous_value 		= $dataOrg['org_altphone'];
				$new_value 				= $postData['org_altphone'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if($postData['org_fax'] !== $dataOrg['org_fax'])
			{
				$gen_name 				= 'FAX';
				$previous_value 		= $dataOrg['org_fax'];
				$new_value 				= $postData['org_fax'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if($postData['org_website'] !== $dataOrg['org_website'])
			{
				$gen_name 				= 'Website';
				$previous_value 		= $dataOrg['org_website'];
				$new_value 				= $postData['org_website'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if($postData['org_vat'] !== $dataOrg['org_vat'])
			{
				$gen_name 				= 'VAT';
				$previous_value 		= $dataOrg['org_vat'];
				$new_value 				= $postData['org_vat'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if($postData['org_cst'] !== $dataOrg['org_cst'])
			{
				$gen_name 				= 'CST';
				$previous_value 		= $dataOrg['org_cst'];
				$new_value 				= $postData['org_cst'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if(($postData['org_billingadd'] !== $dataOrg['org_billingadd']) || ($postData['org_billingpob'] !== $dataOrg['org_billingpob']) || ($postData['org_billingcity'] !== $dataOrg['org_billingcity']) || ($postData['org_billingstate'] !== $dataOrg['org_billingstate']) || ($postData['org_billingpoc'] !== $dataOrg['org_billingpoc']) || ($postData['org_billingcountry'] !== $dataOrg['org_billingcountry']))
			{
				$gen_name 				= 'Billing Address';
				$billing 				= '';
				$billing1 				= '';

				if(isset($dataOrg['org_billingadd']) && !empty($dataOrg['org_billingadd']) && $dataOrg['org_billingadd'] !='')
				{
					$billing_address				= (!empty($dataOrg['org_billingadd']))?'&nbsp;&nbsp;Address: '.$dataOrg['org_billingadd']:" ";
					$billing_pob					= (!empty($dataOrg['org_billingpob']))?',&nbsp;P.O. Box : '.$dataOrg['org_billingpob']:" ";
					$billing_city					= (!empty($dataOrg['org_billingcity']))?', ,&nbsp;'.$dataOrg['org_billingcity']:" ";
					$billing_state					= (!empty($dataOrg['org_billingstate']))?',&nbsp;'.$dataOrg['org_billingstate']:" ";
					$billing_country				= (!empty($dataOrg['billingcountry']))?', '.field_data('tcv_country', 'tender_country_vol', $dataOrg['billingcountry']):" ";
					$billing_poc					= (!empty($dataOrg['org_billingpoc']))?' - '.$dataOrg['org_billingpoc']:" ";
					$billing 						.= $billing_address.$billing_pob.$billing_city.$billing_state.$billing_country.$billing_poc;
				}


				if(isset($postData['org_billingadd']) && !empty($postData['org_billingadd']) && $postData['org_billingadd'] !='')
				{
					$billing_address1				= (!empty($postData['org_billingadd']))?'&nbsp;&nbsp;Address: '.$postData['org_billingadd']:" ";
					$billing_pob1					= (!empty($postData['org_billingpob']))?',&nbsp;P.O. Box : '.$postData['org_billingpob']:" ";
					$billing_city1					= (!empty($postData['org_billingcity']))?',&nbsp;'.$postData['org_billingcity']:" ";
					$billing_state1					= (!empty($postData['org_billingstate']))?',&nbsp;'.$postData['org_billingstate']:" ";
					$billing_country1				= (!empty($postData['billingcountry']))?', '.field_data('tcv_country', 'tender_country_vol', $postData['billingcountry']):" ";
					$billing_poc1					= (!empty($postData['org_billingpoc']))?' - '.$postData['org_billingpoc']:" ";
					$billing1 						.= $billing_address1.$billing_pob1.$billing_city1.$billing_state1.$billing_country1.$billing_poc1;
				}
				


				$previous_value 		= $billing;
				$new_value 				= $billing1;
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if(($postData['org_shippingadd'] !== $dataOrg['org_shippingadd']) || ($postData['org_shippingpob'] !== $dataOrg['org_shippingpob']) || ($postData['org_shippingcity'] !== $dataOrg['org_shippingcity']) || ($postData['org_shippingstate'] !== $dataOrg['org_shippingstate']) || ($postData['org_shippingpoc'] !== $dataOrg['org_shippingpoc']) || ($postData['org_shippingcountry'] !== $dataOrg['org_shippingcountry']))
			{
				$gen_name 				= 'Shipping Address';

				$shipping_address				= (!empty($dataOrg['org_shippingadd']))?'&nbsp;&nbsp;Address: '.$dataOrg['org_shippingadd']:" ";
				$shipping_pob					= (!empty($dataOrg['org_shippingpob']))?',&nbsp;P.O. Box : '.$dataOrg['org_shippingpob']:" ";
				$shipping_city					= (!empty($dataOrg['org_shippingcity']))?', ,&nbsp;'.$dataOrg['org_shippingcity']:" ";
				$shipping_state					= (!empty($dataOrg['org_shippingstate']))?',&nbsp;'.$dataOrg['org_shippingstate']:" ";
				$shipping_country				= (!empty($dataOrg['shippingcountry']))?', '.field_data('tcv_country', 'tender_country_vol', $dataOrg['shippingcountry']):" ";
				$shipping_poc					= (!empty($dataOrg['org_shippingpoc']))?' - '.$dataOrg['org_shippingpoc']:" ";
				$shipping 						= $shipping_address.$shipping_pob.$shipping_city.$shipping_state.$shipping_country.$shipping_poc;

				$shipping_address1				= (!empty($postData['org_shippingadd']))?'&nbsp;&nbsp;Address: '.$postData['org_shippingadd']:" ";
				$shipping_pob1					= (!empty($postData['org_shippingpob']))?',&nbsp;P.O. Box : '.$postData['org_shippingpob']:" ";
				$shipping_city1					= (!empty($postData['org_shippingcity']))?', ,&nbsp;'.$postData['org_shippingcity']:" ";
				$shipping_state1					= (!empty($postData['org_shippingstate']))?',&nbsp;'.$postData['org_shippingstate']:" ";
				$shipping_country1				= (!empty($postData['shippingcountry']))?', '.field_data('tcv_country', 'tender_country_vol', $postData['shippingcountry']):" ";
				$shipping_poc1					= (!empty($postData['org_shippingpoc']))?' - '.$postData['org_shippingpoc']:" ";
				$shipping1 						= $shipping_address1.$shipping_pob1.$shipping_city1.$shipping_state1.$shipping_country1.$shipping_poc1;


				$previous_value 		= $shipping;
				$new_value 				= $shipping1;
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if($postData['org_industry'] !== $dataOrg['org_industry'])
			{
				$gen_name 				= 'Industry';
				$previous_value 		= get_gen_name($dataOrg['org_industry'],'tender_industry');
				$new_value 				= get_gen_name($postData['org_industry'],'tender_industry');
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if($postData['org_comment'] !== $dataOrg['org_comment'])
			{
				$gen_name 				= 'Comment';
				$previous_value 		= $dataOrg['org_comment'];
				$new_value 				= $postData['org_comment'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			if($postData['org_desc'] !== $dataOrg['org_desc'])
			{
				$gen_name 				= 'Description';
				$previous_value 		= $dataOrg['org_desc'];
				$new_value 				= $postData['org_desc'];
				$tda_activity_details	.= "<strong>".$gen_name.":</strong> ".$previous_value." <b> to </b>".$new_value."<br>";
			}
			
			$tda_activity_details	.= "<br>";
			
		}

		$eorg_id 					 				= $this->crm_auth->encrypt_openssl($id);

		$tda_activity_details					.= 'for <a target="_blank" href="'.base_url().'organisations-detail-'.$eorg_id.'">'.$organisations['org_name'].' </a>';
		$arrActivityData							= array();
		$arrActivityData['tda_activity'] 			= $type;
		$arrActivityData['tda_activity_details']	= $tda_activity_details;

		$arrActivityData['tda_type'] 				= TENDER_ACTIVITY_ORG;
		$arrActivityData['tda_prs_id'] 				= $this->session->userdata('prs_id');
		$arrActivityData['tda_date'] 				= date('Y-m-d H:i:s');

		insert('tender_activity',$arrActivityData);
	}

}