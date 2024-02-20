<?php
    if($this->session->userdata('prs_id')==''){
      $abc = base_url();
        echo '<script> ';
          echo 'window.location="'.$abc.'"';
        echo '</script>';
    }   
?>

<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title> General Parameters</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/font-awesome/css/font-awesome.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap/css/bootstrap.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo base_url();?>assets/global/css/components.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url();?>assets/global/css/plugins.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo base_url();?>assets/layouts/layout/css/layout.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/layouts/layout/css/themes/darkblue.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo base_url();?>assets/layouts/layout/css/custom.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
       <!--  <link rel="shortcut icon" href="<?php //echo $this->home_model->logoico('home_top_logoico'); ?>" /> -->
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
                                <h3 class="page-title">  <label class="col-md-2 control-label bold" for="gen_group">Parameter</label>

                                                    <div class="input-group col-md-5">
                                                        <div class="input-group-control">
                                                          <select id="gen_group" required class="form-control" onchange="return table(this.value)"  name="gen_group">

                                                            <option value='please select'>---Please Select---</option>

                                                         <?php
                                                           // $abc3 ="SELECT distinct gen_group as f1 FROM `gen_prm` ";
                                                              $abc3 ="SELECT distinct gen_prm.gen_group as f1, gen_prm_name.gen_title as f2 FROM gen_prm_name, gen_prm WHERE gen_prm.gen_group = gen_prm_name.gen_group ";
                                                                 // $this->db->where('ITE_status','Y');
                                                                 $query = $this->db->query($abc3);

                                                          $str='';
                                                            foreach ($query->result() as $row) {

                                                               // print_r($row);
                                                              if($row->f1==$gen_group)
                                                              {
                                                             //print_r($row);
                                                               $selected='selected';
                                                             }
                                                             else{
                                                              $selected='';

                                                             }
                                                              
                                                               $str .="<option value='".$row->f1."' ".$selected.">".$row->f2."</option>";
                                                            }
                                                         echo $str;
                                                 
                                                    ?>
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
           <?php echo $this->load->view('common/rightsidebar');?>
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
       <?php $this->load->view('common/footer'); ?>
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="<?php echo base_url();?>assets/global/plugins/respond.min.js<?php echo $global_asset_version; ?>"></script>
<script src="<?php echo base_url();?>assets/global/plugins/excanvas.min.js<?php echo $global_asset_version; ?>"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script>
  var myheader="<?php echo site_url(); ?>";
</script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap/js/bootstrap.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/js.cookie.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/jquery.blockui.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo base_url();?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo base_url();?>assets/layouts/layout/scripts/layout.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/layouts/layout/scripts/demo.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/layouts/global/scripts/quick-sidebar.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>
        <script src="<?php echo base_url();?>js/form_access.js<?php echo $global_asset_version; ?>"></script>


         <!-- validation -->

    <script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.min.js<?php echo $global_asset_version; ?>"></script>
    

        <script>

    function table(gen_group)

    {

      var base_url='<?php echo base_url()?>';

      if(gen_group=='please select')

      {

    document.getElementById("go").disabled = true;

      
    }

      else{




         document.getElementById("go").disabled = false;

      }

    }

   </script>
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>