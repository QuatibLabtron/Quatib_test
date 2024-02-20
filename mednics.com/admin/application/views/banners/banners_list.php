<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
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
                                        <span class="caption-subject bold uppercase font-orange">Banners list </span>
                                       
                                        <a href="<?php echo site_url('add-banners')?>" class="btn btn green"><i class="fa fa-plus"></i> Add Banners</a> 

                                         <a class="btn btn green" onclick="return ConverToActive()"><i class="fa fa-check"></i> Active</a>

                                          <a class="btn btn green" onclick="return ConverToDeactive()"><i class="fa fa-close"></i> Deactive</a> 
                                         
                                        <!-- <div class="tools"> </div> -->
                                    </div>
                                   
                                    <div class="portlet-body">
                                        <form method="post" enctype="multipart/form-data" id="frmListing">
                                            <table class="table table-striped table-bordered table-hover banners-list" id="sample_1">
                                                <thead>
                                                    <tr>
                                                        <th> </th>
                                                        <th> Name</th>
                                                        <th> Order</th>
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
        $(document).ready(function(){
                    getbannerslist();          
            });

            

            function getbannerslist()
            {
                var customDataTableElement = '.banners-list';
                $(customDataTableElement).DataTable().destroy();
                var customDataTableCount   = '<?php echo $dataTableData->table_data_count; ?>';
                var customDataTableServer  = <?php echo $dataTableData->table_server_status; ?>;
                var customDataTableUrl     =  baseUrl + 'getbannerslist?table_data_count='+customDataTableCount;
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
                    
                   {   'data'  : 'name' ,
                    'render': function(data, type, row, meta)
                    {
                        link = `
                               <a href="`+baseUrl+`banners-detail-`+row.id_encrypt+`" title=" Detail View "> `+row.name+`</a>
                              `;
                      
                      return link;
                    }
                  },
                  {   'data'  : 'order' },
                  {   'data'  : 'createdby' },
                  {   'data'  : 'updatedby' },
                  {   'data'  : 'status_name' }
                
                ];

                customDatatable(customDataTableElement, customDataTableUrl, customDataTableColumns, true, customDataTableServer);
            }


            function ConverToActive()
            {
                
                
                var checked = jQuery('input[name="chkId[]"]:checked').length > 0;

                if (!checked){
                    alert("Please select at least one record to Activate");
                    return false;
                }

                if(!confirm('Do you really want to Activate this entries'))
                {
                    return;
                }
                var dataString = $('#frmListing').serialize();
                  $.ajax(
                  {
                    type: "POST",
                    url: baseUrl + "banners-activate",
                    data : dataString,
                    success: function(response)
                    {
                      response = JSON.parse(response);
                      
                      if (response.success == true)
                      {
                        swal({
                          title: "Done",
                          text: response.message,
                          type: "success",
                          icon: "success",
                          button: true,
                        }).then(()=>{
                          getbannerslist();
                        });
                      }
                      else
                      {
                        swal({
                          title: "Opps",
                          text: "Something Went wrong",
                          type: "error",
                          icon: "error",
                          button: true,
                        });
                      }
                    }
                  });
            }
             function ConverToDeactive()
            {
                
                
                var checked = jQuery('input[name="chkId[]"]:checked').length > 0;

                if (!checked){
                    alert("Please select at least one record to Deactive");
                    return false;
                }

                if(!confirm('Do you really want to Deactive this entries'))
                {
                    return;
                }
                var dataString = $('#frmListing').serialize();
                  $.ajax(
                  {
                    type: "POST",
                    url: baseUrl + "banners-deactivate",
                    data : dataString,
                    success: function(response)
                    {
                      response = JSON.parse(response);
                      
                      if (response.success == true)
                      {
                        swal({
                          title: "Done",
                          text: response.message,
                          type: "success",
                          icon: "success",
                          button: true,
                        }).then(()=>{
                          getbannerslist();
                        });
                      }
                      else
                      {
                        swal({
                          title: "Opps",
                          text: "Something Went wrong",
                          type: "error",
                          icon: "error",
                          button: true,
                        });
                      }
                    }
                  });
            }
    </script>

    </body>
   
</html>