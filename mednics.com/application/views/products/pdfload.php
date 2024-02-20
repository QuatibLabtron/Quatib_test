<div class="container">
    <div class="row">
		<div class="col-lg-3 for_ipadpro"></div>
		<div class="col-lg-8 for_ipadpro">
			<div class="catalog_body col-lg-12">
                <div class="col-lg-12 body1_part1">
                    <!----------------- Body 1 --------------------->
                    <div class="row catalog_cover">
                        <div class="col-lg-12" style="height: 15%;">
                            <h1 class="catalog_head"><?php echo chop($product['name'],$product['sku']); ?><?= $product['sku']?></h1>
                       	</div>
                    </div>
                </div>
                <?php
                    $product_url = base_url().strtolower($categories[$product['category_id']]['url_title'])."/".strtolower($product['sku']);
                    $product_image = json_decode($product['image_url']);
                    if(empty($product_image->medium)){
                    $product_image = base_url('assets/images/no_photo.png');
                    }else{
                    $product_image = base_url($product_image->medium);
                    }
                    $user_role = $this->session->userdata('role');
                ?>
                    <div class="card" id="myCanvas" style="background-image: url('<?php echo base_url() ?>assets/images/logos/bg-banner.jpg'); background-size: contain; background-repeat: round;">
                        <div class="card-logo">  
                        <img src="<?php echo base_url() ?>assets/images/logos/logo2.png" alt="">
                        </div>
                        <div class="card-image">
                            <img src="<?php echo $product_image; ?>"alt="<?php echo $product['name']; ?>">
                        </div>
                        <div class="card-title">
                            <h1><?php echo $product['name']; ?></h1>
                        </div>
                        <div class="card-dis">
                            <div class="mail">
                                <a href="mailto:quatiblabtron@gmail.com" class="hi"> <p><span>Email :</span> info@medfuge.com</p></a>
                                <a href="<?php echo base_url() ?>" class="hello"><span> website : </span> www.medfuge.com</a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="catalog-header">
                            <div class="title">
                                <h3>Overview </h3>
                            </div>
                            <p><?php echo $product['description']; ?></p>
                        </div>
                        <?php if($product['specifications']){  $specification = json_decode($product['specifications'],true);?>
                        <div class="specification">
                            <div class="title">
                                <h3>Specification</h3>
                            </div>
                            <div class="sub-div">
                                <table class="table table-border">
                                    <?php foreach($specification as $parameter => $value){
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
                                    <?php } } ?>
                                </table>        
                            </div>
                        </div>
                    </div>
                    <?php } if($product['features']){ ?>
                    <div class="card">
                        <div class="feature">
                            <div class="title">
                                <h3>feature </h3>
                            </div>
                            <ul>
                                <?php foreach($product['features'] as $fkey){ ?>
                                <li><?php echo $fkey; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php } if($product['applications']) { ?>
                        <div class="application">
                            <div class="title">
                                <h3>application </h3>
                            </div>
                            <?php foreach($product['applications'] as $app) { ?>
                                <p><?php echo $app; ?></p>
                            <?php } }?>
                        </div>
                        <div class="location">
                            <div class="location-image">
                                <img src="<?php echo base_url(); ?>assets/images/logos/logo2.png" alt="">
                            </div>
                            <div class="location-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="local">
                                            <span><i class="fa-solid fa-location-dot"></i> Location </span>
                                            <a href=""><p> Medfuge 100 Pearl St, Hartford, CT 06103, United States.</p></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mail">
                                            <a href="mailto:quatiblabtron@gmail.com"><span> <i class="fa-solid fa-envelope"></i> Email </span></a>
                                            <a href="mailto:quatiblabtron@gmail.com"><p> info@medfuge.com</p></a>
                                        </div>                           
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="globe">
                                            <span><i class="fa-solid fa-globe"></i> Website </span>
                                            <a href="<?php echo base_url() ?>"><p>www.medfuge.com</p></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
		<div class="col-lg-1 for_ipadpro"></div>
    </div>
</div>