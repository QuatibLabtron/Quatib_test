<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {
	
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
		$this->productsList();
	}
	
	public function productsList()
	{

		$data['title']					= "Products";

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] = array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] = array('Products');
		$data['breadcrumb']        = $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['dataTableData'] 			= $this->home_model->get_products(TABLE_COUNT);

		$data['global_asset_version']   = global_asset_version();

		$this->load->view('products/products_list',$data);
	}

	public function productsDataTablelist()
	{
		$dataOptn = $this->input->get();
	    $dataTableData = $this->home_model->get_products(TABLE_RESULT,$dataOptn);
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


	public function productsFieldList()
	{

		$data['title']					= "Product Fields";

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] = array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] = array('Products', base_url('products'));
		$data['breadcrumb_data'][] = array('Product Fields');
		$data['breadcrumb']        = $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['product_field'] 			= get_column_data('products');
		$data['global_asset_version']   = global_asset_version();

		$this->load->view('products/products_field',$data);
	}

	

	public function productsDetail($products_id = '')
	{		
		$products_id 						= $this->crm_auth->decrypt_openssl($products_id);
		$data 								= array();
		$data['products_id']  				= $products_id;
		$data['products'] 					= $this->home_model->getproductsDataByID($data);

		$data['ctrl']  						= "Products";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Products', base_url('products'));
		$data['breadcrumb_data'][] 			= array('Products Detail');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']					= array();
		$data['scontent']['products_id'] 	= $products_id;
		$data['title']						= $data['products']['name'];
		
		$this->load->view('products/products_detail',$data);
	}


	public function products_active()
	{
		$chkId 		 = $this->input->post('chkId');
    	if($chkId)
		{
		    status_to_update($chkId,'id','products',STATUS_ACTIVE);
		}
			$success = true;
			$message = 'Products Updated successfully';
			$linkn   =  base_url('products');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function products_deactive()
	{
		$chkId 		= $this->input->post('chkId');
    	if($chkId)
		{
		    status_to_update($chkId,'id','products',STATUS_INACTIVE);
		}
			$success = true;
			$message = 'Products Updated successfully';
			$linkn   =  base_url('products');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function addproductsField()
	{
		$field_name 		= $this->input->post('field_name');
		$field_tab_name 	= $this->input->post('field_tab_name');
    	if($field_name)
		{
		    $this->home_model->add_product_field($field_name,$field_tab_name);
		}

		redirect('products-field', 'refresh');
			exit;
	}

	public function products_import()
    {
    	$data 				= array();

    	$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title								= 'Import products';
		$data['ctrler']						= 'products';
		$data['title']						= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Products', base_url('products'));
		$data['breadcrumb_data'][] 			= array('Import products');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$entity_name 						= 'products';
		$view_name	 						= 'excel';
		$data['excelData'] 					= get_excel_import_data($entity_name,$view_name);
		
  		$this->load->view('excel/excel_import_view',$data);
    }

    public function pricelist_import()
    {
    	$data 				= array();

    	$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title								= 'Import Price List';
		$data['ctrler']						= 'pricelist';
		$data['title']						= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Products', base_url('products'));
		$data['breadcrumb_data'][] 			= array('Import Price List');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$entity_name 						= 'price_list';
		$view_name	 						= 'excel';
		$data['excelData'] 					= get_excel_import_data($entity_name,$view_name);
		
  		$this->load->view('excel/excel_import_view',$data);
    }

	

	  
}