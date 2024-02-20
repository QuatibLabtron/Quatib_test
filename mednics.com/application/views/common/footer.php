
<a class="asking" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal22">
    <i class="bi bi-chat-square-text"></i>
</a>
<div class="footer-model-form">

    <div class="modal fade" id="exampleModal22" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

          <div class="modal-content">

            <div class="modal-header">

              <h5 class="modal-title fs-5" id="exampleModalLabel">Enquiry Desk</h5> 

              <button type="button" class="" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-octagon"></i></button>

            </div>

            <div class="modal-body">

            <form action="<?php echo base_url() ?>" method="post" onsubmit="enq_form_btn.disabled=true;return true;">
      	            <div class="mb-3"> 
                        <div class="row">  
                            <div class="col-12">  
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="qq_name" placeholder="Name" required>
                                <span class="err_message"><?php echo form_error('qq_name'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row"> 
                            <div class="col-12"> 
                                <input type="email" class="form-control" id="exampleFormControlInput1" name="qq_email"placeholder="Email" required>
                                <span class="err_message"><?php echo form_error('qq_email'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row"> 
                            <div class="col-12"> 
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="qq_subject"placeholder="Subject" required>
                                <span class="err_message"><?php echo form_error('qq_subject'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row"> 
                            <div class="col-12"> 
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="qq_product"placeholder="Product Name" required>
                                <span class="err_message"><?php echo form_error('qq_product'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row"> 
                            <div class="col-12">  
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="qq_message"placeholder="Product Details" rows="5"></textarea>
                                <span class="err_message"><?php echo form_error('qq_message'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div>
						    <?php echo captcha_common_html(2); ?>
                    </div>
                    <input type="hidden" class="form-control" name="qq_value" value="enquiry">
                    <div class="md-btn">
                        <button type="submit" id="enq_form_btn"  class="quiry-sender" >Send Message <i class="bi bi-send"></i></button>
                    </div>
        </form>

            </div>

          </div>

        </div>

        </div>

    

</div>
<div class="whatsapp-images ">

    <a target="_blank" class="" title="+1 616 693 6797"

        href="https://api.whatsapp.com/send?phone=6166936797&amp;lang=en" class="animate__bounce animate__backInUp animate__repeat-2">

       <img src="<?php echo base_url() ?>assets/images/logos/372108180_WHATSAPP_ICON_400.gif" alt=""></a>

</div>
<a href="#" class="to-top active animate__animated animate__bounceInDown" id="myBtnss">

    <i class="fa-solid fa-arrow-up"></i>

</a>
<section class="footer">

    <div class="container">

        <div class="footer1 ">

            <div class="row g-5">

                <div class="col-lg-3 col-md-6">

                    <div class="office">

                    <h4 class="text-white mb-2">Our Office</h4>

                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Mednics 100 Pearl St,

                        Hartford, CT 06103, United States.</p>

                    <a href="tel:+1 616 693 6797" class="mb-2"><i class="fa fa-phone-alt me-3"></i>+1 616 693 6797</a>

                    <a href="mailto:info@mednics.com" class="mb-2"><i class="fa fa-envelope me-3"></i>info@mednics.com</a>

                    <div class="d-flex pt-2">

                        <a class="btn btn-square btn-outline-light rounded-circle me-2" href=""><i

                                class="fab fa-twitter"></i></a>

                        <a class="btn btn-square btn-outline-light rounded-circle me-2" href=""><i

                                class="fab fa-facebook-f"></i></a>

                        <a class="btn btn-square btn-outline-light rounded-circle me-2" href=""><i class="fa-brands fa-instagram"></i></a>

                        <a class="btn btn-square btn-outline-light rounded-circle me-2" href=""><i

                                class="fab fa-linkedin-in"></i></a>

                    </div>

                </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="quick">

                    <h4 class="text-white mb-2">Quick Links</h4> 

                    <a class="btn btn-link" href="<?php echo base_url('all-category') ?>">Our Categories</a>

                    <a class="btn btn-link" href="<?php echo base_url('all-products') ?>">All-Products</a>

                    <a class="btn btn-link" href="<?php echo base_url('about-us') ?>">About Us</a>

                    <a class="btn btn-link" href="<?php echo base_url('contact-us') ?>">Contact Us</a>

                    <a class="btn btn-link" href="<?php echo base_url('sitemap') ?>">Sitemap</a>

                </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="top-ct">

                    <h4 class="text-white mb-2">Most View</h4>

                    

                    <?php $category_count = 1;

				        			    foreach($random_categories as $footer_cat){ 

				        				    if($category_count <= 5){	

                  				    ?>

                                    

                                        <a class="btn btn-link" href="<?php echo $categories[$footer_cat['id']]['category_url']?>"><?php echo $categories[$footer_cat['id']]['name']?></a>

                                    

                                    <?php $category_count++; } } ?>

                                            

                  

                </div>

            </div>

                <div class="col-lg-3 col-md-6">

                    <div class="best-slr">

                    <h4 class="text-white mb-2">Feature Products</h4>

                    

                    <?php $product_count = 1;

                                        foreach($random_products as $fproduct){

                                        if($product_count<=4 ){	

                                        $product_url =base_url().strtolower($categories[$fproduct['category_id']]['url_title'])."/".strtolower($fproduct['sku']);

                                    ?>

                                    

                                        <a class="btn btn-link" href="<?php echo $product_url; ?>"><?php echo $fproduct['name'];?></a>

                                    

                                    <?php $product_count++; } } ?>

                                        

                </div>

            </div>

            </div>

        </div>

    </div>

    <div class="copy">

        <p class="copy-right"> Copyright © 2023 | Mednics Ltd | All Rights Reserved.</p>

    </div>

</section>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/assets_js_jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
<script src="<?php echo base_url() ?>assets/js/script.js"></script>
<script>

    var correctCaptcha2 = function(response) {
		if(response.length==0){
			alert('Please verify captcha');
		}else{
			document.getElementById("enq_form_btn").removeAttribute("disabled"); 
		}
    }
    


	//Refresh Captcha

    //Contact Us
	function refreshCaptcha(){
		var img = document.images['captcha_image'];
		img.src = img.src.substring(
			0,img.src.lastIndexOf("?")
			)+"?rand="+Math.random()*1000;
	}
	//ENQUIRY DESK
    function refreshCaptcha2(){
		var img = document.images['captcha_image2'];
		img.src = img.src.substring(
			0,img.src.lastIndexOf("?")
			)+"?rand="+Math.random()*1000;
	}
    //Product Description
    function refreshCaptcha3(){
		var img = document.images['captcha_image3'];
		img.src = img.src.substring(
			0,img.src.lastIndexOf("?")
			)+"?rand="+Math.random()*1000;
	}
</script>
</body>



</html>

