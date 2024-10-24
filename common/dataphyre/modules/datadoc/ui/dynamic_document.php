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

$db_projects = dataphyre\datadoc::projects_table();
$stmt = $db_projects->prepare("SELECT * FROM projects WHERE name=:project");
$stmt->bindValue(':project', $_PARAM['project']);
$results_projects = $stmt->execute();
$project = $results_projects->fetchArray(SQLITE3_ASSOC);

// Initialize database and query
$db_data = dataphyre\datadoc::data_table();
$query_data = "SELECT * FROM data WHERE project='{$project['name']}'";
$params = [];

// Process GET parameters and modify SQL query accordingly
if (!empty($_GET['namespace'])) {
    $params[] = "namespace LIKE  '" . SQLite3::escapeString($_GET['namespace']) . "'";
}
if (!empty($_GET['class'])) {
    $params[] = "class LIKE  '" . SQLite3::escapeString($_GET['class']) . "'";
}
if (!empty($_GET['type'])) {
    $params[] = "type LIKE  '" . SQLite3::escapeString($_GET['type']) . "'";
}
if (!empty($_GET['function'])) {
    $params[] = "function LIKE  '" . SQLite3::escapeString($_GET['function']) . "'";
}
if (!empty($_GET['content'])) {
    $params[] = "content LIKE  '" . SQLite3::escapeString($_GET['content']) . "'";
}
if (count($params) > 0) {
    $query_data .= " AND " . implode(" AND ", $params);
}
$results_data = $db_data->query($query_data);
$dynadoc_record = $results_data->fetchArray(SQLITE3_ASSOC);
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
			
			<?php
			$content_first_line=strtok($dynadoc_record['content'], "\n");
			
			$dynadoc_record['phpdoc_tags']=json_decode($dynadoc_record['phpdoc_tags'],true);
			
			$version_string = '';
			if (!empty($dynadoc_record['phpdoc_tags']['version'])) {
				$version_string = '  <span class="badge bg-secondary" style="color:white">'.$dynadoc_record['phpdoc_tags']['version']."</span>";
			}

			$is_static = false;
			if (str_contains($content_first_line, 'static') === true) {
				$is_static = true;
			}
			$access_level = 'public'; // default to public
			if (str_contains($content_first_line, 'protected') === true) {
				$access_level = 'protected';
			} elseif (str_contains($content_first_line, 'private') === true) {
				$access_level = 'private';
			}
			$sync_button='<a href="'.dataphyre\core::url_self_updated_querystring(array('sync_file'=>base64_encode($dynadoc_record['file']))).'" title="Last sync: '.date('Y-m-d H:i:s', $dynadoc_record['time']).'"><i class="fas fa-sync"></i></a>';
			$static_pill = $is_static ? '<span class="badge bg-info" style="color:white">static</span> ' : '';
			$access_pill = "<span class='badge bg-success' style='color:white'>$access_level</span> ";
			switch ($dynadoc_record['type']) {
				case 'namespace':
					echo "<h2><span class='badge bg-primary' style='color:white'>namespace</span> \\{$dynadoc_record['namespace']} {$sync_button}</h2>";
					break;
				case 'class':
					if (!empty($dynadoc_record['namespace'])){
						echo "<h2><span class='badge bg-primary' style='color:white'>Class</span> \\" . $dynadoc_record['namespace'] . "\\" . $dynadoc_record['class'] . " {$sync_button}</h2>";
					}
					else
					{
						echo "<h2><span class='badge bg-primary' style='color:white'>Class</span> \\" . $dynadoc_record['class'] . " {$sync_button}</h2>";
					}
					break;
				case 'function':
					$separator = ($is_static && !empty($dynadoc_record['class'])) ? '::' : '';
					$namespacePart = !empty($dynadoc_record['namespace']) ? "\\{$dynadoc_record['namespace']}" : '';
					$classPart = !empty($dynadoc_record['class']) ? "\\{$dynadoc_record['class']}" : '';
					$functionPart = $dynadoc_record['function'];
					$namespaceClassConnector = (!empty($namespacePart) && !empty($classPart)) ? '\\' : '';
					$func_display = "{$namespacePart}{$namespaceClassConnector}{$classPart}{$separator}{$functionPart}";
					echo "<h2>{$access_pill}{$static_pill} "
					   . "<span class='badge bg-primary' style='color:white'>function</span> "
					   . "{$func_display}() {$version_string} {$sync_button}</h2>";
					break;
				case 'variable':
					echo "<h2><b><span class='badge bg-primary' style='color:white'>variable</span> \${$dynadoc_record['content']} {$sync_button}</h2>";
					$dynadoc_record['content']='$'.$dynadoc_record['content'].';'; // Lil hack
					break;
				default:
					// Handle other types if necessary
					break;
			}
			
			if(!empty($dynadoc_record['file'])){
				if(!empty($dynadoc_record['line'])){
					echo'<h5 class="mt-1"><b>File:</b> '.$dynadoc_record['file'].'</h5>';
				}
			}
			
			if(!empty($dynadoc_record['phpdoc_tags']['author'])){
				echo'<h5 class="mt-1"><b>Author:</b> '.$dynadoc_record['phpdoc_tags']['author'].'</h5>';
			}
			
			if(!empty($dynadoc_record['phpdoc_tags']['package'])){
				if(!empty($dynadoc_record['phpdoc_tags']['subpackage'])){
					echo'<h5><b>Package</b> '.trim($dynadoc_record['phpdoc_tags']['package']).', '.$dynadoc_record['phpdoc_tags']['subpackage'].'</h5>';
				}
				else
				{
					echo'<h5><b>Package</b> '.trim($dynadoc_record['phpdoc_tags']['package']).'</h5>';
				}
			}
			
			if(!empty($dynadoc_record['line'])){
				echo'<h5 class="mt-1"><b>Line: </b>'.$dynadoc_record['line'].'</h5>';
			}
			
			if(!empty($dynadoc_record['phpdoc_description'])){
				echo'<div class="mt-3">';
				echo'<h3><b>Description</b></h3>';
				echo'<div class="card p-2">';
				echo '<h4>'.nl2br($dynadoc_record['phpdoc_description']).'</h4>';
				echo'</div>';
				echo'</div>';
			}
			
			if(!empty($dynadoc_record['phpdoc_tags']['example'])){
				echo'<div class="row mt-3">';
				echo'<div class="col-12">';
				echo'<h3><b>Example(s)</b></h3>';
				$code=dataphyre\datadoc\highlighter::highlight_code($dynadoc_record['phpdoc_tags']['example'], "php", []);
				echo dataphyre\datadoc\highlighter::linkify_php($code, $dynadoc_record['project'], $dynadoc_record['namespace'], $dynadoc_record['class'], $dynadoc_record['function']);
				echo'</div>';
				echo'</div>';
			}
			
			if(!empty($dynadoc_record['phpdoc_tags']['warning'])){
				echo'<div class="mt-3">';
				echo'<h3><b>Warning(s)</b></h3>';
				echo'<div class="card p-2">';
				echo '<h4>'.nl2br(trim($dynadoc_record['phpdoc_tags']['warning'])).'</h4>';
				echo'</div>';
				echo'</div>';
			}
			
			if(!empty($dynadoc_record['content'])){
				echo '<div class="row mt-3">';
				echo '<div class="col-12">';
				echo '<h3><b>Source</b></h3>';
				$code=dataphyre\datadoc\highlighter::highlight_code($dynadoc_record['content'], "php", ['show_lines'=>true, 'start_line'=>$dynadoc_record['line']]);
				echo dataphyre\datadoc\highlighter::linkify_php($code, $dynadoc_record['project'], $dynadoc_record['namespace'], $dynadoc_record['class'], $dynadoc_record['function']);
				echo '</div>';
				echo '</div>';
			}
		?>
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