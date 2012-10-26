<?php
	//require class
	require_once('C:\WebDFS\Websites\_phplib\sdestemplate\template_db.php');

	//database connection
	$instance = db::instance();
	$instance->connection_string($server, $database, $username, $password);
	$conn = $instance::connect();
?>