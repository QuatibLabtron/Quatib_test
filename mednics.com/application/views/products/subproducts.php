<?php $this->load->view('common/header'); ?>

<div class="pbc-section">

    <div class="container">

        <div class="pbc-head">

            <h1><?php echo $category['name'];?></h1>

        </div>

        <div class="pcb-top-btn">

        <?php foreach($categories[$category['id']]['children_ids'] as $child_category_id){ ?>

            <a href="<?php echo $categories[$child_category_id]['category_url']?> " class="pbc-btn"><?php echo $categories[$child_category_id]['name']?></a>

            <?php } ?>

        </div>

        <div class="pbc-main-section">

            <div class="row">

                <div class="col-lg-9">

                    <div class="pbc-box">

                        <div class="row">

                                    <?php

                                        if(!empty($products)){

                                        foreach($products as $product){

                                        $product_url = base_url().strtolower($categories[$product['category_id']]['url_title'])."/".strtolower($product['sku']);

                                        $product_image = json_decode($product['image_url']);

                                        if(empty($product_image->medium))

                                        $product_image = base_url('assets/images/no_photo.png');

                                        else $product_image = base_url($product_image->medium);

                                        $product_spec = json_decode($product['specifications'],true);

                                        if(!empty($product['features']))

                                        {

                                            if(strpos($product['features'],"<br>")){$tag = "<br>";}

                                            else if(strpos($product['features'],"</br>")){$tag = "</br>";}

                                            else if(strpos($product['features'],"<br/>")){$tag = "<br/>";}

                                            else if(strpos($product['features'],"<hr>")){$tag = "<hr>";}

                                            $product['features'] = explode($tag, $product['features']);

                                        }

                                    ?>

                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">

                                <div class="pbc-item">

                                    <div class="pbc-list">

                                        <div class="pbc-image">

                                            <a href="<?php echo $product_url;?>" class="pbc-img">

                                                <img src="<?php echo $product_image;?>"

                                                    alt="<?php echo $product['name'];?>">

                                            </a>

                                            <div class="com_pp">

                                                <label class="action action--compare-add ">

                                                    <input class="check-hidden checkbox" type="checkbox" value="<?php echo $product['sku']?>"

                                                        id="<?php echo $product['sku']?>">

                                                    <i class="far fa-plus"></i>

                                                    <i class="fas fa-check"></i> Compare

                                                </label>

                                            </div>

                                        </div>

                                        <div class="pbc-heading">

                                            <a href="<?php echo $product_url;?>" class="pbc-title"><?php echo $product['name'];?></a>

                                        </div>

                                        <div class="pbc-cont">

                                        <ul>

                                                        <?php $count = 1;

                                                            foreach ($product_spec as $spec => $value) {

                                                            if ($count <= 5) {

                                                        ?>                                                           

                                                            <li><?php echo $spec; ?> : <?php if(is_array($value)) {

                                                                        foreach($value as $key => $value1) 

                                                                        {

                                                                            echo $key . " : " . $value1 . "<br>";

                                                                        }

                                                                        }else

                                                                        {

                                                                            echo $value;

                                                                        }

                                                                    ?>

                                                                </li>   

                                                        <?php } $count++; } ?>  

                                        </ul>

                                            

                                        </div>

                                        <div class="pbc-list-btn">

                                            <a href="<?php echo $product_url;?>"> View Product <i class="fa-regular fa-eye"></i></a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <?php }  } ?>  

                        </div>

                    </div>

                </div>

                <div class="col-lg-3">

                    <div class="pbc-sbct">

                        <div class="pbc-search">

                            <form action="<?php echo html_escape(base_url('search')); ?>" method="get">

                                <input type="text" placeholder="Search Category" name="search">

                                <button> <i class="fa-solid fa-magnifying-glass"></i></button>

                            </form>

                        </div>

                        <div class="pbc-cat-list">

                            <h2>Category</h2>

                            <ul>

                            <?php $category_count = 1;

				        			    foreach($random_categories as $footer_cat){ 

				        				    if($category_count <= 6){	

                  				    ?>

                                <li><a href="<?php echo $categories[$footer_cat['id']]['category_url']?>"><?php echo $categories[$footer_cat['id']]['name']?></a></li>

                                <?php $category_count++; } } ?>   

                                <li><a href="<?php echo base_url('all-category') ?>"><span>View More</span></a></li> 

                            </ul>

                        </div>

                        <div class="pbc-top-prd">

                            <h3>Top Products</h3>

                            <ul>

                                    <?php $product_count = 1;

                                        foreach($random_products as $fproduct){

                                        $product_url =base_url().strtolower($categories[$fproduct['category_id']]['url_title'])."/".strtolower($fproduct['sku']);

                                        $product_image = json_decode($fproduct['image_url']);

                                        if(empty($product_image->medium))

                                        $product_image = base_url('assets/images/no_photo.png');

                                        else $product_image = base_url($product_image->medium);

                                        if($product_count<=6 ){	   

                                    ?>

                                <li>

                                    <div class="pbc-top-image">

                                        <a href="<?php echo $product_url; ?>">

                                            <img src="<?php echo $product_image; ?>"

                                                alt="<?php echo $fproduct['name'];?>">

                                        </a>

                                    </div>

                                    <div class="pbc-top-heading">

                                        <a href="<?php echo $product_url; ?>"><?php echo $fproduct['name'];?></a>

                                    </div>

                                </li>

                                <?php $product_count++; } }  ?>    

                            </ul>

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




