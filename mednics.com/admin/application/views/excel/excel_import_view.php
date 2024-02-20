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
                                        <span class="caption-subject bold uppercase font-orange">
                                            <?php echo $title ?>

                                        <div class="tools"> </div>
                                    </div>


                                 <?php if($this -> session -> flashdata ( 'excel_error' )){ ?>
                                    <div class="portlet-title">
                                        <span class="caption-subject bold uppercase font-red">
                                            Error Found : <br>
                                          <?php echo $this -> session -> flashdata ( 'excel_error' ); ?>
                                        </span>
                                     </div>
                                
                                  <?php } ?>
                               
                          
                                   
                                   <?php 
                                   $new_excel_files          = $excelData['new_excel_files'];
                                   $new_excel_files_statuses = $excelData['new_excel_files_statuses'];
                                   $excel_files              = $excelData['excel_files'];
                                   $excel_files_statuses     = $excelData['excel_files_statuses'];
                                   $entity_attr              = $excelData['entity_attr'];
                                  

                                   if(isset($new_excel_files) && !empty($new_excel_files)) { ?>

                                    <div class="portlet-body">

                                        <div class="portlet-title">
                                           
                                                <span class="caption-subject uppercase font-orange">
                                                    New Excel files: 
                                                </span>

                                        </div>
                                         <hr>
                                        
                                            <table class="table table-striped table-bordered table-hover categories-list" id="add_new_excel">
                                                <thead>
                                                    <tr>
                                                        <th> Name</th>
                                                        <th> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                      <?php  
                                                        foreach($new_excel_files as $index => $excel_file) {
                                                             
                                                        $file_status = $new_excel_files_statuses[$index]; 
                                                        if($file_status != '[no access]'){ ?>
                                                        <tr>
                                                       
                                                             <td> <?php echo $excel_file. ' ' . $file_status  ?></td>
                                                      <td>
                                                        <form method="post" enctype="multipart/form-data" id="add-form" name="add-form" action="<?php echo base_url('import-excel-process') ?>">

                                                             <input type = "hidden" name = "process_type" value = "add_excel_files">
                                                             
                                                             <input type = "hidden" name = "ctrl" value = "<?php echo $ctrler; ?>">

                                                             <input type = "hidden" name = "entity_name" value = "<?php echo $excelData['entity_name']; ?>"> 

                                                             <input type = "hidden" name = "view_name" value = "<?php echo $excelData['view_name']; ?>"> 

                                                             <input type = "hidden" name = "new_excel_files[<?php echo $excel_file ?>]" value = "<?php echo $excel_file ?>">

                                                            <button class="btn btn green" type="submit"><i class="fa fa-check"></i> Add </button> 

                                                        </form>
                                                        </td>
                                                         <tr>
                                                    <?php }} ?>
                                                </tbody>
                                            </table>
                                       
                                    </div>
                                <?php } ?>


                               <?php if(isset($excel_files) && !empty($excel_files)) { ?>

                                    <div class="portlet-body">

                                        <div class="portlet-title">
                                           
                                                <span class="caption-subject uppercase font-orange">
                                                    Excel files: 
                                                </span>

                                        </div>
                                         <hr>
                                        
                                            <table class="table table-striped table-bordered table-hover categories-list" id="add_new_excel">
                                                <thead>
                                                    <tr>
                                                        <th> Name</th>
                                                        <th> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                      <?php  
                                                        foreach($excel_files as $index => $excel_file) {
                                                              $file_status = $excel_files_statuses[$index];  ?>

                                                       <tr>
                                                             <td> <?php echo $excel_file. ' ' . $file_status  ?></td>
                                                            <?php if($file_status == '[modified]') { ?> 
                                                        <td>
                                                         
                                                          <form method="post" enctype="multipart/form-data" id="edit-form" name="edit-form" action="<?php echo base_url('import-excel-process') ?>">

                                                               <input type = "hidden" name = "process_type" value = "update_excel_files">
                                                               
                                                               <input type = "hidden" name = "ctrl" value = "<?php echo $ctrler; ?>">

                                                               <input type = "hidden" name = "entity_name" value = "<?php echo $excelData['entity_name']; ?>"> 

                                                               <input type = "hidden" name = "view_name" value = "<?php echo $excelData['view_name']; ?>"> 

                                                               <input type = "hidden" name = "excel_files[<?php echo $excel_file ?>]" value = "<?php echo $excel_file ?>">

                                                              <button class="btn btn green" type="submit"><i class="fa fa-check"></i> Update </button> 

                                                          </form>
                                                          </td>
                                                        <?php } ?>
                                                          <?php if($file_status != '[no access]' && $file_status != '[modified]' && $excelData['entity_name'] == 'products') { ?> 
                                                          <td>
                                                          <form method="post" enctype="multipart/form-data" id="import-form" name="import-form" action="<?php echo base_url('import-excel-process') ?>">

                                                               <input type = "hidden" name = "process_type" value = "remove_excel_files">
                                                               
                                                               <input type = "hidden" name = "ctrl" value = "<?php echo $ctrler; ?>">

                                                               <input type = "hidden" name = "entity_name" value = "<?php echo $excelData['entity_name']; ?>"> 

                                                               <input type = "hidden" name = "view_name" value = "<?php echo $excelData['view_name']; ?>"> 

                                                               <input type = "hidden" name = "excel_files[<?php echo $excel_file ?>]" value = "<?php echo $excel_file ?>">

                                                              <button class="btn btn green" type="submit"><i class="fa fa-close"></i> Remove </button> 

                                                          </form>
                                                          </td>
                                                        <?php }else{?>
                                                          <td colspan="2"></td>
                                                         <?php } ?>
                                                       </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                       
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
           <?php $this->load->view('common/footer'); ?> 
            <!-- END FOOTER -->
        </div>
            <?php $this->load->view('common/footer_style'); ?> 
        <!-- BEGIN PAGE LEVEL PLUGINS --> 
       
        <script src="<?php echo base_url()?>assets/global/plugins/bootstrap-toastr/toastr.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>

        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url()?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
         <script src="<?php echo base_url()?>assets/pages/scripts/ui-toastr.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
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