<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Seo_model extends CI_Model 
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   
 
    
	public function get_products($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT *,(select name from categories where categories.id = pro.category_id) as category_name,(select name from adm_et_excel_files where adm_et_excel_files.id = (select excel_file_id from adm_et_excel_entries where adm_et_excel_entries.identifier_value = pro.sku and adm_et_excel_entries.entity  ="products")) as excel_name,(select final_inr from price_list where price_list.sku = pro.sku) as product_price,(select prs_name from adm_person where adm_person.prs_id = pro.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = pro.updated_by) updatedby,(select gen_name from adm_gen_prm where adm_gen_prm.gen_value = pro.status and adm_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name 
              FROM products pro ORDER BY id DESC ';

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);

      return $queryResult;
  }
   public function getPagesDataByID($data = array())
  {
    $sqlQuery = 'SELECT pro.id,pro.meta_title,pro.meta_keyword,pro.meta_description
                FROM pages pro
                Where pro.status = "'.STATUS_ACTIVE.'"';
    if(isset($data['categories_id']) && $data['categories_id'] != '')
    {
      $sqlQuery .= ' and pro.id = '.$data['categories_id'].' ';
    }
	
    $query = executeSqlQuery($sqlQuery,'row_array');

    if(isset($query) && $query != '')
    {
      return $query;
    }
    return false;
  }
  public function getCategoriesDataByID($data = array()){
	  $sqlQuery = 'SELECT pro.id,pro.meta_title,pro.meta_keyword,pro.meta_description
                FROM categories pro
                Where pro.status = "'.STATUS_ACTIVE.'" ';
    if(isset($data['categories_id']) && $data['categories_id'] != '')
    {
      $sqlQuery .= ' and pro.id = '.$data['categories_id'].' ';
    }
	//echo $sqlQuery;
    $query = executeSqlQuery($sqlQuery,'row_array');

    if(isset($query) && $query != '')
    {
      return $query;
    }
    return false;
	  
  }
  public function getproductsDataByID($data = array()){
	  $sqlQuery = 'SELECT pro.id,pro.meta_title,pro.meta_keyword,pro.meta_description
                FROM products pro
                Where pro.status = "'.STATUS_ACTIVE.'" ';
    if(isset($data['categories_id']) && $data['categories_id'] != '')
    {
      $sqlQuery .= ' and pro.id = '.$data['categories_id'].' ';
    }
    $query = executeSqlQuery($sqlQuery,'row_array');

    if(isset($query) && $query != '')
    {
      return $query;
    }
    return false;
	  
  }
   }
?>