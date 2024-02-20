<?php
   if($this->session->userdata('prs_id')==''){
      $abc = base_url();
        echo '<script> ';
          echo 'window.location="'.$abc.'"';
        echo '</script>';
    }   
?>

<!DOCTYPE html>

<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
         <?php $this->load->view('common/header_style'); ?> 
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
                       
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?php echo site_url('dashboard')?>">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Form Access</span>
                                </li>
                            </ul>
                           
                        </div>
                        <!-- END PAGE BAR -->
                        <!-- BEGIN PAGE TITLE-->
                        <?php
                            $dept_id = $this->session->userdata('prs_dpt_id');
                             if($dept_id == ADMIN_DEPARTMENT){
                        ?>
                          <form class="horizontal-form" id="" method="post" action="">

                            <h3 class="page-title">  
                                <label class="col-md-2 control-label" for="form_control_1">Employee</label>
                                    <div class="input-group col-md-6">
                                        <div class="input-group-control ">
                                           <select class="form-control " name="USR_id" id="USR_id"><option value="">Please Select</option>
                                           <?php 
                                               echo getCombo("select  prs_id as f1,  prs_name as f2  FROM `adm_person`  where status=".STATUS_ACTIVE." order by f1"); ?>
                                           </select>
                                            <div class="form-control-focus"> </div>
                                        </div>
                                        <span class="input-group-btn btn-right">
                                           <button class="btn green-haze dropdown-toggle" type="button" onclick=" return getReport()">GO</button>
                                        </span>
                                    </div>       
                            </h3>

                            <!-- END PAGE TITLE-->
                            <!-- END PAGE HEADER-->
                           
                            <div class="row" >
                                <div class="col-md-12" id="results">
                                   
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" id="main_result">
                                    
                                </div>
                                <!-- END SAMPLE FORM PORTLET-->
                            </div>
                        </form>
                        <?php } else{  ?>
                            <h3> Sorry you are not authorized to access this page </h3>
                        <?php } ?>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
                <a href="javascript:;" class="page-quick-sidebar-toggler">
                    <i class="icon-login"></i>
                </a>
              
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
           <?php $this->load->view('common/footer'); ?>
    </div>       
        <!-- END FOOTER -->
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
        <script src="<?php echo base_url();?>assets/js/form_access.js<?php echo $global_asset_version; ?>"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>