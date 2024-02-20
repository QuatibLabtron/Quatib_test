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
                              <?php  $eorganisations_id = $this->crm_auth->encrypt_openssl($organisations['org_id']);?>
                                <div class="caption">Organisations Detail <a  href="<?php echo site_url('edit-organisations-'.$eorganisations_id)?>"><i class="fa fa-edit"></i></a></div>
                            </div>
                            <div class="portlet-body detail table-responsive">
                                <table class="table table table-bordered">
                                    <tbody>
                                       
                                        <tr>
                                            <td>Name</td>
                                            <td><?php echo $organisations['org_name']; ?></td>
                                            <td>Primary Email</td>
                                            <td><?php echo $organisations['org_primaryemail'];?></td>

                                        </tr> 

                                         <tr>
                                            <td>Secondary Email</td>
                                            <td><?php echo $organisations['org_secondaryemail']; ?></td>
                                            <td>Tertiary Email</td>
                                            <td><?php echo $organisations['org_tertiaryemail'];?></td>

                                        </tr> 

                                         <tr>
                                            <td>Primary Number</td>
                                            <td><?php echo $organisations['org_primaryphone']; ?></td>
                                            <td>Alternate number</td>
                                            <td><?php echo $organisations['org_altphone'];?></td>

                                        </tr> 

                                         <tr>
                                            <td>FAX</td>
                                            <td><?php echo $organisations['org_fax']; ?></td>
                                            <td>Website</td>
                                            <td><?php echo $organisations['org_website'];?></td>

                                        </tr> 

                                          <tr>
                                            <td>Assigned to</td>
                                            <td><?php echo $organisations['org_assignedto']; ?></td>
                                            <td>Industry</td>
                                            <td><?php echo $organisations['industry'];?></td>

                                        </tr> 

                                         <tr>
                                            <td>CST</td>
                                            <td><?php echo $organisations['org_cst']; ?></td>
                                            <td>VAT</td>
                                            <td><?php echo $organisations['org_vat'];?></td>

                                        </tr> 

                                        <tr>
                                            <td>Billing Address</td>
                                            <td><?php echo $organisations['org_billingadd']; ?></td>
                                            <td>Billing POB</td>
                                            <td><?php echo $organisations['org_billingpob'];?></td>

                                        </tr> 

                                        <tr>
                                            <td>Billing City</td>
                                            <td><?php echo $organisations['org_billingcity']; ?></td>
                                            <td>Billing State</td>
                                            <td><?php echo $organisations['org_billingstate'];?></td>

                                        </tr> 

                                          <tr>
                                            <td>Billing POC</td>
                                            <td><?php echo $organisations['org_billingpoc']; ?></td>
                                            <td>Billing Country</td>
                                            <td><?php echo $organisations['billingcountry'];?></td>

                                        </tr> 

                                        <tr>
                                            <td>Shiping Address</td>
                                            <td><?php echo $organisations['org_shippingadd']; ?></td>
                                            <td>Shiping POB</td>
                                            <td><?php echo $organisations['org_shippingpob'];?></td>

                                        </tr> 

                                        <tr>
                                            <td>Shiping City</td>
                                            <td><?php echo $organisations['org_shippingcity']; ?></td>
                                            <td>Shiping State</td>
                                            <td><?php echo $organisations['org_shippingstate'];?></td>

                                        </tr> 

                                          <tr>
                                            <td>Shiping POC</td>
                                            <td><?php echo $organisations['org_shippingpoc']; ?></td>
                                            <td>Shiping Country</td>
                                            <td><?php echo $organisations['shippingcountry'];?></td>

                                        </tr> 

                                         <tr>
                                            <td>Description</td>
                                            <td><?php echo $organisations['org_desc']; ?></td>
                                            <td>Comment</td>
                                            <td><?php echo $organisations['org_comment'];?></td>

                                        </tr> 

                                        <tr>
                                            <td>Created by</td>
                                            <td><?php echo $organisations['createdby']; ?></td>
                                            <td>Updated by</td>
                                            <td><?php echo $organisations['updatedby']; ?></td>
                                        </tr>

                                       
                                    </tbody>    
                                </table>
                            </div>
                        </div>

                         <div class="row">
                            <div class="col-md-12 ">
                                <div class="portlet light bordered">
                                  
                                    <div class="portlet-title">
                                        <span class="caption-subject bold uppercase font-orange">Contacts list </span>
                                    </div>
                                   
                                    <div class="portlet-body">
                                        <form method="post" enctype="multipart/form-data" id="frmListing">
                                            <table class="table table-striped table-bordered table-hover contacts-list" id="sample_1">
                                                <thead>
                                                    <tr>
                                                        <th> </th>
                                                        <th> Contact Name</th>
                                                        <th> Primary Email</th>
                                                        <th> Primary Phone </th>
                                                        <th> Assigned To </th> 
                                                        <th> Created By </th>  
                                                        <th> Updated By </th>    
                                                        <th> Status </th>    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </form>
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
        <script>
             $(document).ready(function(){
                    getcontactslist();          
            });


            function getcontactslist()
            {
                var organisations_id = <?php echo $organisations['org_id'] ?>;
                var customDataTableElement = '.contacts-list';
                $(customDataTableElement).DataTable().destroy();
                var customDataTableCount   = '<?php echo $dataTableData->table_data_count; ?>';
                var customDataTableServer  = <?php echo $dataTableData->table_server_status; ?>;
                var customDataTableUrl     =  baseUrl + 'getorgcontactslist?table_data_count='+customDataTableCount + '&organisations_id='+organisations_id;
                var customDataTableColumns = [
                    {   'data'  : 'id' ,
                    'render': function(data, type, row, meta)
                    {
                      if(type === 'display'){
                        link = `
                                <input name="chkId[]" value="`+row.id+`" type="checkbox" class="checkthis" />
                                
                              `;
                      }
                      return link;
                    }
                  },
                    
                   {   'data'  : 'cont_name' ,
                    'render': function(data, type, row, meta)
                    {
                        link = `
                               <a target="_blank" href="`+baseUrl+`contacts-detail-`+row.id_encrypt+`" title=" Detail View "> `+row.cont_name+`</a>
                              `;
                      
                      return link;
                    }
                  },
                 
                  {   'data'  : 'cont_primaryemail' },
                  {   'data'  : 'cont_mobilephone' },
                  {   'data'  : 'cont_assignedto' },
                  {   'data'  : 'createdby' },
                  {   'data'  : 'updatedby' },
                  {   'data'  : 'status_name' }
                
                ];

                customDatatable(customDataTableElement, customDataTableUrl, customDataTableColumns, true, customDataTableServer);
            }

        </script>
		
    </body>

</html>