<?php include ("./include.php");
//admin user search
if($_POST[WORK_TYPE] == "SERACH_ADMIN_USER"){
	$query = "SELECT * FROM USER WHERE ADMIN = 1";
	$result = $DB->query($query);
	$fields = array();
	while($row = mysqli_fetch_assoc($result)) {
		$fields[] = $row;
	}
	echo json_encode($fields);
	exit;
} else if ($_POST[WORK_TYPE] == "UPDATE_ADMIN") {
	//update users new password.
	if($_POST[NEWPASSWORD] != ""){
		$query = "SELECT * FROM USER WHERE USER_ID = '".$_POST[USER_ID]."'";
		$result = $DB->query($query);
		$fields = array();
		
		if ($result) {
			while($row = mysqli_fetch_assoc($result)) {
				$fields[] = $row;
			}
			//cur password and saltedvalue
			$SALTED = $_POST[CURPASSWORD].$fields[0][HASHSALT];
			if( md5($SALTED)== $fields[0][HASHEDPW]){
				//build new HASHSALT and HASHEDPW
				$NEW_HASHSALT = md5(rand(10, 99));
				$NEW_HASHEDPW = md5($_POST[NEWPASSWORD].$NEW_HASHSALT);
				//UPDATE
				$query = "UPDATE USER SET FIRSTNAME = '".$_POST[FIRSTNAME]."', LASTNAME = '".$_POST[LASTNAME]."', GENDER = '".$_POST[GENDER]."', ADDRESS = '".$_POST[ADDRESS]."', AFFILIATION = '".$_POST[AFFILIATION]."', HASHSALT = '".$NEW_HASHSALT."', HASHEDPW = '".$NEW_HASHEDPW."' WHERE USER_ID='".$_POST[USER_ID]."'";
				$DB->query($query);
				echo "[{'RESULT': 'success'}]";
				exit;
			} else {
				echo"[{'RESULT': 'wrongPw'}]";
				exit;
			}
		}else {
			echo "[{'RESULT': 'Nodata'}]";
		}
	//update only users information
	} else {
		$query = "UPDATE USER SET FIRSTNAME = '".$_POST[FIRSTNAME]."', LASTNAME = '".$_POST[LASTNAME]."', GENDER = '".$_POST[GENDER]."', ADDRESS = '".$_POST[ADDRESS]."', AFFILIATION = '".$_POST[AFFILIATION]."' WHERE USER_ID='".$_POST[USER_ID]."'";
		$DB->query($query);
		echo "[{'RESULT': 'success'}]";
	}
	
} else if ($_POST[WORK_TYPE] == "INSERT_ADMIN") {
	$query = "SELECT * FROM USER WHERE USER_ID = '".trim($_POST[email])."'";
	$result = $DB->query($query);
	$chk_data = mysqli_fetch_array($result);
	
	// if id is exist
	if($chk_data[USER_ID]){
		echo "[{'RESULT': 'already'}]";
		exit;	
	}
	// insert to database
	$SALT = md5(rand(10, 99));
	$SALTPASS = md5($_POST[password].$SALT);
	$query = "INSERT INTO USER (USER_ID, FIRSTNAME, LASTNAME, AFFILIATION, ADDRESS, HASHEDPW, HASHSALT, LOGINCNT, GENDER, ADMIN, JOINDATE) VALUES ('".trim($_POST[USER_ID])."', '".trim($_POST[FIRSTNAME])."', '".trim($_POST[LASTNAME])."', '".trim($_POST[AFFILIATION])."', '".trim($_POST[ADDRESS])."', '".trim($SALTPASS)."', '".$SALT."', '0', '".trim($_POST[gender])."', '1',  sysdate())";
	$result = $DB->query($query);
	echo "[{'RESULT': 'success'}]";
	exit;
} else if ($_POST[WORK_TYPE] == "DELETE_ADMIN") {
	
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
			echo "[{'RESULT': 'many_fail'}]";
			exit;
		} 
		$SALTED = $_POST[PASSWORD].$fields[0][HASHSALT];
		if( md5($SALTED)== $fields[0][HASHEDPW]){
			// 6. 비밀번호가 같으면 세션값 부여 후 이동
			$_SESSION[USER_ID] = $fields[0][USER_ID];
			$_SESSION[ADMIN] = $fields[0][ADMIN];
			
			//UPDATE STATE
			$CNT = $fields[0][LOGINCNT] + 1;
			$query = "UPDATE USER SET LOGINCNT = ".$CNT." WHERE USER_ID='".$fields[0][USER_ID]."'";
			$DB->query($query);
			if($CNT % 5 == 0){
				$DB->query("UPDATE USER SET LOGINCNT = 0 WHERE USER_ID='".$fields[0][USER_ID]."'");
				echo "[{'RESULT': 'Change_Password'}]";
			}else {
				$DB->query("UPDATE USER SET DISABLELOGIN = 0 , LOGINFAILCNT = 0 WHERE USER_ID='".$fields[0][USER_ID]."'");
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
//display search
} else if($_POST[WORK_TYPE] == "SEARCH_DISPLAY"){
	//delete
	$query = 'SELECT * FROM DISPLAY_VIEW';
	
	
//forgot password mailing service.
} else if ($_POST[WORK_TYPE] == "FORGOT_PASSWORD"){
	$query = "SELECT * FROM USER WHERE USER_ID = '".$_POST[USER_ID]."'";
	$result = $DB->query($query);
	$fields = array();
	if (!$result) {
		echo "[{'RESULT': 'noId'}]";	
		exit;
	}
	while($row = mysqli_fetch_assoc($result)) {
		$fields[] = $row;
	}
	$NEWPASS = "a".rand(10000, 99999);
	$SALT = rand(10, 99);
	
	$NEW_HASHSALT = md5($SALT);
	$NEW_HASHEDPW = md5($NEWPASS.$NEW_HASHSALT);
	
	$DB->query("UPDATE USER SET DISABLELOGIN = 0 , LOGINFAILCNT = 0 , HASHSALT= '".$NEW_HASHSALT."', HASHEDPW = '".$NEW_HASHEDPW."' WHERE USER_ID='".$_POST[USER_ID]."'");
	
	$smtp_mail_id = "skql5566@naver.com"; //ex)test@naver.com smtp host 
	$smtp_mail_pw = "stayNorth4U"; 
	$to_email = $fields[0][USER_ID]; //ex) test@naver.com
	$to_name = $fields[0][FIRST]; //ex)JACK
	$title = "(AiroundU) the new email"; //ex)title
	$from_name = "AiroundU";
	$from_email = "skql5566@naver.com";
	$content = "your new password is [".$NEWPASS."]";
	
	$smtp_use = 'smtp.naver.com'; //smtp server
	if ($smtp_use == 'smtp.naver.com') { 
		$from_email = $smtp_mail_id; //send id
	}else {
		$from_email = $from_email; 
	}
	
	//load mailer
	include("class.phpmailer.php");
	include("class.smtp.php");
	//include("PHPMailerAutoload.php");
	//include("class.phpmaileroauth.php");
	
	$mail = new PHPMailer(true);
	$mail->ContentType="text/html";
	$mail->Charset = "utf-8";
	$mail->Encoding = "base64";
	$mail->IsSMTP();
	try {
		$mail->Host = $smtp_use;   // email host
		$mail->SMTPAuth = true;          // SMTP ssl
		$mail->Port = 465;            // email port
		$mail->SMTPSecure = "ssl";        // SSL enable
		$mail->Username   = $smtp_mail_id; // id
		$mail->Password   = $smtp_mail_pw;	    // password
		$mail->SetFrom($from_email, $from_name);// send person
		$mail->AddAddress($to_email, $to_name); // recive person
		$mail->Subject = $title;					// title
		$mail->MsgHTML($content);					// content
		$mail->Send();								//send
		echo "[{'RESULT': 'success'}]";
		
	} catch (phpmailerException $e) {
		echo "[{'RESULT': 'ok'}]";
	} catch (Exception $e) {
		echo "[{'RESULT': 'no'}]";
	}	
}

function safeCount($array) {
	if (isset($array)) return count($array);
	return -1;
}
//