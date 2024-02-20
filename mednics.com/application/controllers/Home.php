<?php defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Main_model');
        $this->load->helper('pdf_helper');
    }
    public function index()
    {
        //echo "111";
        $cat_ids = $this->session->userdata('category_id');
        if($this->input->post('qq_value')) {             $this->enquiry();           }
        $data = common_data();
        $data['random_products'] = $this->Main_model->get_random_products();
        $data['random_categories'] = $this->Main_model->get_random_categories();
        $data['first_products'] = $this->Main_model->get_first_products();
        $data['latest_products'] = $this->Main_model->get_latest_products();
        $data['product_glance'] = $this->Main_model->getRandomCategoryProducts();
        $data['category_products'] = $this->Main_model->get_products_by_categories($cat_ids);
        $data['sections_data'] = $this->Main_model->get_sections();
        // print_r($data['category_products']); exit;
        // print_r($this->session->userdata('captcha'));exit;
        $this->load->view('home', $data);

    }
    public function route_bkp()
    {
        $url = array_slice($this->uri->segment_array(), 0);
        // print_r($url);exit;
        $last_segment = get_url_last_segment();
        //echo $last_segment;exit;
        $product_model = $this->Main_model->get_product_details($last_segment);
        //print_r($product_model);exit;
        if (count($product_model) > 0) {
            $this->product_description($product_model);
        }else {
            if (count($url) == 1) {
                $is_section = $this->Main_model->get_section($url);
                if (!empty($is_section)) {
                    $url = str_replace('-', ' ', $url[0]);
                    $this->section($is_section);
                } else {
                    redirect(base_url('error-page'));
                }
            } else if (count($url) > 1) {
                $url = $this->uri->uri_string();
                //echo $url;exit;
                $url = substr($url, ($pos = strpos($url, '/')) !== false ? $pos + 1 : 0);
                //echo $url;exit;
                $this->product_category($url);
            }
        }
    }
   function route()
    {
		$url = array_slice($this->uri->segment_array(), 0);
        $last_segment = get_url_last_segment();
        $scnd_last=$this->uri->segment(1); 
        if($scnd_last=='catalog')error_page();
        $product_model = $this->Main_model->get_product_details($last_segment,$scnd_last);
        //print_r($product_model);exit;
		if(count($product_model) > 0){
            $url_segments_num = count($url);
				if(($url_segments_num)>2) { 
					redirect(base_url().$url[$url_segments_num-2]."/".$url[$url_segments_num-1]);  
				}
            $this->product_description($product_model);
		}else{
			if(count($url) == 1){
                $is_section = $this->Main_model->get_section($url);
                if(!empty($is_section)){
                    $url = str_replace('-',' ',$url[0]);
				    $this->section($is_section);
                }
                else {
						$url = $this->uri->uri_string();
						$url = substr($url, ($pos = strpos($url, '/')) !== false ? $pos + 1 : 0);
						$is_category = $this->Main_model->get_category($url);
						if(!empty($is_category)){
							$this->product_category($url);
						}
						else { error_page(); }
					}			
			}
		}	
	}
    public function section($section_data)
    {
        $data = common_data();
        $data['section_data'] = $section_data;
        $data['meta_info'] = set_meta_data_info($section_data['meta_title'], $section_data['meta_keyword'], $section_data['meta_description']);
        $secalphabets = $this->Main_model->get_alphabets('categories', $section_data['page_url']);
        // echo "<pre>"; print_r($data['categories'] );exit;
        $allseccategories = array();
        foreach ($data['categories'] as $category) {
            if ($category['section'] == $section_data['page_url']) {
                $allseccategories[$category['id']] = $category['name'];
            }
        }
        $sorted_sec_category = array();
        foreach ($secalphabets as $key => $alpha) {
            foreach ($allseccategories as $key => $category) {
                $letter = substr($category, 0, 1);
                if ($letter == $alpha) {
                    $sorted_sec_category[$alpha][$key] = $category;
                }
            }
        }
        $data['secalphabets'] = $secalphabets;
        $data['sorted_sec_category'] = $sorted_sec_category;
        // echo "<pre>"; print_r($secalphabets);exit;
        $this->load->view('common/header', $data);
        $this->load->view('products/section');
    }
   	function product_category($url) 
    { //Load Product Category Page
			$data = common_data();
			$page_data = $this->Main_model->get_category($url);
			if(empty($page_data)){ error_page(); }
			else {
				$data['section_name'] = str_replace(' ','-',$this->uri->segment(1));
				$data['section_url']  = $this->uri->segment(1); 
				$data['category']     = $page_data;
				$data['products']     = $this->get_category_products($data['category']['id']); 
				// if(empty($data['category']['image_url'])) { //remove this code if images are provided for all category/sub category
				// 	$category_id = $data['category']['id'];
				// 	$data['category']['image_url'] = $data['categories'][$category_id]['image_url'];
				// }
				/* START meta title , keyword , description view modification 
					$subcat_title="";
					if($data['category']['parent_id']== FALSE){
					$subcat_title="";
					}else{
					$subcat_title=" | ".$data['categories'][$data['category']['parent_id']]['name'];
					}
                    // 	if(!empty($data['category']['meta_title']) || empty($data['category']['meta_title']))
                    // 	{
                    // 	$data['category']['meta_title']	=$data['categories'][$data['category']['id']]['name'].$subcat_title." | Labotronics";

                    // 	}
                    // 	if(!empty($data['category']['meta_keyword']) || empty($data['category']['meta_keyword']))
                    // 	{
                    // 	$data['category']['meta_keyword']=$data['categories'][$data['category']['id']]['name'].$subcat_title." | Labotronics";
                    // 	}
                    // 	if(!empty($data['category']['meta_description']) || empty($data['category']['meta_description']))
                    // 	{
                    // 	$data['category']['meta_description']=$data['categories'][$data['category']['id']]['name'].",".$subcat_title.","."Shop Online at Labotronics.com!";
                    // 	}
                    // END meta title , keyword , description view modification 
                    
                    //$data['category']['meta_description'] = $data['category']['meta_description']."| Shop Online at Labotronics.com!";
                */
				$data['meta_info'] = set_meta_data_info($data['category']['meta_title'],$data['category']['meta_keyword'],$data['category']['meta_description']);
				$data['random_products'] = $this->Main_model->get_random_products();
                
				
                $data['breadcrumbs'] = array();
                $breadcrumb_url_string = "";
                $data['breadcrumbs']['Home'] = base_url();
                $cat_link_components = explode('/', strtolower(str_replace(' ','-',$data['category']['section'])."/".$data['category']['page_url']));
                foreach($cat_link_components as $key) {
                    $breadcrumb_url_string = $breadcrumb_url_string.$key."/";
                    $data['breadcrumbs'][str_replace('-',' ',$key)] = base_url().$key;
                }
				//echo "<pre>"; print_r($data); echo "</pre>"; exit();
				$this->load->view('products/subproducts', $data);
			}
	}
    	function product_description($product_model)
        { //load single product description page
			$data = common_data();
			$data['product']          = $product_model[0];
			$data['product_tabs']     = $this->get_product_tabs($data['product']);
			$data['price']            = $this->Main_model->get_prod_price($data['product']['sku']);
			$data['related_products'] = $this->Main_model->get_related_products($data['product']['category_id']); // For "Other Customer Viewed Products" or "Suggested Products".
             if($this->input->post()){
                 $this->quote();
             }
			/* START MEta update  */
				if(!empty($data['product']['meta_title']) || empty($data['product']['meta_title'])){
				$data['product']['meta_title']=$data['product']['name'] ." | Medfuge";
				}
				// if(!empty($data['product']['meta_keyword']) || empty($data['product']['meta_keyword'])){
				// $data['product']['meta_keyword']=$data['product']['name'] ." | Labotronics";
				// }
                // 	if(!empty($data['product']['meta_description']) || empty($data['product']['meta_description'])){
                // 				$data['product']['meta_description']=$data['product']['name'] ." | Labotronics";
                // 				}
				if(!empty($data['product']['meta_description']) || empty($data['product']['meta_description'])){
				
				$specifications=$data['product']['specifications'];
				$specification = json_decode($specifications, true);
				$i=1;$m_desc="";
				//print_r($specification);
				foreach($specification as $parameter => $value){
					if($i<5){
					if(!is_array($value)){
					$m_desc .=$parameter."=".$this->seo_friendly_url($value)."; ";
					}
					}
				$i++;}
				
				$data['product']['meta_description']= $data['product']['name'] . " ; " .trim($m_desc)."Shop Online at Medfuge.com!";
				
				}
				
				  
				
		    /*END MEta update  */
			$data['meta_info']        = set_meta_data_info($data['product']['meta_title'],$data['product']['meta_keyword'],$data['product']['meta_description']);
			
			  $data['breadcrumbs'] = array();
                $breadcrumb_url_string = "";
				if($data['categories'][$data['product']['category_id']]['parent_id'] == FALSE){
				$subcat_title="";
			}else{
				$level_id=$data['categories'][$data['product']['category_id']]['parent_id'];
				$subcat_title=" /".strtolower(str_replace(' ','-',$data['categories'][$level_id]['url_title']));
			}
				$section_url = $this->Main_model->get_section_url($data['product']['category_id']);
                $data['breadcrumbs']['Home'] = base_url();
                $cat_link_components = explode('/', strtolower(str_replace(' ','-',$section_url.$data['category']['section'])."/".$data['product']['page_url']));
                //$cat_link_components = explode('/', strtolower($section_url.$subcat_title."/".$data['product']['page_url']));
                $count = count( $cat_link_components);
                //print_r($cat_link_components);
                foreach($cat_link_components as $key => $value) {
                  if($key== $count-1){
                       $data['breadcrumbs'][str_replace('-',' ',$value)] = base_url().$cat_link_components[$key-1]."/".$cat_link_components[$key]; 
                  }else{
                     //$breadcrumb_url_string = $breadcrumb_url_string.$value."/";
                    $data['breadcrumbs'][str_replace('-',' ',$value)] = base_url().$value; 
                  }

                } 
			//echo "<pre>"; print_r($data); echo "</pre>"; //exit;
			$this->load->view('productdescription', $data);      
		}
    public function product_description123($product_model)
    { //load single product description page
        
        $data = common_data();
        $data['product'] = $product_model[0];
        //echo "<pre>";print_r($data['product']);exit;
        $data['product_tabs'] = $this->get_product_tabs($data['product']);
        $data['price'] = $this->Main_model->get_prod_price($data['product']['sku']);
        $data['related_products'] = $this->Main_model->get_related_products($data['product']['category_id']);
        // echo "<pre>"; print_r($data['related_products']);exit;
        
        $product = $data['product'];
        array_splice($product, 4);
        recentlyViewed($product);
        suggestedProducts($data['categories'][$data['product']['category_id']]);
        $data['meta_info'] = set_meta_data_info($data['product']['meta_title'], $data['product']['meta_keyword'], $data['product']['meta_description']);
        $data['breadcrumbs'] = array();
        $breadcrumb_url_string = "";
        
        $data['breadcrumbs']['Home'] = base_url();
       
       
        
        $cat_link_components =  explode('/', strtolower($data['sections'][0]['page_url'] . "/" . $data['product']['page_url']));
        $count = count($cat_link_components);
        // print_r($cat_link_components);
        foreach ($cat_link_components as $key => $value) {
            if ($key == $count - 1) {
                $data['breadcrumbs'][str_replace('-', ' ', $value)] = base_url() . $cat_link_components[$key - 1] . "/" . $cat_link_components[$key];
            } else {
                //$breadcrumb_url_string = $breadcrumb_url_string.$value."/";
                $data['breadcrumbs'][str_replace('-', ' ', $value)] = base_url() . $value;
            }
        }
        if($this->input->post()) {
            $this->quote();
        }
        //echo "<pre>";print_r($data['breadcrumbs']);exit;
        // $this->load->view('common/header',$data);
        // $data = common_data();
        $this->load->view('productdescription', $data);
    }
    public function quote()//product Description
    { 
        if(!empty($this->input->post('captcha3'))){
            if($this->session->userdata('captcha')!=$this->input->post('captcha3')){
                $this->session->set_flashdata('pd_quote_error', 'Entered captcha code does not match! Kindly try again.');
                redirect(base_url());
            }
        }elseif(!empty($this->input->post('captcha4'))){
            if($this->session->userdata('captcha')!=$this->input->post('captcha4')){
                $this->session->set_flashdata('pd_quote_error', 'Entered captcha code does not match! Kindly try again.');
                redirect(base_url());
            }
        }
        if($this->formval->run('get_quote_validation') != false) {
            $data = $this->input->post();
            // print_r($data); exit;
            $name = $data['name'];
            $email = $data['email'];
            // $subject = $data['subject'];
            // $contact_number = $data['phone'];
            $product = $data['product'];
            // $location = $data['location'];
            // $url = $data['url'];
            $message = $data['message'];
            $msg_body = '<style type="text/css"></style>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="all">
                <div class="table-responsive">
                    <h1 style="text-align:center; font-size:20px ;">Quotation Request From <a style="color:#0b5387;" href="<?php echo base_url(); ?>">Mednics.com</a></h1>
                    <br>
                    <table class="table">
                        <tr>
                            <td>
                                <h3><b>Name : </b>' . $name . '</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3><b>Email : </b><a href="mailto:' . $email . '">' . $email . '</a></h3>
                            </td>
                        </tr>
                      
                        <tr>
                            <td>
                                <h3>
                                    <b>Product : </b>
                                    
                                        ' . $product . '
                                
                                </h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h3><b>Message : </b>' . $message . '</h3>
                            </td>
                        </tr>
                    </table>
                </div>  ';
            $headSubject = 'Quotation Request - www.mednics.com';
            $to = EMAIL_WEBSITE;
            $cc = EMAIL_WEBSITE_CC;
            $from = $email;

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            
            $result = $this->email
                ->from($from, $name)
                ->to($to)
                ->subject($headSubject)
                ->message($msg_body)
                ->set_header('From', $from)
                ->set_header('Cc', $cc)
                ->set_header('header', $headers)
                ->send();
            
            $referral_url = $this->agent->referrer();
            if ($result) {
                $this->session->set_flashdata('pd_quote_success', 'Product quotation request sent!<br>We will get back to you soon');
                //  redirect($referral_url);
                redirect(base_url('thankyou'));
            } else {
                $this->session->set_flashdata('pd_quote_error', 'Something went wrong, Please try again');
                //redirect(base_url());
                redirect($referral_url);
            }
        } else {
            $this->session->set_flashdata('pd_quote_not_submitted', 'Quotation not submitted!<br>Please recheck your quote request.');
        }
    }
    public function enquiry()//enquiry
    {
        if(!empty($this->input->post('captcha2')) ){
            if($this->session->userdata('captcha')!=$this->input->post('captcha2')){
                $this->session->set_flashdata('qq_quote_error', 'Entered captcha code does not match! Kindly try again.');
                redirect(base_url());
            }
        }
        
        if ($this->formval->run('enquiry_validation') != false) {
            $data = $this->input->post();
            // print_r($data); exit;
            $name = $data['qq_name'];
            $email = $data['qq_email'];
            $subject = $data['qq_subject'];
            // $number = $data['qq_number'];
            $product = $data['qq_product'];
            $message = $data['qq_message'];
            // $location = $data['qq_location'];
            $value = $data['qq_value'];
            // $url = $data['url'];
            $msg_body = '<style type="text/css">
                </style>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="all">
                <div class="table-responsive">
                    <h1 style="text-align:center; font-size:20px">Enquiry From <a style="color:#0b5387;" href="<?php echo base_url(); ?>">Mednics.com</a></h1>
                    <br>
                    <table class="table">
                        <tr>
                            <td>
                                <b>Name : </b>' . $name . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Email : </b><a href="mailto:' . $email . '">' . $email . '</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Product Name : </b>' . $product . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Subject : </b>' . $subject . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Product Details :</b> ' . $message . '
                            </td>
                        </tr>
                    </table>
                </div>  ';
            $headSubject = 'Quick Quotation Request - www.mednics.com';
            $to = EMAIL_WEBSITE;
            $cc = EMAIL_WEBSITE_CC;
            $from = $email;

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            $result = $this->email
                ->from($from, $name)
                ->to($to)
                ->subject($headSubject)
                ->message($msg_body)
                ->set_header('From', $from)
                ->set_header('Cc', $cc)
                ->set_header('header', $headers)
                ->send();
                //$result =1;
            $referral_url = $this->agent->referrer();
            if ($result) {
                $this->session->set_flashdata('quote_success', 'Product quotation request sent!<br>We will get back to you soon');
                //  redirect($referral_url);
                redirect(base_url('thankyou'));
            } else {
                $this->session->set_flashdata('quote_error', 'Something went wrong, Please try again');
                //redirect(base_url());
                redirect($referral_url);
            }
        } else {
            $this->session->set_flashdata('quote_not_submitted', 'Quotation not submitted!<br>Please recheck your quote request.');
            // $referral_url = $this->agent->referrer();
            //redirect($referral_url);
        }
    }
    public function get_category_products($id)
    { //get  all products for specific category/subcategory
        $category_ids = $this->Main_model->get_products_category_id($id);
        $products = $this->Main_model->get_products($category_ids);
        return $products;
    }
    public function get_product_tabs($product)
    {
        $get_all_tabs = $this->Main_model->get_all_tabs();
        $product_tabs = array();
        foreach ($get_all_tabs as $attribute) {
            foreach ($product as $product_attribute => $value) {
                if ($product_attribute == $attribute['prt_tab_name'] && $value != '') {
                    $product_tabs[] = $attribute;
                }
            }
        }
        return $product_tabs;
    }
    public function all_products()
    {
        $data = common_data();
        $data['products'] = $this->Main_model->get_all_products();
        //echo "<pre>"; print_r($data['products']);exit;
        $productalphabet = $this->Main_model->get_alphabets('products');
        $allproducts = array();
        foreach ($data['products'] as $product) {
            $allproducts[$product['id']] = $product['name'];
        }
        $sorted_products = array();
        foreach ($productalphabet as $key => $alpha) {
            foreach ($allproducts as $key => $product) {
                $letter = substr($product, 0, 1);
                if ($letter == $alpha) {
                    $sorted_products[$alpha][$key] = $product;
                }
            }
        }
        $data['productalphabet'] = $productalphabet;
        $data['sorted_product'] = $sorted_products;
        //echo "<pre>";print_r($data['products']);exit;
        $this->load->view('products/product', $data);
    }
    public function products_by_category()
    {
        $data = common_data();
        $catalphabet = $this->Main_model->get_alphabets('categories');
        $allcategories = array();
        foreach ($data['categories'] as $category) {
            $allcategories[$category['id']] = $category['name'];
        }
        $sorted_category = array();
        foreach ($catalphabet as $key => $alpha) {
            foreach ($allcategories as $key => $category) {
                $letter = substr($category, 0, 1);
                if ($letter == $alpha) {
                    $sorted_category[$alpha][$key] = $category;
                }
            }
        }
        $data['catalphabet'] = $catalphabet;
        $data['sorted_category'] = $sorted_category;
        // echo "<pre>";print_r($data['sorted_category']);exit;
        $this->load->view('products_by_category', $data);
    }
    public function product_compare()
    {
        if (isset($_GET['products'])) {    
            $sku = explode(",", $_GET['products']);
            $result = $this->Main_model->product_compare($sku);
            if (empty($result)) {
                redirect(base_url('product'));
            } else {
                $keys = array();
                $uni = array();
                foreach ($result as $row) {
                    $spec = json_decode($row['specifications'], true);
                    foreach ($spec as $key => $value) {
                        if (!in_array($key, $uni)) {
                            $uni[] = $key;
                        }
                    }
                }
                foreach ($result as $row) {
                    $spec = json_decode($row['specifications'], true);
                    foreach ($uni as $k) {
                        if (!isset($spec[$k]) || empty($spec[$k])) {
                            $keys[$k]['child'][] = "&mdash;";
                        } else {
                            $keys[$k]['child'][] = $spec[$k];
                        }
                    }
                }
                $data = common_data();
                // echo "<pre>";print_r($keys);print_r($result);exit;
                $this->load->view('common/header', $data);
                $this->load->view('products/compare', array('keys' => $keys, 'products' => $result));
            }
        } else {
            redirect(base_url('error-page'));
        }
    }
    public function about_us()
    {
        $data = common_data();
        $this->load->view('aboutus', $data);
    }
    public function privacy_policy()
    {
        $data = common_data();
        $this->load->view('policies', $data);
    }
    public function site_map()
    {
        $data = common_data();
        $this->load->view('sitemap', $data);
    }
    public function certificate()
    {
        $data = common_data();
        $this->load->view('certificate', $data);
    }
    public function team_us()
    {
        $data = common_data();
        $this->load->view('teamus', $data);
    }
    public function gallery()
    {
        $data = common_data();
        $this->load->view('gallery', $data);
    }
    // public function contact_us()
    // {
    //     $data = common_data();
    //    $this->load->view('contactus', $data);
    // }
    public function contact_us()//Contact us
    {   
        
        if(!empty($this->input->post('captcha')) ){
            if($this->session->userdata('captcha')!=$this->input->post('captcha')){
                $this->session->set_flashdata('alert_error', 'Entered captcha code does not match! Kindly try again.');
                redirect(base_url());
            }
        }
            if ($this->formval->run('contactus_validation') != false) {
                $name = $this->input->post('name');
                $from = $this->input->post('email');
                $contact_no = $this->input->post('phone');
                $message = $this->input->post('message');
                $subject = $this->input->post('subject');
                  
                $to = EMAIL_WEBSITE;
                $cc = EMAIL_WEBSITE_CC;
                $subject = 'Mednics.com Inquiry - ' . $subject;
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
                $headers .= 'From: ' . $from . "\r\n";

                $msg_body = 
                '<b>Name:</b>' . $name  . "<br><br>" . 
                '<b>Email:</b>' . $from  . "<br><br>" . 
                '<b>Contact Number:</b> ' . $contact_no . "<br><br>" . '
                <b>Subject:</b> ' . $subject . "<br><br>" . '
                <b>Message:</b>' . $message . '<br><br>
                    --
                This e-mail was sent from a Contact form ('. base_url() .')';
                    
                $result = $this->email
                    ->from($from, $name)
                    ->to($to)
                    ->subject($subject)
                    ->message($msg_body)
                    ->set_header('Cc', $cc)
                    ->send();
                    
                if ($result) {
                    $this->session->set_flashdata('alert_success', 'Your Message was sent successfully, We\'ll get back to you soon');
                    redirect(base_url('thankyou'));
                } else {
                    $this->session->set_flashdata('alert_error', 'Something went wrong, Please try again');
                }
            } 
            
        $data = common_data();
        $this->load->view('contactus', $data);
    }
    public function upload_file()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'doc|docx|pdf';
        $this->load->library('upload', $config);
        //echo "here";
        if($this->upload->do_upload('myfile')){
            //echo '111';exit;
            return $this->upload->data();
        }else{
            //echo '111';exit;
            return $this->upload->display_errors();
        }
    }
    public function catalogs_bkp()
    {
        $data = common_data();
        $data['products'] = $this->Main_model->get_all_products();
        //  echo "<pre>"; print_r($data['products']);exit;
        $productalphabet = $this->Main_model->get_alphabets('products');
        $allproducts = array();
        foreach ($data['products'] as $product){
            $allproducts[$product['id']] = $product['name'];
        }
        $sorted_products = array();
        foreach($productalphabet as $key => $alpha){
            foreach($allproducts as $key => $product){
                $letter = substr($product, 0, 1);
                if($letter == $alpha){
                    $sorted_products[$alpha][$key] = $product;
                }
            }
        }
        $data['productalphabet'] = $productalphabet;
        $data['sorted_product'] = $sorted_products;
        $this->load->view('catalog', $data);
    }
    public function catalogs()
    {
        $data = common_data();
        
        $catalphabet = $this->Main_model->get_alphabets('categories');
       
        $allcategories = array();
        foreach($data['categories'] as $category){
            $allcategories[$category['id']] = $category['name'];
        }
       //echo "<pre>"; print_r($catalphabet);exit;
        $sorted_category = array();
        foreach($catalphabet as $key => $alpha){
            foreach($allcategories as $key => $category){
                $letter = substr($category,0,1);
                if($letter == $alpha && empty($data['categories'][$key]['children_ids'])){
                    $sorted_category[$alpha][$key] = $category;
                }
            }
        }
        $data['catalphabet'] = $catalphabet;
        $data['sorted_category'] = $sorted_category;
        $this->load->view('catalog',$data);
        
    }
    public function catalog()
    { /* Single catalogs page*/
        $data = common_data();
        $data['current_date'] = date('Y-m-d'); // Get the current date
        $last_segment = get_url_last_segment();
        $url_count=$this->uri->total_segments();
        $scnd_last=$this->uri->segment($url_count-1);
        if($scnd_last=='catalog');
        $data['product'] = $this->Main_model->get_product_details($last_segment,$scnd_last);
        //echo "<pre>";print_r($data['product']);exit;
        if(empty($data['product'])){
            redirect(base_url('product'));
        }else{
            $data['product'] = $data['product'][0];
            $data['product_tabs'] = $this->get_product_tabs($data['product']);
            $data['meta_info'] = set_meta_data_info($data['product']['meta_title'], $data['product']['meta_keyword'], $data['product']['meta_description']);
            // echo "<pre>";print_r($data);exit;
            //$this->load->view('common/header',$data);
            $this->load->view('products/singlecatalog', $data);
        }
    } 
    public function getproducts_cat()
    { //get all product models under a category...for catalog
        $data = $this->input->post();
        //print_r($data);exit;
        $ids = $this->Main_model->get_products_category_id($data['id']);
        // echo "111";exit;
        $result = $this->Main_model->get_products($ids);
        $products = array();
        foreach($result as $res){
            $products[] = array_slice($res, 0, 4);
        }
        echo json_encode($products);
    }
    public function addToCart()
    {
        $data = $this->input->post();
        $sku = $this->uri->segment(2);
        $product = $this->Main_model->addToCart($sku);
        $price = $this->Main_model->get_product_price($sku);
        if(empty($price)){
            $product_price = 0;
        }else{
            $product_price = $price['final_inr'];
        }
        $cartdata = array(
            'id' => $sku,
            'qty' => 1,
            'price' => $product_price,
            'name' => $product['name'],
            'options' => array('image_url' => $product['image_url'], 'product_url' => $data['product_url']),
        );
        //  print_r($cartdata);exit;
        $this->cart->insert($cartdata);
        print count($this->cart->contents());
    }
    public function removefromcart()
    {
        $data = $this->input->post();
        $cartdata = array(
            'rowid' => $data['rowid'],
            'qty' => 0,
        );
        $this->cart->update($cartdata);
        print count($this->cart->contents());
    }
    public function update_cart()
    {
        $data = $this->input->post();
        $cartdata = array(
            'rowid' => $data['rowid'],
            'qty' => $data['qty'],
        );
        $this->cart->update($cartdata);
        print count($this->cart->contents());
    }
    public function emptycart()
    {
        $this->cart->destroy();
    }
    public function search_products()
    {
        $data = common_data();
        $res['page_url'] = $this->uri->segment_array();
        if($this->formval->run('searchbox_validation') == false)
        {
            //echo "11";exit;
            $user_input = $this->input->get('search');
            $product = $this->Main_model->search_product_by_key($user_input);
            $data['searched_products'] = $product;
            $data['search_key'] = $user_input;
        
            // print_r($data['searched_products']);exit;
            $this->load->view('common/header', $data);
            $this->load->view('products/search');
        }
        else
        {
             error_page();
        }  
    }
    public function thankyou_page()
    {
        $data = array();
        $meta_title = 'Thank you | Get Quote | Medfuge.com Equipment Ltd';
        $meta_keyword = 'Thank you,Get Quote, Medfuge.com Equipment Ltd';
        $meta_description = 'Thank you,Get Quote, Medfuge.com Equipment Ltd';
        $thank_you = 6;
        /****** COMMON DATA  ****/
        $data = common_data($meta_title, $meta_keyword, $meta_description, $thank_you);
        /****** COMMON DATA  ****/
        $data['page_type'] = 6;
        $this->load->view('common/thankyou', $data);
    }
    public function error_page_404()
    {
        $data = array();
        /****** COMMON DATA  ****/
        $data = common_data();
        /****** COMMON DATA  ****/
        $this->load->view('common/error', $data);
    }
    function seo_friendly_url($string)
    {
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-'));
    }
    function ajx_captcah_image()
    {
	
        echo captcha_image_rand();
    }
    public function reCaptcha_curl($captcha_response)
    {	
			

        $keySecret = '6LcEgfAgAAAAANJfz54nIeiTAf_WhsmcvRk64Ehs';

        $check = array(
            'secret'		=>	$keySecret,
            'response'		=>	$captcha_response
        );

        $startProcess = curl_init();

        curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");

        curl_setopt($startProcess, CURLOPT_POST, true);

        curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));

        curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);

        $receiveData = curl_exec($startProcess);

        $finalResponse = json_decode($receiveData, true);
        if($finalResponse['success']){
            return true;
        }else{
            return false;
        }
    }
}