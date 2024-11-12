<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "Page Template Listing";
	
	if(isset($_POST['frm_hide'])){
		if(ereg("^[0-9]+$", $_POST['frm_tpl_id'])){
			mysql_query(sprintf($hide_pg_tpl_update, $_POST['frm_tpl_id']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($hide_tpl_note, $_POST['frm_name']));
				$edit_err = "Template \"".$_POST['frm_name']."\" is now hidden from content managers.";
			}else{
				$bkr->record_event(sprintf($hide_tpl_fail, $_POST['frm_name']));
				$edit_err = "An error occured while attempting to update the view setting for template ".$_POST['frm_name'].".";
			}
		}else{
			$edit_err = "There was an error validating the provided template ID(".$_POST['frm_name'].").";
		}
	}else if(isset($_POST['frm_show'])){
		if(ereg("^[0-9]+$", $_POST['frm_tpl_id'])){
			mysql_query(sprintf($show_pg_tpl_update, $_POST['frm_tpl_id']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($show_tpl_note, $_POST['frm_name']));
				$edit_err = "Template \"".$_POST['frm_name']."\" is now visible to content managers.";
			}else{
				$bkr->record_event(sprintf($show_tpl_fail, $_POST['frm_name']));
				$edit_err = "An error occured while attempting to update the view setting for template ".$_POST['frm_name'].".";
			}
		}else{
			$edit_err = "There was an error validating the provided template ID(".$_POST['frm_name'].").";
		}
	}else if(isset($_POST['frm_delete'])){
		if(ereg("^[0-9]+$", $_POST['frm_tpl_id'])){
			mysql_query(sprintf($pg_tpl_delete, $_POST['frm_tpl_id']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($delete_part_page_note, $_POST['frm_name']));
				$edit_err = "Template \"".$_POST['frm_name']."\" has been removed from the Database system.";
				if(unlink($tpl_pg_dir.$_POST['frm_file'])){
					$bkr->record_event(sprintf($delete_full_page_note, $_POST['frm_file']));
					$edit_err .= "The associated file was deleted successfully deleted.";
				}else{
					$bkr->record_event(sprintf($delete_full_page_fail, $_POST['frm_file']));
					$edit_err .= "An error occured while attempting to delete the file ".$_POST['frm_file'].".";
				}
			}else{
				$bkr->record_event(sprintf($delete_part_page_fail, $_POST['frm_name']));
				$edit_err = "An error occured while attempting to delete template ".$_POST['frm_name'].".";
			}
		}else{
			$edit_err = "There was an error validating the provided template ID(".$_POST['frm_name'].").";
		}
	}
?>
<html lang="EN">
<?php
	$tpl->loadTemplateFile($my_root."templates/all_pg_head.php");
	$tpl->loadVar("pg_title", $app_title.$app_copyright.$page_title);
	$tpl->loadVar("css", $my_root."css/cms.css");
	$tpl->parseTpl();
	echo $tpl->returnParsed();
	$tpl->unLoadTemplate();
?>
<body>
<table width="90%" border="0" cellpadding="2" cellspacing="0">
	<tr> 
		<td width="150" valign="top" align="center">
			<a href="<?php echo $my_root; ?>index.php"><img src="<?php echo $my_root; ?>images/cmslogo.gif" border="0" /></a>
			<br />
<?php
	require_once($my_root."util/nav.php");
	require($my_root."inc/copynotice.php");
?>
		</td>
		<td valign="top"><h1><?php echo $page_title; ?></h1>
<?php
	if(isset($edit_err)){
		$tpl->loadTemplateFile($my_root."templates/user_alert_tpl.php");
		$tpl->loadVar("alert", $edit_err);
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadTemplate();
	}

	//load table heading
	include_once($my_root."inc/tpl_list_head.php");
	
	//load page listing table contents
	$result = mysql_query($all_pg_tpl_list);
	$tpl->loadTemplateFile($my_root."templates/tpl_list_tpl.php");
	while($row = mysql_fetch_assoc($result)){
		if($row['tpl_view']){
			$tpl->loadVar("sub_frm", "frm_hide");
			$tpl->loadVar("view", "Hide");
		}else{
			$tpl->loadVar("sub_frm", "frm_show");
			$tpl->loadVar("view", "Show");
		}
		$tpl->loadVar("tpl_id", $row['tpl_pg_id']);
		$tpl->loadVar("name", $row['tpl_name']);
		$tpl->loadVar("file", $row['tpl_file']);
		$tpl->loadVar("updated", $row['updated']);
		$tpl->loadVar("edit", "tpl_pg_edit.php");
		$tpl->loadVar("author", $row['username']);
		$tpl->loadVar("my_root", $my_root);
		$tpl->loadVar("self", $_SERVER['PHP_SELF']);
		
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadVars();
	}
	$tpl->unLoadTemplate();
	
	//load table footer
	include_once($my_root."inc/tpl_list_foot.php");
?>
		<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>