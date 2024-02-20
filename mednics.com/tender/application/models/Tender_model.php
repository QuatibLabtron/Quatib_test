<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tender_model extends CI_Model 
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
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
         //echo  $sqlQuery;exit;
	    $queryResult      = executeDataTableSqlQuery($sqlQuery,$resType,$dataOptn);
	    return $queryResult;
	 }

  	public function gettendersDataByID($data = array())
  	{
	    $sqlQuery 
	      = 'SELECT *,
	      tdr.tdr_id as id,FORMAT(tdr.tdr_grandtotal,2) as tdr_grandtotal,FORMAT(tdr.tdr_item_total,2) as tdr_item_total,FORMAT(tdr.tdr_pretax_total,2) as tdr_pretax_total,
	      IFNULL((select CONCAT(cont.cont_firstname ," ", cont.cont_lastname)  from tender_contact cont where cont.cont_id = tdr.tdr_contacts)," ") AS contact_name,
	      IFNULL((select cont_sal from tender_contact cont where cont.cont_id = tdr.tdr_contacts)," ") AS contact_salutation,
	      IFNULL((select cont.cont_primaryemail from tender_contact cont where cont.cont_id = tdr.tdr_contacts)," ") AS contact_email,
	      IFNULL((select org_name from tender_organisation where org_id = tdr.tdr_organisationid),"Individual")as organisation,
	      IFNULL((select org_primaryemail from tender_organisation where org_id = tdr.tdr_organisationid)," ")as organisation_email,
	      IFNULL((select tcv_country from tender_country_vol where tcv_id = (select org_billingcountry from tender_organisation where org_id = tdr.tdr_organisationid))," ") as country,
	      IFNULL((select tcv_voltage from tender_country_vol where tcv_id = (select org_billingcountry from tender_organisation where org_id = tdr.tdr_organisationid))," ")as voltage,
	      IFNULL((select tcv_frquency from tender_country_vol where tcv_id = (select org_billingcountry from tender_organisation where org_id = tdr.tdr_organisationid))," ")as frequency,
	      IFNULL((select tcv_plug_type from tender_country_vol where tcv_id = (select org_billingcountry from tender_organisation where org_id = tdr.tdr_organisationid))," ")as plug_type,

	      (select prs_name from tender_person where tender_person.prs_id = tdr.created_by) as createdby,
	      (select prs_name from tender_person where tender_person.prs_id = tdr.updated_by) as updatedby,
	      (select gen_name from tender_gen_prm where tender_gen_prm.gen_value = tdr.tender_status and tender_gen_prm.gen_group = "'.TENDER_STATUS.'" ) as tender_status_name ,
	      (select gen_name from tender_gen_prm where tender_gen_prm.gen_value = tdr.status and tender_gen_prm.gen_group = "'.GENERAL_STATUS.'") as status_name
	            FROM tender_detail tdr
	            Where status = "'.STATUS_ACTIVE.'" ';

      	if(isset($data['tenders_id']) && $data['tenders_id'] != '')
    	{
      		$sqlQuery .= ' and tdr.tdr_id = '.$data['tenders_id'].' ';
    	}
    	$query = executeSqlQuery($sqlQuery,'row_array');
    
	    if(isset($query) && $query != '')
	    {
	      return $query;
	    }
    	return false;
  	}

  	public function gettendersProductDataByID($data)
  	{
    	$sqlQuery = 'SELECT tdr.*  FROM tender_product tdr Where tdr.tdp_tdr_refid = (select tdr_refid from tender_detail where tdr_id = "'.$data['tenders_id'].'")  ';

    	$query = executeSqlQuery($sqlQuery,'result_array');
    
    	if(isset($query) && $query != '')
    	{
      		return $query;
    	}
   	 	return false;
  	}

  	public function delete_tender_product($arrData = array(),$tdr_refid = '')
  	{
	    $this->db->where_not_in('tdp_id',$arrData);
	    $this->db->where('tdp_tdr_refid',$tdr_refid);
	    $this->db->delete('tender_product');
	    return $tdr_refid;
  	}



  	public function gettendersProductEditDataByID($data)
  	{
    	$sqlQuery = 'SELECT `tdp_id`, `tdp_tdr_refid`, `tdp_prd_id`, `tdp_sku`, `tdp_name`, `tdp_quantity`, `tdp_price`, `tdp_spec_show`, `tdp_qty_disc`, `tdp_indv_disc_direct`, `tdp_indv_disc_percent`, `tdp_discounttype`, `tdp_discount_total_amt`, `tdp_item_total`
                FROM tender_product
                Where tdp_tdr_refid = (select tdr_refid from tender_detail where tdr_id = "'.$data['tenders_id'].'")  ';

    	$query = executeSqlQuery($sqlQuery,'result_array');
  
    	if(isset($query) && $query != '')
    	{
      		return $query;
    	}
    	return false;
  	}

    public function validateTenderData($column_name,$value,$id='')
	{
	    $sqlQuery    = "select tdr_id from tender_detail where  ".$column_name."='".$value."'";
	    if($id)
	    {
	      $sqlQuery .= " and tdr_id!=".$id."" ;
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

	


	
	

	public function getOrganisationDropdown($search)
    {
       $OrganisationSqlQuery = "SELECT org_id as id, org_name as text from tender_organisation where status IN (".STATUS_ACTIVE.") ";
        if($search !='')
        {
          $OrganisationSqlQuery.=" and org_name LIKE '%".$search."%' ";
        }
          $OrganisationSqlQuery.="  ORDER BY org_id ASC";
        // ***** It is used to reset value of select2 ****** //
        $resetResult     = array('id'=>'0','text'=>'Please Select Organisation');
        $queryResult     = executeSqlQuery($OrganisationSqlQuery,'result');
        array_unshift($queryResult,$resetResult);
        // ***** It is used to reset value of select2 ****** //
        return $queryResult;
    }	

    public function getContactDropdown($search,$org_id)
    {
       $ContactSqlQuery = "SELECT cont_id as id, CONCAT(cont_firstname ,' ', cont_lastname) as text from tender_contact where status IN (".STATUS_ACTIVE.") ";
        if($search !='')
        {
          $ContactSqlQuery.=" and cont_firstname LIKE '%".$search."%' OR cont_lastname LIKE '%".$search."%' ";
        }
         if($org_id !='')
        {
          $ContactSqlQuery.=" and cont_orgid = '".$org_id."' ";
        }
          $ContactSqlQuery.="  ORDER BY cont_id ASC";
        // ***** It is used to reset value of select2 ****** //
        $resetResult     = array('id'=>'0','text'=>'Please Select Contact');
        $queryResult     = executeSqlQuery($ContactSqlQuery,'result');
        array_unshift($queryResult,$resetResult);
        // ***** It is used to reset value of select2 ****** //
        return $queryResult;
    }	

    public function getProductDropdown($search)
    {
       $ProductSqlQuery = "SELECT id as id, name as text from products where status = '".STATUS_ACTIVE."' ";
        if($search !='')
        {
          $ProductSqlQuery.=" and name LIKE '%".$search."%' OR sku '%".$search."%' ";
        }
          $ProductSqlQuery.="  ORDER BY id ASC";
        // ***** It is used to reset value of select2 ****** //
        $resetResult     = array('id'=>'0','text'=>'Please Select Product');
        $queryResult     = executeSqlQuery($ProductSqlQuery,'result');
        array_unshift($queryResult,$resetResult);
        // ***** It is used to reset value of select2 ****** //
        return $queryResult;
    }	

    public function get_voltage_details($org_id)
    {
    	try
		{
			$sql="select * from tender_country_vol where tcv_id = (select org_billingcountry from tender_organisation where org_id = '".$org_id."') ";
			
			
			$query=$this->db->query($sql);
			$row=$query->row_array();
			if(!empty($row))
			{
				return $row;
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

    public function get_product_details($prd_id)
    {
    	try
		{
			$sql="SELECT pro.name,pro.sku,pro.specifications,(select final_inr from price_list where sku = pro.sku) as price from products as pro where pro.status = '".STATUS_ACTIVE."' and pro.id =  '".$prd_id."' ";
			
			
			$query=$this->db->query($sql);
			$row=$query->row_array();
			if(!empty($row))
			{
				return $row;
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

    public function get_quantity_discount($prd_sku)
    {
    	try
		{
			$sql="SELECT * from price_list where sku = '".$prd_sku."'  ";
			
			$query=$this->db->query($sql);
			$row=$query->row_array();
			if(!empty($row))
			{
				return $row;
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

    public function tenderEmailData($tender_email_id ='')
	{
		$sqlQuery = 'SELECT *,(select tdr_id from tender_detail where tender_detail.tdr_refid = tdr.tde_tdr_refid) as tender_id,
    			(select prs_name from tender_person where tender_person.prs_id = tdr.tde_prs_id) as person_name
                FROM tender_emaillogs tdr
                Where tdr.tde_id = '.$tender_email_id .' ';


		$query = executeSqlQuery($sqlQuery,'row_array');
		
		if(isset($query) && $query != '')
		{
			return $query;
		}
		return false;
	}

}
?>