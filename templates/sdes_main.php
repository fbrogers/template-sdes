<?php
	//check to see if template has data object
	if(!isset($data) or !$data instanceof TemplateData){
		die('Template has no data!');
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?= $data->html_site_meta(); ?>
	<?= $data->html_site_base(); ?>
	<title><?= $data->html_page_title().$data->html_site_title() ?> &raquo; UCF</title>

	<!-- CUSTOM UCF MARKETING HEADER -->
	<script type="text/javascript" src="http://assets.sdes.ucf.edu/scripts/jquery.min.js"></script>
	<script type="text/javascript" src="http://assets.sdes.ucf.edu/scripts/ucf.simplebar.js"></script>
	<link rel="stylesheet" type="text/css" href="http://assets.sdes.ucf.edu/css/ucf.simplebar.css" />
	<!-- /CUSTOM UCF MARKETING HEADER -->

	<!-- STYLES -->
	<link rel="stylesheet" href="http://assets.sdes.ucf.edu/css/sdes_main.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="http://assets.sdes.ucf.edu/css/sdes_print.css" type="text/css" media="print" />
	<link rel="shortcut icon" href="http://assets.sdes.ucf.edu/images/favicon_black.png" type="text/css" />
	<?= $data->html_site_css(); ?>
	<!-- /STYLES -->

	<!-- JAVASCRIPT -->
	<?= $data->html_site_js(); ?>
	<?= $data->html_site_js_raw(); ?>
	<script type="text/javascript">
	$(document).ready(function(){
		if(self != top){
			top.location = self.location;
		}
	});
	</script>
	<!-- /JAVASCRIPT -->

	<?= $data->html_billboard_includes() ?>
	<?= $data->html_site_gaid() ?>	
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
	<div id="nav_container"><?= $data->html_site_navigation() ?></div>
	<!-- /NAVIGATION -->

	<!-- CONTENT -->
	<div id="content_container">
		<div class="shadow"></div>

		<!-- BILLBOARD -->
		<?= $data->html_billboard() ?>
		<!-- /BILLBOARD -->

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

		<!-- CONTENT-END -->
		<div class="content-main-top"></div>
		<div class="content-main-body">
			<div class="content-end">
				<a href="http://get.adobe.com/reader/">
					<img src="http://assets.sdes.ucf.edu/images/content-end-pdf.jpg" class="icon" alt="icon" title="Get Adobe Reader" />
				</a>
				<?= $data->html_site_social_bottom() ?>
				<?= $data->html_site_navigation_bottom() ?>
			</div>
		</div>
		<div class="content-main-bottom"></div>
		<!-- /CONTENT-END -->

		<?= $data->html_site_content_end_under() ?>
	</div>
	<!-- /CONTENT -->

	<!-- FOOTER -->
	<div id="footer_container">
		<div id="footer">
			<!-- FOOTER COLUMN 1 -->
			<?= $data->html_site_footer(1); ?>
			<!-- /FOOTER COLUMN 1 -->

			<!-- FOOTER COLUMN 2 -->
			<?= $data->html_site_footer(2); ?>
			<!-- /FOOTER COLUMN 2 -->

			<!-- SEARCH AND CONTACT -->
			<div class="col3-3">
				<div class="h1">Search SDES</div>
				<div id="search">
					<form action="http://google.cc.ucf.edu/search" method="get">
						<fieldset>
							<input type="text" id="input" name="q" />
							<input type="hidden" name="output" value="xml_no_dtd" />
							<input type="hidden" name="proxystylesheet" value="UCF_Main" />
							<input type="hidden" name="client" value="UCF_Main" />
							<input type="hidden" name="site" value="UCF_Main" />
							<input type="image" src="https://assets.sdes.ucf.edu/images/footer-search-submit.png" alt="magnifying glass" id="sdes-submit" />
						</fieldset>
					</form>
				</div>
				<div class="h1">Contact</div>
				<div class="hr"></div>
				<?= $data->html_site_footer_contact() ?>
			</div>
			<!-- /SEARCH AND CONTACT -->

		</div>  
	</div>
	<!-- /FOOTER -->

	<!-- SUB FOOTER -->
	<div id="sub_footer_container">
		<div id="sub_footer">
			<div id="w3c">
				<a href="http://validator.w3.org/check?uri=referer">Valid HTML 5</a> &bull;
				<a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">Valid CSS 3</a> &bull;
				<a href="http://50.cms.smca.ucf.edu/"><img src="http://assets.sdes.ucf.edu/images/50.png" id="fifty" alt="UCF 50 Years" /></a> &bull;			
				<a href="<?= $data->html_site_footer_ucf_icon() ?>"><img src="http://assets.sdes.ucf.edu/images/sub-footer-pegasus.png" id="pegasus" alt="Pegasus" /></a>
			</div>
			<span>
				Copyright &copy; <?= date('Y'); ?> <a href="http://www.sdes.ucf.edu/">Student Development and Enrollment Services</a> &bull;
				Designed by <a href="http://it.sdes.ucf.edu/">SDES Information Technology</a>
			</span> 
		</div>
	</div>
	<!-- /SUB FOOTER -->
</body>
</html>