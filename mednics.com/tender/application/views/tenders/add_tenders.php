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
                                        <span class="caption-subject bold uppercase">Add Tender</span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form class="form-manager" enctype="multipart/form-data" role="form" id="add-form" name="add-form" method="post" action="<?php echo site_url('add-tenders');?>">
                                        <input type="hidden" class="input_count" id="theValue" name="theValue" value="">
                                        <div class="form-body">

                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                        <div class="caption">Basic Info</div>
                                                </div>
                                                <div class="Portlet-body">
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                         <div class="form-group">
                                                            <label for="form_control_1">Name<span style="color:red">*</span></label>
                                                            <input type="text" class="form-control" name="tdr_name" id="tdr_name" value="<?php echo set_value('tdr_name');?>">
                                                            <span class="text-danger"><?php echo form_error('tdr_name');?></span>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                           <div class="form-group">
                                                                <label for="form_control_1">Organisation
                                                                </label>
                                                                <div class="input-group select2-bootstrap-append">
                                                                    <div class="input-group-btn select_width">
                                                                       <button data-toggle="modal" data-target="#add_org" class="form-control">Add New</button>
                                                                    </div>

                                                                     <select id="tdr_organisationid" name="tdr_organisationid" class="form-control organisation-select2 select2" onchange="getContactDetails(this.value);">
                                                                       <option value=''>Select Organisation</option>
                                                                            <?php echo getCombo('select org_id as f1 ,org_name as f2 from tender_organisation')?> 
                                                                    </select>
                                                                    <span class="text-danger"><?php echo form_error('tdr_organisationid');?></span>
                                                                </div>

                                                            </div>
                                                      </div>
                                                   </div>
                                                   <div class="row">
                                                      <div class="col-md-6">
                                                         <div class="form-group">
                                                            <label for="form_control_1">Subject<span style="color:red">*</span></label>
                                                            <input type="text" class="form-control" name="tdr_subject" id="tdr_subject" value="<?php echo set_value('tdr_subject');?>">
                                                            <span class="text-danger"><?php echo form_error('tdr_subject');?></span>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                           <div class="form-group">
                                                                <label for="form_control_1">Contacts
                                                                </label>
                                                                <div class="input-group select2-bootstrap-append">
                                                                    <div class="input-group-btn select_width">
                                                                       <button data-toggle="modal" data-target="#add_cont" class="form-control">Add New</button>
                                                                    </div>

                                                                     <select id="tdr_contacts" name="tdr_contacts" class="form-control contacts-select2">
                                                                        <option></option>
                                                                    </select>
                                                                    
                                                                    <span class="text-danger"><?php echo form_error('tdr_contacts');?></span>

                                                                </div>

                                                            </div>
                                                      </div>
                                                   </div>

                                                   <div class="row">
                                                      <div class="col-md-12">
                                                         <div class="form-group">
                                                            <label for="form_control_1">Terms & Conditions</label>
                                                            <textarea  class="form-control desc_editor" name="tdr_tnc" id="tdr_tnc"><?php echo $terms_n_condition ?></textarea> 
                                                            <span class="text-danger"><?php echo form_error('tdr_tnc');?></span>
                                                         </div>
                                                      </div>
                                                   </div>


                                                </div>
                                            </div>

                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                        <div class="caption">Item Details</div>
                                                </div>
                                                <div class="Portlet-body">
                                                  <div class="row">
                                                    <div class="col-md-1">
                                                    </div>
                                                    <div class="col-md-2">
                                                       <label class="control-label"> Country </label>
                                                        <input type="text" readonly class="form-control" id="country" value="">
                                                    </div>
                                                    <div class="col-md-2">
                                                       <label class="control-label"> Voltage </label>
                                                        <input type="text" readonly class="form-control" id="voltage" value="">
                                                    </div>

                                                    <div class="col-md-2">
                                                       <label class="control-label"> Frequency </label>
                                                        <input type="text" readonly class="form-control" id="frequency" value="">
                                                    </div>

                                                    <div class="col-md-2">
                                                       <label class="control-label"> Plug Type </label>
                                                        <input type="text" readonly class="form-control" id="plug_type" value="">
                                                    </div>

                                                   <div class=" col-md-2">
                                                      <div class="form-group">
                                                         <label class="control-label">Currency</label>
                                                         <select name="tdr_currency" id="tdr_currency"   class="form-control select2">
                                                                <?php echo getCombo('select gen_value as f1 ,gen_name as f2 from tender_gen_prm where status= "'.STATUS_ACTIVE.'" and gen_group = "'.TENDER_PRICE_TYPE.'" ')?> 
                                                          </select>
                                                        <span class="text-danger"><?php echo form_error('org_website');?></span>
                                                      </div>
                                                   </div>
                                                </div>

                                                <hr>

                                                    <div class="row" >
                                                       <div class="col-md-1">
                                                         
                                                          <div class="form-group">
                                                            <label class="control-label hidden-mobile"> <i class="fa fa-star" aria-hidden="true"></i></label>
                                                          </div>
                                                       </div>
                                                       <div class="col-md-6">
                                                           <div class="form-group">
                                                            <label class="control-label hidden-mobile"> Item Name</label>
                                                          </div>
                                                       </div>
                                                       <div class="col-md-1">
                                                          <div class="form-group">
                                                            <label class="control-label hidden-mobile"> Quantity</label>
                                                          </div>
                                                        </div>
                                                       <div class="col-md-1">
                                                          <div class="form-group">
                                                            <label class="control-label hidden-mobile">Price</label>
                                                          </div>
                                                       </div>
                                                       <div class="col-md-1">
                                                          <div class="form-group">
                                                            <label class="control-label hidden-mobile"> Disc. Amt</label>
                                                          </div>
                                                       </div>
                                                       <div class="col-md-2"> 
                                                          <div class="form-group">
                                                            <label class="control-label hidden-mobile"> Total</label>
                                                          </div>
                                                        </div>

                                                    </div>
                                                 <hr>

                                                  <div class="mt-repeater">
                                                    <div data-repeater-list="purordlist">
                                                       <div data-repeater-item class=" mt-repeater-item">

                                                        <div class="row">

                                                            <input type="hidden" class="text" id="tdp_qty_disc" name="tdp_qty_disc" value="">
                                                            <input type="hidden" class="text" id="tdp_indv_disc_direct" name="tdp_indv_disc_direct" value="">
                                                            <input type="hidden" class="text" id="tdp_indv_disc_percent" name="tdp_indv_disc_percent" value="">


                                                            <div class="col-md-1">
                                                               <div class="form-group">
                                                                  <label class="control-label hidden-desktop"> <i class="fa fa-star" aria-hidden="true"></i></label>
                                                                  <a href="javascript:;" data-repeater-delete class="btn btn-danger " onclick="return decreaseprdCount()">
                                                                  <i class="fa fa-close"></i></a>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                               <div class="form-group">
                                                                  <label class="control-label hidden-desktop"> Item Name</label>
                                                                  <select  class="form-control select2"  id="tdp_prd_id" name="tdp_prd_id"  onchange="return get_product_details(this.name)">
                                                                    <option value="">Select Product</option>
                                                                    <?php 
                                                                       echo getCombo("SELECT id as f1,name as f2 FROM products WHERE status = '".STATUS_ACTIVE."' ");
                                                                       ?>
                                                                  </select>
                                                                </div>
                                                                <div class="form-group">
                                                                  <label class="control-label">Description</label>
                                                                  <textarea id="tdp_desc" class="form-control " name="tdp_desc" > </textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                  <label class="control-label">SKU </label>
                                                                  <input type="text" class="form-control" id="tdp_sku" name="tdp_sku">
                                                                  <input type="hidden" name="tdp_name" id="tdp_name">
                                                                </div>
                                                                <div class="form-group">
                                         
                                                                  <input type="radio" class="form-radio" id="tdp_spec_show" checked="checked" name="tdp_spec_show" value="1" onclick="return checkbox_check(this.name)"> <label class="control-label">Show Specification </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                              <div class="form-group">
                                                                <label class="control-label hidden-desktop"> Quantity</label>
                                                                 <input type="text" pattern= "\d*" class="form-control" min="1" id="tdp_quantity" onchange="return get_quantity_discount(this.name);" name="tdp_quantity" value="1">
                                                              </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="form-group">
                                                                  <label class="control-label hidden-desktop"> Price</label>
                                                                  <input type="text" pattern= "\d*" min="1" class="form-control"  id="tdp_price" name="tdp_price" onchange="return calculate_indv_prd_amount(this.name);">
                                                                </div>
                                                                  <button type="button" name="discount_button" onclick="return individual_product_click(this.name);" class="dis_button">Discount (-)</button>
                                                             </div>
                                                              <div class="col-md-1">
                                                                <div class="form-group">
                                                                  <label class="control-label hidden-desktop"> Disc. Amt</label>
                                                                    <input type="text" class="form-control" readonly id="tdp_discount_total_amt" name="tdp_discount_total_amt" value="">
                                                                </div>
                                                             </div>
                                                             <div class="col-md-2"> 
                                                                <div class="form-group">
                                                                  <label class="control-label hidden-desktop"> Total</label>
                                                                  <input type="text" class="form-control" readonly id="tdp_item_total" name="tdp_item_total" value="">
                                                                </div>
                                                              </div>


                                                              <!-- Modal for Individual product discount start -->
                                                              <div id="product_discount_modal" name="product_discount_modal" class="modal fade" role="dialog">
                                                                <div class="modal-dialog modal-md"> 
                                                                  
                                                                  <!-- Modal content-->
                                                                  <div class="modal-content text-center">
                                                                  
                                                                      <div class="modal-header">
                                                                        <button type="button" class="close fa fa-3x" data-dismiss="modal">×</button>
                                                                        <p class="text-left edit-add">Product Discount</p>
                                                                      </div>
                                                                      <div class="modal-body">
                                                                    <table class="table table-hover table-nomargin  table-bordered">
                                                                      <tbody>
                                                                        <tr>
                                                                          <td>
                                                                            <input type="radio" name="zero_prd_discount" onchange="return prd_indv_zero_disc(this.name)"> Zero Discount</td>
                                                                          <td></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td>
                                                                            <input type="radio" name="prd_indv_percent_disc" class="prd_indv_percent_disc" onchange="return prd_indv_percent_disc(this.name)"> % Price</td>
                                                                          <td>
                                                                            <input type="text" id="prd_indv_percent_disc_value" name="prd_indv_percent_disc_value" style="width: 100px;display: none" onblur="return individual_product_discount(this.name,'perct_disc')"> %</td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td>
                                                                            <input type="radio" name="prd_indv_direct_disc" class="prd_indv_direct_disc" onchange="return prd_indv_direct_disc(this.name)"> Direct Price Reduction</td>
                                                                          <td>
                                                                            <input type="text" id="prd_indv_direct_disc_value" name="prd_indv_direct_disc_value" style="width: 100px;display: none" onkeyup="return individual_product_discount(this.name,'dirct_disc')">
                                                                          </td>
                                                                        </tr>
                                                                      </tbody>
                                                                    </table>

                                                                      </div>
                                                                      <div class="modal-footer">
                                                                        <!-- <button type="submit" class="btn">Add</button> -->
                                                                        <button type="button" class="btn " data-dismiss="modal">Close</button>
                                                                      </div>
                                                                   
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <!-- Modal for Individual product discount end -->

                                                          </div>
                                                           <div ><hr></div>
                                                       </div>
                                                     </div>
                                                   
                                                    <div class="row">
                                                      <div class="col-md-1">
                                                         <div class="form-group ">
                                                            <label class="control-label" style="display: block;">&nbsp;</label>
                                                            <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add">
                                                            <i class="fa fa-plus"></i> Add More</a>
                                                         </div>
                                                      </div>
                                                    </div>
                                                  </div>
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
                                                          
                                                                <input readonly type="text" class="form-control" name="tdr_item_total" id="tdr_item_total" value="">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:right"><a data-target="#invoice_discount_modal" role="button" class="btn" data-toggle="modal"><strong style="color:#56AF45"><strong>(-)Discount</strong></strong></a>
                                                            </td>
                                                            <td style="text-align:right">
                                                               <input readonly type="text" class="form-control" name="tdr_discount" id="tdr_discount">
                                                                <input type="hidden" name="tdr_discount_percent" id="tdr_discount_percent">
                                                                <input type="hidden" name="tdr_discounttype" id="tdr_discounttype">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:right"><strong>(+) Shipping &amp; Handling Charges</strong> </td>
                                                            <td style="text-align:right">
                                                                <input type="text" class="form-control" name="tdr_shipping_charges" id="tdr_shipping_charges" placeholder="0" value="0" class="input-xsmall currency" style="text-align:right" data-rule-required="true" onblur="return calculate_invoice_total()">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:right"><strong>(+) Bank Charges</strong>
                                                            </td>
                                                            <td style="text-align:right">
                                                               
                                                                <input type="text" class="form-control" name="tdr_bank_charges" id="tdr_bank_charges" value="0" onblur="return calculate_invoice_total()">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:right">Pre Tax Total</td>
                                                            <td style="text-align:right">
                                                                <input type="text" readonly class="form-control" name="tdr_pretax_total" id="tdr_pretax_total" value="0">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:right"><strong>(+)Tax</strong>
                                                            </td>
                                                            <td style="text-align:right">
                                                               
                                                                <input type="text" name="tdr_tax" class="form-control" id="tdr_tax" value="0" onblur="return calculate_invoice_total()">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:right"><strong>(+) Taxes For Shipping and Handling</strong> </td>
                                                            <td style="text-align:right">
                                                                  <input type="text" name="tdr_tax_shipping_charges" class="form-control" id="tdr_tax_shipping_charges" value="0" onblur="return calculate_invoice_total()">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:right">Adjustment <span>
                                                                <input type="radio" id="add" class ="tdr_adjustment_add_click" onclick="return inv_adjust_type_click('add_adj');"> Add</span><span>
                                                                <input type="radio" id="subtract" class="tdr_adjustment_sub_click"  value="subtract" onclick="return inv_adjust_type_click('sub_adj');"> Subtract</span>
                                                            </td>
                                                            <td style="text-align:right">
                                                                 <input type="hidden" name="tdr_adjustment_type" id="tdr_adjustment_type" >

                                                                <input type="text"  name="tdr_adjustment" id="tdr_adjustment" placeholder="0" value="0" class="currency form-control" style="text-align:right" data-rule-required="true" onblur=" return inv_adjust()">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:right;font-size:20px">Grand Total</td>
                                                            <td style="text-align:right">
                                                               <!--  <div id="ittot6" style="font-size:20px;">0</div> -->
                                                                <input readonly type="text" class="form-control" name="tdr_grandtotal" id="tdr_grandtotal" value="" >
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
                                                            <label for="form_control_1">Additional Info</label>
                                                            
                                                            <textarea class="form-control" name="tdr_addinfo" id="tdr_addinfo"><?php echo set_value('tdr_addinfo');?></textarea>
                                                            <span class="text-danger"><?php echo form_error('tdr_addinfo');?></span>
                                                         </div>
                                                      </div>

                                                       <div class="col-md-12">
                                                         <div class="form-group">
                                                            <label for="form_control_1">Comment</label>
                                                            
                                                            <textarea class="form-control" name="tdr_comment" id="tdr_comment"><?php echo set_value('tdr_comment');?></textarea>
                                                            <span class="text-danger"><?php echo form_error('tdr_comment');?></span>
                                                         </div>
                                                      </div>
                                                   </div>
                                                 </div>
                                            </div>
                                        
                                            <div class="form-actions">
                                                <button type="button" id="calculate_tender" class="btn blue">Calculate </button>
                                                <button type="submit" id="form_submit" class="btn blue" style="display:none">Save</button>
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

<!-- Modal for Invoice  discount start -->
<div id="invoice_discount_modal" name="invoice_discount_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md"> 
    
    <!-- Modal content-->
    <div class="modal-content text-center">
    
        <div class="modal-header">
          <button type="button" class="close fa fa-3x" data-dismiss="modal">×</button>
          <p class="text-left edit-add"> Discount</p>
        </div>
        <div class="modal-body">
      <table class="table table-hover table-nomargin  table-bordered">
        <tbody>
          <tr>
            <td>
              <input type="radio" name="zero_invoice_discount" class="zero_invoice_discount" onchange="return invoice_zero_disc(this.name)"> Zero Discount</td>
            <td></td>
          </tr>
          <tr>
            <td>
              <input type="radio" name="invoice_percent_disc" class="invoice_percent_disc" onchange="return invoice_percent_disc()"> % Price</td>
            <td>
              <input type="text" id="invoice_percent_disc_value" name="invoice_percent_disc_value" style="width: 100px;display: none" onblur="return invoice_disc_value(this.value,'perct_disc')"> %</td>
          </tr>
          <tr>
            <td>
              <input type="radio" name="invoice_direct_disc" class="invoice_direct_disc" onchange="return invoice_direct_disc(this.name)"> Direct Price Reduction</td>
            <td>
              <input type="text" id="invoice_direct_disc_value" name="invoice_direct_disc_value" style="width: 100px;display: none" onkeyup="return invoice_disc_value(this.value,'dirct_disc')">
            </td>
          </tr>
        </tbody>
      </table>

        </div>
        <div class="modal-footer">
          <!-- <button type="submit" class="btn">Add</button> -->
          <button type="button" class="btn " data-dismiss="modal">Close</button>
        </div>
     
    </div>
  </div>
</div>
<!-- Modal for Individual product discount end -->

    <!-- Start of MOdal Pop ups -->
<div id="add_org" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg"> 
    
    <!-- Modal content-->
    <div class="modal-content text-center">
      <form method="post" name="add-org-form" id="add-org-form" enctype="multipart/form-data" >
        <div class="modal-header">
          <button type="button" class="close fa fa-3x" data-dismiss="modal">×</button>
         <!--  <p class="text-left edit-add">Add Organisation</p> -->
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-6">
                 <div class="form-group">
                    <label for="form_control_1">Name<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="org_name" id="org_name" value="<?php echo set_value('org_name');?>">
                    <span class="text-danger"><?php echo form_error('org_name');?></span>
                 </div>
              </div>
              <div class="col-md-6">
                 <div class="form-group">
                     <label for="form_control_1">Primary Email<span style="color:red">*</span></label>
                    <input type="text" class="form-control" name="org_primaryemail" id="org_primaryemail" value="<?php echo set_value('org_primaryemail');?>">
                    <span class="text-danger"><?php echo form_error('org_primaryemail');?></span>
                 </div>
              </div>
           </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_control_1">Billing</label>
                        <textarea class="form-control" name="org_billingadd" id="org_billingadd" data-msg="PLease enter Billing Address" ></textarea>
                        <span class="text-danger"><?php echo form_error('org_billingadd');?></span>
                     </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_control_1">Billing POB</label>
                        <input type="text" class="form-control" name="org_billingpob" id="org_billingpob" value="<?php echo set_value('org_billingpob');?>">
                        <span class="text-danger"><?php echo form_error('org_billingpob');?></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_control_1">Billing City</label>
                        <input type="text" class="form-control" name="org_billingcity" id="org_billingcity" value="<?php echo set_value('org_billingcity');?>">
                        <span class="text-danger"><?php echo form_error('org_billingcity');?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_control_1">Billing State</label>
                        <input type="text" class="form-control" name="org_billingstate" id="org_billingstate" value="<?php echo set_value('org_billingstate');?>">
                        <span class="text-danger"><?php echo form_error('org_billingstate');?></span>
                     </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_control_1">Billing POC</label>
                        <input type="text" class="form-control" name="org_billingpoc" id="org_billingpoc" value="<?php echo set_value('org_billingpoc');?>">
                        <span class="text-danger"><?php echo form_error('org_billingpoc');?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form_control_1">Billing Country</label>
                        <select name="org_billingcountry" id="org_billingcountry" class="form-control select2">
                             <option value=''>Select Country</option>
                              <?php echo getCombo('select tcv_id as f1 ,tcv_country as f2 from tender_country_vol')?> 
                        </select>
                        <span class="text-danger"><?php echo form_error('org_billingcountry');?></span>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn">Add</button>
          <button type="button" class="btn " data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div id="add_cont" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg"> 
    
    <!-- Modal content-->
    <div class="modal-content text-center">
      <form method="post" name="add-cont-form" id="add-cont-form" enctype="multipart/form-data" >
        <div class="modal-header">
          <button type="button" class="close fa fa-3x" data-dismiss="modal">×</button>
          <!--  <p class="text-left edit-add">Add Organisation</p> -->
        </div>
        <div class="modal-body">
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
                      <label for="form_control_1">Last Name<span style="color:red">*</span>
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
            </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn">Add</button>
          <button type="button" class="btn" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


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
  
     <script src="<?php echo base_url()?>assets/global/plugins/jquery-repeater/jquery.repeater.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
       <script src="<?php echo base_url()?>assets/global/plugins/select2/js/select2.full.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
    <script src="<?php echo base_url()?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>

      <script src="<?php echo base_url()?>assets/pages/scripts/form-repeater.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
    <script src="<?php echo base_url()?>assets/pages/scripts/components-select2.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
    
    <script src="<?php echo base_url()?>assets/js/form_validation_tenders.js<?php echo $global_asset_version; ?>"></script>
    <!-- END THEME LAYOUT SCRIPTS -->


</body>
    
</html>