<?php
	//check to see if template has data object
	if(!isset($data) or !$data instanceof TemplateData){
		die('Template has no data!');
	}
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?= $data->html_site_meta(); ?>
	<?= $data->html_site_base(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=0.75" />
	<title><?= $data->html_page_title().$data->html_site_title() ?> &raquo; UCF</title>
	<script type="text/javascript" src="//assets.sdes.ucf.edu/scripts/jquery.min.js"></script>
	<script type="text/javascript" id="ucfhb-script" src="//universityheader.ucf.edu/bar/js/university-header.js"></script>

	<!-- STYLES -->
	<link rel="stylesheet" href="//assets.sdes.ucf.edu/css/sdes_main_ucf_admin.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="//assets.sdes.ucf.edu/css/sdes_print.css" type="text/css" media="print" />
	<link rel="shortcut icon" href="//assets.sdes.ucf.edu/images/favicon_black.png" type="text/css" />
	<?= $data->html_site_css(); ?>
	<!-- /STYLES -->
</head>
<body>
	<!-- HEADER -->
	<div id="header_container">
		<div id="header">
			<div id="title">
				<?= $data->html_site_title_div() ?>
			</div>
			<div id="subtitle">
				<?= $data->html_site_subtitle_div() ?>
			</div>
		</div>
	</div>
	<!-- /HEADER -->

	<!-- NAVIGATION -->
	<?php if($data->html_site_navigation() != null){ ?>
	<div id="nav_container">
		<div class="nav-menu-button">
			<img src="https://assets.sdes.ucf.edu/images/icons/nav-menu.png" alt="icon"/>
		</div>
		<?= $data->html_site_navigation() ?>
		<div class="clear"></div>
	</div>
	<?php } else { ?>
	<div id="nav_container"></div>
	<?php } ?>
	<!-- /NAVIGATION -->

	<!-- CONTENT -->
	<div id="content_container">
		<div class="shadow"></div>

		<!-- CONTENT-MAIN -->
		<?= $data->html_page_content_above() ?>
		<div class="content-main-top"></div>
		<div class="content-main-body">
			<div class="content-main">
				<?= $data->html_page_content_links() ?>
				<?= $data->html_page_content_title() ?>
				<?= $data->html_page_content() ?>
				<div class="hr-blank"></div>
			</div>
		</div>
		<div class="content-main-bottom"></div>
		<?= $data->html_page_content_below() ?>
		<!-- /CONTENT-MAIN -->

		<?= $data->html_site_content_end_under() ?>
	</div>
	<!-- /CONTENT -->

	<!-- FOOTER -->
	<div id="footer_container"></div>
	<!-- /FOOTER -->

	<!-- SUB FOOTER -->
	<div id="sub_footer_container">
		<div id="sub_footer">
			<div id="w3c">
				<a href="#">Valid HTML 5</a> &bull; <a href="#">Valid CSS 3</a>
			</div>
			<span>
				Copyright &copy; <?= date('Y'); ?> <a href="http://www.sdes.ucf.edu/">Student Development and Enrollment Services</a> &bull;
				Designed by <a href="http://it.sdes.ucf.edu/">SDES Information Technology</a>
			</span> 
		</div>
	</div>
	<!-- /SUB FOOTER -->

	<!-- JAVASCRIPT -->
	<script type="text/javascript" src="//assets.sdes.ucf.edu/scripts/scrollsaver.js"></script>
	<script type="text/javascript" src="//assets.sdes.ucf.edu/scripts/jquery.validate.js"></script>
	<?= $data->html_site_js(); ?>
	<script type="text/javascript" src="//assets.sdes.ucf.edu/scripts/sdes_main_ucf.js"></script>
	<?= $data->html_site_js_raw(); ?>
	<!-- /JAVASCRIPT -->
</body>
</html>