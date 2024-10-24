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

/*************** DATAPHYRE  ***************/
try{
	require_once($rootpath['common_dataphyre']."core.php");
}catch(\Throwable $e){
	if(function_exists("log_error")){
		pre_init_error("Failed to initiate Dataphyre: ".$e->getFile().": ".$e->getLine().": ".$e->getMessage());
	}
	else
	{
		die("Panic: Failed to initiate Dataphyre");
	}
}
/********************************************/

tracelog(__FILE__,__LINE__,__CLASS__,__FUNCTION__, $T="Loaded");

#*************** DATAPHYRE COMPATIBILITY LAYER
// Note: Required since Dataphyre was initially not a framework
function sanitize($a=null,$b=null){return dataphyre\sanitation::sanitize($a,$b);}
function encrypt_data($a=null,$b=null){return dataphyre\core::encrypt_data($a,$b);}
function decrypt_data($a=null,$b=null){return dataphyre\core::decrypt_data($a,$b);}
function array_count($a=null){return dataphyre\core::arr_count($a);}
function convert_storage_unit($a=null){return dataphyre\core::convert_storage_unit($a);}
function sql_count($a=null,$b=null,$c=null, $d=null){return dataphyre\sql::db_count($a,$b,$c,$d);}
function sql_select($a=null,$b=null,$c=null,$d=null,$e=null,$f=null){return dataphyre\sql::db_select($a,$b,$c,$d,$e,$f);}
function sql_delete($a=null,$b=null,$c=null,$d=null){return dataphyre\sql::db_delete($a,$b,$c,$d);}
function sql_update($a=null,$b=null,$c=null,$d=null,$e=null){return dataphyre\sql::db_update($a,$b,$c,$d,$e);}
function sql_insert($a=null,$b=null,$c=null,$d=null){return dataphyre\sql::db_insert($a,$b,$c,$d);}
function clear_cache(){return dataphyre\sql::db_clear_cache();}
function is_bot(){return dataphyre\access::is_bot();}
function rps_limiter($a=null){return dataphyre\firewall::rps_limiter($a);}
function anonymize_email($a=null,$b=null,$c=null){return dataphyre\sanitation::anonymize_email($a,$b,$c);}
function config($a=null){ return dataphyre\core::get_config($a); }
function get_env($a=null){ return dataphyre\core::get_env($a); }
function set_env($a=null, $b=null){ return dataphyre\core::set_env($a, $b); }
function currency_formatter($a=null, $b=null){return dataphyre\currency::formatter($a, $b);}
function rounder($a=null){return dataphyre\currency::convert_to_user_currency($a);}
function convert_to_user_currency($a=null, $b=null, $c=null, $d=null){return dataphyre\currency::convert_to_user_currency($a, $b, $c, $d);}
function convert_to_website_currency($a=null, $b=null, $c=null, $d=null){return dataphyre\currency::convert_to_website_currency($a, $b, $c, $d);}
function adapt($a=null, $b=null){ return dataphyre\templating::adapt($a, $b);}

date_default_timezone_set(config("dataphyre/datadoc/timezone"));