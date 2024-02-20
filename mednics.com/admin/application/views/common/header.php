<style type="text/css">

    

    label.error {



       color: #ff6161 !important;



       font-size: 12px;



       font-weight: 500;



    }

    .page-header.navbar .top-menu .navbar-nav>li.dropdown-user .dropdown-toggle {    margin-top: 20px;    padding: 6px 6px 6px 8px;}

    .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover

    {

            background-color: #333;
    		border-color: #f6f5f9;

    }

    .pagination>li>a, .pagination>li>span{    color: #181818;}

     @media only screen and (max-width: 480px)

     {

        .page-header.navbar .top-menu .navbar-nav>li.dropdown-user .dropdown-toggle {    margin-top: 6px!important;   }

        .portlet.light{padding: 10px 5px 10px;}

         .no_padding{padding-left: 0px;padding-right: 0px;}

     }



</style>

<div class="page-header navbar navbar-fixed-top">

	<!-- BEGIN HEADER INNER -->

	<div class="page-header-inner ">

		<!-- BEGIN LOGO -->

		<div class="page-logo">

			<a href="<?php echo site_url('dashboard')?>">
				<?php 
				 	$urlString = dirname(FCPATH);
				 
                	$website_image_path 		= $urlString.'/'.LOGO_IMAGE_PATH;
                	$website_image 				= bsnprm_value(BSN_WEBSITE_LINK).LOGO_IMAGE_PATH;
				?>
				<img src="<?php echo site_url(LOGO_IMAGE_PATH); ?>" alt="logo" class="logo-default" /> </a>
				<!-- <img src="<?php echo (file_exists($website_image_path))?$website_image:''; ?>" alt="logo" class="logo-default" /> </a> -->

			<div class="menu-toggler sidebar-toggler">

				<span></span>

			</div>

		</div>

		<!-- END LOGO -->

		<!-- BEGIN RESPONSIVE MENU TOGGLER -->

		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">

			<span></span>

		</a>

		<!-- END RESPONSIVE MENU TOGGLER -->

		<!-- BEGIN TOP NAVIGATION MENU -->

		<div class="top-menu">

			<ul class="nav navbar-nav pull-right">

				<li class="dropdown dropdown-user">

					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">

						<!-- <img alt="" class="img-circle" src="<?php echo base_url()?>assets/layouts/layout/img/avatar3_small.jpg" /> -->

						<span class="username "> <?php echo $this->session->userdata('prs_name')?> </span>

						<i class="fa fa-angle-down"></i>

					</a>

					<ul class="dropdown-menu dropdown-menu-default">

					  

						<!-- <li class="divider"> </li> -->

						<li>

							<a href="<?php echo site_url('logout')?>">

								<i class="icon-key"></i> Log Out

							</a>

						</li>

					</ul>

				</li>

				<!-- END USER LOGIN DROPDOWN -->

			</ul>

		</div>

		<!-- END TOP NAVIGATION MENU -->

	</div>

	<!-- END HEADER INNER -->

</div>