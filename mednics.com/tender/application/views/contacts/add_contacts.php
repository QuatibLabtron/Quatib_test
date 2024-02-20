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
<style type="text/css">
.select_width {
    width: 18%;
}
</style>
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
                                        <span class="caption-subject bold uppercase">Add Contacts</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-manager" enctype="multipart/form-data" role="form" id="add-form" name="add-form" method="post" action="<?php echo site_url('add-contacts');?>">
                                        <div class="form-body">
                                            <div class="portlet light bordered">
                                                <div class="Portlet-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">Type</label>
                                                                <select name="cont_type" id="cont_type" class="form-control select2">
                                                                    <!--  <option value=''>Select Currency</option> -->
                                                                    <?php echo getCombo('select gen_value as f1 ,gen_name as f2 from tender_gen_prm where status= "'.STATUS_ACTIVE.'" and gen_group = "'.TENDER_CONTACT_TYPE.'" ')?>
                                                                </select>
                                                                <span class="text-danger"><?php echo form_error('cont_type');?></span>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">First Name<span style="color:red">*</span>
                                                                </label>
                                                                <div class="input-group select2-bootstrap-append">
                                                                    <div class="input-group-btn select_width">
                                                                        <select id="cont_sal" name="cont_sal" class="form-control select2">
                                                                            <?php echo getCombo('select gen_value as f1 ,gen_name as f2 from tender_gen_prm where status= "'.STATUS_ACTIVE.'" and gen_group = "'.TENDER_SALUTION.'" ')?>
                                                                        </select>
                                                                    </div>

                                                                    <input type="text" class="form-control text-file" name="cont_firstname" id="cont_firstname" value="<?php echo set_value('cont_firstname');?>">
                                                                    <span class="text-danger"><?php echo form_error('cont_firstname');?></span>

                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">Last Name
                                                                </label>
                                                                <input type="text" class="form-control" name="cont_lastname" id="cont_lastname" value="<?php echo set_value('cont_lastname');?>">
                                                                <span class="text-danger"><?php echo form_error('cont_lastname');?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">Primary Email<span style="color:red">*</span>
                                                                </label>
                                                                <input type="text" class="form-control" name="cont_primaryemail" id="cont_primaryemail" value="<?php echo set_value('cont_primaryemail');?>">
                                                                <span class="text-danger"><?php echo form_error('cont_primaryemail');?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">Secondary Email</label>
                                                                <input type="text" class="form-control" name="cont_secondaryemail" id="cont_secondaryemail" value="<?php echo set_value('cont_secondaryemail');?>">
                                                                <span class="text-danger"><?php echo form_error('cont_secondaryemail');?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">Primary Phone</label>
                                                                <input type="text" class="form-control" name="cont_mobilephone" id="cont_mobilephone" value="<?php echo set_value('cont_mobilephone');?>">
                                                                <span class="text-danger"><?php echo form_error('cont_mobilephone');?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">Alternate phone</label>
                                                                <input type="text" class="form-control" name="cont_altphone" id="cont_altphone" value="<?php echo set_value('cont_altphone');?>">
                                                                <span class="text-danger"><?php echo form_error('cont_altphone');?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">Department</label>
                                                                <input type="text" class="form-control" name="cont_department" id="cont_department" value="<?php echo set_value('cont_department');?>">
                                                                <span class="text-danger"><?php echo form_error('cont_department');?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">Lead Source</label>
                                                                <select name="cont_leadsource" id="cont_leadsource" class="form-control select2">
                                                                    <!--  <option value=''>Select Currency</option> -->
                                                                    <?php echo getCombo('select gen_value as f1 ,gen_name as f2 from tender_gen_prm where status= "'.STATUS_ACTIVE.'" and gen_group = "'.TENDER_LEAD_SOURCE.'" ')?>
                                                                </select>
                                                                <span class="text-danger"><?php echo form_error('cont_leadsource');?></span>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <?php $person_id = $this->session->userdata('prs_id'); ?>
                                                    <input type="hidden" name="cont_assignedid" id="cont_assignedid" value="<?php echo $person_id ?>">


                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">Assigned To</label>
                                                                <select name="cont_assignedto" id="cont_assignedto" class="form-control" readonly>
                                                                    <!--  <option value=''>Select Currency</option> -->
                                                                    <?php echo getCombo('select prs_username as f1 ,prs_name as f2 from tender_person where status= "'.STATUS_ACTIVE.'" and prs_id = "'.$person_id.'" ')?>
                                                                </select>
                                                                <span class="text-danger"><?php echo form_error('cont_assignedto');?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">Organisation</label>
                                                                <select name="cont_orgid" id="cont_orgid" class="form-control select2">
                                                                    <?php echo getCombo('select org_id as f1 ,org_name as f2 from tender_organisation where status= "'.STATUS_ACTIVE.'" ')?>
                                                                </select>
                                                                <span class="text-danger"><?php echo form_error('cont_orgid');?></span>
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
                                                                <textarea class="form-control" name="cont_desc" id="cont_desc" data-msg="PLease enter Description"></textarea>
                                                                <span class="text-danger"><?php echo form_error('cont_desc');?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="form_control_1">Comment</label>
                                                                <textarea class="form-control" name="cont_comment" id="cont_comment" data-msg="Please enter Comment"></textarea>
                                                                <span class="text-danger"><?php echo form_error('cont_comment');?></span>
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
    <script src="<?php echo base_url()?>assets/js/form_validation_contacts.js<?php echo $global_asset_version; ?>"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>