<?php $this->load->view('common/header'); ?>
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.2.621/styles/kendo.common-material.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.2.621/styles/kendo.material.min.css" />
<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2017.2.621/styles/kendo.material.mobile.min.css" />
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jquery.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2017.2.621/js/kendo.all.min.js"></script>
<script type="x/kendo-template" id="page-template">
	<div class="page-template my-content"></div>
</script>
<div class="catalog-page-one">
    <div class="container">
        <div class="row justify-content-center m-0">
            <div class="col-md-12 col-xl-9 col-lg-10">
                <div class="row justify-content-center m-0">
                    <div class="col-xl-5 col-md-12 col-lg-5">
                        <div class="about-text">
                            <p>Generate Catalog For :</p>
                            <h1><?php echo $product['name']; ?></h1>
                            <a class="down-btn" href="#" onclick="ExportPdf()">Download Catalog</a>
                        </div>
                    </div>
                    
                    <div class="col-xl-7 col-md-8 col-lg-7 px-0">
                        <div class="catalog-design" id="myCanvas">
                            <div class="single-catalog-inner">
                                <div class="catalog-first middle">
                                    <div class="catalog-design-logo">
                                        <img src="<?php echo base_url() ?>assets/images/logos/logo.png" alt="logo">
                                    </div>
                                    <div class="row justify-content-center m-0">
                                        <div class="col-md-12 col-sm-12 col-xl-12 col-lg-12">
                                            <div class="catalog-first-img">
                                            <img src="<?php echo base_url().'assets/resources/images/products/'.$product['sku'].'.png';?>" class="catalog_img" alt="<?php echo $product['sku']; ?>">
                        		
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xl-12 col-lg-12">
                                            <div class="catalog-first-content middle">
                                                <h4><a href="#"><?php echo chop($product['name'],$product['sku']); ?><br><?= $product['sku']?></a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="catalog-second">
                                    <h5> Product Details :</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="second-content middle">
                                                <p><?php echo $product['description']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="catalog-second specification">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="second-content middle">
                                            <div class="specification">
                                                <h5>Specification :</h5>
                                                <div class="row justify-content-center mt-3">
                                                    <div class="col-md-12">
                                                        <div class="table-data-responsive table-responsive cata-table">
                                                            <?php if($product['specifications']){  $specification = json_decode($product['specifications'],true);?>
                                                                <table class="table table-responsive  table-condensed">
                                                                    <tbody>
                                                                    <?php foreach($specification as $parameter => $value){
                                                                        if(!empty($value)){
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $parameter; ?></td>
                                                                            <td>
                                                                            <?php if(is_array($value)){ 
                                                                                echo "<table>";
                                                                                foreach($value as $key => $value1){ ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <?php echo $key?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo $value1?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php } echo "</table>"; }else{
                                                                                        echo $value;
                                                                                    } ?>
                                                                            </td>
                                                                        </tr>
                                                                        <?php } } ?>    
                                                                    </tbody>
                                                                </table>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="catalog-second product-brief-data">
                                <div class="second-content middle">
                                    <h5>Features :</h5>
                                    <ul>
                                        <?php foreach($product['features'] as $fkey){ ?>
                                            <li><i class="fa-solid fa-arrow-right"></i><?php echo $fkey; ?></li>
                                        <?php } ?>    
                                    </ul>
                                </div>
                            </div>
                            <div class="catalog-second">
                                <div class="second-content middle">
                                    <?php if($product['applications']) { ?>
                                        <h5>Application :</h5>
                                        <?php foreach($product['applications'] as $app) { ?>
                                        <p><?php echo $app; ?></p>
                                    <?php } } ?>     
                                </div>
                            </div>
                            <div class="catalog-end">
                                <!-- <p class="catalog-end-text"><b>Mednics product catalog</b> <b>Generated on:<?php echo $current_date; ?></b></p> -->
                                <div class="catalog-end-logo">
                                    <div class="catalog-logo">  
                                        <div class="location">
                                            <div class="location-address">
                                                <p>Email:</p><a href="mailto:Info@mednics.com">info@mednics.com</a>
                                            </div>
                                            <div class="location-address">
                                                <p>Website:</p><a href="<?php echo base_url() ?>" target="_blank">www.Mednics.com</a>
                                            </div>
                                            <div class="location-address">
                                                <p>Phone:</p><a href="tel:+16166936797">+1 616 693 6797</a>
                                            </div>
                                        </div>
                                        <div class="address">
                                            <p>Location:</p><a href="https://maps.app.goo.gl/k4H2DvGy1k3Q6BJP9" target="_blank">Mednics 100 Pearl St, Hartford, CT 06103, United States.</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/footer'); ?>
    <script>
	kendo.pdf.defineFont({
		"DejaVu Sans"             : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans.ttf",
		"DejaVu Sans|Bold"        : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",
		"DejaVu Sans|Bold|Italic" : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
		"DejaVu Sans|Italic"      : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
		"WebComponentsIcons"      : "https://kendo.cdn.telerik.com/2017.1.223/styles/fonts/glyphs/WebComponentsIcons.ttf"
	});
	function ExportPdf(){
		kendo.drawing
		.drawDOM("#myCanvas",
		{
			forcePageBreak: ".page-break",
			paperSize: "A4",
			template: $("#page-template").html(),
			keepTogether: ".prevent-split"
		}).then(function(group){
			kendo.drawing.pdf.saveAs(group, "<?=str_replace(" ", "-", $product['name'])?>.pdf")
		});
	}
</script>