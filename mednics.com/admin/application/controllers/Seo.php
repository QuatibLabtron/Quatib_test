<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seo extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();
     $this->load->model('Seo_model');
		if($this->session->userdata('prs_id') == '')
		{
			redirect('/login', 'refresh');
			exit;
		}
    }
	
	public function seoDetail($categories_id = '')
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
	public function add_seo_pages($categories_id = '')
	{
		$total = $this->uri->total_segments();
		$last = explode('-',$this->uri->segment(1));
		//print_r($last);
		if(isset($last) && count($last)==4){
		$categorie_id=$last[3]; 
		}else{
			$categorie_id="";
		}
		//print_r($categories_id);
		$data = array();
		$validation_config = array(
				  array(
                     'field'   => 'pageid', 
                     'label'   => 'Pages', 
                     'rules'   => 'trim|required'
                  ),array(
                     'field'   => 'meta_title', 
                     'label'   => 'Meta Title', 
                     'rules'   => 'trim|required'
                  ),
				  array(
                     'field'   => 'meta_keyword', 
                     'label'   => 'Meta Keyword', 
                     'rules'   => 'trim|required'
                  ),
				  array(
                     'field'   => 'meta_description', 
                     'label'   => 'Meta Description', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title						= 'Update Pages SEO';
		$data['ctrler']				= 'Pages SEO';
		$data['title']				= $title;
if(!empty($categorie_id)){
		$data['scontent']['categories_id'] 	= $categorie_id;
		//print_r($data['scontent']['categories_id']);
		
		$data['categories'] 				= $this->Seo_model->getPagesDataByID($data['scontent']);
		}else{
			
			$data['categories'] =array();
		}
		//print_r($data['categories']);
		$data['categories_id'] 				= $categorie_id;
			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('SEO List', base_url('products-seo-import'));
		$data['breadcrumb_data'][] 	= array('Update Pages SEO');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']			= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('seo/add_seo_pages',$data);
		}
		else
		{
			$project_name 						= bsnprm_value(BSN_WEBSITE_NAME);
			$page_id 						= trim($this->input->post('pageid'));
			$arrAccountData['meta_title'] 	= ($this->input->post('meta_title'))?trim($this->input->post('meta_title')):$keyword;
			$arrAccountData['meta_keyword'] 	= ($this->input->post('meta_keyword'))?trim($this->input->post('meta_keyword')):$keyword;
			$arrAccountData['meta_description'] = ($this->input->post('meta_description'))?trim($this->input->post('meta_description')):$arrAccountData['description'];

			

			update('id', $page_id, $arrAccountData, 'pages');
			
		
			$this->session->set_flashdata('success', 'Seo Meta Data Updated successfully');
			//redirect(site_url('categories-detail-'.$categories_id));
			redirect(site_url('add-seo-pages-'.$page_id));
			exit;
		}
	}

public function add_seo_categorie($categories_id = '')
	{		
	
		$total = $this->uri->total_segments();
		$last = explode('-',$this->uri->segment(1));
		//print_r($last);
		if(isset($last) && count($last)==4){
		$categorie_id=$last[3]; 
		}else{
			$categorie_id="";
		}
		//print_r($categories_id);
		$data = array();
		
		$validation_config = array(
				  array(
                     'field'   => 'categoryid', 
                     'label'   => 'Category', 
                     'rules'   => 'trim|required'
                  ),
				  array(
                     'field'   => 'meta_title', 
                     'label'   => 'Meta Title', 
                     'rules'   => 'trim|required'
                  ),
				  array(
                     'field'   => 'meta_keyword', 
                     'label'   => 'Meta Keyword', 
                     'rules'   => 'trim|required'
                  ),
				  array(
                     'field'   => 'meta_description', 
                     'label'   => 'Meta Description', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title						= 'Update Categories SEO';
		$data['ctrler']				= 'Categories SEO';
		$data['title']				= $title;

if(!empty($categorie_id)){
		$data['scontent']['categories_id'] 	= $categorie_id;
		//print_r($data['scontent']['categories_id']);
		
		$data['categories'] 				= $this->Seo_model->getCategoriesDataByID($data['scontent']);
		}else{
			
			$data['categories'] =array();
		}
		//print_r($data['categories']);
		$data['categories_id'] 				= $categorie_id;


			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('SEO List', base_url('products-seo-import'));
		$data['breadcrumb_data'][] 	= array('Update Categories SEO');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']			= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('seo/add_seo_category',$data);
		}
		else
		{
			$project_name 						= bsnprm_value(BSN_WEBSITE_NAME);
			
			$categorie_id 						= trim($this->input->post('categoryid'));
			$arrAccountData['meta_title'] 	= ($this->input->post('meta_title'))?trim($this->input->post('meta_title')):$keyword;
			$arrAccountData['meta_keyword'] 	= ($this->input->post('meta_keyword'))?trim($this->input->post('meta_keyword')):$keyword;
			$arrAccountData['meta_description'] = ($this->input->post('meta_description'))?trim($this->input->post('meta_description')):$arrAccountData['description'];

			

			update('id', $categorie_id, $arrAccountData, 'categories');
			
		
			$this->session->set_flashdata('success', 'Seo Meta Data Updated successfully');
			//redirect(site_url('categories-detail-'.$categories_id));
			//redirect(site_url('add-seo-categorie'));
			redirect(site_url("add-seo-categorie-".$categorie_id));
			exit;
		}
	}

	public function add_seo_product($categories_id = '')
	{
		
		$total = $this->uri->total_segments();
        $last = explode('-',$this->uri->segment(1));
		//print_r($last);
		//$product_id="";
		if(isset($last) && count($last)==4){
		$product_id=$last[3]; 
		}else{
			$product_id="";
		}
		//print_r($categories_id);
		$data = array();
		//echo "test". $product_id =$this->uri->segment(1); 
		//echo $_GET[];
		$validation_config = array(
				  array(
                     'field'   => 'productid', 
                     'label'   => 'Product', 
                     'rules'   => 'trim|required'
                  ),
				  array(
                     'field'   => 'meta_title', 
                     'label'   => 'Meta Title', 
                     'rules'   => 'trim|required'
                  ),
				  array(
                     'field'   => 'meta_keyword', 
                     'label'   => 'Meta Keyword', 
                     'rules'   => 'trim|required'
                  ),
				  array(
                     'field'   => 'meta_description', 
                     'label'   => 'Meta Description', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);


		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		if(!empty($product_id)){
		$data['scontent']['categories_id'] 	= $product_id;
		//print_r($data['scontent']['categories_id']);
		$data['categories'] 				= $this->Seo_model->getproductsDataByID($data['scontent']);
		}else{
			
			$data['categories'] =array();
		}
		//print_r($data['categories']);
		$data['categories_id'] 				= $product_id;
		// automatically push current page to last record of breadcrumb
		$title						= 'Update Products SEO';
		$data['ctrler']				= 'Products SEO';
		$data['title']				= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 	= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 	= array('SEO List', base_url('products-seo-import'));
		$data['breadcrumb_data'][] 	= array('Update SEO');
		$data['breadcrumb']        	= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//


		$data['scontent']			= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('seo/add_seo_product',$data);
		}
		else
		{
			$project_name 						= bsnprm_value(BSN_WEBSITE_NAME);
			$product_id 						= trim($this->input->post('productid'));
			$arrAccountData['meta_title'] 	= ($this->input->post('meta_title'))?trim($this->input->post('meta_title')):$keyword;
			$arrAccountData['meta_keyword'] 	= ($this->input->post('meta_keyword'))?trim($this->input->post('meta_keyword')):$keyword;
			$arrAccountData['meta_description'] = ($this->input->post('meta_description'))?trim($this->input->post('meta_description')):$arrAccountData['description'];

			

			update('id', $product_id, $arrAccountData, 'products');
			
		
			$this->session->set_flashdata('success', 'Seo Meta Data Updated successfully');
			//redirect(site_url('categories-detail-'.$categories_id));
			redirect(site_url("add-seo-product-".$product_id));
			exit;
			//echo json_encode(array('success'=>true,"message"=>"categories updated successfully","linkn"=>base_url()."add-seo-".$product_id));
		
		}
	}

	
	public function products_seo_import()
    {
    	$data 				= array();

    	$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();
		// automatically push current page to last record of breadcrumb
		$title								= 'Update SEO for products';
		$data['ctrler']						= 'SEO products';
		$data['title']						= $title;

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][] 			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('Seo', base_url('products-seo-import'));
		$data['breadcrumb_data'][] 			= array('SEO List');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		//$entity_name 						= 'products';
		//$view_name	 						= 'excel';
		//$data['excelData'] 					= get_excel_import_data($entity_name,$view_name);
		$data['dataTableData'] 			= $this->Seo_model->get_products(TABLE_COUNT);
  		$this->load->view('seo/seo_list',$data);
    }

	  
}