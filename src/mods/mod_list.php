<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "Mod Listing";
	
	if(isset($_POST['frm_hide'])){
		if(ereg("^[0-9]+$", $_POST['frm_mid'])){
			mysql_query(sprintf($hide_mod_update, $_POST['frm_mid']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($hide_mod_note, $_POST['frm_mod']));
				$edit_err = "The page '".$_POST['frm_mod']."' is now hidden from users.";
			}else{
				$bkr->record_event(sprintf($hide_mod_fail, $_POST['frm_mod']));
				$edit_err = "An error occured while attempting to update the view setting for '".$_POST['frm_mod']."'.";
			}
		}else{
			$edit_err = "There was an error validating the provided mod ID(".$_POST['frm_mid'].").";
		}
	}else if(isset($_POST['frm_show'])){
		if(ereg("^[0-9]+$", $_POST['frm_mid'])){
			mysql_query(sprintf($show_mod_update, $_POST['frm_mid']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($show_mod_note, $_POST['frm_mod']));
				$edit_err = "The page '".$_POST['frm_mod']."' is now visible to users.";
			}else{
				$bkr->record_event(sprintf($show_mod_fail, $_POST['frm_mod']));
				$edit_err = "An error occured while attempting to update the view setting for '".$_POST['frm_mod']."'.";
			}
		}else{
			$edit_err = "There was an error validating the provided mod ID(".$_POST['frm_mid'].").";
		}
	}else if(isset($_POST['frm_delete'])){
		if(ereg("^[0-9]+$", $_POST['frm_mid'])){
			mysql_query(sprintf($mod_delete, $_POST['frm_mid']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($delete_part_mod_note, $_POST['frm_mod']));
				$edit_err = "The page '".$_POST['frm_mod']."' has now been removed from the CMS system.";
				if(unlink($mod_dir.$_POST['frm_mod'])){
					$bkr->record_event(sprintf($delete_full_mod_note, $_POST['frm_mod']));
					$edit_err .= " The associated file was deleted successfully.";
				}else{
					$bkr->record_event(sprintf($delete_full_mod_fail, $_POST['frm_mod']));
					$edit_err .= " An error occured while attempting to delete the file '".$_POST['frm_mod']."'.";
				}
			}else{
				$bkr->record_event(sprintf($delete_part_page_fail, $_POST['frm_mod']));
				$edit_err = "An error occured while attempting to delete '".$_POST['frm_mod']."'.";
			}
		}else{
			$edit_err = "There was an error validating the provided mod ID(".$_POST['frm_mid'].").";
		}
	}
?>
<html lang="EN">
<?php
	$tpl->loadTemplateFile($my_root."templates/all_pg_head.php");
	$tpl->loadVar("mod_title", $app_title.$app_copyright.$page_title);
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
	include_once($my_root."inc/mod_list_head.php");
	
	//load page listing table contents
	$result = mysql_query($all_mod_list);
	$tpl->loadTemplateFile($my_root."templates/mod_list_tpl.php");
	while($row = mysql_fetch_assoc($result)){
		if($row['view']){
			$tpl->loadVar("sub_frm", "frm_hide");
			$tpl->loadVar("view", "Hide");
		}else{
			$tpl->loadVar("sub_frm", "frm_show");
			$tpl->loadVar("view", "Show");
		}
		$tpl->loadVar("mod_id", $row['mod_id']);
		$tpl->loadVar("mod_name", stripslashes($row['mod_name']));
		$tpl->loadVar("location", stripslashes($row['mod_file']));
		$tpl->loadVar("updated", $row['updated']);
		$tpl->loadVar("self", $_SERVER['PHP_SELF']);
		
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadVars();
	}
	$tpl->unLoadTemplate();
	
	//load table footer
	include_once($my_root."inc/mod_list_foot.php");
?>
		<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>