<?php if(!isset($data) or !$data instanceof TemplateData) die('Template has no data!');

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
	$data->site_meta('robots', 'noindex');


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
	$data->site_base('http://'.$_SERVER['SERVER_NAME'].'/');


	/* ----------------------------------------------------------------------------
		SITE TITLE
	------------------------------------------------------------------------------- 
	description:
	setter for $site_title. takes in a string, all html will be stripped
	
	constraints:
	- character limit of 45 characters by default
	- all html removed in all getters

	default:
	'SITE_TITLE'
	
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

	default:
	'Student Development<br /> and Enrollment Services'
	
	example usage:
	$data->site_subtitle('Student Development<br /> and Enrollment Services');
	---------------------------------------------------------------------------- */
	$data->site_subtitle('Student Development<br /> and Enrollment Services');

	//css
	$data->site_css('https://assets.sdes.ucf.edu/css/sdes_ucf.css','screen');
	$data->site_css('css/style.css','screen');

	//javascript
	$data->site_js('https://assets.sdes.ucf.edu/scripts/jquery.hoverIntent.js');
	$data->site_js('https://assets.sdes.ucf.edu/scripts/jquery.easing.1.3.js');

	//google analytics
	$data->site_gaid('UA-6562360-20');
	
	//site navigation
	$data->site_navigation([
		'./' => 'Home',
		'about' => 'About',
		'services' => 'Services',
		'workshops' => 'Workshops',
		'resources' => 'Resources',
		'employment' => 'Employment',
		'contact' => 'Contact'
	]);
	
	//set billboard (billboard contents are in billboard.inc)
	$data->site_billboard(true, true);

	//under content-end
	$end = '<img src="images/FIPSElogo2.png" alt="FIPSE" class="floatleft" style="width: 50px;">
	<p><em>UCF is a Center of Excellence for Veteran Student Success; a U.S. Department of Education program funded 
	through the <a href="http://www2.ed.gov/about/offices/list/ope/fipse/index.html">Fund for the Improvement of Postsecondary Education</a> (FIPSE). 
	However, these contents do not represent an official endorsement by the Federal Government.</em></p>';
	$data->site_content_end_under($end);

	//footer
	$data->site_footer_ucf_icon('admin/');

	//site hours of operation
	$data->site_hours(load_hours_from_directory($dir['hours']));

	//site demographics (phone, fax, email, location, map)
	$dir = get_directory_info('sarc');
	$data->site_demographics(
		$dir['phone'],
		$dir['fax'],
		$dir['email'],
		$dir['location']['building'].' '.$dir['location']['roomNumber'],
		$dir['location']['buildingNumber']
	);

	//social networking presences
	$data->site_social([
		'facebook' => 'http://www.facebook.com/UCFSARC',
		'picasa' => 'http://www.facebook.com/UCFSARC',
		'twitter' => 'http://twitter.com/ucfvarc',
		'wordpress' => 'http://bewellucf.com/',
		'youtube' => 'http://www.youtube.com/fbrogers'
	]);
	
*/ ?>