<?php

/* ----------------------------------------------------------------------------
	PAGE TITLE
------------------------------------------------------------------------------- 
description:
setter for $page_title. takes in a string. html is stripped when echoed into 
the <title> tag, but <em> and <strong> are maintained in <h1> tag.

default: null

example usage:
$title = 'Welcome!'
$title = 'Welcome to the <em>Site</em>!'
---------------------------------------------------------------------------- */


/* ----------------------------------------------------------------------------
	PAGE LINKS
------------------------------------------------------------------------------- 
description:
setter for $page_links. takes in an array of values that should be formed
as a key/value pair, with the value representing the href of the navigation
link and the key representing the text to place within the anchor. if
constraints are passed, each element of the passed array will be set to
$site_navigation as a key/value pair. also takes a raw string of HTML.

default: null

example usage:
$links = [
	'Vision and Mission' => 'mission',
	'Testimonials' => 'Testimonials',
	'Staff' => 'contact'
];

$links = '
	<ul class="content-main-links">
		<li><a href="http://firstbornrogers.com/">firstbornrogers.com</a><li>
	</ul>
';
---------------------------------------------------------------------------- */


/* ----------------------------------------------------------------------------
	ABOVE PAGE CONTENT
------------------------------------------------------------------------------- 
description:
setter for $page_content_above. takes in a string of html and sets it so that
it will appear before the page content block. note that there is no pre- or
post-formatting done to the html, so make sure to test this before rolling it
to production.

default: null

example usage:
$above = 
'<div class="content-main-top"></div>
<div class="content-main-body">
	<div class="content-main">
		<!-- HTML CONTENT HERE -->
		<div class="hr-blank"></div>
	</div>
</div>
<div class="content-main-bottom"></div>';
---------------------------------------------------------------------------- */


/* ----------------------------------------------------------------------------
	BELOW PAGE CONTENT
------------------------------------------------------------------------------- 
description:
setter for $page_content_below. takes in a string of html and sets it so that
it will appear before the page content block. note that there is no pre- or
post-formatting done to the html, so make sure to test this before rolling it
to production.

default: null

example usage:
$below = 
'<div class="content-main-top"></div>
<div class="content-main-body">
	<div class="content-main">
		<!-- HTML CONTENT HERE -->
		<div class="hr-blank"></div>
	</div>
</div>
<div class="content-main-bottom"></div>';
---------------------------------------------------------------------------- */


/* ----------------------------------------------------------------------------
	PAGE CONTENT: DIRECTORY INFORMATION BLOCK
------------------------------------------------------------------------------- 
description:
prints out a pre-formatted block of html that displays the site's stored hours
of operation, phone number, fax number, email address, and location. Any
element not set in the data object will be skipped automatically.

example usage:
<div class="menu">
	<?= $data->html_block_contact() ?>
</div>

renders:
<div class="menu">
	<table class="grid smaller">
		<tbody>
			<tr>
				<th scope="row">Hours</th>
				<td>Mon-Fri: 8am - 5pm</td>
			</tr>
			<tr>
				<th scope="row">Phone</th>
				<td>407-823-4444</td>
			</tr>
			<tr>
				<th scope="row">Fax</th>
				<td>407-823-4609</td>
			</tr>
			<tr>
				<th scope="row">Email</th>
				<td><a href="mailto:sdestech@ucf.edu">sdestech@ucf.edu</a></td>
			</tr>
			<tr>
				<th scope="row">Location</th>
				<td><a href="http://map.ucf.edu/?show=7b">Ferrell Commons 132</a></td>
			</tr>
		</tbody>
	</table>
</div>
---------------------------------------------------------------------------- */


/* ----------------------------------------------------------------------------
	PAGE CONTENT: BASIC DIRECTORY INFORMATION
------------------------------------------------------------------------------- 
description:
prints out data primed for html output piecemeal. one method for each piece
of the aforementioned contact block.

example usage:
<?= $data->html_site_hours() ?>
<?= $data->html_phone() ?>
<?= $data->html_fax() ?>
<?= $data->html_email() ?>
<?= $data->html_email_link() ?>
<?= $data->html_map_link() ?>

renders:
Mon-Fri: 8am - 5pm
407-823-4444
407-823-4609
<a href="mailto:sdestech@ucf.edu">sdestech@ucf.edu</a>
<a href="http://map.ucf.edu/?show=7b">Ferrell Commons 132</a>
---------------------------------------------------------------------------- */


/* ----------------------------------------------------------------------------
	PAGE CONTENT: DIRECTORY HELPER METHODS
------------------------------------------------------------------------------- 
description:
extension methods for the DirectoryHelper CMS. All methods are documented in
that library's documentation.

example usage:

prints the first alert
<?= $data->get_directory_helper()->PrintAlert(); ?>

prints all alerts
<?= $data->get_directory_helper()->PrintAlerts(); ?>

prints an alert only if isSideWide is true
<?= $data->get_directory_helper()->PrintSiteAlert(); ?>

prints a document with slug matching string
<?= $data->get_directory_helper()->PrintDocument('service-catalog'); ?>

prints all news article summaries
<?= $data->get_directory_helper()->PrintNews(); ?>

prints all news article summaries, including billboard stories
<?= $data->get_directory_helper()->PrintNews(true); ?>

prints all billboard stories as billboards
<?= $data->get_directory_helper()->PrintBillboard(); ?>

prints all staff without role headings
<?= $data->get_directory_helper()->PrintStaff(); ?>

prints all staff with role headings
<?= $data->get_directory_helper()->PrintStaff(true); ?>

prints all staff within a single identified role
<?= $data->get_directory_helper()->PrintRole('ASSA Staff'); ?>
---------------------------------------------------------------------------- */

?>