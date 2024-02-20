<!DOCTYPE html>
<html lang="en">
<head>
        <?php $this->load->view('common/header_style'); ?>
    
   
         </head>
    <!-- END HEAD -->
        <style type="text/css">
             .form-control-static{font-weight: 800;}
             .form-control-static { padding-top: 0px;}
             .table>tbody>tr>td {  padding: 10px; }
             .dashboard-stat.dashboard-stat-v2 .visual { padding-top: 0px; margin-bottom: 0px; }
             .dashboard-stat .details .number {  padding-top: 10px; }
             .dashboard-stat .details .number { font-size: 25px; }
              @media only screen and (max-width: 480px)
                {
                    .table-responsive {
                        width: 100%;
                        margin-bottom: 15px;
                        overflow-y: hidden;
                        -ms-overflow-style: -ms-autohiding-scrollbar;
                        border: 1px solid #e7ecf1;
                    }
                }
         </style>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <?php $this->load->view('common/header');?>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <?php $this->load->view('common/sidebar');?>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        
                        <div class="page-bar">
                           <?php echo $breadcrumb; ?>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light bordered">
                                 <div class="portlet-title">
                                 
                                      <div class="caption"><?php echo $team_detail['prs_name'] ?>'s Detail <a  href="<?php echo site_url('edit-user-'.$team_detail['prs_username'])?>"><i class="fa fa-edit"></i></a></div>
                                  </div>
                                  <div class="portlet-body form ">
                                      <!-- BEGIN FORM-->
                                          <div class="table-responsive">
                                          <table class="table table table-bordered main-table">
                                            <tbody>
                                              <tr>
                                                <td  style="    background: #F5F5F5;"> Full Name: </td>
                                                <td> <b><?php echo $team_detail['prs_name']?></b> </td>
                                                <td  style="    background: #F5F5F5;"> Mobile: </td>
                                                <td> <a href="tel:<?php echo $team_detail['prs_mob']?>"><b><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $team_detail['prs_mob']?></b></a> </td>
                                               
                                              </tr>
                                              <tr>
                                               
                                                <td  style="background: #F5F5F5;"> Email: </td>
                                                <td> <a href="mailto:<?php echo $team_detail['prs_email']?>" target="_blank"><b> <?php echo $team_detail['prs_email']?></b></a>  </td>
                                                <td  style="background: #F5F5F5;"> Department: </td>
                                                <td><b><?php echo $team_detail['dpt_name']; ?></b></td>
                                              </tr>
                                               <tr>
                                              
                                                <td  style="background: #F5F5F5;"> Username:  </td>
                                                <td> <b><?php echo $team_detail['prs_username']?></b>
                                                 </td>
                                              </tr>
                                              <tr>
                                                <td  style="background: #F5F5F5;"> Address: </td>
                                                <td colspan="3"> <b><?php echo $team_detail['prs_address']?></b> </td>
                                                
                                              </tr>
                                            </tbody>
                                          </table>
                                          </div>
                                       
                                      <!-- END FORM-->
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
               <!--  <?php // $this->load->view('common/rightsidebar');?> -->
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
            <?php $this->load->view('common/footer');?>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN QUICK NAV -->
    
    <?php $this->load->view('common/footer_style');?>
        
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url()?>assets/layouts/layout/scripts/layout.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/layout/scripts/demo.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-sidebar.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-nav.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
       
    </body>
</html>