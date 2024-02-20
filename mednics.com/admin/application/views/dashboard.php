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
    <link href="<?php echo base_url()?>assets/global/plugins/datatables/datatables.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    
    <style type="text/css">
      @media only screen and (max-width: 480px)
      {
        .widget-thumb .widget-thumb-heading{    font-size: 10px;margin: 0 0 10px;    color: #444444;}
        .widget-thumb{padding: 10px;}
        .widget-thumb.bordered{    border: 1px solid #979797;}
      }
    </style>
</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <div class="page-wrapper">
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
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <span>Dashboard</span>
                            </li>
                        </ul>
                    </div>
                    <div style="margin-top:15vh;text-align:center;">
                      <div class="row">
                        
                       
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
		
  <!-- BEGIN PAGE LEVEL PLUGINS --> 
  <script src="<?php echo base_url()?>assets/global/scripts/datatable.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/global/plugins/datatables/datatables.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>      
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN THEME GLOBAL SCRIPTS -->
  <script src="<?php echo base_url()?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
  <!-- END THEME GLOBAL SCRIPTS -->
  <!-- BEGIN PAGE LEVEL PLUGINS -->
  <script src="<?php echo base_url()?>assets/pages/scripts/table-datatables-rowreorder.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN THEME LAYOUT SCRIPTS -->
  <script src="<?php echo base_url()?>assets/layouts/layout/scripts/layout.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/layouts/layout/scripts/demo.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-sidebar.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
  <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-nav.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>


 
</body>

    </html>