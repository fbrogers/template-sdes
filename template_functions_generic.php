<?php
	//load a piece of the SDES Directory feed
	function get_directory_info($id){

		//init
		$output = array();

		//get all map locations
		$ch = curl_init("http://assets.sdes.ucf.edu/data/directory.js");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$json = curl_exec($ch);
		curl_close($ch);

		//grab only objects that are type building
		$json = json_decode($json, true);

		//loop through to find the given id
		foreach($json['departments'] as $department){

			//check acronym field against id
			if($department['acronym'] == $id){

				//save output
				$output = $department;
				break;
			}
		}

		//return array
		return $output;
	}

	//grab the hours from a directory output and put them into template format
	function load_hours_from_directory($hours){

		//check input size
		if(count($hours) != 7){
			return false;
		}

		//form the array
		$output = [
			0 => [$hours[0]['open'], $hours[0]['close']],
			1 => [$hours[1]['open'], $hours[1]['close']],
			2 => [$hours[2]['open'], $hours[2]['close']],
			3 => [$hours[3]['open'], $hours[3]['close']],
			4 => [$hours[4]['open'], $hours[4]['close']],
			5 => [$hours[5]['open'], $hours[5]['close']],
			6 => [$hours[6]['open'], $hours[6]['close']],
		];

		//return the preformatted array
		return $output;
	}

	//render the links beside the title/h1
	function contentMainLinks($links){
		$output = NULL;
		
		if(is_array($links)){
			$output .= '<ul class="content-main-links">';
			foreach($links as $name => $uri){
				$output .= '<li><a href="'.$uri.'">'.$name.'</a></li>';
			}
			$output .= '</ul>';
		}else{
			$output .= '<div class="content-main-links">';
			$output .= $links;
			$output .= '</div>';
		}
		
		return $output;
	}

	//get upload directory
	function get_upload_dir(){
		return realpath(ini_get('upload_tmp_dir'));
	}

	//open a sql connection
	function sqlsrv_open(){

		//connection settings
		$settings = [
			"Database" => SQL_DB,
			"UID"=> SQL_USER,
			"PWD"=> SQL_PASS,
			"CharacterSet" => "UTF-8",
			"ReturnDatesAsStrings" => 1
		];

		//connect to sql
		$conn = sqlsrv_connect(SQL_SERVER, $settings) or die(print_r(sqlsrv_errors(), true));
		
		//return connection pointer
		return $conn;
	}

	//prepares values for insert into a CSV file
	function csv_prepare(&$value, $key){
		$value = '"'.$value.'"';
	}

	//parse an rss feed
	function parse_rss($uri = 'http://today.ucf.edu/feed/', $limit = 8){

		//initiate a cURL connection
		$ch = curl_init($uri);

		//set cURL options
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		//execute cURL and dump results
		$rss = curl_exec($ch);

		//close the cURL connection
		curl_close($ch);

		//encode the return as UTF-8 and suppress errors
		$rss = @utf8_encode($rss);

		//disable libxml errors and allow user to fetch error information as needed
		libxml_use_internal_errors(true);

		//try to parse cURL return as XML
		try{
			$xml = new SimpleXMLElement($rss, LIBXML_NOCDATA);
		} 

		//catch exceptions
		catch(Exception $e){
			//nothing
		}

		//if there are errors
		if(libxml_get_errors()){

			//start an error element
			$output = '<li>Failed loading XML</li>';

			//loop through errors
			foreach(libxml_get_errors() as $error){
				$output .= '<li>'.htmlentities($error->message).'</li>';
			}

			//return false
			return $output;
		}

		//set limit if items returned are smaller than limit
		$count = (count($xml->channel->item) > $limit) ? $limit : count($xml->channel->item);

		//init
		$output = NULL;

		//loop through returned list items
		for($i = 0; $i < $count; $i++){

			//filter out non UTF-8 characters
			$url 	= str_replace('&', '&amp;', $xml->channel->item[$i]->link);
			$title 	= str_replace('&', '&amp;', $xml->channel->item[$i]->title);

			//echo beginning of list item
			$output .= '<li><a href="'.$url.'">';

			//truncate title
			$output .= strlen($title) > 50 ? substr($title, 0, 45).'...' : $title;

			//echo end of list item
			$output .= '</a></li>';
		}

		//return output
		return $output;
	}

	//parse an rss feed
	function parse_rss_template($uri = 'http://today.ucf.edu/feed/', $limit = 8){

		//initiate a cURL connection
		$ch = curl_init($uri);

		//set cURL options
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		//execute cURL and dump results
		$rss = curl_exec($ch);

		//close the cURL connection
		curl_close($ch);

		//encode the return as UTF-8 and suppress errors
		$rss = @utf8_encode($rss);

		//disable libxml errors and allow user to fetch error information as needed
		libxml_use_internal_errors(true);

		//try to parse cURL return as XML
		try{
			$xml = new SimpleXMLElement($rss, LIBXML_NOCDATA);
		} 

		//catch exceptions
		catch(Exception $e){
			//nothing
		}

		//init
		$output = [];

		//if there are errors
		if(libxml_get_errors()){

			//start an error element
			$output[] = 'Failed loading XML.';

			//loop through errors
			foreach(libxml_get_errors() as $error){
				$output[] = htmlentities($error->message);
			}

			//return false
			return $output;
		}

		//set limit if items returned are smaller than limit
		$count = (count($xml->channel->item) > $limit) ? $limit : count($xml->channel->item);

		//loop through returned list items
		for($i = 0; $i < $count; $i++){

			//filter out non UTF-8 characters
			$url 	= str_replace('&', '&amp;', $xml->channel->item[$i]->link);
			$title 	= str_replace('&', '&amp;', $xml->channel->item[$i]->title);

			//echo beginning of list item
			$output[$url] = strlen($title) > 50 ? substr($title, 0, 45).'...' : $title;
		}

		//return output
		return $output;
	}

	//checks to see if the request method of the given page was via http post
	function is_post(){
		return (isset($_SERVER['REQUEST_METHOD']) and $_SERVER['REQUEST_METHOD'] == 'POST');
	}

	//check to see if the page was requested via AJAX
	function is_ajax(){
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) and ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
	}

	//outputs a string of HTML for a UCF Events Calendar
	function renderCalendar($id, $limit = 6){
		
		if($id == NULL){
			return true;	
		}
		
		//open cURL instance for the UCF Event Calendar RSS feed
		$ch = curl_init("http://events.ucf.edu/?calendar_id={$id}&upcoming=upcoming&format=rss");

		//set cURL options
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		//execute and dump to variable
		$rss = curl_exec($ch);

		//close connection
		curl_close($ch);

		//encode output as UTF-8
		$rss = @utf8_encode($rss);
			
		//disable libxml errors and allow user to fetch error information as needed
		libxml_use_internal_errors(true);

		//try to parse cURL return as XML
		try{
			$xml = new SimpleXMLElement($rss, LIBXML_NOCDATA);
		} 

		//catch exceptions
		catch(Exception $e){
			//nothing
		}

		//if there are errors
		if(libxml_get_errors()){

			//start an error element
			$output = '<li>Failed loading XML</li>';

			//loop through errors
			foreach(libxml_get_errors() as $error){
				$output .= '<li>'.htmlentities($error->message).'</li>';
			}

			//return false
			return $output;
		}

		//set limit if items returned are smaller than limit
		$count = (count($xml->channel->item) > $limit) ? $limit : count($xml->channel->item);
		
		//start HTML output
		$output = '<ul class="events">';

		//check for items
		if(count($xml->channel->item) == 0){

			//error message
			$output .= '<li><p>Sorry, no events could be found.</p></li></ul>';

			//return
			return $output;
		}

		//loop through until limit
		for($i = 0; $i < $count; $i++){

			//prepare xml output to html
			$title 	= htmlentities($xml->channel->item[$i]->title);
			$title = (strlen($title) > 50) ? substr($title, 0, 45) : $title;
			$loc = htmlentities($xml->channel->item[$i]->children('ucfevent', true)->location->children('ucfevent', true)->name);
			$map = htmlentities($xml->channel->item[$i]->children('ucfevent', true)->location->children('ucfevent', true)->mapurl);
			
			//output html
			$output .= 
			'<li class="event">
				<div class="date">
					<span class="month">'.date('M', strtotime($xml->channel->item[$i]->children('ucfevent', true)->startdate)).'</span>
					<span class="day">'.date('j', strtotime($xml->channel->item[$i]->children('ucfevent', true)->startdate)).'</span>
				</div>
				<a class="title" href="'.htmlentities($xml->channel->item[$i]->link).'">'.$title.'</a>
				<a href="'.htmlentities($xml->channel->item[$i]->link).'">'.$loc.'</a>
				<div class="end"></div>
			</li>';
		}

		//finish unordered list
		$output .= '</ul>';

		//finish output string
		$output .= "<div class=\"datestamp floatright\">
			<a href=\"http://events.ucf.edu/?calendar_id={$id}&amp;upcoming=upcoming\">&raquo;More Events</a>
		</div>";

		//return clean
		return $output;
	}

	function sqlText($string){
		//covert all special HTML characters to encoded characters
		$string = str_replace('&','&amp;',$string);
		$string = str_replace('"','&quot;',$string);
		$string = str_replace('\'','&#039;',$string);
		
		//convert all newlines to HTML <br> tags
		$string = nl2br($string);
		
		//return filtered string
		return $string;	
	}

	function nl2li($string){
		$array = explode("\n",$string);	
		$result = '<ul>';
		foreach($array as $i => $x) $result .= '<li>'.$x.'</li>';
		$result .= '</ul>';
		return $result;
	}

	function simpleInsert($table){
		//connect to sql
		$conn = sqlsrv_open();

		//sanitize
		FormProcessor::oxyClean($_POST);
		
		//build query
		$columns = implode(', ',array_keys($_POST));
		
		//place markers around each value
		foreach($_POST as &$x){
			$x = is_null($x) ? 'NULL' : "'".str_replace("'","''",$x)."'";
		}
		
		//pieces them all together and rewrite nulls
		$values = implode(",",$_POST);
		$values = str_replace("'NULL'","NULL",$values);	
		
		//fire insert query
		$query = "INSERT INTO [$table] ($columns) VALUES ($values); SELECT SCOPE_IDENTITY();";
		$result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));

		//get last primary key
		$pk = getLastId($result);
		
		//close sql
		sqlsrv_close($conn);

		//return new primary key
		return $pk;
	}

	function simpleUpdate($table, $key){
		//connect to sql
		$conn = sqlsrv_open();
		
		//quick fix
		$tableName = explode('_',$table);
		$id = end($tableName).'Id';

		//sanitize
		FormProcessor::oxyClean($_POST);
		
		//place markers around each value
		foreach($_POST as &$x){
			$x = is_null($x) ? 'NULL' : "'".str_replace("'","''",$x)."'";
		}
				
		//build values and columns
		foreach($_POST as $col => $val){
			$update[] = $col."=".$val;
		}
		$update = implode(', ',$update);
		
		//mezmerise
		$query = "UPDATE [$table] SET {$update} WHERE [$id] = ?";
		$result = sqlsrv_query($conn, $query, [$key]) or die(print_r(sqlsrv_errors(), true));
		
		//close sql
		sqlsrv_close($conn);
	}

	//check to see if a given url returns an HTML 200
	function is_live($url){
		//set return bit
		$bool = true;
		
		//initialize a cURL call
		$handle = curl_init($url);
		curl_setopt($handle,  CURLOPT_NOBODY, true);
		
		//go
		curl_exec($handle);
		
		//check the http code returned
		$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		if($httpCode != 200) $bool = false;
		
		//close cURL call
		curl_close($handle);
		
		//return the bit
		return $bool;
	}

	//get the primary key for the last insert
	function getLastId($result){
		sqlsrv_next_result($result);
		sqlsrv_fetch($result);
		return sqlsrv_get_field($result, 0);
	}

	//given table, pkey, and name information, output HTML option elements
	function dropDownChanger($table, $id, $name, $selected = NULL){
		
		//build the query from the pieces
		$conn = sqlsrv_open();
		$query = "SELECT [$id], [$name] FROM [$table] ORDER BY [$name]";
		$result = sqlsrv_query($conn, $query) or die(print_r(sqlsrv_errors(), true));
		
		//start output string
		$output = '<option></option>';
		
		//loop through results
		while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
			$output .= ($row[$id] == $selected)
				? '<option value="'.$row[$id].'" selected="selected">'.ucwords($row[$name]).'</option>'
				: '<option value="'.$row[$id].'">'.ucwords($row[$name]).'</option>';
		}		
		
		//close sql connection
		sqlsrv_close($conn);

		//return
		return $output;
	}

	//generates a number-used-only-once (nonce)
	function nonce($length = 20){
		
		//initialize string
		$string = null;
		
		//collections of nonce columns
		$possible = ['abcdefghijklmnopqrstuvwxyz','ABCDEFGHIJKLMNOPQRSTUVWXYZ','0123456789','!@#*-_'];
		
		//loop through the nonce columns randomly
		for($i = 0; $i < $length; $i++){
			$one = mt_rand(0,3);
			$char = $possible[$one][mt_rand(0, strlen($possible[$one])-1)];
			$string .= $char;
		}
		
		//if each column isn't represented, try again
		if(!preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\*\-_\.\+]).*$/", $string)){
			$string = nonce();	
		}
		
		//return nonce
		return $string;
	}

	//compare the size of an image to given width and height
	function isSize($inputname, $width, $height){
		//get data on image
		$array = getimagesize($_FILES[$inputname]['tmp_name'], $info);

		//check against parameter values
		if(($width != $array[0]) or ($height != $array[1])){
			return false; //not the correct size	
		} else {
			return true; //correct size	
		}
	}

	//given a file stream upload, output a square 125px image
	function picSquared($file, $size, $type = 'jpg', $output = NULL){

		//init
		$blob = true;

		//set size to both variables
		list($targetWidth, $targetHeight) = $size;
		
		//check to see if passed file is in POST or a stream
		if(isset($_FILES[$file]['tmp_name'])){
			
			if($type == 'png'){
				$image = imagecreatefrompng($_FILES[$file]['tmp_name']);	
				imagealphablending($image, true);
				imagesavealpha($image, true);
			}
			else {
				$image = imagecreatefromjpeg($_FILES[$file]['tmp_name']);	
			}
			list($origWidth, $origHeight) = getimagesize($_FILES[$file]['tmp_name']);

		}else{ /*TODO */ }
		
		//create a radio of width:height
		$origRatio = $origWidth/$origHeight;
		
		//adjust new sizes to $size being the shortest size
		if (1 > $origRatio) {
			$new_height = $size/$origRatio;
			$new_width = $size;
		} 
		else {
			$new_width = $size*$origRatio;
			$new_height = $size;
		}	
		
		//find midpoint of each side
		$x_mid = $new_width/2;  
		$y_mid = $new_height/2;
		
		//move original image into a square of size of the shortest side of the original
		$process = imagecreatetruecolor(round($new_width), round($new_height)); 	
		$white = imagecolorallocate($process, 255, 255, 255);
		imagefill($process, 0, 0, $white);
		imagecopyresampled($process, $image, 0, 0, 0, 0, $new_width, $new_height, $origWidth, $origHeight);

		//create thumbnail
		$thumb = imagecreatetruecolor($size, $size);
		imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($size/2)), ($y_mid-($size/2)), $size, $size, $size, $size);

		//check for output path
		if($output != NULL){
			//make either a jpg or png
			if($type='png'){
				imagepng($thumb, $output, 9);
			}else{
				imagejpeg($thumb, $output, 80);
			}
		}else{
			//output the raw jpeg into a buffer
			ob_start();

			//make either a jpg or png
			if($type='png'){
				imagepng($thumb, null, 9);
			}else{
				imagejpeg($thumb, null, 80);
			}

			//dump output buffer to local variable
			$blob = ob_get_clean();
		}

		//free memory 
		imagedestroy($thumb);
		imagedestroy($process);
		
		//return new image
		return $blob;
	}
	
	//check to see if a form is active: requires a database with a switch table
	function checkSwitch($name){
		//open sql connection
		$conn = sqlsrv_open();
		
		//check to see if given switch is on or off
		$query = "SELECT TOP 1 * FROM [switch] WHERE switchName = ? AND switchValue = 1";
		$params = array($name);
		$result = sqlsrv_query($conn, $query, $params) or die(print_r(sqlsrv_errors(), true));
		
		//set switch
		$switch = sqlsrv_has_rows($result);
		
		//close sql connection
		sqlsrv_close($conn);	
		
		//return
		return $switch;
	}

?>