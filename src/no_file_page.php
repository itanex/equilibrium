<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "File Not Available";
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
			<a href="index.php"><img src="images/cmslogo.gif" border="0"></a>
			<br>
<?php
	require_once($my_root."util/nav.php");
	require($my_root."inc/copynotice.php");
?>
		</td>
		<td valign="top"><h1>File Not Available</h1>
		<p class="genText" align="center">The file that this link directed you to does not yet exist. <br>
			Please be patient as this file will become available in the future.</p>
		<?php include("inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>