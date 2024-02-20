<!DOCTYPE html>
<!--[if IE 8]> 
<html lang="en" class="ie8 no-js">
   <![endif]-->
   <!--[if IE 9]> 
   <html lang="en" class="ie9 no-js">
      <![endif]-->
      <!--[if !IE]><!-->
      <html lang="en">
         <!--<![endif]-->
         <!-- BEGIN HEAD -->
         <head>
            <?php $this->load->view('common/header_style')?>  
            <link href="<?php echo base_url()?>assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
            <!-- select2 css files -->
            <link href="<?php echo base_url()?>assets/global/plugins/select2/css/select2.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
            <link href="<?php echo base_url()?>assets/global/plugins/select2/css/select2-bootstrap.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
            <!-- select2 css end -->
         </head>
         <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
              <?php $this->load->view('common/header')?>  
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                 <?php $this->load->view('common/sidebar')?>  
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <?php echo $breadcrumb; ?>
                        </div>
                      
                       <div class="row">
                            <div class="col-md-12 ">
                                <!-- BEGIN SAMPLE FORM PORTLET-->
                                <div class="portlet light bordered">
                                   <div class="portlet-title">
                                     <div class="caption font-orange">
                                        <i class="icon-pin font-orange"></i>
                                        <span class="caption-subject bold uppercase">Add User</span>
                                     </div>
                                  </div>

                                    <div class="portlet-body form">
                                    <div id="error" style="text-align: center;">
                                    </div>
                                        <form class="form-manager" enctype="multipart/form-data" role="form" id="add-form" name="add-form" method="post" action="<?php echo site_url('add-user');?>">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                             <label for="prs_name">Name<span style="color:red">*</span></label>
                                                             <input type="text" class="form-control" id="prs_name" name="prs_name" placeholder="Enter a Name">
                                                             <span class="text-danger"><?php echo form_error('prs_name');?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="prs_email">Email<span style="color:red">*</span></label>
                                                            <input type="email" class="form-control" id="prs_email" name="prs_email" placeholder="Enter a Email">
                                                            <span class="text-danger"><?php echo form_error('prs_email');?></span>
                                                        </div>
                                                   </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="prs_mob">Mobile No.<span style="color:red">*</span></label>
                                                            <input type="text" class="form-control" id="prs_mob" name="prs_mob" placeholder="Enter a Mobile No." >
                                                            <span class="text-danger"><?php echo form_error('prs_mob');?></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                         <div class="form-group">
                                                            <label for="prs_address" class="control-label">Address
                                                            </label>
                                                            <textarea class="form-control" id="prs_address"   name="prs_address" placeholder="Enter a Address" ></textarea> 
                                                            <span class="text-danger"><?php echo form_error('prs_address');?></span>
                                                         </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="prs_password">Password<span style="color:red">*</span></label>
                                                            <input type="password" class="form-control" id="prs_password" name="prs_password" placeholder="Enter a Password"  minlength="6">
                                                            <span class="text-danger"><?php echo form_error('prs_password');?></span>
                                                        </div>    
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="prs_password1">Confirm Password<span style="color:red">*</span></label>
                                                            <input type="password" class="form-control" equalto="#prs_password"  name="prs_password1" id="prs_password1"    minlength="6"  placeholder="Retype Password">
                                                            <span class="text-danger"><?php echo form_error('prs_password1');?></span>
                                                        </div>    
                                                    </div>                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Department<span style="color:red">*</span></label>
                                                          <select name="prs_dpt_id" id="prs_dpt_id"   class="form-control select2" >
                                                              <option value=''>Select Department</option>
                                                                <?php echo getCombo('select dpt_id as f1 ,dpt_name as f2 from adm_department where status= "'.STATUS_ACTIVE.'" ')?> 
                                                          </select>
                                                           <span class="text-danger"><?php echo form_error('prs_dpt_id');?></span>
                                                        </div>    
                                                    </div>   
                                                  </div>
                                                </div>   
                                            </div>
                                            <div class="form-actions noborder">
                                               <button type="submit" id="form_submit" class="btn blue">Save</button>
                                              <button type="button" class="btn blue" name="processing" id="processing" style="display:none">
                                              <i class="fa fa-spinner fa-spin" style="font-size:18px"></i>Processing
                                              </button>
                                              <button type="button" id="cancel" class="btn default">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
           <?php $this->load->view('common/footer')?> 
            <!-- END FOOTER -->
        </div>

      <?php $this->load->view('common/footer_style'); ?> 
	   <!-- for form validation -->
            <!-- BEGIN THEME GLOBAL SCRIPTS -->
            <script src="<?php echo base_url()?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <script src="<?php echo base_url()?>assets/layouts/layout/scripts/layout.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
            <script src="<?php echo base_url()?>assets/layouts/layout/scripts/demo.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
            <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-sidebar.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
            <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-nav.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
            <script src="<?php echo base_url()?>assets/global/plugins/select2/js/select2.full.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
            <script src="<?php echo base_url()?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
            <script src="<?php echo base_url()?>assets/pages/scripts/components-select2.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
		<script src="<?php echo base_url()?>assets/js/form_validation_user.js<?php echo $global_asset_version; ?>" ></script>
        <!--end  validation script -->
		
    </body>
</html>