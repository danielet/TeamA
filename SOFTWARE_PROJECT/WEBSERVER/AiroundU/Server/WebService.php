<?php include ("./include.php");
//admin user search
if($_POST[WORK_TYPE] == "SERACH_ADMIN_USER"){
	
	$query = "SELECT * FROM USER";
	$result = $DB->query($query);
	$fields = array();
	while($row = mysqli_fetch_assoc($result)) {
		$fields[] = $row;
	}
	echo json_encode($fields);
	exit;
} else if ($_POST[WORK_TYPE] == "SEARCH_STREAMING"){
	
	$query = "SELECT * FROM display";
	$result = $DB->query($query);
	$fields = array();
	while($row = mysqli_fetch_assoc($result)) {
		$fields[] = $row;
	}
	echo json_encode($fields);
	//get Air polution range	
} else if ($_POST[WORK_TYPE] == "SEARCH_AIRPOLUTIONLANGE"){
	
	$query = "SELECT * FROM CODE WHERE CD LIKE 'L%';";
	$result = $DB->query($query);
	$fields = array();
	while($row = mysqli_fetch_assoc($result)) {
		$fields[] = $row;
	}
	echo json_encode($fields);
	//ADMIN ID SEARCH	
} else if ($_POST[WORK_TYPE] == "LOGIN"){
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
} else if($$_POST[WORK_TYPE] == "SEARCH_DISPLAY"){
	$query = 'SELECT * FROM DISPLAY_VIEW';
}

function safeCount($array) {
	if (isset($array)) return count($array);
	return -1;
}
//