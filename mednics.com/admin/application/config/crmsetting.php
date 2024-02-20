<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['rest_user'] 			= 	'website';
$config['rest_pass'] 			= 	"";


$config['default_column_attribute_by_name'] = array(
        'id' => json_decode(
            "{\"name\":\"id\",\"display_name\":\"ID\",\"data_type\":\"int_11\",\"unique\":\"1\",\"not_empty\":\"0\",\"default_value\":\"\",\"validation\":\"\",\"table_column\":\"0\",\"excel_column\":\"0\",\"hide_on_add\":\"1\",\"hide_on_edit\":\"0\",\"lock_on_add\":\"0\",\"lock_on_edit\":\"1\",\"no_trim\":\"0\",\"selection_data\":{},\"is_four_spaced_json\":\"0\",\"is_column_wise_json\":\"0\",\"column_wise_json_structure\":{},\"structure_nodes\":[],\"structure_attributes\":{}}"
        , true)
    );

$config['default_column_attribute'] 	= json_decode(
    "{\"name\":\"\",\"display_name\":\"\",\"data_type\":\"text\",\"unique\":\"0\",\"not_empty\":\"0\",\"default_value\":\"\",\"validation\":\"\",\"table_column\":\"0\",\"excel_column\":\"0\",\"hide_on_add\":\"0\",\"hide_on_edit\":\"0\",\"lock_on_add\":\"0\",\"lock_on_edit\":\"0\",\"no_trim\":\"0\",\"selection_data\":{},\"is_four_spaced_json\":\"0\",\"is_column_wise_json\":\"0\",\"column_wise_json_structure\":{},\"structure_nodes\":[],\"structure_attributes\":{}}"
, true);

$config['admin_dir'] 					= dirname(FCPATH); // when included by admin/index.php

$config['excels_dir'] 					= $config['admin_dir'] . "/assets/resources/excels";

$config['product_images_src'] 			= $config['admin_dir'] . '/assets/resources/images/products';

$config['product_images_dest'] 			= $config['admin_dir'] . '/assets/images/products';

$config['product_images_url'] 			= 'assets/images/products';

$config['product_images_src_resize'] 	= '/assets/resources/images/products';
$config['product_images_des_resize'] 	= '/assets/images/products';

$config['product_catalogs_dir'] 		= $config['admin_dir'] . '/catalog';

$config['product_catalogs_url'] 		= 'catalog';

$config['product_catalogs_ext'] 		= '';

$config['product_small_image_res']	 	= array(150, 150);

$config['product_medium_image_res'] 	= array(250, 250);

$config['product_small_image_ext'] 		= '-150x150';

$config['product_medium_image_ext'] 	= '-250x250';

$config['product_image_compression'] 	= 90;

$config['product_image_squared'] 		= true;