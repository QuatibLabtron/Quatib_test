<?php
    if($this->session->userdata('prs_id')==''){
      $abc = base_url();
        echo '<script> ';
          echo 'window.location="'.$abc.'"';
        echo '</script>';
    }   
?>

<!DOCTYPE html>

<html lang="en">
 

    <head>
         <?php $this->load->view('common/header_style')?>  
     
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <!-- BEGIN HEADER -->
         <?php $this->load->view('common/header'); ?>
        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
            <?php $this->load->view('common/sidebar'); ?>
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                   
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo site_url('dashboard')?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Parameters</span>
                            </li>
                        </ul>
                       
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    

                  <div class="row">
					 <div class="portlet light bordered">
						   <form class="horizontal-form" method="post" action="<?php echo site_url('parameter-list')?>">
					  <h3 class="page-title">  <label style="padding-left: 0px" class="col-md-2 control-label bold" for="gen_group"><i class="fa fa-list" aria-hidden="true"></i> Parameter</label>

									<div class="input-group col-md-5">
										<div class="input-group-control">
										  <select id="gen_group" required class="form-control" onchange="return table(this.value)"  name="gen_group">

											<option value='please select'>---Please Select---</option>

										 <?php
											$abc3 ="SELECT distinct gen_group as f1 FROM `adm_gen_prm` ";
											  
												 // $this->db->where('ITE_status','Y');
												 $query = $this->db->query($abc3);

										  $str='';
												foreach ($query->result() as $row) 
												{
											  if($row->f1==$gen_group)
											  {
											 //print_r($row);
											   $selected='selected';
											 }
											 else
												{
											  $selected='';

											 }
											  
											   $str .="<option value='".$row->f1."' ".$selected.">".$row->f1."</option>";
											}
										 echo $str;
								 
									?>
									</select>
													  <div class="form-control-focus"> </div>
												  </div>
												  <span class="input-group-btn btn-right">
													 
													 <button class="btn green" type="submit"  name="go" id="go">GO</button>
												  </span>
											 
										  </div>
                   </h3>

                      <!-- END PAGE TITLE-->
                      <!-- END PAGE HEADER-->
                     
                      <div class="row" >
                          <div class="col-md-12" id="results">
                             
                              
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12" id="main_result">
                              
                          </div>
                          <!-- END SAMPLE FORM PORTLET-->
                      </div>
                  </form>
                       <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject bold uppercase">Parameter List</span>
                                    </div>
                                 <div class="btn-group"  >
                                        <button id="addnewclick" class="btn green">
                                            Add New <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                         </div>

                                  <div class="portlet-body form" >
                                    <!-- BEGIN FORM-->
                                    <div class="form" id="addnewform" style="display:none">
                                        <form  id="add_param" method="post" action="" class="horizontal-form">
                                        <input type="hidden" id="gen_id" name="gen_id" value="">
                                           <div class="form-body" style="padding: 0px 20px 20px 20px;">
                                              <div class="row">
                                                 <div class="col-md-4">
                                                    <div class="form-group">
                                                       <label for="prs_name" class="control-label">Name <span style="color:red">*</span></label>
                                                       <input class="form-control" id="gen_name" name="gen_name"  type="text" required >
                                                      
                                                    </div>
                                                 </div>
                                                 <!--/span-->
                                                 <div class="col-md-4">
                                                    <div class="form-group">
                                                       <label for="prs_mob" class="control-label">Order <span style="color:red">*</span></label>
                                                       <input   class="form-control" id="gen_order" name="gen_order"  type="text" required>
                                                       
                                                    </div>
                                                 </div>
                                                 <!--/span-->
                                              </div>
                                              <div class="row">
                                                 <div class="col-md-4">
                                                    <div class="form-group">
                                                       <label for="prs_email" class="control-label">Group <span style="color:red">*</span></label>
                                                       <input  class="form-control"  value="<?php echo $gen_group?>" readonly id="gen_group" name="gen_group"  type="text" >
                                                      
                                                    </div>
                                                 </div>
                                                 <!--/span-->
                                              </div>
                                              <!--/row-->
                                              
                                             
                                             
                                              
                                              <div class="form-actions left">
                                               
                                                 <button type="submit" class="btn green" name="form_submit" id="form_submit" >
                                                 <i class="fa fa-check"></i> Save</button>
                                                 <button class="btn btn-danger"  style="display:none" id="processing" type="button"> <span class="glyphicon glyphicon-refresh spinning"></span>Processsing</button>
                                              </div>
                                            </div>
                                        </form>
                                    <!-- END FORM-->
                                    </div>
                                    </div>



                                <div class="portlet-body">
                                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                                        <thead>
                                            <tr>
                                              <th style="display: none;">  </th>
                                                <th>Sr No.</th>
                                                <th>Name</th>
                                                <!-- <th>Value</th> -->
                                                <th>Group</th>
                                                  <!-- <th>Status</th> -->
                                                <th>Edit</th> 
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                    <?php  $i=1;
                                     foreach ($post as $key)
                                

                                    {
                                     ?>
                                                <tr class="gradeX">
                                                  <td><?php echo $i;?></td>
                                                  
                                                    <td><?php echo $key->gen_name;?></td>
                                                    <td><?php echo $key->gen_group;?></td>
                                                      
                                                    <td><a class="edit"  id="updatenewclick" onclick="edit(<?php echo $key->gen_id;?>)">Edit</a></td>
                                                   
                                                </tr>
                                              <?php

                                                $i++;
                                                 } ?>

                                         
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                     


                  </div>







               
                <!-- END CONTENT BODY -->
         
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a>
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
       <?php $this->load->view('common/footer'); ?>
        <!-- END FOOTER -->
       
        <!-- BEGIN CORE PLUGINS -->
        <script>
		  var myheader="<?php echo site_url(); ?>";
		</script>
         <?php $this->load->view('common/footer_style'); ?>
		  <!-- FORM VALIDATION -->
        
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js<?php echo $global_asset_version; ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js<?php echo $global_asset_version; ?>"></script>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=<?php echo APIKEYFORLOCATION ?>"></script>
        <!-- END VALIDATION -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>assets/layouts/layout/scripts/layout.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/layouts/layout/scripts/demo.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/layouts/global/scripts/quick-sidebar.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/form_access.js<?php echo $global_asset_version; ?>"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>assets/js/form-validation-script-param.js<?php echo $global_asset_version; ?>"></script>
        <script src="<?php echo base_url();?>assets/js/editable-table-paramnew.js<?php echo $global_asset_version; ?>"></script> 



         <script src="<?php echo base_url()?>assets/pages/scripts/table-datatables-rowreorder.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/global/scripts/datatable.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/global/plugins/datatables/datatables.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>

        <!-- script for the toaster -->

         <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-toastr/toastr.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
          <script src="<?php echo base_url();?>assets/pages/scripts/ui-toastr.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
       

        <script>

        function table(gen_group)

        {

          var base_url='<?php echo base_url()?>';

          if(gen_group=='please select')

          {

        document.getElementById("go").disabled = true;

          
        }

          else{




             document.getElementById("go").disabled = false;

          }

        }





</script>

    </body>

</html>