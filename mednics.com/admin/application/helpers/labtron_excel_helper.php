<?php

function createColumnsArray($end_column, $first_letters = '')
{
    $columns = array();
    $length = strlen($end_column);
    $letters = range('A', 'Z');

    // Iterate over 26 letters.
    foreach ($letters as $letter) 
    {
        // Paste the $first_letters before the next.
        $column = $first_letters . $letter;

        // Add the column to the final array.
        $columns[] = $column;

        // If it was the end column that was added, return the columns.
        if ($column == $end_column)
            return $columns;
    }

    // Add the column children.
    foreach ($columns as $column)
    {
        // Don't itterate if the $end_column was already set in a previous itteration.
        // Stop iterating if you've reached the maximum character length.
        if (!in_array($end_column, $columns) && strlen($column) < $length) {
            $new_columns = createColumnsArray($end_column, $column);
            // Merge the new columns which were created with the final columns array.
            $columns = array_merge($columns, $new_columns);
        }
    }

    return $columns;
}

function getColNameFromNumber($num) 
{
    $numeric = ($num - 1) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num - 1) / 26);
    if ($num2 > 0) 
    {
        return getColNameFromNumber($num2) . $letter;
    } 
    else 
    {
        return $letter;
    }
}

function datetime_int_to_str($datetime)
{
    $strtime = date('Y-m-d H:i:s', $datetime);
    return str_replace('1970-01-01', '0000-00-00', $strtime); // mysql can have dates as 0 zero but php min date is  1970-01-01
}

function date_str_to_int($date)
{
    $date = str_replace('0000-00-00', '1970-01-01', $date);
    return strtotime($date);
}

function date_int_to_str($date)
{
    $strdate = date('Y-m-d', $date);
    return str_replace('1970-01-01', '0000-00-00', $strdate);
}

function time_str_to_int($time)
{
    $strtime = '1970-01-01 ' . date('H:i:s', strtotime($time));
    return strtotime($time);
}

function time_int_to_str($time)
{
    $strtime = date('H:i:s', $time);
    return $strtime;
}

function clear_data($str)
{
    //$str = ForceUTF8\Encoding::toUTF8($str);
    return $str;
}

function str_to_varname($str)
{
    $str = trim($str);
    $separator = '_';
    $q_separator = preg_quote($separator);
    $trans = array(
        '[^a-z0-9 _]' => $separator,
        '\s+' => $separator
    );
    $str = strtolower($str);
    foreach ($trans as $key => $val) {
        $str = preg_replace("#" . $key . "#i", $val, $str);
    }
    return $str;
}

function query_escape_identifier($value)
{
    return "`" . str_replace("`", "``", $value) . "`";
}

function file_exists_case_sensitive($file)
{
    if (!is_file($file)) return false;
    $directoryName = dirname($file);
    if (!is_dir($directoryName)) return false;
    $file = basename($file);
    $d = dir($directoryName);
    while (false !== ($entry = $d->read())) 
    {
        if ($entry === $file) return true;
    }
    return false;
}

/*FOR EXCEL EXPORT FUNCTIONS*/

function export_to_excel($fileName,$excelData,$excel_header,$path,$type = '')
{
   if($type == 'update')
   {
    $updatepath = dirname(FCPATH);
     
   }
   else
   {
     $updatepath = FCPATH;
   }

   $files = glob($updatepath.$path.$fileName);
  
    //get all file names

    foreach($files as $file)
    {
        if(is_file($file))
        unlink($file); 
        //delete file
    }
   

    $dataCount      =  count($excel_header);
    $last_column    =  getColNameFromNumber($dataCount);

    $objPHPExcel    = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);


   
    foreach(range('A',$last_column) as $key => $char)
    {
        foreach ($excel_header as $key1 => $excelheader) 
        {
            if($key === $key1)
            {
                $column_name  = str_replace("_"," ",$excelheader['Field']);
                $objPHPExcel->getActiveSheet()->SetCellValue($char.'1', $column_name);
                
            }
            
            
        }
        
    }

   

    $rowCount = 2;
    if(isset($excelData) && $excelData != '' && !empty($excelData))
    {
        foreach($excelData as $key2 =>$element) 
        {
            foreach(range('A',$last_column) as $key =>$char)
            {
                foreach ($excel_header as $key1 => $excelheader) 
                {

                    if($key === $key1)
                    {
                        $field_name  = $excelheader['Field'];
                        $objPHPExcel->getActiveSheet()->SetCellValue($char.$rowCount, $element[$field_name]);
                   
                        
                    }
                    
                }
            }
            $rowCount++;
        }
    }


  
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        header("Content-Type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename='.$fileName.'');
        header('Cache-Control: 0');

    if($type != 'update')
    {
        
        $objWriter->save($path.$fileName);
        force_download($path.$fileName, NULL);
        unlink($updatepath.$path.$fileName);
    }
    else
    {
        
        $objWriter->save(str_replace(__FILE__,$updatepath.'/'.$path.$fileName,__FILE__));
    }
}

/*FUNCTIONS REQUIRED FOR EXCEL IMPORT*/
function get_excel_import_data($entity_name,$view_name)
{
    $CI =& get_instance();
    $data                       = array();
    $data['entity_name']        = $entity_name;
    $data['view_name']          = $view_name;
    $data['entity_attr']        = et_get_entity_attributes($entity_name);


    $new_excel_files            = array();
    $new_excel_files_statuses   = array();
    $excel_files                = array();
    $excel_files_statuses       = array();

    // Scan folders 
    $files                      = scandir($CI->config->item('excels_dir').'/'. $entity_name);

    $excel_file_rows            = et_get_all('adm_et_excel_files', array('where' => array('entity' => $entity_name)));

   if(isset($excel_file_rows) && $excel_file_rows!= '')
   {
         foreach($excel_file_rows as $excel_file_row) 
        {
            $excel_files[]          = $excel_file_row['name'];
            $file_attr              = json_decode($excel_file_row['attributes'], true);
            $file_path              = $CI->config->item('excels_dir'). '/' . $entity_name . '/' . $excel_file_row['name'] . '.xls';

            $status                 = '';

            if(!et_check_file_access($file_path)) 
            {
                $status = '[no access]';
            } 
            elseif(sha1_file($file_path) != $file_attr['sha1']) 
            {
                $status = '[modified]';
            }
            $excel_files_statuses[] = $status;
        }
    }
    if(isset($files) && $files!= '')
    {
        foreach($files as $file) 
        {
            
            $splits = explode(".", $file);
            $file_name = substr($file, 0, strlen($file) - 4);
            
            if(strlen($file) > 4 && end($splits) == "xls" && !in_array($file_name, $excel_files)) 
            {
                $file_name = substr($file, 0, strlen($file) - 4);
                
                $new_excel_files[] = $file_name;

            $file_path = $CI->config->item('excels_dir') . '/' . $entity_name . '/' . $file_name . '.xls';

            $status = '';
            if (!et_check_file_access($file_path)) 
            {
                $status = '[no access]';
                
            }

            $new_excel_files_statuses[] = $status;

            }
        }
    }

    $data['new_excel_files']            = $new_excel_files;           
    $data['new_excel_files_statuses']   = $new_excel_files_statuses;   
    $data['excel_files']                = $excel_files;                
    $data['excel_files_statuses']       = $excel_files_statuses;      

    return $data;
}

function et_get_entity_attributes($entity)
{
    $CI =& get_instance();
  
    $default_column_attribute_by_name       = $CI->config->item('default_column_attribute_by_name');
    $default_column_attribute               =  $CI->config->item('default_column_attribute');

    $data_types                             = array();
    $data_type_rows                         = et_get_all('adm_et_data_types');
    foreach ($data_type_rows as $data_type_row)
    {
        $data_types[$data_type_row['name']] = $data_type_row;
    }

    
    $entity_attr                            = et_get_by_identifier('adm_et_entities', 'name', $entity);

    $entity_attr['views']                   = json_decode($entity_attr['views'], true);
    $entity_attr['columns_attributes']      = json_decode($entity_attr['columns_attributes'], true);

    $columns_attr                           = $entity_attr['columns_attributes'];
	
	//No need to update and add meta_title ,keyword,description so unset
	unset($columns_attr['meta_title']);
	unset($columns_attr['meta_keyword']);
	unset($columns_attr['meta_description']);
	//end here 
	
    $table_columns                          = array();
    $to_update                              = false;

    $fields_rows                            = et_get_table_fields($entity_attr['name']);
     
    $fields_names                           = array();
    $columns_attr_to_merge                  = array();

    foreach ($fields_rows as $fields_row) 
    {
        $fields_names[$fields_row['Field']] = '';
        $table_columns[]                    = $fields_row['Field'];
        $this_column_attr                   = array('name' => $fields_row['Field']);

        // pick columns that exists in entity
        if (empty($columns_attr[$this_column_attr['name']]))
        {

        

            // find suitable attribute
            $found_attribute = false;
            // check for column name defaults, add all properties that dont exist
            if (!empty($default_column_attribute_by_name[$this_column_attr['name']])) { // column name defaults

               

                foreach ($default_column_attribute_by_name[$this_column_attr['name']] as $key => $value) {

                    if (!isset($this_column_attr[$key])) {
                       
                        $this_column_attr[$key] = $value;
                        
                    }
                }
                $found_attribute = true;
            }

            // check for empty data_type
            if (empty($this_column_attr['data_type'])) {
                $data_type_found = false;
                foreach ($data_types as $data_type) {
                    if ($data_type['table_column_type'] == $fields_row['Type']) {

                        $this_column_attr['data_type'] = $data_type['name'];
                        
                        $data_type_found = true;
                        break;
                    }
                }
                if (!$data_type_found) {
                    $this_column_attr['data_type'] = 'text';
                    
                }
            }

            // apply defaults
            if (!$found_attribute) { // column name defaults
                $this_column_attr = et_fill_default_column_attr($this_column_attr);
                 
            }

            if (empty($this_column_attr['display_name'])) {
                $this_column_attr['display_name'] = $this_column_attr['name'];
                
            }

            $columns_attr_to_merge[$this_column_attr['name']] = $this_column_attr;
            
        }

    }

    
    // merge attrs
    if (!empty($columns_attr_to_merge)) 
    {
        $to_update = true;
       
        $all_column_names_in_order = array_keys(et_merge_arrays_in_order(array($fields_names, $columns_attr_to_merge), 2, true));
        

        $columns_attr_in_order = array();
        foreach ($all_column_names_in_order as $column_name) {
            if (isset($columns_attr[$column_name])) {
                $columns_attr_in_order[$column_name] = $columns_attr[$column_name];
            } elseif (isset($columns_attr_to_merge[$column_name])) {
                $columns_attr_in_order[$column_name] = $columns_attr_to_merge[$column_name];
            }
        }
        $columns_attr = $columns_attr_in_order;
    }
   

    // update table columns
    foreach ($columns_attr as $column_name => $column_attr)
    {
        if (in_array($column_name, $table_columns)) {
        
           
     
            if ($columns_attr[$column_name]['table_column'] != '1') {
               

                $columns_attr[$column_name]['table_column'] = '1';
                $to_update = true;
            }
        } else {
            if ($columns_attr[$column_name]['table_column'] != '0') {
              
               
                $columns_attr[$column_name]['table_column'] = '0';
                $to_update = true;
            }
        }
    }
    
  
    if ($to_update) 
    {
       et_edit_by_identifier('adm_et_entities', array('columns_attributes' => json_encode($columns_attr)), 'name', $entity);
    }

    // put data_type_details
    $columns_attr = et_insert_data_type_details($columns_attr, $data_types);

     

    $entity_attr['columns_attributes'] = $columns_attr;
    
    return $entity_attr;
}

function et_get_all($entity, $query_attr = array())
{

    $CI =& get_instance();
    $values = array();
    $values_pt = '';
    $where = '';
    if (isset($query_attr['where']) && !empty($query_attr['where'])) {
        $where .= " WHERE";
        $where_conditions = '';
        foreach ($query_attr['where'] as $column => $value) {
            $where_conditions .= (($where_conditions) ? " AND " : " ") . query_escape_identifier($column) . " = '".$value."' ";
            $values[] = $value;
            $values_pt .= 's';
           
        }
        $where .= $where_conditions;
        
    }

    $group_by = '';
    if (isset($query_attr['group_by']) && !empty($query_attr['group_by'])) {
        $group_by .= " GROUP BY";
        foreach ($query_attr['group_by'] as $index => $column) {
            $group_by .= (($index) ? "," : "") . " " . query_escape_identifier($column);
        }
    }
    $order_by = '';
    $order_type = '';
    if (isset($query_attr['order_by']) && !empty($query_attr['order_by'])) {
        $order_by .= " ORDER BY";
        foreach ($query_attr['order_by'] as $index => $column) {
            $order_by .= (($index) ? "," : "") . " " . query_escape_identifier($column);
        }
        if (!empty($query_attr['order_type']) && ($query_attr['order_type'] == 'ASC' || $query_attr['order_type'] == 'DESC')) {
            $order_type = " " . $query_attr['order_type'];
        }
    }
    $limit = '';
    if (isset($query_attr['limit']) && !empty($query_attr['limit'])) {
        $limit .= " LIMIT ";
        if (!empty($query_attr['limit']['offset'])) {
            $limit .= (int)$query_attr['limit']['offset'];
        }
        $limit .= (int)$query_attr['limit']['no_of_rows'];
    }
    //echo "SELECT * FROM " . query_escape_identifier($entity) . $where . $order_by . $order_type . $limit;
    
     $sqlQuery = "SELECT * FROM " . query_escape_identifier($entity) . $where . $group_by . $order_by . $order_type . $limit;
   
    
    $query = executeSqlQuery($sqlQuery,'result_array');
        
        
        if(isset($query) && $query != '' && !empty($query))
        {
            return $query;
        }
        return false;
}

function et_get_by_identifier($entity, $identifier_name, $identifier_value)
{
    $CI =& get_instance();
    $sqlQuery = "SELECT * FROM " . query_escape_identifier($entity) . " WHERE " . query_escape_identifier($identifier_name) . " =  '".$identifier_value."'";
    $query = executeSqlQuery($sqlQuery,'row_array');
        
    if(isset($query) && $query != '')
    {
        return $query;
    }
    return false;
}

function et_get_table_fields($entity)
{
    $CI =& get_instance();
    $sqlQuery = "SHOW FIELDS FROM " . query_escape_identifier($entity);
    $query = executeSqlQuery($sqlQuery,'result_array');
    
    if(isset($query) && $query != '')
    {
        return $query;
    }
    return false;
}

// ordering: 0 - add to last | 1 - best place | 2 - best place using first array as initial merged array.
function et_merge_arrays_in_order($arrays, $ordering = 0, $array_of_keys = false)
{
    $merged_array = array();
    if(!$array_of_keys) 
    {
        if($ordering == 0){
            if ($array_of_keys == 0) {
                foreach ($arrays as $array) {
                    if (!empty($merged_array)) {
                        foreach ($array as $value) {
                            if (!in_array($value, $merged_array)) {
                                $merged_array[] = $value;
                            }
                        }
                    } else {
                        $merged_array = $array;
                    }
                }
            }
        }
        elseif($ordering == 1 || $ordering == 2) 
        {
            if ($ordering == 2) {
                $merged_array = array_splice($arrays, 0, 1)[0];
            }
            foreach ($arrays as $array) {
                if ($ordering == 1 || !empty($merged_array)) {

                    foreach ($array as $value) {
                        if (!in_array($value, $merged_array)) {
                            // visit all array collect points for each word -ve for left of the target word, +ve for right of the target word
                            $word_points = array();
                            foreach ($arrays as $arr) {
                                $pos = array_search($value, $arr);
                                if ($pos !== false) {
                                    $pos_found = false;
                                    foreach ($arr as $key => $val) {
                                        if ($key == $pos) {
                                            $pos_found = true;
                                        } elseif (!$pos_found) {
                                            if (empty($word_points[$val])) {
                                                $word_points[$val] = 0;
                                            }
                                            $word_points[$val]--;
                                        } elseif ($pos_found) {
                                            if (empty($word_points[$val])) {
                                                $word_points[$val] = 0;
                                            }
                                            $word_points[$val]++;
                                        }
                                    }
                                }
                            }
                            // further improvement, while placing between words, check which word bonds are the weakest to place in between
                            // check each word in the array and place the target word where suitable
                            $highest_neg_pos = -1;
                            $lowest_non_neg_pos = -1;
                            foreach ($word_points as $word => $word_point) {
                                $pos = array_search($word, $merged_array);
                                if ($pos !== false) {
                                    if ($word_point < 0) {
                                        if ($highest_neg_pos == -1 || $highest_neg_pos < $pos + 1) {
                                            $highest_neg_pos = $pos + 1;
                                        }
                                    } else {
                                        if ($lowest_non_neg_pos == -1 || $pos < $lowest_non_neg_pos) {
                                            $lowest_non_neg_pos = $pos;
                                        }
                                    }
                                }
                            }
                            // place
                            if ($highest_neg_pos != -1) {
                                array_splice($merged_array, $highest_neg_pos, 0, $value);
                            } elseif ($lowest_non_neg_pos != -1) {
                                array_splice($merged_array, $lowest_non_neg_pos, 0, $value);
                            } else {
                                $merged_array[] = $value;
                            }
                        }
                    }
                } else {
                    $merged_array = $array;
                }
            }
        }
    } 
    else 
    { // array of keys
        // get merged keys array
        $keys_arrays = array();
        foreach ($arrays as $array) {
            $keys_arrays[] = array_keys($array);
        }
        $merged_keys = et_merge_arrays_in_order($keys_arrays, $ordering);
        // using the merged keys find which of the keys have further arrays and sort them too
        foreach ($merged_keys as $merged_key) {
            $merged_key_value_arrays = array();
            foreach ($arrays as $array) {
                if (isset($array[$merged_key]) && is_array($array[$merged_key])) {
                    $merged_key_value_arrays[] = $array[$merged_key];
                }
            }
            if (count($merged_key_value_arrays)) {
                $merged_array[$merged_key] = et_merge_arrays_in_order($merged_key_value_arrays, $ordering, true);
            } else {
                $merged_array[$merged_key] = '';
            }
        }
    }
    return $merged_array;
}

function et_fill_default_column_attr($column_attr)
{
   $CI =& get_instance();
    $default_column_attribute = $CI->config->item('default_column_attribute');
    foreach ($default_column_attribute as $key => $value) 
    {
        if (!isset($column_attr[$key])) 
        {
            $column_attr[$key] = $value;
        }
    }
    return $column_attr;
}

function et_insert_data_type_details($columns_attr, $data_types)
{
    foreach ($columns_attr as $column_name => $column_attr) {
        $columns_attr[$column_name]['data_type_details'] = $data_types[$column_attr['data_type']];
        if (!empty($columns_attr[$column_name]['structure_attributes'])) {
            foreach ($columns_attr[$column_name]['structure_attributes'] as $attr_name => $attr_value) {
                $columns_attr[$column_name]['structure_attributes'][$attr_name]['data_type_details'] = $data_types[$attr_value['data_type']];
            }
        }
    }
    return $columns_attr;
}

function et_remove_excel_file($entity_attr, $file)
{

    $excel_file = et_get_by_identifier('adm_et_excel_files', 'unique_value', $entity_attr['name'] . '_' . $file);
   
    if (empty($excel_file)) {
        throw new Exception('Excel file not found');
    }

    et_save_excel_file_by_idenitifier($entity_attr, 'name', $file);

    $excel_entries = et_get_all('adm_et_excel_entries', array('where' => array('excel_file_id' => $excel_file['id'])));
    
    if ($entity_attr['excel_identifier'] == '') {
        $excel_identifier_name = 'excel_identifier_value';
    } else {
        $excel_identifier_name = $entity_attr['excel_identifier'];
    }
    $deleted_rows = array();
    foreach ($excel_entries as $excel_entry) {
        $combined_row = et_get_combined_by_identifier($entity_attr, $excel_identifier_name, $excel_entry['identifier_value']);
        et_delete_combined_by_identifier($entity_attr, $excel_identifier_name, $excel_entry['identifier_value'], false);
        $deleted_rows[] = $combined_row;
    }

    if (!empty($entity_attr['function_after_delete'])) {
        $entity_attr['function_after_delete']($entity_attr, $deleted_rows);
    }

    et_delete_by_identifier('adm_et_excel_files', 'unique_value', $entity_attr['name'] . '_' . $file);
}

function et_edit_by_identifier($entity, $row, $identifier_name, $identifier_value)
{
    $CI =& get_instance();

    $check_table = array("sections", "categories", "products", "price_list","pages");
    if(in_array($entity, $check_table))
    {
       /* $row['inactive']     = PRODUCT_ACTIVE_STATUS;*/
        $row['updated_by']      = $CI->session->userdata('prs_id');
        $row['updated_dt']      = date('Y-m-d H:i:s');
    }
   
    $CI->db->where($identifier_name,$identifier_value);
    $CI->db->update($entity,$row);
    return true;
}


function et_add($entity, $row)
{
    $CI =& get_instance();

    $check_table = array("sections", "categories", "products", "price_list","pages");

    if(in_array($entity, $check_table))
    {
        /*$row['inactive']     = PRODUCT_ACTIVE_STATUS;*/
        $row['created_by']      = $CI->session->userdata('prs_id');
        $row['updated_by']      = $CI->session->userdata('prs_id');
        $row['created_dt']      = date('Y-m-d H:i:s');
        $row['updated_dt']      = date('Y-m-d H:i:s');
    }

    if($CI->db->insert($entity,$row))
    {
        $id = $CI->db->insert_id();
        return $id;
    }

    $error = $CI->db->error();

    if ($error['code'] == 1062) 
    {
        log_message('error','labtron_excel_helper et_add code>> Error while adding excel file >> '.$error['message']);
        $CI->session->set_flashdata('excel_error', 'Filename : labtron_excel_helper function: et_add message:  Error while adding excel file >> '.$error['message']);
        redirect($_SERVER['HTTP_REFERER']);
    }
    if (isset($error['message'])) 
    {
        log_message('error','labtron_excel_helper et_add >> Error while adding excel file >> '.$error['message']);
        $CI->session->set_flashdata('excel_error', 'Filename : labtron_excel_helper function: et_add  message: Error while adding excel file >> '.$error['message']);
        redirect($_SERVER['HTTP_REFERER']);
    }
}

function et_delete_by_identifier($entity, $identifier_name, $identifier_value)
{
    if($entity == 'products')
    {
        et_delete_by_identifier_images($entity, $identifier_name, $identifier_value);
    }

    $CI =& get_instance();
    $CI->db->where($identifier_name,$identifier_value);
    $CI->db->delete($entity);
    log_message('error','>>lst query for delete '.$CI->db->last_query() );
    return true;
}

function et_delete_by_identifier_images($entity, $identifier_name, $identifier_value)
{
    $CI =& get_instance();

    $CI->db->select('image_url');
    $CI->db->from($entity);
    $CI->db->where($identifier_name,$identifier_value);
    $sqlQuery = "select image_url from ".$entity." where ".$identifier_name." = '".$identifier_value."' ";
    $query = executeSqlQuery($sqlQuery,'row_array');
    log_message('error','>>lst et_delete_by_identifier_images '.$CI->db->last_query() );

    $json = str_replace(array("\t","\n"), "",$query['image_url']);
    $data = json_decode($json,true); 
    $admin_url = $CI->config->item('admin_dir');
    if($data) 
    {
        $img_src_small = $data['small'];
          $small_file = $admin_url.'/'.$img_src_small;
        log_message('error','>>lst query for delete  unlink images url  img_src_small>>> '.$small_file);
      
        if(file_exists($small_file))
        {
            unlink($small_file);
        }
        

        $img_src_medium = $data['medium'];
         $medium_file = $admin_url.'/'.$img_src_medium;
         log_message('error','>>lst query for delete  unlink images url img_src_medium >>> '. $medium_file );

         if(file_exists($medium_file))
        {
            unlink($medium_file);
        }
    }

    log_message('error','>>lst query for delete  unlink images '.$CI->db->last_query() );
    return true;
}

function et_check_file_access($file)
{
    $fp = @fopen($file, "r+");
    if (empty($fp)) {
        return false;
    }

    if (flock($fp, LOCK_EX)) {  // acquire an exclusive lock
        flock($fp, LOCK_UN);    // release the loc
        fclose($fp);
        return true;
    } else {
        fclose($fp);
        return false;
    }
}

function et_add_excel_file($entity_attr, $file)
{
    $CI =& get_instance();

    $excel_file_path                    = $CI->config->item('excels_dir') . '/' . $entity_attr['name'] . '/' . $file . '.xls';

    $excel_file                         = et_read_excel_file($excel_file_path);

    $excel_attributes                   = array();
    $excel_attributes['size']           = filesize($excel_file_path);
    $excel_attributes['sha1']           = sha1_file($excel_file_path);
    $excel_attributes['last_modified']  = filemtime($excel_file_path);
    $excel_attributes['columns_attr']   = $excel_file['columns_attr'];

    $excel_file_id                      = et_add('adm_et_excel_files', array('unique_value' => $entity_attr['name'] . '_' . $file, 'name' => $file, 'entity' => $entity_attr['name'], 'attributes' => json_encode($excel_attributes)));

    et_update_columns_attributes($entity_attr, $excel_file['columns_attr']);

    $entity_attr                        = et_get_entity_attributes($entity_attr['name']);

    $rows                               = $excel_file['rows'];
    $excel_order                        = 1;
    $added_rows                         = array();

    if($entity_attr['excel_identifier'] == '') 
    {
        $excel_identifier               = 'excel_identifier_value';
    } 
    else 
    {
        $excel_identifier               = $entity_attr['excel_identifier'];
    }

    foreach($rows as $index => $row) 
    {
        if ($entity_attr['excel_identifier'] == '') 
        {
            $excel_identifier_value     = $excel_file_id . '_' . $excel_order;
        }
        else 
        {
            $excel_identifier_value     = $row[$entity_attr['excel_identifier']];
        }

        et_add_combined($entity_attr, $row, $excel_file_id, $excel_order, false);

        $added_rows[]                   = et_get_combined_by_identifier($entity_attr, $excel_identifier, $excel_identifier_value);

        $excel_order++;
    }

    if(!empty($entity_attr['function_after_add'])) 
    {
        //echo $entity_attr['function_after_add'];exit;
        $entity_attr['function_after_add']($entity_attr, $added_rows);
    }

    et_save_excel_file_by_idenitifier($entity_attr, 'name', $file);
}

function et_read_excel_file($excel_file_path)
{
    $columns_attr                   = array();
    $column_names                   = array();
    $column_display_names           = array();
    $column_wise_json               = array();
    $four_spaced_json_columns       = array();

    $objPHPExcel                    = new PHPExcel();
    $objReader                      = new PHPExcel_Reader_Excel5();
    $objPHPExcel                    = $objReader->load($excel_file_path);

    $objPHPExcel->setActiveSheetIndex(0);

    $objWorksheet                   = $objPHPExcel->getActiveSheet();

    // create excel rows and column row
    $excel_rows                     = array();
    $column_row_done                = false;
    $column_row                     = array();
    $columns_count                  = -1;

    foreach ($objWorksheet->getRowIterator() as $row) 
    {
        $cellIterator               = $row->getCellIterator();

        $cellIterator->setIterateOnlyExistingCells(false);

        if (!$column_row_done) 
        {
            foreach ($cellIterator as $cell) 
            {
                $value              = trim($cell->getValue());
                if (is_null($value)) 
                {
                    $value          = '';
                }
                if ($value != "") 
                {
                    $column_row[]   = $value;//$values[$value_index];
                } 
                else 
                {
                    break;
                }
            }

            $column_row_done        = true;
            $columns_count          = count($column_row);

        } 
        else
        {
            $values                 = array();
            $row_exists             = false;
            $index                  = 0;
            foreach ($cellIterator as $cell) 
            {
                $value              = clear_data($cell->getValue()); // trim problem - do not trim here
                if (is_null($value)) 
                {
                    $value          = '';
                }
                if ($value == '&nbsp;') 
                {
                    $value          = ' '; // substitute with single space
                    $row_exists = true;
                }

                $values[]           = $value;
                $index++;

                if ($index == $columns_count) 
                {
                    break;
                }
            }
            foreach ($values as $value) 
            {
                if (trim($value) != '') 
                {
                    $row_exists     = true;
                    break;
                }
            }
            if ($row_exists) 
            {
                $excel_rows[]       = $values;
            }
        }
    }
    // create column_names, column_wise_json and four_spaced_json_columns
    if (!function_exists('et_read_excel_file_get_column_wise_json_array')) 
    {
        function et_read_excel_file_get_column_wise_json_array($column_row, $column_index)
        {
            $array                  = array();
            for ($column_index = $column_index; $column_index < count($column_row) && $column_row[$column_index] != ']'; $column_index++) 
            {
                $value              = $column_row[$column_index];
                if (substr($value, strlen($value) - 1) == '[') 
                { 
                    // column wise json
                    $column_name    = trim(substr($value, 0, strlen($value) - 1));
                    $column_index++;
                    $ret_array      = et_read_excel_file_get_column_wise_json_array($column_row, $column_index);
                    $column_index   = $ret_array['column_index'];
                    $array[$column_name] = $ret_array['array'];
                } 
                else 
                { 
                    //normal column
                    $array[$value] = '';
                }
            }
            $ret_array = array(
                'column_index' => $column_index,
                'array' => $array
            );
            return $ret_array;
        }
    }
    for ($column_index = 0; $column_index < count($column_row); $column_index++) 
    {
        $value                          = $column_row[$column_index];
        if (substr($value, strlen($value) - 1) == '[') 
        { 
            // column wise json
            $column_display_name        = trim(substr($value, 0, strlen($value) - 1));
            $column_name                = str_to_varname($column_display_name);
            $columns_attr[$column_name] = array('name' => $column_name, 'display_name' => $column_display_name);
            $column_index++;
            $ret_array                  = et_read_excel_file_get_column_wise_json_array($column_row, $column_index);
            $column_index               = $ret_array['column_index'];

            //$columns_attr[$column_name]['is_json'] = '1';

            $columns_attr[$column_name]['is_column_wise_json']          = '1';
            $columns_attr[$column_name]['column_wise_json_structure']   = $ret_array['array'];

        }
        elseif (substr($value, strlen($value) - 2) == '[]') 
        { 
            // fourspaced json
            $column_display_name        = trim(substr($value, 0, strlen($value) - 2));
            $column_name                = str_to_varname($column_display_name);
            $columns_attr[$column_name] = array('name' => $column_name, 'display_name' => $column_display_name);

            //$columns_attr[$column_name]['is_json'] = '1';
            $columns_attr[$column_name]['is_four_spaced_json'] = '1';
        } 
        else 
        { 
            //normal column
            $column_display_name        = $value;
            $column_name                = str_to_varname($column_display_name);
            $columns_attr[$column_name] = array('name' => $column_name, 'display_name' => $column_display_name);
        }
    }

    // create rows, using the previous columns info
    if (!function_exists('et_read_excel_file_get_column_wise_data_array')) 
    {
        function et_read_excel_file_get_column_wise_data_array($excel_row, $column_wise_json_structure, $column_index)
        {
            $array = array();
            foreach ($column_wise_json_structure as $column_wise_json_key => $column_wise_json_value) {
                if (is_array($column_wise_json_value)) {
                    $column_index++;
                    $ret_array = et_read_excel_file_get_column_wise_data_array($excel_row, $column_wise_json_value, $column_index);
                    $column_index = $ret_array['column_index'];
                    $array[$column_wise_json_key] = $ret_array['array'];
                } else {
                    $array[$column_wise_json_key] = trim($excel_row[$column_index]); // trim problem
                }
                $column_index++;
            }
            $ret_array = array(
                'column_index' => $column_index,
                'array' => $array
            );
            return $ret_array;
        }
    }

    $column_index = 0;
    $rows = array();

    for ($i = 0; $i < count($excel_rows); $i++) 
    {
        $rows[] = array();
    }

    foreach ($columns_attr as $column_name => $column_attr) 
    {
        if (!empty($column_attr['is_column_wise_json'])) 
        {
            $column_index++;
            foreach ($excel_rows as $row_index => $excel_row) 
            {
                $ret_array                      = et_read_excel_file_get_column_wise_data_array($excel_row, $column_attr['column_wise_json_structure'], $column_index);
                $rows[$row_index][$column_name] = json_encode(et_arrays_clear_data($ret_array['array']));
            }

            $column_index = $ret_array['column_index'];
        } 
        elseif (!empty($column_attr['is_four_spaced_json'])) 
        {
            foreach ($excel_rows as $row_index => $excel_row)
            {
                $rows[$row_index][$column_name] = json_encode(et_arrays_clear_data(et_decode_four_spaced_json($excel_row[$column_index])));
            }
        } else {
            foreach ($excel_rows as $row_index => $excel_row) {
                $rows[$row_index][$column_name] = trim($excel_row[$column_index]); // trim  problem - some data may require extra spaces
            }
        }
        $column_index++;
    }
    $ret_array = array(
        'rows'         => $rows,
        'columns_attr' => $columns_attr
    );
    return $ret_array;
}

function et_update_excel_file($entity_attr, $file)
{
    $CI =& get_instance();
    $excel_file_path = $CI->config->item('excels_dir'). '/' . $entity_attr['name'] . '/' . $file . '.xls';
    $excel_file = et_read_excel_file($excel_file_path);
    $excel_attributes = array();
    $excel_attributes['size'] = filesize($excel_file_path);
    $excel_attributes['sha1'] = sha1_file($excel_file_path);
    $excel_attributes['last_modified'] = filemtime($excel_file_path);
    $excel_attributes['columns_attr'] = $excel_file['columns_attr'];
    $excel_file_row = et_get_by_identifier('adm_et_excel_files', 'unique_value', $entity_attr['name'] . '_' . $file);
    if (empty($excel_file_row)) {
        throw new Exception('Excel file not found');
    }
    et_edit_by_identifier('adm_et_excel_files', array('unique_value' => $entity_attr['name'] . '_' . $file, 'name' => $file, 'entity' => $entity_attr['name'], 'attributes' => json_encode($excel_attributes)), 'unique_value', $entity_attr['name'] . '_' . $file, true);
    et_update_columns_attributes($entity_attr, $excel_file['columns_attr']);
    $entity_attr = et_get_entity_attributes($entity_attr['name']);
    $rows = $excel_file['rows'];
    $excel_file_id = $excel_file_row['id'];
    $existing_entries = et_get_all('adm_et_excel_entries', array('where' => array('excel_file_id' => $excel_file_id)));
    $done_identifier_values = array();
    $added_rows = array();
    $edited_rows = array();
    $deleted_rows = array();
    $excel_order = 1;
    if ($entity_attr['excel_identifier'] == '') {
        $excel_identifier = 'excel_identifier_value';
    } else {
        $excel_identifier = $entity_attr['excel_identifier'];
    }
    foreach ($rows as $index => $row) {
        if ($entity_attr['excel_identifier'] == '') {
            $excel_identifier_value = $excel_file_id . '_' . $excel_order;
        } else {
            $excel_identifier_value = $row[$entity_attr['excel_identifier']];
        }
        $done_identifier_values[] = $excel_identifier_value;
        $combined_row = et_get_combined_by_identifier($entity_attr, $excel_identifier, $excel_identifier_value);
        if (empty($combined_row)) {
            // add
            et_add_combined($entity_attr, $row, $excel_file_id, $excel_order, false);
            $combined_row = et_get_combined_by_identifier($entity_attr, $excel_identifier, $excel_identifier_value);
            $added_rows[] = $combined_row;
        } else {
            // edit
            et_edit_combined_by_identifier($entity_attr, $row, $excel_identifier, $excel_identifier_value, $excel_file_id, false, true);
            et_get_by_identifier($entity_attr['name'], $excel_identifier, $excel_identifier_value);
            $combined_row = et_get_combined_by_identifier($entity_attr, $excel_identifier, $excel_identifier_value);
            $edited_rows[] = $combined_row;
        }
        $excel_order++;
    }
    // delete
    foreach ($existing_entries as $entry) {
        if (!in_array($entry['identifier_value'], $done_identifier_values)) {
            $combined_row = et_get_combined_by_identifier($entity_attr, $excel_identifier, $entry['identifier_value']);
            et_delete_combined_by_identifier($entity_attr, $excel_identifier, $entry['identifier_value'], false);
            $deleted_rows[] = $combined_row;
        }
    }


    if (!empty($entity_attr['function_after_add'])) {
        $entity_attr['function_after_add']($entity_attr, $added_rows);
    }
    if (!empty($entity_attr['function_after_edit'])) {
        $entity_attr['function_after_edit']($entity_attr, $edited_rows);
    }
    if (!empty($entity_attr['function_after_delete'])) {
        $entity_attr['function_after_delete']($entity_attr, $deleted_rows);
    }
   // echo '<br><br> edited rows: ' . count($edited_rows) . '<br> added rows: ' . count($added_rows) . '<br> deleted rows: ' . count($deleted_rows);
    et_save_excel_file_by_idenitifier($entity_attr, 'name', $file);
}

function et_update_columns_attributes($entity_attr, $excel_columns_attr)
{
    // updatting columns_attr
    $CI =& get_instance();
    $default_column_attribute   = $CI->config->item('default_column_attribute');
    $entity_attr_row            = et_get_by_identifier('adm_et_entities', 'name', $entity_attr['name']);
    $existing_columns_attr      = json_decode($entity_attr_row['columns_attributes'], true);
    $new_columns_attr           = array();
    $to_update                  = false;
    foreach ($excel_columns_attr as $column_name => $column_attr) 
    {
        if (isset($existing_columns_attr[$column_name])) 
        {
            if (!empty($excel_columns_attr[$column_name]['is_column_wise_json'])) 
            {
                $merged_json_structure = et_merge_arrays_in_order(array($existing_columns_attr[$column_name]['column_wise_json_structure'], $excel_columns_attr[$column_name]['column_wise_json_structure']), 2, true);

                //var_dump($merged_json_structure);var_dump($excel_columns_attr[$column_name]['column_wise_json_structure']);

                if ($merged_json_structure != $existing_columns_attr[$column_name]['column_wise_json_structure'])
                {
                    $existing_columns_attr[$column_name]['column_wise_json_structure'] = $merged_json_structure;
                    $to_update          = true;
                    echo $to_update;
                }
            }
            if($existing_columns_attr[$column_name]['excel_column'] != '1') 
            {
                $existing_columns_attr[$column_name]['excel_column']    = '1';
                $existing_columns_attr[$column_name]['display_name']    = $excel_columns_attr[$column_name]['display_name'];
                foreach($column_attr as $key => $value) 
                {
                    $existing_columns_attr[$column_name][$key]          = $value;
                }
                $existing_columns_attr[$column_name]['excel_column']    = '1';

                if((!empty($existing_columns_attr[$column_name]['is_four_spaced_json']) || !empty($existing_columns_attr[$column_name]['is_column_wise_json']) && ($existing_columns_attr[$column_name]['data_type'] != 'json_array' || $existing_columns_attr[$column_name]['data_type'] != 'json_object'))) 
                {
                    $existing_columns_attr[$column_name]['data_type']   = 'json_object';
                }

                $to_update = true;
            }
        }
        else 
        {
            $new_columns_attr[$column_name]                             = $default_column_attribute;
            foreach ($column_attr as $key => $value) 
            {
                $new_columns_attr[$column_name][$key]                   = $value;
            }
            $new_columns_attr[$column_name]['excel_column']             = '1';

            if (!empty($new_columns_attr[$column_name]['is_four_spaced_json']) || !empty($new_columns_attr[$column_name]['is_column_wise_json'])) 
            {
                $new_columns_attr[$column_name]['data_type'] = 'json_object';
            }

            $to_update = true;
        }
    }
    if($to_update) 
    {
        $merged_columns_attr    = array_merge($existing_columns_attr, $new_columns_attr);
        $updated_columns_attr   = array();
        $columns_names_in_order = et_merge_arrays_in_order(array($existing_columns_attr, $excel_columns_attr), 2, true);
        $merged_columns_attr    = et_remove_data_type_details($merged_columns_attr);
        foreach ($columns_names_in_order as $column_name => $value) 
        {
            $updated_columns_attr[$column_name] = $merged_columns_attr[$column_name];
        }

        // update it
        et_edit_by_identifier('adm_et_entities', array('columns_attributes' => json_encode($updated_columns_attr)), 'name', $entity_attr['name']);
    }
}

function et_edit_combined_by_identifier($entity_attr, $row, $identifier_name, $identifier_value, $excel_file_id = false, $save_excel = true, $complete_row = false)
{
    // silent, does not error on unchanged row
    
    $columns_attr                   = $entity_attr['columns_attributes'];
    $table_row                      = array();
    foreach ($columns_attr as $column_name => $column_attr) 
    {
        if (!empty($column_attr['table_column'])) 
        {
            if (isset($row[$column_name])) 
            {
                $table_row[$column_name] = $row[$column_name];
            } elseif ($complete_row && !empty($column_attr['excel_column'])) 
            {
                if ($column_attr['data_type_details']['type'] == 'json_array') 
                {
                    $table_row[$column_name] = '[]';
                } elseif ($column_attr['data_type_details']['type'] == 'json_object')
                {
                    $table_row[$column_name] = '{}';
                } else 
                {
                    $table_row[$column_name] = '';
                }
            }
        }
    }
    et_edit_by_identifier($entity_attr['name'], $table_row, $identifier_name, $identifier_value, true); // ignore unchanged, as ther could be changes in gen extra functions
    if (!empty($entity_attr['use_excels'])) 
    {
        if ($entity_attr['excel_identifier'] == '') 
        {
            $tab_row = et_get_by_identifier($entity_attr['name'], $identifier_name, $identifier_value);
            $excel_identifier_value         = $tab_row['excel_identifier_value'];
        } else 
        {
            $excel_identifier_value         = $row[$entity_attr['excel_identifier']];
        }
        if (empty($excel_file_id) || !$complete_row) 
        {
            $excel_entry                    = et_get_by_identifier('adm_et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $excel_identifier_value);
            $excel_file_id                  = $excel_entry['excel_file_id'];
        }

        $excel_file_row                     = et_get_by_identifier('adm_et_excel_files', 'id', $excel_file_id);

        if (empty($excel_file_row)) 
        {
            throw new Exception('Excel file does not exist on edit');
        }

        $excel_row = array();

        if (!$complete_row) 
        {
            $excel_row                      = json_decode($excel_entry['entry'], true);

            foreach ($row as $key => $value) 
            {
                if (!empty($columns_attr[$key]['excel_column'])) 
                {
                    $excel_row[$key]            = $value;
                }
            }
        }

        $excel_file_attr                    = json_decode($excel_file_row['attributes'], true);

        $excel_file_columns_attr            = $excel_file_attr['columns_attr'];

        foreach ($row as $key => $value) 
        {
            if (!empty($columns_attr[$key]['excel_column'])) 
            {
                if (isset($excel_file_columns_attr[$key]) || isset($excel_row[$key])) 
                {
                    $excel_row[$key]        = $value;

                } elseif ($value != '' && (($columns_attr[$key]['data_type_details']['type'] != 'json_array' && $columns_attr[$key]['data_type_details']['type'] != 'json_object') || ($value != '[]' && $value != '{}'))) 
                {
                    $excel_row[$key]        = $value;
                }
            }
        }

        $excel_entry_row = array(
            'entry'         => json_encode($excel_row),
            'last_modified' => datetime_int_to_str(time())
        );

        et_edit_by_identifier('adm_et_excel_entries', $excel_entry_row, 'unique_value', $entity_attr['name'] . '_' . $excel_identifier_value, true);

        if (!empty($save_excel)) 
        {
            et_save_excel_file_by_idenitifier($entity_attr, 'id', $excel_file_id);
        }
    }
}

function et_add_combined($entity_attr, $row, $excel_file_id = false, $excel_order = false, $save_excel = true)
{

    $ret_array = array();
    $columns_attr = $entity_attr['columns_attributes'];
    if (!empty($entity_attr['use_excels'])) 
    {
        if(empty($excel_file_id)) 
        {
            $excel_files            = et_get_all('adm_et_excel_files', array('where' => array('name' => $entity_attr['name'], 'entity' => $entity_attr['name'])));
            if(empty($excel_files)) 
            {
                throw new Exception('Default Excel file does not exist on add');
            }
            $excel_file_row         = $excel_files[0];
            $excel_file_id          = $excel_file_row['id'];
        } 
        else 
        {
            $excel_file_row         = et_get_by_identifier('adm_et_excel_files', 'id', $excel_file_id);
            if (empty($excel_file_row)) 
            {
                throw new Exception('Excel file does not exist on add');
            }
        }
        if (empty($excel_order)) 
        {
            $last_entries           = et_get_all('adm_et_excel_entries', array('where' => array('excel_file_id' => $excel_file_id), 'order_by' => array('excel_order'), 'order_type' => 'DESC', 'limit' => array('no_of_rows' => '1')));
            if (empty($last_entries)) 
            {
                $excel_order        = 1;
            }
            else 
            {
                $excel_order        = ((int)$last_entries[0]['excel_order']) + 1;
            }
        }
        if ($entity_attr['excel_identifier'] == '') 
        {
            $excel_identifier_value = $excel_file_id . '_' . $excel_order;
        } 
        else 
        {
            $excel_identifier_value = $row[$entity_attr['excel_identifier']];
        }
    }
    $table_row = array();
    foreach ($row as $key => $value) 
    {
        if (!empty($columns_attr[$key]['table_column'])) 
        {
            $table_row[$key]    = $value;
        }
    }
    if (!empty($entity_attr['use_excels']) && $entity_attr['excel_identifier'] == '')
    {
        $table_row['excel_identifier_value'] = $excel_identifier_value;
    }

    $ret_array['table_row_id']  = et_add($entity_attr['name'], $table_row);

    if (!empty($entity_attr['use_excels'])) 
    {

        $excel_file_attr         = json_decode($excel_file_row['attributes'], true);
        $excel_file_columns_attr = $excel_file_attr['columns_attr'];
        $excel_row               = array();

        foreach ($row as $key => $value) 
        {
            if (!empty($columns_attr[$key]['excel_column']))
            {
                if (isset($excel_file_columns_attr[$key]) || isset($excel_row[$key])) 
                {
                    $excel_row[$key]    = $value;
                } 
                elseif ($value != '' && (($columns_attr[$key]['data_type_details']['type'] != 'json_array' && $columns_attr[$key]['data_type_details']['type'] != 'json_object') || ($value != '[]' && $value != '{}'))) 
                {
                    $excel_row[$key]    = $value;
                }
            }
        }
        $ret_array['excel_entry_id']    = et_add('adm_et_excel_entries', array(
            'unique_value'              => $entity_attr['name'] . '_' . $excel_identifier_value,
            'identifier_value'          => $excel_identifier_value,
            'entity'                    => $entity_attr['name'],
            'entry'                     => json_encode($excel_row),
            'last_modified'             => datetime_int_to_str(time()),
            'excel_order'               => $excel_order,
            'excel_file_id'             => $excel_file_id
        ));
        if (!empty($save_excel)) 
        {
            et_save_excel_file_by_idenitifier($entity_attr, 'id', $excel_file_id);
        }
    }
    return $ret_array;
}

function et_delete_combined_by_identifier($entity_attr, $identifier_name, $identifier_value, $save_excel = true, $excel_file_id = false)
{
    $table_row = et_get_by_identifier($entity_attr['name'], $identifier_name, $identifier_value);
    if (empty($table_row)) {
        throw new Exception('row to delete does not exists');
    }
    if (!empty($entity_attr['use_excels'])) {
        if ($entity_attr['excel_identifier'] == '') {
            $excel_identifier_value = $table_row['excel_identifier_value'];
        } else {
            $excel_identifier_value = $identifier_value;
        }
        if (!empty($save_excel) && empty($excel_file_id)) {
            $excel_entry = et_get_by_identifier('adm_et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $excel_identifier_value);
            $excel_file_id = $excel_entry['excel_file_id'];
        }
    }
    et_delete_by_identifier($entity_attr['name'], $identifier_name, $identifier_value);
    if (!empty($entity_attr['use_excels'])) {
        et_delete_by_identifier('adm_et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $excel_identifier_value);
        if (!empty($save_excel)) {
            et_save_excel_file_by_idenitifier($entity_attr, 'id', $excel_file_id);
        }
    }
}

function et_get_combined_by_identifier($entity_attr, $identifier_name, $identifier_value)
{
    $table_row              = array();
    $excel_row              = array();
    $combined_row           = array();
    $excel_identifier_value = $identifier_value;

    $table_row              = et_get_by_identifier($entity_attr['name'], $identifier_name, $identifier_value);

    if(!empty($entity_attr['use_excels'])) 
    {
        if ($entity_attr['excel_identifier'] == '') 
        {
            $excel_identifier_value = $table_row['excel_identifier_value'];

        } 
        elseif (!empty($table_row)) 
        {
            $excel_identifier_value = $table_row[$entity_attr['excel_identifier']];

        }
        else 
        {
            $excel_identifier_value = $identifier_value;
        }

        $excel_entry                = et_get_by_identifier('adm_et_excel_entries', 'unique_value', $entity_attr['name'] . '_' . $excel_identifier_value);
        $excel_row                  = json_decode($excel_entry['entry'], true);
    }
    foreach ($entity_attr['columns_attributes'] as $column_name => $column_attr) 
    {
        if (isset($table_row[$column_name])) 
        {
            $combined_row[$column_name] = $table_row[$column_name];
        } 
        elseif (isset($excel_row[$column_name])) 
        {
            $combined_row[$column_name] = $excel_row[$column_name];
        }
    }
    return $combined_row;
}

function et_save_excel_file_by_idenitifier($entity_attr, $identifier_name, $identifier_value)
{
    $CI =& get_instance();
    $rows                   = et_get_all('adm_et_excel_files', array('where' => array('entity' => $entity_attr['name'], $identifier_name => $identifier_value)));
    if (empty($rows)) 
    {
        throw new Exception('excel file not found');
    }
    $excel_file_row         = $rows[0];
    $excel_file_path        = $CI->config->item('excels_dir') . '/' . $entity_attr['name'] . '/' . $excel_file_row['name'] . '.xls';

    if (!et_check_file_access($excel_file_path)) 
    {
        throw new Exception('No file access');
    }
    $file_attr              = json_decode($excel_file_row['attributes'], true);

    if(sha1_file($excel_file_path) != $file_attr['sha1']) 
    {
        throw new Exception('Excel file is modified, please update.');
    }
    $excel_entries          = et_get_all('adm_et_excel_entries', array('where' => array('excel_file_id' => $excel_file_row['id'])));

    $rows = array();

    foreach ($excel_entries as $excel_entry) 
    {
        $rows[]             = json_decode($excel_entry['entry'], true);
    }
    $columns_attr           = $entity_attr['columns_attributes'];
    $attributes             = json_decode($excel_file_row['attributes'], true);
  
    $unordered_existing_column_names_keys = et_merge_arrays_in_order($rows, 2, true);
     // order should be 2 // wat if only one array
    //var_dump($unordered_existing_column_names_keys);

    $all_column_names       = array_keys(et_merge_arrays_in_order(array($attributes['columns_attr'], $columns_attr, $unordered_existing_column_names_keys), 2, true));

 
    // create $column_names
    $unordered_existing_column_names = array_keys($unordered_existing_column_names_keys);
    $column_names = array();

    foreach ($all_column_names as $all_column_name) 
    {
        if (in_array($all_column_name, $unordered_existing_column_names)) 
        {
            $column_names[]     = $all_column_name;
        }
    }
    if (empty($column_names)) 
    { // in cases whr it is an empty excel file
        if (!empty($attributes['columns_attr']))
        {
            $column_names       = array_keys(et_merge_arrays_in_order(array($attributes['columns_attr'], $unordered_existing_column_names_keys), 2, true));
        } 
        else 
        {
            $column_names       = $unordered_existing_column_names;
        }
    }
    // create $column_wise_json
    $existing_column_wise_json   = array();

    foreach ($column_names as $column_name) 
    {
        if (!empty($columns_attr[$column_name]['is_column_wise_json'])) 
        {
            $existing_column_wise_json[$column_name]    = array();
            $this_column_json_arrays                    = array();

            foreach ($rows as $row) 
            {
                if (!empty($row[$column_name])) 
                {
                    $json = json_decode($row[$column_name], true);
                    if (!empty($json)) 
                    {
                        $this_column_json_arrays[]      = $json;
                    }
                }
            }
            $existing_column_wise_json[$column_name] = et_merge_arrays_in_order($this_column_json_arrays, 0, true);
        }
    }
    // convert them into ordered json structure
    //$column_wise_json = et_intersect_arrays_in_order($all_column_wise_json, $existing_column_wise_json, true);

    $column_wise_json           = $existing_column_wise_json;

    $excel_columns_attr         = array();
    $attributes_for_excel_file  = array('name', 'display_name', 'is_column_wise_json', 'column_wise_json_structure', 'is_four_spaced_json');
    $attributes_not_to_update   = array('column_wise_json_structure');

    foreach ($column_names as $column_name) 
    {
        $excel_columns_attr[$column_name] = array();

        foreach ($attributes_for_excel_file as $attr_name) 
        {
            if (isset($columns_attr[$column_name][$attr_name]) && !in_array($attr_name, $attributes_not_to_update)) 
            {
                $excel_columns_attr[$column_name][$attr_name] = $columns_attr[$column_name][$attr_name];
            }
        }
        if (isset($column_wise_json[$column_name])) 
        {
            $excel_columns_attr[$column_name]['column_wise_json_structure'] = $column_wise_json[$column_name];
        }
    }
  
    et_save_excel_file($excel_file_path, $rows, $excel_columns_attr);

    $new_attributes                     = array();
    $new_attributes['size']             = filesize($excel_file_path);
    $new_attributes['sha1']             = sha1_file($excel_file_path);
    $new_attributes['last_modified']    = filemtime($excel_file_path);
    $new_attributes['columns_attr']     = $excel_columns_attr;
    $excel_file_row['attributes']       = json_encode($new_attributes);

    et_edit_by_identifier('adm_et_excel_files', $excel_file_row, 'id', $excel_file_row['id'], true);
}

function et_save_excel_file($excel_file_path, $rows, $columns_attr = array())
{
    if(empty($columns_attr)) 
    {
        $column_names                   = array_keys(et_merge_arrays_in_order($rows, 0, true));
        foreach ($column_names as $column_name) 
        {
            $columns_attr[$column_name] = array('name' => $column_name, 'display_name' => $column_name);
        }
    }

    $excel_rows                         = array();

    for ($i = 0; $i < count($rows) + 1; $i++) 
    {
        $excel_rows[]                   = array();
    }

    //var_dump($columns_attr);
    // create function for recursive fill

    if (!function_exists('et_save_excel_file_recursive_column_fill')) 
    {
        function et_save_excel_file_recursive_column_fill($excel_rows, $column_index, $column_wise_json_structure, $json_arrays)
        {
            foreach($column_wise_json_structure as $column_name => $value) 
            {
                if(is_array($value)) 
                {
                    $excel_rows[0][$column_index]   = $column_name . ' [';
                    $column_index++;
                    $more_json_arrays               = array();
                    foreach ($json_arrays as $json_array) 
                    {
                        if (isset($json_array[$column_name])) 
                        {
                            $more_json_arrays[]     = $json_array[$column_name];
                        } 
                        else 
                        {
                            $more_json_arrays[]     = array();
                        }
                    }

                    $ret_array                      = et_save_excel_file_recursive_column_fill($excel_rows, $column_index, $value, $more_json_arrays);
                    $column_index                   = $ret_array['column_index'];
                    $excel_rows                     = $ret_array['excel_rows'];
                    $excel_rows[0][$column_index]   = ']';
                } 
                else
                {
                    $excel_rows[0][$column_index]   = et_encode_excel_column_str($column_name);
                    for ($i = 0; $i < count($json_arrays); $i++) 
                    {
                        if (isset($json_arrays[$i][$column_name])) 
                        {
                            $excel_rows[$i + 1][$column_index] = $json_arrays[$i][$column_name];

                        }
                    }
                }

                $column_index++;
            }
            return array(
                'column_index'  => $column_index,
                'excel_rows'    => $excel_rows
            );
        }
    }

    $column_index                           = 0;

    if(isset($columns_attr) && $columns_attr !='')
    {

        foreach ($columns_attr as $column_name => $column_attr) 
        {
            

            if (!empty($column_attr['is_column_wise_json'])) 
            {
                $excel_rows[0][$column_index]   = $column_attr['display_name'] . ' [';
                $column_index++;
                $json_arrays                    = array();
                foreach ($rows as $row) {
                    if (isset($row[$column_name])) {
                        $json_arrays[]          = json_decode($row[$column_name], true);
                    } else {
                        $json_arrays[]          = array();
                    }
                }
                $ret_array                      = et_save_excel_file_recursive_column_fill($excel_rows, $column_index, $column_attr['column_wise_json_structure'], $json_arrays);
                $column_index                   = $ret_array['column_index'];
                $excel_rows                     = $ret_array['excel_rows'];
                $excel_rows[0][$column_index]   = ']';
            } 
            elseif (!empty($column_attr['is_four_spaced_json'])) 
            { 
                // four space json
                $excel_rows[0][$column_index]   = $column_attr['display_name'] . ' []';
                for ($i = 0; $i < count($rows); $i++) 
                {
                    if (isset($rows[$i][$column_name])) 

                    {
                        $excel_rows[$i + 1][$column_index] = et_encode_four_spaced_json(json_decode($rows[$i][$column_name], true));
                    }
                }
            } 
            else
            {
                if(isset($column_attr) && !empty($column_attr))
                {
                     $excel_rows[0][$column_index]   = et_encode_excel_column_str($column_attr['display_name']);

                    for ($i = 0; $i < count($rows); $i++) 
                    {
                        if (isset($rows[$i][$column_name])) 
                        {
                            $excel_rows[$i + 1][$column_index] = $rows[$i][$column_name];
                        }
                    }
                }
               
            }
            $column_index++;
        }
    }
    

    $no_of_columns                          = $column_index;

    // set active sheet to 0 and set all cells blank

    $objPHPExcel                            = new PHPExcel();

    $objPHPExcel->setActiveSheetIndex(0);
    $objWorksheet                           = $objPHPExcel->getActiveSheet();
    if (file_exists($excel_file_path)) 
    {
        $objReader                          = new PHPExcel_Reader_Excel5();
        $objPHPExcel                        = $objReader->load($excel_file_path);

        $objPHPExcel->setActiveSheetIndex(0);

        $objWorksheet                       = $objPHPExcel->getActiveSheet();
        foreach ($objWorksheet->getRowIterator() as $row) 
        {
            $cellIterator                   = $row->getCellIterator();
            //$cellIterator->setIterateOnlyExistingCells(FALSE);
            foreach ($cellIterator as $cell) 
            {
                $cell->setValue('');
            }
        }
    }
    $column_index               = 0;
    $row_index                  = 1;
    foreach ($columns_attr as $column_name => $columns_attr) 
    {
        $objWorksheet->setCellValueByColumnAndRow($column_index, $row_index, $column_name);
        $column_index++;
    }
    $row_index = 1; 

     //starts with 1, column index starts from 0

    foreach ($excel_rows as $excel_row) 
    {
        //$row = json_decode($excel_entry['entry'], true);
        for ($column_index = 0; $column_index < $no_of_columns; $column_index++) 
        {
            if (isset($excel_row[$column_index]) && $excel_row[$column_index] != '') 
            {
                if ($excel_row[$column_index] == ' ') 
                {
                    $objWorksheet->setCellValueByColumnAndRow($column_index, $row_index, '&nbsp;'); // substitute single space with htmlencoded space
                } 
                else 
                {
                    $objWorksheet->setCellValueByColumnAndRow($column_index, $row_index, $excel_row[$column_index]);
                }
            } 
            else 
            {
                $objWorksheet->setCellValueByColumnAndRow($column_index, $row_index, ' '); // appending spaces for cell overflow problem
            }
        }
        $row_index++;
    }
   /* $objWriter                      = new PHPExcel_Writer_Excel5($objPHPExcel); 
    // for .xls
    $objWriter->save($excel_file_path);*/
}

function et_encode_excel_column_str($str)
{
    $str = '' . $str;
    if (substr($str, strlen($str) - 1) == '[') {
        return substr($str, 0, strlen($str) - 1) . '&#91;';
    } elseif (substr($str, strlen($str) - 1) == ']') {
        return substr($str, 0, strlen($str) - 1) . '&#93;';
    } else {
        return $str;
    }
}

function et_decode_excel_column_str($str)
{
    $str = '' . $str;
    if (substr($str, strlen($str) - 5) == '&#91;') {
        return substr($str, 0, strlen($str) - 5) . '[';
    } elseif (substr($str, strlen($str) - 5) == '&#93;') {
        return substr($str, 0, strlen($str) - 5) . ']';
    } else {
        return $str;
    }
}

function et_encode_four_spaced_json_data($str)
{
    $str = '' . $str;
    return str_replace(array("\n    ", "::"), array("\n&nbsp;   ", "&#58;&#58;"), $str);
}

function et_decode_four_spaced_json_data($str)
{
    $str = '' . $str;
    $str = str_replace(array("\n&nbsp;   ", "&#58;&#58;"), array("\n    ", "::"), $str);
    $str = trim($str);
    return $str;
}

function et_intersect_arrays_in_order($complete_ordered_array, $other_array, $array_of_keys = false)
{
    $intersect_array = array();
    if (!$array_of_keys) {
        foreach ($complete_ordered_array as $value) {
            if (in_array($value, $other_array)) {
                $intersect_array[] = $value;
            }
        }
    } else {
        foreach ($complete_ordered_array as $key => $value) {
            if (isset($other_array[$key])) {
                if (is_array($value)) {
                    $intersect_array[$key] = et_intersect_arrays_in_order($value, $other_array[$key], true);
                } else {
                    $intersect_array[$key] = '';
                }
            }
        }
    }
    return $intersect_array;
}

function et_arrays_clear_data($array)
{

    $new_array = array();
    foreach ($array as $key => $value) 
    {
        if (is_array($value)) 
        {
            $new_array[clear_data($key)] = et_arrays_clear_data($value);
        } 
        else 
        {
            $new_array[clear_data($key)] = clear_data($value);

        }

    }
    return $new_array;
}

function et_remove_data_type_details($columns_attr)
{
    foreach ($columns_attr as $column_name => $column_attr) {
        if (!empty($columns_attr[$column_name]['data_type_details'])) {
            unset($columns_attr[$column_name]['data_type_details']);
            if (!empty($columns_attr[$column_name]['structure_attributes'])) {
                foreach ($columns_attr[$column_name]['structure_attributes'] as $key => $value) {
                    if (!empty($columns_attr[$column_name]['structure_attributes'][$key]['data_type_details'])) {
                        unset($columns_attr[$column_name]['structure_attributes'][$key]['data_type_details']);
                    }
                }
            }
        }
    }
    return $columns_attr;
}


function et_products_delete_attributes($product_id)
{
    $rows = et_get_all('product_attribute', array('where' => array('product_id' => $product_id)));
    if (!empty($rows)) 
    {
        //delete all
        et_delete_by_identifier('product_attribute', 'product_id', $product_id);
        foreach ($rows as $row) 
        {
            $pas = et_get_all('product_attribute', array('where' => array('attribute_id' => $row['attribute_id'])));
            if (empty($pas)) 
            {
                et_delete_by_identifier('attributes', 'id', $row['attribute_id']);
            }
        }
    }
}

function et_products_add_attributes($attrs, $product_id, $prefix = '')
{
    foreach ($attrs as $key => $value) 
    {
        $name = $prefix . ' ' . $key;
        if (is_array($value)) {
            et_products_add_attributes($value, $product_id, $name);
        } else {
            $res_rows = et_get_all('attributes', array('where' => array('name' => $name, 'value' => $value)));
            if (!empty($res_rows)) {
                $attribute_id = $res_rows[0]['id'];
            } else {
                $attribute_id = et_add('attributes', array('name' => $name, 'value' => $value));
            }
            // enter into product_attribute
            $res_rows = et_get_all('product_attribute', array('where' => array('product_id' => $product_id, 'attribute_id' => $attribute_id)));
            if (empty($res_rows)) {
                et_add('product_attribute', array('product_id' => $product_id, 'attribute_id' => $attribute_id));
            }
        }
    }
}

function et_products_gen_extras($entity_attr, $rows)
{
    $CI =& get_instance();
    $identifier_name            = $entity_attr['excel_identifier'];
    $product_images_src_dir     = $CI->config->item('product_images_src');
    $product_images_src_resize  = $CI->config->item('product_images_src_resize');
    $product_images_dest_resize = $CI->config->item('product_images_des_resize');
    $product_images_dest_dir    = $CI->config->item('product_images_dest');
    $product_images_dest_url    = $CI->config->item('product_images_url');
    $small_image_res            = $CI->config->item('product_small_image_res');
    $medium_image_res           = $CI->config->item('product_medium_image_res');
    $small_image_extension      = $CI->config->item('product_small_image_ext');
    $medium_image_extension     = $CI->config->item('product_medium_image_ext');
    $catalogs_dest_dir          = $CI->config->item('product_catalogs_dir');
    $catalog_admin_dir          = $CI->config->item('admin_dir');
    $catalogs_url               = $CI->config->item('product_catalogs_url');
    $catalogs_ext               = $CI->config->item('product_catalogs_ext');
    $product_image_compression  = $CI->config->item('product_image_compression');
    $product_image_squared      = $CI->config->item('product_image_squared');
    foreach ($rows as $row) 
    {
        $edit_row   = array();
        $meta       = array();
        if (!empty($row['meta'])) 
        {
            json_decode($row['meta'], true);
        }
        else{
            $meta  = $row;
        }
        

        $subcat                     = et_get_by_identifier('categories', 'id', $row['category_id']);
        if (!empty($subcat)) 
        {
            $maincat                = et_get_by_identifier('categories', 'id', $subcat['parent_id']);
        } else {
            echo 'No category found for the product ' . $row['sku'];
        }
        if (empty($meta['meta_title'])) 
        {
            $edit_row['meta_title']     = $row['name'];
            if (!empty($maincat)) {
                $edit_row['meta_title'] = $maincat['name'] . ' | ' . $row['name'];
            }
        }
        else 
        {
            $edit_row['meta_title']     = $meta['meta_title'];
        }
         if (empty($meta['meta_keyword'])) 
        {
            $edit_row['meta_keyword']     = $row['name'];
            if (!empty($maincat)) {
                $edit_row['meta_keyword'] = $maincat['name'] . ' , ' . $row['name'];
            }
        }
        else 
        {
            $edit_row['meta_keyword']     = $meta['meta_keyword'];
        }
        if (empty($meta['url_title'])) 
        {
            $edit_row['url_title']      = url_title($row['sku']);
            $url_title                  = $edit_row['url_title'];
        } 
        else 
        {
            $edit_row['url_title']      = url_title($meta['url_title']);
            $url_title                  = $edit_row['url_title'];
        }
        if (empty($meta['meta_description'])) 
        {
            $edit_row['meta_description'] = $row['description'];
        } 
        else 
        {
            $edit_row['meta_description'] = $meta['meta_description'];
        }
        if (strlen($edit_row['meta_description']) > 1000)
        {
            $edit_row['meta_description'] = substr($edit_row['meta_description'], 0, 1000);
        }
        if (empty($meta['image_title'])) 
        {
            $edit_row['image_title']      = $row['name'];
            $image_title                  = $edit_row['image_title'];
        } 
        else 
        {
            $edit_row['image_title']      = $meta['image_title'];
            $image_title                  = $edit_row['image_title'];
        }
        if (empty($meta['image_alt'])) 
        {
            $edit_row['image_alt']          = $row['name'];
        } 
        else 
        {
            $edit_row['image_alt']          = $meta['image_alt'];
        }
        //generating page_url
        $page_url                           = $url_title;
        $cat_ok                             = true;
        $next_cat_id                        = $row['category_id'];
        do {
            $cat                            = et_get_by_identifier('categories', 'id', $next_cat_id);
            if (!empty($cat)) 
            {
                $page_url                   = $cat['url_title'] . "/" . $page_url;
                $next_cat_id                = $cat['parent_id'];
            } 
            else 
            {
                $cat_ok                     = false;
                echo "<br>category link missing " . $row['sku'];
                break;
            }
        } 
        while ($cat['level']);
        if ($cat_ok) 
        {
            $edit_row['page_url']           = strtolower($page_url);
        }
        // generating images for products
        $small_image_dest                   = $product_images_dest_dir . "/" . url_title($image_title) . $small_image_extension . ".jpg";
        $medium_image_dest                  = $product_images_dest_dir . "/" . url_title($image_title) . $medium_image_extension . ".jpg";
        /*
                 $small_image_dest                   = $product_images_dest_resize . "/" . url_title($image_title) . $small_image_extension . ".jpg";
                $medium_image_dest                  = $product_images_dest_resize . "/" . url_title($image_title) . $medium_image_extension . ".jpg";
        */
        $image_src = '';$resize_image_src='';

        if (!file_exists($small_image_dest) || !file_exists($medium_image_dest)) 
        {
            if (file_exists($product_images_src_dir . "/" . $row['sku'] . ".png")) 
            {
                
                $image_src                  = $product_images_src_dir . "/" . $row['sku'] . ".png";
                $resize_image_src           = $product_images_src_resize . "/" . $row['sku'] . ".png";
            } 
            elseif (file_exists($product_images_src_dir . "/" . $row['sku'] . ".jpg")) 
            {
                $image_src                  = $product_images_src_dir . "/" . $row['sku'] . ".jpg";
                $resize_image_src           = $product_images_src_resize . "/" . $row['sku'] . ".jpg";
            }
            if (!empty($image_src)) 
            {
                
                resize_image($resize_image_src,$image_src, $small_image_dest, $small_image_res[0], $small_image_res[1]);
                resize_image($resize_image_src,$image_src, $medium_image_dest, $medium_image_res[0], $medium_image_res[1]);
            } 
            else 
            {
                echo "<br>no source image " . $row['sku'];
            }
        }
        if (file_exists($small_image_dest) && file_exists($medium_image_dest)) 
        {
            $edit_row['image_url']           = array();
            $edit_row['image_url']['small']  = $product_images_dest_url . "/" . url_title($image_title) . $small_image_extension . ".jpg";
            $edit_row['image_url']['medium'] = $product_images_dest_url . "/" . url_title($image_title) . $medium_image_extension . ".jpg";
            $edit_row['image_url']           = json_encode($edit_row['image_url']);
        } 
        else 
        { 

             log_message('error','labtron_excel_helper et_products_gen_extras code>> Error while adding excel file no images>> '.$row['sku']);
            $CI->session->set_flashdata('excel_error', 'no image  >> '. $row['sku']);
             redirect($_SERVER['HTTP_REFERER']);
        }
        // generating catalog and its url
        // check if destination  exist
        $exists = false;
        if (file_exists_case_sensitive($catalogs_dest_dir . '/' . url_title($row['name']) . $catalogs_ext . '.pdf')) 
        {
            $exists                         = true;
            $filename                       = url_title($row['name']) . $catalogs_ext . '.pdf';
        } 
        else 
        {
            $next_cat_id                    = $row['category_id'];
            $cat                            = et_get_by_identifier('categories', 'id', $next_cat_id);
            if (!empty($row['series']) && file_exists_case_sensitive($catalogs_dest_dir . '/' . url_title($cat['name']) . '-' . $row['series'] . $catalogs_ext . '.pdf')) 
            {
                $exists                     = true;
                $filename                   = url_title($cat['name']) . '-' . $row['series'] . $catalogs_ext . '.pdf';
                log_message('error',' labtron_excel_helper et_products_gen_extras code>> catalog 11>> '.$filename);
            } 
            elseif (file_exists_case_sensitive($catalog_admin_dir . '/' . $row['catalog_url'])) 
            {
                $exists                     = true;
                $new_catalog_url            = ltrim($row['catalog_url'], 'catalog/'); 
                $filename                   = $new_catalog_url;
                log_message('error',' labtron_excel_helper et_products_gen_extras code>> catalog url exist 11>> '.$filename);
            } 
            else 
            {
                $next_cat_id                = $row['category_id'];
                while (!empty($next_cat_id)) 
                {
                     log_message('error',' labtron_excel_helper et_products_gen_extras code>> catalog21 while next_cat_id>> '.$next_cat_id);
                    $cat                    = et_get_by_identifier('categories', 'id', $next_cat_id);
                    if (file_exists_case_sensitive($catalogs_dest_dir . '/' . url_title($cat['name']) . $catalogs_ext . '.pdf')) 
                    {

                        $exists             = true;
                        $filename           = url_title($cat['name']) . $catalogs_ext . '.pdf';
                         log_message('error',' labtron_excel_helper et_products_gen_extras code>> catalog22 while if file exist>> '.$filename);
                        break;
                    }
                    $next_cat_id            = $cat['parent_id'];
                }
            }
        }
        if ($exists && file_exists($catalogs_dest_dir . '/' . $filename)) 
        {
            $edit_row['catalog_url']        = $catalogs_url . '/' . $filename;
        } 
        else 
        {
             log_message('error','labtron_excel_helper et_products_gen_extras code>> Error while adding excel file no catalog>> '.$row['sku']);
            $CI->session->set_flashdata('excel_error', 'no catalog  >> '. $row['sku']);
            $edit_row['catalog_url']        = '';
        }
        $edited = false;
        foreach ($edit_row as $key => $value) 
        {
            if (!isset($row[$key]) || $row[$key] != $value) 
            {
                $edited                 = true;
                break;
            }
        }
        if ($edited) 
        {
            et_edit_by_identifier($entity_attr['name'], $edit_row, $identifier_name, $row[$identifier_name]);
        }
        $product_id                     = $row['id'];
        et_products_delete_attributes($product_id);
        $specs                          = json_decode($row['specifications'], true);
        et_products_add_attributes($specs, $product_id);
    }
}

function et_products_delete_extras($entity_attr, $rows)
{
    foreach ($rows as $row) 
    {
        et_products_delete_attributes($row['id']);
    }
}

function et_categories_gen_extras($entity_attr, $rows)
{
    $CI =& get_instance();

    $identifier_name                    = $entity_attr['excel_identifier'];

    $category_meta_title_ext            = (!empty(bsnprm_value(BSN_WEBSITE_NAME)))?(bsnprm_value(BSN_WEBSITE_NAME)):$CI->config->item('website_name');

    foreach ($rows as $row) 
    {
        $edit_row                       = array();
        $meta                           = array();
        if(!empty($row['meta'])) 
        {
             $meta = json_decode($row['meta'], true);
        }
        else{
            $meta  = $row;
        }

         
        if(empty($meta['page_title'])) 
        {
            $edit_row['page_title']     = $row['name'];
        } 
        else 
        {
            $edit_row['page_title']     = $meta['page_title'];
        }

        $maincat                        = et_get_by_identifier('categories', 'id', $row['parent_id']);

        if (empty($meta['meta_title'])) 
        {
            $edit_row['meta_title']         = $row['name']  .' | '. $category_meta_title_ext;

            if ($maincat) 
            {
                $edit_row['meta_title']     = $maincat['name'] . ' | ' . $row['name'] . ' | ' .$category_meta_title_ext;
            }
        }
        else 
        {
            $edit_row['meta_title']         = $meta['meta_title'];
        }
        if (empty($meta['meta_keyword'])) 
        {
            $edit_row['meta_keyword']         = $row['name']  .' , '. $category_meta_title_ext;
            
            if ($maincat) 
            {
                $edit_row['meta_keyword']     = $maincat['name'] . ' , ' . $row['name'] . ', ' .$category_meta_title_ext;
            }
        }
        else 
        {
            $edit_row['meta_keyword']         = $meta['meta_keyword'];
        }
        if (empty($meta['url_title'])) 
        {
            $edit_row['url_title']          = url_title($row['name']);
        } 
        else 
        {
            $edit_row['url_title']          = url_title($meta['url_title']);
        }
        if (empty($meta['meta_description'])) 
        {
            $edit_row['meta_description']   = $row['description'];
        } else 
        {
            $edit_row['meta_description']   = $meta['meta_description'];
        }
        /*if (strlen($edit_row['meta_description']) > 1000) 
        {
            $edit_row['meta_description']   = substr($edit_row['meta_description'], 0, 1000);
        }*/
        if (empty($meta['image_title'])) 
        {
            $edit_row['image_title']        = $row['name'];
            $image_title                    = $edit_row['image_title'];
        } 
        else 
        {
            $edit_row['image_title']        = $meta['image_title'];
            $image_title                    = $edit_row['image_title'];
        }
        if (empty($meta['image_alt'])) 
        {
            $edit_row['image_alt']          = $row['name'];
        } 
        else 
        {
            $edit_row['image_alt']          = $meta['image_alt'];
        }
       
        try 
        {
            //echo $edit_row;
            et_edit_by_identifier($entity_attr['name'], $edit_row, $identifier_name, $row[$identifier_name]);
        }catch (Exception $e) 
        {
            log_message('error','Labtron_excel_helper et_categories_gen_extras >> '.$e->getMessage());
             $CI->session->set_flashdata('excel_error', 'Filename : Labtron_excel_helper function : et_categories_gen_extras >> '.$e->getMessage());
            redirect('dashboard');
           
        }
    }

    $rows = et_get_all($entity_attr['name']);
    $changed_ids = array();

    // setting page_urls and level
    if (!function_exists('et_categories_traverse_children')) 
    {
        function et_categories_traverse_children($id, $level, $parent_page_url, &$rows, &$changed_ids)
        {
            for ($i = 0; $i < count($rows); $i++) 
            {
                if ($rows[$i]['parent_id'] == $id) 
                {
                    $level_before           = $rows[$i]['level'];
                    $page_url_before        = strtolower($rows[$i]['page_url']);
                    $rows[$i]['level']      = $level;
                    $cat_page_url           = $parent_page_url . "/" . $rows[$i]['url_title'];
                    $rows[$i]['page_url']   = strtolower($cat_page_url);
                    if ($page_url_before != $rows[$i]['page_url'] || $level_before != $rows[$i]['level']) 
                    {
                        $changed_ids[]      = $i;
                    }
                    et_categories_traverse_children($rows[$i]['id'], $level + 1, $rows[$i]['page_url'], $rows, $changed_ids);
                }
            }
        }
    }
    for ($i = 0; $i < count($rows); $i++) 
    {
        if (!$rows[$i]['parent_id']) 
        { 
            // this is a root , trace its childs and set their level and their page_urls
            $page_url_before                = strtolower($rows[$i]['page_url']);
            $rows[$i]['page_url']           = strtolower($rows[$i]['url_title']);
            if ($page_url_before != $rows[$i]['page_url']) 
            {
                $changed_ids[]              = $i;
            }

            et_categories_traverse_children($rows[$i]['id'], 1, $rows[$i]['page_url'], $rows, $changed_ids);
        }
    }
    foreach ($changed_ids as $changed_id) 
    {
        try 
        {
            et_edit_by_identifier($entity_attr['name'], $rows[$changed_id], $identifier_name, $rows[$changed_id][$identifier_name]);
        } catch(Exception $e) {
            log_message('error','labtron_excel_helper foreach et_categories_gen_extras >> Error while handling excel file et_edit_by_identifier >> '.$e->getMessage());

             $CI->session->set_flashdata('excel_error', 'Filename :labtron_excel_helper Function: et_categories_gen_extras foreach message:  Error while handling excel file et_edit_by_identifier>> '.$e->getMessage());
            redirect('dashboard');
           
        }
    }
}

function et_sections_gen_extras($entity_attr, $rows)
{
    $CI =& get_instance();

    $identifier_name                    = $entity_attr['excel_identifier'];

    $section_meta_title_ext             = (!empty(bsnprm_value(BSN_WEBSITE_NAME)))?(bsnprm_value(BSN_WEBSITE_NAME)):$CI->config->item('website_name');
  

    foreach ($rows as $row) 
    {
        $edit_row                       = array();
        $meta                           = array();
        if (!empty($row['meta'])) 
        {
            $meta = json_decode($row['meta'], true);
        }
        else{
            $meta = $row;
        }
        if (empty($meta['page_title'])) 
        {
            $edit_row['page_title']     = $row['section'];
        } 
        else 
        {
            $edit_row['page_title']     = $meta['page_title'];
        }
        if (empty($meta['page_url'])) 
        {
            $edit_row['page_url']   = strtolower(str_replace(' ','-',$row['section']));
        } else 
        {
            $edit_row['page_url']   = strtolower($meta['page_url']);
        }
        if (empty($meta['meta_title'])) 
        {
            $edit_row['meta_title']   = $row['section'] .' | '. $section_meta_title_ext;
        } else 
        {
            $edit_row['meta_title']   = $meta['meta_title'];
        }
        if (empty($meta['meta_keyword'])) 
        {
            $edit_row['meta_keyword']   = $row['section'] .' , '. $section_meta_title_ext;
        } else 
        {
            $edit_row['meta_keyword']   = $meta['meta_keyword'];
        }
        if (empty($meta['meta_description'])) 
        {
            $edit_row['meta_description']   = $row['description'];
        } else 
        {
            $edit_row['meta_description']   = $meta['meta_description'];
        }
        if (strlen($edit_row['meta_description']) > 1000) 
        {
            $edit_row['meta_description']   = substr($edit_row['meta_description'], 0, 1000);
        }
        if (empty($meta['image_title'])) 
        {
            $edit_row['image_title']        = $row['section'];
            $image_title                    = $edit_row['image_title'];
        } 
        else 
        {
            $edit_row['image_title']        = $meta['image_title'];
            $image_title                    = $edit_row['image_title'];
        }
        if (empty($meta['image_alt'])) 
        {
            $edit_row['image_alt']          = $row['section'];
        } 
        else 
        {
            $edit_row['image_alt']          = $meta['image_alt'];
        }


        try 
        {
           
            et_edit_by_identifier($entity_attr['name'], $edit_row, $identifier_name, $row[$identifier_name]);

        }catch (Exception $e) 
        {
             log_message('error','Labtron_excel_helper et_sections_gen_extras >> '.$e->getMessage());

             $CI->session->set_flashdata('excel_error', 'Filename: Labtron_excel_helper function: et_sections_gen_extras >> '.$e->getMessage());
            redirect('dashboard');
        }
    }  
}

function resize_image($resize_source,$source, $destination, $width = 0, $height = 0) 
{  
    $admin_url = url_without_admin();
   
    $CI                         =& get_instance();
    $image_info                 = getimagesize($admin_url.$resize_source); 
    $config['image_library']    = 'gd2';
    $config['source_image']     = $source; 
    $config['new_image']        = $destination;
    $config['quality']          = 90;
    $config['maintain_ratio']   = FALSE;
    $config['width']            = $width;
    $config['height']           = $height;

    //send config array to image_lib's  initialize function
    // Call resize function in image library.
    $CI->image_lib->initialize($config);
    $CI->image_lib->resize();
    $CI->image_lib->clear();
 
    // Return new image contains above properties and also store in "upload" folder.
    return true;
}

function conv_image($source, $destination, $width = 0, $height = 0, $compression = 90, $squared = false, $transparent_bg = true)
{
    $pic = new Imagick($source);
    if (empty($width) || empty($height)) {
        $width = $pic->getImageWidth();
        $height = $pic->getImageHeight();
    }
    if ($squared) {
        if ($width > $height) {
            $height = $width;
        } else {
            $width = $height;
        }
    }
    $pic->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1, true);
    $file_parts = pathinfo($destination);
    if ($file_parts['extension'] == 'png' && $transparent_bg) {
        $pic->setImageBackgroundColor('None');
        
    } else {
        $pic->setImageBackgroundColor(new ImagickPixel('#FFFFFF'));
        //$pic = $pic->flattenImages();
      
       
        /*         
         $pic = $pic->setImageAlphaChannel(11); // Imagick::ALPHACHANNEL_REMOVE
         $pic = $pic->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);*/
    }
    if ($squared) {
        $pic->extentImage($width, $height, -($width - $pic->getImageWidth()) / 2, -($height - $pic->getImageHeight()) / 2);
    }
    if (!empty($compression)) {
        $pic->setImageCompression(Imagick::COMPRESSION_JPEG);
        $pic->setImageCompressionQuality($compression);
    }
    $pic->writeImage($destination);
    $pic->destroy();
}

?>