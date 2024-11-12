<?php
	//include required class files
	require_once("_dir_config.php");
	
	if(!(isset($_POST['frm_edit']) || isset($_GET['page']))){
		header("Location: page_list.php");
	}
	
	$pg_name = (isset($_POST['frm_page'])) ? $_POST['frm_page'] : $_GET['page'];
	$pg_id = (isset($_POST['frm_pid'])) ? $_POST['frm_pid'] : $_GET['id'];
	$page_title = "Section Listing For: ".$pg_name;

	$valid_color = "genText";
	$invalid_color = "alert";
	
	$required = array(
		"frm_title",
		"frm_tmpl",
		"frm_css"
	);
	
	$regex = array(
		"frm_title" => "^[a-zA-Z0-9._ ]{1,32}$",
		"frm_tmpl" => "^[0-9]+$",
		"frm_css" => "^[a-zA-Z0-9._ ]{1,32}$"
	);
	
	$color = array(
		"frm_title" => $valid_color,
		"frm_tmpl" => $valid_color,
		"frm_css" => $valid_color
	);
	
	$contents = array();
	
	foreach($required as $req){
		$contents[$req] = "";
	}
	
	if(isset($_POST['frm_hide'])){
		if(ereg("^[0-9]+$", $_POST['frm_sid'])){
			mysql_query(sprintf($hide_sec_update, $_POST['frm_sid']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($hide_sec_note, $_POST['frm_sid']));
				$edit_err = "The section(".$_POST['frm_sid'].") is now hidden from visitors.";
			}else{
				$bkr->record_event(sprintf($hide_sec_fail, $_POST['frm_sid']));
				$edit_err = "An error occured while attempting to update the view setting for section ".$_POST['frm_sid'].".";
			}
		}else{
			$edit_err = "There was an error validating the provided section ID(".$_POST['frm_sid'].").";
		}
	}else if(isset($_POST['frm_show'])){
		if(ereg("^[0-9]+$", $_POST['frm_sid'])){
			mysql_query(sprintf($show_sec_update, $_POST['frm_sid']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($show_sec_note, $_POST['frm_sid']));
				$edit_err = "The section(".$_POST['frm_sid'].") is now visible to visitors.";
			}else{
				$bkr->record_event(sprintf($show_sec_fail, $_POST['frm_sid']));
				$edit_err = "An error occured while attempting to update the view setting for section ".pg_id.".";
			}
		}else{
			$edit_err = "There was an error validating the provided section ID(".$_POST['frm_sid'].").";
		}
	}else if(isset($_POST['frm_delete'])){
		if(ereg("^[0-9]+$", $_POST['frm_sid'])){
			mysql_query(sprintf($section_delete, $_POST['frm_sid']));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($delete_sec_note, $_POST['frm_sid']));
				$edit_err = "The section(".$_POST['frm_sid'].") has now been removed from the CMS system.";
			}else{
				$bkr->record_event(sprintf($delete_sec_fail, $_POST['frm_sid']));
				$edit_err = "An error occured while attempting to delete section ".$_POST['frm_sid'].".";
			}
		}else{
			$edit_err = "There was an error validating the provided section ID(".$_POST['frm_sid'].").";
		}
	}else if(isset($_POST['frm_details'])){
		if(validate()){
			mysql_query(sprintf($update_page_details, $contents['frm_title'], $contents['frm_tmpl'], $contents['frm_css'], $pg_id));
			if(mysql_affected_rows() == 1){
				$bkr->record_event(sprintf($detail_pg_note, $_POST['frm_page']));
				$edit_err = "The page details have now been updated.";
			}else{
				$bkr->record_event(sprintf($detail_pg_fail, $_POST['frm_page']));
				$edit_err = "An error occured while attempting to update the page details.";
			}
		}else{
			$edit_err = "There was an error validating the provided page details.";
		}
	}else{
		$result = mysql_query(sprintf($fetch_page_details, $pg_id));
		if(mysql_num_rows($result) == 1){
			$row = mysql_fetch_assoc($result);
			$contents['frm_title'] = stripslashes($row['title']);
			$contents['frm_tmpl'] = $row['tpl_pg_id'];
			$contents['frm_css'] = $row['css_id'];
		}else{
			$edit_err = "There was an error retrieving the page details from the database.";
		}
	}
	
	function validate(){
		global $required, $regex, $colors, $contents, $invalid_color;
		$validated = true;
		
		foreach($required as $req){
			if(!ereg($regex[$req], $_POST[$req])){
				$validated = false;
				$colors[$req] = $invalid_color;
			}
			$contents[$req] = $_POST[$req];
		}
		return $validated;
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
?>
		<h5>Page Details</h5>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<input type="hidden" name="frm_pid" value="<?php echo $pg_id; ?>">
		<input type="hidden" name="frm_page" value="<?php echo $pg_name; ?>">
		<input type="hidden" name="frm_edit" value="true">
		<table border="0" cellpadding="2" cellspacing="0" width="500" class="tblBorder">
			<tr class="tblRowContent">
				<td><p class="<?php echo $color['frm_title']; ?>">Page Title:</p></td>
				<td><input type="text" name="frm_title" value="<?php echo $contents['frm_title']; ?>"></td>
			</tr>
			<tr class="tblRowContent">
				<td><p class="<?php echo $color['frm_tmpl']; ?>">Page Layout Template:</p></td>
				<td>
<?php
	$result = mysql_query($list_pg_tpl);
	if(mysql_num_rows($result) > 0){
	
?>
					<select name="frm_tmpl">
						<option>Choose a template</option>
<?php
		while($row = mysql_fetch_assoc($result)){
			if($row['tpl_pg_id'] == $contents['frm_tmpl']){
?>
						<option value="<?php echo $row['tpl_pg_id']; ?>" SELECTED><?php echo $row['tpl_name']; ?></option>
<?php
			}else{
?>
						<option value="<?php echo $row['tpl_pg_id']; ?>"><?php echo $row['tpl_name']; ?></option>
<?php
			}
		}
?>
					</select>
<?php
	}else{
?>
						<p class="alert">There are no templates loaded and/or active. You must first upload and activate a page template.</p>
<?php
	}
?>
				</td>
			</tr>
			<tr class="tblRowContent">
				<td><p class="<?php echo $color['frm_css']; ?>">Page CSS Resource:</p></td>
				<td>
<?php
	$result = mysql_query($list_css);
	if(mysql_num_rows($result) > 0){
	
?>
					<select name="frm_css">
						<option>Choose a CSS File</option>
<?php
		while($row = mysql_fetch_assoc($result)){
			if($row['css_id'] == $contents['frm_css']){
?>
						<option value="<?php echo $row['css_id']; ?>" SELECTED><?php echo $row['css_name']; ?></option>
<?php
			}else{
?>
						<option value="<?php echo $row['css_id']; ?>"><?php echo $row['css_name']; ?></option>
<?php
			}
		}
?>
					</select>
<?php
	}else{
?>
						<p class="alert">There are no CSS files loaded and/or active. You must first upload and activate a CSS file.</p>
<?php
	}
?>
				</td>
			</tr>
			<tr class="tblRowContent">
				<td align="right" colspan="2"><input type="submit" name="frm_details" value="Update Page" class="submitButton"></td>
			</tr>
		</table>
		</form>
		<hr width="500" align="left">
		<h5>Page Section Content</h5>
<?php	
	//load section listing tables
	$result = mysql_query(sprintf($sec_list_for_pg, $pg_id));
	$tpl->loadTemplateFile($my_root."templates/sec_list_tpl.php");
	while($row = mysql_fetch_assoc($result)){
		if($row['view']){
			$tpl->loadVar("sub_frm", "frm_hide");
			$tpl->loadVar("view", "Hide");
		}else{
			$tpl->loadVar("sub_frm", "frm_show");
			$tpl->loadVar("view", "Show");
		}
		$tpl->loadVar("pg_id", $pg_id);
		$tpl->loadVar("pg_name", $pg_name);
		$tpl->loadVar("pgsc_id", $row['pgsc_id']);
		$tpl->loadVar("title", stripslashes($row['title']));
		$tpl->loadVar("content", stripslashes($row['content']));
		if(stripslashes($row['img_name']) == ""){
			$tpl->loadVar("image", "../images/spacer.gif");
		}else{
			$tpl->loadVar("image", "../../img/".stripslashes($row['img_name']));
		}
		$tpl->loadVar("img_desc", stripslashes($row['img_desc']));
		$tpl->loadVar("img_url", stripslashes($row['img_url']));
		$tpl->loadVar("template", stripslashes($row['tpl_name']));
		$tpl->loadVar("updated", $row['updated']);
		$tpl->loadVar("self", $_SERVER['PHP_SELF']);
		$tpl->loadVar("demo", "sample.php?page=".$pg_id."&section=".$row['pgsc_id']);
		
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadVars();
	}
	$tpl->unLoadTemplate();
	
?>
		<p class="genText"><a href="section_man.php?page=<?php echo $pg_name; ?>&id=<?php echo $pg_id; ?>" class="genText">Add a new section</a></p>
			<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>