
<?php 
//include 'gauth.php';
//$this->load->view('gauth');
$this->load->library('GoogAuth');
$ga = new GoogAuth();
//$email = $this->session->userdata("prs_email");
$email = base64_decode($this->input->get('value'));
$app_name = "Mednics_admin";
$account = $app_name."-".$email;
if(!empty($this->session->flashdata('login_error'))){
        echo "<div class='row'>";
        echo "<div class='alert alert-danger contact_msg' id='error_delay_fade'>";
        echo $this->session->flashdata('login_error');
        echo "</div>";
        echo "</div>";
}

?>
<?php //$this->load->view('common/header_style'); ?>
<link href="<?php echo base_url()?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<style>
    .contact_msg {
	position: fixed;
	font-size: 16px;
	text-align: center;
	z-index: 999;
	width: 500px;
	left: calc(-50vw + 50%);
	right: calc(-50vw + 50%);
	margin-left: auto;
	margin-right: auto;
}
</style>
    <body class=" login">
       
        <div class="content" style="margin: 50px auto;text-align: center;">
           <div class="row">
               <div class="col-md-4 col-sm-8 col-md-offset-4 col-sm-offset-2">
            <!-- BEGIN LOGIN FORM -->
            <form action="<?php echo base_url('googleAuth');?>" method="post">
                
                <h3 class="form-title" style="text-align: center;">Mednics Security</h3>
            <?php 
                    //$urlString = dirname(FCPATH);
                    //$website_image_path         = $urlString.'/'.LOGO_IMAGE_PATH;
                   // $website_image              = bsnprm_value(BSN_WEBSITE_LINK).LOGO_IMAGE_PATH;
                ?>
               <!-- <div class="logo" style="margin-bottom:20px;">
					<img style="width: 50%;" src="<?php echo (file_exists($website_image_path))?$website_image:''; ?>" alt="" />
				</div>-->
                <div class="form-group">
					<input type="hidden" id="" value="">
                    <?php if(isset($check) &&  $check == 0){ ?>
                    <div class="input-icon">Please Contact Mednics IT Dept <?php echo $app_name; ?></div>
                    <div class="input-icon">For Login</div>
                    <?php 
                    $secret_key = $ga->createSecret();
                    $qrCodeUrl = $ga->getQRCodeGoogleUrl($account, $secret_key); 
                    $value = $this->home_model->saveGoogleSecretKey($email , $secret_key);
                   // echo $value;
                    ?>
                    <div class="input-icon"><img src='<?php echo $qrCodeUrl; ?>'/></div>
                    <div class="input-icon">or enter this code manually into Google Authenticator</div>
                    <div class="input-icon">Your Account :<?php echo $account; ?></div>
                    <div class="input-icon">Your Key : <?php echo $secret_key; ?></div>
                    <?php } ?>
                    <div class="input-icon" style="margin-bottom: 10px;">
                         <label class="control-label">Email</label>
                        <input class="form-control" type="text" name="email" id="email" value="<?php echo $email; ?>" readonly> 
                    </div>
                    <div class="input-icon" style="margin-bottom: 10px;">
                        <label class="control-label">Security Code</label>
                        <input class="form-control"  type="text" name="code" id="code" required> 
                    </div>
                </div>
            
                <div class="form-actions">
                    <button type="submit" class="btn">Login</button>
                </div>
            </form>
                   </div>
          </div>
        </div>
        <!-- END LOGIN -->
        <!-- BEGIN COPYRIGHT -->
     <!--   <div class="copyright" style="text-align: center;">  &copy; 2021. All rights reserved. Design by:   <a href="https://www.labtron.com/" target="_blank"><span class="white_font">Labtron Equipment Ltd.</span></a> </div>-->
	
        
    </body>
<script src="//code.jquery.com/jquery-1.11.1.js"></script>
<script>
    $("#error_delay_fade").fadeIn().delay( 5000 ).fadeOut();
</script>