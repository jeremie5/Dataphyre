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