<?php
 /*************************************************************************
 *  2020-2024 Shopiro Ltd.
 *  All Rights Reserved.
 * 
 * NOTICE: All information contained herein is, and remains the 
 * property of Shopiro Ltd. and is provided under a dual licensing model.
 * 
 * This software is available for personal use under the Free Personal Use License.
 * For commercial applications that generate revenue, a Commercial License must be 
 * obtained. See the LICENSE file for details.
 *
 * This software is provided "as is", without any warranty of any kind.
 */


if(isset($_GET['logout'])){
	unset($_SESSION['dp_datadoc_logged_in']);
}

if(isset($_GET['sync_file'])){
	dataphyre\datadoc::sync_file(base64_decode($_GET['sync_file']));
}
?>
<style>
@font-face {
	font-family: Phyro-Bold; src: url('https://cdn.shopiro.ca/res/assets/genesis/fonts/Phyro-Bold.ttf'); 
} 
.phyro-bold {
  font-family: 'Phyro-Bold', sans-serif;
  font-weight: 700;
  font-style: normal;
  line-height: 1.15;
  letter-spacing: -.02em;
  -webkit-font-smoothing: antialiased;
}
</style>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
	<title>DataDoc</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/png" sizes="32x32" href="https://cdn.shopiro.ca/res/assets/genesis/img/favicon-32x32.png?v=1.5.8" nonce="0fdf026a">
	<link rel="icon" type="image/png" sizes="16x16" href="https://cdn.shopiro.ca/res/assets/genesis/img/favicon-16x16.png?v=1.5.8" nonce="0fdf026a">
	<meta http-equiv="Content-Type" charset="UTF-8" content="text/html; charset=UTF-8" />
	<meta name="msapplication-TileColor" content="#343a40">
	<meta name="theme-color" content="#343a40">
	<script src="https://cdn.shopiro.ca/res/shopirocs/library/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdn.shopiro.ca/res/assets/genesis/css/bootstrap.min.css?v=1.5.8" nonce="0fdf026a">
	<link rel="stylesheet" href="https://cdn.shopiro.ca/res/assets/genesis/css/style.css?v=1.5.8" nonce="0fdf026a">
	<link rel="stylesheet" href="https://cdn.shopiro.ca/res/assets/genesis/css/responsive.css?v=1.5.8" nonce="0fdf026a">
	<link rel="stylesheet" href="https://cdn.shopiro.ca/res/assets/genesis/css/font-awesome.min.css?v=1.5.8" nonce="0fdf026a">
	<link rel="stylesheet" href="https://cdn.shopiro.ca/res/assets/genesis/fontawesome-5.13/css/all.css?v=1.5.8" nonce="0fdf026a">
</head>
<body class="<?=adapt(["dark"=>"dark-mode bg-dark"]);?>">
    <div id="wrapper">
		<header>
			<div class="topbar" id="top" style='position:relative !important'>
				<div class="header1 po-relative bg-dark">
					<div class="container">
						<nav class="navbar">
							<a href="<?=dataphyre\core::url_self(); ?>" class="navbar-brand" style="color:white; font-size:45px;"><span class="phyro-bold"><i>DATADOC</i></span></a>
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header1" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
								<span class="ti-menu"></span>
							</button>
							<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
							<?php 
							if(dataphyre\datadoc::logged_in()===true){
							?>
							<div class="act-buttons">
								<a type="button" href="<?=dataphyre\core::url_self_updated_querystring(array("logout"=>1)); ?>" class="btn btn-danger">Logout</a>
							</div>
							<?php
							}
							?>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</header>
	</div>
	<div class="<?=adapt(["dark"=>"bg-secondary"]);?>">
		<?php
		if(dataphyre\datadoc::logged_in()===true){
		?>
		<nav class="d-flex justify-content-between align-items-center px-3 py-2">
			<?=adapt(["dark"=>"<style>.breadcrumb-item+.breadcrumb-item::before{color: white;}</style>"]);?>
			<ol class="breadcrumb p-0">
			<!--
				<li class="breadcrumb-item <?=adapt(["dark"=>"text-white"]);?>"><a href="<?=dataphyre\core::url_self();?>developer/documentation" class="<?=adapt(["light"=>"text-body","dark"=>"text-white"]);?>">Developer Documentation</a></li>
				<li class="breadcrumb-item <?=adapt(["dark"=>"text-white"]);?>"><a href="<?=dataphyre\core::url_self();?>developer/documentation/<?=$documentid;?>/<?=$document_url_title;?>" class="<?=adapt(["light"=>"text-body","dark"=>"text-white"]);?>"><b><?=$document_data['titles'];?></b></a></li>
			-->
			</ol>
			<div class="search-container position-relative">
				<form method="get" action="<?=dataphyre\core::url_self();?>developer/documentation/search">
					<input type="text" class="w-100" name="s" placeholder="Search...">
					<i class="fas fa-search h-100 position-absolute d-flex align-items-center justify-content-center"></i> 
				</form>
			</div>
			<div class="header-menu pt-1">
				<input type="checkbox">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</nav>
		 <?php
		}
		?>