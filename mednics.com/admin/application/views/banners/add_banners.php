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
                                        <span class="caption-subject bold uppercase">Add Banners</span>
                                     </div>
                                  </div>
                                  <div class="portlet-body form">
                                     <form class="form-manager" enctype="multipart/form-data" role="form" id="add-form" name="add-form" method="post" action="<?php echo site_url('add-banners');?>">
                                        <div class="form-body">
                                           <div class="row">
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label for="form_control_1">Name</label>
                                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo set_value('name');?>">
                                                    <span class="text-danger"><?php echo form_error('name');?></span>
                                                 </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="form_control_1">Order</label>
                                                    <input type="int"  class="form-control" name="order" id="order" value="<?php echo set_value('order');?>">
                                                    <span class="text-danger"><?php echo form_error('order');?></span>
                                                 </div>
                                              </div>
                                           </div>

                                           <div class="row">
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label for="form_control_1">Image Title</label>
                                                    <input type="text" class="form-control" name="image_title" id="image_title" value="<?php echo set_value('image_title');?>">
                                                    <span class="text-danger"><?php echo form_error('image_title');?></span>
                                                 </div>
                                              </div>
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                    <label for="form_control_1">Image Alt</label>
                                                    <input type="text" class="form-control" name="image_alt" id="image_alt" value="<?php echo set_value('image_alt');?>">
                                                    <span class="text-danger"><?php echo form_error('image_alt');?></span>
                                                 </div>
                                              </div>
                                           </div>
                                           
                                           <div class="row">
                                            
                                              <div class="col-md-6">
                                                 <div class="form-group">
                                                    <input type="file" class="form-control" id="picture" name="picture">
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
            <script src="<?php echo base_url()?>assets/js/form_validation_banners.js<?php echo $global_asset_version; ?>" ></script>
            <!-- END THEME LAYOUT SCRIPTS -->
         </body>
      </html>