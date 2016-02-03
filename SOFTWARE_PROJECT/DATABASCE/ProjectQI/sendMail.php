<?
$smtp_mail_id = "skql5566@naver.com"; //예)test@naver.com 혹은 test@gmail.com 등의 형식
$smtp_mail_pw = "stayNorth4U"; 
$to_email = "skql5566@naver.com"; //예) test@naver.com
$to_name = "PARK"; //예)홍길동
$title = "TEST"; //예)홍길동님의 문의사항 등록되었습니다. 
$from_name = "PARK";
$from_email = "skql5566@naver.com";
$content = "메일내용 <br> html도 가능";
 
$smtp_use = 'smtp.naver.com'; //네이버 메일 사용시
//$smtp_use = 'smtp.gmail.com'; //구글 메일 사용시 주석제거
if ($smtp_use == 'smtp.naver.com') { 
$from_email = $smtp_mail_id; //네이버메일은 보내는 id로만 전송이가능함
}else {
 $from_email = $from_email; 
}
 
//메일러 로딩
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
  $mail->Host = $smtp_use;   // email 보낼때 사용할 서버를 지정
  $mail->SMTPAuth = true;          // SMTP 인증을 사용함
  $mail->Port = 465;            // email 보낼때 사용할 포트를 지정
  $mail->SMTPSecure = "ssl";        // SSL을 사용함
  $mail->Username   = $smtp_mail_id; // 계정
  $mail->Password   = $smtp_mail_pw; // 패스워드
  $mail->SetFrom($from_email, $from_name); // 보내는 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)
  $mail->AddAddress($to_email, $to_name);  // 받을 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)
  $mail->Subject = $title;         // 메일 제목
  $mail->MsgHTML($content);         // 메일 내용 (HTML 형식도 되고 그냥 일반 텍스트도 사용 가능함)
  $mail->Send();              // 실제로 메일을 보냄
echo "메일을 전송하였습니다.";
 
} catch (phpmailerException $e) {
  echo "ok".$e->errorMessage();
} catch (Exception $e) {
   echo "no".$e->getMessage();
}?>