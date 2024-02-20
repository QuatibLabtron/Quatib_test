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
                              <?php  $eentities_id = $this->crm_auth->encrypt_openssl($entities['id']);?>
                                <div class="caption">Entities Detail <a  href="<?php echo site_url('edit-entities-'.$eentities_id)?>"><i class="fa fa-edit"></i></a></div>
                            </div>
                            <div class="portlet-body detail table-responsive">
                                <table class="table table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td colspan="3"><?php echo $entities['name']; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Display Name</td>
                                            <td><?php echo $entities['display_name']; ?></td>
                                            <td>Order</td>
                                            <td><?php echo $entities['order']; ?></td>
                                                
                                        </tr> 
                                         <tr>
                                            <td>Use Excels</td>
                                            <td><?php echo $entities['use_excels']; ?></td>
                                            <td>Excel Identifier</td>
                                            <td><?php echo $entities['excel_identifier']; ?></td>
                                                
                                        </tr> 

                                        <tr>
                                            <td>Function After Add</td>
                                            <td><?php echo $entities['function_after_add']; ?></td>
                                            <td>Function After Edit</td>
                                            <td><?php echo $entities['function_after_edit']; ?></td>
                                                
                                        </tr>
                                        <tr>
                                            <td>Function After Delete</td>
                                            <td><?php echo $entities['function_after_delete']; ?></td>
                                          
                                                
                                        </tr> 
                                        <tr>
                                            <td>Views</td>
                                            <td colspan="3"><?php
                                            $json_views = pretty_json_format($entities['views']);
                                             echo $json_views; ?></td>
                                        </tr> 
                                        <tr>
                                            <td>Columns Attributes</td>
                                            <td colspan="3"><?php
                                             $json_attr = pretty_json_format($entities['columns_attributes']);
                                             echo $json_attr;
                                            ?></td>
                                        </tr> 

                                        <tr>
                                            <td>Created by</td>
                                            <td><?php echo $entities['createdby']; ?></td>
                                            <td>Updated by</td>
                                            <td><?php echo $entities['updatedby']; ?></td>
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