<?php

/* ----------------------------------------------------------------------------
	INCLUDE THE CLASS DEFINTIONS
------------------------------------------------------------------------------- 
This is where you should include the template_data.php file, which contains
the three required classes for using this engine: TemplateData, TemplatePage,
and TemplateFrame.
---------------------------------------------------------------------------- */
require_once realpath('C:\WebDFS\Websites\_phplib\template_data.php');


/* ----------------------------------------------------------------------------
	CREATE A TemplateData OBJECT
------------------------------------------------------------------------------- 
Create a new instance of TemplateData and set it to a variable. By default, 
that variable must be named '$data', as that is what the default data include
template is expecting. This can be changed if necessary, but be aware that
all pieces of this system must agree on a name. 

After the object has been created, include the contents of whatever file
contains the data setter method calls.
---------------------------------------------------------------------------- */
try{
	$data = new TemplateData;
	require_once 'includes/data.inc.php';
} catch(Exception $e){
	die('Exception: '.$e->getMessage());
}


/* ----------------------------------------------------------------------------
	LOAD PAGE DATA INTO TemplateData
------------------------------------------------------------------------------- 
Call the 'load_page' method and pass it a new TemplatePage object (with the
current TemplateData object as a parameter). This will automatically scrape
the page, load the data into a TemplatePage object, and transfer the data back
into the TemplatePage object.
---------------------------------------------------------------------------- */
try{
	$data->load_page(new TemplatePage($data));
} catch(Exception $e){
	die('Exception: '.$e->getMessage());
}


/* ----------------------------------------------------------------------------
	PASS DATA TO THE TEMPLATE VIA TemplateFrame
------------------------------------------------------------------------------- 
Create a new TemplateFrame object with the current TemplateData object as a
parameter. Its constructor will grab the chosen template name and load the 
template into the page, giving it access to the TemplateData getter methods.
---------------------------------------------------------------------------- */
try{
	new TemplateFrame($data);
} catch(Exception $e){
	die('Exception: '.$e->getMessage());
}

?>