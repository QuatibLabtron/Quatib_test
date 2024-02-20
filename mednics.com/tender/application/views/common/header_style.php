<?php header( 'Set-Cookie: cross-site-cookie=name; SameSite=None; Secure'); ?>
<meta charset="utf-8" />
<title>
    <?php echo bsnprm_value(BSN_WEBSITE_NAME) ?>
    <?php echo $title=( $title)? " | ".$title: ''; ?>
</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />
<?php $globalCacheHVersion = global_asset_version(); ?>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>assets/global/plugins/font-awesome/css/font-awesome.min.css<?php echo $globalCacheHVersion; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css<?php echo $globalCacheHVersion; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>assets/global/plugins/bootstrap/css/bootstrap.min.css<?php echo $globalCacheHVersion; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css<?php echo $globalCacheHVersion; ?>" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="<?php echo base_url()?>assets/global/css/components.min.css<?php echo $globalCacheHVersion; ?>" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo base_url()?>assets/global/css/plugins.min.css<?php echo $globalCacheHVersion; ?>" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href="<?php echo base_url()?>assets/layouts/layout/css/layout.min.css<?php echo $globalCacheHVersion; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>assets/layouts/layout/css/themes/darkblue.min.css<?php echo $globalCacheHVersion; ?>" rel="stylesheet" type="text/css" id="style_color" />
<link href="<?php echo base_url()?>assets/layouts/layout/css/custom.css<?php echo $globalCacheHVersion; ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>assets/layouts/layout/css/summernote.css<?php echo $globalCacheHVersion; ?>" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->
<?php
	$image_path = '../assets/images/favicon.png';
?>
<link rel="shortcut icon" type="image/png" href="<?php echo $image_path; ?>" />