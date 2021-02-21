<?
// sessoin start
session_start();

include ("./lib.php");

// Dbconnect
$DB = sql_connect($db_host, $db_user, $db_pass, $db_name);

// 4. head 부분 
?>