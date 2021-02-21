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

if($_POST[first] == ""){
    ?>
    <script>
        alert("write first name.");
        location.replace("modify_user.php");
    </script>
    <?
    exit;
}

if($_POST[last] == ""){
    ?>
    <script>
        alert("write last name.");
        location.replace("modify_user.php");
    </script>
    <?
    exit;
}


// 4. 회원정보 적기
$sql = "update USER set U_FIRSTNAME = '".$_POST[first] ."', U_LASTNAME = '".$_POST[last] ."' where U_ID = '".$_SESSION[user_id]."'";
mysqli_query($DB, $sql);

// 8. 첫 페이지로 보내기
?>
<script>
alert("information changed.");
location.replace("modify_user.php");
</script>