<?
include ("./include.php");
$_POST[USER_ID] = "test@test.com";
$_POST[PASSWORD] = "test";
$query = "SELECT * FROM USER WHERE USER_ID = '".$_POST[USER_ID]."'";
$result = $DB->query($query);
$fields = array();

if ($result) {
	while($row = mysqli_fetch_assoc($result)) {
		$fields[] = $row;
	}
	//패스워드를 5회이상 틀린경우
	if($fields[0][DISABLELOGIN] == 1){
		echo "[{'RESULT': 'Miss_Password'}]";
		exit;
	} 
	$SALTED = $_POST[PASSWORD].$fields[0][HASHSALT];
	if( md5($SALTED)== $fields[0][HASHEDPW]){
		// 6. 비밀번호가 같으면 세션값 부여 후 이동
		$_SESSION[USER_ID] = $fields[0][HASHSALT];
		$_SESSION[ADMIN] = $fields[0][HASHSALT];
		
		//UPDATE STATE
		$CNT = $fields[0][LOGINCNT] + 1;
		$query = "UPDATE USER SET LOGINCNT = ".$CNT." WHERE USER_ID='".$fields[0][USER_ID]."'";
		$DB->query($query);
		if($CNT % 5 == 0){
			$DB->query("UPDATE USER SET LOGINCNT = 0 WHERE USER_ID='".$fields[0][USER_ID]."'");
			echo "[{'RESULT': 'Change_Password'}]";
		}else {
			$DB->query("UPDATE USER SET DESABELOGIN = 0 , FAILCNT = 0 WHERE USER_ID='".$fields[0][USER_ID]."'");
			echo "[{'RESULT': 'success'}]";
		}
		exit;
	} else {
		echo "hello";
		if($fields[0][LOGINFAILCNT] > 4){
			$DB->query("UPDATE USER SET DISABLELOGIN = 1 WHERE USER_ID='".$fields[0][USER_ID]."'");
		}else{
			//FAILCNT 증가
			$FAILCNT = $fields[0][LOGINFAILCNT] + 1;
			$DB->query("UPDATE USER SET LOGINFAILCNT = ".$FAILCNT." WHERE USER_ID='".$fields[0][USER_ID]."'");
		}
		echo"[{'RESULT': 'Wrong_password'}]";
		exit;
	}
}else {
	echo "[{'RESULT': 'Nodata'}]";
}
?>
