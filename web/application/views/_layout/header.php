<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!---Title-->
	<title><?=(isset($title_browser_ro) && !is_null($title_browser_ro) ? $title_browser_ro : "No Title ;-)")?></title>
	<meta name="description" content="<?=(isset($meta_description) && !is_null($meta_description) ? $meta_description : "")?>">
	<meta name="keywords" content="<?=(isset($keywords) && !is_null($keywords) ? $keywords : "")?>">
	<!--Google Fonts-->
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,300,500,600,800,700' rel='stylesheet' type='text/css'>
	<!--Favicon-->
	<!-- <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"> -->
	<!--Bootstrap CSS-->
	<link href="<?=base_url();?>public/assets/css/bootstrap.min.css" rel="stylesheet">
	<!--Font awsome CSS-->
	<link href="<?=base_url();?>public/assets/css/font-awesome.min.css" rel="stylesheet">
	<!--Meanmenu CSS-->
	<link href="<?=base_url();?>public/assets/css/meanmenu.min.css" rel="stylesheet">
	<!--Rev Slider CSS-->
	<link href="<?=base_url();?>public/assets/rs-plugin/css/settings.css" rel="stylesheet">
	<!-- Owl Carousel CSS -->
	<link href="<?=base_url();?>public/assets/css/owl.carousel.css" rel="stylesheet">
	<link href="<?=base_url();?>public/assets/css/owl.theme.css" rel="stylesheet">
	<link href="<?=base_url();?>public/assets/css/owl.transitions.css" rel="stylesheet">
	<!--Jquery UI CSS-->
	<link href="<?=base_url();?>public/assets/css/jquery-ui.css" rel="stylesheet">
	<!--Normalize CSS-->
	<link href="<?=base_url();?>public/assets/css/normalize.css" rel="stylesheet">
	<!--Main Style CSS-->
	<link href="<?=base_url();?>public/assets/style.css" rel="stylesheet">
	<!--Responsive CSS-->
	<link href="<?=base_url();?>public/assets/css/responsive.css" rel="stylesheet">
	<link href="<?=base_url();?>/public/assets/css/jquery.fancybox.css" rel="stylesheet">
	<link href="<?=base_url();?>public/assets/css/jquery.realperson.css" rel="stylesheet">
	<!--Modernizr js-->
	<script src="<?=base_url();?>public/assets/js/vendor/modernizr-2.8.3.min.js"></script>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>