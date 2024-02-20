<?php

class Main_model extends CI_Model

{

    public function __construct()

    {    

	}

    function get_random_categories()

    {

        $this->db->select('id,description')->from('categories')->where('status',1)->order_by('id', 'RANDOM');

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        return $response;

    }

    function get_random_products()

    {

        $this->db->select('name,description,sku,category_id,specifications,features,image_url,page_url,catalog_url')->from('products')->where('status',1)->order_by('id', 'RANDOM');

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        foreach($response as $pindex => $single_product){

            $product_spec = json_decode($single_product['specifications'],true);

            $response[$pindex]['specifications'] = array_slice($product_spec,0,5);

        }

        // echo "<pre>";print_r($response);exit;

        return $response;

    }

    function get_related_products($id)

    {

        $this->db->select('name,sku,category_id,image_url,page_url,specifications')->from('products')->where('category_id',$id)->order_by('name', 'ASC')->limit(10);

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        /*foreach($response as $pindex => $single_product){

            $product_spec = json_decode($single_product['specifications'],true);

            $response[$pindex]['specifications'] = array_slice($product_spec,0,4);

        }*/

        // echo "<pre>";print_r($response);exit;

        return $response;

    }

    function get_all_categories()

    {//get all categories level wise

        $this->db->select('*')->from('categories')->where('status',1)->order_by('name, level');

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        $categories = array();

        foreach($response as $category){

            $categories[$category['id']] = $category;

        }        

        foreach($categories as $category_id => $category) {

            if($category['level'] == 0) {       

                $categories[$category_id]['all_children_ids'] = array();

                $categories[$category_id]['children_ids'] = array(); 

                $this->make_nodes_leaves($categories, $category_id);                

            }

        }

        $products = $this->get_first_products();

        foreach($categories as $category){

            foreach($products as $product){

                if($category['id']==$product['category_id']){

                    $categories[$category['id']]['image_url'] = $product['image_url'];

                }

                if(!empty($category['all_children_ids'])){

                    for($i=0;$i<sizeof($category['all_children_ids']);$i++){

                        if($category['all_children_ids'][$i]==$product['category_id']){

                            $categories[$category['id']]['image_url'] = $product['image_url'];

                        }

                    }

                }

            }

            //$categories[$category['id']]['category_url'] =  base_url().strtolower(str_replace(' ','-',$category['section']))."/".$category['page_url']; 

            $categories[$category['id']]['category_url'] =  base_url().strtolower($category['url_title']); 

        }

        return $categories;        

    }

    function make_nodes_leaves(&$categories, &$parent_id)

    {//creating tree structure for category hierarchy

        foreach($categories as $category_id => $category) {

            if($category['parent_id'] == $parent_id){

                $categories[$parent_id]['children_ids'][] = $category_id;

                $categories[$parent_id]['all_children_ids'][] = $category_id;

                $categories[$category_id]['all_children_ids'] = array();

                $categories[$category_id]['children_ids'] = array();

                $this->make_nodes_leaves($categories, $category_id);

                $categories[$parent_id]['all_children_ids'] = array_merge($categories[$parent_id]['all_children_ids'], $categories[$category_id]['all_children_ids']);

            }   

        }

    }

    function get_first_products()

    {//get first product of all categories

        $this->db->select('sku,name,category_id,description,image_url,page_url')->from('products')->where('status',1)->order_by('category_id');

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        $products = array();

        foreach($response as $product){

            if(empty($products[$product['category_id']])){

                $products[$product['category_id']] = $product;

            }            

        }

        //echo "<pre>"; print_r($response); print_r($products); exit;

        return $products;             

    }

    function get_product_details($sku,$scnd_last)

    {//get individual product details from sku

        // $this->db->select('*')->from('products')->where('sku',$sku)->where('status',1);          

        $scnd_last1=str_replace("-"," ",$scnd_last);

        if($scnd_last=='catalog'){

            $this->db->select('t1.*')

            ->from('products as t1')

            ->join('categories as t2','t1.category_id=t2.id','left')

            ->where(array('t1.sku'=>strtoupper($sku),'t1.status'=>1));

        }else{

        $this->db->select('t1.*')

        ->from('products as t1')

        ->join('categories as t2','t1.category_id=t2.id','left')

        ->where(array('t1.sku'=>strtoupper($sku),'t1.status'=>1))

        ->group_start()

        ->or_where(array('LOWER(t2.`name`)'=>$scnd_last1,'LOWER(t2.`url_title`)'=>$scnd_last))

        ->group_end(); 

        }         

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();//result_Array necessary for count

	            if(!empty($response[0]['features'])){

	            if(strpos($response[0]['features'],"<br>")){

	                $tag = "<br>";

	            }

	            else if(strpos($response[0]['features'],"</br>")){

	                $tag = "</br>";

	            }

	            else if(strpos($response[0]['features'],"<br/>")){

	                $tag = "<br/>";

	            }

	            //echo $tag;

	            //$response[0]['features'] = preg_split('/(<br>)/', $response[0]['features'] , -1, PREG_SPLIT_NO_EMPTY); 

	            $response[0]['features'] = explode($tag, $response[0]['features']);

            }

            if(!empty($response[0]['applications'])){

	            if(strpos($response[0]['applications'],"<br>")){

	                $tag = "<br>";

	            }

	            else if(strpos($response[0]['applications'],"</br>")){

	                $tag = "</br>";

	            }

	            else if(strpos($response[0]['applications'],"<br/>")){

	                $tag = "<br/>";

	            }

	            //echo $tag;

	            //$response[0]['features'] = preg_split('/(<br>)/', $response[0]['features'] , -1, PREG_SPLIT_NO_EMPTY); 

	            $response[0]['applications'] = explode($tag, $response[0]['applications']);

            }

        } // <br> </br> </ br>              

        return $response;

    }

    function get_all_tabs()

    {

        $this->db->select('prt_name,prt_tab_name')->from('product_tabs');        

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        return $response;

    }

    function get_prod_price($sku)

    {

        $this->db->select('*')->from('price_list')->where('sku',$sku);       

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->row_array();

        }

        return $response;

    }

    function get_section($url)

    {

        $this->db->select('*')->from('sections')->where('page_url',$url[0]);

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->row_array();

        }

        return $response;        

    } 

    function get_section_url($id)

    {

        $this->db->select('section')->from('categories')->where('status',1)->where('id',$id); 

        $query = $this->db->get();

        $response = $query->result_array();

        //print_r($response);exit;

       return $response[0]['section'];

    }

    function get_category_bkp($url)

    {//get individual category details from url

        $this->db->select('*')->from('categories')->where('status',1)->where('page_url',$url);       

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->row_array();

        }

        return $response;

    }

    function get_category($url)

    {//get individual category details from url

        $this->db->select('*')->from('categories')->where('status',1)->where('url_title',$url);       

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->row_array();

        }

        return $response;

    }

    function get_products_category_id($id)

    {//get all category/sub category id related to specific category/sub category

        $this->db->select('id')->from('categories')->where('parent_id',$id)->or_where('id',$id); 

        $subQuery =  $this->db->get_compiled_select();

        $this->db->select('id')->from('categories')->where('status',1)->where("parent_id IN ($subQuery)", NULL, FALSE)->or_where('id',$id);      

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        $category_ids = array();

        foreach($response as $category){

            $category_ids[] = $category['id'];

        }

        return $category_ids;

    }

    function get_products($ids)

    {//get all products related to specific category/sub categories

        $this->db->select('id,sku,name,catalog_url,specifications,features,image_url,page_url,category_id')->from('products')->where('status',1)->where_in('category_id',$ids);

        $this->db->order_by('sku','ASC');

        $query = $this->db->get();

        //echo $this->db->last_query();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        return $response;

    }

    function addToCart($sku)

    {

        $this->db->select('sku,name,image_url')->from('products')->where('sku', $sku)->where('status',1);

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->row_array();

        }

        return $response;

    }

    function get_product_price($sku)

    {

        $this->db->select('*')->from('price_list')->where('sku', $sku);

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->row_array();

        }

        return $response;

    }

    function get_alphabets($table,$section=NULL)

    {

        $this->db->select('SUBSTRING(name,1,1) as alpha',FALSE);

        $this->db->where('status',1);

        if($section != NULL){

           $this->db->where('section',$section); 

        }

        $this->db->order_by('name','ASC');

        $query = $this->db->get($table);

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        $alpha = array();

        foreach($response as $letter){

            if(!in_array($letter['alpha'],$alpha)){

                $alpha[] = $letter['alpha'];                

            }

        }

        return $alpha;

    }

    function get_all_section()

    {

        $this->db->select('id,section,page_url,meta_title,meta_keyword,meta_description')->from('sections')->order_by('section');

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        return $response;        

    }

    function get_sections()

    {

        $this->db->select('id,section,description,page_url,meta_title,meta_keyword,meta_description')->from('sections')->where('section','Heating Equipment')->or_where('section','Laboratory Equipment')->order_by('section','desc');

		$query = $this->db->get();

		$response = array();

		if($query->num_rows() > 0){

			$response = $query->result_array();

		}

		return $response;        

    }

    function get_page_data($url)

    {

        $this->db->select('*')->from('pages')->where('page_url',$url);

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->row_array();

        }

        return $response;

    }

    function product_compare($skus)

    {//get details of multiple products based on sku

        $this->db->select('id,name,sku,category_id,specifications,page_url,image_url')->from('products')->where_in('sku', $skus)->order_by('name'); 

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        return $response;

    }

    function search_product_by_key($user_input)

    {

        //$user_input= 'furnace';

        $this->db->select('id,sku,name,category_id,page_url,features,image_url,catalog_url,specifications')->from('products')->like('name',$user_input);

        $query = $this->db->get();

        //print_r($this->db->last_query()); exit;

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        // print_r($response);exit;

        return $response;

    }

    function get_all_products()

    {// get all products

        $this->db->select('id,sku,name,category_id,page_url')->from('products')->order_by('name','ASC');

        $query = $this->db->get();

        $response = array();    

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        $products = array();

        foreach($response as $category){

            $products[$category['id']] = $category;

        } 

        // print_r($products); die();

        return $products;

    }

    function get_first_product_category($ids)

    {//get first products only related to specific category/sub categories

        //print_r($ids);

        $this->db->select('sku,name,category_id,image_url,page_url')->from('products')->where('status',1)->where_in('category_id',$ids)->group_by('category_id');

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        return $response;

    }

    function get_latest_products()

    {

        $this->db->select('name,sku,category_id,image_url,page_url,catalog_url')->from('products')->where('status',1)->order_by('created_dt', 'DESC')->limit(10);

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        return $response;

    }

    function get_products_by_categories($category_ids)

    {//get products for sub categories

        

        $this->db->select('id,name,sku,category_id,page_url,image_url,catalog_url')->from('products')->where_in('category_id', $category_ids)->order_by('name','RANDOM');

        $query = $this->db->get();

		$response = array();

		if($query->num_rows() > 0){

			$response = $query->result_array();

        }

        // print_r($response); exit;

		return $response;

    }

    function get_random_product_category()

    {

        $this->db->select('name,description,sku,category_id,features,specifications,image_url,page_url,catalog_url')->from('products')->where('status',1)->order_by('id', 'RANDOM');

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        foreach($response as $pindex => $single_product){

            $product_spec = json_decode($single_product['specifications'],true);

            $response[$pindex]['specifications'] = array_slice($product_spec,0,5);

        }

        // echo "<pre>";print_r($response);exit;

        return $response;

    }

    function getRandomCategoryProducts()

    {

        $this->db->select('id, name')->from('categories')->where('status',1)->where('level',0)->order_by('id', 'RANDOM')->limit(4);

        $query = $this->db->get();

        $response = array();

        if($query->num_rows() > 0){

            $response = $query->result_array();

        }

        // echo "<pre>";print_r($response);exit;

        $random_array =array();

        foreach($response as $categories){

            //echo $categories['id']."===".$categories['name']."<br>";

            $category_ids = $this->get_products_category_id($categories['id']);

            $products =$this->get_products($category_ids);

            $random_array[$categories['name']] = $products;

        }

        // echo "<pre>";print_r($random_array);exit;

        return $random_array;

    }

}