<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "Page Listing";
	
	if(isset($_POST['frm_hide'])){
		if(ereg("^[0-9]+$", $_POST['frm_pid'])){
			mysql_query(sprintf($hide_pg_update, $_POST['frm_pid']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($hide_page_note, $_POST['frm_page']));
				$edit_err = "The page '".$_POST['frm_page']."' is now hidden from visitors.";
			}else{
				$bkr->record_event(sprintf($hide_page_fail, $_POST['frm_page']));
				$edit_err = "An error occured while attempting to update the view setting for '".$_POST['frm_page']."'.";
			}
		}else{
			$edit_err = "There was an error validating the provided page ID(".$_POST['frm_pid'].").";
		}
	}else if(isset($_POST['frm_show'])){
		if(ereg("^[0-9]+$", $_POST['frm_pid'])){
			mysql_query(sprintf($show_pg_update, $_POST['frm_pid']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($show_page_note, $_POST['frm_page']));
				$edit_err = "The page '".$_POST['frm_page']."' is now visible to visitors.";
			}else{
				$bkr->record_event(sprintf($show_page_fail, $_POST['frm_page']));
				$edit_err = "An error occured while attempting to update the view setting for '".$_POST['frm_page']."'.";
			}
		}else{
			$edit_err = "There was an error validating the provided page ID(".$_POST['frm_pid'].").";
		}
	}else if(isset($_POST['frm_delete'])){
		if(ereg("^[0-9]+$", $_POST['frm_pid'])){
			mysql_query(sprintf($pg_delete, $_POST['frm_pid']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($delete_part_page_note, $_POST['frm_page']));
				$edit_err = "The page '".$_POST['frm_page']."' has now been removed from the CMS system.";
				if(unlink($pg_dir.$_POST['frm_page'])){
					$bkr->record_event(sprintf($delete_full_page_note, $_POST['frm_page']));
					$edit_err .= " The associated file was deleted successfully.";
				}else{
					$bkr->record_event(sprintf($delete_full_page_fail, $_POST['frm_page']));
					$edit_err .= " An error occured while attempting to delete the file '".$_POST['frm_page']."'.";
				}
			}else{
				$bkr->record_event(sprintf($delete_part_page_fail, $_POST['frm_page']));
				$edit_err = "An error occured while attempting to delete '".$_POST['frm_page']."'.";
			}
		}else{
			$edit_err = "There was an error validating the provided page ID(".$_POST['frm_pid'].").";
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
			<a href="<?php echo $my_root; ?>index.php"><img src="<?php echo $my_root; ?>images/cmslogo.gif" border="0"></a>
			<br>
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
	include_once($my_root."inc/site_list_head.php");
	
	//load page listing table contents
	$result = mysql_query($all_page_list);
	$tpl->loadTemplateFile($my_root."templates/pg_list_tpl.php");
	while($row = mysql_fetch_assoc($result)){
		if($row['view']){
			$tpl->loadVar("sub_frm", "frm_hide");
			$tpl->loadVar("view", "Hide");
		}else{
			$tpl->loadVar("sub_frm", "frm_show");
			$tpl->loadVar("view", "Show");
		}
		$tpl->loadVar("pg_id", $row['p_id']);
		$tpl->loadVar("pg_name", stripslashes($row['title']));
		$tpl->loadVar("location", stripslashes($row['filename']));
		$tpl->loadVar("updated", $row['updated']);
		$tpl->loadVar("checked_out", ($row['checked_out']) ? "Yes" : "No");
		$tpl->loadVar("self", $_SERVER['PHP_SELF']);
		
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadVars();
	}
	$tpl->unLoadTemplate();
	
	//load table footer
	include_once($my_root."inc/site_list_foot.php");
?>
		<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>