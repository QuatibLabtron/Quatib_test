<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['rest_user'] 			= 	'website';
$config['rest_pass'] 			= 	"";



/*Email Setting*/

/***********************************************************
			FOR DEMO PURPOSE
************************************************************/

$config['admin_from_name'] 		= 	PROJECT_NAME;
$config['admin_email_from'] 	= 	'info@medfuge.com';
$config['mail_is_smtp'] 		= 	true;
$config['mail_smtp_host'] 		= 	'ssl://mail.medfuge.com';
$config['mail_smtp_user'] 		= 	'info@medfuge.com';
$config['mail_smtp_pass'] 		= 	'NewAccounts@71!';
$config['mail_smtp_port'] 		= 	465; 


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