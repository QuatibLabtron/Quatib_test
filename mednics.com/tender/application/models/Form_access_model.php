<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form_access_model extends CI_Model 
{
	/**
	* Instanciar o CI
	*/
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
		/**
	* Instanciar o CI
	*/
	public function formaccess_model()
    {
        parent::Model();
		$this->CI =& get_instance();
    }
	

	public function persondata($usr_id='')
	{
			global $active_user;

    	$sql1="select  * FROM `tender_person` where prs_id=".$usr_id."";

				$query1 =$this->db->query($sql1);

				$row1 =$query1->row();

				return $row1;
	}
	
	function display_access($usr_id)
	{
		$uty=$this->persondata($usr_id);
		
		$str="";
		
		$str.="<table align='center' cellpadding='0' cellspacing='0' border='0' class='table-form' width='100%'>";
		$str.="<tr>";
		$str.="<td>User Name :-";
		$str.="</td>";
		if(!empty($uty))
		{
			$str.="<td>";
			$str.="".$uty->prs_name."";
			// $str.="  ";
			// $str.="".$uty->usr_ref."";
			// $str.="</td>";
		}
		
		$str.="</tr>";
		
		$str.="</table>";
		$str.="&nbsp;&nbsp;";
		
		$sql ="select distinct tender_menu_master.mnu_name,tender_menu_master.mnu_id,tender_menu_master.mnu_link from tender_menu_master left join  tender_menu_transaction on tender_menu_master.mnu_id=tender_menu_transaction.mtr_mnu_id  where tender_menu_master.mnu_Status='Y' and tender_menu_transaction.mtr_DPT_id ='".$uty->prs_dpt_id."' and tender_menu_transaction.mtr_Status='Y'  order by tender_menu_master.mnu_name";

		  
	


		$by_combo=$this->db->query($sql);
		//return $result;
		
		//print_r($mod);
		$i=-1;
		foreach($by_combo->result() as $mod)
		{
			$i++;
			
			$str.="<table align='center' cellpadding='0' cellspacing='0' border='0' class='table-form' width='100%'>";
			$str.="<tr>";
			
			$str.="<td  width='90%' bgcolor='#CCCCCC' onclick='open_down(".$mod->mnu_id.");' title='Click Here To Expand' id='show".$mod->mnu_id."'>";
			//$str.="";
			$str.="<img src='".base_url()."assets/images/plus.gif' id='my".$mod->mnu_id."' >&nbsp;&nbsp;<font style='cursor:pointer'><b>".$mod->mnu_name."</b><input type='hidden' name='modstat".$mod->mnu_id."' id='modstat".$mod->mnu_id."' value='0'";
			$str.="</td>";
			$str.="</tr>";
			$str.="</table>";
			$str.="<div id='mod".$mod->mnu_id."' style='display:none'>";
			$str.="<table align='center' cellpadding='0' cellspacing='0' border='0' class='table-form' width='100%'>";
			
			$this->db->select('sbm_id,sbm_name');
			$this->db->from('tender_sub_menu_master');
			$this->db->where("sbm_mnu_id",$mod->mnu_id);
			$this->db->where("sbm_status",STATUS_ACTIVE);
			
			
			$by_combo1 = $this->db->get();

			$str.="<div id='err".$mod->mnu_id."' style='color:#FF0000'></div>";
			
			
			//print_r($pag);
			$pp=0;
			$j=0;
			
			foreach($by_combo1->result() as $pag)
			{
				
				/*if($pp=="0" || $pp=="4")
				{
					$str.="<tr>";
				}*/
				
				if($j==0)
				{
					$str.="<tr align='center'>";
					$str.="<td width='400px' align='center'>";
					$str.="<b>Page Access</b>";
					$str.="</td>";
					$str.="<td width='150px' align='center'><center>";
					$str.="<b>Set All Priviledged</b>";
					$str.="</center></td>";
					$str.="<td width='150px' align='center'><center>";
					$str.="<b>Read</b>";
					$str.="</center></td>";
					$str.="<td align='center' width='150px'><center>";
					$str.="<b>Update</b>";
					$str.="</center></td>";
					$str.="<td align='center' width='150px'><center>";
					$str.="<b>Delete</b>";
					$str.="</center></td>";
					$str.="<td align='center' width='150px'><center>";
					$str.="<b>Write</b>";
					$str.="</center></td>";
					$str.="</tr>";
				}
				
				$str.="<tr>";
				
				$this->db->select('fma_id ,fma_access,`fma_read`,`fma_update`,`fma_delete`,`fma_write`,fma_Status');
				$this->db->from('tender_form_access');
				$this->db->where("fma_sbm_id",$pag->sbm_id);
				$this->db->where("fma_mnu_id",$mod->mnu_id);
				$this->db->where("fma_USR_id",$usr_id);
				
				$by_combo2 = $this->db->get();
				$rownew=$by_combo2->row();
				

				//echo $sq3;
				//print_r($by_combo2->num_rows());
				
				$pp++;
				$chk = new stdClass;
				if($by_combo2->num_rows() > 0)
				{
					$chk=$rownew;
				}
				else
				{
					$chk->fma_id = '' ;
					$chk->fma_access=0;
					$chk->fma_read=0;
					$chk->fma_update=0;
					$chk->fma_delete=0;
					$chk->fma_write=0;
					$chk->fma_Status=0;
				}
					$str.="<td>";
					if($chk->fma_access==1)
					{
						$str.="<input type='checkbox' name='".$mod->mnu_id."fma_access".$j."' id='".$mod->mnu_id."fma_access".$j."' value='' checked='checked' onclick='check_access(".$mod->mnu_id.",".$j.");' >".$pag->sbm_name."";
					}
					else
					{
						$str.="<input type='checkbox' name='".$mod->mnu_id."fma_access".$j."' id='".$mod->mnu_id."fma_access".$j."' value='' onclick='check_access(".$mod->mnu_id.",".$j.");' >".$pag->sbm_name."";
					}

					if($chk->fma_id != '')
					{
						$str.="<input type='hidden' name='".$mod->mnu_id."ffma_access".$j."' id='".$mod->mnu_id."ffma_access".$j."' value='".$chk->fma_id ."' />";
					}
					else
					{
						$str.="<input type='hidden' name='".$mod->mnu_id."ffma_access".$j."' id='".$mod->mnu_id."ffma_access".$j."' value='0' />";
					}
					$str.="<input type='hidden' name='".$mod->mnu_id."sbm_id".$j."' id='".$mod->mnu_id."sbm_id".$j."' value='".$pag->sbm_id."' />";
					//echo "djkhfhdk".$chk->fma_read."sdfdf<br><br><br>";
					$str.="</td>";
					$str.="<td>";
					if($chk->fma_access==1)
					{
						if($chk->fma_read==1 && $chk->fma_update==1 && $chk->fma_delete==1 && $chk->fma_write==1)
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."all".$j."' id='".$mod->mnu_id."all".$j."' value='' checked='checked' onclick='check_all(".$mod->mnu_id.",".$j.");'  > All";
						}
						else
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."all".$j."' id='".$mod->mnu_id."all".$j."' value='' onclick='check_all(".$mod->mnu_id.",".$j.");' > All";
						}
					}
					else
					{
						if($chk->fma_read==1 && $chk->fma_update==1 && $chk->fma_delete==1 && $chk->fma_write==1)
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."all".$j."' id='".$mod->mnu_id."all".$j."' value='' checked='checked' disabled='disabled' onclick='check_all(".$mod->mnu_id.",".$j.");' > All";
						}
						else
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."all".$j."' id='".$mod->mnu_id."all".$j."' value='' disabled='disabled' onclick='check_all(".$mod->mnu_id.",".$j.");' > All";
						}
					}
					$str.="</td>";
					$str.="<td>";
					if($chk->fma_access==1)
					{
						if($chk->fma_read==1)
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."read".$j."' id='".$mod->mnu_id."read".$j."' value='' checked='checked'  > Read";
						}
						else
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."read".$j."' id='".$mod->mnu_id."read".$j."' value='' > Read";
						}
					}
					else
					{
						if($chk->fma_read==1)
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."read".$j."' id='".$mod->mnu_id."read".$j."' value='' checked='checked' disabled='disabled' > Read";
						}
						else
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."read".$j."' id='".$mod->mnu_id."read".$j."' value='' disabled='disabled' > Read";
						}
					}
					$str.="</td>";
					$str.="<td>";
					if($chk->fma_access==1)
					{
						if($chk->fma_update==1)
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."upd".$j."' id='".$mod->mnu_id."upd".$j."' value='' checked='checked' > Update";
						}
						else
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."upd".$j."' id='".$mod->mnu_id."upd".$j."' value='' > Update";
						}	
					}
					else
					{
						if($chk->fma_update==1)
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."upd".$j."' id='".$mod->mnu_id."upd".$j."' value='' checked='checked' disabled='disabled' > Update";
						}
						else
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."upd".$j."' id='".$mod->mnu_id."upd".$j."' value='' disabled='disabled' > Update";
						}	
					}
					$str.="</td>";
					$str.="<td>";
					if($chk->fma_access==1)
					{
						if($chk->fma_delete==1)
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."del".$j."' id='".$mod->mnu_id."del".$j."' value='' checked='checked' > Delete";
						}
						
						else
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."del".$j."' id='".$mod->mnu_id."del".$j."' value='' > Delete";
						}
					}
					else
					{
						if($chk->fma_delete==1)
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."del".$j."' id='".$mod->mnu_id."del".$j."' value='' checked='checked' disabled='disabled' > Delete";
						}
						
						else
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."del".$j."' id='".$mod->mnu_id."del".$j."' value='' disabled='disabled' > Delete";
						}
					}
					$str.="</td>";
					$str.="<td>";
					if($chk->fma_access==1)
					{
						if($chk->fma_write==1)
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."write".$j."' id='".$mod->mnu_id."write".$j."' value='' checked='checked' > Write";
						}
						else
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."write".$j."' id='".$mod->mnu_id."write".$j."' value='' > Write";
						}
					}
					else
					{
						if($chk->fma_write==1)
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."write".$j."' id='".$mod->mnu_id."write".$j."' value='' checked='checked' disabled='disabled' > Write";
						}
						else
						{
							$str.="<input type='checkbox' name='".$mod->mnu_id."write".$j."' id='".$mod->mnu_id."write".$j."' value='' disabled='disabled' > Write";
						}
					}
					$str.="</td>";
				$str.="</tr>";
				/*if($pp=="0" || $pp=="4")
				{			
					$str.="</tr>";
					$pp=0;;
				}*/
				$j++;
			}
			$str.="<tr><td colspan='6' align='center'><input type='hidden' name='".$mod->mnu_id."pgcount' id='".$mod->mnu_id."pgcount' value='".$j."' /><center><input type='button' name='btn' id='btn' value='Update' class='submit' onclick='update_access(\"".$mod->mnu_id."\",5);' /></center></td></tr>";
			$str.="</table>";
			$str.="</div>";
		}
		return $str;	
	}
	
	function change_access()
	{
		//echo $this->acc;
		$com=explode("@",$_REQUEST['fma_access']);
		//print_r($com);
		$marlen=sizeof($com);
		for($i=0;$i<$marlen-1;$i++)
		{
			$inar=explode("#",$com[$i]);
			//print_r($inar);
			if($inar[6]!="")
			{
			if($inar[0]==0)
			{
				//echo "fma_read";
				if($inar[1]==1)
				{
					$sq="insert into tender_form_access(`fma_USR_id`,`fma_mnu_id`,`fma_sbm_id`,`fma_access`,`fma_read`,`fma_update`,`fma_delete`,`fma_write`) value ('".$inar[6]."','".$inar[7]."','".$inar[8]."','".$inar[1]."','".$inar[2]."','".$inar[3]."','".$inar[4]."','".$inar[5]."')";
					$this->db->query($sq);
				}
				else
				{
					
				}
			}
			else
			{
				//echo "UPDATE";
				$sq="update tender_form_access set fma_access='".$inar[1]."',`fma_read`='".$inar[2]."',`fma_update`='".$inar[3]."',`fma_delete`='".$inar[4]."',`fma_write`='".$inar[5]."' where fma_id ='".$inar[0]."'";
				//echo $sq;
				$this->db->query($sq);
				
				if($inar[1]=="1")
				{
					$sqy="update tender_form_access set fma_Status='Y' where fma_id ='".$inar[0]."' ";
					$this->db->query($sqy);
				}				
			}
			}
		}
	}
}
?>