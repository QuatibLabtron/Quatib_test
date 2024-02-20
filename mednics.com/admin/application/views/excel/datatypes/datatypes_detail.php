<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
	
        <?php $this->load->view('common/header_style')?>  
		 
        <!-- BEGIN LEVEL STYLES -->       
      <link href="<?php echo base_url()?>assets/pages/css/profile.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
		 
        <!-- END PAGE LEVEL STYLES -->
        
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
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <?php echo $breadcrumb; ?>
                        </div>
                         <div class="portlet bordered light">
                            <div class="portlet-title">
                              <?php  $edatatypes_id = $this->crm_auth->encrypt_openssl($datatypes['id']);?>
                                <div class="caption">Data Types Detail <a  href="<?php echo site_url('edit-datatypes-'.$edatatypes_id)?>"><i class="fa fa-edit"></i></a></div>
                            </div>
                            <div class="portlet-body detail table-responsive">
                                <table class="table table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td colspan="3"><?php echo $datatypes['name']; ?></td>
                                          
                                        </tr>

                                        <tr>
                                            <td>Table column type</td>
                                            <td><?php echo $datatypes['table_column_type']; ?></td>
                                            <td>Type</td>
                                            <td><?php echo $datatypes['type']; ?></td>
                                                
                                        </tr> 
                                         <tr>
                                            <td>Lowest Limit</td>
                                            <td><?php echo $datatypes['lowest_limit']; ?></td>
                                            <td>highest limit</td>
                                            <td><?php echo $datatypes['highest_limit']; ?></td>
                                                
                                        </tr> 

                                        <tr>
                                            <td>Decimal Places</td>
                                            <td><?php echo $datatypes['decimal_places']; ?></td>
                                            <td>Length</td>
                                            <td><?php echo $datatypes['length']; ?></td>
                                                
                                        </tr> 

                                        <tr>
                                            <td>Created by</td>
                                            <td><?php echo $datatypes['createdby']; ?></td>
                                            <td>Updated by</td>
                                            <td><?php echo $datatypes['updatedby']; ?></td>
                                        </tr>

                                       
                                    </tbody>    
                                </table>
                            </div>
                        </div>
                      </div>
                      <!-- END PROFILE CONTENT --> 
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
           <?php $this->load->view('common/footer')?> 
            <!-- END FOOTER -->
        </div>
		 <?php $this->load->view('common/footer_style')?> 
        
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url()?>assets/layouts/layout/scripts/layout.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/layout/scripts/demo.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-sidebar.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-nav.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
		
    </body>

</html>