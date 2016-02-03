<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 로그인한 회원은 뒤로 보내기
if($_SESSION[user_id]){
    ?>
    <script>
        alert("로그인 하신 상태입니다.");
        history.back();
    </script>
    <?
}

// 3. 넘어온 변수 검사
if(trim($_POST[first]) == ""){
    ?>
    <script>
        alert("first");
        history.back();
    </script>
    <?
    exit;
}

if(trim($_POST[last]) == ""){
    ?>
    <script>
        alert("last");
        history.back();
    </script>
    <?
    exit;
}

if($_POST[email] == ""){
    ?>
    <script>
        alert("email");
        history.back();
    </script>
    <?
    exit;
}

if($_POST[password] == ""){
    ?>
    <script>
        alert("passwold");
        history.back();
    </script>
    <?
    exit;
}

if($_POST[password2] == ""){
    ?>
    <script>
        alert("passwold2");
        history.back();
    </script>
    <?
    exit;
}
if($_POST[m_pass] != $_POST[m_pass2]){
    ?>
    <script>
        alert("password missed.");
        history.back();
    </script>
    <?
    exit;
}

// 4. 같은 아이디가 있는지 검사
$query = "select * from USER where U_ID = '".trim($_POST[email])."'";
$result = mysqli_query($DB, $query);
$chk_data = mysqli_fetch_array($result);
// 5. 가입된 아이디가 있으면 되돌리기
echo $chk_data[0];
if($chk_data[U_ID]){
    ?>
    <script>
        alert("이미 가입된 아이디 입니다.");
        history.back();
    </script>
    <?
    exit;
}
// 6. 회원정보 적기
//보안 : salt 값 생성시 $,A 포함
//sha 256 등과 같은 알고리즘 적용해볼것
//보안과 관련해서 무엇을 이용하는지 어필용
$SALT = md5(rand(10, 99));
$SALTPASS = md5($_POST[password].$SALT);
$sql = "insert into USER (U_ID, U_FIRSTNAME, U_LASTNAME, U_AFFILIATION, U_ADDRESS, U_SALTPASS, U_SALTVALUE, LOGINCNT) values ('".trim($_POST[email])."', '".trim($_POST[first])."', '".trim($_POST[last])."', '".trim($_POST[affiliation])."', '".trim($_POST[address])."', '".trim($SALTPASS)."', '".$SALT."', '0')";
$result = $DB->query($sql);
// 7. 로그인 페이지로 보내기
?>
<script>
alert("You Joined.");
location.replace("login.php");
</script>
