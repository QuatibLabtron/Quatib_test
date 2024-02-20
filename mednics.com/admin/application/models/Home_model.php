<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model 
{

	function __construct()
  {
      parent::__construct();
  }
	
  /***********************************************************
        START GENERAL MODELS
  ************************************************************/

  function get_value_no($gen_group)
  {
    $lastNo = $this->getLastNo($gen_group);
    $n = $lastNo + 1;
    return $n;
  }

	function getLastNo($gen_group)
  {
    $sql = "SELECT gen_value  FROM `adm_gen_prm` where gen_group='".$gen_group."' ORDER BY gen_value DESC LIMIT 1";
  
    $res = $this->db->query($sql);
    $row = $res->row();
    $data = $row->gen_value;
    return $data;
  }


/***********************************************************
        START USER MODELS
************************************************************/

  public function getUserData($value='')
  {
    $usr_username = $this->input->post('usr_username');
    $pwd      = $this->input->post('usr_password');

    if($value=='0')
        $encrypt=openssl_encrypt($pwd,CIPHER,KEY);
    elseif($value=='1')
        $encrypt=$pwd; 

    log_message('error','>>email getUserData'.$usr_username);
    log_message('error','>>password getUserData'.$encrypt );

    if(isset($usr_username) and !empty($usr_username))
    {
      switch ($usr_username) {
        case is_numeric($usr_username):
                $sqlQuery = "SELECT * FROM `adm_person` WHERE  prs_mob='".$usr_username."' and prs_password='".$encrypt."' and status='".STATUS_ACTIVE."'  ";
          break;
        case filter_var($usr_username, FILTER_VALIDATE_EMAIL):
                $sqlQuery ="SELECT * FROM `adm_person` WHERE  prs_email='".$usr_username."' and prs_password='".$encrypt."' and status='".STATUS_ACTIVE."'  ";
          break;
        default:
                $sqlQuery ="SELECT * FROM `adm_person` WHERE  prs_username='".$usr_username."' and prs_password='".$encrypt."' and status='".STATUS_ACTIVE."'  ";
          break;
      }
      $user_data = executeSqlQuery($sqlQuery,'row');
    }
      return $user_data;
  }

  public function getAllUsers($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT adm.*,adm.prs_id as id,(select adm_department.dpt_name from adm_department where adm_department.DPT_id=adm.prs_dpt_id)dpt_name,(select adm_person.prs_name from adm_person where adm_person.prs_id = adm.created_by) createdby ,(select adm_person.prs_name from adm_person where adm_person.prs_id = adm.updated_by) updatedby,(select adm_gen_prm.gen_name from adm_gen_prm where adm_gen_prm.gen_value = adm.status and adm_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name
              FROM adm_person adm';

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);

      return $queryResult;
  }

  public function getUserDetails($data = array())
  {
    $sqlQuery = 'SELECT adm.*,adm.prs_id as id,(select adm_department.dpt_name from adm_department where adm_department.DPT_id=adm.prs_dpt_id)dpt_name,(select adm_person.prs_name from adm_person where adm_person.prs_id = adm.created_by) createdby ,(select adm_person.prs_name from adm_person where adm_person.prs_id = adm.updated_by) updatedby,(select adm_gen_prm.gen_name from adm_gen_prm where adm_gen_prm.gen_value = adm.status and adm_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name
              FROM adm_person adm
              Where adm.status = "'.STATUS_ACTIVE.'" ';

    if(isset($data['person_id']) && $data['person_id'] != '')
    {
      $sqlQuery .= ' and adm.prs_id = '.$data['person_id'].' ';
    }
    if(isset($data['username']) && $data['username'] != '')
    {
      $sqlQuery .= ' and adm.prs_username = "'.$data['username'].'" ';
    }
      

    $query = executeSqlQuery($sqlQuery,'row_array');

    if(isset($query) && $query != '')
    {
      return $query;
    }
    return false;
  }

/***********************************************************
        START BANNER MODELS
************************************************************/

  public function get_banners($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT *,(select prs_name from adm_person where adm_person.prs_id = ban.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = ban.updated_by) updatedby,(select gen_name from adm_gen_prm where adm_gen_prm.gen_value = ban.status and adm_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name 
              FROM banners ban ';

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);

      return $queryResult;
  }

  public function getbannersDataByID($data = array())
  {
     $sqlQuery = 'SELECT *,(select prs_name from adm_person where adm_person.prs_id = ban.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = ban.updated_by) updatedby
                FROM banners ban
                Where status = "'.STATUS_ACTIVE.'" ';

      if(isset($data['banners_id']) && $data['banners_id'] != '')
      {
        $sqlQuery .= ' and ban.id = '.$data['banners_id'].' ';
      }

      $query = executeSqlQuery($sqlQuery,'row_array');
      
      if(isset($query) && $query != '')
      {
        return $query;
      }
      return false;
  }

/***********************************************************
        START CATEGORIES MODELS
************************************************************/

  public function get_categories($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT *,(select id from sections where sections.page_url = cat.section) as section_id,(select section from sections where sections.page_url = cat.section) as section_name,(select name from categories where categories.id = cat.parent_id) as category_name,(select id from categories where categories.id = cat.parent_id) as category_id,(select prs_name from adm_person where adm_person.prs_id = cat.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = cat.updated_by) updatedby,(select gen_name from adm_gen_prm where adm_gen_prm.gen_value = cat.status and adm_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name 
              FROM categories cat ';
      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);
      return $queryResult;
  }

  public function getcategoriesDataByID($data = array())
  {
    $sqlQuery = 'SELECT *,(select section from sections where sections.page_url = cat.section) as section_name,(select id from sections where sections.page_url = cat.section) as section_id,(select name from categories where categories.id = cat.parent_id) as category_name,(select id from categories where categories.id = cat.parent_id) as category_id,(select prs_name from adm_person where adm_person.prs_id = cat.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = cat.updated_by) updatedby
                FROM categories cat
                Where status = "'.STATUS_ACTIVE.'" ';
    if(isset($data['categories_id']) && $data['categories_id'] != '')
    {
      $sqlQuery .= ' and cat.id = '.$data['categories_id'].' ';
    }
    $query = executeSqlQuery($sqlQuery,'row_array');

    if(isset($query) && $query != '')
    {
      return $query;
    }
    return false;
  }

/***********************************************************
      START DATATYPES MODELS
************************************************************/

  public function get_datatypes($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT *,(select prs_name from adm_person where adm_person.prs_id = dty.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = dty.updated_by) updatedby,(select gen_name from adm_gen_prm where adm_gen_prm.gen_value = dty.status and adm_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name 
              FROM adm_et_data_types dty ';

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);
      return $queryResult;
  }
     
  public function getdatatypesDataByID($data = array())
  {
    $sqlQuery = 'SELECT *,(select prs_name from adm_person where adm_person.prs_id = dty.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = dty.updated_by) updatedby
                FROM adm_et_data_types dty
                Where status <> "'.STATUS_ACTIVE.'" ';
        if(isset($data['datatypes_id']) && $data['datatypes_id'] != '')
    {
      $sqlQuery .= ' and dty.id = '.$data['datatypes_id'].' ';
    }
    $query = executeSqlQuery($sqlQuery,'row_array');

    if(isset($query) && $query != '')
    {
      return $query;
    }
    return false;
  }

/***********************************************************
      START ENTITIES MODELS
************************************************************/

  public function get_entities($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT *,(select prs_name from adm_person where adm_person.prs_id = ent.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = ent.updated_by) updatedby,(select gen_name from adm_gen_prm where adm_gen_prm.gen_value = ent.status and adm_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name 
              FROM adm_et_entities ent ';

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);
      return $queryResult;
  }
    
  public function getentitiesDataByID($data = array())
  {
    $sqlQuery = 'SELECT *,(select prs_name from adm_person where adm_person.prs_id = ent.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = ent.updated_by) updatedby
                FROM adm_et_entities ent
                Where status = "'.STATUS_ACTIVE.'" ';
    if(isset($data['entities_id']) && $data['entities_id'] != '')
    {
      $sqlQuery .= ' and ent.id = '.$data['entities_id'].' ';
    }
    $query = executeSqlQuery($sqlQuery,'row_array');
    if(isset($query) && $query != '')
    {
      return $query;
    }
    return false;
  }

/***********************************************************
      START BANNER MODELS
************************************************************/

  public function get_pages($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT *,(select prs_name from adm_person where adm_person.prs_id = pag.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = pag.updated_by) updatedby,(select gen_name from adm_gen_prm where adm_gen_prm.gen_value = pag.status and adm_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name 
              FROM pages pag ';

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);
      return $queryResult;
  }
  
  public function getpagesDataByID($data = array())
  {
    $sqlQuery = 'SELECT *,(select prs_name from adm_person where adm_person.prs_id = pag.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = pag.updated_by) updatedby
        FROM pages pag Where status = "'.STATUS_ACTIVE.'" ';

    if(isset($data['pages_id']) && $data['pages_id'] != '')
    {
      $sqlQuery .= ' and pag.id = '.$data['pages_id'].' ';
    }

    $query = executeSqlQuery($sqlQuery,'row_array');
    
    if(isset($query) && $query != '')
    {
      return $query;
    }
    return false;
  }

/***********************************************************
      START PRODUCT MODELS
************************************************************/
  public function add_product_field($field_name,$field_tab_name)
  {
    $this->load->dbforge();
    $fields = array(
        $field_name => array('type' => 'TEXT') );
    $this->dbforge->add_column('products', $fields);

     $arrData = array('prt_name'  => $field_tab_name,'prt_tab_name' => $field_name);
    $this->db->insert('product_tabs',$arrData);
    return true;
  }
    

  public function get_products($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT *,(select name from categories where categories.id = pro.category_id) as category_name,(select name from adm_et_excel_files where adm_et_excel_files.id = (select excel_file_id from adm_et_excel_entries where adm_et_excel_entries.identifier_value = pro.sku and adm_et_excel_entries.entity  ="products")) as excel_name,(select final_inr from price_list where price_list.sku = pro.sku) as product_price,(select prs_name from adm_person where adm_person.prs_id = pro.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = pro.updated_by) updatedby,(select gen_name from adm_gen_prm where adm_gen_prm.gen_value = pro.status and adm_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name 
              FROM products pro ORDER BY id DESC ';

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);

      return $queryResult;
  }
    
  public function getproductsDataByID($data = array())
  {
    $sqlQuery = 'SELECT *,(select name from categories where categories.id = pro.category_id) as category_name,(select final_inr from price_list where price_list.sku = pro.sku) as product_price,(select prs_name from adm_person where adm_person.prs_id = pro.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = pro.updated_by) updatedby
                FROM products pro
                Where status = "'.STATUS_ACTIVE.'" ';
         if(isset($data['products_id']) && $data['products_id'] != '')
    {
      $sqlQuery .= ' and pro.id = '.$data['products_id'].' ';
    }

    $query = executeSqlQuery($sqlQuery,'row_array');
    
    if(isset($query) && $query != '')
    {
      return $query;
    }
    return false;
  }


/***********************************************************
      START SECTION MODELS
************************************************************/
  public function get_sections($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT *,(select prs_name from adm_person where adm_person.prs_id = sec.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = sec.updated_by) updatedby,(select gen_name from adm_gen_prm where adm_gen_prm.gen_value = sec.status and adm_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name 
              FROM sections sec
              ';
      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);

      return $queryResult;
  }

  public function getsectionDataByID($data = array())
  {
    $sqlQuery = 'SELECT *,(select prs_name from adm_person where adm_person.prs_id = sec.created_by) createdby ,(select prs_name from adm_person where adm_person.prs_id = sec.updated_by) updatedby
                FROM sections sec
                Where status = "'.STATUS_ACTIVE.'" ';
    if(isset($data['section_id']) && $data['section_id'] != '')
    {
      $sqlQuery .= ' and sec.id = '.$data['section_id'].' ';
    }

    $query = executeSqlQuery($sqlQuery,'row_array');
    
    if(isset($query) && $query != '')
    {
      return $query;
    }
    return false;
  }

/***********************************************************
      START PARAMETER MODELS
************************************************************/
  public function getParameterList()
  {
    $sql   = "SELECT gen_id,gen_name,gen_value,gen_group,gen_order,status FROM `adm_gen_prm` WHERE gen_group  ='".$this->input->post('gen_group')."' and status='".STATUS_ACTIVE."' ";
    $query  = $this->db->query($sql);
    $result = $query->result();
    return $result;
  }

/***********************************************************
      START ACCESS MODELS
************************************************************/
  public function getMenu()
  {
      $dpt_id = $this->session->userdata('prs_dpt_id');
      $sql ="select distinct adm_menu_master.mnu_name,mnu_icon,adm_menu_master.mnu_id,adm_menu_master.mnu_link from adm_menu_master left join  adm_menu_transaction on adm_menu_master.mnu_id=adm_menu_transaction.mtr_mnu_id  where adm_menu_transaction.mtr_dpt_id ='".$dpt_id."' and adm_menu_master.status='".STATUS_ACTIVE."' and adm_menu_transaction.status='".STATUS_ACTIVE."'  order by adm_menu_master.mnu_order";
      
  
      $result=$this->db->query($sql);
      return $result;
  }

  public function getsubmenu($mnu_id)
  {
      $prs_id = $this->session->userdata('prs_id');
      $sql = "select * from adm_sub_menu_master where status = '".STATUS_ACTIVE."' and sbm_group='submenu' and sbm_mnu_id=".$mnu_id." and sbm_parent_id=".$mnu_id." and sbm_id in (select fma_sbm_id from adm_form_access where fma_status='Y' and fma_access='1'  and fma_usr_id='".$prs_id."' and fma_mnu_id='".$mnu_id."') order by sbm_order";
      $result=$this->db->query($sql);
      return $result;
  }

  public function getpages($pageid,$moduleid)
  {
      $prs_id = $this->session->userdata('prs_id');
      $sql = "select sbm_mnu_id,sbm_pagelink as form_name,sbm_name as form_title,SUBSTRING_INDEX(sbm_name,'(',-1) as pgname from adm_sub_menu_master where status = '".STATUS_ACTIVE."' and sbm_group='submenu' and sbm_mnu_id='".$moduleid."' and sbm_id in (select fma_sbm_id from adm_form_access where fma_status='Y' and fma_access='1' and fma_usr_id='".$prs_id."' and sbm_parent_id='".$pageid."' and fma_mnu_id='".$moduleid."') order by SUBSTRING_INDEX(sbm_name,'(',-1)";
      $result=$this->db->query($sql);
      return $result;
  }
  public function saveGoogleSecretKey($email,$secret_key)
    {
       $updatedata = array(
            'google_secret_key'=> $secret_key,
        );
        $this->db->where('prs_email', $email);
        $this->db->update('adm_person', $updatedata);
        if ($this->db->affected_rows() > 0){
            return "update";
        }else{
            return "error";
        }
    }
    public function checkGoogleSecretKey($email)
    {
        $where = array('prs_email' => $email);
        $this->db->select('*')->from('adm_person')->where($where)->where('google_secret_key !=','');
        $query = $this->db->get()->row_array();
        if(isset($query)){
            $query_result_count = count($query);
        }
        else {
            $query_result_count = 0;
        }
        if($query_result_count > 1){
            return 1;
        }else{
            return 0;
        } 
    }
    public function getGoogleSecretKey($email)
    {
        $where = array('prs_email' => $email);
        $this->db->select('google_secret_key')->from('adm_person')->where($where);
        $result = $this->db->get()->row_array();
        return $result['google_secret_key'];
     }
    public function getUserAuthData($email)
    {
        $where = array('prs_email' => $email,'status'=>'1');
         $this->db->select('*')->from('adm_person')->where($where);
         $user_data =  $this->db->get()->row();
        return $user_data;
    }

}
?>