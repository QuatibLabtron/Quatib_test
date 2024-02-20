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
    
    <style type="text/css">
      @media only screen and (max-width: 480px)
      {
        .widget-thumb .widget-thumb-heading{    font-size: 10px;margin: 0 0 10px;    color: #444444;}
        .widget-thumb{padding: 10px;}
        .widget-thumb.bordered{    border: 1px solid #979797;}
      }
    </style>
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
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <span>Dashboard</span>
                            </li>
                        </ul>
                    </div>
                    <div style="margin-top:5vh;text-align:center;">
                      <div class="row">
                         <?php $department = $this->session->userdata('prs_dpt_id');
                         if($department != DEVELOPER_DEPARTMENT){ ?> 
                        <div class="col-md-6">
                            <div class="portlet light bordered ">
                              <div class="portlet-title ">
                                      <div class="caption">
                                        <i style="font-size: 25px;color: #393;" class="fa fa-bullhorn" aria-hidden="true" >
                                          Users Feeds</i>
                                      </div>
                              </div> 
                              <?php if(isset($UserFeed) && $UserFeed != ''){ ?>
                                
                                <div class="row">
                                  <div class="col-md-12" style="height:400px;overflow-y:scroll;">
                                     <table  class="table table-hover table-nomargin table-bordered dataTable-scroller">
                                       <tbody>
                                        <?php foreach ($UserFeed as $key => $UserFeeds) { ?>
                                       
                                          <tr>
                                              <td style="text-align: left">
                                                <span class='label label-success' >
                                                  <i class='fa fa-users'></i></span>
                                                  <a target="_blank" href="<?php echo base_url('user-details-'.$UserFeeds['person_usrname']) ?>"><?php echo ucwords($UserFeeds['person_name']) ?></a> <?php echo ucwords($UserFeeds['tda_activity']) ?> 
                                                    <br><br>
                                                    <?php echo $UserFeeds['tda_activity_details'] ?> <br>
                                                    in
                                                      <?php echo ucwords($UserFeeds['activity_type']) ?><br>
                                                    <span style='color:#339933;float:right'>
                                                      <?php echo time_ago($UserFeeds['tda_date'])  ?>
                                                    </span>
                                              </td>
                                            </tr>
                                      <?php  } ?>
                                      </tbody>
                                   </table>
                                  </div>
                               </div>
                               <?php }  ?>
                             </div>
                        </div>
                      <?php } ?>
                         
                         <?php if($department == ADMIN_DEPARTMENT){ ?> 
                          <div class="col-md-6">
                            <div class="portlet light bordered">
                                <div class="portlet-title" >
                                  <div class="caption">
                                    <i style="font-size: 25px;color: #e51400;" class="fa fa-table" aria-hidden="true" > User Activity logs</i>
                                  </div>
                                </div> 
                                <div class="portlet-body">
                                  <table class="table table-striped table-bordered table-hover dashboard-list" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th> User Name</th>
                                            <th> No. Of Tenders </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                          <?php } ?>
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
  <script type="text/javascript">
            $(document).ready(function(){
                    getDashboardslist();           
            });
            
            function getDashboardslist()
            {
                var customDataTableElement = '.dashboard-list';
                $(customDataTableElement).DataTable().destroy();
                var customDataTableCount   = '<?php echo $dataTableData->table_data_count; ?>';
                var customDataTableServer  = <?php echo $dataTableData->table_server_status; ?>;
                var customDataTableUrl     =  baseUrl + 'getdashboardlist?table_data_count='+customDataTableCount;
                var customDataTableColumns = [
                    {   'data'  : 'prs_name' ,
                    'render': function(data, type, row, meta)
                    {
                      if(type === 'display'){
                        link = `
                                 <a href="`+baseUrl+`dashboard-details-`+row.id_encrypt+`" title="user Details"> `+row.prs_name+`</a>
                              `;
                      }
                      return link;
                    }
                  },
                   {   'data'  : 'total_tender' ,
                    'render': function(data, type, row, meta)
                    {
                      if(row.total_tender > 0)
                      {
                        link = `
                               <a href="`+baseUrl+`dashboard-details-`+row.id_encrypt+`" title=" Detail View "> `+row.total_tender+`</a>
                              `;
                      }else{
                        link = row.total_tender;
                      }
                      
                      return link;
                    }
                  }
                
                ];
                customDatatable(customDataTableElement, customDataTableUrl, customDataTableColumns, true, customDataTableServer);
            }
  </script>
  
</body>
</html>