<?php $this->load->view('common/header'); ?>
<div class="category-section">
    <div class="container">
        <div class="cs-head">
            <h1>Medical Category</h1>
        </div>
        <div class="cs-box">
        <?php foreach ($categories as $category) {
                // if($category['level']==0 and !empty($category['all_children_ids'])) {
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
                    <ul>
                    <?php $i = 1; 
                                foreach($category['all_children_ids'] as $subcategory){ 
                                    if($i <= 5){
                                         ?>
                        <li><a href="<?php echo $categories[$subcategory]['category_url'];?>"><i class="fa-solid fa-caret-right"></i><?php echo $categories[$subcategory]['name'];?></a></li>
                        <?php $i++; } }?>
                    </ul>
                    <div class="cs-btn">
                        <a href="<?php echo $category['category_url'];?>" class="cs-list-btn">More Details <i class="fa-solid fa-angles-right"></i>    </a>
                    </div>
                </div>
            </div>
            <?php } ?>  
        </div>
    </div>
</div>
<?php $this->load->view('common/footer'); ?>