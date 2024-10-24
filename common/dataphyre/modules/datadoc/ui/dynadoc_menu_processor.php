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

if(dataphyre\datadoc::logged_in()===true){

	$db_projects = dataphyre\datadoc::projects_table();
	$stmt = $db_projects->prepare("SELECT * FROM projects WHERE name=:project");
	$stmt->bindValue(':project', $_GET['project']);
	$results_projects = $stmt->execute();
	$project = $results_projects->fetchArray(SQLITE3_ASSOC);
	$path = isset($_GET['path']) ? $_GET['path'] : '';

	$path=str_replace(' Dynamic code documentation', '', $path);
	$path=str_replace(' Namespace(s)', '', $path);
	$path=str_replace(' Class(es)', '', $path);
	$path=str_replace(' <i>Function(s)', '', $path);
	$path=str_replace('//', '/', $path);
	$path=str_replace('//', '/', $path);
	$path=str_replace('//', '/', $path);

	$elements = explode('/', $path);
	if (count($elements) >= 1) {
		$type = array_pop($elements);
	}
	if (count($elements) >= 1) {
		$function = array_pop($elements);
	}
	if (count($elements) >= 1) {
		$class = array_pop($elements);
	}
	$namespace = implode('/', $elements); 

	$db_data=dataphyre\datadoc::data_table();
	$query_data = "SELECT * FROM data WHERE project='{$project['name']}'";
	if (!empty($namespace)) {
		$query_data .= " AND namespace='{$namespace}'";
	}
	if (!empty($class)) {
		$query_data .= " AND class='{$class}'";
	}
	if (!empty($type)) {
		$query_data .= " AND type='{$type}'";
	}
	if (!empty($function)) {
		$query_data .= " AND function='{$function}'";
	}
	$query_data .= " ORDER BY namespace, class, function, type";

	$results_data = $db_data->query($query_data);
	$sorted_data = [];
	while ($record = $results_data->fetchArray(SQLITE3_ASSOC)) {
		if(in_array($record['type'], ['tracelog', 'sql_select', 'sql_delete', 'sql_update', 'sql_insert', 'sql_count'])){
			continue;
		}
		$path=[];
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
		dataphyre\datadoc::dynadoc_insert_data($sorted_data, $path, $record);
	}
	echo "<div class='main-menu'>";
	dataphyre\datadoc::dynadoc_output_nested_structure($project, $sorted_data, 0, $path);
	echo "</div>";
	exit();
}