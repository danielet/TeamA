<?

include ("./include.php");

$data = json_decode($_POST[TEST], true);
echo $data['USER_ID'];
echo $data['LAT'];
echo $data['LNG'];

$query = "insert into STREAMING (USER_ID, , LAT, LNG) values ('".trim($data['USER_ID'])."', '".trim($data['LAT'])."', '".trim($data['LNG'])."')";
$result = $DB->query($query);


?>