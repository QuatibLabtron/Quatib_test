<?php $this->load->view('common/header'); ?>

<?php 
if(!empty($this->session->flashdata('pd_quote_success'))){
echo "<div class='row'>";
echo "<div class='alert alert-success contact_msg' id='error_delay_fade'>";
echo $this->session->flashdata('pd_quote_success');
echo "</div>";
echo "</div>";
}else if(!empty($this->session->flashdata('pd_quote_error'))){
echo "<div class='row'>";
echo "<div class='alert alert-danger contact_msg' id='error_delay_fade'>";
echo $this->session->flashdata('pd_quote_error');
echo "</div>";
echo "</div>";
}else if(!empty($this->session->flashdata('pd_quote_not_submitted'))){
echo "<div class='row'>";
echo "<div class='alert alert-danger contact_msg' id='error_delay_fade'>";
echo $this->session->flashdata('pd_quote_not_submitted');
echo "</div>";
echo "</div>";
}

        $product_url = base_url().strtolower($categories[$product['category_id']]['url_title'])."/".strtolower($product['sku']);

        $product_image = json_decode($product['image_url']);

        if(empty($product_image->medium))

        {

            $product_image = base_url()."assets/images/no_photo.png";

        }

        else

        {

            $product_image = base_url($product_image->medium);

        }

        $user_role = $this->session->userdata('role');

?>

<div class="product-details-section">

    <div class="container">

        <div class="row">

            <div class="col-lg-9">

                <div class="pds-part">

                    <div class="row">

                        <div class="col-lg-5">

                            <div class="pds-image">

                                <div class="pds-img">

                                    <img src="<?php echo $product_image; ?>" alt="<?php echo $product['name']; ?>">

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-7">

                            <div class="pds-info">

                                <h1><?php echo $product['name']; ?></h1>

                                <p class="pre_text_desc"><?php echo $product['description']; ?></p>

                                <div class="pds-log-btn">

                                    <?php if($product['catalog_url']!='' && file_exists($product['catalog_url']))

                                        { ?>

                                            <a href="<?php echo base_url().$product['catalog_url'] ?>">View Catalog</a>

                                            <?php  

                                        }else

                                        {  ?>

                                            <a href="<?php echo base_url('catalog/').$product['sku']?>">View Catalog</a>

                                    <?php } ?>   

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="pds-spl-part">

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                        <li class="nav-item" role="presentation">

                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"

                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"

                                aria-selected="true">Description</button>

                        </li>

                        <li class="nav-item" role="presentation">

                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"

                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"

                                aria-selected="false">Specifications</button>

                        </li>

                        <li class="nav-item" role="presentation">

                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"

                                data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"

                                aria-selected="false">Features</button>

                        </li>

                        <li class="nav-item" role="presentation">

                            <button class="nav-link" id="pills-disabled-tab" data-bs-toggle="pill"

                                data-bs-target="#pills-disabled" type="button" role="tab" aria-controls="pills-disabled"

                                aria-selected="false">Applications</button>

                        </li>

                    </ul>

                </div>

                <div class="data-show">

                    <div class="tab-content" id="pills-tabContent">

                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"

                            aria-labelledby="pills-home-tab" tabindex="0">

                            <div class="prd-des">

                                <h2>Product Description</h2>

                                <?php if($product['description'] != '' && isset($product['description'])){ ?>

                                <p> 

                                    <span><?php echo $product['name']; ?> </span>

                                    <?php echo $product['description']; ?>

                                </p>

                                <?php }  ?>    

                            </div>

                        </div>

                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"

                            aria-labelledby="pills-profile-tab" tabindex="0">

                            <div class="prd-spfc">

                                <div class="sub-div">

                                    <?php if($product['specifications']){ $specification = json_decode($product['specifications'],true);?> 

                                        <div class="pd-sep-div">

                                            <h2>Specification</h2>

                                        </div>

                                        <table class="table">

                                            <tbody>

                                                <?php $count = 1; foreach($specification as $parameter => $value){

                                                if(!empty($value)){

                                                ?>

                                                    <tr>

                                                        <td><?php echo $parameter; ?></td>

                                                        <td><?php if(is_array($value)){ 

                                                            echo "<table>";

                                                            foreach($value as $key => $value1){ ?>

                                                            <tr>

                                                                <td><?php echo $key?></td>

                                                                <td><?php echo $value1?></td>

                                                            </tr>                                    

                                                            <?php } echo "</table>"; }else{

                                                            echo $value;

                                                            } ?> 

                                                        </td>

                                                    </tr> 

                                                <?php $count++; } } ?>    

                                            </tbody>

                                        </table>

                                    <?php } ?>

                                </div>

                            </div>

                        </div>

                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"

                            aria-labelledby="pills-contact-tab" tabindex="0">

                            <div class="prd-ftr">

                                <div class="sub-div feature">

                                    <?php if($product['features']){ ?>

                                        <div class="pd-sep-div">

                                            <h2>Features</h2>

                                        </div>

                                            <ul>

                                                <?php foreach($product['features'] as $fkey){ ?>

                                                    <li>

                                                    <i class="fa-solid fa-arrow-right"></i><?php echo $fkey; ?>       

                                                    </li>

                                                <?php } ?>   

                                            </ul>

                                    <?php } ?> 

                                </div>       

                            </div>

                        </div>

                        <div class="tab-pane fade" id="pills-disabled" role="tabpanel"aria-labelledby="pills-disabled-tab" tabindex="0">

                            <div class="prd-app">

                                <div class="sub-div applications">

                                    <?php if($product['applications']) { ?>

                                        <div class="pd-sep-div">

                                            <h2>Applications</h2>

                                        </div>

                                        <?php foreach($product['applications'] as $app) { ?>

                                        <p><?php echo $app; ?></p> 

                                    <?php } } ?>  

                                </div>        

                            </div>

                        </div>

                    </div>

                </div>

                <div class="pds-get-form">

                    <div class="row">

                        <div class="col-lg-10">

                            <div class="getin">

                                <div class="title">

                                    <h2>Get <span> Quote </span></h2>

                                </div>

                                <form class="row g-3" action="<?php echo $product_url?>" method="POST" onsubmit="req_qt.disabled=true;return true;">

                                   <div class="col-lg-6">

                                        <div class="col-md-12 mb-3">

                                            <input type="text" class="form-control" id="inputEmail4"  name="name" placeholder="Name" required>
                                            <span class="err_message"><?php echo form_error('name');?></span>

                                        </div>

                                        <div class="col-md-12 mb-3">

                                            <input type="email" class="form-control" id="inputPassword4" name="email" placeholder="Email" required>
                                            <span class="err_message"><?php echo form_error('email');?></span>
                                        </div>

                                        <div class=" col-md-12  mb-3">

                                            <input type="text" class="form-control" id="inputAddress2" name="product" value="<?php echo $product['name']; ?>" readonly="readonly">

                                        </div>

                                   </div>

                                   <div class="col-lg-6">

                                        <div class="col-lg-12 mb-3">

                                            <textarea id="" class="form-control" rows="2" name="message" placeholder="Product-Details" required></textarea>
                                            <span class="err_message"><?php echo form_error('message');?></span>

                                        </div>
                                        <div class="col-lg-12">
                                            <?php echo captcha_common_html(3); ?>
                                            </div>
                                        <div class="pdf-form-btn">

                                            <button type="submit" class="btn-2" id ="send_quote"> <i class="fa-regular fa-paper-plane"></i> Send

                                                Quote</button>

                                        </div>

                                   </div>    

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="pbc-sbct2">

                    <div class="pbc-search2">

                        <form action="<?php echo html_escape(base_url('search')); ?>" method="get">    

                                <input type="text" placeholder="Search Category" name="search">

                                <button> <i class="fa-solid fa-magnifying-glass"></i></button>

                        </form>

                    </div>

                    <div class="pbc-cat-list2">

                        <h2>Category</h2>

                        <ul>

                            <?php $count = 1;

                             foreach ($categories as $category) {

                                // if($category['level']==0 and !empty($category['all_children_ids'])) {

                                $cat_image = json_decode($category['image_url']);

                                if(empty($cat_image->small)) {

                                $cat_image = base_url('assets/images/no_photo.png');

                                }else{

                                $cat_image = base_url($cat_image->medium);

                                }

                                if ($count <= 6) {

                            ?>

                            <li><a href="<?php echo $category['category_url'];?>"><?php echo $category['name'];?></a></li>

                            <?php } $count++; }  ?>  

                            <li><a href="<?php echo base_url('all-category') ?>"><span>View More</span></a></li> 

                        </ul>

                    </div>

                    <div class="pbc-top-prd2">

                        <h3>Related Products</h3>

                        <?php if(!empty($related_products)){ ?>

                            <ul>

                            

                            <?php

                                $count =1;

                                foreach($related_products as $relatedProduct){

                                $rimage = json_decode($relatedProduct['image_url']);

                                $rproduct_url = base_url().strtolower($categories[$relatedProduct['category_id']]['url_title'])."/".strtolower($relatedProduct['sku']);

                                if(empty($rimage->small)){

                                    $rimage = base_url('assets/images/no_photo.jpg');

                                }else{

                                    $rimage = base_url($rimage->small);

                                }	

                                ?>

                                <li>

                                    <div class="pbc-top-image2">

                                        <a href="<?php echo $rproduct_url?>">

                                            <img src="<?php echo $rimage?>"

                                                alt="<?php echo $relatedProduct['name'];?>">

                                        </a>

                                    </div>

                                    <div class="pbc-top-heading2">

                                        <a href="<?php echo $rproduct_url?>"><?php echo $relatedProduct['name'];?></a>

                                    </div>

                                </li>

                                <?php $count++; } ?>   

                            </ul>

                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>    

    </div>

</div>

<?php $this->load->view('common/footer'); ?>

