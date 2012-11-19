#SDES Template

- Class: TemplateData, TemplatePage, TemplateFrame
- Author: Jordan Rogers <jr@ucf.edu>
- Creation Date: September 2012

##Description

A set of functions, templates, and classes to standardize and simplify the collection of SDES sites.

##Changelog

2012-11-19

	* Allowing no action if site hours, basic information, and social networks are blank or malformed

2012-11-16

	* In full production
	* Lots and lots and lots of bug fixes and tweaks

2012-10-10

	* Fixed some defaults with the billboard properties
	* Added a check for the default billboard image, fails over to no billboard
	* Added a mutator for $data_include_path
	* Hours of Operation are now included in the null check for the contact block html getter
	* Swapped out urlencode for htmlentities over the html output of hrefs for the social media icons

2012-10-09

	* Added more helper functions to move directory information to the TemplateData object
	* Completed a full example file of data.inc.php
	* Rewrote site_billboard() to be a little simpler
	* Changed site_demographics to site_directory_basics to be less ambiguous
	* Added example for page use
	* Added the ability to set $page_content_links to an HTML string or an array

2012-10-08

	* Added TemplateFrame class so that template-loading functionality could exist within an OOP context
	* Added generic function to build a template-standard $hours array from the directory-standard
	* Added an /examples folder with commented examples of an index.php, sample data.inc.php, and billboard.inc
	* Removed load_data method (now done in the index.php)