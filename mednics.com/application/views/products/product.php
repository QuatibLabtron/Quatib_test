<?php $this->load->view('common/header'); ?>
<div class="all-prd-section">
    <div class="container">
        <div class="cs-head">
            <h1>All Medical Products </h1>
        </div>
        <div class="aps-box">
            <?php foreach ($categories as $category) { ?>
                <div class="aps-item">
                    <div class="aps-list">
                        <div class="aps-head">
                            <a href="<?php echo $category['category_url']; ?>"><?php echo $category['name']; ?></a>
                        </div>

                        <?php if (!empty($category['all_children_ids'])) { ?>
                            <!-- If there are subcategories -->
                            <ul class="aps-sub-list">
                                <?php foreach ($category['all_children_ids'] as $subcategory) { ?>
                                    <li>
                                        <a href="<?php echo $categories[$subcategory]['category_url']; ?>" class="aps-anch">
                                            <?php echo $categories[$subcategory]['name']; ?>
                                        </a>

                                        <!-- Display products under the current subcategory -->
                                        <ul class="aps-sub-list1">
                                            <?php foreach ($products as $product) {
                                                $product_url = base_url().strtolower($categories[$product['category_id']]['url_title'])."/".strtolower($product['sku']);
                                                if ($product['category_id'] == $subcategory || $product['category_id'] == $category['id']) { ?>
                                                    <li>
                                                        <!-- Make the product name a link to the product description page -->
                                                        <a href="<?php echo $product_url;?>">
                                                            <?php echo $product['name']; ?>
                                                        </a>
                                                    </li>
                                                <?php }
                                            } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } else { ?>
                            <!-- If there are no subcategories, display category products directly -->
                            <ul class="aps-sub-list1">
                                <?php foreach ($products as $product) {
                                    $product_url = base_url().strtolower($categories[$product['category_id']]['url_title'])."/".strtolower($product['sku']);
                                    if ($product['category_id'] == $category['id']) { ?>
                                        <li>
                                            <!-- Make the product name a link to the product description page -->
                                            <a href="<?php echo $product_url;?>">
                                                <?php echo $product['name']; ?>
                                            </a>
                                        </li>
                                    <?php }
                                } ?>
                            </ul>
                        <?php } ?>

                        <div class="aps-btn">
                            <a href="<?php echo $category['category_url']; ?>">View More</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view('common/footer'); ?>
