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
    $sql = "SELECT gen_value  FROM `tender_gen_prm` where gen_group='".$gen_group."' ORDER BY gen_value DESC LIMIT 1";
    $res = $this->db->query($sql);
    $row = $res->row();
    $data = $row->gen_value;
    return $data;
  }

  /***********************************************************
        START DASHBOARD MODELS
  ************************************************************/

  public function get_dashboardList($resType,$dataOptn='')
  { 
    $sqlQuery 
            = 'SELECT prs.prs_name,
            prs.prs_id as id,(select COUNT(tdr_id) from tender_detail where created_by =  prs.prs_id)as total_tender
            FROM tender_person prs 
            Where prs.status = "'.STATUS_ACTIVE.'" ';

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);
      return $queryResult;
  }

  public function get_userFeed($resType)
  { 
    $department  =  $this->session->userdata('prs_dpt_id');
    $user_id    =  $this->session->userdata('prs_id');
    $date_6mnt  =  date("Y-m-d", strtotime("-6 months"));
    $sqlQuery   = 'SELECT tda.*,
            (select prs_name from tender_person where tender_person.prs_id = tda.tda_prs_id) as person_name,
              (select prs_username from tender_person where tender_person.prs_id = tda.tda_prs_id) as person_usrname,
             (select gen_name from tender_gen_prm where tender_gen_prm.gen_value = tda.tda_type and tender_gen_prm.gen_group = "'.TENDER_ACTIVITY_TYPE.'") as activity_type 
            FROM tender_activity tda 
            Where tda.tda_date > "'.$date_6mnt.'" ';
        if($department != ADMIN_DEPARTMENT)
        {
          $sqlQuery   .=  'and tda.tda_prs_id = '.$user_id;
        }

           $sqlQuery    .="  ORDER BY tda.tda_id DESC";
      $queryResult = executeSqlQuery($sqlQuery,$resType);
      return $queryResult;
  }

  public function getAllTenders($resType,$dataOptn='',$dataSrch =array())
  { 
      $department = $this->session->userdata('prs_dpt_id');
      $prs_id     = $this->session->userdata('prs_id');
      $person_id  = (isset($dataSrch['person_id']) && $dataSrch['person_id'] != '')?$dataSrch['person_id']:$prs_id;

      $sqlQuery = 'SELECT *,
            tdr.tdr_id as id,
            IFNULL((select CONCAT(cont.cont_firstname ," ", cont.cont_lastname)  from tender_contact cont where cont.cont_id = tdr.tdr_contacts)," ") AS contact_name,
            IFNULL((select cont_sal from tender_contact cont where cont.cont_id = tdr.tdr_contacts)," ") AS contact_salutation,
            IFNULL((select org_name from tender_organisation where org_id = tdr.tdr_organisationid),"Individual")as organisation,
            (select prs_name from tender_person where tender_person.prs_id = tdr.created_by) as createdby ,
            (select prs_name from tender_person where tender_person.prs_id = tdr.updated_by) as updatedby,(select gen_name from tender_gen_prm where tender_gen_prm.gen_value = tdr.tender_status and tender_gen_prm.gen_group = "'.TENDER_STATUS.'") as tender_status_name , 
            (select gen_name from tender_gen_prm where tender_gen_prm.gen_value = tdr.status and tender_gen_prm.gen_group = "'.GENERAL_STATUS.'") as status_name
                  FROM tender_detail tdr 
                  Where status = "'.STATUS_ACTIVE.'" ';
            if(!empty($person_id) && $person_id !='' && $department != ADMIN_DEPARTMENT)
            {
              $sqlQuery  .= 'and created_by = '.$person_id.' ';
            }
           
      $sqlQuery      .="  ORDER BY tdr.tdr_id DESC";
      $queryResult      = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);
      return $queryResult;
   }

  /***********************************************************
        START USER MODELS
  ************************************************************/

  public function getAllUsers($resType,$dataOptn='')
  {
      //echo $resType;exit;
      $sqlQuery = 'SELECT adm.*,adm.prs_id as id,(select adm_department.dpt_name from adm_department where adm_department.DPT_id=adm.prs_dpt_id)dpt_name,(select tender_person.prs_name from tender_person where tender_person.prs_id = adm.created_by) createdby ,(select tender_person.prs_name from tender_person where tender_person.prs_id = adm.updated_by) updatedby,(select tender_gen_prm.gen_name from tender_gen_prm where tender_gen_prm.gen_value = adm.status and tender_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name
              FROM tender_person adm';
//echo $sqlQuery;exit;
      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);
      
      return $queryResult;
  }

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
                $sqlQuery = "SELECT * FROM `tender_person` WHERE  prs_mob='".$usr_username."' and prs_password='".$encrypt."' and status='".STATUS_ACTIVE."'  ";
          break;
        case filter_var($usr_username, FILTER_VALIDATE_EMAIL):
                $sqlQuery ="SELECT * FROM `tender_person` WHERE  prs_email='".$usr_username."' and prs_password='".$encrypt."' and status='".STATUS_ACTIVE."'  ";
          break;
        default:
                $sqlQuery ="SELECT * FROM `tender_person` WHERE  prs_username='".$usr_username."' and prs_password='".$encrypt."' and status='".STATUS_ACTIVE."'  ";
          break;
      }
      $user_data = executeSqlQuery($sqlQuery,'row');
    }
      return $user_data;
  }

  public function getUserDetails($data = array())
  {
    $sqlQuery = 'SELECT adm.*,adm.prs_id as id,(select adm_department.dpt_name from adm_department where adm_department.DPT_id=adm.prs_dpt_id)dpt_name,(select tender_person.prs_name from tender_person where tender_person.prs_id = adm.created_by) createdby ,(select tender_person.prs_name from tender_person where tender_person.prs_id = adm.updated_by) updatedby,(select tender_gen_prm.gen_name from tender_gen_prm where tender_gen_prm.gen_value = adm.prs_currency and tender_gen_prm.gen_group = "'.TENDER_PRICE_TYPE.'") currency  ,(select tender_gen_prm.gen_name from tender_gen_prm where tender_gen_prm.gen_value = adm.status and tender_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name
              FROM tender_person adm
              Where adm.status != "'.STATUS_BLOCKED.'" ';

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

  public function validateUserData($column_name,$value,$id='')
  {
    $sqlQuery    = "select prs_id from tender_person where  ".$column_name."='".$value."'";
    if($id)
    {
      $sqlQuery .= " and prs_id!=".$id."" ;
    }

    $query       = $this->db->query($sqlQuery);
    $row         = $query->row();

    if(!empty($row))
    {
      return false;
    }
    else
    {
      return true;
    }
  }

  public function get_userFolloupExport($user_id)
  {
    $SqlQuery = 'SELECT 
        tdr.tdr_id as id,tdr.tdr_name  as name,tdr.tdr_refid as invoice_no,tdr.tdr_grandtotal as total_amount,
          IFNULL((select CONCAT(cont.cont_firstname ," ", cont.cont_lastname)  from tender_contact cont where cont.cont_id = tdr.tdr_contacts)," ") AS contact_name,
          IFNULL((select org_name from tender_organisation where org_id = tdr.tdr_organisationid),"Individual")as organisation,
          IFNULL((select org_primaryemail from tender_organisation where org_id = tdr.tdr_organisationid)," ")as organisation_email,
          IFNULL((select tcv_country from tender_country_vol where tcv_id = (select org_billingcountry from tender_organisation where org_id = tdr.tdr_organisationid))," ") as country,
          (select gen_name from tender_gen_prm where tender_gen_prm.gen_value = tdr.status and tender_gen_prm.gen_group = "'.GENERAL_STATUS.'") as status_name,
          (select GROUP_CONCAT(tdp_sku)  from tender_product where tdp_tdr_refid = tdr.tdr_refid) as products,
          (select GROUP_CONCAT(DISTINCT (tde_to)) from tender_emaillogs where tde_tdr_refid= tdr.tdr_refid) as emailto
                FROM tender_detail tdr
                Where tdr.status = "'.STATUS_ACTIVE.'" and tdr.created_by = "'.$user_id.'" ';
     
        $SqlQuery.="  ORDER BY tdr.tdr_id DESC";

      $queryResult     = executeSqlQuery($SqlQuery,'result_array');
     
      return $queryResult;
  }

  /***********************************************************
        START ORGANISATION MODELS
  ************************************************************/

  public function getAllOrganisations($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT *,IFNULL((select tcv_country from tender_country_vol where tender_country_vol.tcv_id = org_billingcountry),"") as billingcountry,org.org_id as id,(select prs_name from tender_person where tender_person.prs_id = org.created_by) as createdby ,(select prs_name from tender_person where tender_person.prs_id = org.updated_by) as updatedby,(select gen_name from tender_gen_prm where tender_gen_prm.gen_value = org.status and tender_gen_prm.gen_group = "'.GENERAL_STATUS.'") as status_name 
              FROM tender_organisation org ';

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);

      return $queryResult;
  }

  public function getorganisationsDataByID($data = array())
  { 
    $sqlQuery = "SELECT *,(select gen_name from tender_gen_prm where tender_gen_prm.gen_value = org_industry and tender_gen_prm.gen_group = '".TENDER_INDUSTRY."') as industry,IFNULL((select tcv_country from tender_country_vol where tender_country_vol.tcv_id = org_billingcountry),'') as billingcountry,IFNULL((select tcv_country from tender_country_vol where tender_country_vol.tcv_id = org_shippingcountry),'') as shippingcountry,(select prs_name from tender_person where tender_person.prs_id = org.created_by) as createdby ,(select prs_name from tender_person where tender_person.prs_id = org.updated_by) as updatedby
                FROM tender_organisation org
                Where status = '".STATUS_ACTIVE."' ";
    if(isset($data['organisations_id']) && $data['organisations_id'] != '')
    {
      $sqlQuery .= ' and org.org_id = '.$data['organisations_id'].' ';
    }
    $query = executeSqlQuery($sqlQuery,'row_array');
    if(isset($query) && $query != '')
    {
      return $query;
    }
    return false;
  }

  public function validateOrganistaionData($column_name,$value,$id='')
  {
    $sqlQuery    = "select org_id from tender_organisation where  ".$column_name."='".$value."'";
    if($id)
    {
      $sqlQuery .= " and org_id!=".$id."" ;
    }
    $query       = $this->db->query($sqlQuery);
    $row         = $query->row();
    if(!empty($row))
    {
      return false;
    }
    else
    {
      return true;
    }
  }


  /***********************************************************
        START CONTACT MODELS
  ************************************************************/
  public function getAllContacts($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT *,CONCAT(cont.cont_firstname ," ", cont.cont_lastname) AS cont_name,cont.cont_id as id,(select org_name from tender_organisation where org_id = cont.cont_orgid)as organisation,(select prs_name from tender_person where tender_person.prs_id = cont.created_by) as createdby ,(select prs_name from tender_person where tender_person.prs_id = cont.updated_by) as updatedby,(select gen_name from tender_gen_prm where tender_gen_prm.gen_value = cont.status and tender_gen_prm.gen_group = "'.GENERAL_STATUS.'") as status_name 
              FROM tender_contact cont ';

      if(isset($dataOptn['organisations_id']) && $dataOptn['organisations_id'] != '')
      {
        $sqlQuery .= ' where cont.cont_orgid = '.$dataOptn['organisations_id'].' ';
      }  

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);

      return $queryResult;
  }

  public function getcontactsDataByID($data = array())
  {
    $sqlQuery = "SELECT *,CONCAT(cont.cont_firstname ,' ', cont.cont_lastname) AS cont_name,(select org_name from tender_organisation where org_id = cont.cont_orgid) as organisation,(select gen_name from tender_gen_prm where tender_gen_prm.gen_value = cont.cont_leadsource and tender_gen_prm.gen_group = '".TENDER_LEAD_SOURCE."' ) as lead_source,(select gen_name from tender_gen_prm where tender_gen_prm.gen_value = cont.cont_sal and tender_gen_prm.gen_group = '".TENDER_SALUTION."' ) as salutation,(select prs_name from tender_person where tender_person.prs_id = cont.created_by) as createdby ,(select prs_name from tender_person where tender_person.prs_id = cont.updated_by) as updatedby
                FROM tender_contact cont
                Where cont.status = '".STATUS_ACTIVE."' ";
      if(isset($data['contacts_id']) && $data['contacts_id'] != '')
      {
        $sqlQuery .= ' and cont.cont_id = '.$data['contacts_id'].' ';
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
      $sqlQuery = 'SELECT *,(select prs_name from tender_person where tender_person.prs_id = dty.created_by) createdby ,(select prs_name from tender_person where tender_person.prs_id = dty.updated_by) updatedby,(select gen_name from tender_gen_prm where tender_gen_prm.gen_value = dty.status and tender_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name 
              FROM adm_et_data_types dty ';

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);
      return $queryResult;
  }
     
  public function getdatatypesDataByID($data = array())
  {
    $sqlQuery = 'SELECT *,(select prs_name from tender_person where tender_person.prs_id = dty.created_by) createdby ,(select prs_name from tender_person where tender_person.prs_id = dty.updated_by) updatedby
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
public function validateContactsData($column_name,$value,$id='')
  {
    $sqlQuery    = "select cont_id from tender_contact where  ".$column_name."='".$value."'";
    if($id)
    {
      $sqlQuery .= " and cont_id!=".$id."" ;
    }
    $query       = $this->db->query($sqlQuery);
    $row         = $query->row();
    if(!empty($row))
    {
      return false;
    }
    else
    {
      return true;
    }
  } 
  /***********************************************************
        START ENTITIES MODELS
  ************************************************************/

  public function get_entities($resType,$dataOptn='')
  {
      $sqlQuery = 'SELECT *,(select prs_name from tender_person where tender_person.prs_id = ent.created_by) createdby ,(select prs_name from tender_person where tender_person.prs_id = ent.updated_by) updatedby,(select gen_name from tender_gen_prm where tender_gen_prm.gen_value = ent.status and tender_gen_prm.gen_group = "'.STATUS_NAME.'") as status_name 
              FROM adm_et_entities ent ';

      $queryResult     = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);
      return $queryResult;
  }
    
  public function getentitiesDataByID($data = array())
  {
    $sqlQuery = 'SELECT *,(select prs_name from tender_person where tender_person.prs_id = ent.created_by) createdby ,(select prs_name from tender_person where tender_person.prs_id = ent.updated_by) updatedby
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
        START PARAMETER MODELS
  ************************************************************/
  public function getParameterList()
  {
    $sql   = "SELECT gen_id,gen_name,gen_value,gen_group,gen_order,status FROM `tender_gen_prm` WHERE gen_group  ='".$this->input->post('gen_group')."' and status='".STATUS_ACTIVE."' ";
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
      $sql ="select distinct tender_menu_master.mnu_name,mnu_icon,tender_menu_master.mnu_id,tender_menu_master.mnu_link from tender_menu_master left join  tender_menu_transaction on tender_menu_master.mnu_id=tender_menu_transaction.mtr_mnu_id  where tender_menu_transaction.mtr_dpt_id ='".$dpt_id."' and tender_menu_master.status='".STATUS_ACTIVE."' and tender_menu_transaction.status='".STATUS_ACTIVE."'  order by tender_menu_master.mnu_order";
      
  
      $result=$this->db->query($sql);
      return $result;
  }

  public function getsubmenu($mnu_id)
  {
      $prs_id = $this->session->userdata('prs_id');
      $sql = "select * from tender_sub_menu_master where status = '".STATUS_ACTIVE."' and sbm_group='submenu' and sbm_mnu_id=".$mnu_id." and sbm_parent_id=".$mnu_id." and sbm_id in (select fma_sbm_id from tender_form_access where fma_status='Y' and fma_access='1'  and fma_usr_id='".$prs_id."' and fma_mnu_id='".$mnu_id."') order by sbm_order";
      $result=$this->db->query($sql);
      return $result;
  }

  public function getpages($pageid,$moduleid)
  {
      $prs_id = $this->session->userdata('prs_id');
      $sql = "select sbm_mnu_id,sbm_pagelink as form_name,sbm_name as form_title,SUBSTRING_INDEX(sbm_name,'(',-1) as pgname from tender_sub_menu_master where status = '".STATUS_ACTIVE."' and sbm_group='submenu' and sbm_mnu_id='".$moduleid."' and sbm_id in (select fma_sbm_id from tender_form_access where fma_status='Y' and fma_access='1' and fma_usr_id='".$prs_id."' and sbm_parent_id='".$pageid."' and fma_mnu_id='".$moduleid."') order by SUBSTRING_INDEX(sbm_name,'(',-1)";
      $result=$this->db->query($sql);
      return $result;
  }
  public function saveGoogleSecretKey($email,$secret_key)
  {
     $updatedata = array(
          'google_secret_key'=> $secret_key,
      );
      $this->db->where('prs_email', $email);
      $this->db->update('tender_person', $updatedata);
      if ($this->db->affected_rows() > 0){
          return "update";
      }else{
          return "error";
      }
  }
  public function checkGoogleSecretKey($email)
  {
      $where = array('prs_email' => $email);
      $this->db->select('*')->from('tender_person')->where($where)->where('google_secret_key !=','');
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
      $this->db->select('google_secret_key')->from('tender_person')->where($where);
      $result = $this->db->get()->row_array();
      return $result['google_secret_key'];
   }
  public function getUserAuthData($email)
  {
      $where = array('prs_email' => $email,'status'=>'1');
       $this->db->select('*')->from('tender_person')->where($where);
       $user_data =  $this->db->get()->row();
      return $user_data;
  }

}
?>