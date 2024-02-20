<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
         <?php $this->load->view('common/header_style')?>  

        <!-- select2 css files -->
            <link href="<?php echo base_url()?>assets/global/plugins/select2/css/select2.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
            <link href="<?php echo base_url()?>assets/global/plugins/select2/css/select2-bootstrap.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
        <!-- select2 css end -->

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
                                <!-- BEGIN SAMPLE FORM PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-orange">
                                            <i class="icon-pin font-orange"></i>
                                            <span class="caption-subject bold uppercase">Edit Categories</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                                    <?php $ecategories_id = $this->crm_auth->encrypt_openssl($categories_id); ?>
                                       <form class=" form-manager" enctype="multipart/form-data" role="form" id="edit-form" name="edit-form" method="post" action="<?php echo site_url('edit-categories-'.$ecategories_id);?>">
                                            <div class="form-body">
                                                
                                                <input type="hidden" id="id" name="id" value="<?php echo $categories['id']?>">
                                                <div class="row">                                                          
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Name</label>
                                                            <input type="text" class="form-control" name="name" id="name" value="<?php echo $categories['name'];?>">
                                                            <span class="text-danger"><?php echo form_error('name');?></span>
                                                        </div>
                                                    </div>        

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Description</label>
                                                            <textarea class="form-control" name="description" id="description"><?php echo $categories['description'];?></textarea>
                                                           
                                                            <span class="text-danger"><?php echo form_error('description');?></span>
                                                        </div>
                                                    </div>      
                                                </div>

                                                 <div class="row">                            
                                                                
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Section Name</label>
                                                            <select  class="form-control select2"   required id="section" name="section">
                                                                <option value=''>Select Section</option>
                                                                <?php echo getCombo("SELECT section as f2,page_url as f1 FROM sections where status=".STATUS_ACTIVE." ",$categories['section']);?>
                                                            </select>
                                                            <span class="text-danger"><?php echo form_error('section');?></span>
                                                        </div>
                                                    </div>        

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Url title</label>
                                                            <input type="text" class="form-control" name="url_title" id="url_title" value="<?php echo $categories['url_title'];?>">
                                                           
                                                            <span class="text-danger"><?php echo form_error('url_title');?></span>
                                                        </div>
                                                    </div>      
                                                </div> 

                                                 <div class="row">                                                          
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Category Name</label>
                                                            <select  class="form-control select2"    id="parent_id" name="parent_id" onchange=" get_category_level(this.value)">
                                                                <option value=0>Select Parent Category</option>
                                                                <?php echo getCombo("SELECT name as f2,id as f1 FROM categories where status=".STATUS_ACTIVE." ",$categories['parent_id']);?>
                                                            </select>
                                                            <span class="text-danger"><?php echo form_error('parent_id');?></span>
                                                        </div>
                                                    </div>        

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Level</label>
                                                            <input type="number" min=0 class="form-control" name="level" id="level" value="<?php echo $categories['level'];?>">
                                                           
                                                            <span class="text-danger"><?php echo form_error('level');?></span>
                                                        </div>
                                                    </div>      
                                                </div>  

                                                 <div class="row">                                                          
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Page Url</label>
                                                            <input type="text" class="form-control" name="page_url" id="page_url" value="<?php echo $categories['page_url'];?>">
                                                            <span class="text-danger"><?php echo form_error('page_url');?></span>
                                                        </div>
                                                    </div>                                                  
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Page Title</label>
                                                            <input type="text" class="form-control" name="page_title" id="page_title" value="<?php echo $categories['page_title'];?>">
                                                            <span class="text-danger"><?php echo form_error('page_title');?></span>
                                                        </div>
                                                    </div>      
                                                </div> 

                                                <div class="row">    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Image Title</label>
                                                            <input type="text" class="form-control" name="image_title" id="image_title" value="<?php echo $categories['image_title'];?>">
                                                            <span class="text-danger"><?php echo form_error('image_title');?></span>
                                                        </div>
                                                    </div>                                                      
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Image Alt</label>
                                                            <input type="text" class="form-control" name="image_alt" id="image_alt" value="<?php echo $categories['image_alt'];?>">
                                                            <span class="text-danger"><?php echo form_error('image_alt');?></span>
                                                        </div>
                                                    </div>                                                  
                                                         
                                                </div> 

                                                <div class="row">                                                          
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Meta/Head Title</label>
                                                            <input type="text" class="form-control" name="meta_title" id="meta_title" value="<?php echo $categories['meta_title'];?>">
                                                            <span class="text-danger"><?php echo form_error('meta_title');?></span>
                                                        </div>
                                                    </div>                                                  
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Meta Keyword</label>
                                                            <input type="text" class="form-control" name="meta_keyword" id="meta_keyword" value="<?php echo $categories['meta_keyword'];?>">
                                                            <span class="text-danger"><?php echo form_error('meta_keyword');?></span>
                                                        </div>
                                                    </div>      
                                                </div> 
                                                <div class="row">                                                          
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_control_1">Meta Description</label>
                                                            <textarea class="form-control" name="meta_description" id="meta_description"><?php echo $categories['meta_description'];?></textarea>
                                                           
                                                            <span class="text-danger"><?php echo form_error('meta_description');?></span>
                                                        </div>
                                                    </div>    

                                                                                                  
                                                </div> 
                                            
                                                <div class="form-actions">
                                                   <button type="submit" id="form_submit" class="btn blue">Save</button>
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
        <script type="text/javascript">var base_url='<?php echo base_url();?>';</script>
        
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url()?>assets/layouts/layout/scripts/layout.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/layout/scripts/demo.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-sidebar.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
       <script src="<?php echo base_url()?>assets/layouts/global/scripts/quick-nav.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/global/plugins/select2/js/select2.full.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url()?>assets/pages/scripts/components-select2.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
      
            <script src="<?php echo base_url()?>assets/js/form_validation_categories.js<?php echo $global_asset_version; ?>" ></script>
        <!-- END THEME LAYOUT SCRIPTS -->
    
    
    </body>

</html>