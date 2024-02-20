<?php $this->load->view('common/header'); ?>
<section class="sitemap-section">
    <div class="container">
        <div class="sitemap-part">
            <div class="site-head">
                <h1 class="site-title"> Med<span>nics</span> <p>Sitemap</p></h1>
            </div>
            <div class="sitemap-section">
                <div class=" coll_tp">
                    <div class="content-panel sitemap">
                        <ul>
                            <li><a class="l0bg"  href="<?= base_url(); ?>">Home</a>
                                <ul>    
                                    <li><a class="l1bg" href="<?php echo base_url('all-category') ?>">Categories</a>
                                        <ul>
                                                <?php
                                                    foreach($categories as $key => $category) {
                                                        if($category['level']==0) {
                                                ?>
                                                <li><a class="l2bg" href="<?php echo $category['category_url']; ?>"><?php echo $category['name']; ?></a>
                                                    <ul>
                                                        <?php foreach($category['all_children_ids'] as $allcat_subcat_id){ ?>
                                                        <li><a class="l1bg" href="<?php echo $categories[$allcat_subcat_id]['category_url']; ?>"><?php echo $categories[$allcat_subcat_id]['name']; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                                <?php } } ?>
                                        </ul>
                                    </li> 
                                    <li><a class="l1bg" href="<?php echo base_url('all-products') ?>">All Products</a></li>
                                    <li><a class="l1bg" href="<?php echo base_url('catalogs') ?>">Catalogs</a></li>             
                                    <li><a class="l1bg" href="<?php echo base_url('about-us') ?>">About Us</a></li>
                                    <li><a class="l1bg" href="<?php echo base_url('contact-us') ?>">Contact us</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('common/footer'); ?>