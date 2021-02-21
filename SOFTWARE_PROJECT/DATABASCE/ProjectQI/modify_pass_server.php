<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 로그인 안한 회원은 로그인 페이지로 보내기
if(!$_SESSION[user_id]){
    ?>
    <script>
        alert("you need Login.");
        location.replace("login.php");
    </script>
    <?
}

if($_POST[passwordN] == ""){
    ?>
    <script>
        alert("write password.");
        location.replace("modify_pass.php");
    </script>
    <?
    exit;
} else {
    //password confirm
    $sql = "select * from USER where U_ID = '".trim($_SESSION[user_id])."'";
    $result = mysqli_query($DB, $sql);
    $chk_data = mysqli_fetch_array($result);
    $SALTED = $_POST[passwordN].$chk_data[U_SALTVALUE];
    if( md5($SALTED)!= $chk_data[U_SALTPASS]){
        ?>
        <script>
            alert("miss password.");
            location.replace("modify_pass.php");
        </script>
        <?
        exit;
    }
}

if($_POST[password1] == ""){
    ?>
    <script>
        alert("write new password.");
        location.replace("modify_pass.php");
    </script>
    <?
    exit;
}

if($_POST[password2] == ""){
    ?>
    <script>
        alert("write confirm password.");
        history.back();
    </script>
    <?
    exit;
}

if($_POST[passwordN] == $_POST[password1]){
    ?>
    <script>
        alert("User another password.");
        history.back();
    </script>
    <?
    exit;
}

if($_POST[password1] != $_POST[password2]){
    ?>
    <script>
        alert("new password != confirm password.");
        history.back();
    </script>
    <?
    exit;
}


// 4. 회원정보 적기
$SALT = md5(rand(10, 99));
$SALTPASS = md5($_POST[password1].$SALT);
$sql = "update USER set U_SALTPASS = '".$SALTPASS."', U_SALTVALUE = '".$SALT."' where U_ID = '".$_SESSION[user_id]."'";
mysqli_query($DB, $sql);

// 8. 첫 페이지로 보내기
?>
<script>
alert("information changed.");
location.replace("main.php");
</script>