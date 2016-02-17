<?

include ("./include.php");
//STREAMING DATA UPDATE	
if($_POST[WORK_TYPE] == "STREAMING"){
	
	//SELECT * FORM DISPLAY WHERE USER = "", DEVICE_ID = ""
	$query = "SELECT * FROM USER WHERE USER_ID = '".trim($_POST[email])."', DEVICE_ID = '".trim($_POST[mac])."'";
	$result = $DB->query($query);
	$chk_data = mysqli_fetch_array($result);
	
	// if id is exist
	if($chk_data[USER_ID]){
		//update data, avg
		$AVG_CO = (($chk_data[AVG_CO] * $chk_data[UPDATECNT]) + $chk_data[CO]) / ($chk_data[UPDATECNT] + 1) ;
		$AVG_NO2 = (($chk_data[AVG_NO2] * $chk_data[UPDATECNT]) + $chk_data[NO2]) / ($chk_data[UPDATECNT] + 1) ;
		$AVG_SO2 = (($chk_data[AVG_SO2] * $chk_data[UPDATECNT]) + $chk_data[SO2]) / ($chk_data[UPDATECNT] + 1) ;
		$AVG_O3 = (($chk_data[AVG_O3] * $chk_data[UPDATECNT]) + $chk_data[O3]) / ($chk_data[UPDATECNT] + 1) ;
		$AVG_TEMP = (($chk_data[AVG_TEMP] * $chk_data[UPDATECNT]) + $chk_data[TEMP]) / ($chk_data[UPDATECNT] + 1) ;
		$AVG_PM25 = (($chk_data[AVG_PM25] * $chk_data[UPDATECNT]) + $chk_data[PM25]) / ($chk_data[UPDATECNT] + 1) ;
		$sql = "UPDATE display SET CO = '".$_POST[CO]."', NO2 = '".$_POST[NO2]."', SO2 = '".$_POST[SO2]."', 03 = '".$_POST[O3]."', TEMP = '".$_POST[TEMP]."', PM25 = '".$_POST[PM25]."', AVG_CO = '".$AVG_CO."', AVG_NO2 = '".$AVG_NO2."', AVG_SO2 = '".$AVG_SO2."', AVG_O3 = '".$AVG_O3."', AVG_TEMP = '".$AVG_TEMP."', AVG_PM25 = '".$AVG_PM25."', UPDATECNT = '".($chk_data[UPDATECNT] + 1)."'  WHERE USER_ID = '".$_POST[email]."' AND DEVICE ID= '".$_POST[mac]."'";
		$DB->query($sql);
		
		if($DB){
			echo "success";
		}
		else{
			echo "fail";
		}	
	} else {
		//If key is not exist -> insert
		//insert new value
		$sql = "INSERT INTO display (DEVICE_ID,USER_ID, LAT, LNG, CO, NO2, SO2, O3, TEMP, PM25, AVG_CO, AVG_NO2, AVG_SO2, AVG_O3, AVG_TEMP, AVG_PM25, UPDATECNT) VALUES ( '".$_POST[DEVICE_ID]."','".$_POST[USER_ID]."','".$_POST[LAT]."','".$_POST[LNG]."','".$_POST[CO]."','".$_POST[NO2]."','".$_POST[SO2]."','".$_POST[O3]."','".$_POST[TEMP]."','".$_POST[PM25]."', 0, 0, 0, 0, 0, 0, 0)";
		$DB->query($sql);
		
		if($DB){
			echo "success";
		}
		else{
			echo "fail";
		}
	}
//SIGN UP DATA INSERT	
} else if ($_POST[WORK_TYPE] == "STREAMING_END"){
	$query = "DELETE FROM display WHERE USER_ID = '".trim($_POST[email])."', DEVICE_ID = '".trim($_POST[mac])."'";
	$result = $DB->query($query);
	$chk_data = mysqli_fetch_array($result);
		
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
	$query = "INSERT INTO USER (USER_ID, FIRSTNAME, LASTNAME, AFFILIATION, ADDRESS, HASHEDPW, HASHSALT, LOGINCNT, GENDER, ADMIN, JOINDATE) VALUES ('".trim($_POST[email])."', '".trim($_POST[first])."', '".trim($_POST[last])."', '".trim($_POST[affiliation])."', '".trim($_POST[address])."', '".trim($SALTPASS)."', '".$SALT."', '0', '".trim($_POST[gender])."', '0', sysdate())";
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