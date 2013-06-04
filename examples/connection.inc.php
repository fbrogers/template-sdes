<?php
  require_once('C:\WebDFS\Websites\_phplib\sdestemplate\template_db.php');
  try{
    $instance = db::instance();
    $instance->connection_string($server, $database, $username, $password);
    $conn = $instance::connect();
  } catch(Exception $e){
    die('Error: '.$e->getMessage());
  }
?>