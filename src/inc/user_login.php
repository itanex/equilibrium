<!-- BEGIN USER LOGIN -->
<h1>User Login</h1>
<form action="<?php echo $my_root; ?>userman/verify.php" method="post">
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td><p class="genText">Username:</p></td>
		<td><input type="text" name="frm_user" size="16" maxlength="32"></td>
	</tr>
	<tr>
		<td><p class="genText">Password:</p></td>
		<td><input type="password" name="frm_pass" size="16" maxlength="32"></td>
	</tr>
	<tr>
		<td></td>
		<td height="30" valign="bottom"><input type="submit" name="frm_login" value="Login"></td>
	</tr>
</table>
</form>
<!-- END USER LOGIN -->