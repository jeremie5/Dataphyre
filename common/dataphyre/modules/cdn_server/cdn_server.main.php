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

tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T="Module initialization");

cdn_server::$storage_filepath=$rootpath['dataphyre']."cdn_content/storage";

$configurations['dataphyre']['cdn_server']=[
    "redundancy_level"=>1,
	"streamed_encryption_chunk_size"=>8192,
	"cache_compression_level"=>0,
	"block_compression_level"=>0,
	"gc_timeout"=>5,
	"datacenter_priority"=>[
		"NAQC_MTL"=>1,
		"NAQC_QC"=>2
	],
	"servers"=>[
		"192.168.0.1"=>[
			"name"=>"SRV_CDN_0001",
			"datacenter"=>"NAQC_MTL"
		],
		"192.168.0.2"=>[
			"name"=>"SRV_CDN_0002",
			"datacenter"=>"NAQC_MTL"
		],
		"192.168.0.3"=>[
			"name"=>"SRV_CDN_0003",
			"datacenter"=>"NAQC_MTL"
		]
	]
];

cdn_server::$cdn_server_name=$configurations['dataphyre']['cdn_server']['servers'][$_SERVER['SERVER_ADDR']]['name'];

class cdn_server{ 
	
	static $cdn_server_name='';
	
	static $storage_filepath='';
	
	static $inodes_per_directory_depth=10000;
	
	static $modified_image_cache_lifespan=7200;
	
	static $remote_image_cache_lifespan=7200;
	
	static $max_content_addition_attempts=10;
	
	public static function get_servers_for_blockid(int $blockid, ?string $target_datacenter=null) : array {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		global $configurations;
		$servers=$configurations['dataphyre']['cdn_server']['servers'];
		$datacenter_priority=$configurations['dataphyre']['cdn_server']['datacenter_priority'];
		$hash=crc32((string)$blockid);
		$server_keys=array_keys($servers);
		usort($server_keys, function($a, $b)use($servers, $datacenter_priority){
			$priorityA=$datacenter_priority[$servers[$a]['datacenter']] ?? PHP_INT_MAX;
			$priorityB=$datacenter_priority[$servers[$b]['datacenter']] ?? PHP_INT_MAX;
			return $priorityA<=>$priorityB;
		});
		$total_servers=count($server_keys);
		$selected_servers=[];
		$datacenter_counts=[];
		$datacenter_groups=[];
		foreach($server_keys as $server_key){
			$datacenter=$servers[$server_key]['datacenter'];
			$datacenter_counts[$datacenter]=$datacenter_counts[$datacenter] ?? 0;
			$datacenter_groups[$datacenter][]=$server_key;
		}
		for($i=0; $i<$total_servers; $i++){
			$server_index=($hash+$i)%$total_servers;
			$server_key=$server_keys[$server_index];
			$datacenter=$servers[$server_key]['datacenter'];
			if($target_datacenter!==null && $datacenter!==$target_datacenter){
				continue;
			}
			if($datacenter_counts[$datacenter]<$configurations['dataphyre']['cdn_server']['redundancy_level'] && !in_array($server_key, $selected_servers)){
				$selected_servers[]=$server_key;
				$datacenter_counts[$datacenter]++;
			}
			if(count($selected_servers)>=$configurations['dataphyre']['cdn_server']['redundancy_level']*count($datacenter_counts)){
				break;
			}
		}
		$final_selected_servers=[];
		foreach($datacenter_groups as $datacenter=>$group_servers){
			if($target_datacenter!==null && $datacenter!==$target_datacenter){
				continue;
			}
			shuffle($group_servers);
			foreach($group_servers as $server_key){
				if(in_array($server_key, $selected_servers)){
					$final_selected_servers[]=$server_key;
				}
			}
		}
		return $final_selected_servers;
	}
	
	private static function can_store_block() : bool {
		$totalSpace=disk_total_space("/");
		$freeSpace=disk_free_space("/");
		$usedSpacePercentage=(1-$freeSpace/$totalSpace)*100;
		return $usedSpacePercentage<90;
	}
	
	public static function get_mime_type($filename) : string {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		$file_extension=strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		$mime_types=[
			'js'=>'text/javascript',
			'css'=>'text/css',
			'woff'=>'application/font-woff',
			'ttf'=>'application/font-sfnt',
			'jpg'=>'image/jpeg',
			'jpeg'=>'image/jpeg',
		];
		if(array_key_exists($file_extension, $mime_types)){
			return $mime_types[$file_extension];
		}
		$finfo=finfo_open(FILEINFO_MIME_TYPE);
		if($finfo){
			$mime_type=finfo_file($finfo, $filename);
			finfo_close($finfo);
			return $mime_type;
		}
		return 'application/octet-stream';
	}

	public static function get_folder(string $blockpath) : string {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		if(str_contains($blockpath, '.')) $blockpath=substr($blockpath, 0, strrpos($blockpath, ".")); // Remove file extension
		$result=str_replace('-', '/', cdn_server::decode_blockpath($blockpath));
		return $result;
	}

	public static function encode_blockpath(string $blockpath) : string {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		$paths=explode('/', $blockpath);
		foreach($paths as $id=>$path){
			$paths[$id]=strtoupper(dechex(intval($path)));
		}
		return implode('-',$paths);
	}

	public static function decode_blockpath(string $blockpath) : string {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		$paths=explode('-', $blockpath);
		foreach($paths as $id=>$path){
			$paths[$id]=hexdec($path);
		}
		return implode('-',$paths);
	}

	public static function blockid_to_blockpath(int $blockid) : string {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		while($blockid>0){
			$remainder=$blockid%self::$inodes_per_directory_depth;
			$path='-'.$remainder.$path;
			$temp=$blockid-$remainder;
			$blockid=$temp/self::$inodes_per_directory_depth;
		}
		return ltrim($path, '-');
	}
	
	public static function blockpath_to_blockid(string $blockpath) : int {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		$blockid=0;
		$pathParts=explode('-', $blockpath);
		foreach($pathParts as $part){
			if($part!==''){
				$blockid=$blockid*self::$inodes_per_directory_depth+intval($part);
			}
		}
		return $blockid;
	}
	
	public static function get_server_step() : int {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		global $configurations;
		return array_search($_SERVER['SERVER_ADDR'], array_keys($configurations['dataphyre']['cdn_server']['servers']));
	}

	public static function add_content(string $origin_url, int $iteration=0, bool $encryption=false) : array {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		if(!isset($iteration_error)){
			static $iteration_error='';
		}
		if(self::can_store_block()===false){
			tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S="Out of storage space", $T="fatal");
			return [
				"status"=>"failed", 
				"errors"=>"Out of storage space",
				"server"=>$_SERVER['SERVER_ADDR']
			];
		}
		if($iteration>self::$max_content_addition_attempts){
			if(!empty($blockid)){
				sql_update(
					$L="dataphyre.cdn_blocks",
					$F=["hash"=>$iteration_error],
					$P="WHERE blockid=?",
					$V=array($blockid)
				);
			}
			return [
				"status"=>"failed", 
				"errors"=>$iteration_error,
				"server"=>$_SERVER['SERVER_ADDR']
			];
		}
		if(empty($origin_url)){
			return [
			"status"=>"failed", 
			"errors"=>"No origin url",
			"server"=>$_SERVER['SERVER_ADDR']
			];
		}
		if(false===$server_step=self::get_server_step()){
			return [
				"status"=>"failed", 
				"errors"=>"Failed getting server step", 
				"server"=>$_SERVER['SERVER_ADDR']
			];
		}
		$i=0;
		while($i<5){
			$i++;
			if(!is_int($blockid)){
				$blockid=self::assign_block();
			}
			if(is_int($blockid)){
				if(false!==$blockpath_data=self::stream_remote_content_to_block($origin_url, $blockid, $encryption)){
					return array_filter([
						"status"=>"success",
						"origin"=>$origin_url,
						"blockpath"=>cdn_server::encode_blockpath($blockpath_data['blockpath']),
						"passkey"=>$blockpath_data['passkey'],
						"server"=>$_SERVER['SERVER_ADDR']
					]);
				}
				$iteration_error="Failed saving content to block $blockid from $origin_url";
				break;
			}
			$iteration_error="Failed to create block or no blockid returned from assignation";
			break;
		}
		return self::add_content($origin_url, $iteration+1, $encryption);
	}
	
	private static function assign_block(string $method_on_new="random") : int|bool {
		$query=[
			"mysql"=>"
				START TRANSACTION;
				SELECT blockid INTO @blockid 
				FROM dataphyre.cdn_blocks 
				WHERE use_count = 0 AND time <= DATE_SUB(NOW(), INTERVAL 5 MINUTE) 
				ORDER BY time ASC 
				LIMIT 1 
				FOR UPDATE;
				UPDATE dataphyre.cdn_blocks 
				SET time = NOW() 
				WHERE blockid = @blockid;
				COMMIT;
			",
			"postgresql"=>"
				WITH cte AS (
					SELECT blockid FROM dataphyre.cdn_blocks  
					WHERE use_count = 0 AND time <= (NOW() - INTERVAL '5 minutes') 
					ORDER BY time ASC 
					LIMIT 1 
					FOR UPDATE
				)
				UPDATE dataphyre.cdn_blocks 
				SET time = NOW() 
				WHERE blockid IN (SELECT blockid FROM cte) 
				RETURNING blockid;
			"
		];
		if(false!==$result=sql_query(
			$Q=$query, 
			$V=null, 
			$M=false, 
			$C=false, 
			$CC=false, 
			$Q=false
		)){
			$blockid=$result['blockid'];
		}
		if(empty($blockid)){
			if($method_on_new==='random'){
				$maxint=(int)file_get_contents(__DIR__."/maxint");
				$maxint=min($maxint, PHP_INT_MAX);
				$maxint=(int)max($maxint, self::$inodes_per_directory_depth);
				$attempts=0;
				while($attempts<10){
					$insert_blockid=random_int(1, $maxint);
					if(false!==sql_insert(
						$L="dataphyre.cdn_blocks",
						$F=["blockid"=>$insert_blockid]
					)){
						$blockid=$insert_blockid;
						break;
					}
					$attempts++; 
				}
				if(!is_int($blockid)){
					if(false!==$count_in_maxint_range=sql_count(
						$L="dataphyre.cdn_blocks",
						$P="WHERE blockid<? AND blockid>?",
						$V=[$maxint, $maxint/10],
						$C=false
					)){
						if($count_in_maxint_range/($maxint-($maxint/10))>0.75){ // If more than 75% of blocks are assigned in this range move to next one
							file_put_contents(__DIR__."/maxint", $maxint*10);
							return self::assign_block();
						}
					}
				}
			}
		}
		if(is_int($blockid)){
			return $blockid;
		}
		return false;
	}
	
	private static function stream_remote_content_to_block(string $origin_url, int $blockid, bool $encryption=false) : bool|array {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		$filename=self::blockid_to_blockpath($blockid);
		$filename=str_replace('-', '/', $filename);
		$filepath=cdn_server::$storage_filepath.$folder."/".$filename;
		if(file_exists($filepath)){
			tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S="Content already existed at block location", $T="fatal");
			return false;
		}
		if(self::can_store_block()===false){
			tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S="Out of storage space", $T="fatal");
			return false;
		}
		$passkey=($encryption===true)?bin2hex(openssl_random_pseudo_bytes(16)):null;
		if(false!==self::stream_remote_content_to_file($origin_url, $filepath, ["passkey"=>$passkey])){
			$hash=hash_file("sha256", $filepath);
			if(false!==$row=sql_select(
				$S="blockid",
				$L="dataphyre.cdn_blocks",
				$P="WHERE hash=?",
				$V=[$hash], 
				$F=false,
				$C=false
			)){
				unlink($filepath);
				$filename=cdn_server::blockid_to_blockpath($row['blockid']);
				$blockpath=str_replace('-', '/', $filename);
				return array_filter([
					"blockpath"=>$blockpath,
					"passkey"=>$passkey
				]);
			}
			$file_size=filesize($filepath);
			$mime_type=self::get_mime_type($filepath);
			if(false!==sql_update(
				$L="dataphyre.cdn_blocks",
				$F=[
					"use_count"=>1,
					"hash"=>$hash,
					"filesize"=>$file_size,
					"mime_type"=>$mime_type,
					"genesis_server"=>$_SERVER['SERVER_ADDR']
				],
				$P="WHERE blockid=?",
				$V=[$blockid]
			)){
				return array_filter([
					"blockpath"=>$filename,
					"passkey"=>$passkey
				]);
			}
			tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S="Failed assigning content to block", $T="fatal");
			unlink($filepath);
		}
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S="Failed to save content", $T="fatal");
		return false;
	}

	private static function stream_remote_content(string $url, ?array $parameters=null, int $max_attempts=10, int $retry_delay_micros=1000) : bool {
		tracelog(__DIR__, __FILE__, __LINE__, __CLASS__, __FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		$parameters??=[];
		$url=core::url_updated_querystring($url, $parameters);
		if(!str_contains($url, $_SERVER['SERVER_ADDR'])){
			$attempts=0;
			while($attempts<$max_attempts){
				if($stream=@fopen($url, 'rb')){
					stream_set_blocking($stream, false);
					while(!feof($stream)){
						if(false===$chunk=fread($stream, 4096))continue;
						echo $chunk;
					}
					fclose($stream);
					return true;
				}
				else
				{
					$attempts++;
					if($attempts<$max_attempts){
						usleep($retry_delay_micros);
					}
				}
			}
		}
		return false;
	}
	
	private static function stream_remote_content_to_file(string $url, string $filepath, ?array $parameters=null, int $max_attempts=10, int $retry_delay_micros=1000) : bool {
		tracelog(__DIR__, __FILE__, __LINE__, __CLASS__, __FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		global $configurations;
		$parameters??=[];
		$url=core::url_updated_querystring($url, $parameters);
		if(self::can_store_block()===false){
			tracelog(__DIR__, __FILE__, __LINE__, __CLASS__, __FUNCTION__, $S="Out of storage space", $T="fatal");
			return false;
		}
		$attempts=0;
		while($attempts<$max_attempts){
			if($stream=@fopen($url, 'rb')){
				stream_set_blocking($stream, false);
				core::file_put_contents_forced($temp_filepath=$filepath.'.tmp', '');
				if($file=fopen($temp_filepath, 'wb')){
					while(!feof($stream)){
						if(false===$read=fread($stream, 4096)) continue;
						fwrite($file, $read);
					}
					fclose($file);
					fclose($stream);
					$file_info=finfo_open(FILEINFO_MIME_TYPE);
					$mime_type=finfo_file($file_info, $temp_filepath);
					finfo_close($file_info);
					if(isset($parameters['passkey'])){
						if(str_starts_with($mime_type, 'image/')){
							$content=file_get_contents($temp_filepath);
							$encrypted_data=openssl_encrypt($content, 'aes-256-cbc', $parameters['passkey'], OPENSSL_RAW_DATA, $iv=random_bytes(16));
							core::file_put_contents_forced($filepath, $iv.$encrypted_data);
						}
						else
						{
							fwrite($encrypted_file=fopen($filepath, 'wb'), $iv=random_bytes(16));
							$input=fopen($temp_filepath, 'rb');
							while(!feof($input)){
								$chunk=fread($input, $configurations['dataphyre']['cdn_server']['streamed_encryption_chunk_size']);
								$encrypted_chunk=openssl_encrypt($chunk, 'aes-256-cbc', $parameters['passkey'], OPENSSL_RAW_DATA, $iv);
								fwrite($encrypted_file, $encrypted_chunk);
							}
							fclose($input);
							fclose($encrypted_file);
						}
					}
					else
					{
						rename($temp_filepath, $filepath);
					}
					return true;
				}
				else
				{
					fclose($stream);
					unlink($temp_filepath);
					$attempts++;
					if($attempts<$max_attempts){
						usleep($retry_delay_micros);
					}
				}
			}
			else
			{
				$attempts++;
				if($attempts<$max_attempts){
					usleep($retry_delay_micros);
				}
			}
		}
		return false;
	}

	public static function discard_content(int $blockid) : array {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		$filename=cdn_server::blockid_to_blockpath($blockid);
		$filename=str_replace('-', '/', $filename);
		$filepath=cdn_server::$storage_filepath.'/'.$filename;
		if(file_exists($filepath)){
			if(unlink($filepath)){
				sql_update(
					$L="dataphyre.cdn_blocks",
					$F="replication_count=replication_count-1",
					$P="WHERE blockid=?",
					$V=[$blockid]
				);
				tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S="Content discarded");
				return [
					"status"=>"success",
					"errors"=>"Content discarded successfully.",
					"server"=>$_SERVER['SERVER_ADDR']
				];
			}
			else
			{
				tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S="Failed to discard content");
				return [
					"status"=>"failed", 
					"errors"=>"Failed to discard content from storage.",
					"server"=>$_SERVER['SERVER_ADDR']
				];
			}
		}
		else
		{
			return [
				"status"=>"failed", 
				"errors"=>"No content found at specified block location.",
				"server"=>$_SERVER['SERVER_ADDR']
			];
		}
	}

	public static function purge_content(int $blockid) : array {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		$filename=cdn_server::blockid_to_blockpath($blockid);
		$filename=str_replace('-', '/', $filename);
		$filepath=cdn_server::$storage_filepath.'/'.$filename;
		if(file_exists($filepath)){
			if(unlink($filepath)){
				sql_update(
					$L="dataphyre.cdn_blocks", 
					$F=["use_count"=>0],
					$P="WHERE blockid=?", 
					$V=[$blockid], 
					$CC=true
				);
				tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S="Content purged");
				return [
					"status"=>"success", 
					"errors"=>"Content purged successfully.",
					"server"=>$_SERVER['SERVER_ADDR']
				];
			}
			else
			{
				tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S="Failed to purge content");
				return [
					"status"=>"failed", 
					"errors"=>"Failed to purge content from storage.",
					"server"=>$_SERVER['SERVER_ADDR']
				];
			}
		}
		else
		{
			return [
				"status"=>"failed", 
				"errors"=>"No content found at specified block location.",
				"server"=>$_SERVER['SERVER_ADDR']
			];
		}
	}

	public static function get_filepath(string $blockpath) : bool|string {
		global $rootpath;
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		if(false!==$filepath=self::get_folder($blockpath)){
			$filepath=$rootpath['dataphyre']."cdn_content/storage/".$filepath;
			if(file_exists($filepath)){
				return $filepath;
			}
		}
		return false;
	}

	public static function display_remote_file_content(string $blockpath, ?array $parameters=null) : void { 
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args());
		global $configurations;
		$mime_type=self::get_mime_type($blockpath);
		$parameters['proxy_bounces']??=0;
		$parameters['proxy_bounces']++;
		$file_no_extension=pathinfo($blockpath, PATHINFO_FILENAME);
		$filepath=self::get_folder($blockpath);
		$decoded_blockpath=self::decode_blockpath($file_no_extension);
		$blockid=self::blockpath_to_blockid($decoded_blockpath);
		$remote_servers=self::get_servers_for_blockid($blockid);
		if(!in_array($_SERVER['SERVER_ADDR'], $remote_servers)){
			if(str_contains($mime_type, 'image')){
				$remote_content_cache_key=hash("sha256", implode($parameters));
			}
			if(isset($remote_content_cache_key)){
				if(null!==$cached_content=cache::get($remote_content_cache_key)){
					//$cached_content_inflated=gzinflate($cached_content, $configurations['dataphyre']['cdn_server']['cache_compression_level']);
					//echo $cached_content_inflated;
					echo $cached_content;
					flush();
					fastcgi_finish_request();
					cache::set($remote_content_cache_key, $cached_content, self::$remote_image_cache_lifespan);
					exit();
				}
			}
		}
		if($parameters['proxy_bounces']>count($remote_servers)+1){
			self::cannot_display_content("Too many attempts within zone", 502);
		}
		$proxy_path=array_filter(explode(',',base64_decode($parameters['proxy_path'])));
		$filtered_remote_servers=array_filter($remote_servers, function($server) use ($proxy_path){
			return $server!==$_SERVER['SERVER_ADDR'] && !in_array($server, $proxy_path);
		});
		if(!empty($filtered_remote_servers)){
			$remote_server=reset($filtered_remote_servers);
			$proxy_path[]=$_SERVER['SERVER_ADDR'];
			$parameters['proxy_path']=base64_encode(implode(',', $proxy_path));
			$remote_url="http://{$remote_server}/vault/{$blockpath}";
			ob_start();
			if(false!==self::stream_remote_content($remote_url, $parameters)){
				$remote_content=ob_get_contents();
				flush();
				fastcgi_finish_request();
				if(in_array($_SERVER['SERVER_ADDR'], $remote_servers)){
					$remote_url="http://{$remote_server}/direct_storage/storage/{$filepath}";
					self::replicate_content($blockid, $decoded_blockpath, $remote_url);
				}
				else
				{
					if(isset($remote_content_cache_key)){
						$remote_content_deflated=gzdeflate($remote_content, $configurations['dataphyre']['cdn_server']['cache_compression_level']);
						cache::set($remote_content_cache_key, $remote_content_deflated, self::$remote_image_cache_lifespan);
					}
				}
				exit();
			}
			ob_end_clean();
		}
		if(!isset($parameters['genesis_server']) || !isset($parameters['expected_hash'])){
			if(false!==$block=sql_select(
				$S="*",
				$L="dataphyre.cdn_blocks",
				$P="WHERE blockid={$blockid}",
				$V=null,
				$F=false,
				$C=false
			)){
				if($block['genesis_server']==0){
					self::cannot_display_content("Zone server list exhausted. Genesis server is unknown for block ".$blockid.".", 502);
				}
				$parameters['genesis_server']=$block['genesis_server'];
				$parameters['expected_hash']=$block['expected_hash'];
			}
		}
		if(!empty($parameters['genesis_server'])){
			if(!in_array($parameters['genesis_server'], $proxy_path)){
				if($parameters['genesis_server']!==$_SERVER['SERVER_ADDR']){
					$proxy_path[]=$_SERVER['SERVER_ADDR'];
					$parameters['proxy_path']=base64_encode(implode(',', $proxy_path));
					$remote_url="http://{$parameters['genesis_server']}/vault/{$blockpath}";
					if(false!==self::stream_remote_content($remote_url, $parameters)){
						ob_flush();
						flush();
						fastcgi_finish_request();
						if(in_array($_SERVER['SERVER_ADDR'], $remote_servers)){
							$remote_url="http://{$parameters['genesis_server']}/direct_storage/storage/{$filepath}";
							if(false!==self::replicate_content($blockid, $decoded_blockpath, $remote_url, $parameters['expected_hash'])){
								if(!in_array($parameters['genesis_server'], $remote_servers)){
									file_get_contents($parameters['genesis_server']."/cdn_api?pvk=".$configurations['dataphyre']['private_key']."&action=discard&blockid=".$blockid);
									sql_query(
										$Q="UPDATE dataphyre.cdn_blocks SET genesis_server=? WHERE blockid=?;",
										$V=[$_SERVER['SERVER_ADDR'], $blockid]
									);
								}
							}
						}
						exit();
					}
				}
			}
		}
		self::cannot_display_content("No server left to attempt getting content from for block ".$blockid.".", 502);
	}
	
	public static function enforce_block_integrity(int $blockid, ?string $expected_hash=null) : bool {
		tracelog(__DIR__, __FILE__, __LINE__, __CLASS__, __FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		$blockpath=self::blockid_to_blockpath($blockid);
		$filename=str_replace('-', '/', $blockpath);
		$filepath=cdn_server::$storage_filepath.$folder."/".$filename;
		if(file_exists($filepath)){
			if(!isset($expected_hash)){
				if(false!==$block=sql_select(
					$S="*",
					$L="dataphyre.cdn_blocks",
					$P="WHERE blockid={$blockid}",
					$V=null,
					$F=false,
					$C=false
				)){
					$expected_hash=$block['hash'];
				}
				else
				{
					// Block is not assigned, delete block from storage if it exists
					unlink($filepath);
					return false;
				}
			}
			if(hash_file("sha256", $filepath)!==$expected_hash){
				self::discard_content($blockid);
				return false;
			}
		}
		return true;
	}
	
	private static function replicate_content(int $blockid, string $decoded_blockpath, string $remote_url, ?string $expected_hash=null) : bool {
		tracelog(__DIR__, __FILE__, __LINE__, __CLASS__, __FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		global $configurations;
		$filename=str_replace('-', '/', $decoded_blockpath);
		$filepath=cdn_server::$storage_filepath.$folder."/".$filename;
		if(false!==self::stream_remote_content_to_file($remote_url, $filepath, ['raw_file'])){
			if(false!==self::enforce_block_integrity($blockid, $expected_hash)){
				sql_query(
					$Q="UPDATE dataphyre.cdn_blocks SET replication_count=replication_count+1 WHERE blockid=?;",
					$V=[$blockid]
				);
				return true;
			}
		}
		return false;
	}
	
    public static function display_file_content(string $blockpath, ?array $parameters=null) : void {
        tracelog(__DIR__, __FILE__, __LINE__, __CLASS__, __FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		global $configurations;
		while(ob_get_level()){
			ob_end_flush();
		}
		$mime_type=self::get_mime_type($blockpath);
		header('server: DataphyreCDN ('.self::$cdn_server_name.')');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
		header('Content-Type: '.$mime_type);
		header('Cache-Control: max-age=31536000, immutable');
		header('Expires: '.gmdate('D, d M Y H:i:s', strtotime("+1 year")).'GMT');
		header('pragma: cache');
        if(false===$filepath=self::get_filepath($blockpath)){
			self::display_remote_file_content($blockpath, $parameters);
		}
		if(isset($parameters['expected_hash'])){
			$file_no_extension=pathinfo($blockpath, PATHINFO_FILENAME);
			$filepath=self::get_folder($blockpath);
			$decoded_blockpath=self::decode_blockpath($file_no_extension);
			$blockid=self::blockpath_to_blockid($decoded_blockpath);
			if(false===self::enforce_block_integrity($blockid, $parameters['expected_hash'])){
				self::cannot_display_content("Content block $blockid is corrupt. Anchor was dropped and a new one will be loaded.", 501);
			}
		}
		$parameters['mime_type']=$mime_type;
		if(in_array($mime_type, ['image/jpeg', 'image/png', 'image/webp'])){
			self::display_image($filepath, $parameters);
		}
		elseif(array_key_exists($mime_type, $video_mime_map=[
			'video/mp4'=>'mp4',
			'video/webm'=>'webm',
			'video/x-matroska'=>'mkv',
			'video/x-msvideo'=>'avi',
			'video/mov'=>'mov',
			'video/divx'=>'divx',
			'video/x-ms-asf'=>'asf',
			'video/x-ms-wmv'=>'wmv',
			'video/av1'=>'av1',
			'video/hevc'=>'hevc',
			'video/x-flv'=>'flv',
			'video/quicktime'=>'prores',
			'video/mpeg'=>'mpeg2'
		])){
			self::stream_video($filepath, $video_mime_map[$mime_type], $parameters);
		}
		else
		{
			self::stream_file($filepath, $parameters);
		}
    }
	
	private static function stream_file(string $filepath, ?array $parameters=null) : void {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		global $configurations;
		if(file_exists($filepath)){
			if($file=fopen($filepath, 'rb')){
				if(isset($parameters['passkey'])){
					$iv=fread($file, 16);
					while(!feof($file)){
						$encrypted_chunk=fread($file, $configurations['dataphyre']['cdn_server']['streamed_encryption_chunk_size']);
						if(false===$decrypted_chunk=openssl_decrypt($encrypted_chunk, 'aes-256-cbc', $parameters['passkey'], OPENSSL_RAW_DATA, $iv)){
							fclose($file);
							self::cannot_display_content("Decryption failed", 401);
						}
						echo $decrypted_chunk;
						flush();
					}
				}
				else
				{
					header('Content-Length: '.filesize($filepath));
					fpassthru($file);
				}
				fclose($file);
				exit();
			}
		}
		self::cannot_display_content("Failed to stream file", 500);
	}

	private static function stream_video(string $filepath, string $format, ?array $parameters=null) : void {
		tracelog(__DIR__, __FILE__, __LINE__, __CLASS__, __FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		$valid_formats=['mp4', 'webm', 'avi', 'mkv', 'wmv', 'mov', 'divx', 'asf', 'av1', 'hevc', 'ogv', '3gp', 'flv', 'prores', 'mpeg2'];
		if(!in_array($format, $valid_formats)){
			self::cannot_display_content("Invalid video format", 415);
		}
		header('Content-Type: video/'.$format);
		if(isset($parameters['passkey'])){
			self::stream_file($filepath, $parameters);
		}
		$cmd="ffmpeg -i ".escapeshellarg($filepath);
		if(isset($parameters['bitrate'])){
			$cmd.=" -b:v ".escapeshellarg($parameters['bitrate']);
		}
		$cmd.=" -f ".escapeshellarg($format)." pipe:1";
		$descriptorspec=[
			0=>['pipe', 'r'],
			1=>['pipe', 'w'],
			2=>['pipe', 'w']
		];
		$process=proc_open($cmd, $descriptorspec, $pipes);
		if(is_resource($process)){
			fclose($pipes[0]);
			while(!feof($pipes[1])){
				echo fread($pipes[1], 1024 * 16);
				flush();
			}
			fclose($ipes[1]);
			$return_value=proc_close($process);
			if($return_value!=0){
				self::cannot_display_content("Failed reading video", 410);
			}
			exit();
		}
		self::cannot_display_content("Unable to read video", 410);
	}
		
	private static function display_image(string $filepath, ?array $parameters=null) : void {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		$cache_key=hash("sha256", $filepath.$parameters['passkey'].$parameters['quality'].$parameters['raw_file'].$parameters['width'].$parameters['height'].$parameters['mode']);
		if(null!==$image=cache::get($cache_key)){
			//$inflated_image=gzinflate($remote_content, $configurations['dataphyre']['cdn_server']['cache_compression_level']);
			//echo $inflated_image;
			echo $image;
			ob_flush();
			flush();
			fastcgi_finish_request();
			cache::set($cache_key, $image, self::$modified_image_cache_lifespan);
			exit();
		}
		if(isset($parameters['raw_file'])){
			$parameters=[];
		}
		if(isset($parameters['passkey'])){
			if(false===$file_content=file_get_contents($filepath)){
				self::cannot_display_content("Failed to read file content", 409);
			}
			$iv=substr($file_content, 0, 16);
			$encrypted_content=substr($file_content, 16);
			if(false===$decrypted_content=openssl_decrypt($encrypted_content, 'aes-256-cbc', $parameters['passkey'], OPENSSL_RAW_DATA, $iv)){
				self::cannot_display_content("Decryption failed", 401);
			}
			$file_content=$decrypted_content;
		}
		else
		{
			if(false===$file_content=file_get_contents($filepath)){
				self::cannot_display_content("Image is not readable from disk", 409);
			}
		}
		if(false!==$modified_image=self::modify_image($file_content, $parameters)){
			echo $modified_image;
			ob_flush();
			flush();
			fastcgi_finish_request();
			cache::set($cache_key, $modified_image, self::$modified_image_cache_lifespan);
			exit();
		}
		self::cannot_display_content("Image is not readable from disk", 409);
	}
	
    private static function stretch_image(object $image, int $new_width, int $new_height) : object {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
        $dst_image=imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $new_width, $new_height, imagesx($image), imagesy($image));
        imagedestroy($image);
        return $dst_image;
    }

    private static function reframe_image(object $image, int $new_width, int $new_height) : object {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
        $src_aspect=imagesx($image)/imagesy($image);
        $new_aspect=$new_width/$new_height;
        if($src_aspect>$new_aspect){
            $src_height=imagesy($image);
            $src_width=imagesy($image)*$new_aspect;
            $src_x=(imagesx($image)-$src_width)/2;
            $src_y=0;
        }
		else
		{
            $src_width=imagesx($image);
            $src_height=imagesx($image)/$new_aspect;
            $src_x=0;
            $src_y=(imagesy($image)-$src_height)/2;
        }
        $dst_image=imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($dst_image, $image, 0, 0, $src_x, $src_y, $new_width, $new_height, $src_width, $src_height);
        imagedestroy($image);
        return $dst_image;
    }
	
	public static function cannot_display_content(string $error_string='Unknown error', int $status_code=502) : void {
		tracelog(__DIR__,__FILE__,__LINE__,__CLASS__,__FUNCTION__, $S=null, $T='function_call', $A=func_get_args()); // Log the function call
		global $configurations;
		ob_clean();
		header_remove();
		http_response_code($status_code);
		header('Content-Type: text/html');
		header('server: DataphyreCDN ('.self::$cdn_server_name.')');
		header('error: '.$error_string);
		$cdn_server_name=self::$cdn_server_name;
		echo <<<HTML
			<!DOCTYPE HTML>
			<html>
			<head>
				<meta charset="utf-8">
				<meta name="robots" content="noindex">
				<link href="https://cdn.shopiro.ca/res/assets/img/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">
				<link href="https://cdn.shopiro.ca/res/assets/img/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png">
				<style>
				@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap');
				@font-face { 
					font-family:Phyro-Bold; src: url('https://cdn.shopiro.ca/res/assets/universal/fonts/Phyro-Bold.ttf'); 
				} 
				.phyro-bold {
				  font-family: 'Phyro-Bold', sans-serif;
				  font-weight: 700;
				  font-style: normal;
				  line-height: 1.15;
				  letter-spacing: -.02em;
				  -webkit-font-smoothing: antialiased;
				}
				body { text-align: center; margin-top: 250px; font-family: Arial, sans-serif; }
				</style>
				<title>Dataphyre CDN</title>
			</head>
			<body>
				<span style='font-size:100px;color:black;' class='phyro-bold'><a href="https://shopiro.ca/" style="text-decoration:none;color:black;"><i>Shopiro</i></a> CDN</span><br>
				<p style='max-width:50%;font-size:20px;font-family:"Roboto",sans-serif;'>
					<center>Failed to display requested content: $error_string</center>
				</p>
				<p>($cdn_server_name)</p>
				<span style='font-size:30px;font-family:"Roboto",sans-serif;'>Powered by</span><br>
				<span style='font-size:60px;' class='phyro-bold'>Dataphyre™</span>
			</body>
			</html>
			HTML;
		exit();
	}
	
}