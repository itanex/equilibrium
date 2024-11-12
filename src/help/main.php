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
		<td valign="top"><h1>F(requently) A(sked) Q(uestion)s</h1>
		  <p class="genText">The help system is pending development till a beta release.</p>
		  <h5>Creating a Page</h5>
		  <p class="genText">Creating a page is rather simple. First vist the create a page link in the CMS menu. Then enter the page name, this is what the CMS will name the file that you are creating. DO NOT include the file extension(ie .html/.php). This is done by the CMS. Next enter in the title of the page. This goes into the pages' title tags and is controled by the CMS. Next choose a template that the page will be set to use. Default is select for you but if you upload any new templates then you may choose one of those. After you are done click submit and the page will be created. You will be shown to the section management screen next. (see Section Management). </p>
		  <h5>Updating a Page's Detail</h5>
		  <p class="genText">To update a page's detail. Login and go to "View Page List" in the menu under "Page Management". Click the edit button for the page you with to edit. You can change the page's details at the top of the Section management page. You can also update a section of the page if you need to (see "Updating a Page Section").</p>
		  <h5>Updating a Page Section</h5>
		  <p class="genText">Updating a page is simple. Login and go to "View Page List" in the menu under "Page Management". Click the edit button for the page you with to edit. You will be presented with each section for your page. Find the section you with to update and click edit. Make your apropriate changes and then click the update button. You can also add a section via the Section listing page (see Adding a Page Section).</p>
		  <h5>Deleting a Page</h5>
		  <p class="genText">Deleting a page is as simple as going to the "View Page List" in the menu under "Page Management" and finding the file you with to delete and clicking the delete button.</p>
		  <h5>Page Sections - What is a page Section </h5>
		  <p class="genText">A page section is litterally as it is: a section of the page. I use page sections to denote a portion of a page that is presented via a specific section template. This template receives the information you provide via the section content input and displays it appropriately.</p>
		  <h5>Templates</h5>
		  <p class="genText"><b>Page Templates</b><br>A page template is a file that contains the body elements of a page. Equilibrium is designed to handle all your page's needs outside of the body. You can specify a CSS to be used by the page (*However, currently only single CSS files are supported). A tutorial on creating your own templates will be provided at a later time.</p>
		  <h5>Mods</h5>
		  <p class="genText"><b>What is a Mod?</b><br>Mod by all means can be defined as a module. Equillibrium uses a style of module that can be used to define a section of a page. When you develop a page section you can define a mod to manage that sections content. For example: you can develop a page that will display images. Instead of coding up all the images. A mod can provide the page and the CMS with a database file of the images and display them according to how mod is set up. All page sections utilize the "Base" Mod. It displays text and images and can include any HTML content that is provided.</p>
		  <p class="genText"><b>Can I use a Mod in my project</b><br>Modules are included with Equillibrium to help you provide more flavor to your site without having to develop them on site. All mods are developed for use with this CMS and any use outside is allowed but not recomended since they may contain code that depends on code in Equillibium. Credit to the author(s) of Equillibrium is request for any use of official mods for other projects not related to Equillibrium.</p>
		  <?php include($my_root."inc/copynotice.php"); ?></td>
	</tr>
</table>
</body>
</html>