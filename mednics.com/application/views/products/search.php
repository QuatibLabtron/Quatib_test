<div class="search-page-section">
    <div class="container">
        <div class="sps-head">
            <h1>Search For :<span> <?php if(isset($search_key)) { echo $search_key; }?> </span></h1>
        </div>
        <div class="sps-box">
        <?php if(isset($searched_products)) { 
                    if(empty($searched_products)){ ?>
                <h3>No results found</h3><br><br>
                <?php } 
                foreach($searched_products as $sproduct){
                    $spimage = json_decode($sproduct['image_url']);
                    if(empty($spimage->small)){
                        $spimage = base_url('assets/images/no_photo.png');
                    }else{
                        $spimage = base_url($spimage->small);
                    }
                    $sproduct_url = base_url().strtolower($categories[$sproduct['category_id']]['url_title'])."/".strtolower($sproduct['sku']);
                ?>
            <div class="sps-item">
                <div class="sps-list">
                    <div class="sps-image">
                        <a href="<?php echo $sproduct_url?>"><img
                                src="<?php echo $spimage?>" alt="<?php echo $sproduct['name']; ?>"></a>
                    </div>
                    <div class="arrow"></div>
                    <a href="<?php echo $sproduct_url; ?>" class="sps-list-head">
                        <h3 class="sps-list-title"><?php echo $sproduct['name'];?></h3>
                    </a>
                    <div class="sps-view-more">
                        <a href="<?php echo $sproduct_url; ?>">More Details <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <?php } } ?>     
        </div>
    </div>
</div>
<?php $this->load->view('common/footer'); ?>