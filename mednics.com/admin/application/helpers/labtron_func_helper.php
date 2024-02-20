<?php

/***********************************************************
		NORMAL CRUD FUNCTIONS STARTS
************************************************************/

	function update($field, $id, $array, $table)
	{
		$CI 		 = & get_instance();
		$CI->db->where($field, $id);
		$CI->db->update($table, $array);
		
		log_message('ERROR','>>library update >>'.$CI->db->last_query());

		return $id;
	}

	function insert($table, $array)
	{
		$CI 		 = & get_instance();
		$CI->db->insert($table, $array);

		log_message('ERROR','>>library insert >>'.$CI->db->last_query());

		$id = $CI->db->insert_id();
		return $id;
	}

  	function detail_data($fields, $table_name, $where_condition = '', $order_by = '')
    {
    	$CI 		 = & get_instance();
        $sql = 'select ' . $fields . ' from ' . $table_name;
        if ($where_condition) $sql.= ' where ' . $where_condition;
        if ($order_by) $sql.= ' ' . $order_by;
        return $CI->db->query($sql)->row_array();
    }

    function list_data($fields, $table_name, $where_condition = '', $order_by = '')
    {
    	$CI 		 = & get_instance();
        $sql = 'select ' . $fields . ' from ' . $table_name;
        if ($where_condition) $sql.= ' where ' . $where_condition;
        if ($order_by) $sql.= ' ' . $order_by;
        return $CI->db->query($sql)->result_array();
    }

    function field_data($field, $table_name, $id = '')
    {
    	$CI 		 = & get_instance();
        $prefix = explode("_", $field) [0];
        $sql = 'select ' . $field . ' retfield from ' . $table_name . ' where ' . $prefix . '_id = ' . $id;
        return $CI->db->query($sql)->row()->retfield;
    }

    function get_column_data($table_name = '')
    {
    	$CI 		 = & get_instance();
    	$sqlQuery 	 = 'SHOW COLUMNS FROM '.$table_name.' ';
 
        $query       = $CI->db->query($sqlQuery);
       
		$row 		 = $query->result_array();
		return $row;
    }

/***********************************************************
		NORMAL CRUD FUNCTIONS END
************************************************************/

/***********************************************************
		PROJECTWISE FUNCTIONS START
************************************************************/

	function getCombo($sql,$value=false)
	{
		$CI 		 = & get_instance();
		$query=$CI->db->query($sql);
		$str='';
		foreach($query->result() as $row)
		{
			$selected="";
			if($value)
			{
				if($value==$row->f1)
				{
					$selected=" selected='selected'";
				}
			}
			$str.="<option value=".$row->f1."".$selected.">".$row->f2."</option>";
		}
		
		return $str;
	}

	function gettableColumns($table_name = '')
	{
		$CI 		 = & get_instance();

		if(empty($table_name)) { return NULL; }
		$sqlQuery 	= 'SHOW COLUMNS FROM '.$table_name;
		$query 		= executeSqlQuery($sqlQuery,'result_array');
		if(isset($query) && $query != '')
		{
			return $query;
		}
		return false;
	}

	function executeSqlQuery($sqlQuery,$resType)
	{
		$CI 		 = & get_instance();
	    $query  = $CI->db->query($sqlQuery);
	    switch ($resType) 
	    {
	        case 'row':
	            $result = $query->row();
	            break;
	        case 'result':
	            $result = $query->result();
	            break;
		    case 'result_array':
		          $result = $query->result_array();
		          break;
		    case 'row_array':
		          $result = $query->row_array();
		          break;
		    case 'update':
		        $result = 'true';
		        break;
	        default:
	            $result = '';
	            break;
	    }
	    return $result;
	}

	function executeDataTableSqlQuery($sqlQuery,$dataType,$dataOptn='')
    {
    	$CI 		 = & get_instance();
        switch($dataType)
        { 
            // ,IF(table_data_count >table_server_limit,'true','false') table_server_status
            case 'count':
             $sqlQuery = "SELECT *,IF(table_data_count >table_server_limit,true,false) table_server_status from (SELECT (SELECT bpm_value from adm_bsn_prm where bpm_name ='".TABLE_SERVER_LIMIT."') table_server_limit,(SELECT IFNULL(COUNT(*),0) from (".$sqlQuery.") tbl ) table_data_count) result"; 
              $resType = 'row';
              break;
            case 'result':
            if(isset($dataOptn['columns']))
            {
                $search_query = array();

                for ($i=0; $i < count($dataOptn['columns']); $i++) 
                { 
                    array_push($search_query, $dataOptn['columns'][$i]['data']." like '%".$dataOptn['search']['value']."%'");
                }

                $sqlQuery = "select * from (".$sqlQuery.") tbl where ".join(" or ",$search_query); 
                if($dataOptn['length'] != '-1')
                {
                    $sqlQuery .= "LIMIT ".$dataOptn['start'].",".$dataOptn['length'];
                }

            }
            $resType = 'result';
           break;
        }
      
	        
	    $query  = $CI->db->query($sqlQuery);
	    switch ($resType) 
	    {
	        case 'row':
	          $result = $query->row();
	          break;
	        case 'result':
	          $result = $query->result();
	          break;
	        case 'result_array':
	              $result = $query->result_array();
	              break;
	        case 'row_array':
	              $result = $query->row_array();
	              break;
	        case 'update':
	            $result = 'true';
	            break;
	        default:
	          $result = '';
	          break;
	    }
	    return $result;
    }

	function table_date($date = '')
	{
		$newdate = date('d-M-Y',strtotime($date));
		return $newdate;
	}

	function display_date($date = '')
	{
		$newdate = date('d M,Y',strtotime($date));
		return $newdate;
	}

	function encrypt_key_in_array($data, $key_val_arr)
	{
	    $CI = & get_instance();
	    $key = array_keys($key_val_arr);

	    $x = 'a';

	    for($i = 0; $i < count($data); $i++)
	    {
	      for($j = 0; $j < count($key); $j++)
	      {
	        $data[$i]->{$key_val_arr[$key[$j]]} = $CI->crm_auth->encrypt_openssl($data[$i]->{$key[$j]});
	      }
	    }

	    return $data;
	}

	function url_without_admin()
	{
		$path = site_url();
		return dirname($path); 
	}

	function pretty_json_format($json) 
	{
		if (!is_string($json)) 
		{
		    if (phpversion() && phpversion() >= 5.4) 
		    {
		      return json_encode($json, JSON_PRETTY_PRINT);
		    }

		    $json = json_encode($json);
		}

		  $result      = '';
		  $pos         = 0;              
		   // indentation level
		  $strLen      = strlen($json);
		  $indentStr   = "\t";
		  $newLine     = "\n";
		  $prevChar    = '';
		  $outOfQuotes = true;

		  for ($i = 0; $i < $strLen; $i++) 
		  {
		    // Speedup: copy blocks of input which don't matter re string detection and formatting.
		    $copyLen = strcspn($json, $outOfQuotes ? " \t\r\n\",:[{}]" : "\\\"", $i);
		    if($copyLen >= 1) 
		    {
		      	$copyStr = substr($json, $i, $copyLen);
		      	// Also reset the tracker for escapes: we won't be hitting any right now
		      	// and the next round is the first time an 'escape' character can be seen again at the input.
		      	$prevChar = '';
		      	$result .= $copyStr;
		      	$i += $copyLen - 1;     
		      	 // correct for the for(;;) loop
		      	continue;
		    }
		    
		    // Grab the next character in the string
		    $char = substr($json, $i, 1);
		    
		    // Are we inside a quoted string encountering an escape sequence?
		    if (!$outOfQuotes && $prevChar === '\\') {
		      // Add the escaped character to the result string and ignore it for the string enter/exit detection:
		      $result .= $char;
		      $prevChar = '';
		      continue;
		    }
		    // Are we entering/exiting a quoted string?
		    if ($char === '"' && $prevChar !== '\\') {
		      $outOfQuotes = !$outOfQuotes;
		    }
		    // If this character is the end of an element,
		    // output a new line and indent the next line
		    else if ($outOfQuotes && ($char === '}' || $char === ']')) {
		      $result .= $newLine;
		      $pos--;
		      for ($j = 0; $j < $pos; $j++) {
		        $result .= $indentStr;
		      }
		    }
		    // eat all non-essential whitespace in the input as we do our own here and it would only mess up our process
		    else if ($outOfQuotes && false !== strpos(" \t\r\n", $char)) {
		      continue;
		    }
		    // Add the character to the result string
		    $result .= $char;
		    // always add a space after a field colon:
		    if ($outOfQuotes && $char === ':') {
		      $result .= ' ';
		    }
		    // If the last character was the beginning of an element,
		    // output a new line and indent the next line
		    else if ($outOfQuotes && ($char === ',' || $char === '{' || $char === '[')) {
		      $result .= $newLine;
		      if ($char === '{' || $char === '[') {
		        $pos++;
		      }
		      for ($j = 0; $j < $pos; $j++) {
		        $result .= $indentStr;
		      }
		    }
		    $prevChar = $char;
		  }
		  return $result;
	}

	function assign_keys_to_array($arrData)
	{
		$new_array = array();

		if(isset($arrData) && $arrData != '') 
		{
			foreach($arrData as $key=>$value)
			{
				foreach($value as $key1=>$value1)
				{
	            	$new_array[] = $key1;
				}
	        }

	        return $new_array;
		}

		return '';
	}

	function generateRandomString($length) 
	{
	    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	    $randomNo = '';
	    for ($i = 0; $i < $length; $i++) {
	      $randomNo .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomNo;
	}

	function get_header_data($array1,$array2)
	{
		$array3 = assign_keys_to_array($array2);
		
		$remove_from_array = array();
		
		foreach($array1 as $key1=>$value1)
		{
			if(!in_array($value1['Field'],$array3))
			{
				$remove_from_array[] = $key1;
			}
		}
		
	    foreach ($remove_from_array as $key => $value) 
	    {
	    	unset($array1[$value]);
	    }

	  
	    return $array1; 
	}

	function bsnprm_value($name = '')
	{
		$CI 		 = & get_instance();	

		if(empty($name)) { return NULL; }

		$CI->db->select('c1.bpm_value as bpm_value');
		$CI->db->from('adm_bsn_prm c1');
		$CI->db->where('c1.bpm_name', $name);
		$query  = $CI->db->get();
		$rows 	= $query->row_array();
		$bpm_value 	= $rows['bpm_value'];
		return $bpm_value;
	}

	function get_existing_excel_filename($entity = '')
	{
		$CI 		 = & get_instance();
			
		if(empty($entity)) { return NULL; }
		

		$CI->db->select('c1.name as name');
		$CI->db->from('adm_et_excel_files c1');
		$CI->db->where('c1.entity',$entity);
		
		$query  = $CI->db->get();
		$rows 	= $query->row_array();
		
		$gen_name 	= $rows['name'];
		return $gen_name;
	}

	function status_to_update($chk_id = '',$table_id = '',$table_name = '' ,$status_type = '')
    {
    	$CI 		 	= & get_instance();
        $status_type 	= ($status_type > 0)?$status_type:STATUS_INACTIVE;
        $arrData    	= array('status' =>$status_type,
                            	'updated_dt'=>date('Y-m-d H:i:s'),
                            	'updated_by'=>$CI->session->userdata('prs_id'));
            
        if(is_array($chk_id) && count($chk_id)>0)
        {
            $CI->db->where_in($table_id,$chk_id);
        }
        
        $CI->db->update($table_name,$arrData);
        return true;
    }

    function checkAvailability($column_name = '',$column_value = '',$table_name = '',$table_id ='',$check_id = '')
	{
		$CI 		 	= & get_instance();
		try
		{
			$sqlQuery = "select ".$column_name." from ".$table_name." where ".$column_name."='".$column_value."'";
			if(!empty($check_id))
			{
				$sqlQuery.="and ".$table_id."!='".$check_id."'";
			}
			
			$query=$CI->db->query($sqlQuery);
			$row=$query->row();
			if(!empty($row))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		catch(Exception $e)
		{
			return false;
		}
	}