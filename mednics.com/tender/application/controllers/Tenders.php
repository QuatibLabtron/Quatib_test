<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tenders extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();

        $this->load->model('tender_model');
        
		if($this->session->userdata('prs_id') == '')
		{
			redirect('/login', 'refresh');
			exit;
		}
    }
	
	public function index()
	{
		$this->tendersList();
	}
/***********************************************************
			STANDARD FUNCTIONS
************************************************************/	
	public function tendersList()
	{
		$t               				=	date('d-m-Y');
		$day             				=	date("d",strtotime($t));
		$month           				=	date("m",strtotime($t));
		$arrBSNData['bpm_value'] 		=	$month.$day;
		

		update('bpm_name','custom_prefix_number',$arrBSNData,'tender_bsn_prm');

		$data['title']					= "Tenders";

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 		= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 		= array('Tenders');
		$data['breadcrumb']        		= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['dataTableData'] 			= $this->tender_model->getAllTenders(TABLE_COUNT);

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('tenders/tenders_list',$data);
	}

	public function tendersDataTablelist()
	{
		$dataOptn 					= $this->input->get();
	    $dataTableData 				= $this->tender_model->getAllTenders(TABLE_RESULT,$dataOptn);
	      // ******** Encrypt Data from multidimensional array ******//
	    $enc_arr['id']    			= 'id_encrypt';
	   /* $enc_arr['tender_id'] 	= 'tender_id_encrypt';*/
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

	public function tendersDetail($tenders_id = '')
	{
		$tenders_id 						= $this->crm_auth->decrypt_openssl($tenders_id);
		$data = array();
		$data['tenders_id']  				= $tenders_id;
		
		$data['tenders'] 					= $this->tender_model->gettendersDataByID($data);
		$data['tender_product'] 			= $this->tender_model->gettendersProductDataByID($data);
		//echo "<pre>"; print_r($data['tender_product']);exit;
		
		$data['ctrl']  						= "Detail";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Tenders', base_url('tenders'));
		$data['breadcrumb_data'][] 			= array('Tenders Detail');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['scontent']					= array();
		$data['scontent']['tenders_id'] 	= $tenders_id;
		$data['title']						= $data['tenders']['tdr_subject'];

		$this->load->view('tenders/tenders_detail',$data);
	}
	
	public function add_tenders()
	{
		
		$data 									= array();
		$validation_config 						= array(
				  array(
                     'field'   => 'tdr_contacts', 
                     'label'   => 'Tenders Contact', 
                     'rules'   => 'trim|required'
                  ),
                  array(
                     'field'   => 'tdr_name', 
                     'label'   => 'Tenders Name', 
                     'rules'   => 'trim|required'
                  ),
            );

		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 			= global_asset_version();
		$data['ci_asset_versn'] 				= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title									= 'Add Tenders';
		$data['ctrler']							= 'Tenders';
		$data['title']							= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 				= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 				= array('Tenders', base_url('tenders'));
		$data['breadcrumb_data'][] 				= array('Add Tenders');
		$data['breadcrumb']        				= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$person_id 								= $this->session->userdata('prs_id');
		$data['terms_n_condition'] 				= field_data('prs_tnc','tender_person', $person_id);

		$data['scontent']						= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('tenders/add_tenders',$data);
		}
		else
		{

			/**** INSERTING TENDER DETAILS START ****/

			$this->db->trans_start();   
				$reference 							= 	generate_reference_id();
				$reference_id 						= 	$reference['reference'];
				$arrBSNData['bpm_value'] 			= 	$reference['number_seq'];



				update('bpm_name','custom_start_sequence',$arrBSNData, 'tender_bsn_prm');

				$arrAccountData['tdr_refid'] 			= $reference_id;

				$arrAccountData['tdr_name'] 			= trim($this->input->post('tdr_name'));
				$arrAccountData['tdr_organisationid'] 	= trim($this->input->post('tdr_organisationid'));
				$arrAccountData['tdr_contacts'] 		= trim($this->input->post('tdr_contacts'));
				$arrAccountData['tdr_subject'] 			= trim($this->input->post('tdr_subject'));
				$arrAccountData['tdr_tnc'] 				= trim($this->input->post('tdr_tnc'));
				$arrAccountData['tdr_addinfo'] 			= trim($this->input->post('tdr_addinfo'));
				/*$arrAccountData['tdr_desc'] 			= trim($this->input->post('tdr_desc'));*/
				$arrAccountData['tdr_currency'] 		= trim($this->input->post('tdr_currency'));

				$arrAccountData['tdr_item_total'] 		= trim($this->input->post('tdr_item_total'));
				$arrAccountData['tdr_discount'] 		= trim($this->input->post('tdr_discount'));
				$arrAccountData['tdr_discount_percent'] = trim($this->input->post('tdr_discount_percent'));
				$arrAccountData['tdr_discounttype'] 	= trim($this->input->post('tdr_discounttype'));
				
				$arrAccountData['tdr_shipping_charges'] = trim($this->input->post('tdr_shipping_charges'));
				$arrAccountData['tdr_bank_charges'] 	= trim($this->input->post('tdr_bank_charges'));

				$arrAccountData['tdr_pretax_total'] 	= trim($this->input->post('tdr_pretax_total'));
				$arrAccountData['tdr_tax'] 				= trim($this->input->post('tdr_tax'));
				$arrAccountData['tdr_tax_shipping_charges'] = trim($this->input->post('tdr_tax_shipping_charges'));

				$arrAccountData['tdr_adjustment_type'] 	= trim($this->input->post('tdr_adjustment_type'));
				$arrAccountData['tdr_adjustment'] 		= trim($this->input->post('tdr_adjustment'));

				$arrAccountData['tdr_grandtotal'] 		= trim($this->input->post('tdr_grandtotal'));
				$arrAccountData['tdr_comment'] 			= trim($this->input->post('tdr_comment'));
				//$arrAccountData['tdr_inv_data'] 		= trim($this->input->post('tdr_inv_data'));

				$arrAccountData['status'] 				= STATUS_ACTIVE;
				$arrAccountData['created_by'] 			= $this->session->userdata('prs_id');
				$arrAccountData['updated_by'] 			= $this->session->userdata('prs_id');
				$arrAccountData['created_dt'] 			= date('Y-m-d H:i:s');
				$arrAccountData['updated_dt'] 			= date('Y-m-d H:i:s');

				$tenders_id	= insert('tender_detail',$arrAccountData);
				/**** INSERTING PRODUCTS START ****/
				$discount 		= 	0;
				$purordlist 	=	$this->input->post('purordlist');
				$venper 		= array();
				if (isset($purordlist[0]['tdp_prd_id']) && $purordlist[0]['tdp_prd_id'] != '') 
				{
					foreach($purordlist as $key=>$value)
					{
						$tdp_qty_disc 						= (isset($purordlist[$key]['tdp_qty_disc']))?$purordlist[$key]['tdp_qty_disc']:0;
						$tdp_indv_disc_direct 				= (isset($purordlist[$key]['tdp_indv_disc_direct']))?$purordlist[$key]['tdp_indv_disc_direct']:0;
						$tdp_indv_disc_percent 				= (isset($purordlist[$key]['tdp_indv_disc_percent']))?$purordlist[$key]['tdp_indv_disc_percent']:0;
						$tdp_discount_total_amt 			= (isset($purordlist[$key]['tdp_discount_total_amt']))?$purordlist[$key]['tdp_discount_total_amt']:0;
					
						$venper['tdp_prd_id'] 				= $purordlist[$key]['tdp_prd_id'];
						$venper['tdp_sku'] 					= $purordlist[$key]['tdp_sku'];
						$venper['tdp_name'] 				= $purordlist[$key]['tdp_name'];
						$venper['tdp_desc'] 				= $purordlist[$key]['tdp_desc'];
						$venper['tdp_quantity']				= $purordlist[$key]['tdp_quantity'];
						$venper['tdp_price'] 				= $purordlist[$key]['tdp_price'];
						$venper['tdp_spec_show'] 			= $purordlist[$key]['tdp_spec_show'];

						$venper['tdp_qty_disc']				= $tdp_qty_disc;
						$venper['tdp_indv_disc_direct']		= $tdp_indv_disc_direct;
						$venper['tdp_indv_disc_percent']	= $tdp_indv_disc_percent;
						$venper['tdp_discounttype']			= get_discoutn_type($tdp_qty_disc,$tdp_indv_disc_direct,$tdp_indv_disc_percent);
						$venper['tdp_discount_total_amt']	= $tdp_discount_total_amt;

						$venper['tdp_item_total']			= $purordlist[$key]['tdp_item_total'];
						$venper['tdp_tdr_refid']			= $reference_id;
						
						insert('tender_product',$venper);
						$discount 							+=	$tdp_discount_total_amt;
					}  
				}

				$arrDiscountData['tdr_discount_total_amt'] 	= 0;
				$arrAccountData['tdr_discount']				= 0;
				$discount1 = ((!empty($arrAccountData['tdr_adjustment'])) && $arrAccountData['tdr_adjustment_type'] == SUB_ADJUSTMENT_TYPE)?$arrAccountData['tdr_adjustment']:0;
				$arrDiscountData['tdr_discount_total_amt'] 	= $discount + $arrAccountData['tdr_discount'] + $discount1;

				update('tdr_id',$tenders_id,$arrDiscountData, 'tender_detail'); 

				/**** INSERTING PRODUCTS END ****/

				//********* TRACK USER Activity *********//
				$this->tender_activity(TENDER_ACTIVITY_CREATE, $tenders_id);
				//********* TRACK USER Activity *********//


			$this->db->trans_complete();

			/**** INSERTING TENDER DETAILS END ****/

			$tenders_id 	= $this->crm_auth->encrypt_openssl($tenders_id);
			$this->session->set_flashdata('success', 'Tenders added successfully');
			redirect(site_url('tenders-detail-'.$tenders_id));
			exit;
		}
	}
	
	public function edit_tenders($tenders_id = '')
	{
		
		$tenders_id 			= $this->crm_auth->decrypt_openssl($tenders_id);
		$data 					= array();

		$validation_config 		= array(
				  array(
                     'field'   => 'tdr_contacts', 
                     'label'   => 'Tenders Contact', 
                     'rules'   => 'trim|required'
                  ),
                  array(
                     'field'   => 'tdr_name', 
                     'label'   => 'Tenders Name', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);
		
	
		$data['global_asset_version'] 			= global_asset_version();
		$data['ci_asset_versn'] 				= ci_asset_versn();
		$data['scontent']['tenders_id'] 		= $tenders_id;
		$data['tenders'] 						= $this->tender_model->gettendersDataByID($data['scontent']);
		$tender_product							= $this->tender_model->gettendersProductEditDataByID($data['scontent']);
		$data['tender_total_product'] 			= count($this->tender_model->gettendersProductDataByID($data['scontent']));

		$data['tenders_id'] 					= $tenders_id;
		$etenders_id 							= $this->crm_auth->encrypt_openssl($tenders_id);
		
		$data['tender_product']					= 'null';
		if (isset($tender_product) && $tender_product != '')
		{
			$data['tender_product'] 	    	= json_encode($tender_product);
		}

		// automatically push current page to last record of breadcrumb
		$title							= 'Edit Tenders';
		$data['ctrler']					= 'Tenders';
		$data['title']					= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 		= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 		= array('Tenders', base_url('tenders'));
		$data['breadcrumb_data'][] 		= array($data['tenders']['tdr_name'].' Details', base_url('tenders-detail-'.$etenders_id));
		$data['breadcrumb_data'][] 		= array('Edit Tenders');
		$data['breadcrumb']        		= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('tenders/edit_tenders',$data);
		}
		else
		{
		/*	echo "<pre>";
			print_r($_POST);
			exit();*/

			/**** INSERTING TENDER DETAILS START ****/

			$this->db->trans_start();   
			
				$tenders_id 							= trim($this->input->post('tdr_id'));
				$tdr_refid 								= trim($this->input->post('tdr_refid'));
				$arrAccountData['tdr_refid'] 			= $tdr_refid;
				$arrAccountData['tdr_name'] 			= trim($this->input->post('tdr_name'));
				$arrAccountData['tdr_organisationid'] 	= trim($this->input->post('tdr_organisationid'));
				$arrAccountData['tdr_contacts'] 		= trim($this->input->post('tdr_contacts'));
				$arrAccountData['tdr_subject'] 			= trim($this->input->post('tdr_subject'));
				$arrAccountData['tdr_tnc'] 				= trim($this->input->post('tdr_tnc'));
				$arrAccountData['tdr_addinfo'] 			= trim($this->input->post('tdr_addinfo'));
				/*$arrAccountData['tdr_desc'] 			= trim($this->input->post('tdr_desc'));*/
				$arrAccountData['tdr_currency'] 		= trim($this->input->post('tdr_currency'));

				$arrAccountData['tdr_item_total'] 		= trim($this->input->post('tdr_item_total'));
				$arrAccountData['tdr_discount'] 		= trim($this->input->post('tdr_discount'));
				$arrAccountData['tdr_discount_percent'] = trim($this->input->post('tdr_discount_percent'));
				$arrAccountData['tdr_discounttype'] 	= trim($this->input->post('tdr_discounttype'));
				
				$arrAccountData['tdr_shipping_charges'] = trim($this->input->post('tdr_shipping_charges'));
				$arrAccountData['tdr_bank_charges'] 	= trim($this->input->post('tdr_bank_charges'));

				$arrAccountData['tdr_pretax_total'] 	= trim($this->input->post('tdr_pretax_total'));
				$arrAccountData['tdr_tax'] 				= trim($this->input->post('tdr_tax'));
				$arrAccountData['tdr_tax_shipping_charges'] = trim($this->input->post('tdr_tax_shipping_charges'));

				$arrAccountData['tdr_adjustment_type'] 	= trim($this->input->post('tdr_adjustment_type'));
				$arrAccountData['tdr_adjustment'] 		= trim($this->input->post('tdr_adjustment'));

				$arrAccountData['tdr_grandtotal'] 		= trim($this->input->post('tdr_grandtotal'));
				$arrAccountData['tdr_comment'] 			= trim($this->input->post('tdr_comment'));
				//$arrAccountData['tdr_inv_data'] 		= trim($this->input->post('tdr_inv_data'));
				

				$arrAccountData['tender_status'] 		= trim($this->input->post('tender_status'));
				$arrAccountData['status'] 				= STATUS_ACTIVE;
				$arrAccountData['updated_by'] 			= $this->session->userdata('prs_id');
				$arrAccountData['updated_dt'] 			= date('Y-m-d H:i:s');

				update('tdr_id', $tenders_id, $arrAccountData, 'tender_detail');


				/**** INSERTING PRODUCTS START ****/

				$discount 		= 0;
				$purordlist 	= $this->input->post('purordlist');
				$venper 		= array();
				$arrIDs 		= array();
				if (isset($purordlist[0]['tdp_prd_id']) && $purordlist[0]['tdp_prd_id'] != '') 
				{
					foreach($purordlist as $key=>$value)
					{
						$tdp_id 							= $purordlist[$key]['tdp_id'];

						$tdp_qty_disc 						= (isset($purordlist[$key]['tdp_qty_disc']))?$purordlist[$key]['tdp_qty_disc']:0;
						$tdp_indv_disc_direct 				= (isset($purordlist[$key]['tdp_indv_disc_direct']))?$purordlist[$key]['tdp_indv_disc_direct']:0;
						$tdp_indv_disc_percent 				= (isset($purordlist[$key]['tdp_indv_disc_percent']))?$purordlist[$key]['tdp_indv_disc_percent']:0;
						$tdp_discount_total_amt 			= (isset($purordlist[$key]['tdp_discount_total_amt']))?$purordlist[$key]['tdp_discount_total_amt']:0;
					
						$venper['tdp_prd_id'] 				= $purordlist[$key]['tdp_prd_id'];
						$venper['tdp_sku'] 					= $purordlist[$key]['tdp_sku'];
						$venper['tdp_name'] 				= $purordlist[$key]['tdp_name'];
						$venper['tdp_desc'] 				= $purordlist[$key]['tdp_desc'];
						$venper['tdp_quantity']				= $purordlist[$key]['tdp_quantity'];
						$venper['tdp_price'] 				= $purordlist[$key]['tdp_price'];
						$venper['tdp_spec_show'] 			= $purordlist[$key]['tdp_spec_show'];

						$venper['tdp_qty_disc']				= $tdp_qty_disc;
						$venper['tdp_indv_disc_direct']		= $tdp_indv_disc_direct;
						$venper['tdp_indv_disc_percent']	= $tdp_indv_disc_percent;
						$venper['tdp_discounttype']			= get_discoutn_type($tdp_qty_disc,$tdp_indv_disc_direct,$tdp_indv_disc_percent);
						$venper['tdp_discount_total_amt']	= $tdp_discount_total_amt;

						$venper['tdp_item_total']			= $purordlist[$key]['tdp_item_total'];
						$venper['tdp_tdr_refid']			= $tdr_refid;

						if(isset($tdp_id) && $tdp_id != '')
						{
							$tdp_ids = update('tdp_id',$tdp_id,$venper, 'tender_product'); 
						}
						else
						{
							$tdp_ids = insert('tender_product',$venper);
						}

						$arrIDs[] 	=  $tdp_ids;	
						
						$discount 							+=	$tdp_discount_total_amt;
					}  
					if(isset($arrIDs) && !empty($arrIDs))
					{
						$this->tender_model->delete_tender_product($arrIDs,$tdr_refid);
					}
				}

				

				$arrDiscountData['tdr_discount_total_amt'] 	= 0;
				$discount1 = ((!empty($arrAccountData['tdr_adjustment'])) && $arrAccountData['tdr_adjustment_type'] == SUB_ADJUSTMENT_TYPE)?$arrAccountData['tdr_adjustment']:0;
				$arrDiscountData['tdr_discount_total_amt'] 	= $discount + $arrAccountData['tdr_discount'] + $discount1;

				update('tdr_id',$tenders_id,$arrDiscountData, 'tender_detail'); 

				/**** INSERTING PRODUCTS END ****/

				//********* TRACK USER Activity *********//
				$this->tender_activity(TENDER_ACTIVITY_UPDATE, $tenders_id);
				//********* TRACK USER Activity *********//


			$this->db->trans_complete();

			/**** INSERTING TENDER DETAILS END ****/

			$tenders_id 	= $this->crm_auth->encrypt_openssl($tenders_id);
			$this->session->set_flashdata('success', 'Tenders updated successfully');
			redirect(site_url('tenders-detail-'.$tenders_id));
			exit;

		}
	}


/***********************************************************
			ADDTIONAL FUNCTIONS
************************************************************/		

	public function tendersInvoice($tenders_id = '')
	{
		$tenders_id 						= $this->crm_auth->decrypt_openssl($tenders_id);
		$data = array();
		$data['tenders_id']  				= $tenders_id;
		$data['tenders'] 					= $this->tender_model->gettendersDataByID($data);
		$data['tender_product'] 			= $this->tender_model->gettendersProductDataByID($data);
		
		$data['ctrl']  						= "Detail";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Tenders', base_url('tenders'));
		$data['breadcrumb_data'][] 			= array('Tenders Invoice');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']					= array();
		$data['scontent']['tenders_id'] 	= $tenders_id;
		$data['title']						= $data['tenders']['tdr_subject'];


		
		$this->load->view('tenders/tenders_invoice',$data);
	}
	
	public function checktendersAvailability()
	{
		$id 			= $this->input->post('tdr_id');
		$tenders 		= trim($this->input->post('tdr_name'));
		$result 		= $this->tender_model->validateTenderData('tdr_name',$tenders);
		

		if($result){
			$status = true;
		}
		else
		{
			$status = $tenders." is already taken.Please try another one.";
			
		}
		echo json_encode($status);
		exit;	
	}

	public function checktendersEmailAvailability()
	{
		$id 			= $this->input->post('tdr_id');
		$tenders 		= $this->input->post('tdr_primaryemail');
		$result 		= $this->tender_model->validateTenderData('tdr_primaryemail',$tenders);
		
		if($result){
			$status = true;
		}
		else
		{
			$status = $tenders." is already taken.Please try another one.";
			
		}
		echo json_encode($status);
		exit;	
	}

	public function add_organisation()
	{
		$person_id								= $this->session->userdata('prs_id');
		$arrAccountData['org_name'] 			= trim($this->input->post('org_name'));
		$arrAccountData['org_primaryemail'] 	= trim($this->input->post('org_primaryemail'));
		$arrAccountData['org_assignedto'] 		= field_data('prs_name', 'tender_person', $person_id);
		$arrAccountData['org_assignedid'] 		= $person_id;
		$arrAccountData['org_billingadd'] 		= trim($this->input->post('org_billingadd'));
		$arrAccountData['org_billingpob'] 		= trim($this->input->post('org_billingpob'));
		$arrAccountData['org_billingcity'] 		= trim($this->input->post('org_billingcity'));
		$arrAccountData['org_billingstate'] 	= trim($this->input->post('org_billingstate'));
		$arrAccountData['org_billingpoc'] 		= trim($this->input->post('org_billingpoc'));
		$arrAccountData['org_billingcountry'] 	= trim($this->input->post('org_billingcountry'));
		$arrAccountData['status'] 				= STATUS_ACTIVE;
		$arrAccountData['created_by'] 			= $this->session->userdata('prs_id');
		$arrAccountData['updated_by'] 			= $this->session->userdata('prs_id');
		$arrAccountData['created_dt'] 			= date('Y-m-d H:i:s');
		$arrAccountData['updated_dt'] 			= date('Y-m-d H:i:s');

		$organisations_id   					= insert('tender_organisation',$arrAccountData);
		if($organisations_id){
			
			echo json_encode(array('success'=>true,"message"=>"Organisations added successfully","name"=>$org_name,"id"=>$organisations_id));
			exit;
		}
		else
		{
			$status = false;
			$message = "Some error occured";
		}	
	}

	public function tenders_active()
	{
		$chkId 		= $this->input->post('chkId');

    	if($chkId)
		{
			status_to_update($chkId,'tdr_id','tender_detail',STATUS_ACTIVE);
		}
			$success = true;
			$message = 'Tenders Updated successfully';
			$linkn   =  base_url('tenders');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function tenders_deactive()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
			status_to_update($chkId,'tdr_id','tender_detail',STATUS_INACTIVE);
		}
			$success = true;
			$message = 'Tenders Updated successfully';
			$linkn   =  base_url('tenders');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function getOrganisationDropdown()
	{
		$search   			= $this->input->get('q');
		$OrganisationData 	= array('results'=>$this->tender_model->getOrganisationDropdown($search));
		echo json_encode($OrganisationData);
	}

	public function getContactDropdown($org_id)
	{
		$search   		= $this->input->get('q');
		$ContactData 	= array('results'=>$this->tender_model->getContactDropdown($search,$org_id));
		echo json_encode($ContactData);
	}

	public function getProductDropdown()
	{
		$search   		= $this->input->get('q');
		$ProductData 	= array('results'=>$this->tender_model->getProductDropdown($search));
		echo json_encode($ProductData);
	}
	  
	public function add_new_organisation()
	{
			$arrAccountData['org_name'] 			= trim($this->input->post('org_name'));
			$arrAccountData['org_primaryemail'] 	= trim($this->input->post('org_primaryemail'));
			$arrAccountData['org_billingadd'] 		= trim($this->input->post('org_billingadd'));
			$arrAccountData['org_billingpob'] 		= trim($this->input->post('org_billingpob'));
			$arrAccountData['org_billingcity'] 		= trim($this->input->post('org_billingcity'));
			$arrAccountData['org_billingstate'] 	= trim($this->input->post('org_billingstate'));
			$arrAccountData['org_billingpoc'] 		= trim($this->input->post('org_billingpoc'));
			$arrAccountData['org_billingcountry'] 	= trim($this->input->post('org_billingcountry'));
			$arrAccountData['org_assignedid'] 		= $this->session->userdata('prs_id');
			$arrAccountData['org_assignedto'] 		= field_data('prs_name', 'tender_person', $arrAccountData['org_assignedid']);

			$arrAccountData['status'] 			= STATUS_ACTIVE;
			$arrAccountData['created_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['updated_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['created_dt'] 		= date('Y-m-d H:i:s');
			$arrAccountData['updated_dt'] 		= date('Y-m-d H:i:s');

			$organisations_id	= insert('tender_organisation', $arrAccountData);


			if($organisations_id)
			{
				
				$response = array(
					'success' => true,
					'message' => 'Organisation Added successfully',
					'id' => $organisations_id
				);
				echo json_encode($response);
			}
			else
			{
				$response = array(
					'success' => false,
					'message' => 'Error in Adding Organisation'
				);
				echo json_encode($response);
			}
	}

	public function add_new_contact()
	{
		$organisation_id 						= trim($this->input->post('cont_orgid'));
		$arrAccountData['cont_type'] 			= NORMAL_TENDER_CONTACT_TYPE;
		$arrAccountData['cont_sal'] 			= trim($this->input->post('cont_sal'));
		$arrAccountData['cont_firstname'] 		= trim($this->input->post('cont_firstname'));
		$arrAccountData['cont_lastname'] 		= trim($this->input->post('cont_lastname'));
		$arrAccountData['cont_orgid'] 			= ($organisation_id != '' && isset($organisation_id))?$organisation_id:ORGANISATION_INDIVIDUAL_ID;
		$arrAccountData['cont_primaryemail'] 	= trim($this->input->post('cont_primaryemail'));

		$arrAccountData['cont_assignedid'] 		= $this->session->userdata('prs_id');
		$arrAccountData['cont_assignedto'] 		= field_data('prs_name', 'tender_person', $arrAccountData['cont_assignedid']);

		$arrAccountData['status'] 				= STATUS_ACTIVE;
		$arrAccountData['created_by'] 			= $this->session->userdata('prs_id');
		$arrAccountData['updated_by'] 			= $this->session->userdata('prs_id');
		$arrAccountData['created_dt'] 			= date('Y-m-d H:i:s');
		$arrAccountData['updated_dt'] 			= date('Y-m-d H:i:s');

		$contacts_id							= insert('tender_contact', $arrAccountData);


		if ($contacts_id)
		{
			
			$response = array(
				'success' => true,
				'message' => 'Contact Added successfully',
				'id' => $contacts_id
			);
			echo json_encode($response);
		}
		else
		{
			$response = array(
				'success' => false,
				'message' => 'Error in Adding Contact'
			);
			echo json_encode($response);
		}
	}

	public function get_voltage_details()
	{
		$org_id = $this->input->post('org_id');

		$VoltageData 	= $this->tender_model->get_voltage_details($org_id);

		$response = array(
					'success' 	=> true,
					'country' 	=> $VoltageData['tcv_country'],
					'voltage' 	=> $VoltageData['tcv_voltage'],
					'frequency' => $VoltageData['tcv_frquency'],
					'plug_type' => $VoltageData['tcv_plug_type']
				);
		echo json_encode($response);
	}

	public function get_product_details()
	{
		$prd_id = $this->input->post('prd_id');


		$ProductData 	= $this->tender_model->get_product_details($prd_id);


		$specifications = specification_html_helper($ProductData['specifications']);
		
		$response = array(
					'success' 	=> true,
					'tdp_desc' 	=> $specifications,
					'tdp_sku' 	=> $ProductData['sku'],
					'tdp_price' => $ProductData['price'],
					'tdp_name' 	=> $ProductData['name']
				);


		echo json_encode($response);
	}

	public function get_product_desc()
	{
		$prd_id = $this->input->post('prd_id');

		$PrdData 		= detail_data('tdp_desc,tdp_prd_id', 'tender_product', 'tdp_id ='.$prd_id);
		$specifications = $PrdData['tdp_desc'];
		$product_id 	= $PrdData['tdp_prd_id'];

		$response = array(
					'success' 	=> true,
					'tdp_desc' 	=> $specifications,
					'tdp_prd_id'=> $product_id,
				);

		echo json_encode($response);
	}

	public function get_quantity_discount()
	{
		$prd_sku 		= $this->input->post('prd_sku');
		$prd_qty 		= $this->input->post('prd_qty');
		$ProductData 	= $this->tender_model->get_quantity_discount($prd_sku,$prd_qty);

		if(isset($ProductData['final_inr']) && $ProductData['final_inr'] !='' && !empty($ProductData['final_inr']))
		{
			$product_discount_price  = 0;
			$product_price = $ProductData['final_inr'] * $prd_qty;

			switch (true) {
				  case ($prd_qty >= 5 && $prd_qty < 10):
				    $price = calculate_percent($ProductData['prl_5to10'],$product_price);
					$product_discount_price = $price;
				  break;
				  case($prd_qty >= 10 && $prd_qty < 25):
				   		$price = calculate_percent($ProductData['prl_10to25'],$product_price);
						$product_discount_price = $price;	
				  break;
				   case($prd_qty >= 25 && $prd_qty < 50):
				   		$price = calculate_percent($ProductData['prl_25to50'],$product_price);
						$product_discount_price = $price;	
				  break;

				   case($prd_qty >= 50 && $prd_qty < 80):
				   		$price = calculate_percent($ProductData['prl_50to80'],$product_price);
						$product_discount_price = $price;		
				  break;
				  case($prd_qty >= 80 && $prd_qty < 120):
				   		$price = calculate_percent($ProductData['prl_80to120'],$product_price);
						$product_discount_price = $price;
				  break;

				  default:
				    $product_discount_price  = 0;
				}
		}
		
		

		$response = array(
					'success' 			=> true,
					'tdp_qty_disc' 		=> $product_discount_price,
				);

		echo json_encode($response);
	}
	  
	public function generate_pdf($tenders_id,$type)
	{
		
		/***********************************************************
					Tender Data
		************************************************************/
		$etenders_id					= $tenders_id;
		$tenders_id 					= $this->crm_auth->decrypt_openssl($tenders_id);


		$data = array();
		$Orgdat = array();
		$data['tenders_id']  			= $tenders_id;
		$tenders 						= $this->tender_model->gettendersDataByID($data);
		$tender_product 				= $this->tender_model->gettendersProductDataByID($data);
		$Orgdata['organisations_id']  	= $tenders['tdr_organisationid'];
		$organisations 					= $this->home_model->getorganisationsDataByID($Orgdata);
		$date_time 						= date('Y-m-d H:i:s');


		$tender_reference 				= $tenders['tdr_refid'];
		$tender_name 					= $tenders['tdr_name'];
		$tender_subject 				= $tenders['tdr_subject'];
		$tender_data					= '';
		$date_today 					= date('d,M Y');
		$curreny 						= get_gen_name($tenders['tdr_currency'],TENDER_PRICE_TYPE);
		$orgn_name 						= (!empty($organisations['org_name']) && $organisations['org_name'] != 'Individual')?'&nbsp;&nbsp;<strong>'.$organisations['org_name'].'</strong><br>':" ";
		$billing_address				= (!empty($organisations['org_billingadd']))?'&nbsp;&nbsp;'.$organisations['org_billingadd']:" ";
		$billing_pob					= (!empty($organisations['org_billingpob']))?'<br>&nbsp;&nbsp;&nbsp;P.O. Box : '.$organisations['org_billingpob']:" ";
		$billing_city					= (!empty($organisations['org_billingcity']))?', <br>&nbsp;&nbsp;&nbsp;'.$organisations['org_billingcity']:" ";
		$billing_state					= (!empty($organisations['org_billingstate']))?'<br>&nbsp;&nbsp;&nbsp;'.$organisations['org_billingstate']:" ";
		$billing_country				= (!empty($organisations['billingcountry']))?', '.$organisations['billingcountry']:" ";
		$billing_poc					= (!empty($organisations['org_billingpoc']))?' - '.$organisations['org_billingpoc']:" ";
		$billing 						= $billing_address.$billing_pob.$billing_city.$billing_state.$billing_country.$billing_poc;
	
        $urlString 				   = dirname(FCPATH);
        $logo 					   = base_url().HEADER_LOGO;
		//$logo_image = 'http://192.168.1.175:8887/tender_crm/v1/tender/assets/tcpdf/images/header_logo.jpg';
		$contact_sal = get_gen_name($tenders["contact_salutation"],TENDER_SALUTION);  
		$tender_header = '
		 <div align="center" style="border-bottom:1px solid #ccc;">
		    <img src="'.$logo.'" >
		    </div>';
		$tender_organisation 			= 
		'<table width="100%"  border="0" cellspacing="0" cellpadding="8">
		  <tr>
		    <td colspan="4" style="border-bottom:1px solid #ccc; border-top:1px solid #ccc;"><div align="center"><strong> Proforma Invoice </strong></div></td>
		  </tr>
		  <tr>
		    <td colspan="2">To,<br>
		      <strong>'.$contact_sal.$tenders["contact_name"].'</strong>
		 		<br> '.$orgn_name.' <span style="text-align:justify">'.$billing.'</span><br></td>
		    <td width="50%" colspan="2"> <div align="right"><strong>Invoice No: '. $tenders['tdr_refid'].'</strong> <br>
		        <strong>Date:'.$date_today.'</strong> </div></td>
		  </tr>
		  <tr>
		    <td align="right"> <strong>Country : </strong>'.$tenders['country'].'</td>
		    <td align="right"> <strong>Voltage : </strong>'.$tenders['voltage'].'</td>
		    <td align="right"> <strong>Frequency : </strong>'.$tenders['frequency'].'</td>
		    <td align="right"> <strong>Plug Type : </strong>'.$tenders['plug_type'].'</td>
		  </tr>
		</table>';

		$tender_productS  =
			'<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
			 	<thead>
				  <tr>
				    <td width="60%"> <div align="center"><strong>Description </strong></div></td>
				     <td width="10%"> <div align="center"><strong>QTY </strong></div></td>
				    <td width="15%"> <div align="center"><strong>Unit Price ($)</strong></div></td>
				    <td width="15%"> <div align="center"><strong>Total Price ($) </strong></div></td>
				  </tr>
			  	</thead>
			  	<tbody>';
		 if(isset($tender_product) && $tender_product !='' && !empty($tender_product)) {
         	$i = 0; 
        	foreach ($tender_product as $key => $tenderproduct) {
      		 $product_desc = $tenderproduct['tdp_desc'];
      		 $product_discount = (isset($tenderproduct['tdp_discount_total_amt']) && $tenderproduct['tdp_discount_total_amt'] > 0 )?'<br><br> <b>(-)Discount </b> :'.number_format($tenderproduct['tdp_discount_total_amt'],2):"";
      	$tender_productS .=
      		'<tr>
			    <td width="60%"> <div align="left"><strong> '. $tenderproduct['tdp_name'] .'</strong> </div> 
			      '. $product_desc.'
			  </td>
			    <td  width="10%"> <div align="center">'. $tenderproduct['tdp_quantity'] .'</div></td>
			     <td width="15%"> <div align="center">'. number_format($tenderproduct['tdp_price'],2).$product_discount.'
			     </div></td>
			    <td width="15%"> <div align="center">'.number_format($tenderproduct['tdp_item_total'],2) .' </div></td>
			  </tr>';
		}}
		$tdr_shipping_charges1 = (INT)$tenders['tdr_shipping_charges'];
		 $tdr_shipping_charges =  (isset($tenders['tdr_shipping_charges']) && $tdr_shipping_charges1 > 0)?number_format($tenders['tdr_shipping_charges'],2):'As Applicable'; 

		$tender_footer =
			'</tbody>
				<tfoot> 
				  <tr>
				    <td colspan="3"> <div align="center"  valign="top"><strong>Price
				    </strong></div></td>
				    <td> <div align="center">'. $tenders['tdr_item_total'] .'</div></td>
				  </tr>';
		if(isset($tenders['tdr_discount']) && $tenders['tdr_discount'] > 0)
			{
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>(-)Discount </strong>
				    	</div>
				    </td>
				    <td> <div align="center">'. number_format($tenders['tdr_discount'],2) .'</div></td>
				 </tr>';
			}
		
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>(+) Shipping &amp; Handling Charges</strong>
				    	</div>
				    </td>
				    <td> <div align="center">'.  $tdr_shipping_charges .'</div></td>
				 </tr>';
			
			if(isset($tenders['tdr_bank_charges']) && $tenders['tdr_bank_charges'] > 0)
			{
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>(+) Bank Charges</strong>
				    	</div>
				    </td>
				    <td> <div align="center">'. number_format($tenders['tdr_bank_charges'],2) .'</div></td>
				 </tr>';
			}
			if(isset($tenders['tdr_pretax_total']) && $tenders['tdr_pretax_total'] > 0)
			{
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center">Pre Tax Total
				    	</div>
				    </td>
				    <td> <div align="center">'. $tenders['tdr_pretax_total'] .'</div></td>
				 </tr>';
			}
			if(isset($tenders['tdr_tax']) && $tenders['tdr_tax'] > 0)
			{
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>(+)Tax</strong>
				    	</div>
				    </td>
				    <td> <div align="center">'. number_format($tenders['tdr_tax'],2) .'</div></td>
				 </tr>';
			}
			if(isset($tenders['tdr_tax_shipping_charges']) && $tenders['tdr_tax_shipping_charges'] > 0)
			{
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>(+) Taxes For Shipping and Handling</strong>
				    	</div>
				    </td>
				    <td> <div align="center">'. number_format($tenders['tdr_tax_shipping_charges'],2) .'</div></td>
				 </tr>';
			}
			if(isset($tenders['tdr_adjustment']) && $tenders['tdr_adjustment'] > 0)
			{
				$adj = (($tenders['tdr_adjustment_type'] == SUB_ADJUSTMENT_TYPE))?"-":"+";
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>('.$adj.')Adjustment</strong>
				    	</div>
				    </td>
				    <td> <div align="center">'. number_format($tenders['tdr_adjustment'],2) .'</div></td>
				 </tr>';
			}
				  
		$tender_footer .=		 
			'<tr>
			    <td colspan="3"> <div align="center"><strong>GRAND TOTAL(USD $) </strong></div></td>
			    <td> <div align="center"><strong>'.$tenders['tdr_grandtotal'].'</strong></div></td>
			  </tr>
			</tfoot>
		</table>';

		$tender_tnc 	= 
			'<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><strong> Terms and Conditions </strong> <br>
				     <span style="white-space: pre-line">'. $tenders['tdr_tnc'].'</span>
				    </td>
				  </tr>
				 
				</table>';	
		
		$tender_data  .= $tender_header.$tender_organisation.$tender_productS.$tender_footer.$tender_tnc;
		
    
		 generate_pdf($tender_reference,$tender_name,$tender_subject,$tender_data,$type);
		 

		 if($type == TENDER_INVOICE_PDF_MAIL)
		 {
		 	redirect('send-email-tenders-'.$etenders_id);
		 }
		 else{}
	}

	public function tendersGenrateEmail($tender_id)
	{
		$data 									= array();
		$validation_config 						= array(
				  array(
                     'field'   => 'tde_subject', 
                     'label'   => 'Tenders Subject', 
                     'rules'   => 'trim|required'
                  ),
                  array(
                     'field'   => 'tde_to', 
                     'label'   => 'Tenders To', 
                     'rules'   => 'trim|required'
                  ),
            );

		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 			= global_asset_version();
		$data['ci_asset_versn'] 				= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title									= 'Mail Tenders';
		$data['ctrler']							= 'Tenders';
		$data['title']							= $title;

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 				= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 				= array('Tenders', base_url('tenders'));
		$data['breadcrumb_data'][] 				= array('Mail Tenders');
		$data['breadcrumb']        				= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['tender_id']						= $tender_id;
		$data['tenders_id']						= $this->crm_auth->decrypt_openssl($tender_id);

		$data['tenders'] 						= $this->tender_model->gettendersDataByID($data);
		$data['reference_number']				= $data['tenders']['tdr_refid'];
		$data['tender_product'] 				= $this->tender_model->gettendersProductDataByID($data);


		$data['scontent']						= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('tenders/mail_tenders',$data);
		}
		else
		{
				
			$reference_id 							= trim($this->input->post('tde_tdr_refid'));
			$arrAccountData['tde_tdr_refid'] 		= $reference_id;
			$arrAccountData['tde_from'] 			= $this->session->userdata('prs_email');
			$arrAccountData['tde_to'] 				= trim($this->input->post('tde_to'));
			$arrAccountData['tde_cc'] 				= trim($this->input->post('tde_cc'));
			$arrAccountData['tde_bcc'] 				= trim($this->input->post('tde_bcc'));
			$arrAccountData['tde_subject'] 			= trim($this->input->post('tde_subject'));
			$arrAccountData['tde_content'] 			= trim($this->input->post('tde_content'));
			
			$count = count($_FILES['files']['name']);
            
			if($count)
			{
				$arrAccountData['tde_flg_attachment'] 	= YES;
			}

			$arrAccountData['tde_prs_id'] 			= $this->session->userdata('prs_id');
			$arrAccountData['created_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['created_dt'] 		= date('Y-m-d H:i:s');
			
			$tender_email_id	= insert('tender_emaillogs',$arrAccountData);

			/**** upload multiple attachment **/

				$config['upload_path'] 		= SAVE_ADD_PDF_LINK; 
		        $config['allowed_types'] 	= 'PDF|pdf';
		        $config['max_size'] 		= '5000';
				$this->load->library('upload',$config); 
				$data['attachment_name'] = array();
				for($i=0;$i<$count;$i++)
				{
					
	        		if(isset($_FILES['files']['name'][$i]))
	        		{
	        			$name 						='';
	        			$name 						= $reference_id.'-'.$_FILES['files']['name'][$i];
	        		
	        			$_FILES['file']['name'] 	= $name;
				        $_FILES['file']['type'] 	= $_FILES['files']['type'][$i];
				        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
				        $_FILES['file']['error'] 	= $_FILES['files']['error'][$i];
				        $_FILES['file']['size'] 	= $_FILES['files']['size'][$i];

				  
				       $this->upload->do_upload(); 

				         
				         if($this->upload->do_upload('file'))
				         {
				            $uploadData = $this->upload->data();
				            $filename = $uploadData['file_name'];
   
            				$data['attachment_name'][] = SAVE_ADD_PDF_LINK.$filename;

				         }
	        		}

	        	}
     			$tender_pdf_file 		   = SAVE_PDF.$reference_id.'.pdf';
            //echo $tender_pdf_file;exit;
     			$data['attachment_name'][] = $tender_pdf_file;
	        /**** upload multiple attachment **/
				$tenderEmailData  					  = array();
				
				$tenderEmailData					  = $this->tender_model->tenderEmailData($tender_email_id);


			    $arrEmailData                         = array();
			    $arrEmailData['email_subject']        = $tenderEmailData['tde_subject'];
			    $arrEmailData['email_content']        = $tenderEmailData['tde_content'];
			    $arrEmailData['email_template']       = '';
			    $arrEmailData['email_template_data']  = '';
			    $arrEmailData['name']                 = $tenderEmailData['person_name'];
			    $arrEmailData['email']                = $tenderEmailData['tde_to'];
			    $arrEmailData['email_cc']      	  	  = $tenderEmailData['tde_cc'];
			    $arrEmailData['email_bcc']      	  = $tenderEmailData['tde_bcc'];

			    $arrEmailData['attachment_array']     = $data['attachment_name'];
			    $arrEmailData['attachment_flg']       = $tenderEmailData['tde_flg_attachment'];

			    $login_userDetails	= array();
			    $user_id 		  					  = $this->session->userdata('prs_id');
			    $login_userDetails					  = detail_data('*', 'tender_person', 'prs_id = "'.$user_id.'" ');
			    $arrEmailData['admin_email_from'] 	  = $login_userDetails['prs_email'];
			    $arrEmailData['smtp_user'] 	  		  = $login_userDetails['prs_email'];
			    $arrEmailData['smtp_pass'] 	 	 	  = $login_userDetails['prs_emilpwd'];
			    $arrEmailData['smtp_host'] 	  		  = $login_userDetails['prs_host'];
			    $arrEmailData['smtp_port'] 	 	 	  = $login_userDetails['prs_port'];


			    $this->crm_auth->sendEmail($arrEmailData);

			   
			    if(isset($arrEmailData['attachment_flg']) && $arrEmailData['attachment_flg'] == YES)
				{
					foreach ($arrEmailData['attachment_array'] as $key => $value) 
					{
						if($value != $tender_pdf_file)
						{
						  unlink($value);
						}
					}
				}

			$tenders_id = $this->crm_auth->encrypt_openssl($tenderEmailData['tender_id']);
			$this->session->set_flashdata('success', 'Tender Mail sent successfully');
			redirect(site_url('tenders-detail-'.$tenders_id),'refresh');
			exit;
		}
	}

	public function generate_pdf_invoice($tenders_id,$type)
	{
		
		/***********************************************************
					Tender Data
		************************************************************/
		$etenders_id					= $tenders_id;
		$tenders_id 					= $this->crm_auth->decrypt_openssl($tenders_id);


		$data = array();
		$Orgdat = array();

		$tender_ref_Data 				= generate_invoice_reference_id();
		$arrBSNData['bpm_value'] 		= $tender_ref_Data['number_seq'];
		update('bpm_name','custom_invoice_start_sequence',$arrBSNData, 'tender_bsn_prm');

		$arrInvData['tdr_invoice_number'] 	= $tender_ref_Data['reference'];
		update('tdr_id',$tenders_id,$arrInvData, 'tender_detail');

		$data['tenders_id']  			= $tenders_id;
		$tenders 						= $this->tender_model->gettendersDataByID($data);
		$tender_product 				= $this->tender_model->gettendersProductDataByID($data);
		$Orgdata['organisations_id']  	= $tenders['tdr_organisationid'];
		$organisations 					= $this->home_model->getorganisationsDataByID($Orgdata);
		$date_time 						= date('Y-m-d H:i:s');



		$tender_reference 				= $tenders['tdr_invoice_number'];
		$tender_name 					= $tenders['tdr_name'];
		$tender_subject 				= $tenders['tdr_subject'];
		$tender_data					= '';
		$date_today 					= date('d,M Y');
		$curreny 						= get_gen_name($tenders['tdr_currency'],TENDER_PRICE_TYPE);
		$orgn_name 						= (!empty($organisations['org_name']) && $organisations['org_name'] != 'Individual')?'&nbsp;&nbsp;<strong>'.$organisations['org_name'].'</strong><br>':" ";
		$billing_address				= (!empty($organisations['org_billingadd']))?'&nbsp;&nbsp;'.$organisations['org_billingadd']:" ";
		$billing_pob					= (!empty($organisations['org_billingpob']))?'<br>&nbsp;&nbsp;&nbsp;P.O. Box : '.$organisations['org_billingpob']:" ";
		$billing_city					= (!empty($organisations['org_billingcity']))?', <br>&nbsp;&nbsp;&nbsp;'.$organisations['org_billingcity']:" ";
		$billing_state					= (!empty($organisations['org_billingstate']))?'<br>&nbsp;&nbsp;&nbsp;'.$organisations['org_billingstate']:" ";
		$billing_country				= (!empty($organisations['billingcountry']))?', '.$organisations['billingcountry']:" ";
		$billing_poc					= (!empty($organisations['org_billingpoc']))?' - '.$organisations['org_billingpoc']:" ";
		$billing 						= $billing_address.$billing_pob.$billing_city.$billing_state.$billing_country.$billing_poc;
		$logo 							= base_url().HEADER_LOGO;
		//$logo_image = 'http://192.168.1.175:8887/tender_crm/v1/tender/assets/tcpdf/images/header_logo.jpg';
		$contact_sal = get_gen_name($tenders["contact_salutation"],TENDER_SALUTION);  
		$tender_header = '
		 <div align="center" style="border-bottom:1px solid #ccc;">
		    <img src="'.$logo.'" >
		    </div>';
		$tender_organisation 			= 
		'<table width="100%"  border="0" cellspacing="0" cellpadding="8">
		  <tr>
		    <td colspan="4" style="border-bottom:1px solid #ccc; border-top:1px solid #ccc;"><div align="center"><strong>  Invoice </strong></div></td>
		  </tr>
		  <tr>
		    <td colspan="2">To,<br>
		      <strong>'.$contact_sal.$tenders["contact_name"].'</strong>
		 		<br> '.$orgn_name.' <span style="text-align:justify">'.$billing.'</span><br></td>
		    <td width="50%" colspan="2"> <div align="right"><strong>Invoice No: '. $tenders['tdr_invoice_number'].'</strong> <br>
		        <strong>Date:'.$date_today.'</strong> </div></td>
		  </tr>
		  <tr>
		    <td align="right"> <strong>Country : </strong>'.$tenders['country'].'</td>
		    <td align="right"> <strong>Voltage : </strong>'.$tenders['voltage'].'</td>
		    <td align="right"> <strong>Frequency : </strong>'.$tenders['frequency'].'</td>
		    <td align="right"> <strong>Plug Type : </strong>'.$tenders['plug_type'].'</td>
		  </tr>
		</table>';

		$tender_productS  =
			'<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
			 	<thead>
				  <tr>
				    <td width="60%"> <div align="center"><strong>Description </strong></div></td>
				     <td width="10%"> <div align="center"><strong>QTY </strong></div></td>
				    <td width="15%"> <div align="center"><strong>Unit Price ($)</strong></div></td>
				    <td width="15%"> <div align="center"><strong>Total Price ($) </strong></div></td>
				  </tr>
			  	</thead>
			  	<tbody>';
		 if(isset($tender_product) && $tender_product !='' && !empty($tender_product)) {
         	$i = 0; 
        	foreach ($tender_product as $key => $tenderproduct) {
      		 $product_desc = $tenderproduct['tdp_desc'];
      		 $product_discount = (isset($tenderproduct['tdp_discount_total_amt']) && $tenderproduct['tdp_discount_total_amt'] > 0 )?'<br><br> <b>(-)Discount </b> :'.number_format($tenderproduct['tdp_discount_total_amt'],2):"";
      	$tender_productS .=
      		'<tr>
			    <td width="60%"> <div align="left"><strong> '. $tenderproduct['tdp_name'] .'</strong> </div> 
			      '. $product_desc.'
			  </td>
			    <td  width="10%"> <div align="center">'. $tenderproduct['tdp_quantity'] .'</div></td>
			     <td width="15%"> <div align="center">'. number_format($tenderproduct['tdp_price'],2).$product_discount.'
			     </div></td>
			    <td width="15%"> <div align="center">'.number_format($tenderproduct['tdp_item_total'],2) .' </div></td>
			  </tr>';
		}}
		$tdr_shipping_charges1 = (INT)$tenders['tdr_shipping_charges'];
		 $tdr_shipping_charges =  (isset($tenders['tdr_shipping_charges']) && $tdr_shipping_charges1 > 0)?number_format($tenders['tdr_shipping_charges'],2):'As Applicable'; 

		$tender_footer =
			'</tbody>
				<tfoot> 
				  <tr>
				    <td colspan="3"> <div align="center"  valign="top"><strong>Price
				    </strong></div></td>
				    <td> <div align="center">'. $tenders['tdr_item_total'] .'</div></td>
				  </tr>';
		if(isset($tenders['tdr_discount']) && $tenders['tdr_discount'] > 0)
			{
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>(-)Discount </strong>
				    	</div>
				    </td>
				    <td> <div align="center">'. number_format($tenders['tdr_discount'],2) .'</div></td>
				 </tr>';
			}
		
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>(+) Shipping &amp; Handling Charges</strong>
				    	</div>
				    </td>
				    <td> <div align="center">'.  $tdr_shipping_charges .'</div></td>
				 </tr>';
			
			if(isset($tenders['tdr_bank_charges']) && $tenders['tdr_bank_charges'] > 0)
			{
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>(+) Bank Charges</strong>
				    	</div>
				    </td>
				    <td> <div align="center">'. number_format($tenders['tdr_bank_charges'],2) .'</div></td>
				 </tr>';
			}
			if(isset($tenders['tdr_pretax_total']) && $tenders['tdr_pretax_total'] > 0)
			{
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center">Pre Tax Total
				    	</div>
				    </td>
				    <td> <div align="center">'. $tenders['tdr_pretax_total'] .'</div></td>
				 </tr>';
			}
			if(isset($tenders['tdr_tax']) && $tenders['tdr_tax'] > 0)
			{
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>(+)Tax</strong>
				    	</div>
				    </td>
				    <td> <div align="center">'. number_format($tenders['tdr_tax'],2) .'</div></td>
				 </tr>';
			}
			if(isset($tenders['tdr_tax_shipping_charges']) && $tenders['tdr_tax_shipping_charges'] > 0)
			{
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>(+) Taxes For Shipping and Handling</strong>
				    	</div>
				    </td>
				    <td> <div align="center">'. number_format($tenders['tdr_tax_shipping_charges'],2) .'</div></td>
				 </tr>';
			}
			if(isset($tenders['tdr_adjustment']) && $tenders['tdr_adjustment'] > 0)
			{
				$adj = (($tenders['tdr_adjustment_type'] == SUB_ADJUSTMENT_TYPE))?"-":"+";
				$tender_footer .= 
				'<tr>
				    <td colspan="3">      
				    	<div align="center"><strong>('.$adj.')Adjustment</strong>
				    	</div>
				    </td>
				    <td> <div align="center">'. number_format($tenders['tdr_adjustment'],2) .'</div></td>
				 </tr>';
			}
				  
		$tender_footer .=		 
			'<tr>
			    <td colspan="3"> <div align="center"><strong>GRAND TOTAL(USD $) </strong></div></td>
			    <td> <div align="center"><strong>'.$tenders['tdr_grandtotal'].'</strong></div></td>
			  </tr>
			</tfoot>
		</table>';

		$tender_tnc 	= 
			'<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><strong> Terms and Conditions </strong> <br>
				     <span style="white-space: pre-line">'. $tenders['tdr_tnc'].'</span>
				    </td>
				  </tr>
				 
				</table>';	
		
		$tender_data  .= $tender_header.$tender_organisation.$tender_productS.$tender_footer.$tender_tnc;
		/*	print_r($tender_data);
		exit;*/

		 generate_pdf($tender_reference,$tender_name,$tender_subject,$tender_data,$type);

		 if($type == TENDER_INVOICE_PDF_MAIL)
		 {
		 	redirect('send-invoice-email-'.$etenders_id);
		 }
		 else{}
	}

	public function tendersGenrateEmailInvoice($tender_id)
	{
		$data 									= array();
		$validation_config 						= array(
				  array(
                     'field'   => 'tde_subject', 
                     'label'   => 'Tenders Subject', 
                     'rules'   => 'trim|required'
                  ),
                  array(
                     'field'   => 'tde_to', 
                     'label'   => 'Tenders To', 
                     'rules'   => 'trim|required'
                  ),
            );

		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 			= global_asset_version();
		$data['ci_asset_versn'] 				= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title									= 'Mail Tenders';
		$data['ctrler']							= 'Tenders';
		$data['title']							= $title;

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 				= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 				= array('Tenders', base_url('tenders'));
		$data['breadcrumb_data'][] 				= array('Mail Tenders');
		$data['breadcrumb']        				= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['tender_id']						= $tender_id;
		$data['tenders_id']						= $this->crm_auth->decrypt_openssl($tender_id);

		$data['tenders'] 						= $this->tender_model->gettendersDataByID($data);
		$data['reference_number']				= $data['tenders']['tdr_invoice_number'];
		$data['tender_product'] 				= $this->tender_model->gettendersProductDataByID($data);


		$data['scontent']						= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('tenders/mail_tenders',$data);
		}
		else
		{
				
			$reference_id 							= trim($this->input->post('tde_tdr_invoice_number'));
			$arrAccountData['tde_tdr_refid'] 		= $reference_id;
			$arrAccountData['tde_from'] 			= $this->session->userdata('prs_email');
			$arrAccountData['tde_to'] 				= trim($this->input->post('tde_to'));
			$arrAccountData['tde_cc'] 				= trim($this->input->post('tde_cc'));
			$arrAccountData['tde_bcc'] 				= trim($this->input->post('tde_bcc'));
			$arrAccountData['tde_subject'] 			= trim($this->input->post('tde_subject'));
			$arrAccountData['tde_content'] 			= trim($this->input->post('tde_content'));
			
			$count = count($_FILES['files']['name']);

			if($count)
			{
				$arrAccountData['tde_flg_attachment'] 	= YES;
			}

			$arrAccountData['tde_prs_id'] 			= $this->session->userdata('prs_id');
			$arrAccountData['created_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['created_dt'] 		= date('Y-m-d H:i:s');
			
			$tender_email_id	= insert('tender_emaillogs',$arrAccountData);

			/**** upload multiple attachment **/

				$config['upload_path'] 		= SAVE_ADD_PDF_LINK; 
		        $config['allowed_types'] 	= 'PDF|pdf';
		        $config['max_size'] 		= '5000';
				$this->load->library('upload',$config); 
				$data['attachment_name'] = array();
				for($i=0;$i<$count;$i++)
				{
					
	        		if(isset($_FILES['files']['name'][$i]))
	        		{
	        			$name 						='';
	        			$name 						= $reference_id.'-'.$_FILES['files']['name'][$i];
	        		
	        			$_FILES['file']['name'] 	= $name;
				        $_FILES['file']['type'] 	= $_FILES['files']['type'][$i];
				        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
				        $_FILES['file']['error'] 	= $_FILES['files']['error'][$i];
				        $_FILES['file']['size'] 	= $_FILES['files']['size'][$i];

				  
				       $this->upload->do_upload(); 

				         
				         if($this->upload->do_upload('file'))
				         {
				            $uploadData = $this->upload->data();
				            $filename = $uploadData['file_name'];
   
            				$data['attachment_name'][] = SAVE_ADD_PDF_LINK.$filename;

				         }
	        		}

	        	}
     			$tender_pdf_file 		   = SAVE_PDF.$reference_id.'.pdf';
     			$data['attachment_name'][] = $tender_pdf_file;
     			
	        	/**** upload multiple attachment **/
				$tenderEmailData  					  = array();
				
				$tenderEmailData					  = $this->tender_model->tenderEmailData($tender_email_id);


			    $arrEmailData                         = array();
			    $arrEmailData['email_subject']        = $tenderEmailData['tde_subject'];
			    $arrEmailData['email_content']        = $tenderEmailData['tde_content'];
			    $arrEmailData['email_template']       = '';
			    $arrEmailData['email_template_data']  = '';
			    $arrEmailData['name']                 = $tenderEmailData['person_name'];
			    $arrEmailData['email']                = $tenderEmailData['tde_to'];
			    $arrEmailData['email_cc']      	  	  = $tenderEmailData['tde_cc'];
			    $arrEmailData['email_bcc']      	  = $tenderEmailData['tde_bcc'];

			    $arrEmailData['attachment_array']     = $data['attachment_name'];
			    $arrEmailData['attachment_flg']       = $tenderEmailData['tde_flg_attachment'];

			    $login_userDetails	= array();
			    $user_id 		  					  = $this->session->userdata('prs_id');
			    $login_userDetails					  = detail_data('*', 'tender_person', 'prs_id = "'.$user_id.'" ');
			    $arrEmailData['admin_email_from'] 	  = $login_userDetails['prs_email'];
			    $arrEmailData['smtp_user'] 	  		  = $login_userDetails['prs_email'];
			    $arrEmailData['smtp_pass'] 	 	 	  = $login_userDetails['prs_emilpwd'];
			    $arrEmailData['smtp_host'] 	  		  = $login_userDetails['prs_host'];
			    $arrEmailData['smtp_port'] 	 	 	  = $login_userDetails['prs_port'];


			    $this->crm_auth->sendEmail($arrEmailData);

			   
			    if(isset($arrEmailData['attachment_flg']) && $arrEmailData['attachment_flg'] == YES)
				{
					foreach ($arrEmailData['attachment_array'] as $key => $value) 
					{
						if($value != $tender_pdf_file)
						{
						  unlink($value);
						}
					}
				}

			$tenders_id = $this->crm_auth->encrypt_openssl($tenderEmailData['tender_id']);
			$this->session->set_flashdata('success', 'Tender Mail sent successfully');
			redirect(site_url('tenders-detail-'.$tenders_id),'refresh');
			exit;
		}
	}

	public function tender_activity($type, $id)
	{
		$data['tenders_id']  		= $id;
		$tenders 					= $this->tender_model->gettendersDataByID($data);
		$eorg_id 					= $this->crm_auth->encrypt_openssl($tenders['tdr_organisationid']);
		$etender_id 				= $this->crm_auth->encrypt_openssl($id);
		$tda_activity_details	    = '';

		$tda_activity_details					.= '<strong> Tender : </strong> <a href="'.base_url().'tenders-detail-'.$etender_id.'">'.$tenders['tdr_subject'].' </a> for <a href="'.base_url().'organisations-detail-'.$eorg_id.'">'.$tenders['organisation'].' </a> with an amount of <b>'.$tenders['tdr_grandtotal'].' </b>';

		$arrActivityData							= array();
		$arrActivityData['tda_activity'] 			= $type;
		$arrActivityData['tda_activity_details']	= $tda_activity_details;

		$arrActivityData['tda_type'] 				= TENDER_ACTIVITY_TENDER;
		$arrActivityData['tda_prs_id'] 				= $this->session->userdata('prs_id');
		$arrActivityData['tda_date'] 				= date('Y-m-d H:i:s');

		insert('tender_activity',$arrActivityData);
	}

}

?>