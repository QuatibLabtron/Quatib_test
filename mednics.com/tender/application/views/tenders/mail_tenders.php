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
<style type="text/css">
    .select_width 
    {
        width: 18%;
    }
      .dis_button{
    color: green;
    background: #ffffff;
    border:2px solid green;
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
                                        <span class="caption-subject bold uppercase">Mail Tender</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-manager" enctype="multipart/form-data" role="form" id="send-email-form" name="send-email-form" method="post" action="<?php echo site_url('send-email-tenders-'.$tender_id);?>">
                                     
                                     <input type="hidden" name="tde_tdr_refid" id="tde_tdr_refid" value="<?php echo $tenders['tdr_refid']; ?>">
                                     <input type="hidden" name="tde_tdr_invoice_number" id="tde_tdr_invoice_number" value="<?php echo $tenders['tdr_invoice_number']; ?>">
                                        <div class="form-body">

                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                        <div class="caption">Basic Info</div>
                                                </div>
                                                <div class="Portlet-body">
                                                    <div class="row">
                                                      <div class="col-md-12">
                                                         <div class="form-group">
                                                            <label for="form_control_1">Email Address<span style="color:red">*</span></label>
                                                            <input type="text" class="form-control" name="tde_to" id="tde_to" value="<?php echo ($tenders['organisation_email']!= '')?$tenders['organisation_email']:$tenders['contact_email']; ?>">
                                                            <span class="text-danger"><?php echo form_error('tde_to');?></span>
                                                         </div>
                                                      </div>
                                                     
                                                   </div>
                                                   <div class="row">
                                                      <div class="col-md-12">
                                                         <div class="form-group">
                                                            <label for="form_control_1">CC</label>
                                                            <input type="text" class="form-control" name="tde_cc" id="tde_cc" value="<?php echo bsnprm_value(BSN_WEBSITE_EMAIL_ADDRESS);?>">
                                                            <span class="text-danger"><?php echo form_error('tde_cc');?></span>
                                                         </div>
                                                      </div>
                                                   </div>

                                                   <div class="row">
                                                      <div class="col-md-12">
                                                         <div class="form-group">
                                                            <label for="form_control_1">BCC</label>
                                                            <input type="text" class="form-control" name="tde_bcc" id="tde_bcc" value="<?php echo set_value('tde_bcc');?>">
                                                            <span class="text-danger"><?php echo form_error('tde_bcc');?></span>
                                                         </div>
                                                      </div>
                                                   </div>

                                                     <div class="row">
                                                      <div class="col-md-12">
                                                         <div class="form-group">
                                                            <label for="form_control_1">Subject<span style="color:red">*</span></label>
                                                            <input type="text" class="form-control" name="tde_subject" id="tde_subject" value="<?php echo $tenders['tdr_subject']; ?>">
                                                            <span class="text-danger"><?php echo form_error('tde_subject');?></span>
                                                         </div>
                                                      </div>
                                                   </div>



                                                   <div class="row">
                                                      <div class="col-md-12">
                                                         <div class="form-group">
                                                            <label for="form_control_1">
                                                            Message<span style="color:red">*</span></label>
                                                            <textarea  class="form-control desc_editor" name="tde_content" id="tde_content">
                                                                <p>Dear <?php echo $tenders['contact_name'];?>,</p>
                                                                <p>Thank you for sharing your requirements with us.</p>
                                                                <p>Kindly find the Proforma Invoice for
<?php 
$product_name_a = array();
$product_name = '';
$product_catalog = '';
if(isset($tender_product) && $tender_product !='' && !empty($tender_product)) 
{ 
    foreach ($tender_product as $key => $tenderproduct) 
    { 
        $product_name_a[] = $tenderproduct['tdp_name'];
        $catalog = catalog_url_helper($tenderproduct['tdp_sku']);
        $product_catalog .= '<li>'.$tenderproduct['tdp_name'].' : <a href = " '.bsnprm_value(BSN_WEBSITE_LINK).$catalog.' " target= "_blank" >'.bsnprm_value(BSN_WEBSITE_LINK).$catalog.'</a> </li>';
    }
}  
$product_name = implode(' , ', $product_name_a);
?>
                                                                <strong><?php echo $product_name; ?></strong> you enquired for.</p>
                                                                <p>Please download the product catalogue from this link for more product details:</p>
                                                                <ul><?php echo $product_catalog; ?></ul>
                                                                <p>We look forward to discussing this project with you in more detail at the earliest.</p>
                                                                <p>Best Regards,
                                                                <br><strong><?php echo $this->session->userdata('prs_name'); ?></strong> | Product Specialist
                                                                <br>Email: <?php echo $this->session->userdata('prs_email'); ?>
                                                                <br>Website: <a href="<?php echo bsnprm_value(BSN_WEBSITE_LINK) ?>" target="_blank"><?php echo rtrim(bsnprm_value(BSN_WEBSITE_LINK), "/"); ?></a></p></textarea> 
                                                            <span class="text-danger"><?php echo form_error('tde_contents');?></span>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="row">
                                                      <div class="col-md-12">
                                                         <div class="form-group">
                                                            <label for="form_control_1"><strong>Tender PDF : <strong></label>
                                                            <label for="form_control_1"> <a href="<?php echo bsnprm_value(BSN_WEBSITE_LINK).SAVE_PDF_LINK.$reference_number ?>.pdf "> <?php echo $reference_number ?>.pdf</a></label>
                                                           
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                            </div>

                                          <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                      <div class="caption">Extra Info</div>
                                              </div> 
                                               <div class="Portlet-body">
                                                <div class="row">
                                                  <div class="col-md-12">
                                                     <div class="form-group">
                                                        <label for="form_control_1"><strong>Additional Files : <strong></label>
                                                         <input type="file" class="form-control" name="files[]" id="tde_attachment"  multiple >
                                                        <span class="text-danger"><?php echo form_error('tde_attachment');?></span>
                                                     </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <div class="col-md-12">
                                                     <div class="form-group">
                                                        <label for="form_control_1">Comment</label>
                                                        
                                                        <textarea class="form-control" name="tde_comment" id="tde_comment"><?php echo set_value('tde_comment');?></textarea>
                                                        <span class="text-danger"><?php echo form_error('tde_comment');?></span>
                                                     </div>
                                                  </div>
                                               </div>
                                                
                                              </div>
                                            </div>
                                        
                                            <div class="form-actions">
                                                <button type="submit" id="form_submit" class="btn blue">Send</button>
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
  
    <script src="<?php echo base_url()?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>


    <script src="<?php echo base_url()?>assets/js/form_validation_tenders.js<?php echo $global_asset_version; ?>"></script> 
    <!-- END THEME LAYOUT SCRIPTS -->


</body>
    
</html>