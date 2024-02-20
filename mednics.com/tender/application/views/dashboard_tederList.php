<!DOCTYPE html>
<!--[if IE 8]> 
<html lang="en" class="ie8 no-js">
   <![endif]--><!--[if IE 9]> 
   <html lang="en" class="ie9 no-js">
      <![endif]--><!--[if !IE]><!-->
      <html lang="en">
         <!--<![endif]-->   
          <!-- BEGIN HEAD -->    
         <head>
            <?php $this->load->view('common/header_style'); ?>
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
                     <!-- BEGIN CONTENT BODY -->                    
                     <div class="page-content">
                        <!-- BEGIN PAGE BAR -->                        
                        <div class="page-bar">
                             <?php echo $breadcrumb; ?>
                     	</div>
                        <div class="row">
                           <div class="col-md-12 ">
                              <div class="portlet light bordered">
                                 <div class="portlet-title">
                                 	<span class="caption-subject bold uppercase font-orange">Tenders list </span>
                                    	<a href="<?php echo site_url('export-user-followup-'.$person_id)?>" class="btn btn green"><i class="fa fa-plus"></i> Export </a>
                                    </div>
                                 <div class="portlet-body">
                                    <form method="post" enctype="multipart/form-data" id="frmListing">
                                       <table class="table table-striped table-bordered table-hover tenders-list" id="sample_1">
                                          <thead>
                                             <tr>
                                                <th> </th>
                                                <th> Name</th>
                                                <th> Reference ID </th>
                                                <th> Customer Name </th>
                                                <th> Total </th>
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
                     <!-- END CONTENT BODY -->                
                  </div>
                  <!-- END CONTENT -->            
               </div>
               <!-- END CONTAINER -->            
               <!-- BEGIN FOOTER -->           
               <?php $this->load->view('common/footer'); ?>     
                       <!-- END FOOTER -->        
            </div>
            <?php $this->load->view('common/footer_style'); ?>
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
          	<script type="text/javascript">
                  $(document).ready(function() {
					    gettenderslist();
					});

					function gettenderslist() {
					    var user_id = '<?php echo $person_id ?>';
					    var customDataTableElement = '.tenders-list';
					    $(customDataTableElement).DataTable().destroy();
					    var customDataTableCount = '<?php echo $dataTableData->table_data_count; ?>';
					    var customDataTableServer = <?php echo $dataTableData->table_server_status; ?> ;
					    var customDataTableUrl = baseUrl + 'gettenderDashboardlist-' + user_id + '?table_data_count=' + customDataTableCount;
					    var customDataTableColumns = [{
					        'data': 'id',
					        'render': function(data, type, row, meta) {
					            if (type === 'display') {
					                link = `<input name="chkId[]" value="` + row.id + `" type="checkbox" class="checkthis"/>`;
					            }
					            return link;
					        }
					    }, {
					        'data': 'tdr_name',
					        'render': function(data, type, row, meta) {
					            link = `<a href="` + baseUrl + `tenders-detail-` + row.id_encrypt + `" title=" Detail View "> ` + row.tdr_name + `</a>`;
					            return link;
					        }
					    }, {
					        'data': 'tdr_refid'
					    }, {
					        'data': 'contact_name'
					    }, {
					        'data': 'tdr_grandtotal'
					    }, {
					        'data': 'updated_by'
					    }, {
					        'data': 'status_name'
					    }];
					    customDatatable(customDataTableElement, customDataTableUrl, customDataTableColumns, true, customDataTableServer);
					}
			</script>    
         </body>
      </html>