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
                              <?php $ecategories_id = $this->crm_auth->encrypt_openssl($categories['id']);  ?>
                                <div class="caption">Categories Detail <a  href="<?php echo site_url('edit-categories-'.$ecategories_id)?>"><i class="fa fa-edit"></i></a></div>
                            </div>
                            <div class="portlet-body detail table-responsive">
                                <table class="table table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Name</td>
                                            <td colspan="3"><?php echo $categories['name']; ?></td>
                                          
                                        </tr>

                                        <tr>
                                            <td>Description</td>
                                            <td colspan="3"><?php echo $categories['description']; ?></td>
                                            
                                        </tr>

                                        <tr>
                                            <td>Section Name</td>
                                            <td><?php echo $categories['section']; ?></td>
                                            <td>Url Title</td>
                                            <td><?php echo $categories['url_title']; ?></td>
                                                
                                        </tr>

                                        <tr>
                                            <td>Parent Category Name</td>
                                            <td><?php echo $categories['category_name']; ?></td>
                                            <td>Level</td>
                                            <td><?php echo $categories['level']; ?></td>
                                                
                                        </tr>


                                         <tr>
                                            <td>Page title</td>
                                            <td><?php echo $categories['page_title']; ?></td>
                                            <td>Page url</td>
                                            <td><?php echo $categories['page_url']; ?></td>
                                            
                                         </tr>   

                                         <tr>
                                            <td>Meta title</td>
                                            <td><?php echo $categories['meta_title']; ?></td>
                                            <td>Meta Keyword</td>
                                            <td><?php echo $categories['meta_keyword']; ?></td>
                                                
                                        </tr>

                                        <tr>
                                             <td> Meta description </td>
                                            <td colspan="3"><?php echo $categories['meta_description']; ?></td>
                                        </tr>


                                        <tr>
                                            <td>Image title</td>
                                            <td><?php echo $categories['image_title']; ?></td>
                                            <td>Image alt</td>
                                            <td><?php echo $categories['image_alt']; ?></td>
                                         </tr>  

                                        <tr>
                                            <td>Created by</td>
                                            <td><?php echo $categories['createdby']; ?></td>
                                            <td>Updated by</td>
                                            <td><?php echo $categories['updatedby']; ?></td>
                                        </tr>

                                       
                                    </tbody>    
                                </table>

                                    Image Uploaded: 
                                    <?php if(isset($categories['image_url']) && $categories['image_url'] !=''){ ?>
                                    <img width="150px" height="150px" src="<?php echo url_without_admin(); ?>/<?php echo $categories['image_url'] ?>" alt="foto">

                                <?php } ?>
                                 <form class="form-manager" enctype="multipart/form-data" role="form" id="add-form" name="add-form" method="post" action="<?php echo site_url('upload-categories-image');?>">
                                                                             
                                            <div class="col-md-3">
                                                 <input type="hidden" id="id" name="id" value="<?php echo $categories['id']; ?>">
                                                 <input type="hidden" id="page_url" name="page_url" value="<?php echo $categories['url_title']; ?>">
                                                 <input type="hidden" id="image_url" name="image_url" value="<?php echo $categories['image_url']; ?>">
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
       
		
    </body>

</html>