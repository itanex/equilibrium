<?php
	require_once("_dir_config.php");
	$my_id = {PG_ID};
	$pg->can_view($my_id);
	$result = mysql_query(sprintf($fetch_full_page, $my_id));
	if(mysql_num_rows($result) == 1){
		$row = mysql_fetch_assoc($result);
		$pg_title =	$row['title'];
		$pg_css = $row['css_file'];
	}else{
		die("Database error - This page is not available from the Equalibrium CMS system.");
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>	
	<title><?php echo $pg_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="css/<?php echo $pg_css; ?>">
</head>
<body>
{PAGETPL}
</body>
</html>