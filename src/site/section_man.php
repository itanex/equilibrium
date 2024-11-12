<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "Section Management";
	$sub_type = "Submit";

	$valid_color = "genText";
	$invalid_color = "alert";
	
	$pg_name = (isset($_POST['frm_page'])) ? $_POST['frm_page'] : $_GET['page'];
	$pg_id = (isset($_POST['frm_pid'])) ? $_POST['frm_pid'] : $_GET['id'];
	
	$required = array(
		"frm_pid",
		"frm_title",
		"frm_content",
		"frm_img",
		"frm_img_dsc",
		"frm_img_url",
		"frm_tpid"
	);
	
	$regex = array(
		"frm_pid" => "^[0-9]*$",
		"frm_title" => "^[a-zA-Z0-9_.,\'\"!@#$%&*() ]*$",
		"frm_content" => "^(.)+$",
		"frm_img" => "^(.)*$",
		"frm_img_dsc" => "^[a-zA-Z0-9_.,\'\"!@#$%&*() ]*$",
		"frm_img_url" => "^[a-zA-Z0-9_.,\'\"!@#$%&*() ]*$",
		"frm_tpid" => "^[0-9]+$"
	);
	
	$colors = array(
		"frm_pid" => $valid_color,
		"frm_title" => $valid_color,
		"frm_content" => $valid_color,
		"frm_img" => $valid_color,
		"frm_img_dsc" => $valid_color,
		"frm_img_url" => $valid_color,
		"frm_tpid" => $valid_color
	);
	
	$contents = array();
	
	foreach($required as $req){
		$contents[$req] = "";
	}
	
	if(isset($_POST['frm_system'])){
		if(validate()){
			if($_POST['frm_system'] == "Submit"){
				mysql_query(sprintf($section_insert, $pg_id, $_POST['frm_tpid'], $_POST['frm_title'], $_POST['frm_content'], $_FILES['frm_img']['name'], $_POST['frm_img_dsc'], $_POST['frm_img_url']));
				if(mysql_affected_rows() == 1){
					if(uploadFile()){
						$bkr->record_event(sprintf($submit_sec_note, $_POST['frm_title'], $_POST['frm_page']));
						header("Location: section_list.php?page=".$pg_name."&id=".$pg_id);
					}else{
						$bkr->record_event(sprintf($submit_sec_fail, $_POST['frm_title'], $_POST['frm_page']));
						$edit_err = "There was an error uploading the file.";
					}
				}else{
					$edit_err = "There was an error inserting the data into the database.<br>".mysql_error();
				}
			}else if($_POST['frm_system'] == "Update"){
				mysql_query(sprintf($section_update, $pg_id, $_POST['frm_tpid'], $_POST['frm_title'], $_POST['frm_content'], $_FILES['frm_img']['name'], $_POST['frm_img_dsc'], $_POST['frm_img_url'], $_POST['frm_sid']));
				if(mysql_affected_rows() == 1){
					if(uploadFile()){
						$bkr->record_event(sprintf($update_sec_note, $_POST['frm_title'], $_POST['frm_page']));
						header("Location: section_list.php?page=".$pg_name."&id=".$pg_id);
					}else{
						$bkr->record_event(sprintf($update_sec_fail, $_POST['frm_title'], $_POST['frm_page']));
						$edit_err = "There was an error uploading the file.";
					}
				}else{
					$edit_err = "There was an error updating the data into the database.<br>".mysql_error();
					$sub_type = "Update";
				}
			}
		}else{
			$edit_err = "Please insure that all fields contain a valid entry.";
			if($_POST['frm_system'] == "Update"){
				$sub_type = "Update";
			}
		}
	}else if($_POST['frm_edit']){
		$result = mysql_query(sprintf($sec_fetch, $_POST['frm_sid']));
		if(mysql_num_rows($result) == 1){
			$row = mysql_fetch_assoc($result);
			$contents['frm_title'] = stripslashes($row['title']);
			$contents['frm_content'] = stripslashes($row['content']);
			$contents['frm_img'] = $row['img_name'];
			$contents['frm_img_dsc'] = stripslashes($row['img_desc']);
			$contents['frm_img_url'] = stripslashes($row['img_url']);
			$contents['frm_tpid'] = $row['tpl_sc_id'];
			$sub_type = "Update";
		}else{
			header("Location: section_list.php?page=".$pg_name."&id=".$pg_id);
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
	
	function uploadFile(){
		if($_FILES['userfile']['name'] != ""){
			$uploadfile = "../../img/".$_FILES['userfile']['name']; //full path to final upload_dir.filename.ext
			if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)){ 
			   chmod($uploadfile, 0644); //must set readability for base users
			}else{
				//make a decent upload file error
				//return false;
			}
		}
			return true;
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
		
      <p class="genText">Create your page content here.</p>
<?php
	if(isset($edit_err)){
		$tpl->loadTemplateFile($my_root."templates/user_alert_tpl.php");
		$tpl->loadVar("alert", $edit_err);
		$tpl->parseTpl();
		echo $tpl->returnParsed();
		$tpl->unLoadTemplate();
	}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="frm_pid" value="<?php echo $pg_id; ?>">
<input type="hidden" name="frm_page" value="<?php echo $pg_name; ?>">
<input type="hidden" name="frm_sid" value="<?php echo $_POST['frm_sid']; ?>">
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td colspan="2">
		<table cellpadding="2" cellspacing="0" border="0">
			<tr>
				<td><a href="#" class="genText"><img src="../images/bold.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/italic.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/underline.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/aleft.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/acenter.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/aright.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/bullet.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/numbered.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/increase.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/break.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/link.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/email.gif"></a></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td><p class="<?php echo $colors['frm_title']; ?>">Title:</p></td>
	<td><p class="<?php echo $colors['frm_title']; ?>"><input type="text" name="frm_title" size="32" maxlength="32" value="<?php echo $contents['frm_title']; ?>" class="dataField">
              </p></td>
</tr>
<tr>
	<td colspan="2">
		<table cellpadding="2" cellspacing="0" border="0">
			<tr>
				<td><a href="#" class="genText"><img src="../images/bold.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/italic.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/underline.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/aleft.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/acenter.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/aright.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/bullet.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/numbered.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/increase.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/break.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/link.gif"></a></td>
				<td><a href="#" class="genText"><img src="../images/email.gif"></a></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td valign="top"><p class="<?php echo $colors['frm_content']; ?>">Text:</p></td>
	<td><p class="<?php echo $colors['frm_content']; ?>"><textarea name="frm_content" rows="20" cols="80" class="dataField"><?php echo $contents['frm_content']; ?></textarea>
              </p></td>
</tr>
<tr>
	<td valign="top"><p class="<?php echo $colors['frm_img']; ?>">Image:</p></td>
	<td><p class="<?php echo $colors['frm_img']; ?>"><input type="file" name="frm_img" value="Browse" class="submitButton"></td>
</tr>
<tr>
	<td><p class="<?php echo $colors['frm_img_dsc']; ?>">Short Description:</p></td>
	<td><p class="<?php echo $colors['frm_img_dsc']; ?>"><input type="text" name="frm_img_dsc" size="32" maxlength="32" value="<?php echo $contents['frm_img_dsc']; ?>" class="dataField">
              </p></td>
</tr>
<tr>
	<td><p class="<?php echo $colors['frm_img_url']; ?>">Image URL:</p></td>
	<td><p class="<?php echo $colors['frm_img_url']; ?>"><input type="text" name="frm_img_url" size="64" maxlength="255" value="<?php echo $contents['frm_img_url']; ?>" class="dataField">
              </p></td>
</tr>
<tr>
	<td><p class="<?php echo $colors['frm_tpid']; ?>">Template: </p></td>
<?php
	$result = mysql_query($all_sc_tpl_list);
	if(mysql_num_rows($result) > 0){
?>
	<td><p class="<?php echo $colors['frm_tpid']; ?>"><select name="frm_tpid" class="dataField">
<?php
		while($row = mysql_fetch_assoc($result)){
			if($row['tpl_sc_id'] == $contents['frm_tpid']){
?>
		<option value="<?php echo $row['tpl_sc_id']; ?>" selected><?php echo $row['tpl_name']; ?></option>
<?php
			}else{
?>
		<option value="<?php echo $row['tpl_sc_id']; ?>"><?php echo $row['tpl_name']; ?></option>
<?php
			}
		}
?>
	</select></p></td>
<?php
	}else{
?>
	<td><p class="alert">There are currently no section templates either uploaded or active. Please upload or activate a template to continue.</p></td>
<?php
	}
?>
</tr>
<tr>
	<td height="30" align="right" valign="bottom" colspan="2"><input type="submit" name="frm_system" value="<?php echo $sub_type; ?>" class="submitButton"></td>
</tr>
</table>
</form>
		<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>