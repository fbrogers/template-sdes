<?php
/*********************************************************************
  __                        .__          __               .___       __          
_/  |_  ____   _____ ______ |  | _____ _/  |_  ____     __| _/____ _/  |______   
\   __\/ __ \ /     \\____ \|  | \__  \\   __\/ __ \   / __ |\__  \\   __\__  \  
 |  | \  ___/|  Y Y  \  |_> >  |__/ __ \|  | \  ___/  / /_/ | / __ \|  |  / __ \_
 |__|  \___  >__|_|  /   __/|____(____  /__|  \___  > \____ |(____  /__| (____  /
           \/      \/|__|             \/          \/       \/     \/          \/ 

Class:			TemplateData, TemplatePage
Author: 		Jordan Rogers <jr@ucf.edu>
Creation Date:	September 2012

/*********************************************************************
       .__                                 .__                 
  ____ |  |__ _____    ____    ____   ____ |  |   ____   ____  
_/ ___\|  |  \\__  \  /    \  / ___\_/ __ \|  |  /  _ \ / ___\ 
\  \___|   Y  \/ __ \|   |  \/ /_/  >  ___/|  |_(  <_> ) /_/  >
 \___  >___|  (____  /___|  /\___  / \___  >____/\____/\___  / 
     \/     \/     \/     \//_____/      \/           /_____/ 

2012-09-24 Jordan Rogers <jr@ucf.edu>
	* added hasAdmin getter, setter, property
	* general clean-up

2012-09-24 Jordan Rogers <jr@ucf.edu>
	* added footer functions, getters, and setters
	* implemented some missing CSS on sdes_main
	* reflected changes to sdes_main template

2012-09-21 Jordan Rogers <jr@ucf.edu>
	* functional build
	* defined order of operations
	
2012-09-20 Jordan Rogers <jr@ucf.edu>
	* initial build

/*********************************************************************/

class TemplateData{
	//general settings
	private $site_title_length = 45;
	private $site_footer_column_limit = 8;

	//defines the site title in the <title> tag, the contact block in the footer, and the div#title element
	private $site_title;
	private $site_title_href;
	private $site_subtitle;
	private $site_subtitle_href;

	//collection of custom meta tags
	private $site_meta_tags = array();
	private $site_base;

	//collection of custom css/js files included in the header
	private $site_includes_css = array();
	private $site_includes_js = array();
	private $site_js;

	//the private Google Analytics ID
	private $site_gaid;
	
	//site navigation
	private $site_navigation = array();

	//billboard content
	private $site_billboard;
	private $hasBillboard;
	private $isSlider;
	private $slider;
	
	//allowed pages for the billboard
	private $site_billboard_allowed = array();
	
	//variable for the page filename
	private $site_include_path;
	private $page;
	private $page_title;
	
	//variable for the page contents
	private $page_content;

	//collection of title bar links
	private $page_content_links = array();
	
	//data above/below the main content block;
	private $page_content_above;
	private $page_content_below;
	
	//data below the bottom navigation
	private $site_title_under;
	private $site_content_end_under;

	//footer fields
	private $site_footer_col1 = array();
	private $site_footer_col2 = array();
	private $site_footer_col1_1 = array();
	private $site_footer_col1_2 = array();
	private $site_footer_col2_1 = array();
	private $site_footer_col2_2 = array();
	private $site_footer_col1_title;
	private $site_footer_col2_title;
	private $site_footer_col1_1_title;
	private $site_footer_col1_2_title;
	private $site_footer_col2_1_title;
	private $site_footer_col2_2_title;
	private $site_footer_ucf_icon;

	//basic demographic fields
	private $site_phone;
	private $site_fax;
	private $site_email;
	private $site_location_name;
	private $site_location_id;
	
	//social networking array
	private $site_social = array();

	//defaults
	private $site_footer_col1_default = [
		'https://publishing.ucf.edu/sites/sdes/' => 'SDES Home',
		'https://publishing.ucf.edu/sites/sdes/Pages/WhatisSDES.aspx' => 'What is SDES? / About',
		'https://publishing.ucf.edu/sites/sdes/Pages/Departments.aspx' => 'SDES Departments',
		'https://publishing.ucf.edu/sites/sdes/Pages/Calendar.aspx' => 'Division Calendar',
		'https://publishing.ucf.edu/sites/sdes/Pages/Contact.aspx' => 'Contact Us',
		'https://publishing.ucf.edu/sites/sdes/Pages/Staff.aspx' => 'SDES Leadership Team',
		'http://creed.sdes.ucf.edu/' => 'The UCF Creed',
		'http://it.sdes.ucf.edu/' => 'SDES Information Technology',
	];
	
	//object constructor
	public function __construct(){
	
		//included functions
		require_once realpath('C:\WebDFS\Websites\_phplib\template_functions_generic.php');

		//sets the default title to dummy text and href to self
		$this->site_title = 'SITE_TITLE';
		$this->site_title_href = './';

		//sets the default subtitle to SDES
		$this->site_subtitle = 'Student Development<br /> and Enrollment Services';
		$this->site_subtitle_href = 'http://www.sdes.ucf.edu/';

		//defaults for the billboard and/or slider
		$this->site_billboard = 'images/slate.jpg';
		$this->site_billboard_allowed = ['home', 'thanks'];
		$this->hasBillboard = true;
		$this->isSlider = false;
		$this->slider = 'nivo_slider';
		
		//content block
		$this->site_include_path = NULL;
		$this->site_title_under = '<div class="top"></div>';

		//footer block
		$this->site_footer(1, 'Site Hosted by SDES', $this->site_footer_col1_default);
		$this->site_footer(2, 'UCF Today News', parse_rss_template());
		$this->site_footer_ucf_icon = 'http://www.ucf.edu/';
	}

	public static function load_data(TemplateData $data){

		//include data
		require_once('includes/data.inc.php');

		//return object
		return $data;
	}

/*-----------------------------------------------------------------------------------------*/
/*--- DATA INPUT METHODS ------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------*/

	public function site_include_path($path){

		//check type
		if(!is_string($path)){
			throw new Exception('Include path must be a string.');
		}

		//ensure that final character is a forward slash
		if(substr($path, -1) != '/' or substr($path, -2) == '/'){
			throw new Exception('Include path must terminate with a forward slash.');
		}

		//set
		$this->site_include_path = $path;
	}

	public function get_site_include_path(){

		return $this->site_include_path;
	}

	public function site_footer_ucf_icon($href){

		//check type
		if(!is_string($href)){
			throw new Exception('Must be a string.');
		}

		//checks to ensure that the text contains no HTML except images
		$href = trim(strip_tags($href));

		//set the internal reference
		$this->site_footer_ucf_icon = $href;		
	}

	public function site_footer($position, $title1, $elements1, $title2 = NULL, $elements2 = NULL){

		//allowed positions
		$allowed = [1, 2];

		//check type
		if(!is_array($elements1) or !is_int($position) or !in_array($position, $allowed)){
			throw new Exception('Type is not correct for footer column.');
		}

		//check length of array, both elements 1 and 2
		if(count($elements1) > $this->site_footer_column_limit or (is_array($elements2) and count($elements2) > $this->site_footer_column_limit)){
			throw new Exception('Arrays must be capped at '.$this->site_footer_column_limit.' elements in the footer.');
		}

		//mini columns
		if(is_array($elements2)){

			//switch for position
			switch($position){
				case 1:
					$this->site_footer_col1_1 = $elements1;
					$this->site_footer_col1_1_title = $title1;
					$this->site_footer_col1_2 = $elements2;
					$this->site_footer_col1_2_title = $title2;
					break;
				case 2:
					$this->site_footer_col2_1 = $elements1;
					$this->site_footer_col2_1_title = $title1;
					$this->site_footer_col2_2 = $elements2;
					$this->site_footer_col2_2_title = $title2;
					break;
			}

		}else{

			//switch for position
			switch($position){
				case 1:
					$this->site_footer_col1 = $elements1;
					$this->site_footer_col1_title = $title1;
					break;
				case 2:
					$this->site_footer_col2 = $elements1;
					$this->site_footer_col2_title = $title1;
					break;
			}
		}
	}

	public function load_page(TemplatePage $page){
	
		//get private values
		$page_data = $page->page_public();
	
		//variable for the page filename
		$this->page = $page_data['path'];
		$this->page_title = $page_data['title'];
		
		//variable for the page contents
		$this->page_content = $page_data['content'];

		//collection of title bar links
		$this->page_content_links = $page_data['links'];
		
		//data above/below the main content block;
		$this->page_content_above = $page_data['above'];
		$this->page_content_below = $page_data['below'];	
	}
	
	//set the site title
	public function site_title($text){

		//check type
		if(!is_string($text)){
			throw new Exception('Site title must be a string.');
		}

		//checks to ensure that the text contains no HTML except images
		$text = strip_tags(trim($text), '<img>');

		//ensure that the text can fit into the template
		if(strlen($text) > $this->site_title_length){
			throw new Exception('Site title must be less than 45 characters.');
		}

		//set the internal reference
		$this->site_title = $text;
	}

	//set the site subtitle
	public function site_subtitle($text){

		//check type
		if(!is_string($text)){
			throw new Exception('Site title must be a string.');
		}

		//checks to ensure that the text contains no HTML except breaks and images
		$text = strip_tags(trim($text), '<br><img>');

		//ensure that the text can fit into the template
		if(strlen($text) > $this->site_title_length){
			throw new Exception('Site title must be less than 45 characters.');
		}

		//set the internal reference
		$this->site_subtitle = $text;
	}

	//set the site title uri
	public function site_title_href($href){

		//check type
		if(!is_string($href)){
			throw new Exception('Site title HREF must be a string.');
		}

		//checks to ensure that the text contains no HTML except breaks and images
		$text = strip_tags(trim($text));

		//set the internal reference
		$this->site_title_href = $href;
	}


	//set the site title uri
	public function site_subtitle_href($href){

		//check type
		if(!is_string($href)){
			throw new Exception('Site subtitle HREF must be a string.');
		}

		//checks to ensure that the text contains no HTML except breaks and images
		$text = strip_tags(trim($text));

		//set the internal reference
		$this->site_subtitle_href = $href;
	}

	//set the included css files
	public function site_includes_css($file, $media = 'screen'){

		//type check
		if(!is_string($file)){
			throw new Exception('Site includes must be passed as a string.');
		}

		//possible values for $type
		$allowed_media_types = ['all', 'screen', 'print', 'tv', 'handheld'];

		//challenge the media type
		if(!in_array($media, $allowed_media_types)){
			throw new Exception('Media type is not allowed.');
		}

		//construct the CSS type
		$node = ['path' => $file, 'media' => $media];

		//add to the internal reference
		$this->site_includes_css[] = $node;
	}

	//set the included js files
	public function site_includes_js($file){

		//type check
		if(!is_string($file)){
			throw new Exception('Site includes must be passed as a string.');
		}

		//add to the internal reference
		$this->site_includes_js[] = $file;
	}

	//set the raw javascript
	public function site_js($js){

		//type check
		if(!is_string($js)){
			throw new Exception('Site meta content must be passed as strings.');
		}

		//add to the private reference
		$this->site_js = $js;
	}

	//set the custom meta tags into the array
	public function site_meta_tag($name, $content){

		//type check
		if(!is_string($name) or !is_string($content)){
			throw new Exception('Site meta content must be passed as strings.');
		}

		//construct the CSS type
		$node = ['name' => $name, 'content' => $content];

		//add to the internal reference
		$this->site_meta_tags[] = $node;
	}

	//set the Google Analytics ID
	public function site_gaid($id){
	
		//type check
		if(!is_string($id)){
			throw new Exception('Site meta content must be passed as strings.');
		}

		//value check
		if(substr($id, 0, 3) != 'UA-'){
			throw new Exception("Google Analytics ID not well-formed.", 1);			
		}

		//move the id into the private property
		$this->site_gaid = $id;
	}
	
	//set the site navigation
	public function site_navigation($elements){
	
		//verify type
		if(is_array($elements)){
		
			//loop array elements
			foreach($elements as $href => $text){
			
				//policy enforcement
				if(substr($href, 0, 4) == 'http' or substr($href, 0, 3) == 'www'){
					throw new Exception('External links are not allowed in the site navigation.', 1);
				}
			
				//save to 
				$this->site_navigation[$href] = strip_tags($text);
			}
		}
	}
	
	//set the options for the billboard
	public function site_billboard($hasBillboard, $isSlider){
	
		//type check
		if(!is_bool($hasBillboard) or !is_bool($isSlider)){
			throw new Exception('First two parameters must be boolean.', 1);
		}
	
		//set object properties
		$this->hasBillboard = $hasBillboard;
		$this->isSlider = $isSlider;

		//include billboard contents
		if($hasBillboard){
			
			//load billboard.inc
			$this->site_billboard = file_get_contents('includes/billboard.inc');

			//throw exception if unable to load file
			if(!$this->site_billboard){
				throw new Exception("Error opening billboard HTML include", 1);
			}
		}
	}
	
	//set the content under the repeated navigation
	public function site_content_end_under($content){
		$this->site_content_end_under = $content;
	}
	
	//set up the basic required demographic fields for a site
	public function site_demographics($phone, $fax, $email, $location, $mapId){
	
		//property assignment
		$this->site_phone = $phone;
		$this->site_fax = $fax;
		$this->site_email = $email;
		$this->site_location_name = $location;
		$this->site_location_id = $mapId;
	}
	
	//set up the social networking presences for the site
	public function site_social($collection){
	
		//type check
		if(!is_array($collection)){
			throw new Exception('Site social must be passed as an array.');
		}
		
		//possible values for $type
		$allowed = ['facebook', 'picasa', 'skype', 'tumblr', 'twitter', 'wordpress', 'youtube'];

		//loop
		foreach($collection as $type => $val){
			
			//challenge the media type
			if(!in_array($type, $allowed)){
				throw new Exception('Social media type is not allowed.');
			}
			
			//store
			$this->site_social[$type] = $val;
		}
	}

/*-----------------------------------------------------------------------------------------*/
/*--- HTML OUTPUT METHODS -----------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------*/

	//generate meta tag html
	public function html_block_contact($full = false){

		//init
		$output = NULL;

		//check all fields first
		if($this->site_phone != NULL or
			$this->site_fax != NULL or
			$this->site_email != NULL or
			($this->site_location_name != NULL and $this->site_location_id != NULL)){

			//start block code
			$output .= '<table class="grid smaller">'."\n";

			//if phone is set
			if($this->site_phone != NULL){

				//start table row
				$output .= '<tr>'."\n";

				//table row header
				$output .= '<th scope="row">Phone</th>'."\n";

				//table row data
				$output .= '<td>'.$this->site_phone.'</td>'."\n";

				//construct the html node
				$output .= '</tr>'."\n";
			}

			//if fax is set
			if($this->site_fax != NULL){

				//start table row
				$output .= '<tr>'."\n";

				//table row header
				$output .= '<th scope="row">Fax</th>'."\n";

				//table row data
				$output .= '<td>'.$this->site_fax.'</td>'."\n";

				//construct the html node
				$output .= '</tr>'."\n";
			}

			//if fax is set
			if($this->site_email != NULL){

				//start table row
				$output .= '<tr>'."\n";

				//table row header
				$output .= '<th scope="row">Email</th>'."\n";

				//table row data
				$output .= '<td>'.$this->html_email_link().'</td>'."\n";

				//construct the html node
				$output .= '</tr>'."\n";
			}

			//if location is set
			if($this->site_location_id != NULL and $this->site_location_name != NULL){

				//start table row
				$output .= '<tr>'."\n";

				//table row header
				$output .= '<th scope="row">Location</th>'."\n";

				//table row data
				$output .= '<td>'.$this->html_map_link().'</td>'."\n";

				//construct the html node
				$output .= '</tr>'."\n";
			}

			//end block code
			$output .= '</table>'."\n";
		}

		//return the html output
		return $output;
	}

	//generate meta tag html
	public function html_meta(){

		//init
		$output = NULL;

		//loop through all of the current meta tag nodes and generate the html
		foreach($this->site_meta_tags as $node){

			//check each piece for necessary indices
			if(!isset($node['name'], $node['content'])){
				throw new Exception('Meta tag generator missing required fields.');
			}

			//construct the html node
			$output .= '<meta name="'.$node['name'].'" content="'.$node['content'].'" />';

			//insert a clean newline
			$output .= "\n";
		}

		//return the html output
		return $output;
	}

	//generate base tag html
	public function html_base(){
	
		//init
		$output = NULL;

		if($this->site_base != NULL){
		
			//html
			$output .= '<base href="'.$this->site_base.'" />'."\n";
		}

		//return output
		return $output;
	}
	
	//generate title html
	public function html_site_title(){
	
		//init 
		$output = NULL;

		//check for null
		if($this->site_title != NULL){

			//add the title to the output
			$output .= $this->site_title;
		}

		//output
		return $output;
	}

	//generate css html
	public function html_css(){

		//init
		$output = NULL;

		//loop through all of the current css files and generate the html
		foreach($this->site_includes_css as $file){

			//check each piece for necessary indices
			if(!isset($file['path'], $file['media'])){
				throw new Exception('CSS generator missing required fields.');
			}

			//construct the html node
			$output .= '<link rel="stylesheet" href="'.$file['path'].'" type="text/css" media="'.$file['media'].'" />';

			//insert a clean newline
			$output .= "\n";
		}

		//output
		return $output;
	}

	//generate css html
	public function html_js(){

		//init
		$output = NULL;

		//loop through all of the current css files and generate the html
		foreach($this->site_includes_js as $file){

			//insert a clean newline
			$output .= "\t";

			//construct the html node
			$output .= '<script type="text/javascript" src="'.$file.'"></script>';

			//insert a clean newline
			$output .= "\n";
		}

		//output
		return $output;
	}

	//raw javascript output
	public function html_js_raw(){

		//init
		$output = NULL;

		//if there is raw js, echo it
		if($this->site_js != NULL){

			//start script tag
			$output .= '<script type="text/javascript">'."\n";

			//dump the raw js
			$output .= $this->site_js;

			//end script tag
			$output .= '</script>'."\n";

		}

		//return output
		return $output;
	}
	
	//print out the html for the slider of choice
	public function html_slider_code(){
	
		//init
		$output = NULL;
		
		//check the size of the array
		if($this->isSlider and !empty($this->site_billboard)){
		
			switch($this->slider){

				case 'nivo_slider':
					$output .= $this->generate_nivo_slider();
					break;
			}			
		}
		
		//return
		return $output;
	}
	
	//html block for Google Analytics ASYNC Urchin
	public function generate_google_analytics_urchin(){
		$output = '
	<!-- GA-ASYNC -->
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push([\'_setAccount\', \''.$this->site_gaid.'\']);
		_gaq.push([\'_trackPageview\']);
		(function() { 
			var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
			ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
			(document.getElementsByTagName(\'head\')[0] || document.getElementsByTagName(\'body\')[0]).appendChild(ga);
		})();
	</script>
	<!-- /GA-ASYNC -->
		';

		 //return clean
		 return $output;
	}
	
	//print out div#title
	public function html_site_title_div(){
		
		//init
		$output = NULL;
		
		//check the size of the array
		if(!empty($this->site_title) && !empty($this->site_title_href)){
		
			//start navigation
			$output .= '<a href="'.$this->site_title_href.'">'.$this->site_title.'</a>'."\n";
		}
		
		//return
		return $output;
	}
	
	//print out div#subtitle
	public function html_site_subtitle_div(){
		
		//init
		$output = NULL;
		
		//check the size of the array
		if(!empty($this->site_subtitle) && !empty($this->site_subtitle_href)){
		
			//start navigation
			$output .= '<a href="'.$this->site_subtitle_href.'">'.$this->site_subtitle.'</a>'."\n";
		}
		
		//return
		return $output;
	}
	
	//print out the html for site navigation
	public function html_site_navigation(){
		
		//init
		$output = NULL;
		
		//check the size of the array
		if(!empty($this->site_navigation)){
		
			//start navigation
			$output .= '<ul id="nav-under">'."\n";
		
			//loop through navigation array
			foreach($this->site_navigation as $href => $text){
				
				//single navigation element
				$output .= "\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";				
			}
			
			//start navigation
			$output .= "\t\t".'</ul>'."\n";		
		}
		
		//return
		return $output;
	}
	
	public function html_site_navigation_bottom(){
		
		//init
		$output = NULL;
		
		//check the size of the array
		if(!empty($this->site_navigation)){
		
			//start navigation
			$output .= '<ul>'."\n";
		
			//loop through navigation array
			foreach($this->site_navigation as $href => $text){
				
				//single navigation element
				$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";				
			}
			
			//start navigation
			$output .= "\t\t\t\t".'</ul>'."\n";		
		}
		
		//return
		return $output;
	}
	
	public function html_site_social_bottom(){
	
		//init
		$output = NULL;
		
		//if there are any social networking sites enabled
		if(!empty($this->site_social)){

			//reverse order of array for better usability
			$this->site_social = array_reverse($this->site_social, true);

			//loop through each one and fire off some icons
			foreach($this->site_social as $type => $val){

				//start link
				$output .= '<a href="'.urlencode($val).'">'."\n\t\t\t\t\t";

				//pick out an image
				switch($type){
					case 'facebook':
						$output .= '<img src="http://assets.sdes.ucf.edu/images/icons/facebook.png" class="icon" alt="icon" title="Facebook" />';
						break;

					case 'picasa':
						$output .= '<img src="http://assets.sdes.ucf.edu/images/icons/picasa.png" class="icon" alt="icon" title="Google Picasa" />';
						break;

					case 'skype':
						$output .= '<img src="http://assets.sdes.ucf.edu/images/icons/skype.png" class="icon" alt="icon" title="Skype" />';
						break;

					case 'twitter':
						$output .= '<img src="http://assets.sdes.ucf.edu/images/icons/twitter.png" class="icon" alt="icon" title="Twitter" />';
						break;

					case 'wordpress':
						$output .= '<img src="http://assets.sdes.ucf.edu/images/icons/wordpress.png" class="icon" alt="icon" title="WordPress Blog" />';
						break;

					case 'youtube':
						$output .= '<img src="http://assets.sdes.ucf.edu/images/icons/youtube.png" class="icon" alt="icon" title="YouTube" />';
						break;
				}

				//start link
				$output .= "\n\t\t\t\t".'</a>'."\n";
			}
		}
		
		//return an html string of output
		return $output;	
	}
	
	public function html_billboard(){
	
		//init
		$output = NULL;
		
		//if the billboard bitflag is on
		if($this->hasBillboard and in_array($this->page, $this->site_billboard_allowed)){
		
			//if the slider bitflag is on
			if($this->isSlider){

				//output the entire contents of the site_billboard
				$output .= $this->site_billboard;
		
			} else {

				//output the image inside the preformed slate container
				$output .= '
				<div id="slate_container"> 
					<div id="slate"> 
						<img src="'.$this->site_billboard.'" alt="billboard image" /> 
					</div> 
				</div>';
			}
		}
		
		//output html
		return $output;	
	}
	
	public function html_page_title(){
		//init
		$output = NULL;
		
		//conditional
		if($this->page_title != NULL && $this->page != 'home'){
		
			//set the title without any html
			$output .= strip_tags($this->page_title);
			
			//separater
			$output .= ' | ';
		
		}		
		
		//output html
		return $output;	
	}
	
	public function html_page_content_links(){
		//init
		$output = NULL;
		
		//conditional
		if(!empty($this->page_content_links)){
			
			//render beginning of wrapper
			$output .= '<ul class="content-main-links">'."\n";
		
			foreach($this->page_content_links as $href => $text){
			
				//set the title without any html except <em> and <strong>
				$output .= '<li><a href="'.$href.'">'.$text.'</a></li>';
			}
			
			//render end of wrapper
			$output .= '</ul>'."\n";
		}		
		
		//output html
		return $output;	
	}

	public function html_page_content_title(){
		//init
		$output = NULL;
		
		//conditional
		if($this->page_title != NULL){
			
			//render beginning of h1
			$output .= '<h1 id="content_top">';
		
			//set the title without any html except <em> and <strong>
			$output .= strip_tags($this->page_title, '<em><strong>');
			
			//render end of h1
			$output .= '</h1>'."\n";
			
			//render divider under h1
			$output .= $this->site_title_under."\n";
		}		
		
		//output html
		return $output;	
	}

	public function html_page_content(){
		//init
		$output = NULL;
		
		//conditional
		if($this->page_content != NULL){
		
			//set the title without any html
			$output .= $this->page_content;
		}		
		
		//output html
		return $output;	
	}
	
	public function html_page_content_above(){
		//init
		$output = NULL;
		
		//conditional
		if($this->page_content_above != NULL){
		
			//set the title without any html
			$output .= $this->page_content_above;
			
			//newline, for kicks
			$output .= "\n";
		}		
		
		//output html
		return $output;	
	}

	public function html_page_content_below(){
		//init
		$output = NULL;
		
		//conditional
		if($this->page_content_below != NULL){
		
			//set the title without any html
			$output .= $this->page_content_below;
			
			//newline, for kicks
			$output .= "\n";
		}		
		
		//output html
		return $output;	
	}

	public function html_site_content_end_under(){
		//init
		$output = NULL;
		
		//conditional
		if($this->site_content_end_under != NULL){
		
			//set the title without any html
			$output .= $this->site_content_end_under;
			
			//newline, for kicks
			$output .= "\n";
		}		
		
		//output html
		return $output;	
	}

	public function html_site_footer($position){
		//init
		$output = NULL;

		//allowed positions
		$allowed = [1,2];

		if(!in_array($position, $allowed)){
			throw new Exception("Position out of bounds.", 1);			
		}
		
		//conditional
		switch($position){

			case 1:
				if($this->site_footer_col1_1 != NULL && $this->site_footer_col1_2 != NULL){

					//render beginning of wrapper
					$output .= '<div class="col3-1-1">'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col1_1_title.'</div>'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					foreach($this->site_footer_col1_1 as $href => $text){
					
						//set the title without any html except <em> and <strong>
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";

					//render end of wrapper
					$output .= "\t\t\t".'</div>'."\n";

					//render beginning of wrapper
					$output .= "\t\t\t".'<div class="col3-1-2">'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col1_2_title.'</div>'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					foreach($this->site_footer_col1_2 as $href => $text){
					
						//set the title without any html except <em> and <strong>
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";

					//render end of wrapper
					$output .= "\t\t\t".'</div>'."\n";
				}else{

					//render beginning of wrapper
					$output .= '<div class="col3-1">'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col1_title.'</div>'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					foreach($this->site_footer_col1 as $href => $text){
					
						//set the title without any html except <em> and <strong>
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";

					//render end of wrapper
					$output .= "\t\t\t".'</div>'."\n";
				}
				break;

			case 2:
				if($this->site_footer_col2_1 != NULL && $this->site_footer_col2_2 != NULL){

					//render beginning of wrapper
					$output .= '<div class="col3-2-1">'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col2_1_title.'</div>'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					foreach($this->site_footer_col2_1 as $href => $text){
					
						//set the title without any html except <em> and <strong>
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";

					//render end of wrapper
					$output .= "\t\t\t".'</div>'."\n";

					//render beginning of wrapper
					$output .= "\t\t\t".'<div class="col3-2-2">'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col2_2_title.'</div>'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					foreach($this->site_footer_col2_2 as $href => $text){
					
						//set the title without any html except <em> and <strong>
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";

					//render end of wrapper
					$output .= "\t\t\t".'</div>'."\n";
				}else{

					//render beginning of wrapper
					$output .= '<div class="col3-2">'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col2_title.'</div>'."\n";			

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";

					//render beginning of wrapper
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					foreach($this->site_footer_col2 as $href => $text){
					
						//set the title without any html except <em> and <strong>
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";

					//render end of wrapper
					$output .= "\t\t\t".'</div>'."\n";
				}
				break;
		}
		
		//output html
		return $output;	
	}

	//email link
	public function html_site_footer_ucf_icon(){

		//init
		$output = NULL;
		
		//conditional
		if($this->site_footer_ucf_icon != NULL){
		
			//set the title without any html
			$output .= htmlentities($this->site_footer_ucf_icon);
		}		
		
		//output html
		return $output;	
	}

	//email link
	public function html_email_link(){

		//init
		$output = NULL;
		
		//conditional
		if($this->site_email != NULL){
		
			//set the title without any html
			$output .= '<a href="mailto:'.$this->site_email.'">'.$this->site_email.'</a>';
			
			//newline, for kicks
			$output .= "\n";
		}		
		
		//output html
		return $output;	
	}

	//email link
	public function html_map_link(){
		//init
		$output = NULL;
		
		//conditional
		if($this->site_location_name != NULL && $this->site_location_id != NULL){
		
			//set the title without any html
			$output .= '<a href="http://map.ucf.edu/?show='.$this->site_location_id.'">'.$this->site_location_name.'</a>';
			
			//newline, for kicks
			$output .= "\n";
		}		
		
		//output html
		return $output;	
	}

	//phone number
	public function html_phone(){
		//init
		$output = NULL;
		
		//conditional
		if($this->site_phone != NULL){
		
			//set the title without any html
			$output .= $this->site_phone;
		}		
		
		//output html
		return $output;	
	}

	//fax number
	public function html_fax(){
		//init
		$output = NULL;
		
		//conditional
		if($this->site_fax != NULL){
		
			//set the title without any html
			$output .= $this->site_fax;
		}		
		
		//output html
		return $output;	
	}

	//contact block
	public function html_site_footer_contact(){
		//init
		$output = '<p>';
		
		//site title
		$output .= $this->html_site_title_div().'<br />';

		//if phone and email are set, echo; else, use subtitle
		if($this->site_phone != NULL and $this->site_email != NULL){

			//phone
			$output .= 'Phone: '.$this->html_phone();

			//separator
			$output .= ' &bull; ';

			//email
			$output .= strlen($this->site_email) > 23
				? $this->html_email_link().'<br />'
				: 'Email: '.$this->html_email_link().'<br />';
		
		}else{

			//subtitle link
			$output .= '<a href="'.$this->site_subtitle_href.'">'.strip_tags($this->site_subtitle).'</a><br />';
		}

		//if phone and email are set, echo; else, use subtitle
		if($this->site_location_name != NULL and $this->site_location_id != NULL){

			//phone
			$output .= 'Location: '.$this->html_map_link().'<br />';

		}else{

			//subtitle link
			$output .= '<a href="#">UCF Phonebook</a> &bull;
			<a href="#">UCF Events</a> &bull;
			<a href="#">UCF Map</a> &bull;
			<a href="#">Ask UCF</a><br />';
		}

		//finish
		$output .= '</p>';
		
		//output html
		return $output;	
	}

	//html block for Nivo Slider
	public static function generate_nivo_slider(){
		 $output = '
	<!-- NIVO-SLIDER -->
	<link rel="stylesheet" href="https://assets.sdes.ucf.edu/plugins/nivoslider/jquery.nivo.slider.css" type="text/css" media="screen" />
	<script type="text/javascript" src="https://assets.sdes.ucf.edu/plugins/nivoslider/jquery.nivo.slider.js"></script>
	<script type="text/javascript">
		$(window).load(function() {
			var total = $(\'#slider img\').length;
			var rand = Math.floor(Math.random()*total);
			$("#slider").nivoSlider({
				startSlide: rand,
				effect: "random",
				slices:10,
				animSpeed:500,
				pauseTime:5000,
				directionNav:true,
				controlNav:false,
				captionOpacity:0.7
			});	
		});	
	</script>
	<!-- /NIVO-SLIDER -->
		 ';

		 //return clean
		 return $output;
	}
}

class TemplatePage{

	//variable for the page filename
	private $page;
	private $page_title;
	
	//variable for the page contents
	private $page_content;

	//collection of title bar links
	private $page_content_links = array();
	
	//data above/below the main content block;
	private $page_content_above;
	private $page_content_below;

	//get the current page via querystring
	public function __construct(TemplateData $data){
	
		//turn on output buffering
		ob_start();

		//flush the buffer
		ob_implicit_flush(0);

		//set page name to querystring id or home
		$this->page = isset($_GET['id']) ? $_GET['id'] : 'home';

		//get site include path from data object
		$path = $data->get_site_include_path();

		//load page into output buffer
		$real = realpath($path.basename($this->page).'.php');

		//if the file does not exist, kill the process
		if(!is_file($real)){
			die(header('HTTP/1.0 404 Not Found'));
		}

		//load the page data
		require_once($real);

		//save the page data into a variable
		$this->page_content = ob_get_contents();
		
		//page title
		if(isset($title)){
			$this->page_title = $title;
		}
		
		//page links
		if(isset($links) && is_array($links)){
			$this->page_content_links($links);
		}
		
		//page above content
		if(isset($above)){
			$this->page_content_above = $above;
		}
		
		//page below content
		if(isset($below)){
			$this->page_content_below = $below;
		}
		
		//clean up the output buffer
		ob_end_clean();	
	}
	
	//set some content main links
	public function page_content_links($collection){
	
		//verify type
		if(is_array($collection)){
		
			//loop array elements
			foreach($collection as $href => $text){
			
				//save to 
				$this->page_content_links[$href] = strip_tags($text);
			}
		}
	}
	
	//return private page values
	public function page_public(){
		
		$array = [
			'path' => $this->page,
			'title' => $this->page_title,
			'content' => $this->page_content,
			'links' => $this->page_content_links,
			'above' => $this->page_content_above,
			'below' => $this->page_content_below
		];
		
		return $array;	
	}
}
?>