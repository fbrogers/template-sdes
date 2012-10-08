<?php /*


	//go get data
	$dir = get_directory_info('sarc');
	$data->site_include_path('pages/');

	//header
	$data->site_title('Student Academic Resource Center');

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
	*/
?>