#SDES Template

- Class: TemplateData, TemplatePage, TemplateFrame
- Author: Jordan Rogers <jr@ucf.edu>
- Creation Date: September 2012

##Description

A set of functions, templates, and classes to standardize and simplify the collection of SDES sites.

##Changelog

2012-10-09

	* Added more helper functions to move directory information to the TemplateData object
	* Completed a full example file of data.inc.php
	* Rewrote site_billboard() to be a little simpler
	* Changed site_demographics to site_directory_basics to be less ambiguous
	* Added example for page use

2012-10-08

	* Added TemplateFrame class so that template-loading functionality could exist within an OOP context
	* Added generic function to build a template-standard $hours array from the directory-standard
	* Added an /examples folder with commented examples of an index.php, sample data.inc.php, and billboard.inc
	* Removed load_data method (now done in the index.php)