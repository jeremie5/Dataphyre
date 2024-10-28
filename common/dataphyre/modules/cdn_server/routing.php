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

define('RUN_MODE', 'sessionless_request');

try{
	if(!isset($rootpath['common_dataphyre'])){
		require($rootpath['dataphyre']."core.php");
	}
	else
	{
		require($rootpath['common_dataphyre']."core.php");
	}
}catch(\Throwable $e){
	pre_init_error('Fatal error: Unable to load dataphyre core: '.$e->getFile().": ".$e->getLine().": ".$e->getMessage());
} 

\dataphyre\scheduling::run(
	$name="cdn_server_traversal_gc",
	$filepath=__DIR__.'/traversal_gc.php',
	$frequency=$configurations['dataphyre']['cdn_server']['gc_timeout'],
	$timeout=$configurations['dataphyre']['cdn_server']['gc_timeout'],
	$memory='32M',
	$dependencies=[$rootpath['backend'].'wrapper.php'],
);

function config($a=null){ return dataphyre\core::get_config($a); }
function sql_count($a=null,$b=null,$c=null, $d=null, $e=null, $f=null){return dataphyre\sql::db_count($a,$b,$c,$d,$e,$f);}
function sql_select($a=null,$b=null,$c=null,$d=null,$e=null,$f=null,$g=null,$h=null){return dataphyre\sql::db_select($a,$b,$c,$d,$e,$f,$g,$h);}
function sql_delete($a=null,$b=null,$c=null,$d=null,$e=null,$f=null){return dataphyre\sql::db_delete($a,$b,$c,$d,$e,$f);}
function sql_update($a=null,$b=null,$c=null,$d=null,$e=null,$f=null,$g=null){return dataphyre\sql::db_update($a,$b,$c,$d,$e,$f,$g);}
function sql_insert($a=null,$b=null,$c=null,$d=null,$e=null,$f=null){return dataphyre\sql::db_insert($a,$b,$c,$d,$e,$f);}
function sql_query($a=null,$b=null,$c=null,$d=null,$e=null,$f=null, $g=null, $h=null){return dataphyre\sql::db_query($a,$b,$c,$d,$e,$f,$g,$h);}

$uri_parts=explode('/', $_REQUEST['uri']);

$allowed_referrers=array(
	"https://shopiro.ca/",
	"https://cs.shopiro.ca/",
	"https://cdn.shopiro.ca/",
	"https://shopiro.us/",
	"https://cs.shopiro.us/",
	"https://cdn.shopiro.us/",
	"https://shopiro.com/",
	"https://cs.shopiro.com/",
	"https://cdn.shopiro.com/"
);

$referrer_is_allowed=true;
//$referrer_is_allowed=false;
if(isset($_SERVER['HTTP_REFERER'])){
	foreach($allowed_referrers as $referrer){
		if(str_contains($_SERVER['HTTP_REFERER'], $referrer)){
			$referrer_is_allowed=true; 
			break;
		}
	}
}

if($uri_parts[0]==='res'){
	if($referrer_is_allowed===true){
		$file_path=substr($_REQUEST['uri'], strlen('res/'));
		if(!empty($file_path)){
			$file_path=$rootpath['dataphyre']."cdn_content/direct/".$file_path;
			$file_path=str_replace('../', '', $file_path); // Mitigation of directory traversal attacks
			if(is_readable($file_path)){
				header('server: DataphyreCDN ('.dataphyre\cdn_server::$cdn_server_name.')');
				header('Access-Control-Allow-Origin: *');
				header('Access-Control-Allow-Methods: GET, OPTIONS');
				header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
				header('Cache-Control: max-age=31536000, immutable');
				header('Expires: '.gmdate('D, d M Y H:i:s', strtotime("+1 year")).' GMT');
				header('pragma: cache');
				header('Content-Type: '.dataphyre\cdn_server::get_mime_type($file_path));
				header('Content-Length: '.filesize($file_path));
				header('Content-Disposition: inline; filename="'.basename($file_path).'"');
				$file=fopen($file_path, 'rb');
				if($file){
					fpassthru($file);
					fclose($file);
					exit();
				}
			}
		}
	}
	dataphyre\cdn_server::cannot_display_content("Unauthorized", 502);
	exit();
}
elseif($uri_parts[0]==='cdn_api'){
	header('Content-Type: application/json');
	if($_REQUEST['pvk']===$configurations['dataphyre']['private_key']){
		if($_REQUEST['action']==='push'){
			$encryption=(bool)$_REQUEST['encryption']??=false;
			$result=dataphyre\cdn_server::add_content(base64_decode($_REQUEST['origin']), 0, $encryption);
		}
		elseif($_REQUEST['action']==='purge'){ 
			$result=dataphyre\cdn_server::purge_content($_REQUEST['blockid']);
		}
		elseif($_REQUEST['action']==='discard'){
			$result=dataphyre\cdn_server::discard_content($_REQUEST['blockid']);
		}
		else
		{
			$result=["errors"=>"unknown_action"];
		}
		die(json_encode($result));
	}
	die(json_encode(array(
		'status'=>"failed", 
		"errors"=>"bad_private_key"
	)));
}
elseif($uri_parts[0]==='vault'){
	if($referrer_is_allowed===true){
		if(!empty($uri_parts[1])){
			$blockpath=$uri_parts[count($uri_parts)-1];
			if(is_numeric($blockpath)){
				$blockpath=dataphyre\cdn_server::encode_blockpath(dataphyre\cdn_server::blockid_to_blockpath($blockpath));
			}
			$parameters=$_REQUEST;
			dataphyre\cdn_server::display_file_content($blockpath, $parameters);
		}
		require(__DIR__."/facade.php");
		exit();
	}
}
elseif($uri_parts[0]==='robots.txt'){
	header('server: DataphyreCDN ('.dataphyre\cdn_server::$cdn_server_name.')');
	header('Content-Type: text/plain');
	echo"User-agent: *\n";
	echo"Disallow: /\n";
	exit();
}
elseif($uri_parts[0]==='dataphyre' && $uri_parts[1]==='tracelog'){
	require($rootpath['dataphyre']."modules/tracelog/viewer.php");
	exit();
}
elseif($uri_parts[0]==='dataphyre' && $uri_parts[1]==='logs'){
	require($rootpath['dataphyre']."modules/log_viewer/log_viewer.php");
	exit();
}
else
{
	require(__DIR__."/facade.php");
	exit();
}
require(__DIR__."/facade.php");
exit();