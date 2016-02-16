<?

include ("./include.php");
//STREAMING DATA UPDATE	
if($_POST[WORK_TYPE] == "STREAMING"){
	$sql = "INSERT INTO display (TS,USER_ID, LAT, LNG,CO,NO2,SO2,O3,TEMP,PM25) VALUES ( '".$_POST[TS]."','".$_POST[USER_ID]."','".$_POST[LAT]."','".$_POST[LNG]."','".$_POST[CO]."','".$_POST[NO2]."','".$_POST[SO2]."','".$_POST[O3]."','".$_POST[TEMP]."','".$_POST[PM25]."')";
	$DB->query($sql);
	
	if($DB){
		echo "success";
	}
	else{
		echo "fail";
	}
	
//SIGN UP DATA INSERT	
} else if($_POST[WORK_TYPE] == "SIGNUP"){
	//check id is 
	$query = "SELECT * FROM USER WHERE USER_ID = '".trim($_POST[email])."'";
	$result = $DB->query($query);
	$chk_data = mysqli_fetch_array($result);
	
	// if id is exist
	if($chk_data[USER_ID]){
		echo 'Already joined an email';
		exit;	
	}
	// insert to database
	$SALT = md5(rand(10, 99));
	$SALTPASS = md5($_POST[password].$SALT);
	$query = "INSERT INTO USER (USER_ID, FIRSTNAME, LASTNAME, AFFILIATION, ADDRESS, HASHEDPW, HASHSALT, LOGINCNT, GENDER) VALUES ('".trim($_POST[email])."', '".trim($_POST[first])."', '".trim($_POST[last])."', '".trim($_POST[affiliation])."', '".trim($_POST[address])."', '".trim($SALTPASS)."', '".$SALT."', '0', '".trim($_POST[gender])."')";
	$result = $DB->query($query);
	echo 'Welcome';
	exit;
	
} else if ($_POST[WORK_TYPE] == "SIGNIN"){
	$query = "SELECT * FROM USER WHERE USER_ID = '".$_POST[email]."'";
	$result = $DB->query($query);
	$fields = array();

	if ($result) {
		while($row = mysqli_fetch_assoc($result)) {
			$fields[] = $row;
		}
		//패스워드를 5회이상 틀린경우
		if($fields[0][DISABLELOGIN] == 1){
			echo "Your password is missed";
			exit;
		} 
		$SALTED = $_POST[password].$fields[0][HASHSALT];
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
				echo "You must change your password.";
			}else {
				$DB->query("UPDATE USER SET DESABELOGIN = 0 , FAILCNT = 0 WHERE USER_ID='".$fields[0][USER_ID]."'");
				echo "Success";
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
			echo"Your password is wrong";
			exit;
		}
	}else {
		echo "no matched";
	}
} else if ($_POST[WORK_TYPE] == "TEST"){
	
}



?>