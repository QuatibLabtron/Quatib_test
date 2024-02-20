<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Access_model extends CI_Model 
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
   
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
        $sql = "select * from adm_sub_menu_master where sbm_status='Y' and sbm_group='submenu' and sbm_mnu_id=".$mnu_id." and sbm_parent_id=".$mnu_id." and sbm_id in (select fma_sbm_id from adm_form_access where fma_status='Y' and fma_access='1'  and fma_usr_id='".$prs_id."' and fma_mnu_id='".$mnu_id."') order by sbm_order";
        $result=$this->db->query($sql);
        return $result;
    }

    function getpages($pageid,$moduleid)
    {
        $prs_id = $this->session->userdata('prs_id');
        $sql = "select sbm_mnu_id,sbm_pagelink as form_name,sbm_name as form_title,SUBSTRING_INDEX(sbm_name,'(',-1) as pgname from adm_sub_menu_master where sbm_status='Y' and sbm_group='submenu' and sbm_mnu_id='".$moduleid."' and sbm_id in (select fma_sbm_id from adm_form_access where fma_status='Y' and fma_access='1' and fma_usr_id='".$prs_id."' and sbm_parent_id='".$pageid."' and fma_mnu_id='".$moduleid."') order by SUBSTRING_INDEX(sbm_name,'(',-1)";
        $result=$this->db->query($sql);
        return $result;
    }
   }
?>