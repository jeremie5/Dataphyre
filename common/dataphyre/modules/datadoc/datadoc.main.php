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


namespace dataphyre;

dp_module_required('datadoc', 'sql');

if(file_exists($filepath=$rootpath['common_dataphyre']."config/datadoc.php")){
	require_once($filepath);
}
if(file_exists($filepath=$rootpath['dataphyre']."config/datadoc.php")){
	require_once($filepath);
}

require(__DIR__."/tokenizer.php");
require(__DIR__."/highlighter.php");

/*
if(isset($_GET['test'])){
	if($_GET['test']===''){
		
		set_time_limit(0);
		ini_set('max_execution_time', 0);
			
		datadoc::create_project("shopiro", "Shopiro", "/var/www/shopicore/applications/shopiro/");
		datadoc::add_files_to_project("/var/www/shopicore/applications/shopiro/", "shopiro");
		datadoc::add_files_to_project("/var/www/shopicore/common/backend/functions/", "shopiro");
		datadoc::sync_all_files("shopiro");

	}
}
*/

class datadoc{
	
	static $files_db;
	static $data_db;
	static $documents_db;
	static $projects_db;
	static $document_categories_db;

	public static function logged_in(){
		if($_SESSION['dp_datadoc_logged_in']){
			return true;
		}
		return false;
	}
	
	public static function login($password){
		sleep(2);
		if($_SESSION['dp_datadoc_attempts']>2)return false;
		if($password===config("dataphyre/datadoc/password")){
			$_SESSION['dp_datadoc_logged_in']=true;
			echo'Good password';
			return true;
		}
		$_SESSION['dp_datadoc_attempts']++;
		echo'Bad password';
		return false;
	}
	
	public static function dynadoc_output_record($project, $record){
		$data_id=rand(0,999999999999999999);
		$url_base=core::url_self()."dataphyre/datadoc/".$project['name']."/dynadoc";
		$content='';
		if($record['type']==='variable'){
			$url = $url_base . "?namespace=" . $record['namespace'] . "&class=" . $record['class'] . "&type=variable&content=" . $record['content'];
			$content.='<a style="color:black" href="' . $url . '">$'.$record['content'].'</a>';
		}
		elseif($record['type']==='function'){
			$url = $url_base . "?namespace=" . $record['namespace'] . "&class=" . $record['class'] . "&type=function&function=" . $record['function'];
			$content.='<a style="color:black" href="' . $url . '"><i class="fas fa-align-left"></i> '.$record['function'].'()</a>';
		}
		elseif($record['type']==='namespace'){
			$url = $url_base . "?namespace=" . $record['namespace']."&type=namespace";
			$content.='<a style="color:black" href="' . $url . '"><i class="fas fa-align-left"></i> '.$record['namespace'].'</a>';
		}
		elseif($record['type']==='class'){
			$url = $url_base . "?namespace=" . $record['namespace'] . "&class=" . $record['class']."&type=class";
			$content.='<a style="color:black" href="' . $url . '"><i class="fas fa-align-left"></i>'.$record['class'].'</a>';
		}
		else
		{
			$content.=$record['content'];
		}
		return $content;
	}

	public static function dynadoc_output_nested_structure($project, $data, $indentation=0, $currentPath = []){
		global $dynadoc_record;
		$namespace = $_GET['namespace'] ?? '';
		$class = $_GET['class'] ?? '';
		$type = $_GET['type'] ?? '';
		$function = $_GET['function'] ?? '';
		foreach($data as $key => $value){
			$new_id = rand(0,999999999999999999);
			$shouldExpand = 'false';
			$collapseClass = '';
			// Generate the current path for this iteration
			$newCurrentPath = array_merge($currentPath, [$key]);
			$joinedPath = implode('/', $newCurrentPath);
			if(is_array($value)){
				// Check if the current path matches the path in the URL parameters
				$matching = false;
				if ($joinedPath === "$namespace/$class/$type/$function") {
					$matching = true;
				}
				if ($indentation === 0 && isset($dynadoc_record)) {
					$matching = true;
				}
				if($matching){
					$shouldExpand = 'true';
					$collapseClass = 'show';
				}
				if(isset($value['id'])){
					echo "<div class='menu-item'>";
					echo self::dynadoc_output_record($project, $value);
					echo "</div>";
				}
				else
				{
					if(!empty($key)){
						echo "<div class='menu-item' style='padding-left: ".($indentation*8)."px;'>";
						echo "<a class='collapsed' role='button' data-toggle='collapse' href='#collapseData{$new_id}' aria-expanded='{$shouldExpand}'>";
						echo "<span style='color:black'>".$key."</span>";
						echo "</a>";
						echo "<div id='collapseData{$new_id}' class='panel-collapse collapse {$collapseClass}' role='tabpanel'>";
						self::dynadoc_output_nested_structure($project, $value, $indentation+1, $newCurrentPath);
						echo "</div></div>";
					}
				}
			}
		}
	}
	
	public static function dynadoc_insert_data(&$arr, $path, $value){
		$temp = &$arr;
		foreach($path as $segment){
			if(!isset($temp[$segment])){
				$temp[$segment] = [];
			}
			$temp = &$temp[$segment];
		}
		$temp[] = $value;
	}
	
	public static function manudoc_output_record($record){
		$data_id = rand(0, 999999999999999999);
		echo '<div class="panel panel-default">';
		echo '<div class="panel-heading" id="headingData'.$data_id.'">';
		echo '<a class="collapsed" role="button" data-toggle="collapse" href="#collapseData'.$data_id.'" aria-expanded="false" aria-controls="collapseData'.$data_id.'">';
		echo '<span style="color:black; font-weight:normal;">';
		echo $record['titles'];
		echo '</span>';
		echo '</a>';
		echo '</div>';
		echo '<div class="panel-body">';
		echo '<a href="'.dataphyre\core::url_self().'dataphyre/datadoc/'.$GLOBALS['project']['name'].'/manudoc/'.$record['id'].'">View Document</a>';
		echo '</div>';
		echo '</div>';
	}

public static function manudoc_output_nested_structure($data, $indentation=0){
    foreach($data as $item){
        $padding = $indentation * 8;
        if ($item['type'] === 'static') {
            echo '<div class="menu-item" style="padding-left: '.$padding.'px;">';
            echo $item['content'];
            echo '</div>';
        } elseif ($item['type'] === 'category') {
            $new_id = rand(0, 999999999999999999);  // Adding a random id
            echo '<div class="menu-item" style="padding-left: '.$padding.'px;">';
            echo '<a class="collapsed" role="button" data-toggle="collapse" href="#collapse'.$new_id.'" aria-expanded="false">';
            echo '<span style="color:black;">'.$item['content'].'</span>';
            echo '</a>';
            echo '<div id="collapse'.$new_id.'" class="panel-collapse collapse" role="tabpanel">';
            self::manudoc_output_nested_structure($item['children'], $indentation + 1);
            echo '</div>';
            echo '</div>';
        } elseif ($item['type'] === 'document') {
            echo '<div class="menu-item" style="padding-left: '.$padding.'px;">';
            self::manudoc_output_record($item['content']);
            echo '</div>';
        }
    }
}
	
	public static function url_self($full=false){
		if(function_exists("tracelog")){
			tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T=null, $S="function_call", $A=func_get_args()); // Log the function call
		}
		if(null!==$early_return=core::dialback("CALL_CORE_URL_SELF",...func_get_args())) return $early_return;
		$protocol=isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? $_SERVER['HTTP_X_FORWARDED_PROTO'] : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on' ? 'https' : 'http');
		//return $protocol.'://'.$_SERVER['HTTP_HOST'].($full ? htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8') : '/');
		return $protocol.'://'.$_SERVER['HTTP_HOST'].($full ? $_SERVER['REQUEST_URI'] : '/');
	}
	
	public static function url_updated_querystring(string $url, array|null $value=null, array|null|bool $remove=false) : string{
		return core::url_updated_querystring($url, $value, $remove);
	}	
	
	public static function url_self_updated_querystring(array|null $value=null, array|null|bool $remove=false) : string{
		return core::url_self_updated_querystring($value, $remove);
	}
	
	public static function document_categories_table(){
		if (is_object(datadoc::$document_categories_db)) return datadoc::$document_categories_db;
		$document_categories_db = __DIR__ . "/doc/document_categories.db";
		if (!file_exists($document_categories_db)) {
			core::file_put_contents_forced($document_categories_db, '');
		}
		$db = new \SQLite3($document_categories_db);
		if ($db) {
			$result = $db->exec('CREATE TABLE IF NOT EXISTS document_categories (categoryid INTEGER PRIMARY KEY AUTOINCREMENT, project TEXT, titles TEXT, name TEXT, parent TEXT)');
			if (!$result) {
				return false;
			}
			return datadoc::$document_categories_db = $db;
		}
		return false;
	}
	
	public static function documents_table(){
		if (is_object(datadoc::$documents_db)) return datadoc::$documents_db;
		$documents_db = __DIR__ . "/doc/documents.db";
		if (!file_exists($documents_db)) {
			core::file_put_contents_forced($documents_db, '');
		}
		$db = new \SQLite3($documents_db);
		if ($db) {
			$result = $db->exec('CREATE TABLE IF NOT EXISTS documents (documentid INTEGER PRIMARY KEY AUTOINCREMENT, project TEXT, type TEXT, path TEXT, titles TEXT, contents TEXT, display_in_menus INTEGER, last_edit TEXT, searchable INTEGER)');
			if (!$result) {
				return false;
			}
			return datadoc::$documents_db = $db;
		}
		return false;
	}
	
	public static function projects_table(){
		if (is_object(datadoc::$projects_db)) return datadoc::$projects_db;
		$projects_db = __DIR__ . "/doc/projects.db";
		if (!file_exists($projects_db)) {
			core::file_put_contents_forced($projects_db, '');
		}
		$db = new \SQLite3($projects_db);
		if ($db) {
			$result = $db->exec('CREATE TABLE IF NOT EXISTS projects (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT UNIQUE, title TEXT, path TEXT)');
			if (!$result) {
				return false;
			}
			return datadoc::$projects_db = $db;
		}
		return false;
	}
	
	public static function data_table(){
		if (is_object(datadoc::$data_db)) return datadoc::$data_db;
		$data_db = __DIR__ . "/doc/data.db";
		if (!file_exists($data_db)) {
			core::file_put_contents_forced($data_db, '');
		}
		$db = new \SQLite3($data_db);
		if ($db) {
			$result = $db->exec('CREATE TABLE IF NOT EXISTS data (id INTEGER PRIMARY KEY AUTOINCREMENT, time INTEGER, checksum TEXT UNIQUE, type TEXT, content TEXT, file TEXT, project TEXT, function TEXT, namespace TEXT, class TEXT, line INTEGER, phpdoc_description TEXT, phpdoc_tags TEXT)');
			if (!$result) {
				return false;
			}
			return datadoc::$data_db = $db;
		}
		return false;
	}

	public static function files_table(){
		if (is_object(datadoc::$files_db)) return datadoc::$files_db;
		$files_db = __DIR__ . "/doc/files.db";
		if (!file_exists($files_db)) {
			core::file_put_contents_forced($files_db, '');
		}
		$db = new \SQLite3($files_db);
		if ($db) {
			$result = $db->exec('CREATE TABLE IF NOT EXISTS files (id INTEGER PRIMARY KEY AUTOINCREMENT, filepath TEXT UNIQUE, checksum TEXT, project TEXT, last_synced TIMESTAMP, is_stale INTEGER)');
			if (!$result) {
				return false;
			}
			return datadoc::$files_db = $db;
		}
		return false;
	}
	
	public static function create_project(string $name='', string $title='', string $path=''){
		tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T=null, $S='function_call', $A=func_get_args()); // Log the function call
		if(!$projects_db=datadoc::projects_table()){
			return false;
		}
		// Insert the new record into the SQLite database
		$insert_stmt = $projects_db->prepare("INSERT OR REPLACE INTO projects (name, title, path) VALUES (:name, :title, :path)");
		$insert_stmt->bindValue(':name', $name);
		$insert_stmt->bindValue(':title', $title);
		$insert_stmt->bindValue(':path', $path);
		$insert_stmt->execute();
		return true;
	}
	
	public static function reference_functions($content, $current_project, $current_class){
		tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T=null, $S='function_call', $A=func_get_args()); // Log the function call
		if(!$data_db=datadoc::data_table()){
			return false;
		}
		// Define a generic regex pattern to match namespaces, classes, functions, and variables
		$pattern = '/\b([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*|\$\w+)\b/';
		// Check for matches in content
		preg_match_all($pattern, $content, $matches);
		foreach($matches[0] as $detected_entity){
			$stmt = $data_db->prepare("SELECT * FROM data WHERE (class=:class OR function=:function OR namespace=:namespace) AND project=:project");
			$stmt->bindValue(':class', $current_class);
			$stmt->bindValue(':function', $detected_entity);
			$stmt->bindValue(':namespace', $detected_entity);
			$stmt->bindValue(':project', $current_project);
			$result = $stmt->execute();
			while($row = $result->fetchArray(SQLITE3_ASSOC)){
				$reference_type = $row['type'];  // Assuming 'type' can be 'class', 'function', 'namespace', etc.
				$url = core::url_self() . 'dataphyre/datadoc/' . $current_project . '/' . $reference_type . '/' . $detected_entity;
				$content = str_replace($detected_entity, "<a href=\"$url\">$detected_entity</a>", $content);
			}
		}
		return $content;
	}
	
	public static function add_files_to_project(string $dirpath, string $project=''){
		tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T=null, $S='function_call', $A=func_get_args()); // Log the function call
		if(!$file_db = datadoc::files_table()){
			return false;
		}
		$dirpath = str_replace('//', '/', $dirpath);
		// Check if directory exists
		if(is_dir($dirpath)){
			$files = scandir($dirpath);
			foreach($files as $file) {
				$filepath = $dirpath . '/' . $file;
				// Skip '.' and '..' directories
				if($file == "." || $file == "..") {
					continue;
				}
				// If it's a directory, recurse into it
				if(is_dir($filepath)) {
					self::add_files_to_project($filepath, $project);
				}
				else
				{
					self::add_file_to_project($filepath, $project);
				}
			}
			return true;
		}
		return false;
	}

	public static function add_file_to_project(string $filepath, string $project=''){
		tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T=null, $S='function_call', $A=func_get_args()); // Log the function call
		if(!$file_db=datadoc::files_table()){
			return false;
		}
		$filepath = str_replace('//', '/', $filepath);
		// Check if file exists
		if(file_exists($filepath) && str_ends_with($filepath, '.php')){
			// Calculate initial checksum
			$file_content = file_get_contents($filepath);
			$current_checksum = md5($file_content);
			// Insert the new file record into the SQLite database
			$insert_stmt = $file_db->prepare("INSERT INTO files (filepath, checksum, project, last_synced) VALUES (:filepath, :checksum, :project, datetime('now'))");
			$insert_stmt->bindValue(':filepath', $filepath);
			$insert_stmt->bindValue(':checksum', $current_checksum);
			$insert_stmt->bindValue(':project', $project);
			$insert_stmt->execute();
			datadoc::sync_file($filepath, $project);
			return true;
		}
		return false;
	}

	public static function delete_file(string $filepath, string $project=''){
		tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T=null, $S='function_call', $A=func_get_args()); // Log the function call
		if(!$file_db=datadoc::files_table()){
			return false;
		}
		if(!$data_db=datadoc::data_table()){
			return false;
		}
		$filepath=rtrim($filepath, '/').'/';
		$like_filepath=$filepath . '%';
		$delete_stmt = $file_db->prepare("DELETE FROM files WHERE filepath LIKE :filepath AND project=:project");
		$delete_stmt->bindValue(':filepath', $like_filepath);
		$delete_stmt->bindValue(':project', $project);
		$delete_stmt->execute();
		$delete_data_stmt = $data_db->prepare("DELETE FROM data WHERE file LIKE :filepath AND project=:project");
		$delete_data_stmt->bindValue(':filepath', $like_filepath);
		$delete_data_stmt->bindValue(':project', $project);
		$delete_data_stmt->execute();
	}

	public static function get_stale_files(string $project=''){
		tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T=null, $S='function_call', $A=func_get_args()); // Log the function call
		if(!$data_db=datadoc::data_table()){
			return false;
		}
		// Initialize an empty array to hold the stale files
		$stale_files = [];
		// Query the database for files marked as stale
		$stale_stmt = $file_db->prepare('SELECT filepath FROM files WHERE project=:project AND is_stale=1');
		$stale_stmt->bindValue(':project', $project);
		$stale_result = $stale_stmt->execute();
		while ($row = $stale_result->fetchArray(SQLITE3_ASSOC)) {
			$stale_files[] = $row['filepath'];
		}
		return $stale_files;
	}

	public static function sync_all_files(string $project=''){
		tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T=null, $S='function_call', $A=func_get_args()); // Log the function call
		if(!$file_db=datadoc::files_table()){
			return false;
		}
		// Retrieve list of files
		$file_stmt = $file_db->prepare('SELECT * FROM files WHERE project=:project');
		$file_stmt->bindValue(':project', $project);
		$file_result = $file_stmt->execute();
		while ($row = $file_result->fetchArray(SQLITE3_ASSOC)) {
			$filepath = $row['filepath'];
			$stored_checksum = $row['checksum'];
			$last_synced = $row['last_synced'];
			// Check if file exists
			if(file_exists($filepath)){
				$file_content = file_get_contents($filepath);
				$current_checksum = md5($file_content);
				// Compare checksum to see if the file has been modified
				if ($current_checksum !== $stored_checksum) {
					// Call sync_file function
					datadoc::sync_file($filepath, $project);
					// Update the database record
					$update_stmt = $file_db->prepare("UPDATE files SET checksum=:checksum, last_synced=datetime('now'), is_stale=0 WHERE project=:project AND filepath=:filepath");
					$update_stmt->bindValue(':checksum', $current_checksum);
					$update_stmt->bindValue(':filepath', $filepath);
					$update_stmt->bindValue(':project', $project);
					$update_stmt->execute();
				}
				else
				{
					// Reset the staleness flag since the file exists and has been synced
					$stale_stmt = $file_db->prepare("UPDATE files SET is_stale=0 WHERE filepath=:filepath AND project=:project");
					$stale_stmt->bindValue(':filepath', $filepath);
					$stale_stmt->bindValue(':project', $project);
					$stale_stmt->execute();
				}
			}
			else
			{
				// Mark the file as stale in the database
				$stale_stmt = $file_db->prepare("UPDATE files SET is_stale=1 WHERE filepath=:filepath AND project=:project");
				$stale_stmt->bindValue(':filepath', $filepath);
				$stale_stmt->bindValue(':project', $project);
				$stale_stmt->execute();
			}
		}
	}

	public static function change_filepath(string $old_filepath, string $new_filepath){
		tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T=null, $S='function_call', $A=func_get_args()); // Log the function call
		if(!$file_db=datadoc::files_table()){
			return false;
		}
		// Prepare the SQL statement for updating the filepath
		$updateStmt = $file_db->prepare("UPDATE data SET file=:new_filepath WHERE file=:old_filepath");
		$updateStmt->bindValue(':new_filepath', $new_filepath);
		$updateStmt->bindValue(':old_filepath', $old_filepath);
		// Execute the update query
		if($updateStmt->execute()){
			return true; // Return true if the filepath was successfully updated
		}
		else
		{
			return false; // Return false if the update failed
		}
	}

	public static function sync_file(string $file, string $project=''){
		tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T=null, $S='function_call', $A=func_get_args()); // Log the function call
		if(!$data_db=datadoc::data_table()){
			return false;
		}
		if(false!==$tokens=datadoc\tokenizer::tokenize($file)){
			foreach($tokens as $token){
				
				if($token['type']==='function'){
					//echo'<div style="background-color:black;">';
					//echo datadoc\highlighter::highlight_code($token['content'], 'php');
					//echo'</div>';
				}
				
				$checksum = md5($token['type'].$token['function'].$token['class'].$token['namespace']);
				$stmt=$data_db->prepare('SELECT COUNT(*) as count FROM data WHERE checksum=:checksum AND project=:project LIMIT 1');
				$stmt->bindValue(':checksum', $checksum);
				$stmt->bindValue(':project', $project);
				$result=$stmt->execute()->fetchArray(SQLITE3_ASSOC);
				if($result['count']>0){
					// Update existing record
					$updateStmt = $data_db->prepare("UPDATE data SET time=:time, content=:content, file=:file, project=:project, line=:line, phpdoc_description=:phpdoc_description, phpdoc_tags=:phpdoc_tags WHERE checksum=:checksum AND project=:project");
					$updateStmt->bindValue(':content', $token['content']);
					$updateStmt->bindValue(':file', $file);
					$updateStmt->bindValue(':project', $project);
					$updateStmt->bindValue(':line', $token['line']);
					$updateStmt->bindValue(':time', time());
					if (!empty($token['phpdoc']['description'])) {
						$updateStmt->bindValue(':phpdoc_description', $token['phpdoc']['description']);
					}
					else
					{
						$updateStmt->bindValue(':phpdoc_description', '0');
					}
					if(!empty($token['phpdoc']['tags'])){
						$updateStmt->bindValue(':phpdoc_tags', json_encode($token['phpdoc']['tags']));
					}
					else
					{
						$updateStmt->bindValue(':phpdoc_tags', '0');
					}
					$updateStmt->bindValue(':checksum', $checksum);
					$updateStmt->execute();
				}
				else
				{
					// Insert new record
					$insertStmt = $data_db->prepare("INSERT INTO data (time, checksum, type, content, file, project, function, namespace, class, line, phpdoc_description, phpdoc_tags) VALUES (:time, :checksum, :type, :content, :file, :project, :function, :namespace, :class, :line, :phpdoc_description, :phpdoc_tags)");
					$insertStmt->bindValue(':time', time());
					$insertStmt->bindValue(':checksum', $checksum);
					$insertStmt->bindValue(':type', $token['type']);
					$insertStmt->bindValue(':content', $token['content']);
					$insertStmt->bindValue(':file', $file);
					$insertStmt->bindValue(':project', $project);
					$insertStmt->bindValue(':function', $token['function']);
					$insertStmt->bindValue(':namespace', $token['namespace']);
					$insertStmt->bindValue(':class', $token['class']);
					$insertStmt->bindValue(':line', $token['line']);
					if (!empty($token['phpdoc']['description'])) {
						$insertStmt->bindValue(':phpdoc_description', $token['phpdoc']['description']);
					}
					else
					{
						$insertStmt->bindValue(':phpdoc_description', '0');
					}
					if(!empty($token['phpdoc']['tags'])){
						$insertStmt->bindValue(':phpdoc_tags', json_encode($token['phpdoc']['tags']));
					}
					else
					{
						$insertStmt->bindValue(':phpdoc_tags', '0');
					}
					$insertStmt->execute();
				}
			}
		}
	}

}