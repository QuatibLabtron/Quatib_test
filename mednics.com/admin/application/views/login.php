<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	

         <?php $this->load->view('common/header_style'); ?>

		 

        <!-- BEGIN PAGE LEVEL PLUGINS -->

        <link href="<?php echo base_url()?>assets/global/plugins/select2/css/select2.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />

        <link href="<?php echo base_url()?>assets/global/plugins/select2/css/select2-bootstrap.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />

        <!-- END PAGE LEVEL PLUGINS -->



        <!-- BEGIN PAGE LEVEL STYLES -->

        <link href="<?php echo base_url()?>assets/pages/css/login-4.min.css<?php echo $global_asset_version; ?>" rel="stylesheet" type="text/css" />

        <!-- END PAGE LEVEL STYLES -->



        <style type="text/css">

          

                label.error {



                   color: #ff6161 !important;



                   font-size: 12px;



                   font-weight: 500;



                }

                .form-control, output {

                    font-size: 12px;

                    line-height: 1.42857;

                    color: #555;

                    display: block;

                }

                .login .content .form-actions .btn

                {

                    background-color: #0d819d;

                    border: 1px solid #acacac;

                    color: #fff;

                }



                .login .content label, .input-icon>i{ 

                    color: #0d819d;

                }

                /*Login page*/

                .login .content{

                    background: #fff;

                    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);

                }



                

                 .login .content p,

                .login .content h3, .login .content h4{

                  color: #000000;

                }

                .form-control{

                    border: 1px solid #0d819d;

                }

                .form-control:focus{

                    border: 1px solid #0d819d;

                }

                .white_font{

                      color: #fff;

                }

                

        </style>

    </head>

    <!-- END HEAD -->



    <body class=" login">

        <!-- BEGIN LOGO -->

        

        <!-- END LOGO -->

        <!-- BEGIN LOGIN -->

        <div class="content" style="margin: 50px auto;">

           <?php 

                    $urlString = dirname(FCPATH);

                    $website_image_path         = $urlString.'/'.LOGO_IMAGE_PATH;

                    $website_image              = bsnprm_value(BSN_WEBSITE_LINK).LOGO_IMAGE_PATH;

                ?>

            <!-- BEGIN LOGIN FORM -->

            <form class="login-form" id="login_form" method="post">

                <div class="logo">

					<!-- <img style="width: 70%;" src="<?php echo (file_exists($website_image_path))?$website_image:''; ?>" alt="" /> -->

                    <img src="<?php echo site_url(LOGO_IMAGE_PATH); ?>" alt="logo" class="logo-default" /> </a>

				</div>

				

                <h3 class="form-title" style="text-align: center;">Login to your account</h3>

            

                <div class="form-group">

					<input type="hidden" id="ref" value="<?php echo $ref?>">

                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

                    <label class="control-label visible-ie8 visible-ie9">Username</label>

                    <div class="input-icon">

                        <i class="fa fa-user"></i>

                        <input class="form-control placeholder-no-fix" required="" type="text" autocomplete="off" placeholder="Username" name="usr_username" id="usr_username"   /> 

                    </div>

                </div>

                <div class="form-group">

                    <label class="control-label visible-ie8 visible-ie9">Password</label>

                    <div class="input-icon">

                        <i class="fa fa-lock"></i>

                        <input class="form-control placeholder-no-fix" required="" type="password" autocomplete="off" placeholder="Password" name="usr_password" id="usr_password" /> 

                    </div>

                </div>

                <div class="form-actions">

                    <label class="rememberme">

                        <input type="hidden" name="rememberme" id="rememberme" value="1" />

                        <span></span>

                    </label>

                    <!-- <button type="submit" class="btn green pull-right" id="submit-button"> Login </button> -->

                   

                    <button id="form_submit1" type="submit" class="btn  pull-right">Login</button>

                </div>

				<!--    <div class="create-account">

                    <p> Don't have an account yet ?&nbsp;

                        <a href="<?php echo site_url('registration')?>" > Create an account </a>

                    </p>

                </div> -->

            </form>

          

        </div>

        <!-- END LOGIN -->

        <!-- BEGIN COPYRIGHT -->

        <div class="copyright">  &copy; 2023. All rights reserved. Design by:   <a href="https://www.mednics.com/" target="_blank"><span class="white_font">Mednics Equipment Ltd.</span></a> </div>

		

        <?php $this->load->view('common/footer_style'); ?>

        <!-- BEGIN PAGE LEVEL PLUGINS -->

        <script src="<?php echo base_url()?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>

        <script src="<?php echo base_url()?>assets/global/plugins/backstretch/jquery.backstretch.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>

        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL SCRIPTS -->

        <script src="<?php echo base_url()?>assets/global/scripts/app.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>

        <!-- END THEME GLOBAL SCRIPTS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->

        <script type="text/javascript">

        var base_url = '<?php echo base_url()?>';

        </script>



        <!-- start validation script -->

		<script src="<?php echo base_url()?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>

		<script src="<?php echo base_url()?>assets/js/form_validation_login.js<?php echo $global_asset_version; ?>" ></script>

		<script src="<?php echo base_url()?>assets/pages/scripts/login-4.min.js<?php echo $global_asset_version; ?>" type="text/javascript"></script>

           

            <!--end  validation script -->

        <!-- END PAGE LEVEL SCRIPTS -->

        <!-- BEGIN THEME LAYOUT SCRIPTS -->

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