<?php
/*---------------------------------------------------
/ This file holds all the special variables and 
/ configurations that are required for this dirctory
---------------------------------------------------*/
	$my_root = "../";
	
	/*---------------------------------------------------
	/ include all required files
	---------------------------------------------------*/
	require_once($my_root."_config.php");
	
	/*---------------------------------------------------
	/ define all required sql statements 
	---------------------------------------------------*/
	$all_mod_list = "SELECT * FROM mod_list";
	$fetch_mod_file = "SELECT mod_id FROM mod_list WHERE mod_file='%s'";
	$fetch_mod_name = "SELECT mod_id FROM mod_list WHERE mod_name='%s'";
	$fetch_title = "SELECT mod_name FROM mod_list WHERE mod_id='%s'";
	$mod_insert = "INSERT INTO mod_list(mod_file, mod_name, u_id, updated, view) VALUES('%s', '%s', '%s', NOW(), '0')";
	$mod_delete = "DELETE FROM mod_list WHERE mod_id='%s'";
	$hide_mod_update = "UPDATE mod_list SET view='0' WHERE mod_id='%s'";
	$show_mod_update = "UPDATE mod_list SET view='1' WHERE mod_id='%s'";

	/*---------------------------------------------------
	/ create all required variables
	---------------------------------------------------*/
	$logged = $user_obj->check_session(); //generate a logged var
	
	/*-------------------------------------------------------
	/ enable this for the server
	/ -------------------------------------------------------*/
	$mod_dir = $site_dir."mods/";
	
	/*--------------------------------------------------------*/
	
	/*---------------------------------------------------
	/ bookkeeper strings
	---------------------------------------------------*/
	$upload_mod_note = "<b>MOD</b>: <b>%s</b> was uploaded and referenced.";
	$upload_mod_fail = "<b>MOD</b>: <b>%s</b> failed to upload.";
	$create_mod_db_fail = "<b>MOD</b>: <b>%s</b> failed to be created.";
	
	$hide_mod_note = "<b>MOD</b>: <b>%s</b> was hidden from users.";
	$hide_mod_fail = "<b>MOD</b>: <b>%s</b> failed to be hidden from users.";
	$show_mod_note = "<b>MOD</b>: <b>%s</b> was revealed to users.";
	$show_mod_fail = "<b>MOD</b>: <b>%s</b> failed to be revealed to users.";
	
	$delete_part_mod_note = "<b>MOD</b>: <b>%s</b> was deleted from the database.";
	$delete_part_mod_fail = "<b>MOD</b>: <b>%s</b> failed to be deleted from the database.";
	$delete_full_mod_note = "<b>MOD</b>: <b>%s</b> was deleted from the file system.";
	$delete_full_mod_fail = "<b>MOD</b>: <b>%s</b> failed to be deleted from the file system.";
?>