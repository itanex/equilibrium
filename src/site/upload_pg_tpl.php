<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "Upload Page Template";

	$valid_color = "genText";
	$invalid_color = "alert";
	
	$required = array(
		"frm_name"
	);
	
	$regex = array(
		"frm_name" => "^([a-zA-Z0-9_]){1,32}$"
	);
	
	$colors = array(
		"frm_name" => $valid_color,
		"frm_file" => $valid_color
	);
	
	$contents = array();
	
	foreach($required as $req){
		$contents[$req] = "";
	}
	
	function check_unique_file($filename){
		global $pg_tpl_fetch_file;
		
		$result = mysql_query(sprintf($pg_tpl_fetch_file, $filename));
				
		return mysql_num_rows($result) == 0;
	}
	
	function check_unique_name($name){
		global $pg_tpl_fetch_name;
		
		$result = mysql_query(sprintf($pg_tpl_fetch_name, $name));
				
		return mysql_num_rows($result) == 0;
	}
	
	if(isset($_POST['frm_send'])){
		if(validate() && $_FILES['frm_file']['name'] != ""){
			if(check_unique_file($_FILES['frm_file']['name'])){
				if(check_unique_name($_POST['frm_name'])){
					mysql_query(sprintf($pg_tpl_insert, $_FILES['frm_file']['name'], $_POST['frm_name'], $_SESSION['u_id']));
					if(mysql_affected_rows() == 1){
						$tplfile = $tpl_pg_dir.$_FILES['frm_file']['name']; //full path to final upload dir.filename.ext
						
						if(move_uploaded_file($_FILES['frm_file']['tmp_name'], $tplfile)){ 
							chmod($tplfile, 0644); //must set readability for base users
							$bkr->record_event(sprintf($upload_tpl_note, $_FILES['frm_file']['name']));
							$edit_err = $_FILES['frm_file']['name']." is valid, and was successfully uploaded.";
						}else{
							$bkr->record_event(sprintf($upload_tpl_fail, $_FILES['frm_file']['name']));
							$edit_err = $_FILES['frm_file']['name']." failed to upload. <br>".$_FILES['frm_file']['error'];
						} 
							
						header("Location: ".$my_root."site/tpl_pg_list.php");
					}else{
						$bkr->record_event(sprintf($create_tpl_db_fail, $_POST['frm_name']));
						$edit_err = "The server failed to create ".$_POST['frm_name'].".";
						$tpl_pg = mysql_insert_id();
						mysql_query(sprintf($pg_tpl_delete, $tpl_pg));
						if(mysql_affected_rows() != 1){
							$edit_err .= "<br>The database failed to remove the reference for the page template file. Please contact your system administrator.<br><br>Your page template id is: ".$tpl_pg.".";
						}
					}
				}else{
					$edit_err = "The page template name you entered already exists.";
				}
			}else{
				$edit_err = "The page template file you entered already exists.";
			}
		}else{
			$edit_err = "Please insure that all fields contain a valid entry.";
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
		<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
		<input type="hidden" name="MAX_FILE_SIZE" value="30000">
		<table width="300" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td width="125" nowrap><p class="genText">Template Name: </p></td>
				<td nowrap><p class="genText"><input type="text" name="frm_name" size="32" maxlength="32" value="<?php echo $content['frm_name']; ?>" class="dataField"></p></td>
			</tr>
			<tr>
				<td nowrap><p class="genText">Template File: </p></td>
				<td nowrap><p class="genText"><input name="frm_file" type="file" class="submitButton"> Max File size 30k</p></td>
			</tr>
			<tr>
				<td colspan="2" align="right"><input type="submit" name="frm_send" value="Send File" class="submitButton"> </td>
			</tr>
		</table>
		</form>
		<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>