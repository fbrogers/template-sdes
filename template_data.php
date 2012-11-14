<?php

class TemplateData{
	//general settings
	private $template_include_path = 'C:\WebDFS\Websites\_phplib\sdestemplate\\';
	private $data_include_path;
	private $template_icon_path = 'http://assets.sdes.ucf.edu/images/icons';
	private $site_title_length = 45;
	private $site_subtitle_length = 60;
	private $site_footer_column_limit = 8;

	//site template
	private $site_template;

	//collection of custom meta tags
	private $site_meta = array();
	private $site_base;

	//defines the site title in the <title> tag, the contact block in the footer, and the div#title element
	private $site_title;
	private $site_title_href;
	private $site_subtitle;
	private $site_subtitle_href;

	//collection of custom css/js files included in the header
	private $site_css = array();
	private $site_js = array();
	private $site_js_raw;

	//the private Google Analytics ID
	private $site_gaid;
	
	//site navigation
	private $site_navigation = array();

	//billboard content
	private $site_billboard;
	private $site_billboard_exists;
	private $site_billboard_dynamic;
	private $site_billboard_dynamic_type;
	
	//allowed pages for the billboard
	private $site_billboard_allowed_pages = array();
	
	//properties for the included page to set
	private $site_include_path;
	private $page;
	private $page_title;
	private $page_content;
	private $page_content_links;
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
	private $site_hours = array();
	private $site_phone;
	private $site_fax;
	private $site_email;
	private $site_location_name;
	private $site_location_id;
	
	//social networking array
	private $site_social = array();

	//defaults
	private $site_footer_col1_default = [
		'SDES Home' => 'http://www.sdes.ucf.edu/',
		'What is SDES? / About' => 'http://www.sdes.ucf.edu/about',
		'SDES Departments' => 'http://www.sdes.ucf.edu/departments',
		'Division Calendar' => 'http://www.sdes.ucf.edu/events',
		'Contact Us' => 'http://www.sdes.ucf.edu/contact',
		'SDES Leadership Team' => 'http://www.sdes.ucf.edu/staff',
		'The UCF Creed' => 'http://creed.sdes.ucf.edu/',
		'SDES Information Technology' => 'http://it.sdes.ucf.edu/'
	];
	
	//object constructor
	public function __construct(){
	
		//included functions, formProcessor class
		require_once($this->template_include_path.'template_functions_generic.php');
		require_once($this->template_include_path.'..\formprocessor\forms.php');

		//include path for data
		$this->data_include_path = 'includes/';

		//default template
		$this->site_template = 'main';

		//sets the default title to dummy text and href to self
		$this->site_title = 'SITE_TITLE';
		$this->site_title_href = './';

		//sets the default subtitle to SDES
		$this->site_subtitle = 'Student Development<br /> and Enrollment Services';
		$this->site_subtitle_href = 'http://www.sdes.ucf.edu/';

		//defaults for the billboard and/or slider
		$this->site_billboard = 'images/billboard.jpg';
		$this->site_billboard_exists = true;
		$this->site_billboard_dynamic_type = 'nivo_slider';
		$this->site_billboard_allowed_pages = ['home', 'thanks'];
		
		//content block
		$this->site_include_path = NULL;
		$this->site_title_under = '<div class="top"></div>';

		//footer block
		$this->site_footer(1, 'Site Hosted by SDES', $this->site_footer_col1_default);
		$this->site_footer(2, 'UCF Today News', parse_rss_template());
		$this->site_footer_ucf_icon = 'http://www.ucf.edu/';	
	}

/*-------------------------------------------------------------------------------------------------------------------*/
/*--- INTERACTION METHODS WITH TemplatePage -------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/

	//mapped method to TemplatePate object to retrieve page data
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

	//set the include path for pages within the site
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

/*-------------------------------------------------------------------------------------------------------------------*/
/*--- SITE DATA INPUT METHODS (MUTATORS / SETTERS) ------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/

	//sets the default includes directory
	public function data_include_path($path){
		//type check
		if(!is_string($path)){
			throw new Exception('Data include path must be passed as a string.');
		}

		//ensure that final character is a forward slash
		if(substr($path, -1) != '/' or substr($path, -2) == '/'){
			throw new Exception('Data include path must terminate with a forward slash.');
		}

		//set property
		$this->data_include_path = $path;
	}

	//sets the page template
	public function site_template($template){
		//type check
		if(!is_string($template)){
			throw new Exception('Site template must be passed as a string.');
		}

		//add to the internal reference
		$this->site_template = $template;
	}

	//set the custom meta tags into the array
	public function site_meta($name, $content){
		//type check
		if(!is_string($name) or !is_string($content)){
			throw new Exception('Site meta content must be passed as strings.');
		}

		//construct the tag pieces
		$tag = ['name' => $name, 'content' => $content];

		//add to the internal reference
		$this->site_meta[] = $tag;
	}

	//set the custom base href
	public function site_base($href){
		//type check
		if(!is_string($href)){
			throw new Exception('Site base content must be passed as a string.');
		}

		//add to the internal reference
		$this->site_base = $href;
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
		if(strlen(strip_tags($text)) > $this->site_title_length){
			throw new Exception("Site title must be less than {$this->site_title_length} characters.");
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
		if(strlen($text) > $this->site_subtitle_length){
			throw new Exception("Site subtitle must be less than {$this->site_subtitle_length} characters.");
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
		$text = strip_tags(trim($href));

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
		$text = strip_tags(trim($href));

		//set the internal reference
		$this->site_subtitle_href = $href;
	}

	//set the included css files
	public function site_css($file, $media = 'screen'){
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
		$this->site_css[] = $node;
	}

	//set the included js files
	public function site_js($file){
		//type check
		if(!is_string($file)){
			throw new Exception('Site includes must be passed as a string.');
		}

		//add to the internal reference
		$this->site_js[] = $file;
	}

	//set the raw javascript
	public function site_js_raw($js){
		//check for previous call
		if($this->site_js_raw != NULL){
			throw new Exception('Raw javascript can only be set once.');
		}
	
		//type check
		if(!is_string($js)){
			throw new Exception('Site meta content must be passed as strings.');
		}

		//add to the private reference
		$this->site_js_raw = $js;
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
		if(!is_array($elements)){
			throw new Exception('Site navigation must be passed as an array.', 1);
		}
		
		//loop array elements
		foreach($elements as $text => $href){
		
			//policy enforcement
			if(substr($href, 0, 4) == 'http' or substr($href, 0, 3) == 'www'){
				throw new Exception('External links are not allowed in the site navigation.', 1);
			}
		
			//save to 
			$this->site_navigation[strip_tags($text)] = $href;
		}
	}
	
	//set the options for the billboard
	public function site_billboard($billboard, $content_file = NULL){	
		//type check
		if(!is_bool($billboard)){
			throw new Exception("Parameter 1 for site billboard must be a boolean.", 1);
		}
	
		//check existance of path
		if($content_file == NULL){
			$content_file = 'billboard.inc';
		}

		//check the billboard bit field
		if($billboard){
		
			//check to see if the billboard file exists
			if(is_file($this->get_data_include_path().$content_file)){		
				//set various fields
				$this->site_billboard = file_get_contents($this->get_data_include_path().$content_file);
				$this->site_billboard_exists = true;
				$this->site_billboard_dynamic = true;

			} elseif(is_file($this->site_billboard)){			
				//set various fields
				$this->site_billboard_exists = true;
				$this->site_billboard_dynamic = false;

			} else {
				//set defaults
				$this->site_billboard_exists = false;
				$this->site_billboard_dynamic = false;
			}
		} else {
			//turn it off
			$this->site_billboard_exists = false;
		}
	}

	//set the allowed pages for the billboard to appear under
	public function site_billboard_allowed_pages($pages){
		//type check
		if(!is_array($pages)){
			throw new Exception('Pages allowed to show the billboard must be passed as an array.');
		}

		//set property
		foreach($pages as $page){
			$this->site_billboard_allowed_pages[] = trim(strip_tags($page));
		}
	}
	
	//set the content under the repeated navigation
	public function site_content_end_under($content){
		//type check
		if(!is_string($content)){
			throw new Exception('Site content underneath the repeated navigation must be passed as a string.');
		}

		//set property
		$this->site_content_end_under = $content;
	}

	//pass general data into the footer properties
	public function site_footer($position, $title1, $elements1, $title2 = NULL, $elements2 = NULL){
		//allowed positions
		$allowed = [1, 2];

		//check type
		if(!is_array($elements1) or !is_int($position) or !in_array($position, $allowed)){
			throw new Exception('Type is not correct for footer column.');
		}

		//check length of array, both elements 1 and 2
		if(count($elements1) > $this->site_footer_column_limit
		or (is_array($elements2) and count($elements2) > $this->site_footer_column_limit)){
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

	//set the href for the ucf icon
	public function site_footer_ucf_icon($href){
		//type check
		if(!is_string($href)){
			throw new Exception('UCF icon path must be passed as a string.');
		}

		//add to the internal reference
		$this->site_footer_ucf_icon = $href;
	}

/*-------------------------------------------------------------------------------------------------------------------*/
/*--- PAGE DATA INPUT METHODS (MUTATORS / SETTERS) ------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/

	//set up the basic demographic fields for a site
	public function site_directory_basics($basics){	
	
		//type check
		if(!is_array($basics)){
			throw new Exception('Basic directory information must be passed as an array.');
		}
		
		//values check
		if(count($basics) != 5){
			throw new Exception('Basic directory information must be passed correctly.');
		}
	
		//property assignment
		$this->site_phone = isset($basics['phone']) ? $basics['phone'] : NULL;
		$this->site_fax = isset($basics['fax']) ? $basics['fax'] : NULL;
		$this->site_email = isset($basics['email']) ? $basics['email'] : NULL;
		$this->site_location_name = isset($basics['location']) ? $basics['location'] : NULL;
		$this->site_location_id = isset($basics['mapId']) ? $basics['mapId'] : NULL;
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

	//set the hours for each day of the week
	public function site_hours($hours){
		//type check
		if(!is_array($hours)){
			throw new Exception("Hours must be passed as a two-dimensional array.", 1);
		}

		//count check for days of the week
		if(count($hours) != 7){
			throw new Exception("Each day of the week must be represented in the hours array.", 1);
		}

		//loop each day of the week
		for($i = 0; $i <= 6; $i++){

			//check each day for two values
			if(count($hours[$i]) != 2){
				throw new Exception("Each day of the week must contain open and close time.", 1);
			}

			//if the values are not null (null is an acceptable value)
			if($hours[$i][0] != NULL and $hours[$i][1] != NULL){
				//check each value for valid timestamps
				if(!preg_match("/^([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $hours[$i][0])){
					throw new Exception("Invalid open time.", 1);
				}
				if(!preg_match("/^([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $hours[$i][1])){
					throw new Exception("Invalid close time.", 1);
				}
			}
		}

		//save to interal property
		$this->site_hours = $hours;
	}


/*-------------------------------------------------------------------------------------------------------------------*/
/*--- SIMPLE DATA OUTPUT METHODS (ACCESSORS / GETTERS) --------------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/

	public function get_template_include_path(){
		return $this->template_include_path;
	}

	public function get_data_include_path(){
		return $this->data_include_path;
	}

	public function get_site_include_path(){
		return $this->site_include_path;
	}

	public function get_site_template(){
		return $this->site_template;
	}

/*-------------------------------------------------------------------------------------------------------------------*/
/*--- HTML SITE DATA OUTPUT METHODS (ACCESSORS / GETTERS) -----------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/

	//generate meta tag html
	public function html_site_meta(){
		//init
		$output = NULL;

		//loop through all of the current meta tag nodes and generate the html
		foreach($this->site_meta as $node){

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
	public function html_site_base(){	
		//init
		$output = NULL;

		//check for null
		if($this->site_base != NULL){
			$output .= '<base href="'.$this->site_base.'" />'."\n";
		}

		//return output
		return $output;
	}

	//generate page title for <title> tag
	public function html_page_title(){
		//init
		$output = NULL;
		
		//conditional
		if($this->page_title != NULL && $this->page != 'home'){
		
			//set the title without any html
			$output .= strip_tags($this->page_title);
			
			//separater
			$output .= ' &raquo; ';
		
		}		
		
		//output html
		return $output;	
	}
	
	//generate site title for <title> tag
	public function html_site_title(){	
		//init 
		$output = NULL;

		//check for null
		if($this->site_title != NULL){
			$output .= strip_tags($this->site_title);
		}

		//output
		return $output;
	}

	//generate css includes html
	public function html_site_css(){
		//init
		$output = NULL;

		//loop through all of the current css files and generate the html
		foreach($this->site_css as $file){

			//check each piece for necessary indices
			if(!isset($file['path'], $file['media'])){
				throw new Exception('CSS generator missing required fields.');
			}

			//construct the html node
			$output .= '<link rel="stylesheet" href="'.$file['path'].'" type="text/css" media="'.$file['media'].'" />'."\n";
		}

		//output
		return $output;
	}

	//generate javascript includes html
	public function html_site_js(){
		//init
		$output = NULL;

		//loop through all of the current css files and generate the html
		foreach($this->site_js as $file){
			$output .= "\t".'<script type="text/javascript" src="'.$file.'"></script>'."\n";
		}

		//output
		return $output;
	}

	//raw javascript output
	public function html_site_js_raw(){
		//init
		$output = NULL;

		//if there is raw js, echo it
		if($this->site_js_raw != NULL){

			//start script tag
			$output .= '<script type="text/javascript">'."\n";
			$output .= $this->site_js_raw;
			$output .= '</script>'."\n";
		}

		//return output
		return $output;
	}
	
	//print out the html for the slider of choice
	public function html_billboard_includes(){	
		//init
		$output = NULL;
		
		//check the size of the array
		if($this->site_billboard_dynamic and $this->site_billboard != NULL){
		
			switch($this->site_billboard_dynamic_type){
				case 'nivo_slider':
					$output = 
	'<!-- NIVO-SLIDER -->
	<link rel="stylesheet" href="https://assets.sdes.ucf.edu/plugins/nivoslider/jquery.nivo.slider.css" type="text/css" media="screen" />
	<script type="text/javascript" src="https://assets.sdes.ucf.edu/plugins/nivoslider/jquery.nivo.slider.js"></script>
	<script type="text/javascript">
		$(window).load(function() {
			$("#slider").nivoSlider({
				slices: 10,
				pauseTime: 5000,
				controlNav: false,
				captionOpacity: 0.7
			});	
		});	
	</script>
	<!-- /NIVO-SLIDER -->';
					break;
			}			
		}
		
		//return
		return $output;
	}
	
	//html block for Google Analytics ASYNC Urchin
	public function html_site_gaid(){
		//init
		$output = NULL;

		//null check
		if($this->site_gaid != NULL){

			$output = 
	'<!-- GA-ASYNC -->
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
	<!-- /GA-ASYNC -->';

		}

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
			foreach($this->site_navigation as $text => $href){
				
				//single navigation element
				$output .= "\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";				
			}
			
			//start navigation
			$output .= "\t\t".'</ul>'."\n";		
		}
		
		//return
		return $output;
	}
	
	public function html_billboard(){	
		//init
		$output = NULL;
		
		//if the billboard bitflag is on
		if($this->site_billboard_exists and in_array($this->page, $this->site_billboard_allowed_pages)){
		
			//if the slider bitflag is on
			if($this->site_billboard_dynamic){

				//output the entire contents of the site_billboard
				$output .= $this->site_billboard;
		
			} elseif(is_file($this->site_billboard)){

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

	public function html_page_content_above(){
		//init
		$output = NULL;
		
		//check for null
		if($this->page_content_above != NULL){
		
			//set the title without any html
			$output .= $this->page_content_above."\n";
		}		
		
		//output html
		return $output;	
	}	
	
	public function html_page_content_links(){
		//init
		$output = NULL;
		
		//output if property is an array
		if(is_array($this->page_content_links) and !empty($this->page_content_links)){
			
			//render beginning of wrapper
			$output .= '<ul class="content-main-links">'."\n";
		
			foreach($this->page_content_links as $text => $href){
			
				//set the title without any html except <em> and <strong>
				$output .= '<li><a href="'.$href.'">'.$text.'</a></li>';
			}
			
			//render end of wrapper
			$output .= '</ul>'."\n";
		}

		//output if property is a string
		elseif(is_string($this->page_content_links) and $this->page_content_links != NULL){

			//render beginning of wrapper
			$output .= $this->page_content_links."\n";
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
	
	public function html_page_content_below(){
		//init
		$output = NULL;
		
		//check for null
		if($this->page_content_below != NULL){
		
			//set the title without any html
			$output .= $this->page_content_below."\n";
		}		
		
		//output html
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
				$output .= '<a href="'.htmlentities($val).'">'."\n\t\t\t\t\t";

				//pick out an image
				switch($type){
					case 'facebook':
						$output .= '<img src="'.$this->template_icon_path.'/facebook.png" class="icon" alt="icon" title="Facebook" />';
						break;
					case 'picasa':
						$output .= '<img src="'.$this->template_icon_path.'/picasa.png" class="icon" alt="icon" title="Google Picasa" />';
						break;
					case 'skype':
						$output .= '<img src="'.$this->template_icon_path.'/skype.png" class="icon" alt="icon" title="Skype" />';
						break;
					case 'twitter':
						$output .= '<img src="'.$this->template_icon_path.'/twitter.png" class="icon" alt="icon" title="Twitter" />';
						break;
					case 'wordpress':
						$output .= '<img src="'.$this->template_icon_path.'/wordpress.png" class="icon" alt="icon" title="WordPress Blog" />';
						break;
					case 'youtube':
						$output .= '<img src="'.$this->template_icon_path.'/youtube.png" class="icon" alt="icon" title="YouTube" />';
						break;
				}

				//start link
				$output .= "\n\t\t\t\t".'</a>'."\n";
			}
		}
		
		//return an html string of output
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
			foreach($this->site_navigation as $text => $href){
				
				//single navigation element
				$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";				
			}
			
			//start navigation
			$output .= "\t\t\t\t".'</ul>'."\n";		
		}
		
		//return
		return $output;
	}

	public function html_site_content_end_under(){
		//init
		$output = NULL;
		
		//conditional
		if($this->site_content_end_under != NULL){

			//canned top output
			$output .= '<div class="content-main-top"></div>'."\n";
			$output .= '<div class="content-main-body">'."\n";
			$output .= '<div class="content-main">'."\n";

			//set the title without any html
			$output .= $this->site_content_end_under;
			
			//canned bottom output
			$output .= '<div class="hr-clear"></div>'."\n";
			$output .= '</div>'."\n";
			$output .= '</div>'."\n";
			$output .= '<div class="content-main-bottom"></div>'."\n";
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
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col1_1_title.'</div>'."\n";			
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					//set the title without any html except <em> and <strong>
					foreach($this->site_footer_col1_1 as $text => $href){						
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";
					$output .= "\t\t\t".'</div>'."\n";

					//render beginning of wrapper
					$output .= "\t\t\t".'<div class="col3-1-2">'."\n";			
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col1_2_title.'</div>'."\n";			
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					//set the title without any html except <em> and <strong>
					foreach($this->site_footer_col1_2 as $text => $href){
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";
					$output .= "\t\t\t".'</div>'."\n";
				}else{

					//render beginning of wrapper
					$output .= '<div class="col3-1">'."\n";			
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col1_title.'</div>'."\n";			
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					//set the title without any html except <em> and <strong>
					foreach($this->site_footer_col1 as $text => $href){
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";
					$output .= "\t\t\t".'</div>'."\n";
				}
				break;
			case 2:
				if($this->site_footer_col2_1 != NULL && $this->site_footer_col2_2 != NULL){

					//render beginning of wrapper
					$output .= '<div class="col3-2-1">'."\n";			
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col2_1_title.'</div>'."\n";			
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					//set the title without any html except <em> and <strong>
					foreach($this->site_footer_col2_1 as $text => $href){
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";
					$output .= "\t\t\t".'</div>'."\n";

					//render beginning of wrapper
					$output .= "\t\t\t".'<div class="col3-2-2">'."\n";			
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col2_2_title.'</div>'."\n";			
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					//set the title without any html except <em> and <strong>
					foreach($this->site_footer_col2_2 as $text => $href){
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";
					$output .= "\t\t\t".'</div>'."\n";
				}else{

					//render beginning of wrapper
					$output .= '<div class="col3-2">'."\n";			
					$output .= "\t\t\t\t".'<div class="h1">'.$this->site_footer_col2_title.'</div>'."\n";			
					$output .= "\t\t\t\t".'<div class="hr"></div>'."\n";
					$output .= "\t\t\t\t".'<ul>'."\n";
				
					//set the title without any html except <em> and <strong>
					foreach($this->site_footer_col2 as $text => $href){
						$output .= "\t\t\t\t\t".'<li><a href="'.$href.'">'.$text.'</a></li>'."\n";
					}
					
					//render end of wrapper
					$output .= "\t\t\t\t".'</ul>'."\n";
					$output .= "\t\t\t".'</div>'."\n";
				}
				break;
		}
		
		//output html
		return $output;	
	}

	//contact block
	public function html_site_footer_contact(){
		//init
		$output = '<p>';
		
		//site title
		$output .= $this->html_site_title().'<br />';

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
		
		} elseif($this->site_subtitle != NULL){
			//subtitle link
			$output .= '<a href="'.$this->site_subtitle_href.'">'.strip_tags($this->site_subtitle).'</a><br />';

		} else {
			//generic ucf link
			$output .= '<a href="http://www.ucf.edu/">University of Central Florida</a><br />';
		}

		//if phone and email are set, echo; else, use subtitle
		if($this->site_location_name != NULL and $this->site_location_id != NULL){

			//location link
			$output .= 'Location: '.$this->html_map_link().'<br />';

		}else{
			//subtitle link
			$output .= '<a href="http://phonebook.ucf.edu/">UCF Phonebook</a> &bull; ';
			$output .= '<a href="http://events.ucf.edu/">UCF Events</a> &bull; ';
			$output .= '<a href="http://map.ucf.edu/">UCF Map</a> &bull; ';
			$output .= '<a href="http://ucf.custhelp.com/">Ask UCF</a>';
			$output .= '<br />';
		}

		//finish
		$output .= '</p>';
		
		//output html
		return $output;	
	}

	//ucf icon link
	public function html_site_footer_ucf_icon(){
		//init
		$output = NULL;
		
		//conditional
		if($this->site_footer_ucf_icon != NULL){
		
			//output the href
			$output .= htmlentities($this->site_footer_ucf_icon);
		}		
		
		//output html
		return $output;	
	}

/*-------------------------------------------------------------------------------------------------------------------*/
/*--- HTML PAGE DATA OUTPUT METHODS (ACCESSORS / GETTERS) -----------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/

	//generate a standard contact information block based on set demographic fields
	public function html_block_contact($full = false){
		//init
		$output = NULL;

		//check all fields first
		if($this->site_phone != NULL
			or $this->site_fax != NULL
			or $this->site_email != NULL
			or ($this->site_location_name != NULL and $this->site_location_id != NULL)
			or $this->site_hours != NULL
		){

			//start block code
			$output .= '<table class="grid smaller">'."\n";

			//if hours of operation are set
			if($this->site_hours != NULL){
				$output .= '<tr>'."\n";
				$output .= '<th scope="row">Hours</th>'."\n";
				$output .= '<td>'.$this->html_site_hours().'</td>'."\n";
				$output .= '</tr>'."\n";
			}
			//if phone is set
			if($this->site_phone != NULL){
				$output .= '<tr>'."\n";
				$output .= '<th scope="row">Phone</th>'."\n";
				$output .= '<td>'.$this->site_phone.'</td>'."\n";
				$output .= '</tr>'."\n";
			}
			//if fax is set
			if($this->site_fax != NULL){
				$output .= '<tr>'."\n";
				$output .= '<th scope="row">Fax</th>'."\n";
				$output .= '<td>'.$this->site_fax.'</td>'."\n";
				$output .= '</tr>'."\n";
			}
			//if email is set
			if($this->site_email != NULL){
				$output .= '<tr>'."\n";
				$output .= '<th scope="row">Email</th>'."\n";
				$output .= '<td>'.$this->html_email_link().'</td>'."\n";
				$output .= '</tr>'."\n";
			}
			//if location is set
			if($this->site_location_id != NULL and $this->site_location_name != NULL){
				$output .= '<tr>'."\n";
				$output .= '<th scope="row">Location</th>'."\n";
				$output .= '<td>'.$this->html_map_link().'</td>'."\n";
				$output .= '</tr>'."\n";
			}

			//end block code
			$output .= '</table>'."\n";
		}

		//return the html output
		return $output;
	}

	//phone number
	public function html_phone(){
		//init
		$output = NULL;
		
		//check for null, add to output
		if($this->site_phone != NULL){
			$output .= $this->site_phone;
		}		
		
		//output html
		return $output;	
	}

	//fax number
	public function html_fax(){
		//init
		$output = NULL;
		
		//check for null, add to output
		if($this->site_fax != NULL){
			$output .= $this->site_fax;
		}		
		
		//output html
		return $output;	
	}

	//email address
	public function html_email(){
		//init
		$output = NULL;
		
		//check for null, add to output
		if($this->site_email != NULL){
			$output .= $this->site_email;
		}		
		
		//output html
		return $output;	
	}

	//email link
	public function html_email_link(){
		//init
		$output = NULL;
		
		//check for null, add to output
		if($this->site_email != NULL){
			$output .= '<a href="mailto:'.$this->site_email.'">'.$this->site_email.'</a>';
		}		
		
		//output html
		return $output;	
	}

	//UCF map link
	public function html_map_link(){
		//init
		$output = NULL;
		
		//check for null, add to output
		if($this->site_location_name != NULL && $this->site_location_id != NULL){
			$output .= '<a href="http://map.ucf.edu/?show='.$this->site_location_id.'">'.$this->site_location_name.'</a>';
		}		
		
		//output html
		return $output;	
	}

	//hours of operation
	public function html_site_hours(){
		//init
		$output = NULL;
		$collections = [];
		$final = [];

		//value-to-day conversion array
		$names = ['Mon', 'Tues', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'];
		
		//check for null, add to output
		if(!empty($this->site_hours)){
			
			//loop through each day
			foreach($this->site_hours as $day => $hours){

				//if the day has hours set
				if($hours[0] != NULL and $hours[1] != NULL){

					//grab each piece of the time
					$seconds_open = explode(':', $hours[0]);
					$seconds_close = explode(':', $hours[1]);

					//set the time stamp
					$open_format = $seconds_open[1] == '00' ? 'ga' : 'g:ia';
					$close_format = $seconds_close[1] == '00' ? 'ga' : 'g:ia';

					//save the times out as clean times (8:00am)
					$open = date($open_format, strtotime('1985-10-22 ' . $hours[0]));
					$close = date($close_format, strtotime('1985-10-22 ' . $hours[1]));
					$both = $open.' - '.$close;

					//if this range exists, capture it
					$collections[$both][] = $day;
				}
			}

			//if there are results
			if(!empty($collections)){

				$blocks = NULL;
				$block = NULL;

				//separate them by sequential order
				foreach($collections as $time => $days){

					//for each day in the collection
					foreach($days as $index => $day){

						//set the current day to the current block
						$block[] = $day;

						//save and start a new block if the next day isn't sequential or is the last element
						if($day == end($days) or (isset($days[$index + 1]) and $day + 1 != $days[$index + 1])){
							$blocks[] = $block;
							$block = NULL;
						}
					}

					//save out blocks, reset
					$collections[$time] = $blocks;
					$blocks = NULL;
				}

				//echo time
				foreach($collections as $time => $days){

					foreach($days as $piece){

						$temp[] = count($piece) == 1 ? $names[$piece[0]] : $names[$piece[0]].'-'.$names[end($piece)];
					}

					$final[] = implode(', ', $temp).': '.$time;
					$temp = NULL;
				}

				//save to output string
				$output .= implode("<br />\n", $final);
			}
		}
		
		//output html
		return $output;
	}

	//social getter
	public function html_social_uri($network = NULL){
		//init
		$output = NULL;

		if(!($this->site_social == NULL)){

			//if null
			if($network == NULL){
				$output = $this->site_social;
			}

			//add to output
			elseif(isset($this->site_social[$network])){
				$output .= $this->site_social[$network];
			}				
		}	
		
		//output
		return $output;	
	}
}

/*-------------------------------------------------------------------------------------------------------------------*/
/*--- CLASS: TemplatePage -------------------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/

class TemplatePage{

	//variable for the page filename
	private $page;
	private $page_title;
	
	//variable for the page contents
	private $page_content;

	//collection of title bar links
	private $page_content_links;
	
	//data above/below the main content block;
	private $page_content_above;
	private $page_content_below;

	//get the current page via query string
	public function __construct(TemplateData $data){

		//check for active connection string
		if(class_exists('db')){
			$instance = db::instance();
			if($instance->isConnected()){
				$conn = db::connect();
			}
		}	
	
		//turn on output buffering
		ob_start();

		//flush the buffer
		ob_implicit_flush(0);

		//set page name to query string id or home
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
		if(isset($links)){
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

/*-------------------------------------------------------------------------------------------------------------------*/
/*--- SETTERS -------------------------------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/
	
	//set some content main links
	public function page_content_links($collection){	
		//verify type
		if(is_array($collection)){
		
			//loop array elements
			foreach($collection as $text => $href){
			
				//save to 
				$this->page_content_links[strip_tags($text)] = $href;
			}

		} elseif(is_string($collection)){

			$this->page_content_links = $collection;
		}
	}

/*-------------------------------------------------------------------------------------------------------------------*/
/*--- GETTERS -------------------------------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/

	//return private page values
	public function page_public(){
		//values to pass
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

/*-------------------------------------------------------------------------------------------------------------------*/
/*--- CLASS: TemplateFrame ------------------------------------------------------------------------------------------*/
/*-------------------------------------------------------------------------------------------------------------------*/

class TemplateFrame{

	//settings for templates
	private $template_path;

	//constructor
	public function __construct(TemplateData $data){

		//check to see if template is specified
		if($data->get_site_template() == NULL){
			throw new Exception("Template is not set.", 1);
		}

		//check file path
		if($data->get_template_include_path() == NULL){
			throw new Exception("Template include path is not set.", 1);
		}

		//set template directory
		$this->template_path = $data->get_template_include_path().'\templates\\';

		//load the template
		switch($data->get_site_template()){
			case 'main':
				require_once $this->get_template_path().'sdes_main.php';
				break;
			case 'admin':
				require_once $this->get_template_path().'sdes_admin.php';
				break;
			default:
				require_once $this->get_template_path().'sdes_main.php';
				break;
		}
	}

	//get template path
	public function get_template_path(){
		return $this->template_path;
	}
}
?>