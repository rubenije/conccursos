<?php 
	error_reporting(0);
	if (!defined("INCLUDE_PATH")) {
		define("INCLUDE_PATH", "");
	}
	include_once(INCLUDE_PATH.'class/class.DB.php');
	include_once(INCLUDE_PATH.'class/class.inputfilter.php');
	include_once(INCLUDE_PATH.'class/inc.globals.php');
	session_start();
	
	if(!$_SESSION['PANEL']){
		header("Location: index.php?opc=logout");
		exit;
	}
	
	$base = basename(trim($_SERVER['SCRIPT_NAME']), '.php');
	$name = "PosicionamientoPro";
?>