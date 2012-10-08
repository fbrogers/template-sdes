<?php
	//include the required template class
	require_once realpath('C:\WebDFS\Websites\_phplib\template_data.php');

	//load the data into the template class, specifying the path to the data
	try{
		$data = TemplateData::load_data(new TemplateData, 'includes/data.inc.php');
	} catch(Exception $e){
		die('Exception: '.$e->getMessage());
	}
	
	//load page
	try{
		$data->load_page(new TemplatePage($data));
	} catch(Exception $e){
		die('Exception: '.$e->getMessage());
	}

	//load template
	try{
		new TemplateFrame($data);
	} catch(Exception $e){
		die('Exception: '.$e->getMessage());
	}
?>