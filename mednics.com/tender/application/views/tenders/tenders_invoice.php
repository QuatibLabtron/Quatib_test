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
              								<div style="height:150px;background:#F5F5F5" class="text-center">
              									<!--<h2>Invoice Letter Head Space</h2>-->
              									<img height="145" src="<?php echo base_url().'assets/images/logo.jpg'?>" class="img-reponsive">
              								</div>
                            </div>
                            <div class="portlet-body detail table-responsive">
              								
              								<div class="col-md-12" style="margin-bottom:50px">
              									<h2 class="text-center" style="height:50px;background:#F5F5F5;padding:5px">Proforma Invoice</h2>
              									<div class="col-md-3">
              										<h4><b>Contact Name :</b> Mosaic</h4>
              										<h4><b>Organisation :</b> <?php echo $tenders['organisation'];?></h4>
              									</div>
              									<div class="col-md-6"></div>
              									<div class="col-md-3">
              										<h4><b>Invoice No :</b> <?php echo $tenders['tdr_contacts'];?></h4>
              										<h4><b>Date :</b> <?php echo date("d/m/Y"); ?></h4>
              									</div>
              								</div>
              								
              								<br><br>
              								<table class="table table-bordered">
              									<thead>
              										<tr>
              											<th>Sr. No</th>
              											<th>Description</th>
              											<th>Unit Price (USD $)</th>
              											<th>Qty</th>
              											<th>Discount(-)</th>
              											<th>Total Price (USD $)</th>
              										</tr>
              									</thead>
              									<tbody>
              										 
              										<tr>
              											<td>1</td>
              											<td>
              												<h3 class="text-center">Aneroid BP Apparatus ABP-1000A</h3>
              												<ul>
              													<li>Display : 59.5 mm ID manometer</li>
              													<li>Measurement Method : Oscillometric</li>
              													<li>NIBP Measurement : 0 mmHg ~ 300 mmHg</li>
              													<li>Material : Nickel plated construction with zinc-alloy handle</li>
              												</ul>
              											</td>
              											<td>690.00</td>
              											<td>1</td>
              											<td>100.00</td>
              											<td>590.00</td>
              										</tr>
              										<tr>
              											<td>2</td>
              											<td>
              												<h3 class="text-center">Aneroid BP Apparatus ABP-1000A</h3>
              												<ul>
              													<li>Display : 59.5 mm ID manometer</li>
              													<li>Measurement Method : Oscillometric</li>
              													<li>NIBP Measurement : 0 mmHg ~ 300 mmHg</li>
              													<li>Material : Nickel plated construction with zinc-alloy handle</li>
              												</ul>
              											</td>
              											<td>1000.00</td>
              											<td>2</td>
              											<td>200.00</td>
              											<td>1800.00</td>
              										</tr>
              										<tr class="text-center">
              											<td colspan="5"><b>Sub Total :</b></td>
              											<td>2390.00</td>
              										</tr>
              										<tr class="text-center">
              											<td colspan="5"><b>Discount (-) :</b></td>
              											<td>100.00</td>
              										</tr>
              										<tr class="text-center">
              											<td colspan="5"><b>Packing, Forwarding & Shipping Charges :</b></td>
              											<td>As Applicable</td>
              										</tr>
              										<tr class="text-center">
              											<td colspan="5"><b>Bank Charges :</b></td>
              											<td>30.00</td>
              										</tr>
              										<tr class="text-center">
              											<td colspan="5"><b>GRAND TOTAL(USD $) :</b></td>
              											<td>2260.00</td>
              										</tr>
              									   
              									</tbody>    
              								</table>
              							</div>
              							<div class="portlet-footer">
              								<h3>Terms and Conditions</h3>
              								<ul>
              									<li><b>MEDXO LTD.</b></li>
              									<li>USD Account Number: 4006193</li>
              									<li>Bank Name: Royal Bank of Canada</li>
              									<li>Swift Code: ROYCCAT2</li>
              									<li>Branch Address: Northland Plaza BR 4820 Northland DR NW Suite 220 Calgary AB T2L 2L3</li>
              									
              									<li>Delivery Time:
              											<br><i class="fa fa-arrow-right"></i> 4-5 weeks for small products by DHL 
              											<br><i class="fa fa-arrow-right"></i> 8-12 weeks for big shipments from the date of receipt of Payment
              									</li>
              									<li>Quotation valid for only 60 days</li>
              									<li>Warranty: One year from the date of shipment, against all manufacturing defects.</li>
              									<li>100% advance payment by wire transfer.</li>
              								</ul>
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