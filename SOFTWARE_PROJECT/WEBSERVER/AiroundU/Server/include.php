<?
// sessoin start
session_start();

include ("lib.php");

// Dbconnect
$DB = sql_connect($db_host, $db_user, $db_pass, $db_name);

//check input value is empty
function check_empty($value){
	if($value == ""){
		echo 'miss_logined'.key($value);
		exit;
	} 
}
?>