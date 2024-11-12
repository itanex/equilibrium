<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "Create Page";

	$valid_color = "genText";
	$invalid_color = "alert";
	
	$required = array(
		"frm_name",
		"frm_title",
		"frm_tpl"
	);
	
	$regex = array(
		"frm_name" => "^[a-zA-Z0-9._]{1,28}.[a-zA-Z]{3}$",
		"frm_title" => "^[a-zA-Z0-9._ ]{1,32}$",
		"frm_tpl" => "^[0-9]+$"
	);
	
	$colors = array(
		"frm_name" => $valid_color,
		"frm_title" => $valid_color,
		"frm_tpl" => $valid_color
	);
	
	$contents = array();
	
	foreach($required as $req){
		$contents[$req] = "";
	}
	
	function check_unique_filename($filename){
		global $pg_fetch_file;
		
		$result = mysql_query(sprintf($pg_fetch_file, $filename));
		
		return mysql_num_rows($result) == 0;
	}
	
	if(isset($_POST['frm_system'])){
		if(validate()){
			if(check_unique_filename($_POST['frm_name'])){
				mysql_query(sprintf($pg_insert, $_POST['frm_tpl'], strtolower($_POST['frm_name'].".php"), $_POST['frm_title'], $_SESSION['u_id']));
				if(mysql_affected_rows() == 1){
					$result = mysql_query(sprintf($pg_fetch_last_id, $_POST['frm_tpl'], strtolower($_POST['frm_name'].".php"), $_POST['frm_title'], $_SESSION['u_id']));
					$row = mysql_fetch_assoc($result);
					$pg_num = $row['p_id'];
					$result = mysql_query(sprintf($pg_tpl_fetch, $_POST['frm_tpl']));
					if(mysql_num_rows($result) == 1){
						$row = mysql_fetch_assoc($result);
						$tplfile = $my_root."pg_tpl/".$row['tpl_file'];
						$newfile = $base_root.$my_root.strtolower($_POST['frm_name'].".php");
						
						if(copy($basefile, $newfile)){
							$fp1 = fopen($tplfile, "r");
							$tpl_content = fread($fp1, filesize($tplfile));
							fclose($fp1);
							
							$tpl->loadTemplateFile($newfile);
							$tpl->loadVar("title", $_POST['frm_title']);
							$tpl->loadVar("pg_id", $pg_num);
							$tpl->loadVar("css", "css/default.css");
							$tpl->loadVar("pagetpl", $tpl_content);			
							$tpl->parseTpl();
							
							$fp2 = fopen($newfile, "w");
							fwrite($fp2, $tpl->returnParsed()); 
							fclose($fp2);
							
							$tpl->unLoadTemplate();
							
							$bkr->record_event(sprintf($page_create_note, $_POST['frm_name']));
							header("Location: ".$my_root."site/section_man.php?page=".$_POST['frm_name']."&id=".$pg_num);
						}else{
							$edit_err = "The server failed to create ".$_POST['frm_name'].".";
							$pg_num = mysql_insert_id();
							mysql_query(sprintf($pg_delete, $pg_num));
							if(mysql_affected_rows() != 1){
								$edit_err .= "<br>The database failed to remove the reference for your page. Please contact your system administrator.<br><br>Your page number is: ".$pg_num.".";
							}
						}
					}else{
						$edit_err = "There was an error retrieving the template file name from the database.";
					}
				}else{
					$edit_err = "There was an error posting the page to the database. No page was created.";
				}
			}else{
				$edit_err = "The filename you entered already exists.";
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
		
      <p class="genText">Define your new page's following settings.</p>
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
<input type="hidden" name="MAX_FILE_SIZE" value="30000">
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><p class="<?php echo $colors['frm_name']; ?>">Page Name: </p></td>
	<td><p class="<?php echo $colors['frm_name']; ?>"><input type="text" name="frm_name" size="32" maxlength="32" value="<?php echo $contents['frm_name']; ?>" class="dataField"> This is the name of the file on the server.</p></td>
</tr>
<tr>
	<td><p class="<?php echo $colors['frm_title']; ?>">Title: </p></td>
	<td><p class="<?php echo $colors['frm_title']; ?>"><input type="text" name="frm_title" size="32" maxlength="32" value="<?php echo $contents['frm_title']; ?>" class="dataField"> This is the title of your page which will be used to identify the page in the CMS and will be displayed in the page's title section.</p></td>
</tr>
<tr>
	<td><p class="<?php echo $colors['frm_tpl']; ?>">Template: </p></td>
	<?php
		$result = mysql_query($list_pg_tpl);
		if(mysql_num_rows($result) > 0){
		
	?>
	<td><p class="<?php echo $colors['frm_tpl']; ?>"><select name="frm_tpl">
	<?php
			while($row = mysql_fetch_assoc($result)){
	?>
		<option value="<?php echo $row['tpl_pg_id']; ?>"><?php echo $row['tpl_name']; ?></option>
	<?php
			}
	?>
	</select></p></td>
	<?php
		}else{
	?>
		<td><p class="alert">There are no templates loaded and/or active. You must first upload and activate a page template.</p></td>
	<?php
		}
	?>
</tr>
<tr>
	<td height="30" align="right" valign="bottom" colspan="2"><input type="submit" name="frm_system" value="Submit File" class="submitButton"></td>
</tr>
</table>
</form>
<p class="alert">If you want to work on a new file please go to the page listing and choose the file to edit from there.</p>
		<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>