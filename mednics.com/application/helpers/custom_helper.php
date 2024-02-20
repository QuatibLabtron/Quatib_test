<?php

    function breadcrumbs_data(){

        $CI = &get_instance();

        $url = $CI->uri->segment_array();

		$total = $CI->uri->total_segments();

		$breadcrumbs['Home'] = base_url();

		$breadcrumb_link[0] = base_url(); 

        if(in_array('catalog',$url)){

            $breadcrumbs=array();

        }else{

		for($i=1;$i<=$total;$i++){

			$breadcrumb_link[$i]=$breadcrumb_link[$i-1].$CI->uri->segment($i)."/";

			$breadcrumbs[str_replace('-',' ',$CI->uri->segment($i))] = $breadcrumb_link[$i];

		}

    }

		return $breadcrumbs;

    }

    function common_data(){

        $CI = &get_instance();

        $cat_ids = $CI->session->userdata('id');

        $data['breadcrumbs'] = breadcrumbs_data();

		$last_segment = get_url_last_segment();

        if($last_segment == '') $last_segment='home';

        $page_data = $CI->Main_model->get_page_data($last_segment);

       // print_r($page_data);

        if(!empty($page_data)){

            $data['meta_info'] = set_meta_data_info($page_data['meta_title'],$page_data['meta_keyword'],$page_data['meta_description']); 

        }else{

             $data['meta_info'] = set_meta_data_info('','','');

        }

           

		$section = $CI->Main_model->get_all_section();

        $data['sections'] = $section;

       $data['categories'] = $CI->Main_model->get_all_categories();

       $data['random_categories']   = $CI->Main_model->get_random_categories(); // For product categories.

        $data['latest_products'] = $CI->Main_model->get_latest_products();

        $data['random_products'] = $CI->Main_model->get_random_products();

        return $data;

    }

    function get_user_profile_data(){

        $CI = &get_instance();

        $user_status = $CI->session->userdata('response_status');

        $user_email = $CI->session->userdata('email');

        if(!empty($user_status)){

            $result = $CI->User_model->get_user_profile_data($user_email);

            // echo "<pre>";print_r($result);

            return $result;

        }

        else return 0;

    }

    function get_url_last_segment(){

        $CI = &get_instance();

        $total = $CI->uri->total_segments();

		$last_segment = $CI->uri->segment($total);

        return $last_segment;

    }

    function set_meta_data_info($title,$keyword,$description){

        if($title == '') $title = META_TITLE; // Default constants values

        if($keyword == '')

            $keyword = META_KEYWORD;

        if($description == '')

            $description = META_DESCRIPTION;

        return array('meta-title' => $title,'meta-keyword' => $keyword,'meta-description' => $description);

    }

    function error_page(){

        $CI = &get_instance();

		$data = common_data();

        $data['meta_info'] = set_meta_data_info('','','');

		$CI->load->view('common/error' ,$data);

    }

     function suggestedProducts($data=NULL){

        $CI = &get_instance();

        $category = $CI->session->userdata('category');//declare session array to store visited category

        $suggestedProducts = $CI->session->userdata('suggestedProducts');//declare session array to store suggested products

        if(empty($suggestedProducts)){

            $suggestedProducts = array();  

        }

        if(!is_array($category)){

            $category = array();  

        }

        $first_products = $CI->Main_model->get_first_products();//get first products

        if(!empty($data)){

            $sugcategories = $data['all_children_ids'];

            if(!in_array($data['id'],$category)){

                $category[] = $data['id'];

            }

            foreach($sugcategories as $key => $value){

                if(!in_array($value,$category)){

                    $category[] = $value;

                }

            }

        }

        if(!empty($category)){

            //echo "not first visit";

            $category_products = $CI->Main_model->get_first_product_category($category);//get first products of categories

            $suggestedProducts = array_merge($suggestedProducts,$category_products);

            if(sizeof($suggestedProducts)<3){//at least 3 products required

                foreach($first_products as $fst_products){

                    if(sizeof($suggestedProducts)<=10){

                        if(!in_array($fst_products,$suggestedProducts)){

                            $suggestedProducts[] = $fst_products;

                        }

                    }

                }

            $CI->session->set_userdata('category', $category);

            $CI->session->set_userdata('suggestedProducts', ($suggestedProducts));

            }

            else if(sizeof($suggestedProducts)>10){//only 10 recent category products will be displayed

                for($i=9;$i<=sizeof($suggestedProducts);$i++)

                    array_shift($suggestedProducts);

                $CI->session->set_userdata('category', $category);

                $CI->session->set_userdata('suggestedProducts', array_reverse($suggestedProducts));

            }

            else {

                $CI->session->set_userdata('category', $category);

                $CI->session->set_userdata('suggestedProducts', array_reverse($suggestedProducts));

            }

        }

        else if(empty($category)){

            //echo "first visit";

            if(sizeof($first_products)>10){//only 10 recent category products will be displayed

                for($i=sizeof($first_products);$i>=10;$i--)

                    array_shift($first_products);

            }

            $CI->session->set_userdata('suggestedProducts', $first_products);

        }  

    }

     function recentlyViewed($data){

        $CI = &get_instance();

        $skus = $CI->session->userdata('skus');//declare session array to store visited products

        $recentlyViewed = $CI->session->userdata('recentlyViewed');//declare session array to store recent products

        $recentlyViewed = array();

        if(!is_array($skus)){

            $skus = array();  

        }

        if(sizeof($skus)>10){//only 10 recent products will be displayed

            array_shift($skus);

        }

        //here set your id or page or whatever

        if(!empty($data['sku'])){

            if(!in_array($data['sku'],$skus)){

                $skus[] = $data['sku'];

            }

        } 

        $products = $CI->Main_model->product_compare($skus);

        foreach($skus as $sku){//this loop is for sorting the products in the same order as sku

            foreach($products as $product){

                if($product['sku']==$sku)

                    array_push($recentlyViewed,$product);

            }

        }

        $recentlyViewed = array_reverse($recentlyViewed);

        $CI->session->set_userdata('skus', $skus);

        $CI->session->set_userdata('recentlyViewed', $recentlyViewed);

    }

    function captcha_common_html($id=""){

		

        $captcha_box='<div class="capbox">

                        <div class="fake-input">

        <img src="'.base_url('load-captcha-image?rand=rand()').'"  id="captcha_image'.$id.'"  class="captcha_image" alt="captcha'.$id.'">

        <input class="captcha-control captcha_input" placeholder="Enter Captcha" type="text" name="captcha'.$id.'"  required="required">

        <div class="refresh">

        <a href="javascript: refreshCaptcha'.$id.'();" title="Can`t read? Click here to Refresh"> <i class="fa fa-refresh" aria-hidden="true"></i></a><br>

        </div>

        </div>

        </div>';

        echo $captcha_box;	

    }
    

    function captcha_image_rand(){

	

        error_reporting(E_ALL);

         $CI = &get_instance();

        //You can customize your captcha settings here

    

        $captcha_code = '';

        $captcha_image_height = 50;

        $captcha_image_width = 130;

        $total_characters_on_image = 4;

    

        //The characters that can be used in the CAPTCHA code.

        //avoid all confusing characters and numbers (For example: l, 1 and i)

        $possible_captcha_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZbcdfghjkmnpqrstvwxyz23456789';

        $captcha_font = dirname(__FILE__).'/fonts/monofont.ttf';

    

        $random_captcha_dots = 50;

        $random_captcha_lines = 25;

        $captcha_text_color = "0x142864";

        $captcha_noise_color = "0x142864";

    

    

        $count = 0;

        while ($count < $total_characters_on_image) { 

        $captcha_code .= substr(

            $possible_captcha_letters,

            mt_rand(0, strlen($possible_captcha_letters)-1),

            1);

        $count++;

        }

    

        $captcha_font_size = $captcha_image_height * 0.65;

        $captcha_image = @imagecreate(

            $captcha_image_width,

            $captcha_image_height

            );

    

        /* setting the background, text and noise colours here */

        $background_color = imagecolorallocate(

            $captcha_image,

            255,

            255,

            255

            );

    

        $array_text_color = hextorgb($captcha_text_color);

        $captcha_text_color = imagecolorallocate(

            $captcha_image,

            $array_text_color['red'],

            $array_text_color['green'],

            $array_text_color['blue']

            );

    

        $array_noise_color = hextorgb($captcha_noise_color);

        $image_noise_color = imagecolorallocate(

            $captcha_image,

            $array_noise_color['red'],

            $array_noise_color['green'],

            $array_noise_color['blue']

            );

    

        /* Generate random dots in background of the captcha image */

        for( $count=0; $count<$random_captcha_dots; $count++ ) {

        imagefilledellipse(

            $captcha_image,

            mt_rand(0,$captcha_image_width),

            mt_rand(0,$captcha_image_height),

            2,

            3,

            $image_noise_color

            );

        }

    

        /* Generate random lines in background of the captcha image */

        for( $count=0; $count<$random_captcha_lines; $count++ ) {

        imageline(

            $captcha_image,

            mt_rand(0,$captcha_image_width),

            mt_rand(0,$captcha_image_height),

            mt_rand(0,$captcha_image_width),

            mt_rand(0,$captcha_image_height),

            $image_noise_color

            );

        }

    

        /* Create a text box and add 6 captcha letters code in it */

        $text_box = imagettfbbox(

            $captcha_font_size,

            0,

            $captcha_font,

            $captcha_code

            ); 

        $x = ($captcha_image_width - $text_box[4])/2;

        $y = ($captcha_image_height - $text_box[5])/2;

        imagettftext(

            $captcha_image,

            $captcha_font_size,

            0,

            $x,

            $y,

            $captcha_text_color,

            $captcha_font,

            $captcha_code

            );

    

        /* Show captcha image in the html page */

        // defining the image type to be shown in browser widow

        header('Content-Type: image/jpeg'); 

        imagejpeg($captcha_image); //showing the image

        imagedestroy($captcha_image); //destroying the image instance

        //$_SESSION['captcha'] = $captcha_code;

        $CI->session->set_userdata('captcha', $captcha_code);

    

        

    }

    function hextorgb($hexstring){

      $integar = hexdec($hexstring);

      return array("red" => 0xFF & ($integar >> 0x10),

        "green" => 0xFF & ($integar >> 0x8),

        "blue" => 0xFF & $integar);

    }

?>