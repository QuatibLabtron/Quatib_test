<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

		if($this->session->userdata('prs_id') == '')
		{
			redirect('/login', 'refresh');
			exit;
		}
			
    }
	
	public function add_user()
	{
		$data = array();
		$validation_config = array(
				  array(
                     'field'   => 'prs_name', 
                     'label'   => 'Person name', 
                     'rules'   => 'trim|required'
                  ),
            );
		$this->form_validation->set_rules($validation_config);

		$data['title']						= "Add User";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][]			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][]			= array('Users', base_url('users'));
		$data['breadcrumb_data'][] 			= array('Add User');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['scontent']			= array();
		
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->load->view('user/add_user',$data);
		}
		else
		{
			$this->db->trans_start();

			$usr_ref 							= generateRandomString(6);
			$arrAccountData['prs_name'] 		= trim($this->input->post('prs_name'));
			$arrAccountData['prs_username'] 	= $usr_ref.'_'.$arrAccountData['prs_name'];
			$arrAccountData['prs_mob'] 			= trim($this->input->post('prs_mob'));
			$arrAccountData['prs_email'] 		= trim($this->input->post('prs_email'));
			$arrAccountData['prs_address'] 		= trim($this->input->post('prs_address'));
			$arrAccountData['prs_dpt_id'] 		= trim($this->input->post('prs_dpt_id'));
			$arrAccountData['prs_password'] 	= openssl_encrypt($this->input->post('prs_password'),CIPHER,KEY);
			$arrAccountData['status'] 		= STATUS_ACTIVE;
			$arrAccountData['created_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['updated_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['created_dt'] 		= date('Y-m-d H:i:s');
			$arrAccountData['updated_dt'] 		= date('Y-m-d H:i:s');

			$user_id		= insert('adm_person',$arrAccountData);
			$this->db->trans_complete();

			$this->session->set_flashdata('success', 'User added successfully');
			redirect(site_url('user-details-'.$arrAccountData['prs_username']));
			exit;
		}
	}
	
	public function userList()
	{
		$data['title']						= " User List";
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

		// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][]			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][] 			= array('User List');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$data['dataTableData'] 				= $this->home_model->getAllUsers(TABLE_COUNT);

		$this->load->view('user/user_list',$data);
	}

	public function userDataTablelist()
	{
		$dataOptn 				= $this->input->get();
	    $dataTableData 			= $this->home_model->getAllUsers(TABLE_RESULT,$dataOptn);
	      // ******** Encrypt Data from multidimensional array ******//
	     $enc_arr['id']    		= 'id_encrypt';
	    $dataTableArray['data'] = encrypt_key_in_array($dataTableData,$enc_arr);

	      // ******** Encrypt Data from multidimensional array ******//
	    if(isset($dataOptn['columns']))
	        {
	           // *********** Get Data Count **********//
	              $dataTableArray['draw']             = $dataOptn['draw'];
	              $dataTableArray['recordsTotal']     = $dataOptn['table_data_count'];
	              $dataTableArray['recordsFiltered']  = $dataOptn['table_data_count'];
	          // *********** Get Data Count **********//
	      	}

	    echo json_encode($dataTableArray);
	}
	
	public function userDetails($usr_ref)
	{
		$scontent							= array();
		$scontent['username'] 			 	= $usr_ref;
		$data['team_detail']				= $this->home_model->getUserDetails($scontent);
		$data['title']						= $data['team_detail']['prs_name'];
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][]			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][]			= array('Users', base_url('users'));
		$data['breadcrumb_data'][] 			= array($data['team_detail']['prs_name'].' Profile');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//

		$this->load->view('user/user_details',$data);
	}

	public function edit_user($usr_ref)
	{
		$data = array();

		$validation_config = array(
				  array(
                     'field'   => 'prs_name', 
                     'label'   => 'user name', 
                     'rules'   => 'trim|required'
                  )
            );
		$this->form_validation->set_rules($validation_config);

		$scontent							= array();
		$scontent['username'] 			 	= $usr_ref;
		$data['user']						= $this->home_model->getUserDetails($scontent);
		$data['title']						= $data['user']['prs_name'];
		$data['global_asset_version'] 		= global_asset_version();
		$data['ci_asset_versn'] 			= ci_asset_versn();

			// ***** Breadcrumb Data Starts here *******//
		$data['breadcrumb_data'][]			= array('Dashboard', base_url(''));
		$data['breadcrumb_data'][]			= array('Users', base_url('users'));
		$data['breadcrumb_data'][]			= array($data['user']['prs_name']." Profile", base_url('user-details-'.$data['user']['prs_username']));
		$data['breadcrumb_data'][] 			= array('Edit User');
		$data['breadcrumb']        			= $this->crm_auth->ci_breadcrumbs($data['breadcrumb_data']);
		// ***** Breadcrumb Data Ends here *******//
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('user/edit_user',$data);
		}
		else
		{
			$this->db->trans_start();

			$user_id 							= $this->input->post('prs_id');
			$usr_ref 							= $this->input->post('prs_username');
			$arrAccountData['prs_name'] 		= trim($this->input->post('prs_name'));
			$arrAccountData['prs_username'] 	= $usr_ref;
			$arrAccountData['prs_mob'] 			= trim($this->input->post('prs_mob'));
			$arrAccountData['prs_email'] 		= trim($this->input->post('prs_email'));
			$arrAccountData['prs_address'] 		= trim($this->input->post('prs_address'));
			$arrAccountData['prs_dpt_id'] 		= trim($this->input->post('prs_dpt_id'));
			$arrAccountData['status'] 			= STATUS_ACTIVE;
			$arrAccountData['updated_by'] 		= $this->session->userdata('prs_id');
			$arrAccountData['updated_dt'] 		= date('Y-m-d H:i:s');

			$user_id = update('prs_id', $user_id, $arrAccountData, 'adm_person');

			$this->db->trans_complete();

			$this->session->set_flashdata('success', 'User updated successfully');
			redirect(site_url('user-details-'.$usr_ref));
			exit;
		}
	}
	
   	public function changepassword($value='')
   	{
		$old_password 	= trim($this->input->post('old_password'));
		$old_password1 	= openssl_encrypt($old_password,CIPHER,KEY);
		$username       = $this->input->post('usr_ref');
        $row  			= detail_data('*', 'adm_person' , 'prs_username = "'.$username.'" ');

		if($old_password1 == $row['prs_password'])
        {
        	$id 			= $this->input->post('prs_id');
			$password 		= trim($this->input->post('password'));
			$new_password1 	= openssl_encrypt($password,CIPHER,KEY);
            $userArray 		= array('prs_password'=>trim($new_password1));
            $res 			= update('prs_id', $id, $userArray, 'adm_person');
           
            echo json_encode(array("success"=>true,"message"=>'User Password Updated successfully. Please try Login','linkn'=>base_url('users')));
        }
        else
        {
           echo json_encode(array("success"=>false,"message"=>'Current Password Not Match'));
        }
   	}

   	public function user_active()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
			status_to_update($chkId,'prs_id','adm_person',STATUS_ACTIVE);
		}
			$success = true;
			$message = 'User Updated successfully';
			$linkn   =  base_url('users');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

	public function user_deactive()
	{
		$chkId = $this->input->post('chkId');
    	if($chkId)
		{
		    status_to_update($chkId,'prs_id','adm_person',STATUS_INACTIVE);
		}
			$success = true;
			$message = 'User Updated successfully';
			$linkn   =  base_url('users');
		

		echo json_encode(array('success'=>$success,'message'=>$message,'linkn'=>$linkn));
	}

}