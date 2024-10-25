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

if(isset($_PARAM['documentid'])){
	$documentid=$_PARAM['documentid'];
}
else
{
	$documentid=1;
}

if(false===$document_data=sql_select($S="*", $L="developer_documents", $P="WHERE documentid=?", $V=array($documentid), $F=false, $C=false)){
	$documentid=0;
	$document_data=sql_select($S="*", $L="developer_documents", $P="WHERE documentid=?", $V=array(0), $F=false, $C=false);
}
$document_url_title=substr(str_replace(array(' ', '?', "'", '"'), array('-','','',''), $document_data['titles']), 0, 64);

$document_data['contents']=$document_data['contents'];

$exploded=[]; 
preg_match_all('/<section id=(.*?)<\/section>/s', $document_data['contents'], $exploded);
foreach($exploded as $exploded){
	foreach($exploded as $section){
		if(str_contains($section, '>')){
			$exploded2=explode('>', $section);
			$section_id=str_replace(array("'",'"', '<section id=','</section>'), '', $exploded2[0]);
			$section_name=$exploded2[1];
			$sections[$section_id]=$section_name;
		}
	}
}
?>
<script>document.title="<?=dataphyre\core::ellipsis($document_data['titles'], 20);?> - <?=$platform_name;?>";</script>
<div class="<?=adapt(["dark"=>"bg-secondary"]);?>">
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
			<style>section{visibility:hidden;}</style>
			<?=$document_data['titles'];?></h1>
			
			<?php
			echo $document_data['contents'];
			?>
			<!--<code class="code-highlight"><p><code>$client = <span class="keyword">new</span> Class(<span class="string">"123"</span>, <span class="string">"abc"</span>, <span class="string">"a1b"</span>);</code></p></code>-->
		</div>
		<div class="col-md right-col">
			<div class="position-sticky">
				<?php if(!empty($sections)){ ?>
				<h5 class="py-3 <?=adapt(["dark"=>"text-white"]);?>">On this page</h5>
				<div class="ml-2 pb-3">
					<?php
						foreach($sections as $id=>$name){
							echo'<a href="javascript:void(0);" onclick="$(\'html, body\').animate({scrollTop: $(\'#'.$id.'\').offset().top}, 500);" class="'.adapt(["light"=>"text-body","dark"=>"text-white"]).'">'.$name.'</a><br>';
						}
					?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php
require_once(__DIR__."/footer.php");