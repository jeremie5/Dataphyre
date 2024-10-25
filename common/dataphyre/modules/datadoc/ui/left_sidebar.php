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

ini_set('memory_limit', '512M');

?>
<style>
.breadcrumb {
	margin: 0;
	background: transparent;
}
.search-container {
	width: 15%;
	border: 1px solid #d5d5d5;
	border-radius: 0.2rem;
	overflow: hidden
}
.search-container input {
	border: none;
	padding: 5px 5px 5px 10px;
	outline: none;
}
.search-container i {
	top: 50%;
	right: 0;
	transform: translateY(-50%);
	color: white;
	background: #343a40;
	width: 35px;
	cursor: pointer;
}
.row.main-row {
	border-top: 1px solid #eef1f2;
	margin: 0;
}
.panel-group {
	border-right: 1px solid #eef1f2;
}
.panel-heading {
	padding: 0;
	border: 0;
}
.panel-heading a,
.panel-body a {
	display: inherit;
	transition: .1s ease;
	padding: 0.5rem 1.25rem;
}
.panel-heading a {
	font-weight: bold;
}
.panel-heading a:hover,
.panel-body a:hover {
	background: rgba(0, 0, 0, 0.067);
	border-radius: 0.2rem;
}
.panel-heading a i {
	font-size: 12px;
	transition: .2s ease;
}
.panel-heading.active a i {
	transform: rotate(90deg);
	vertical-align: middle;
}
.row.main-row .position-sticky {
	top: 0;
}
.col.right-col div a {
	display: inherit;
	padding: 5px 10px;
	transition: .1s ease;
	width: max-content;
}
code {
	color: #c3c3c3!important;
}
.code-highlight {
	display: block;
	overflow-x: auto;
	padding: 1.25rem;
	color: #abb2bf;
	background: #282c34;
	border-radius: 3px;
	font-size: 12px!important;
}
.code-highlight span.string {
	color: #98c379;
}
.code-highlight span.keyword {
	color: #c678dd;
}
.col.right-col div a:hover {
	background: rgba(0, 0, 0, 0.05);
}
.header-menu {
	display: none;
	position: relative;
}
.header-menu input {
	display: block;
	width: 40px;
	height: 32px;
	position: absolute;
	top: -7px;
	left: -5px;
	cursor: pointer;
	opacity: 0;
	z-index: 2;
	-webkit-touch-callout: none;
}
.header-menu span {
	display: block;
	width: 33px;
	height: 4px;
	margin-bottom: 5px;
	position: relative;
	background: #343a40;
	border-radius: 3px;
	z-index: 1;
	transform-origin: 4px 0px;
	transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1.0), background 0.5s cubic-bezier(0.77, 0.2, 0.05, 1.0), opacity 0.55s ease;
}
.header-menu:hover span {
	background: #343a40;
}
.header-menu span:first-child {
	transform-origin: 0% 0%;
}
.header-menu span:nth-last-child(2) {
	transform-origin: 0% 100%;
}
.header-menu input:checked~span {
	opacity: 1;
	transform: rotate(45deg) translate(-8px, -15px);
}
.header-menu input:checked~span:nth-last-child(2) {
	transform: rotate(-45deg) translate(-4px, 13px);
}
.header-menu input:checked~span:nth-last-child(3) {
	opacity: 0;
	transform: rotate(0deg) scale(0.2, 0.2);
}
@media(max-width:992px) {
	.wrapper {
		width: 100%;
	}
}
@media only screen and (max-width: 768px) {
	.navigation-col {
		position: fixed;
		left: 0;
		height: 100vh;
		background: white;
		width: 260px;
		padding: 40px;
		transform-origin: 0% 0%;
		transform: translate(-100%, 0);
		transition: transform 0.5s cubic-bezier(0.77, 0.2, 0.05, 1.0);
		z-index: 9;
	}
	.navigation-col.active {
		transform: none;
	}
	.navigation-col .panel-group {
		border: none;
	}
	.header-menu {
		display: initial;
	}
	.row.main-row .right-col,
	.search-container {
		display: none;
	}
}
</style>

<div class="panel panel-default" id="mainAccordion">
    <div class="panel-body">
        <?php
        $db_projects=dataphyre\datadoc::projects_table();
        $query_projects="SELECT * FROM projects";
        $results_projects=$db_projects->query($query_projects);
        while($project=$results_projects->fetchArray(SQLITE3_ASSOC)){
            $panel_heading_active="";
            $aria_expanded="false";
            $show="";
			if($_PARAM['project']===$project['name']){
				$panel_heading_active="show";
				$aria_expanded="true";
				$show='show';
			}
            ?>
            <div class="panel-heading <?=$panel_heading_active;?>" role="tab" id="heading_dynadoc<?php echo $project['id']; ?>">
                <a class="collapsed" style="color:black;" role="button" data-toggle="collapse" data-parent="#mainAccordion" href="#collapse_dynadoc<?php echo $project['id']; ?>" aria-expanded="<?=$aria_expanded;?>" aria-controls="collapse_dynadoc<?php echo $project['id']; ?>">
                    <?php echo $project['title']; ?>
                </a>
            </div>
            <div id="collapse_dynadoc<?php echo $project['id']; ?>" class="panel-collapse collapse <?=$show;?>" role="tabpanel" aria-labelledby="heading_dynadoc<?php echo $project['id']; ?>">
                <div class="panel-body pl-3">
                    <!-- Nested: Data Table -->
                    <div class="accordion" id="dataAccordion_dynadoc<?php echo $project['id']; ?>">
						<a href="<?=dataphyre\core::url_self()?>dataphyre/datadoc/<?=$project['name']?>" style="color:black;"><i class="far fa-tachometer"></i> Project dashboard</a>
						<a href="<?=dataphyre\core::url_self()?>dataphyre/datadoc/<?=$project['name']?>/settings" style="color:black;"><i class="far fa-cogs"></i> Project settings</a>
						<?php
						
						
$sorted_data = [];
$manual_docs_children = [
    ['type' => 'static', 'content' => '<a href="'.dataphyre\core::url_self().'dataphyre/datadoc/'.$GLOBALS['project']['name'].'/manudoc/manage_categories" style="color:black;"><i class="far fa-money-check-edit"></i> Manage categories</a>'],
    ['type' => 'static', 'content' => '<a href="'.dataphyre\core::url_self().'dataphyre/datadoc/'.$GLOBALS['project']['name'].'/manudoc/manage_documents" style="color:black;"><i class="far fa-file-edit"></i> Manage documents</a>']
];
$sorted_data[] = ['type' => 'category', 'content' => '<b><i class="far fa-book"></i> Manual documentation</b>', 'children' => $manual_docs_children];
$db_categories = dataphyre\datadoc::document_categories_table();
$query_categories = "SELECT * FROM document_categories WHERE project='{$GLOBALS['project']['name']}' ORDER BY name";
$results_categories = $db_categories->query($query_categories);
while ($category = $results_categories->fetchArray(SQLITE3_ASSOC)) {
    $sorted_data[] = ['type' => 'category', 'content' => $category['name'], 'children' => []];
}
$db_documents = dataphyre\datadoc::documents_table();
$query_documents = "SELECT * FROM documents WHERE project='{$GLOBALS['project']['name']}' ORDER BY path";
$results_documents = $db_documents->query($query_documents);
while ($document = $results_documents->fetchArray(SQLITE3_ASSOC)) {
    foreach ($sorted_data as &$item) {
        if ($item['type'] === 'category' && $item['content'] === $document['path']) {
            $item['children'][] = ['type' => 'document', 'content' => $document];
            break;
        }
    }
}
echo '<div class="main-menu">';
dataphyre\datadoc::manudoc_output_nested_structure($sorted_data);
echo '</div>';

$sorted_data=[];
$db_data=dataphyre\datadoc::data_table();
$query_data="SELECT * FROM data WHERE project='{$project['name']}' ORDER BY namespace, class, function, type";
$results_data=$db_data->query($query_data);
// Sort data into a nested array
while($record=$results_data->fetchArray(SQLITE3_ASSOC)){
	if(in_array($record['type'], ['tracelog', 'sql_select', 'sql_delete', 'sql_update', 'sql_insert', 'sql_count'])){
		continue;
	}
	$path=[];
	$path[]='<b><i class="far fa-robot"></i> Dynamic code documentation</b>';
	if(!empty($record['namespace'])){
		$path[]='<b><i class="fas fa-folder-tree"></i> <i>Namespace(s)</i></b>';
		$namespace_exploded=explode('\\', $record['namespace']);
		foreach($namespace_exploded as $key=>$namespace){
			$path[]='<b><i class="far fa-box"></i> '.$namespace.'</b>';
		}
	}
	if(!empty($record['class'])){
		$path[]='<b><i class="fas fa-folder-tree"></i> <i>Class(es)</i></b>';
		$path[]='<b><i class="far fa-folder"></i> '.$record['class'].'</b>';
	}
	if(!empty($record['function'])){
		$path[]='<b><i class="fas fa-folder-tree"></i> <i>Function(s)</i></b>';
		$path[]='<b><i class="far fa-function"></i> '.$record['function'].'()</b>';
	}
	if($record['type']==='variable'){
		$path[]='<b>$ <i>Variable(s)</i></b>';
	}
    if(!empty($path)) {
        dataphyre\datadoc::dynadoc_insert_data($sorted_data, $path, $record);
    }
}
echo "<div class='main-menu'>";
dataphyre\datadoc::dynadoc_output_nested_structure($project, $sorted_data);
echo "</div>";

						?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
$('.panel-collapse').on('show.bs.collapse', function() {
	$(this).siblings('.panel-heading').addClass('active');
});
$('.panel-collapse').on('hide.bs.collapse', function(e) {
	e.target.previousElementSibling.classList.remove('active');
});
const headerNav = document.querySelector(".navigation-col");
const menuBtn = document.querySelector(".header-menu");
menuBtn.addEventListener("click", function() {
	headerNav.className = this.children[0].checked ? "col navigation-col active bg-secondary" : "col navigation-col bg-secondary";
})
window.onscroll = function() {
	if (headerNav.classList.contains("active")) {
		headerNav.classList.remove("active");
		menuBtn.children[0].checked = false
	}
};
</script>