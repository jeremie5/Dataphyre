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


$filename=$_PARAM['filename'];
$filename=str_replace("/","", $filename);
$filename=str_replace("%2F","", $filename);

if(strpos(strtolower($filename), "png")){ header("Content-Type: image/png"); }
if(strpos(strtolower($filename), "jpeg")){ header("Content-Type: image/jpeg"); }
if(strpos(strtolower($filename), "jpg")){ header("Content-Type: image/jpeg"); }
if(strpos(strtolower($filename), "gif")){ header("Content-Type: image/gif"); }
if(strpos(strtolower($filename), "css")){ header("Content-Type: text/css"); }
if(strpos(strtolower($filename), "html")){ header("Content-Type: text/html"); }
if(strpos(strtolower($filename), "htm")){ header("Content-Type: text/html"); }
if(strpos(strtolower($filename), "gif")){ header("Content-Type: text/gif"); }
if(strpos(strtolower($filename), "js")){ header("Content-Type: application/javascript"); }
if(strpos(strtolower($filename), "ogg")){ header("Content-Type: application/ogg"); }
if(strpos(strtolower($filename), "pdf")){ header("Content-Type: application/pdf"); }
if(strpos(strtolower($filename), "zip")){ header("Content-Type: application/zip"); }
if(strpos(strtolower($filename), "mp4")){ header("Content-Type: video/mp4"); }
if(strpos(strtolower($filename), "mp3")){ header("Content-Type: audio/mpeg"); }
if(strpos(strtolower($filename), "wav")){ header("Content-Type: audio/x-ms-wma"); }

if(file_exists($filename=__DIR__."/cache/".$filename)){
	if(false!==$file=file_get_contents($filename)){
		echo $file;
	}
}
header("HTTP/1.0 404 Not Found");
exit();