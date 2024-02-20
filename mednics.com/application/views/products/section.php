<div class="category-section">
    <div class="container">
        <div class="cs-head">
            <h1>All Medical Equipment</h1>
        </div>
        <div class="cs-box">
        <?php foreach ($categories as $category) {
                $cat_image = json_decode($category['image_url']);
                if(empty($cat_image->small)) {
                $cat_image = base_url('assets/images/no_photo.png');
                }else{
                $cat_image = base_url($cat_image->medium);
                }
            ?>
            <div class="cs-item">
                <div class="cs-list">
                    <div class="cs-list-head">
                        <a href="<?php echo $category['category_url'];?>" class="cs-list-title"><?php echo $category['name'];?></a>
                    </div>
                    <div class="cs-image">
                        <a href="<?php echo $category['category_url'];?>" class="cs-img">
                            <img src="<?php echo $cat_image;;?>" alt="<?php echo $category['name'];?>">
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>  
        </div>
    </div>
</div>
<?php $this->load->view('common/footer'); ?>