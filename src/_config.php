<?php
/*---------------------------------------------------
/ This file holds all the global variables required
/ througout the CMS system
---------------------------------------------------*/
	$base_root = "../";
	$app_title = "Equilibrium ";
	$app_copyright = " &copy;2004 Itanexmedia.com - ";
	
	/*---------------------------------------------------
	/ include all required files
	---------------------------------------------------*/
	require_once($my_root."classes/database.php");
	require_once($my_root."classes/template.php");
	require_once($my_root."classes/user_class.php");
	require_once($my_root."classes/bookkeeper.php");
	
	/*---------------------------------------------------
	/ define all required sql statements 
	---------------------------------------------------*/

	/*---------------------------------------------------
	/ create all required variables
	---------------------------------------------------*/
	connect_mysql();         //connect to the database
	$tpl = new Template();   //create a template object
	$user_obj = new User("/cms/index.php");  //create a user object
	$bkr = new BookKeeper(); //create a bookkeeper object
	$site_dir = "C:/Program Files/Apache Group/Apache2/htdocs/cms/";
	//$site_dir = "/var/subdomain/cmsdemo/html/cms/";
	//$site_dir = "C:/Program Files/Apache Group/Apache2/htdocs/cms/";
?>