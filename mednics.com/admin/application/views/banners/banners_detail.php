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
                              <?php  $ebanners_id = $this->crm_auth->encrypt_openssl($banners['id']);?>
                                <div class="caption">Banners Detail <a  href="<?php echo site_url('edit-banners-'.$ebanners_id)?>"><i class="fa fa-edit"></i></a></div>
                            </div>
                            <div class="portlet-body detail table-responsive">
                                <table class="table table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td><?php echo $banners['name']; ?></td>
                                            <td>Order</td>
                                            <td><?php echo $banners['order']; ?></td>
                                          
                                        </tr>

                                        <tr>
                                            <td>Image title</td>
                                            <td><?php echo $banners['image_title']; ?></td>
                                            <td>Image alt</td>
                                            <td><?php echo $banners['image_alt']; ?></td>
                                         </tr>  

                                        <tr>
                                            <td>Created by</td>
                                            <td><?php echo $banners['createdby']; ?></td>
                                            <td>Updated by</td>
                                            <td><?php echo $banners['updatedby']; ?></td>
                                        </tr>

                                       
                                    </tbody>    
                                </table>

                                    Image Uploaded: 
                                    <?php if(isset($banners['image_url']) && $banners['image_url'] !=''){ ?>
                                    <img width="150px" height="150px" src="<?php echo url_without_admin(); ?>/<?php echo $banners['image_url'] ?>" alt="foto">

                                <?php } ?>
                                 <form class="form-manager" enctype="multipart/form-data" role="form" id="add-form" name="add-form" method="post" action="<?php echo site_url('upload-banners-image');?>">
                                                                             
                                            <div class="col-md-3">
                                                 <input type="hidden" id="id" name="id" value="<?php echo $banners['id']; ?>">
                                                 <input type="hidden" id="page_url" name="page_url" value="<?php echo $banners['name']; ?>">
                                                 <input type="hidden" id="image_url" name="image_url" value="<?php echo $banners['image_url']; ?>">
                                                <input type="file" class="form-control" id="picture" name="picture">
                                            </div>
                                              <div class="col-md-3">
                                                 <button type="submit" onclick="return check_form()" id="form_submit" class="btn blue">Update image</button>
                                              </div>
                                            
                                    
                                </form>
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
        
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url()?>assets/layouts/layout/scripts/layout.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/layout/scripts/demo.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-sidebar.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-nav.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });
            })
        </script>
		
    </body>

</html>