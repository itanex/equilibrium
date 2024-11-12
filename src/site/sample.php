<?php
	require_once($my_root."_dir_config.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<link rel="stylesheet" href="<?php echo $_GET['css'] or "css/ix.css"; ?>" type="text/css">
</head>
<body>
<?php
	//get section count
	$result = mysql_query(sprintf($fetch_section_sample, $_GET['section'], $_GET['page']));
	if(mysql_num_rows($result) == 1){
		$row = mysql_fetch_assoc($result);
		$tpl->loadTemplateFile($my_root."sc_tpl/".$row['tpl_file']);
		$tpl->loadVar("sec_title", stripslashes($row['title']));
		$tpl->loadVar("sec_body", stripslashes($row['content']));
		$tpl->loadVar("image", stripslashes($row['img_name']));
		$tpl->loadVar("link", stripslashes($row['img_url']));
		$tpl->loadVar("alt_text", stripslashes($row['img_desc']));
		$tpl->parseTpl();
		echo $tpl->returnParsed();
	}else{
?>
<p class="alert">There are no sections or there was an error with the database.<br>[Database Error: <?php echo mysql_error(); ?>]<br><?php echo sprintf($fetch_section_sample, $_GET['section'], $_GET['page']); ?></p>
<?php
	}
?>
</body>
</html>