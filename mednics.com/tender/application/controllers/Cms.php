<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        
		if($this->session->userdata('prs_id') == '')
		{
			redirect('/login', 'refresh');
			exit;
		}
    }
	
	public function dashboard()
	{
		// CUSTOM BUSINESS PARAMETER - PREFIX NUMBER
		$t               				=	date('d-m-Y');
		$day             				=	date("d",strtotime($t));
		$month           				=	date("m",strtotime($t));
		$arrBSNData['bpm_value'] 		=	$month.$day; 
        
		update('bpm_name','custom_prefix_number',$arrBSNData, 'tender_bsn_prm');
		$arrBSNData1['bpm_value'] 		=	$day.$month;
		
		update('bpm_name','custom_invoice_prefix_number',$arrBSNData1, 'tender_bsn_prm');
		$data 							= array();
		$dataSrch 						= array();
	
		$data['title']					= "Dashboard";
		$data['dataTableData'] 			= $this->home_model->get_dashboardList(TABLE_COUNT);
		
		$data['UserFeed'] 				= $this->home_model->get_userFeed(TABLE_RESULT_ARRAY,$dataSrch);
       // echo "<pre>";print_r($data['UserFeed']);exit;
		$data['global_asset_version']   = global_asset_version();
		$this->load->view('dashboard',$data);
	}
	
	public function dashboardDataTablelist()
	{
		$dataOptn 					= $this->input->get();
	    $dataTableData 				= $this->home_model->get_dashboardList(TABLE_RESULT,$dataOptn);
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
	public function dashboardDetails($user_id)
	{
		$data['title']					= "Tenders";
		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 		= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 		= array('Tenders');
		$data['breadcrumb']        		= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//
		$user_id 						= $this->crm_auth->decrypt_openssl($user_id);
		$data['person_id']         		= $user_id;
		$dataSrch['person_id']          = $user_id;
		
		$data['dataTableData'] 			= $this->home_model->getAllTenders(TABLE_COUNT,$dataSrch);
		$data['global_asset_version']   = global_asset_version();
		$this->load->view('dashboard_tederList',$data);
	}

	public function tendersDataTablelist($user_id)
	{
		$dataOptn 					= $this->input->get();
		$dataSrch['person_id']      = $user_id;
	    $dataTableData 				= $this->home_model->getAllTenders(TABLE_RESULT,$dataOptn,$dataSrch);
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

	public function userFolloupExport($user_id)
	{
		$user_name      = field_data('prs_name', 'tender_person', $user_id);
		$filename      	= $user_name.date('YmdHis');
		$header 		= array('Name','Invoice No','Contact Name','Organisation','Country','Total Amount','Products','Email to');	
		// output headers so that the file is downloaded rather than displayed
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$filename.'.csv');
	  
		// create a file pointer connected to the output stream
		$lead_export_file = fopen('php://output', 'w');
	  
	   	//output the column headings
		fputcsv($lead_export_file, $header);
		$data = array();
		$data['arrResult'] 	= $this->home_model->get_userFolloupExport($user_id); 
		
		$arrResult = array();
		$arrResult = $data['arrResult'];
		if(is_array($arrResult) && count($arrResult)>0)
		{
			$i=0;
		  	foreach($arrResult as $listData)
		  	{
					  
				$name 			= $listData['name'];
				$invoice_no 	= $listData['invoice_no'];
				$contact_name 	= $listData['contact_name'];
				$organisation 	= $listData['organisation'];
				$country 		= $listData['country'];
				$total_amount 	= $listData['total_amount'];
				$products 		= $listData['products'];
				$email_to 		= $listData['emailto'];
				
				$resultData = array($name,$invoice_no,$contact_name,$organisation,$country,$total_amount,$products,$email_to);
	  			fputcsv($lead_export_file, $resultData);
			}
		}
	}
}
