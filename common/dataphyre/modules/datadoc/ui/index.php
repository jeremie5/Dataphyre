<?php
 /*************************************************************************
 *  2020-2024 Shopiro Ltd.
 *  All Rights Reserved.
 * 
 * NOTICE: All information contained herein is, and remains the 
 * property of Shopiro Ltd. and is provided under a dual licensing model.
 * 
 * This software is available for personal use under the Free Personal Use License.
 * For commercial applications that generate revenue, a Commercial License must be 
 * obtained. See the LICENSE file for details.
 *
 * This software is provided "as is", without any warranty of any kind.
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