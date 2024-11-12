<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "Edit Page";

	$valid_color = "genText";
	$invalid_color = "alert";
	
	$required = array(
		"frm_name",
		"frm_location",
		"frm_file",
		"frm_body"
	);
	
	$regex = array(
		"frm_name" => "^[a-zA-Z0-9]{6,32}$",
		"frm_location" => "^[a-zA-Z0-9]{6,32}$",
		"frm_file" => "^[a-zA-Z0-9]{6,32}$",
		"frm_body" => "^[a-zA-Z0-9]{6,32}$"
	);
	
	$colors = array(
		"frm_name" => $valid_color,
		"frm_location" => $valid_color,
		"frm_file" => $valid_color,
		"frm_body" =>  $valid_color
	);
	
	if(isset($_POST['frm_add'])){
		if(validate()){
			if(!unique_user($_POST['frm_user'])){
				$add_admin = add_user($_POST['frm_user'], $_POST['frm_pass']);
			}else{
				$common = "The username ".$_POST['frm_user']." is already in use.";
			}
		}else{
			$invalid = "Please insure that all fields contain a valid entry.";
		}
	}
	
	function validate(){
		global $required, $regex, $colors, $invalid_color;
		$validated = true;
		
		foreach($required as $req){
			if(!ereg($regex[$req], $_POST[$req])){
				$validated = false;
				$colors[$req] = $invalid_color;
			}
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
		
      <p class="genText">This page will allow you to edit a selected page's settings.</p>
<h1>Update Page Reference</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><p class="<?php echo $colors['frm_name']; ?>">Page Name: </p></td>
	<td><p class="<?php echo $colors['frm_name']; ?>"><input type="text" name="frm_name" size="16" maxlength="32" value="<?php echo (isset($_POST['frm_name'])) ? $_POST['frm_name'] : ""; ?>" class="submitButton"> original file name</p></td>
</tr>
<tr>
	<td><p class="<?php echo $colors['frm_location']; ?>">Location: </p></td>
	<td><p class="<?php echo $colors['frm_location']; ?>"><input type="text" name="frm_pass" size="16" maxlength="32" value="<?php echo (isset($_POST['frm_location'])) ? $_POST['frm_location'] : ""; ?>" class="submitButton"> location on server</p></td>
</tr>
<tr>
	<td><p class="<?php echo $colors['frm_file']; ?>">File: </p></td>
	<td><p class="<?php echo $colors['frm_file']; ?>"><input type="text" name="frm_pass" size="16" maxlength="32" value="<?php echo (isset($_POST['frm_file'])) ? $_POST['frm_file'] : ""; ?>" class="submitButton"> original file</p></td>
</tr>
<tr>
	<td></td>
	<td height="30" valign="bottom"><input type="submit" name="frm_system" value="Update Details" class="submitButton"></td>
</tr>
</table>
</form>
<h1>Update Page Content</h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><p class="<?php echo $colors['frm_name']; ?>">Page Name: </p></td>
	<td><p class="<?php echo $colors['frm_name']; ?>"><input type="text" name="frm_name" size="16" maxlength="32" value="<?php echo (isset($_POST['frm_name'])) ? $_POST['frm_name'] : ""; ?>" class="submitButton"> minimum of 6 alpha-numeric characters</p></td>
</tr>
<tr>
	<td><p class="<?php echo $colors['frm_location']; ?>">Location: </p></td>
	<td><p class="<?php echo $colors['frm_location']; ?>"><input type="text" name="frm_pass" size="16" maxlength="32" value="<?php echo (isset($_POST['frm_location'])) ? $_POST['frm_location'] : ""; ?>" class="submitButton"> minimum of 6 alpha-numeric characters</p></td>
</tr>
<tr>
	<td valign="top"><p class="<?php echo $colors['frm_body']; ?>">Body Contents: </p></td>
	<td><p class="<?php echo $colors['frm_body']; ?>"><textarea name="frm_body" cols="40" rows="10" class="submitButton"><?php echo (isset($_POST['frm_body'])) ? $_POST['frm_body'] : ""; ?></textarea> minimum of 6 alpha-numeric characters</p></td>
</tr>
<tr>
	<td></td>
	<td height="30" valign="bottom"><input type="submit" name="frm_man" value="Update Content" class="submitButton"></td>
</tr>
</table>
</form>
		<?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>