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
$title = 'About Us';


/* ----------------------------------------------------------------------------
	PAGE LINKS
------------------------------------------------------------------------------- 
description:
setter for $page_links. takes in an array of values that should be formed
as a key/value pair, with the value representing the href of the navigation
link and the key representing the text to place within the anchor. if
constraints are passed, each element of the passed array will be set to
$site_navigation as a key/value pair.

default: null

example usage:
$links = ['About' => 'about', 'Services' => 'services'];
---------------------------------------------------------------------------- */
$links = [
	'Vision and Mission' => 'mission',
	'Testimonials' => 'Testimonials',
	'Staff' => 'contact'
];


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
//$above = NULL;


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
//$below = NULL;

?>


<?php 
/* ----------------------------------------------------------------------------
	PAGE CONTENT: DIRECTORY INFORMATION BLOCK
------------------------------------------------------------------------------- 
description:
prints out a pre-formatted block of html that displays the site's stored hours
of operation, phone number, fax number, email address, and location. Any
element not set in the data object will be skipped automatically.

example usage:
<div class="sidemenu">
	<?= $data->html_block_contact() ?>
</div>

renders:
<div class="sidemenu">
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
?>

<div class="sidemenu">
	<?= $data->html_block_contact() ?>
</div>


<?php 
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
<?= $data->html_email_link() ?>
<?= $data->html_map_link() ?>

renders:
Mon-Fri: 8am - 5pm
407-823-4444
407-823-4609
<a href="mailto:sdestech@ucf.edu">sdestech@ucf.edu</a>
<a href="http://map.ucf.edu/?show=7b">Ferrell Commons 132</a>
---------------------------------------------------------------------------- */
?>

<div class="left">
	<p>Welcome to SDES Information Technology! We empower SDES to achieve by combining
	advanced, reliable, and effective technology with diverse technical services including
	forecasting, consulting, research, purchasing, installation, configuration, and ongoing
	support for applications, clients, peripherals, and infrastructure devices for
	supported SDES staff.</p>

	<ul class="link-list bullets">
		<li><a href="https://portal.sdes.ucf.edu/technology/callticket/staff_submit.aspx">Submit a Call Ticket</a></li>
		<li><a href="teams">Learn More About Our Teams</a></li>
		<li><a href="services">Our Provided Services</a></li>
	</ul>
</div>
<div class="hr-blank"></div>