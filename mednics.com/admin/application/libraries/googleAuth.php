<?php 
session_start();
error_reporting(E_ALL);

include 'lib/config.php';
include 'lib/authfunctions.php';
include 'GoogAuth.php';
$ga = new GoogAuth();

$email = $_SESSION['login_user'];
//echo $email;
$app_name = "admin_labtron";
$account = $email.'-'.$app_name;
if(isset($_POST['submit'])){
     //echo "111";exit;
    unset($_SESSION['login_error']);
    $code = $_POST['code'];
    $secret_key = getGoogleSecretKey($email,$conn);
    $checkResult = $ga->verifyCode($secret_key, $code, 2);
    if ($checkResult) {
        header('Location: home.php');
    }else{
        $_SESSION['login_error'] = "Incorrect code submitted, Enter Correct Code.";
        }
	}
if(!empty($_SESSION['login_error'])){
        echo "<div class='row'>";
        echo "<div class='alert alert-danger contact_msg' id='error_delay_fade'>";
        echo $_SESSION['login_error'];
        echo "</div>";
        echo "</div>";
}
?>
<?php //$this->load->view('common/header_style'); ?>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
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
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                
                <h3 class="form-title" style="text-align: center;">Google Autentication</h3>
    
                <!--<div class="logo" style="margin-bottom:20px;">
					<img style="width: 20%;" src="../assets/images/logo.png" alt="labtron_logo" />
				</div>-->
                <div class="form-group">
					<input type="hidden" id="" value="">
                    <?php 
                    $check = checkGoogleSecretKey($email,$conn);
                    if(isset($check) &&  $check == 0){ ?>
                    <div class="input-icon">This is your first time using <?php echo $app_name; ?></div>
                    <div class="input-icon">Scan the QR code below with Google Authenticator app</div>
                    <?php 
                    $secret_key = $ga->createSecret();
                    $qrCodeUrl = $ga->getQRCodeGoogleUrl($account, $secret_key); 
                    $value = saveGoogleSecretKey($email , $secret_key,$conn);
                    echo $value;
                    ?>
                    <div class="input-icon"><img src='<?php echo $qrCodeUrl; ?>'/></div>
                    <div class="input-icon">or enter this code manually into Google Authenticator</div>
                    <div class="input-icon">Your Account :<?php echo $account; ?></div>
                    <div class="input-icon">Your Key : <?php echo $secret_key; ?></div>
                    <?php } ?>
                    <div class="input-icon" style="margin-bottom: 10px;">
                         <label class="control-label">Username</label>
                        <input class="form-control" type="text" name="email" id="email" value="<?php echo $email; ?>" readonly> 
                    </div>
                    <div class="input-icon" style="margin-bottom: 10px;">
                        <label class="control-label">Security Code</label>
                        <input class="form-control"  type="text" name="code" id="code" required> 
                    </div>
                </div>
            
                <div>
                    <button type="submit" class="btn btn-success" name="submit">Login</button>
                </div>
            </form>
                   </div>
          </div>
        </div>
        <!-- END LOGIN -->
        <!-- BEGIN COPYRIGHT -->
        <div class="copyright" style="text-align: center;">  &copy; 2021. All rights reserved. Design by:   <a href="https://www.labtron.com/" target="_blank"><span class="white_font">Labtron Equipment Ltd.</span></a> </div>
	
        
    </body>
<script src="//code.jquery.com/jquery-1.11.1.js"></script>
<script>
    $("#error_delay_fade").fadeIn().delay( 5000 ).fadeOut();
</script>