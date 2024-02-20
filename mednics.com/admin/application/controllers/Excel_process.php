<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel_process extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();

        //$this->load->model('categories_model');
    
		if($this->session->userdata('prs_id') == '')
		{
			redirect('/login', 'refresh');
			exit;
		}
    }
	
	public function excel_importing()
	{
		if(isset($_POST) && $_POST != '' && !empty($_POST))
		{
			$entity_attr 	= et_get_entity_attributes($_POST['entity_name']);
			$redirect_ctrl 	= $_POST['ctrl'];

			if($_POST['process_type'] == 'add_excel_files') 
			{
				if(isset($_POST['new_excel_files']) && $_POST['new_excel_files']!='')
				{

					foreach ($_POST['new_excel_files'] as $file) 
					{
						try
						{
							$this->db->trans_start();


							et_add_excel_file($entity_attr, $file);
							
		            		$entity_attr = et_get_entity_attributes($entity_attr['name']);

							$this->db->trans_complete();
							$this->session->set_flashdata('success', 'Data Imported Successful');

							redirect(base_url($_POST['ctrl'].'-import'));
						}
						catch (Exception $e)
						{
							log_message('error','Excel process excel_importing add_excel_files >> Error while adding excel file >> '.$e->getMessage());
							$this->session->set_flashdata('excel_error', 'Error while adding excel file >> '.$e->getMessage());
							redirect('dashboard');
							//echo 'Error while adding excel file >> ', $e->getMessage(), "\n";

						}
						
					}	
				}
			}
			elseif($_POST['process_type'] == 'update_excel_files') 
			{
				if(isset($_POST['excel_files']) && $_POST['excel_files']!='')
				{

					foreach ($_POST['excel_files'] as $file) 
					{
						try
						{
							$this->db->trans_start();


							et_update_excel_file($entity_attr, $file);

            				$entity_attr = et_get_entity_attributes($entity_attr['name']);

							$this->db->trans_complete();
							$this->session->set_flashdata('success', 'Data Updated Successful');

							redirect(base_url($_POST['ctrl'].'-import'));
						}
						catch (Exception $e)
						{
							//echo 'Error while adding excel file >> ', $e->getMessage(), "\n";
							log_message('error','Excel process excel_importing update_excel_files >> Error while adding excel file >> '.$e->getMessage());
							$this->session->set_flashdata('excel_error', 'Error while updating excel file >> '.$e->getMessage());
							redirect('dashboard');

						}
						
					}	
				}
			}
			elseif($_POST['process_type'] == 'remove_excel_files') 
			{
				if(isset($_POST['excel_files']) && $_POST['excel_files']!='')
				{

					foreach ($_POST['excel_files'] as $file) 
					{
						try
						{
							$this->db->trans_start();


							et_remove_excel_file($entity_attr, $file);

							$this->db->trans_complete();
							$this->session->set_flashdata('success', 'Data Removed Successful');

							redirect(base_url($_POST['ctrl'].'-import'));
						}
						catch (Exception $e)
						{
							//echo 'Error while adding excel file >> ', $e->getMessage(), "\n";
							log_message('error','Excel process excel_importing remove_excel_files >> Error while adding excel file >> '.$e->getMessage());
							$this->session->set_flashdata('excel_error', 'Error while removing excel file >> '.$e->getMessage());
							redirect('dashboard');


						}
						
					}	
				}
			}



		}else{
			redirect('dashboard');	
		}
		
	}

	  
}