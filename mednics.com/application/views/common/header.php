<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <title>Mednics</title> -->

    <title><?php echo $meta_info['meta-title']; ?></title>

    <meta name="description" content="<?php echo $meta_info['meta-description']; ?>" >

    <meta name="keyword" content="<?php echo $meta_info['meta-keyword']; ?>" >

    <meta name="author" content="mednics.com" >

    
    <link rel="canonical" href="<?php echo current_url(); ?>">

    <!--  Meta tags -->

    <meta itemprop="image" content="<?php echo base_url(); ?>assets/images/favicon.png" >

    <meta itemprop="url" content="<?php echo base_url(); ?>" >

    <meta itemprop="name" content="Medical Equipment | Lab Supplies | Mednics " >

    <meta name="twitter:card" content="summary" >

    <meta itemprop="name" content="Medical Equipment | Lab Supplies | Mednics" > 

    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logos/icon.png" type="image/x-icon">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/solid.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"

        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="

        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css"

        integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA=="

        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>

</head>



<body>
 
    <div class="header-section ">

        <div class="heading">

            <div class="container">

                <div class="header">

               
                    <div class="contact">

                        <div class="phone ">

                            <a href="https://api.whatsapp.com/send?phone=6166936797&amp;lang=en"> <i

                                    class="fa-brands fa-whatsapp"></i>

                                +1 616 693 6797

                            </a>

                        </div>

                        <div class="phone">

                            <a href="mailto:info@mednics.com"><i class="fa-regular fa-envelope"></i>

                                info@mednics.com

                            </a>

                        </div>

                    </div>
                    <div class="showformdata"> 
                    <form action="<?php echo html_escape(base_url('search')); ?>" method="get">

                        <input type="text" placeholder="Search Product" name="search" class="search__input">

                        <button type="submit" class="sf-btn">Search</button>

                    </form>

                </div>

                    <!-- <div class="policies">

                        <a href="<?php echo base_url(); ?>">Privacy Policy /</a>

                        <a href="<?php echo base_url(); ?>">Career /</a>

                        <a href="<?php echo base_url('sitemap') ?>"> Sitemap</a>

                    </div> -->



                </div>

            </div>

        </div>



    </div>

    <div class="navigation ">

        <div class="navmenu">

            <div class="container">

                <div class="logo-section">

                    <div class="nav-logo">

                        <a href="<?php echo base_url() ?>"><img src="<?php echo base_url() ?>assets/images/logos/logo.png" alt=""></a>

                        <div class="logo-icon">

                            <a class="logobar-icon" type="button" data-bs-toggle="offcanvas"

                                data-bs-target="#offcanvasTop" aria-controls="offcanvasTop"> <i

                                    class="fa-solid fa-bars"></i></a>

                        </div>

                    </div>

                    <div class="menu-list1" id="show-menu">

                        <ul class="nav-list1">

                            <li class="nav-item1"><a href="<?php echo base_url() ?>">Home</a></li>

                            <li class="nav-item1"><a href="<?php echo base_url('all-category') ?>"> Category</a></li>

                            <li class="nav-item1"><a href="<?php echo base_url('all-products') ?>">All-Products</a></li>

                            <li class="nav-item1"><a href="<?php echo base_url('catalogs') ?>">Catalog</a></li>

                            <li class="nav-item1"><a href="<?php echo base_url('about-us') ?>">About Us</a></li>

                            <li class="nav-item1"><a href="<?php echo base_url('contact-us') ?>">Contact Us</a></li>

                        </ul>

                        <!-- <div class="srch-but">

                            <button type="submit" class="sf-btn2" id="hideform"><i class="fa-solid fa-magnifying-glass"></i></button>

                        </div> -->

                    </div>

 
                    <div class="menu-icon">

                        <a href="" class="menubar-icon" id="select-menu" data-bs-toggle="offcanvas"

                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i

                                class="fa-solid fa-bars"></i></a>

                    </div>

                </div>

            </div>



        </div>

        <div class="mobile-search">

            <div class="head-search2">

                    

                    <form action="<?php echo html_escape(base_url('search')); ?>" method="get">

                        <input type="text" placeholder="Search Product" name="search" class="search__input">

                        <button type="submit" class="sf-btn2">Search</button>

                    </form>

                </div>

        </div>

        <div class="container">

            <div class="head-search" id="showform">

                <div class="showformdata">

                   

                    <form action="<?php echo html_escape(base_url('search')); ?>" method="get">

                        <input type="text" placeholder="Search Product" name="search" class="search__input">

                        <button type="submit" class="sf-btn">Search</button>

                    </form>

                </div>



              



            </div>

        </div>



    </div>



    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">

        <div class="offcanvas-header">

            <h5 class="offcanvas-title" id="offcanvasRightLabel">Menu</h5>

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>

        </div>

        <div class="offcanvas-body menu-list-body">

            <div class="menu-list" id="show">

                <ul class="nav-list">

                    <li class="nav-item"><a href="<?php echo base_url() ?>">Home</a></li>

                    <li class="nav-item"><a href="<?php echo base_url('all-category') ?>"> Category</a></li>

                    <li class="nav-item"><a href="<?php echo base_url('all-products') ?>">A-Z Products</a></li>

                    <li class="nav-item"><a href="<?php echo base_url('catalogs') ?>">Catalog</a></li>

                    <li class="nav-item"><a href="<?php echo base_url('about-us') ?>">About Us</a></li>

                    <li class="nav-item"><a href="<?php echo base_url('contact-us') ?>">Contact Us</a></li>

                </ul>

            </div>

        </div>

    </div>

    <?php $breadcrumbs =  array_unique($breadcrumbs);

        if(is_array($breadcrumbs)){

            if(sizeof($breadcrumbs)!=1){ ?>

                <div class="headbar">

                <div class="container">

                <ul class="breadcrumb">

                    <?php foreach($breadcrumbs as $breadcrumb => $link){

                        if($breadcrumb=='compare'){ $link = '#'; }

                        if($breadcrumb=='Home'){ ?>

                        <li class="breadcrumb-item"><a href="<?php echo base_url()?>"> Home  </a></li>

                    <?php	} else { ?>

                        || <li class="breadcrumb-item"> <a href="<?=$link?>"><?= ucwords($breadcrumb ); ?></a></li>

                    <?php } } ?>

                </ul>

                </div>

                </div>

    <?php }	} ?>