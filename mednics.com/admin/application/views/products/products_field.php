<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <?php $this->load->view('common/header_style'); ?>  
		
        <!-- BEGIN PAGE LEVEL PLUGINS -->
       
        <!-- END PAGE LEVEL PLUGINS -->
       
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
                                <div class="portlet light bordered">
                                  
                                    <div class="portlet-title">
                                        <span class="caption-subject bold uppercase font-orange">Product Fields </span>
                                       
                                       <!--  <a href="<?php //echo site_url('add-products')?>" class="btn btn green"><i class="fa fa-plus"></i> Add Products</a>  -->

                                         <a class="btn btn green"  data-toggle="modal" data-target="#modalLoginForm"><i class="fa fa-plus"></i> Add Fields</a>
                                         
                                       <!--  <div class="tools"> </div> -->
                                    </div>
                                   
                                    <div class="portlet-body">
                                        <form method="post" enctype="multipart/form-data" id="frmListing">
                                            <table class="table table-striped table-bordered table-hover products-list" id="sample_1">
                                                <thead>
                                                    <tr>
                                                      
                                                        <th> Name </th> 
                                                         
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                   <?php if(isset($product_field) && $product_field != ''){
                                                     foreach($product_field as $productfield){

                                                            ?> 
                                                      <tr>
                                                        <td>
                                                         
                                                          <?php echo $productfield['Field'] ?>
                                                        
                                                        </td>
                                                        </tr>
                                                        <?php }} ?>
                                                </tbody>
                                            </table>
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

            <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Add New field</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="form-manager" enctype="multipart/form-data" role="form" id="add-form" name="add-form" method="post" action="<?php echo site_url('add-products-field');?>">
                    <div class="modal-body mx-3">
                      <div class="md-form mb-5">
                         <label data-error="wrong" data-success="right" for="defaultForm-email"><strong>Name (eg: optional_accessories) </strong></label> 
                        <input type="text" id="field_name" name="field_name" required="required" class="form-control validate">
                      </div>

                       <div class="md-form mb-5">
                         <label data-error="wrong" data-success="right" for="defaultForm-email"><strong>Tab Name  (eg : Optional Accessories)</strong></label> 
                        <input type="text" id="field_name" name="field_tab_name" required="required" class="form-control validate">
                      </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                      <button class="btn btn-default" type="submit">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- BEGIN FOOTER -->
           <?php $this->load->view('common/footer'); ?> 
            <!-- END FOOTER -->
        </div>
			<?php $this->load->view('common/footer_style'); ?> 
        <!-- BEGIN PAGE LEVEL PLUGINS --> 
      
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url()?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url()?>assets/layouts/layout/scripts/layout.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/layout/scripts/demo.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-sidebar.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-nav.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
       

    </body>
   
</html>