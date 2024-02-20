<!DOCTYPE html>

<html lang="en">
   
    <head>
         <?php $this->load->view('common/header_style')?>  
        
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
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
                   
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo site_url('dashboard')?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Parameters</span>
                            </li>
                        </ul>
                       
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <form class="horizontal-form" method="post" action="<?php echo site_url('parameter-list')?>">
                        <h3 class="page-title">  
                          <label class="col-md-2 control-label bold" for="gen_group">Parameter
                          </label>
                            <div class="input-group col-md-5">
                              <div class="input-group-control">
                                <select id="gen_group" required class="form-control" onchange="return table(this.value)"  name="gen_group">
                                    <option value='please select'>---Please Select---</option>
                                   <?php
                                      $abc3 ="SELECT distinct gen_group as f1 FROM `adm_gen_prm` ";
                                      $query = $this->db->query($abc3);

                                      $str='';
                                        foreach ($query->result() as $row) 
                                        {
                                          if($row->f1==$gen_group)
                                          {
                                           $selected='selected';
                                          }
                                          else{
                                          $selected='';}
                                          $str .="<option value='".$row->f1."' ".$selected.">".$row->f1."</option>";
                                        }
                                     echo $str;  ?>
                                </select>
                                <div class="form-control-focus"> </div>
                              </div>
                              <span class="input-group-btn btn-right">
                                 <button class="btn green" type="submit"  name="go" id="go">GO</button>
                              </span>
                            </div>          
                          </h3>
                      <!-- END PAGE TITLE-->
                      <!-- END PAGE HEADER-->
                    <div class="row" >
                        <div class="col-md-12" id="results">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="main_result">
                            
                        </div>
                        <!-- END SAMPLE FORM PORTLET-->
                    </div>
                  </form>
                  <section class="panel" id="product_after"  style="display:none">

                  </section>

                </div>
                <!-- END CONTENT BODY -->
              </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR -->
            <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a>
         
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
       <?php $this->load->view('common/footer'); ?>
        <!-- END FOOTER -->
       
        <!-- BEGIN CORE PLUGINS -->
        <script>
        var myheader="<?php echo site_url(); ?>";
        </script>
         <?php $this->load->view('common/footer_style')?> 
		<!-- FORM VALIDATION -->
        
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js<?php echo $global_asset_version; ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js<?php echo $global_asset_version; ?>"></script>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=<?php echo APIKEYFORLOCATION ?>"></script>
        <!-- END VALIDATION -->		 
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>assets/layouts/layout/scripts/layout.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/layouts/layout/scripts/demo.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/layouts/global/scripts/quick-sidebar.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/js/form_access.js<?php echo $global_asset_version; ?>"></script>
        <script>
          function table(gen_group)
          {

            var base_url='<?php echo base_url()?>';
            if(gen_group=='please select')
            {
              document.getElementById("go").disabled = true;
            }else{
              document.getElementById("go").disabled = false;
            }
          }
        </script>
      <!-- END THEME LAYOUT SCRIPTS -->
    </body>
</html>