<?php $this->load->view('common/header'); ?>

<div class="banner-section">

    <div class="banner-image">

        <img src="<?php echo base_url() ?>assets/images/logos/Mednics-banner.jpg" alt="" class="banner-img">

    </div>

</div>

<div class="home-about-section">

    <div class="container">

        <div class="row">

            <div class="col-lg-6">

                <div class="about-image">

                    <div class="about-img">

                        <img src="<?php echo base_url() ?>assets/images/logos/mb.jpg" alt="">

                    </div>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="has-part">

                    <p class="has-info"> <span> Mednics, </span> a distinguished name in the field of medical equipment

                       stands out for its commitment to cutting-edge technology. Our unwavering dedication to

                        creating innovative and dependable products is tailored to meet the diverse needs of customers in

                        various industries. With a solid foundation of over two decades of expertise, mednics consistently

                        develops solution-oriented products, addressing a wide spectrum of medical requirements.</p>

                    <p class="has-info">We provide top-grade medical products to cater the needs of many Educational

                        institutions, Hospitals, Research institutes, Pharmaceutical industries, Environmental sciences,

                        Chemical, biological and clinical diagnostic labs and other organizations since the company's inception.

                    </p>

                    <p class="has-info">We are an <span>ISO 9001:2015 </span> certified company, and most of our products meet

                        stringent International Standards such as <span> ISO 13485:2012, ISO 14001:2015, ISO 13485:2016 </span>

                        and CE Certifications complying with GMP standards</p>

                    <p class="has-info">You can find a complete Type of high-quality, medical equipment manufactured with

                        various specifications to meet your medical needs. Our advanced medical instruments give laboratories

                        the comprehensive approach needed to accomplish operational goals.</p>

                </div>

            </div>

        </div>

       

    </div>

</div>

<div class="index-category">

    <div class="our-category">

        <div class="our-category-part">

            <h2 class="ocp-title">Our Categories</h2>

            <ul>

            <?php $i = 1; foreach($categories as $rcategory){

                    if($i <= 5){ ?>

                <li><a href="<?php echo $categories[$rcategory['id']]['category_url'];?>"><?php echo $categories[$rcategory['id']]['name'];?></a></li>

                <?php $i++; } } ?>

                <li><a href="<?php echo base_url() ?>all-category">View More</a></li>

                

            </ul>

        </div>

    </div>

</div>

<div class="home-product-section">

    <div class="container">

        <div class="hps-part">

            <div class="head-title">

                <h1 class="title"> Medical Categories </h1>

            </div>

            <div class="hps-box">

            <?php $i = 1; foreach($random_categories as $rcategory){

                        $rcatimage = json_decode($categories[$rcategory['id']]['image_url']);

                        if(empty($rcatimage->small)){

                                $rcatimage = base_url('assets/images/no_photo.png');

                        }else{

                                $rcatimage = base_url($rcatimage->small);

                        }if($i <= 10){

                                                    ?>  

                <div class="hps-item">

                    <div class="hps-list">

                        <div class="hps-image">

                            <a href="<?php echo $categories[$rcategory['id']]['category_url'];?>"><img

                                    src="<?php echo $rcatimage; ?>"

                                    alt="<?php echo $categories[$rcategory['id']]['name'];?>"></a>

                        </div>

                        <div class="arrow"></div>

                         <a href="<?php echo $categories[$rcategory['id']]['category_url'];?>" class="hps-list-head">

                            <h3 class="hps-list-title"><?php echo $categories[$rcategory['id']]['name'];?></h3>

                        </a>

                        <div class="view-more">

                            <a href="<?php echo $categories[$rcategory['id']]['category_url'];?>">More Details <i class="fa-solid fa-arrow-right"></i></a>

                        </div>

                    </div>

                </div>

                <?php $i++; } }  ?>    

            </div>

        </div>

    </div>

</div>

<div class="range-product-section">

    <div class="container">

        <div class="range-part">

            <div class="head-title">

                <h2 class="title">Medical Products </h2>

            </div>

            <div class="rps-box">

            <?php $i = 1; foreach($random_products as $fproduct){

                        $product_url =base_url().strtolower($categories[$fproduct['category_id']]['url_title'])."/".strtolower($fproduct['sku']);

                        $fpimage = json_decode($fproduct['image_url']);

                        if(empty($fpimage->medium)){

                            $fpimage = base_url('assets/images/no_photo.png');

                        }else{

                            $fpimage = base_url($fpimage->medium);

                        }if($i <= 8){

                    ?>         

                <div class="rps-item">

                    <div class="rps-list">

                        <div class="rps-head">

                            <a href="<?php echo $product_url; ?>">

                                <h2><?php echo $fproduct['name'];?></h2>

                            </a>

                        </div>

                        <div class="rps-image">

                            <a href="<?php echo $product_url; ?>"><img src="<?php echo $fpimage; ?>" alt="<?php echo $fproduct['name'];?>"></a>

                        </div>

                        <div class="local-bar">

                            <a href="<?php echo $product_url; ?>"><i class="fa-solid fa-eye"></i></a>

                            <?php if($fproduct['catalog_url']!='' && file_exists($fproduct['catalog_url']))

                                        { ?>

                                            <a href="<?php echo base_url().$fproduct['catalog_url'] ?>"><i class="bi bi-file-pdf-fill"></i></a>

                                            <?php  

                                        }else

                                        {  ?>

                                            <a href="<?php echo base_url('catalog/').$fproduct['sku']?>"><i class="bi bi-file-pdf-fill"></i></a>

                                    <?php } ?> 

                            <div class="com_pp2">

                                <label class="action2 action--compare-add2 ">

                                    <input class="check-hidden2 checkbox2" type="checkbox" value="<?php echo $fproduct['sku']?>"

                                        id="<?php echo $fproduct['sku']?>">

                                    <i class="far fa-plus"></i>

                                    <i class="fas fa-check"></i> 

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

                <?php $i++; } }  ?>    

            </div>

        </div>

    </div>

</div>

<div class="top-category-section">

    <div class="container">

        <div class="row">

            <div class="col-lg-4 ">

                <div class="top-ct-part">

                    <h3> Top Category</h3>

                    <ul>

                    <?php 

                             foreach ($categories as $rcategory) {

                                

                                    ?>

                        <li> <a href="<?php echo $categories[$rcategory['id']]['category_url'];?>"><?php echo $categories[$rcategory['id']]['name'];?><i class="fa-solid fa-arrow-right"></i></a></li>

                        <?php }  ?>

                    </ul>

                </div>

            </div>

            <div class="col-lg-8 col-md-12">

                <div class="best-seller-product">

                    <h3>Best Seller</h3>

                    <div class="bsr-box">

                        <div class="bsr-item">

                            <div class="owl-carousel owl-theme">

                            <?php foreach($latest_products as $lproduct){

                        $product_url =base_url().strtolower($categories[$lproduct['category_id']]['url_title'])."/".strtolower($lproduct['sku']);

                        $lpimage = json_decode($lproduct['image_url']);

                        if(empty($lpimage->medium)){

                            $lpimage = base_url('assets/images/no_photo.png');

                        }else{

                            $lpimage = base_url($lpimage->medium);

                        }

                    ?> 

                                <div class="bsr-list">

                                    <div class="bsr-image">

                                        <a href="<?php echo $product_url; ?>" class="bsr-img">

                                            <img src="<?php echo $lpimage; ?>"

                                                alt="<?php echo $lproduct['name'];?>">

                                        </a>

                                    </div>

                                    <div class="bsr-title">

                                        <a href="<?php echo $product_url; ?>"><?php echo $lproduct['name'];?></a>

                                    </div>

                                    <div class="bsr-btn">

                                        <a href="<?php echo $product_url; ?>">View More<i class="fa-solid fa-right-long"></i></a>

                                    </div>

                                </div>

                                <?php } ?>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="compare compare_btn">

    <div class="row row-2 compare-section">

        <a href="javascript:" class="btn compare_btn pull-right btn-compare" style="display: none;"> </a>

        <br>

    </div>

</div>

<?php $this->load->view('common/footer'); ?>