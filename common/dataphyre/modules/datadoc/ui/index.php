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

if(dataphyre\datadoc::logged_in()!==true){
	require_once(__DIR__."/login.php");
	exit();
}

require_once(__DIR__."/header.php");
?>
<div class="row main-row">
	<div class="col p-0 navigation-col">
		<div class="wrapper center-block h-100">
			<div class="panel-group h-100 py-3" id="accordion" role="tablist" aria-multiselectable="true">
				<?php require(__DIR__."/left_sidebar.php");?>
			</div>
		</div>
	</div>
	<div class="col col-md-6 col-lg-7 col-xl-8 pt-3 pb-5">
		<?=adapt(["dark"=>"<style>p,li,h1,h2,h3,h4,h5,h6{color:white !important;}</style>"]);?>
		<style>section{visibility:hidden;}
			
.line-number {
	color: #aaa;
	margin-right: 10px;
}
			
		</style>
	</div>
</div>
<?php
require_once(__DIR__."/footer.php");