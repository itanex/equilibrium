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
	require_once($my_root."classes/database.php");
	require_once($my_root."classes/template.php");
	require_once($my_root."classes/page.php");
	
	/*---------------------------------------------------
	/ Directory List 
	---------------------------------------------------*/
	$pg_dir = $site_dir;
	$tpl_pg_dir = $site_dir."pg_tpl/";
	$tpl_sc_dir = $site_dir."sc_tpl/";
	$img_dir = $site_dir."img/";	
	
	/*---------------------------------------------------
	/ define all required sql statements 
	---------------------------------------------------*/
	$all_page_list = "SELECT * FROM pg_list";
	$pg_fetch_file = "SELECT p_id FROM pg_list WHERE filename='%s'";
	$pg_fetch_title = "SELECT p_id FROM pg_list WHERE title='%s'";
	$pg_insert = "INSERT INTO pg_list(tpl_pg_id, filename, title, view, updated, updated_by) VALUES('%s', '%s', '%s', '0', NOW(), '%s')";
	$pg_fetch_last_id = "SELECT p_id FROM pg_list WHERE tpl_pg_id='%s' AND filename='%s' AND title='%s'";
	$hide_pg_update = "UPDATE pg_list SET view='0' WHERE p_id='%s'";
	$show_pg_update = "UPDATE pg_list SET view='1' WHERE p_id='%s'";
	$pg_delete = "DELETE FROM pg_list WHERE p_id='%s'";

	$all_pg_tpl_list = "SELECT * FROM tpl_pg_list, user_accts WHERE tpl_pg_list.u_id=user_accts.u_id ORDER BY tpl_name";
	$list_pg_tpl = "SELECT * FROM tpl_pg_list WHERE tpl_view='1' ORDER BY tpl_name";
	$pg_tpl_fetch = "SELECT * FROM tpl_pg_list WHERE tpl_pg_id='%s'";
	$pg_tpl_fetch_file = "SELECT tpl_pg_id FROM tpl_pg_list WHERE tpl_file='%s'";
	$pg_tpl_fetch_name = "SELECT tpl_pg_id FROM tpl_pg_list WHERE tpl_name='%s'";
	$pg_tpl_insert = "INSERT INTO tpl_pg_list(tpl_file, tpl_name, u_id, updated) VALUES('%s', '%s', '%s', NOW())";
	$hide_pg_tpl_update = "UPDATE tpl_pg_list SET tpl_view='0' WHERE tpl_pg_id='%s'";
	$show_pg_tpl_update = "UPDATE tpl_pg_list SET tpl_view='1' WHERE tpl_pg_id='%s'";
	$pg_tpl_delete = "DELETE FROM tpl_pg_list WHERE tpl_pg_id='%s'";
	
	$all_sc_tpl_list = "SELECT * FROM tpl_sc_list, user_accts WHERE tpl_sc_list.u_id=user_accts.u_id ORDER BY tpl_name";
	$list_sc_tpl = "SELECT * FROM tpl_sc_list WHERE tpl_view='1' ORDER BY tpl_name";
	$sc_tpl_fetch = "SELECT * FROM tpl_sc_list WHERE tpl_sc_id='%s'";
	$sc_tpl_fetch_file = "SELECT tpl_sc_id FROM tpl_sc_list WHERE tpl_file='%s'";
	$sc_tpl_fetch_name = "SELECT tpl_sc_id FROM tpl_sc_list WHERE tpl_name='%s'";
	$sc_tpl_insert = "INSERT INTO tpl_sc_list(tpl_file, tpl_name, u_id, updated) VALUES('%s', '%s', '%s', NOW())";
	$hide_sc_tpl_update = "UPDATE tpl_sc_list SET tpl_view='0' WHERE tpl_sc_id='%s'";
	$show_sc_tpl_update = "UPDATE tpl_sc_list SET tpl_view='1' WHERE tpl_sc_id='%s'";
	$sc_tpl_delete = "DELETE FROM tpl_sc_list WHERE tpl_sc_id='%s'";
	
	$sec_list_for_pg = "SELECT * FROM pg_section RIGHT JOIN tpl_sc_list ON tpl_sc_list.tpl_sc_id=pg_section.tpl_sc_id WHERE p_id='%s' ORDER BY  pgsc_id";
	$sec_fetch = "SELECT * FROM pg_section WHERE pgsc_id='%s'";
	$section_insert = "INSERT INTO pg_section(p_id, tpl_sc_id, title, content, img_name, img_desc, img_url, updated) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW())";
	$section_update = "UPDATE pg_section SET p_id='%s', tpl_sc_id='%s', title='%s', content='%s', img_name='%s', img_desc='%s', img_url='%s', updated=NOW() WHERE pgsc_id='%s'";
	$hide_sec_update = "UPDATE pg_section SET view='0' WHERE pgsc_id='%s'";
	$show_sec_update = "UPDATE pg_section SET view='1' WHERE pgsc_id='%s'";
	$section_delete = "DELETE FROM pg_section WHERE pgsc_id='%s'";
	$section_pg_delete = "DELETE FROM pg_section WHERE p_id='%s'";
	
	$list_css = "SELECT css_id, css_name FROM css_list WHERE view='1'";
	$fetch_page_details = "SELECT title, tpl_pg_id, css_id FROM pg_list WHERE p_id='%s'";
	$update_page_details = "UPDATE pg_list SET title='%s', tpl_pg_id='%s', css_id='%s' WHERE p_id='%s'";
	$fetch_full_page = "SELECT * FROM pg_list WHERE p_id='%s'";
	
	/*---------------------------------------------------
	/ create all required variables
	---------------------------------------------------*/
	$logged = $user_obj->check_session(); //generate a logged var
	connect_mysql();        //connect to the database
	$tpl = new Template();  //create a template object
	$pg = new Page();  //create a template object
	$basefile = $my_root."pg_tpl/basefile.php";	
	/*---------------------------------------------------
	/ bookkeeper strings
	---------------------------------------------------*/
	$page_create_note = "<b>PAGE CREATION</b>: '%s'";
	
	$detail_pg_note = "<b>PAGE DETAILS</b>: '%s' was updated.";
	$detail_pg_fail = "<b>PAGE DETAILS</b>: '%s' failed to be updated";
	
	$hide_page_note = "<b>PAGE MANAGEMENT</b>: '%s' was hidden from users.";
	$hide_page_note = "<b>PAGE MANAGEMENT</b>: '%s' was not hidden from users.";
	$show_page_note = "<b>PAGE MANAGEMENT</b>: '%s' was revealed to users.";
	$show_page_note = "<b>PAGE MANAGEMENT</b>: '%s' was not revealed to users.";
	
	$delete_part_page_note = "<b>PAGE MANAGEMENT</b>: '%s' was deleted from the database.";
	$delete_part_page_fail = "<b>PAGE MANAGEMENT</b>: '%s' failed to be deleted from the database.";
	$delete_full_page_note = "<b>PAGE MANAGEMENT</b>: '%s' was deleted from the file system.";
	$delete_full_page_fail = "<b>PAGE MANAGEMENT</b>: '%s' failed to be deleted from the file system.";
	
	$hide_sec_note = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' was hidden from users.";
	$hide_sec_fail = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' failed to be hidden from users.";
	$show_sec_note = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' was revealed to users.";
	$show_sec_fail = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' failed to be revealed to users.";
	
	$delete_sec_note = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' was deleted.";
	$delete_sec_fail = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' failed to be deleted.";
	$detail_sec_note = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' was deleted";
	$detail_sec_fail = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' failed to be deleted.";
	
	$delete_sec_note = "SECTION TEMPLATE: Section('%s') was deleted";
	$delete_sec_fail = "SECTION TEMPLATE: Section('%s') failed to be deleted.";
	
	$submit_sec_note = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' created.";
	$submit_sec_fail = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' failed to be created.";
	$update_sec_note = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' updated.";
	$update_sec_fail = "<b>SECTION MANAGEMENT</b>: Section('%s') of page '%s' failed to be updated.";
	
	$hide_tpl_note = "<b>PAGE TEMPLATE</b>: '%s' was hidden from users.";
	$hide_tpl_fail = "<b>PAGE TEMPLATE</b>: '%s' failed to be hidden from users.";
	$show_tpl_note = "<b>PAGE TEMPLATE</b>: '%s' was revealed to users.";
	$show_tpl_fail = "<b>PAGE TEMPLATE</b>: '%s' failed to be revealed to users.";
	
	$delete_part_tpl_note = "<b>PAGE TEMPLATE</b>: '%s' was deleted from the database.";
	$delete_part_tpl_fail = "<b>PAGE TEMPLATE</b>: '%s' failed to be deleted from the database.";
	$delete_full_tpl_note = "<b>PAGE TEMPLATE</b>: '%s' was deleted from the file system.";
	$delete_full_tpl_fail = "<b>PAGE TEMPLATE</b>: '%s' failed to be deleted from the file system.";
	
	$upload_tpl_note = "<b>PAGE TEMPLATE</b>: '%s' was uploaded and referenced.";
	$upload_tpl_fail = "<b>PAGE TEMPLATE</b>: '%s' failed to upload.";
	$create_tpl_db_fail = "<b>PAGE TEMPLATE</b>: '%s' failed to be created.";

	$fetch_full_page = "SELECT * FROM pg_list WHERE p_id='%s'";
	$fetch_sections = "
		SELECT title, content, tpl_file, img_name, img_desc, img_url
		FROM pg_section
		LEFT JOIN tpl_sc_list ON pg_section.tpl_sc_id=tpl_sc_list.tpl_sc_id
		WHERE p_id='%s' and view='1'
		ORDER BY pgsc_id";
	
	$fetch_section_sample = "
		SELECT title, content, tpl_file, img_name, img_desc, img_url
		FROM pg_section
		LEFT JOIN tpl_sc_list ON pg_section.tpl_sc_id=tpl_sc_list.tpl_sc_id
		WHERE pgsc_id='%s' and p_id='%s'";
?>