<?php $this->load->view('common/header'); ?>
<?php if(!empty($this->session->flashdata('alert_success'))){
echo "<div class='row'>";
echo "<div class='alert alert-success contact_msg' id='error_delay_fade'>";
echo $this->session->flashdata('alert_success');
echo "</div>";
echo "</div>";
}else if(!empty($this->session->flashdata('alert_error'))){
echo "<div class='row'>";
echo "<div class='alert alert-danger contact_msg' id='error_delay_fade'>";
echo $this->session->flashdata('alert_error');
echo "</div>";
echo "</div>";
} ?>
<div class="contact-section">
    <div class="container">
        <div class="cnt-head">
            <h1>Conatct Us</h1>
        </div>
        <div class="self-form">
        <div class="row">
            <div class="col-lg-6">
                <div class="get-in-touch">
                    <h2>Get In Touch</h2>
                    <p> You can always reach us via following contact details. We will give our best to reach you as
                        possible.</p>
                    <div class="address">
                        <div class="locate">
                            <div class="icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="path">
                                <h4>Address</h4>
                                <p>Mednics 100 Pearl St, Hartford, CT 06103, United States.</p>
                            </div>
                        </div>
                        <div class="locate">
                            <div class="icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="path">
                                <h4>Phone</h4>
                                <a href="#">+1 616 693 6797.</a>
                            </div>
                        </div>
                        <div class="locate">
                            <div class="icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="path">
                                <h4>Email</h4>
                                <a href="mailto:info@mednics.com">info@mednics.com</a>
                            </div>
                        </div>
                        <div class="locate">
                            <div class="icon">
                                <i class="fa-solid fa-earth-africa"></i>
                            </div>
                            <div class="path">
                                <h4>Website</h4>
                                <a href="<?php echo base_url() ?>">www.Mednics.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-form">
                    <h3>Leave A Message</h3>
                    <form action="<?php echo html_escape(base_url('contact-us'))?>" method="POST" onsubmit="form_submit_reg.disabled=true;return true;">
                        <div class="col-md-12"> 
                            <input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Name">
                            <span class="err_message"><?php echo form_error('name');?></span>
                        </div>
                        <br>
                        <div class="col-md-12"> 
                            <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Email">
                            <span class="err_message"><?php echo form_error('email');?></span>
                        </div>
                        <br>
                        <div class="col-md-12"> 
                            <input type="mobile" class="form-control" id="inputPassword4" name="phone" placeholder="Phone Number">
                            <span class="err_message"><?php echo form_error('phone');?></span>
                        </div>
                        <br>
                        <div class="col-12"> 
                            <input type="text" class="form-control" id="inputAddress" name="subject" placeholder="Subject">
                            <span class="err_message"><?php echo form_error('subject');?></span>
                        </div>
                        <br>
                        <div class="col-12">
                           <textarea rows="3"class="form-control" id="inputAddress" name="message" placeholder="Message"></textarea>
                           <span class="err_message"><?php echo form_error('message');?></span>
                        </div>
                        <br>
                        <div class="col-12">
                            <span style="background-color:#163661;color:#fff;">
                        <?php echo captcha_common_html(); ?>
                        </span>	
                        </div>
                        <br>
                        <div class="cff-btn">
                            <button type="submit" id="form_submit_reg" class="cff-inner-btn">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?php $this->load->view('common/footer'); ?>
<script>
    var correctCaptcha = function(response) {
		if(response.length==0){
			alert('Please verify captcha');
		}else{
			document.getElementById("form_submit_reg").removeAttribute("disabled"); 
		}
    }
    $("#error_delay_fade").fadeIn().delay(3000).fadeOut();

</script>
