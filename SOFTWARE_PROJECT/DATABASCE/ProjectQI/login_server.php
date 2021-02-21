<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<?
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 로그인한 회원은 뒤로 보내기
if($_SESSION[user_id]){
    ?>
    <script>
        alert("you already logined.");
        history.back();
    </script>
    <?
}

// 3. 넘어온 변수 검사
if(trim($_POST[id]) == ""){
    ?>
    <script>
        alert("Please check your id.");
        history.back();
    </script>
    <?
    exit;
}

if($_POST[password] == ""){
    ?>
    <script>
        alert("you should list your password.");
        history.back();
    </script>
    <?
    exit;
}

// 4. 같은 아이디가 있는지 검사
//조회 알고리즘에 대한 검색 필요(fast search algorithm)
$sql = "select * from USER where U_ID = '".trim($_POST[id])."'";
$result = $DB->query($sql);
$chk_data = mysqli_fetch_array($result);
// 5. 아이디가 존재 하는 경우
if($chk_data[U_ID]){
    //패스워드를 5회이상 틀린경우
    if($chk_data[10] == "F"){
        ?>
        <script>
            alert("you're missed password. 5 times, your account is locked");
            history.back();
        </script>
        <?
        exit;
    }
    // 5. 입력된 비밀번호와 저장된 비밀번호가 같은지 비교해서
    $SALTED = $_POST[password].$chk_data[U_SALTVALUE];
    if( md5($SALTED)== $chk_data[U_SALTPASS]){
        // 6. 비밀번호가 같으면 세션값 부여 후 이동
        $_SESSION[user_id] = $chk_data[U_ID];
        $_SESSION[user_name] = $chk_data[U_NAME];
        
        $host = "localhost";
        $user = "root";
        $pw = "apmsetup";
        $db = "UCSD";
        $my_db = new mysqli($host,$user,$pw,$db);
        mysqli_query($my_db,"set names utf8");
        if ( mysqli_connect_errno() ) {
            echo mysqli_connect_error();
            exit;
        }
        $CNT = $chk_data[LOGINCNT] + 1;
        $my_db->query("UPDATE USER SET LOGINCNT = ".$CNT." WHERE U_ID='".$chk_data[U_ID]."'");
        if($CNT % 5 == 0){
            $my_db->query("UPDATE USER SET LOGINCNT = "."0"." WHERE U_ID='".$chk_data[U_ID]."'");
        ?>
        <script>
            alert("you shoud change your password [security problem].");
            location.replace("modify_pass.php");
        </script>
        <?       
            
        }else {
            $DB->query("UPDATE USER SET LOGIN_ENABLE = '' , FAILCNT = 0 WHERE U_ID='".$chk_data[U_ID]."'");
            
        ?>
        <script>
            //alert("환영합니다.");
            location.replace("main.php");
        </script>
        <?
        }
        exit;
    }else{
        // 7. 비밀번호가 다르면
        if($chk_data[9] > 4){
            $DB->query("UPDATE USER SET LOGIN_ENABLE = 'F' WHERE U_ID='".$chk_data[U_ID]."'");
        }else{
            //FAILCNT 증가
            $FAILCNT = $chk_data[9] + 1;
            $DB->query("UPDATE USER SET FAILCNT = ".$FAILCNT." WHERE U_ID='".$chk_data[U_ID]."'");
        } 
        ?>
        <script>
            alert("wrong password.");
            history.back();
        </script>
        <?
        exit;
    }
}else{
    // 8. 아이디가 존재하지 않으면
    ?>
    <script>
        alert("he is not exist.");
        history.back();
    </script>
    <?
    exit;
}
?>