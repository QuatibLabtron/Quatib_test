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
                         <!-- END PAGE BAR -->
                         <!-- BEGIN PAGE TITLE-->
                         <!--  <h1 class="page-title"> Blank Page Layout
                            <small>blank page layout</small>
                            </h1> -->
                         <!-- END PAGE TITLE-->
                         <!-- END PAGE HEADER-->
                         <div class="row">
                            <div class="col-md-12 ">
                               <!-- BEGIN SAMPLE FORM PORTLET-->
                               <div class="portlet light bordered">
                                  <div class="portlet-title">
                                     <div class="caption font-orange">
                                        <i class="icon-pin font-orange"></i>
                                        <span class="caption-subject bold uppercase">Add Organisation</span>
                                     </div>
                                  </div>
                                  <div class="portlet-body form">
                                     <form class="form-manager" enctype="multipart/form-data" role="form" id="add-form" name="add-form" method="post" action="<?php echo site_url('add-organisations');?>">
                                        <div class="form-body">
                                          <div class="portlet light bordered">
                                            <div class="Portlet-body">
                                               <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Name<span style="color:red">*</span></label>
                                                        <input type="text" class="form-control" name="org_name" id="org_name" value="<?php echo set_value('org_name');?>">
                                                        <span class="text-danger"><?php echo form_error('org_name');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="form_control_1">Primary Email<span style="color:red">*</span></label>
                                                        <input type="email" class="form-control" name="org_primaryemail" id="org_primaryemail" value="<?php echo set_value('org_primaryemail');?>">
                                                        <span class="text-danger"><?php echo form_error('org_primaryemail');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Secondary Email</label>
                                                        <input type="email" class="form-control" name="org_secondaryemail" id="org_secondaryemail" value="<?php echo set_value('org_secondaryemail');?>">
                                                        <span class="text-danger"><?php echo form_error('org_secondaryemail');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="form_control_1">Tertiary Email</label>
                                                        <input type="email" class="form-control" name="org_tertiaryemail" id="org_tertiaryemail" value="<?php echo set_value('org_tertiaryemail');?>">
                                                        <span class="text-danger"><?php echo form_error('org_tertiaryemail');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Primary Phone</label>
                                                        <input type="text" class="form-control" name="org_primaryphone" id="org_primaryphone" value="<?php echo set_value('org_primaryphone');?>">
                                                        <span class="text-danger"><?php echo form_error('org_primaryphone');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="form_control_1">Alternate phone</label>
                                                        <input type="text" class="form-control" name="org_altphone" id="org_altphone" value="<?php echo set_value('org_altphone');?>">
                                                        <span class="text-danger"><?php echo form_error('org_altphone');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                                <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">FAX</label>
                                                        <input type="text" class="form-control" name="org_fax" id="org_fax" value="<?php echo set_value('org_fax');?>">
                                                        <span class="text-danger"><?php echo form_error('org_fax');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="form_control_1">Website</label>
                                                        <input type="text" class="form-control" name="org_website" id="org_website" value="<?php echo set_value('org_website');?>">
                                                        <span class="text-danger"><?php echo form_error('org_website');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                           
                                           <?php $person_id = $this->session->userdata('prs_id'); ?>
                                            <input type="hidden" name="org_assignedid" id="org_assignedid" value="<?php echo $person_id ?>">
                                         
                                                <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Assigned To</label>
                                                          <select name="org_assignedto" id="org_assignedto" class="form-control" readonly>
                                                             <!--  <option value=''>Select Currency</option> -->
                                                                <?php echo getCombo('select prs_username as f1 ,prs_name as f2 from tender_person where status= "'.STATUS_ACTIVE.'" and prs_id = "'.$person_id.'" ')?> 
                                                          </select>
                                                        <span class="text-danger"><?php echo form_error('org_assignedto');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="form_control_1">Industry</label>
                                                        <select name="org_industry" id="org_industry"   class="form-control select2">
                                                              <option value=''>Select Industry</option>
                                                                <?php echo getCombo('select gen_value as f1 ,gen_name as f2 from tender_gen_prm where status= "'.STATUS_ACTIVE.'" and gen_group = "'.TENDER_INDUSTRY.'" ')?> 
                                                          </select>
                                                        <span class="text-danger"><?php echo form_error('org_website');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">CST</label>
                                                        <input type="text" class="form-control" name="org_cst" id="org_cst" value="<?php echo set_value('org_cst');?>">
                                                        <span class="text-danger"><?php echo form_error('org_cst');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="form_control_1">VAT</label>
                                                        <input type="text" class="form-control" name="org_vat" id="org_vat" value="<?php echo set_value('org_vat');?>">
                                                        <span class="text-danger"><?php echo form_error('org_vat');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                              </div>
                                            </div>
                                            <div class="portlet light bordered">
                                               <div class="portlet-title">
                                                        <div class="caption">Address</div>
                                                    </div>
                                              <div class="Portlet-body">
                                                <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Billing <a style="cursor:pointer;" onclick="return copy_to_shipping()">Copy to Shipping Address</a></label>
                                                        <textarea class="form-control" name="org_billingadd" id="org_billingadd" data-msg="PLease enter Billing Address" ></textarea>
                                                        <span class="text-danger"><?php echo form_error('org_billingadd');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                          <label for="form_control_1">Shipping <a style="cursor:pointer;" onclick="return copy_to_billing()">Copy to Billing Address</a></label>
                                                        <textarea class="form-control" name="org_shippingadd" id="org_shippingadd" data-msg="PLease enter Shipping Address" ></textarea>
                                                        <span class="text-danger"><?php echo form_error('org_shippingadd');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Billing POB</label>
                                                        <input type="text" class="form-control" name="org_billingpob" id="org_billingpob" value="<?php echo set_value('org_billingpob');?>">
                                                        <span class="text-danger"><?php echo form_error('org_billingpob');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="form_control_1">Shipping POB</label>
                                                        <input type="text" class="form-control" name="org_shippingpob" id="org_shippingpob" value="<?php echo set_value('org_shippingpob');?>">
                                                        <span class="text-danger"><?php echo form_error('org_shippingpob');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                                <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Billing City</label>
                                                        <input type="text" class="form-control" name="org_billingcity" id="org_billingcity" value="<?php echo set_value('org_billingcity');?>">
                                                        <span class="text-danger"><?php echo form_error('org_billingcity');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="form_control_1">Shipping City</label>
                                                        <input type="text" class="form-control" name="org_shippingcity" id="org_shippingcity" value="<?php echo set_value('org_shippingcity');?>">
                                                        <span class="text-danger"><?php echo form_error('org_shippingcity');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Billing State</label>
                                                        <input type="text" class="form-control" name="org_billingstate" id="org_billingstate" value="<?php echo set_value('org_billingstate');?>">
                                                        <span class="text-danger"><?php echo form_error('org_billingstate');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="form_control_1">Shipping State</label>
                                                        <input type="text" class="form-control" name="org_shippingstate" id="org_shippingstate" value="<?php echo set_value('org_shippingstate');?>">
                                                        <span class="text-danger"><?php echo form_error('org_shippingstate');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Billing POC</label>
                                                        <input type="text" class="form-control" name="org_billingpoc" id="org_billingpoc" value="<?php echo set_value('org_billingpoc');?>">
                                                        <span class="text-danger"><?php echo form_error('org_billingpoc');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="form_control_1">Shipping POC</label>
                                                        <input type="text" class="form-control" name="org_shippingpoc" id="org_shippingpoc" value="<?php echo set_value('org_shippingpoc');?>">
                                                        <span class="text-danger"><?php echo form_error('org_shippingpoc');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                                <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                       <label for="form_control_1">Billing Country</label>
                                                          <select name="org_billingcountry" id="org_billingcountry" class="form-control select2">
                                                               <option value=''>Select Country</option>
                                                                <?php echo getCombo('select tcv_id as f1 ,tcv_country as f2 from tender_country_vol')?> 
                                                          </select>
                                                        <span class="text-danger"><?php echo form_error('org_billingcountry');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Shipping Country</label>
                                                        <select name="org_shippingcountry" id="org_shippingcountry" class="form-control select2">
                                                           <option value=''>Select Country</option>
                                                            <?php echo getCombo('select tcv_id as f1 ,tcv_country as f2 from tender_country_vol')?> 
                                                          </select>
                                                        <span class="text-danger"><?php echo form_error('org_shippingcountry');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                              </div>
                                            </div>
                                            <div class="portlet light bordered">
                                              <div class="Portlet-body">
                                                <div class="row">
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Description</label>
                                                        <textarea class="form-control" name="org_desc" id="org_desc" data-msg="PLease enter Description" ></textarea>
                                                        <span class="text-danger"><?php echo form_error('org_desc');?></span>
                                                     </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                     <div class="form-group">
                                                          <label for="form_control_1">Comment</label>
                                                        <textarea class="form-control" name="org_comment" id="org_comment" data-msg="Please enter Comment" ></textarea>
                                                        <span class="text-danger"><?php echo form_error('org_comment');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                              </div>
                                            </div>
                                          
                                           <div class="form-actions">
                                              <button type="submit" id="form_submit" class="btn blue">Save</button>
                                              <button type="button" class="btn blue" name="processing" id="processing" style="display:none">
                                              <i class="fa fa-spinner fa-spin" style="font-size:18px"></i>Processing
                                              </button>
                                              <button type="button" id="cancel" class="btn default">Cancel</button>
                                           </div>
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
            <!-- <div class="quick-nav-overlay"></div> -->
            <?php $this->load->view('common/footer_style')?> 
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
            <script src="<?php echo base_url()?>assets/js/form_validation_organisations.js<?php echo $global_asset_version; ?>" ></script>
            <!-- END THEME LAYOUT SCRIPTS -->
         </body>
      </html>