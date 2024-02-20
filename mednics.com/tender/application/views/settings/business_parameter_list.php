<!DOCTYPE html>
<html lang="en">
    <head>
    <?php $this->load->view('common/header_style')?>  

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <?php $this->load->view('common/header');?>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <?php $this->load->view('common/sidebar');?>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                       
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="<?php echo site_url('home')?>">Home</a>
                                    <i class="fa fa-circle"></i>
                                </li>
                                <li>
                                    <span>Business Parameter</span>
                                </li>
                            </ul>
                           
                        </div>
                        <!-- END PAGE BAR -->
                    
                       <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="icon-settings font-dark"></i>
                                            <span class="caption-subject bold uppercase">Business Parameter List</span>

                                        </div>

                                        <div class="tools"> </div>
                                    </div>
                                    <div class="portlet-body">
                                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                                            <thead>
                                                <tr>   
                                                    <th> ID </th>
                                                    <th> Name </th>
                                                    <th> Value </th>
                                                    <th> Edit </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; 
                                                foreach ($business_parameter as $key) { ?>
                                                 
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $key['bpm_name'] ?></td>
                                                    <td><?php echo $key['bpm_value'] ?></td>
                                                    <td><a data-toggle="modal" href="#subcatedit" data-id='<?php echo $key['bpm_id'] ?>' data-value='<?php echo $key['bpm_value'] ?>' data-name='<?php echo $key['bpm_name'] ?>' class="btn green  openmodel  pull pull-right" >Edit</a></td>
                                                
                                                    

                                                </tr>
                                                <?php $i++;} ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                               
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="subcatedit"  role="basic" aria-hidden="true"> <!-- tyfcb edit model -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h4 class="modal-title"><div class="caption font-red-sunglo">
                                                <i class="icon-bubble font-red-sunglo"></i>
                                                <span class="caption-subject bold uppercase">Edit</span>
                                            </div>
                                        </h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" id="bsnParmEdit" method="post">
                                        <!-- validaton form open -->
                                        <div class="form-body">
                                           <!-- Main form--> 
                                           <div class="form-group">

                                                <input type="hidden"  id="bpm_id" name="bpm_id" required value="" > 
                                           </div>
                                           <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="" id="bpm_name" name="bpm_name" disabled="" required value=""> 
                                           </div>
                                           <div class="form-group">
                                                <label >Value </label>
                                                <input type="input" name="bpm_value" id="bpm_value" class="form-control" placeholder="" required value="">
                                            </div>
                                            <!-- Main form End-->
                                        </div>
                                            <div class="modal-footer form-actions">
                                                <button type="button" class="btn red btn-outline" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn green">Update</button>
                                            </div>
                                    </form>       
                                </div>     
                            </div>    
                        </div>
                       <!-- /.modal-content -->
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                <!-- BEGIN QUICK SIDEBAR -->
             
                <!-- END QUICK SIDEBAR -->
            </div>
            <!-- END CONTAINER -->
            <!-- BEGIN FOOTER -->
             <?php  $this->load->view('common/footer');?>
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
        <script src="<?php echo base_url();?>assets/js/business_parameter_edit.js<?php echo $global_asset_version; ?>"></script>

        <script type="text/javascript">
            $(document).on("click",".openmodel" , function() {
            var bpm_name = $(this).data('name');
            var bpm_value = $(this).data('value');
            var bpm_id  = $(this).data('id');
           
            $(".modal-body #bpm_name").val(bpm_name);
            $(".modal-body #bpm_value").val(bpm_value);
            $(".modal-body #bpm_id").val(bpm_id);
            
           });
        </script>
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>