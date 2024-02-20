
<div class="compare-product">
    <div class="compact">
        <h1 class="heading_center">Comparison of products</h1> 
        <div class="table_div mt-4" id="overflowtest">
            <table class="table compare_table border ">
                <thead>
                  

                    <tr style="background-color: #fff;;">
                        
                        <td class="first_col">
                            <b> Product </b>
                        </td>
                        <?php foreach ($products as $product) {
                                    $product_url = base_url().strtolower($categories[$product['category_id']]['url_title'])."/".strtolower($product['sku']);
                                    $image = json_decode($product['image_url']);
                                    if(empty($image->small)){
                                        $image = base_url('assets/images/no_photo.png');
                                    }else{
                                        $image = base_url($image->small);
                                        }
                                        $product_url = base_url().strtolower($categories[$product['category_id']]['url_title'])."/".strtolower($product['sku']);
                                ?>
                        <td>
                            <a href="<?php echo $product_url; ?>">    
                            <img src="<?php echo $image; ?>"
                                class="compare_img" alt="<?php echo $product['name']; ?>"
                                title="<?php echo $product['name']; ?>"></a>
                        </td>
                        <?php } ?>  
                    </tr>
                    <tr style="background-color: #eceff7">
                        <td class="first_col">
                            <b> Product Name </b>
                        </td>
                        <?php foreach ($products as $product) {
                                    $product_url = base_url().strtolower($categories[$product['category_id']]['url_title'])."/".strtolower($product['sku']);
                                    ?>
                                    <td>
                            <a href="<?php echo $product_url; ?>" class="compare_link"><?php echo $product['name']; ?></a>
                        </td>
                        <?php } ?>
                    </tr>
                   
                </thead>
                <tbody>
                    <?php foreach ($keys as $parameter => $specs){ ?>
                        <tr>
                            <td class="first_col"><?php echo $parameter?></td>
                            <?php if($specs['child']){
                                            foreach($specs['child'] as $value){
                                            if(!$value){
                                            $value = '&mdash;';
                                            }else{
                                            if(is_array($value)){
                                            echo "<td>";
                                            echo "<table class='table-striped table-hover'>";
                                            foreach($value as $v_child => $v_value){
                                            echo "<tr>";
                                            echo "<td>".$v_child."</td>";
                                            echo "<td>".$v_value."</td>";
                                            echo "</tr>";
                                            }
                                            echo "</table>";
                                            echo "</td>";
                                        } else { ?>
                                <td>
                                    <p><?php echo $value;?></p>
                                </td>
                            <?php } } } } ?>  
                        </tr>
                    <?php } ?>
                    <tr>
                        <td class="first_col">Delete</td>
                                <?php $redirect_link = base_url()."all-products";
                                 foreach ($products as $product) {
                                $delete_link = "";
                                if(isset($_GET['products']))
                                $sku = explode(",",$_GET['products']);
                                $sku_key = array_search($product['sku'],$sku);
                                unset($sku[$sku_key]);
                                $sku = implode(',',$sku);
                                $delete_link = base_url()."compare?products=".$sku;
                                if (empty($sku)) {
                                    $delete_link = $redirect_link; // Set the redirect link to product page
                                }
                                ?>    
                        <td class="pro-remove">
                            <a href="<?php echo $delete_link;?>"> <i class="fas fa-trash-alt"></i></a>
                        </td>
                        <?php } ?>    
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->load->view('common/footer'); ?>
