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
                              <?php  $econtacts_id = $this->crm_auth->encrypt_openssl($contacts['cont_id']);?>
                                <div class="caption">Contacts Detail <a  href="<?php echo site_url('edit-contacts-'.$econtacts_id)?>"><i class="fa fa-edit"></i></a></div>
                            </div>
                            <div class="portlet-body detail table-responsive">
                                <table class="table table table-bordered">
                                    <tbody>
                                       
                                        <tr>
                                            <td>Name</td>
                                            <td><?php echo $contacts['salutation']; ?> <?php echo $contacts['cont_name']; ?></td>
                                            <td>Primary Email</td>
                                            <td><?php echo $contacts['cont_primaryemail'];?></td>

                                        </tr> 

                                         <tr>
                                            <td>Secondary Email</td>
                                            <td><?php echo $contacts['cont_secondaryemail']; ?></td>
                                            <td>Organisation</td>
                                            <td><?php echo $contacts['organisation']; ?></td>

                                        </tr> 

                                         <tr>
                                            <td>Primary Number</td>
                                            <td><?php echo $contacts['cont_mobilephone']; ?></td>
                                            <td>Alternate number</td>
                                            <td><?php echo $contacts['cont_altphone'];?></td>

                                        </tr> 

                                         <tr>
                                            <td>Lead Source</td>
                                            <td><?php echo $contacts['lead_source']; ?></td>
                                            <td>Department</td>
                                            <td><?php echo $contacts['cont_department'];?></td>

                                        </tr> 

                                          <tr>
                                            <td>Assigned to</td>
                                            <td><?php echo $contacts['cont_assignedto']; ?></td>
                                            

                                        </tr> 

                                         <tr>
                                            <td>Description</td>
                                            <td><?php echo $contacts['cont_desc']; ?></td>
                                            <td>Comment</td>
                                            <td><?php echo $contacts['cont_comment'];?></td>

                                        </tr> 

                                        <tr>
                                            <td>Created by</td>
                                            <td><?php echo $contacts['createdby']; ?></td>
                                            <td>Updated by</td>
                                            <td><?php echo $contacts['updatedby']; ?></td>
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