<?php $this->load->view('common/header'); ?>
<div class="catalog-section">
    <div class="container">
        <div class="cs-head">
            <h1>Medical Equipment Catalogs</h1>
        </div>
        <div class="log-box">
        <?php foreach($categories as $allcatalog_category){
            $catimage = json_decode($allcatalog_category['image_url']);
            if(empty($catimage->medium)){
                $catimage = base_url('assets/images/no_photo.png');
            }else{
                $catimage = base_url($catimage->medium);
            }
            if($allcatalog_category['level']==0 and !empty($allcatalog_category['all_children_ids'])){
        ?>  
            <div class="log-item">
                <div class="log-list">
                    <div class="log-image">
                        <a href="<?php echo $allcatalog_category['category_url'];?>"class="log-img">
                            <img src="<?php echo $catimage; ?>" alt="<?php echo $allcatalog_category['name'];?>">
                        </a>
                    </div>
                    <div class="log-title">
                        <a href="<?php echo $allcatalog_category['category_url'];?>"class="log-title-cont"><?php echo $allcatalog_category['name'];?></a>
                    </div>
                    <ul class="log-sub-list">
                        <?php foreach($allcatalog_category['all_children_ids'] as $allcat_subcat_id){ ?>  
                        <li><a href="" data-bs-toggle="modal" data-bs-target="#exampleModal22"onclick="getproducts_cat(<?php echo $allcat_subcat_id;?>,'<?php echo $categories[$allcat_subcat_id]['name'];?>','<?php echo base_url() ?>')"><?php echo $categories[$allcat_subcat_id]['name'];?> </a></li>
                        <?php } ?>     
                    </ul>
                </div>
            </div>
            <?php } } ?>
        </div>
    </div>
</div>
<div class="catalog-modal">
<div class="modal fade" id="exampleModal22" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel1">Catalog</h1> 
      </div>
      <div class="modal-body" >
        <ul>
            <li id="addcards">
                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="bi bi-file-earmark-pdf-fill"></i> Vascular-Doppler-UVD-1000A</a>
            </li> 
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="" data-bs-dismiss="modal">Close</button> 
      </div>
    </div>
  </div>
  </div>
</div>
<?php $this->load->view('common/footer'); ?>
<script>
    function getproducts_cat(id, name, base_url) {
        //alert(namespace)
        // alert(name);return;
        $("#exampleModalLabel1").empty();
        $("#addcards").empty();
        var cards;
        var data = { 'id': id };
        ajaxurl = base_url + "getproducts_cat";
        $.ajax({
            data: data,
            url: ajaxurl,
            type: "POST",
            dataType: "json",
            success: function (result) {
                // alert(JSON.stringify(result));return;
                $("#exampleModalLabel1").html(name);
                var i;
                for (i = 0; i < result.length; i++) {
                    var res = false;
                    if (result[i]['catalog_url'] != '') {
                        res = checkFileExist(base_url + result[i]['catalog_url']);
                    }
                    if (res == true) {
                        cards = "<a href='" + base_url + "catalog/" + result[i]['sku'] + "' > <i class='bi bi-file-earmark-pdf-fill'></i>" + result[i]['name'] + " </a>";
                    } else {
                        cards = "<a href='" + base_url + "catalog/" + result[i]['sku'] + "' ><i class='bi bi-file-earmark-pdf-fill'></i>" + result[i]['name'] + " </a>";
                    }
                    // alert(cards)
                    $("#addcards").append(cards);
                }
            },
            error: function (error) {
                alert("ERROR: " + JSON.stringify(error));
            }
        });
    }
    function checkFileExist(urlToFile) {
        var xhr = new XMLHttpRequest();
        xhr.open('HEAD', urlToFile, false);
        xhr.send();

        if (xhr.status == "404") {
            return false;
        } else {
            return true;
        }
    }
</script>