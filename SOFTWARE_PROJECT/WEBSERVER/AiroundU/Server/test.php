<?
include ("./include.php");

$query = "SELECT * FROM USER WHERE USER_ID = 'test@test.com'";
$result = $DB->query($query);
$fields = array();
if (!$result) {
	echo "[{'RESULT': 'noId'}]";	
	exit;
} else {
	echo "ok";
}

?>
