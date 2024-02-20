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
                                        <span class="caption-subject bold uppercase">Update Meta Data</span>
                                     </div>
                                  </div>
                                  <div class="portlet-body form">
                                     <form class="form-manager" enctype="multipart/form-data" role="form" id="add-form" name="add-form" method="post" action="<?php echo site_url('add-seo');?>">
                                        <div class="form-body">
                                           <div class="row">
                                              
                                           
                                           <div class="row">
                                              <div class="col-md-12">
                                                 <div class="form-group">
                                                    <label for="Product">Products List</label>
													  <select id="productid" name="productid" class="form-control organisation-select2 select2" onchange="getseolist(this.value);">
                                                                       <option value=''>Select Organisation</option>
                                                                           <?php echo getCombo("SELECT name as f2,id as f1 FROM products where status=".STATUS_ACTIVE." ",!empty($categories['id'])?$categories['id']:"" );?>  
                                                                    </select>
                                                     <span class="text-danger"><?php echo form_error('productid');?></span>
                                                 </div>
                                              </div>
											  <div class="col-md-12">
                                                 <div class="form-group">
                                                    <label for="meta_title">Meta Title</label>
                                                    <input type="text" class="form-control" name="meta_title" id="meta_title" value="<?php echo !empty($categories['meta_title'])?$categories['meta_title']:set_value('meta_title');?>">
                                                    <span class="text-danger"><?php echo form_error('meta_title');?></span>
                                                 </div>
                                              </div>
                                              <div class="col-md-12">
                                                 <div class="form-group">
                                                    <label for="meta_keyword">Meta Keyword</label>
                                                    <input type="text" class="form-control" name="meta_keyword" id="meta_keyword" value="<?php echo !empty($categories['meta_keyword'])?$categories['meta_keyword']:set_value('meta_keyword');?>">
                                                    <span class="text-danger"><?php echo form_error('meta_keyword');?></span>
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="row">
                                              <div class="col-md-12">
                                                 <div class="form-group">
                                                    <label for="meta_description">Meta Description</label>
                                                    <textarea class="form-control" name="meta_description" id="meta_description"><?php echo !empty($categories['meta_description'])?$categories['meta_description']:set_value('meta_description');?></textarea>
                                                    <span class="text-danger"><?php echo form_error('meta_description');?></span>
                                                 </div>
                                              </div>
                                           </div>
                                           <div class="form-actions">
                                              <button type="submit" id="form_submit" class="btn blue">Update</button>
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
            <script src="<?php echo base_url()?>assets/js/form_validation_pages.js<?php echo $global_asset_version; ?>" ></script>
            <!-- END THEME LAYOUT SCRIPTS -->
			
			  <script type="text/javascript">
       
            function getseolist(val)
            {
           
      
          var url = val; // get selected value
          if (url) { // require a URL
              window.location = "add-seo-"+url; // redirect
          }
          return false;
      
    
           
            }
    </script>
         </body>
      </html>