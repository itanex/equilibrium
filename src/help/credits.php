<?php
	//include required class files
	require_once("_dir_config.php");
	$page_title = "FAQ";
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
		<td valign="top"><h1>Equilibrium Credits </h1>
		  <p class="genText">Please give honor to this list.</p>
		  <ul>
			  <li class="genText"><b>Bryan Wood(itanex)</b> -
			    <ul>
		  	      <li class="genText">Developer/Founder</li>
		  	      <li class="genText">Main Engine Coder</li>
		  	      <li class="genText">MySQL Development</li>
		  	      <li class="genText">Developer/Founder</li>
		  	      <li class="genText">Layout and Design</li>
		        </ul>
			  </li>
	      </ul>
		  <?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>