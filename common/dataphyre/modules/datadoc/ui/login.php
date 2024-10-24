<?php
/*************************************************************************
*  2020-2022 Shopiro Ltd.
*  All Rights Reserved.
* 
* NOTICE:  All information contained herein is, and remains the 
* property of Shopiro Ltd. and its suppliers, if any. The 
* intellectual and technical concepts contained herein are 
* proprietary to Shopiro Ltd. and its suppliers and may be 
* covered by Canadian and Foreign Patents, patents in process, and 
* are protected by trade secret or copyright law. Dissemination of 
* this information or reproduction of this material is strictly 
* forbidden unless prior written permission is obtained from Shopiro Ltd..
*/

if(dataphyre\datadoc::logged_in()){
	header("Location: ".dataphyre\core::url_self()."dataphyre/datadoc");
}

if(isset($_POST['login_datadoc'])){
	if(dataphyre\core::csrf("datadoc_login", $_POST['csrf'])){
		if(true===dataphyre\datadoc::login($_POST['login_datadoc'])){
			header("Refresh:0");
		}
	}
	else
	{
		echo'Bad CSRF';
	}
}

require_once(__DIR__."/header.php");
?>
<div class="row justify-content-center main-row">
	<div class="col col-md-6 col-lg-3 col-xl-4 pt-3 pb-5">
		<div class="card p-3">
			<center>
				<h2>Login to DataDoc</h2>
				<form method="post">
					<input type="password" class="form-control" name="login_datadoc">
					<input type="hidden" class="form-control" name="csrf" value="<?=dataphyre\core::csrf("datadoc_login");?>">
					<input type="submit" class="btn btn-success btn-block mt-3" value="Login">
				</form>
			</center>
		</div>
	</div>
</div>
<?php
require_once(__DIR__."/footer.php");