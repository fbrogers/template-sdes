<?php if(!isset($data) or !($data instanceof TemplateData)) die('Data not passed.');

/* ----------------------------------------------------------------------------
	SITE TEMPLATE
------------------------------------------------------------------------------- 
description:
setter for $site_template. takes in a string, all html will be stripped. the
getter finds the specified template file and passes the finished TemplateData
object to it via require_once on the template file

default: 'main'

example usage:
$data->site_template('main'); 
---------------------------------------------------------------------------- */
$data->site_template('main');


/* ----------------------------------------------------------------------------
	SITE META TAG INFORMATION
------------------------------------------------------------------------------- 
description:
setter for $site_meta. takes in an array with two values: the first is the name
of the meta tag, which is used in the "name" attribute; the second is the
corresponding value to that named attribute. this method simply adds the result
as a new index of the $site_meta array, meaning this method can be called
multiple times. The only reasonable use these days is to tell Google to buzz
off from sites that have no business in search results.

default: null

example usage:
$data->site_meta('robots', 'noindex'); 
$data->site_meta('description', 'This is an awesome description.'); 
---------------------------------------------------------------------------- */
//$data->site_meta();


/* ----------------------------------------------------------------------------
	SITE BASE ELEMENT
------------------------------------------------------------------------------- 
description:
setter for $site_base. takes in a string, which will act as the base URL for
all links and form submissions on the site. This is useful when using custom
URL Rewrite scripts for clean URLs. Do not use if you aren't sure what it's
for, because the effects can be nasty.

default: null

example usage:
$data->site_base('http://it.sdes.ucf.edu/'); 
$data->site_base('http://'.$_SERVER['SERVER_NAME'].'/'); 
---------------------------------------------------------------------------- */
//$data->site_base();


/* ----------------------------------------------------------------------------
	SITE TITLE
------------------------------------------------------------------------------- 
description:
setter for $site_title. takes in a string, all html will be stripped

constraints:
- character limit of 45 characters by default
- all html removed in all getters

default: 'SITE_TITLE'

example usage:
$data->site_title('SDES Information Technology'); 
---------------------------------------------------------------------------- */
$data->site_title('SDES Information Technology');


/* ----------------------------------------------------------------------------
	SITE SUBTITLE
------------------------------------------------------------------------------- 
description:
setter for $site_subtitle. takes in a string. html will be stripped when
it is printed for the footer, but <br> and <img> will maintain in 
#subtitle element. if using a <br />, make sure to leave a space before/after
it so it can be cleanly removed for the footer.

constraints:
- all html stripped but <br>, <img>

default: 'Student Development<br /> and Enrollment Services'

example usage:
$data->site_subtitle('Student Development<br /> and Enrollment Services');
---------------------------------------------------------------------------- */
//$data->site_subtitle('Submit a Call Ticket');


/* ----------------------------------------------------------------------------
	SITE TITLE LINK (HREF)
------------------------------------------------------------------------------- 
description:
setter for $site_title_href. takes in a string, all html will be stripped and
the value will be trimmed. This designates the link that will be wrapped over
the #title element in the header and the site name in the contact block of the
footer.

constraints:
- must be of type string
- all html removed in all getters

default: './'

example usage:
$data->site_title_href('./'); 
$data->site_title_href('?id=home'); 
$data->site_title_href('home'); 
---------------------------------------------------------------------------- */
//$data->site_title_href('./');


/* ----------------------------------------------------------------------------
	SITE SUBTITLE LINK (HREF)
------------------------------------------------------------------------------- 
description:
setter for $site_subtitle_href. takes in a string, all html will be stripped
and	the value will be trimmed. This designates the link that will be wrapped
over the #subtitle element in the header and (possibly) the subtitle name in
the contact block of the footer.

constraints:
- must be of type string
- all html removed in all getters

default: 'http://www.sdes.ucf.edu/'

example usage:
$data->site_subtitle_href('http://www.sdes.ucf.edu/');
$data->site_subtitle_href('../');
---------------------------------------------------------------------------- */
//$data->site_subtitle_href('../');


/* ----------------------------------------------------------------------------
	SITE STYLE (CSS) INCLUDES
------------------------------------------------------------------------------- 
description:
setter for $site_css. takes in two parameters: the path to the file to be
included; the type of media the CSS should be rendered within. Allowed strings
for the second parameter are set in $allowed_media_types. if constraints are
passed, the set of values will be passed into $site_css as a key/value pair,
meaning this method can be called multiple times.

constraints:
- parameter 1 must be of type string
- parameter 2 must exist within $allowed_media_types

default: null

example usage:
$data->site_css('https://assets.sdes.ucf.edu/css/sdes_ucf.css','screen');
$data->site_css('css/style.css','screen');
$data->site_css('css/print.css','print');
---------------------------------------------------------------------------- */
$data->site_css('https://assets.sdes.ucf.edu/css/sdes_ucf.css','screen');


/* ----------------------------------------------------------------------------
	SITE JAVASCRIPT INCLUDES
------------------------------------------------------------------------------- 
description:
setter for $site_js. takes in the path to the javascript file to be included.
this method	can be called multiple times.

constraints:
- must be of type string

default: null

example usage:
$data->site_js('https://assets.sdes.ucf.edu/scripts/jquery.hoverIntent.js');
$data->site_js('scripts/application.js');
---------------------------------------------------------------------------- */



/* ----------------------------------------------------------------------------
	SITE JAVASCRIPT GLOBAL SCRIPTS (RAW JAVASCRIPT)
------------------------------------------------------------------------------- 
description:
setter for $site_js_raw. takes in a string of javascript to be included. this
method can only be called once. the getter will place this string inside a
<script type="text/javascript"> tag.

constraints:
- must be of type string

default: null

example usage:
$raw = 
'$(document).ready(function(){
	$("style").remove();
	$("[align=\'center\']").removeAttr("align");
});';

$data->site_js_raw($raw);
---------------------------------------------------------------------------- */



/* ----------------------------------------------------------------------------
	SITE GOOGLE ANALYTICS TRACKING URCHIN
------------------------------------------------------------------------------- 
description:
setter for $site_gaid. takes in a string that represents the property ID for
the given Google Analytics property. the getter will place the ID within a
much-larger javascript script.

constraints:
- must be of type string
- must begin with the substring 'UA-'

default: null

example usage:
$data->site_gaid('UA-6562360-20');
---------------------------------------------------------------------------- */
$data->site_gaid('UA-6562360-1');


/* ----------------------------------------------------------------------------
	SITE NAVIGATION
------------------------------------------------------------------------------- 
description:
setter for $site_navigation. takes in an array of values that should be formed
as a key/value pair, with the value representing the href of the navigation
link and the key representing the text to place within the anchor. as external
links are NOT allowed within a site navigation, the setter checks for the
existance of http or www and fails if found. if constraints are passed, each
element of the passed array will be set to $site_navigation as a key/value
pair.

constraints:
- must be of type array
- all key must NOT begin with 'http' or 'www'

default: null

example usage:
$data->site_navigation([
	'Home' => './',
	'About' => 'about',
	'Teams' => 'teams',
	'Services' => 'services',
	'Training' => 'teams#training',
	'Resources' => 'resources',
	'Contact' => 'contact'
]);
---------------------------------------------------------------------------- */
$nav = [
	'Home' => './',
	'About' => 'about',
	'Teams' => 'teams',
	'Services' => 'services',
	'Training' => 'teams#training',
	'Resources' => 'resources',
	'Contact' => 'contact'
];
$data->site_navigation($nav);


/* ----------------------------------------------------------------------------
	SITE BILLBOARD AND/OR ROTATOR
------------------------------------------------------------------------------- 
description:
setter for the following properties: $site_billboard, $site_billboard_exists,
$site_billboard_dynamic, and $site_billboard_dynamic_type. takes in two
parameters: a boolean to indicate if the site has a billboard or not
(required); a filename (must be located within the includes directory) of a
file containing the HTML for the dynamic billboard. if the second parameter is
not set, it will default to 'billboard.inc'. If the file exists, the system
will assume that the billboard should be dynamic. If not, it will default to
the path stored by default in the $site_billboard property 
('images/billboard.jpg' by default).

constraints:
- parameter 1 must be a boolean
- parameter 2 must be a filename that exists within the includes directory
- if the billboard file does not exist, it will default to a static billboard

default:
$site_billboard = 'images/billboard.jpg'
$site_billboard_exists = true
$site_billboard_dynamic = null
$site_billboard_dynamic_type = 'nivo_slider'

example usage:
$data->site_billboard(false);
$data->site_billboard(true);
$data->site_billboard(true, 'altbillboard.inc');
---------------------------------------------------------------------------- */
//$data->site_billboard();


/* ----------------------------------------------------------------------------
	ALLOWED PAGES FOR THE SITE BILLBOARD
------------------------------------------------------------------------------- 
description:
setter for $site_billboard_allowed_pages. lets the user add specific page
paths that the billboard will appear under, in addition to the default pages.
dependent on the site billboard	actually existing.

constraints:
- value must be an array

default: ['home', 'thanks']

example usage:
$data->site_billboard_allowed_pages(['thanks2', 'thanks3']);
---------------------------------------------------------------------------- */
//$data->site_billboard_allowed_pages();


/* ----------------------------------------------------------------------------
	CONTENT PAGE INCLUDE PATH
------------------------------------------------------------------------------- 
description:
setter for $site_include_path. takes in a string that specifics the path to the
folder that contains the site pages. 

constraints:
- must be a string
- must end in a forward slash (/)
- character preceding the final character cannot be a forward slash (/)

default: null

example usage:
$data->site_include_path('pages/'); 
---------------------------------------------------------------------------- */
//$data->site_include_path();


/* ----------------------------------------------------------------------------
	CONTENT BELOW THE REPEATED NAVIGATION
------------------------------------------------------------------------------- 
description:
setter for $site_content_end_under. takes in a string of (expected) html
content and displays it within a set of div elements beneath the repeated
navigation div.

constraints:
- value must be a string

default: null

example usage:
$end = '<div class="sponsors">
	<div class="global-col3-1">
		<a href="http://www.designergreens.net/">
			<img src="images/static/designer-greens.jpg" alt="ad">
		</a>
	</div>
	<div class="global-col3-2" style="text-align:center">
		<a href="http://www.orlandosportandsocialclub.com/">
			<img src="images/static/sport-social-club.jpg" alt="ad">
		</a>
	</div>
	<div class="global-col3-3">
		<a href="http://www.nirsa.org//AM/Template.cfm?Section=Welcome">
			<img src="images/static/nirsa.jpg" class="floatright" alt="ad">
		</a>
	</div>
	<div class="hr-clear"></div>	
</div>';
$data->site_content_end_under($end);
---------------------------------------------------------------------------- */
//$data->site_billboard_allowed_pages();


/* ----------------------------------------------------------------------------
	SITE FOOTER COLUMN DATA
------------------------------------------------------------------------------- 
description:
setter for all site footer-related properties. takes in between two required
parameters and five paramters to form the first and second columns in the
footer. parameter 1 determines the position (range defined by $allowed, 
defaults to 1 or 2). parameters 2 and 3 indicate the title and elements of the
column. the passed array for elements can contain up to 
$site_footer_column_limit elements.

parameters 4 and 5 also specify a second set of title and elements. if
parameters 4 and 5 are specified, the specified positioned column will be 
divided into two smaller columns that can both receive up to 
$site_footer_column_limit elements.

constraints:
- parameter 1 must be an integer that exists within $allowed
- parameter 2 must be a string
- parameter 3 must be an array with $site_footer_column_limit values
- (optional) parameter 4 must be a string
- (optional) parameter 5 must be an array with $site_footer_column_limit values

default:
$data->site_footer(1, 'Site Hosted by SDES', $this->site_footer_col1_default);
$data->site_footer(2, 'UCF Today News', parse_rss_template());

example usage:
$data->site_footer(1, 'Upcoming Events', parse_rss_template());
$data->site_footer(2, 'News', parse_rss_template(), 'Events', $events);
$data->site_footer(1, '', []);
---------------------------------------------------------------------------- */
//$data->site_footer(1, 'Site Hosted by SDES', $this->site_footer_col1_default);
//$data->site_footer(2, 'UCF Today News', parse_rss_template());


/* ----------------------------------------------------------------------------
	UCF ICON LINK IN FOOTER
------------------------------------------------------------------------------- 
description:
setter for $site_footer_ucf_icon. takes in a string and sets that string to the
href for the UCF Icon in the footer. This is useful for hiding a link to an
administration console, a SharePoint site, or other authenticated source.

constraints:
- must be of type string

default: 'http://www.ucf.edu/'

example usage:
$data->site_footer_ucf_icon('admin/');
---------------------------------------------------------------------------- */
//$data->site_footer_ucf_icon();


/* ----------------------------------------------------------------------------
	BASIC DIRECTORY INFORMATION
------------------------------------------------------------------------------- 
description:
setter for phone, fax, email, and location properties. all fields are required,
but any field can be passed as null. takes in one array with five (5) values:
phone; fax;	valid email address; location name; location ID
(UCF Map Building Number). A helper function is included with 
template_functions_generic that takes in a directory node and pushes it into
this method.

constraints:
- must be of type array
- array must contain five values

default: null

example usage:
$data->site_directory_basics([
	'phone' => '407-823-5753',
	'fax' => NULL,
	'email' => 'fy@ucf.edu',
	'location' => 'Howard Philips Hall 156',
	'mapId' => '27'
]);
$data->site_directory_basics(load_basics_from_directory($dir));
---------------------------------------------------------------------------- */
$dir = get_directory_info('it');
$data->site_directory_basics(load_basics_from_directory($dir));


/* ----------------------------------------------------------------------------
	HOURS OF OPERATION
------------------------------------------------------------------------------- 
description:
setter for $site_hours, which houses 14 individual values in a mutlidimensional
array (two values for each of the seven days of the week). takes in one array
that must have seven values, and each value must be an array with two values
each. these two-value arrays must contain valid timestamps or nulls.

constraints:
- must be of type array
- array must contain seven arrays of two values each
- each value must be valid timestamp (hh:mm:ss) or null

default: null

example usage:
$hours = [
	['08:00:00', '17:00:00'],
	['08:00:00', '17:00:00'],
	['08:00:00', '18:00:00'],
	['08:00:00', '17:00:00'],
	['08:00:00', '17:00:00'],
	[NULL, NULL],
	[NULL, NULL]
];
$data->site_hours($hours);

$dir = get_directory_info('sarc');
$data->site_hours(load_hours_from_directory($dir['hours']));
---------------------------------------------------------------------------- */
$data->site_hours(load_hours_from_directory($dir['hours']));


/* ----------------------------------------------------------------------------
	SOCIAL NETWORKING PRESENCES
------------------------------------------------------------------------------- 
description:
setter for $site_social, which houses URIs to various social networking
presences, set in $allowed. takes in an array which is required to have 
key/value pairs where the key matches an element in $allowed and the value is
a valid URI.

constraints:
- must be of type array
- each element of the array must contain a key/value pair
- index of each element must exist within $allowed
- value of each element must be a valid URI

default: null

example usage:
$data->site_social([
	'facebook' => 'http://www.facebook.com/UCFSARC',
	'picasa' => 'http://www.facebook.com/UCFSARC',
	'twitter' => 'http://twitter.com/ucfvarc',
	'wordpress' => 'http://bewellucf.com/',
	'youtube' => 'http://www.youtube.com/fbrogers'
]);
---------------------------------------------------------------------------- */
$data->site_social(load_social_from_directory($dir));

?>