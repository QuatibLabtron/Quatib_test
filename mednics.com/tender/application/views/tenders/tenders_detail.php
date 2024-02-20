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
          <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo base_url()?>assets/global/plugins/datatables/datatables.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url()?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
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
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <?php echo $breadcrumb; ?>
                        </div>
                         <div class="portlet bordered light">
                            <div class="portlet-title">
                              <?php  $etenders_id = $this->crm_auth->encrypt_openssl($tenders['tdr_id']);?>
                                <div class="caption">Tenders Detail 
                                  
                                   &nbsp;<a class="popovers" data-container="body"  data-trigger="hover" data-placement="top"  data-content="Edit Tender" href="<?php echo site_url('edit-tenders-'.$etenders_id)?>"><i style="    font-size: 25px;    color: #bc2721;" class="fa fa-edit" aria-hidden="true" title="Edit Tender"></i></a>

                                    &nbsp;<a class="popovers" data-container="body"  data-trigger="hover" data-placement="top"  data-content="Download PDF" href="<?php echo site_url('tenders-pdf-'.$etenders_id.'-'.TENDER_INVOICE_PDF)?>"><i style=" font-size: 25px; color: #bc2721;" class="fa fa fa-file-pdf-o" aria-hidden="true" title="Download PDF"></i></a>

                                   &nbsp;<a class="popovers" data-container="body"  data-trigger="hover" data-placement="top"  data-content="Generate Mail" href="<?php echo site_url('tenders-pdf-'.$etenders_id.'-'.TENDER_INVOICE_PDF_MAIL)?>"><i style="    font-size: 25px;    color: #bc2721;" class="fa fa-envelope" aria-hidden="true" title="Generate Mail"></i></a>


                                   &nbsp;<a class="popovers" data-container="body"  data-trigger="hover" data-placement="top"  data-content="Download Invoice PDF" href="<?php echo site_url('tenders-invoice-pdf-'.$etenders_id.'-'.TENDER_INVOICE_PDF)?>"><i style=" font-size: 25px; color: #279e00;" class="fa fa fa-file-pdf-o" aria-hidden="true" title="Download PDF"></i></a>

                                   &nbsp;<a class="popovers" data-container="body"  data-trigger="hover" data-placement="top"  data-content="Generate Mail" href="<?php echo site_url('tenders-invoice-pdf-'.$etenders_id.'-'.TENDER_INVOICE_PDF_MAIL)?>"><i style="    font-size: 25px;    color: #279e00;" class="fa fa-envelope" aria-hidden="true" title="Generate Invoice Mail"></i></a>
                                  
                                </div>
                            </div>
                            <div class="portlet-title">Basic Info </div>
                           
                            <div class="portlet-body detail table-responsive">
                                <table class="table table table-bordered">
                                    <tbody>
                                        
                                        <tr>
                                            <td>Reference Id</td>
                                            <td><?php echo $tenders['tdr_refid']; ?></td>
                                             <td>Tender Status</td>
                                            <td><?php echo $tenders['tender_status_name']; ?></td>
                                        </tr> 
                                    
                                        <tr>
                                            <td>Name</td>
                                            <td><?php echo $tenders['tdr_name']; ?></td>
                                            <td>Subject</td>
                                            <td><?php echo $tenders['tdr_subject']; ?></td>

                                        </tr> 
                                        <tr>
                                             <td>Organisation</td>
                                             <?php 
                                                $organisation_id = $this->crm_auth->encrypt_openssl($tenders['tdr_organisationid']);
                                                $contact_id = $this->crm_auth->encrypt_openssl($tenders['tdr_contacts']);
                                              ?>
                                            <td><a target="_blank" href="<?php echo base_url().'organisations-detail-'.$organisation_id ?>"><?php echo $tenders['organisation'];?></a></td>
                                            <td>Contact</td>
                                            <td><a target="_blank" href="<?php echo base_url().'contacts-detail-'.$contact_id ?>"><?php echo $tenders['contact_name'];?></a></td>
                                        </tr> 
                                        <tr>
                                            <td>Terms and condition</td>
                                            <td colspan="3"><?php echo $tenders['tdr_tnc']; ?></td>
                                        </tr> 
                                        <tr>
                                            <td>Created by</td>
                                            <td><?php echo $tenders['createdby']; ?></td>
                                            <td>Updated by</td>
                                            <td><?php echo $tenders['updatedby']; ?></td>
                                        </tr>

                                       
                                    </tbody>    
                                </table>
                            </div>
                        </div>

                        <div class="portlet bordered light">
                           <div class="portlet-title">&nbsp;Item Details </div>
                           
                            <div class="portlet-body">
                            
                                <div class="row">
                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-2">
                                       <label class="control-label"> Country </label>
                                    </div>
                                    <div class="col-md-2">
                                       <label class="control-label"> Voltage </label>
                                    </div>

                                    <div class="col-md-2">
                                       <label class="control-label"> Frequency </label>
                                    </div>

                                    <div class="col-md-2">
                                       <label class="control-label"> Plug Type </label>
                                    </div>

                                   <div class="col-md-2">
                                         <label class="control-label">Currency</label>
                                   </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-2 ">
                                         <label class="control-label"> <?php echo $tenders['country']; ?> </label>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label"> <?php echo $tenders['voltage']; ?> </label>
                                    </div>

                                    <div class="col-md-2">
                                         <label class="control-label"> <?php echo $tenders['frequency']; ?> </label>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="control-label"> <?php echo $tenders['plug_type']; ?></label>
                                    </div>

                                   <div class="col-md-2">
                                          <label class="control-label"><?php echo get_gen_name($tenders['tdr_currency'],TENDER_PRICE_TYPE) ?></label>
                                   </div>
                                </div>

                            </div>
                        </div>

                        <div class="portlet bordered light">
                            
                            <div class="portlet-body detail table-responsive">
                                
                                <table class="table table-hover table-nomargin table-bordered" role="grid">
                                    <thead>
                                        <tr role="row">
                                        <th >Sr no.</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Discount Total</th>
                                        <th >Net Price</th>
                                        </tr>
                                    </thead>
                                    <?php if(isset($tender_product) && $tender_product !='' && !empty($tender_product)) {
                                            $i = 0; ?>
                                    <tbody class="tender_details">
                                        <?php foreach ($tender_product as $key => $tenderproduct) { 
                                            $i++;?>
                                        
                                        <tr role="row" class="tr_details">
                                            <th> <?php echo $i ?></th>
                                            <th>
                                               <div class="control-group">
                                                  <div class="controls">
                                                     <label><strong> <?php echo $tenderproduct['tdp_name'] ?> </strong>
                                                     </label> <hr>
                                                     <label> <?php echo $tenderproduct['tdp_desc'] ?> </label>

                                                     <hr>
                                                     Catalog :
                                                        <a target="new" href="<?php echo bsnprm_value(BSN_WEBSITE_LINK).'catalog/'.$tenderproduct['tdp_sku'] ?>"><?php echo $tenderproduct['tdp_name'] ?>.pdf  </a>
                                                     <br>
                                                     <label>
                                                        Show Specification - <?php echo get_gen_name($tenderproduct['tdp_spec_show'],YES_NO_OPTION) ?> </label>
                                                  </div>
                                               </div>
                                            </th >
                                            <th>
                                               <label>  <?php echo $tenderproduct['tdp_quantity'] ?> </label>
                                            </th>
                                            <th>
                                               <div>
                                                  <label><?php echo $tenderproduct['tdp_price'] ?>  </label>
                                               </div>
                                               
                                            </th>
                                            <th>
                                               <label> <?php echo $tenderproduct['tdp_discount_total_amt'] ?> </label>
                                               
                                            </th>
                                            <th>
                                               <label> <?php echo $tenderproduct['tdp_item_total'] ?> </label>
                                            </th>
                                            
                                        </tr>
                                    <?php } ?>
                                  </tbody>
                              <?php } ?>
                               </table>
                            </div>
                        </div>

                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                    <div class="caption">Totals</div>
                            </div>
                            <div class="Portlet-body">
                              <!-- Totals of overall Invoice start -->
                                <div class="row">
                                  <table class="table table-hover table-nomargin table-bordered">
                                    <tbody><tr>
                                        <td style="text-align:right">Items Total</td>
                                        <td style="text-align:right">
                                                <?php echo $tenders['tdr_item_total'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right"><strong style="color:#56AF45"><strong>(-)Discount</strong></strong>
                                        </td>
                                        <td style="text-align:right">
                                           <?php echo $tenders['tdr_discount'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right"><strong>(+) Shipping &amp; Handling Charges</strong> </td>
                                        <td style="text-align:right">
                                            <?php echo (isset($tenders['tdr_shipping_charges']))?$tenders['tdr_shipping_charges']:'As Applicable'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right"><strong>(+) Bank Charges</strong>
                                        </td>
                                        <td style="text-align:right">
                                           <?php echo $tenders['tdr_bank_charges'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right">Pre Tax Total</td>
                                        <td style="text-align:right">
                                           <?php echo $tenders['tdr_pretax_total'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right"><strong>(+)Tax</strong></a>
                                        </td>
                                        <td style="text-align:right">
                                            <?php echo $tenders['tdr_tax'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right"><strong>(+) Taxes For Shipping and Handling</strong> </td>
                                        <td style="text-align:right">
                                              <?php echo $tenders['tdr_tax_shipping_charges'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right"> <strong>(<?php echo (($tenders['tdr_adjustment_type'] == SUB_ADJUSTMENT_TYPE))?'-':'+' ?>)Adjustment </strong> <span>
                                        
                                        </td>
                                        <td style="text-align:right">
                                           <?php echo $tenders['tdr_adjustment'] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:right;font-size:20px">Grand Total</td>
                                        <td style="text-align:right">
                                            <?php echo $tenders['tdr_grandtotal'] ?>
                                        </td>
                                    </tr>
                                </tbody></table>
                              </div>
                              <!-- Totals of overall Invoice end -->
                            </div>
                          </div>
                          <div class="portlet light bordered">
                              <div class="portlet-title">
                                      <div class="caption">Extra Info</div>
                              </div> 

                                <div class="row">
                                  <div class="col-md-12">
                                     <div class="form-group"> 
                                        <label for="form_control_1">Additional Info :&nbsp; </label>
                                        <label for="form_control_1"><?php echo $tenders['tdr_addinfo'] ?></label>
                                        
                                     </div>
                                  </div>

                                   <div class="col-md-12">
                                     <div class="form-group">
                                        <label for="form_control_1">Comment :&nbsp;</label>
                                        <label for="form_control_1"><?php echo $tenders['tdr_comment'] ?></label>
                                     </div>
                                  </div>
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
        <!-- END THEME LAYOUT SCRIPTS -->
      
        
    </body>

</html>