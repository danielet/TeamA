<?php
//타이머시에도 상수로 등록 한후 사용
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 로그인한 회원은 뒤로 보내기
if($_SESSION[user_id]){
    ?>
    <script>
        alert("You already logined.");
        location.replace("main.php");
    </script>
    <?php
}
?>
<!DOCTYPE html>
<head>
    <title>QI Project</title>

	<script type="text/javascript" src="include.js"></script>
</head>

<body>
<!--=== Content Part ===-->
<div class="container">
    <form name="registForm" method="post" action="./login_server.php" style="margin:0px;">
        <!--Reg Block-->
        <div class="reg-block">
            <div class="reg-block-header">
                <h2><p>Hallo~ Sandiego</p> Sign In</h2>
                <p>Don't Have Account? Click <a class="color-green" href="join.php">Sign Up</a> to registration.</p>
            </div>

            <div class="input-group margin-bottom-20">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="text" class="form-control" name="id" placeholder="Email">
            </div>
            <div class="input-group margin-bottom-20">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Password">
            </div>
            <hr>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <button type="submit" class="btn-u btn-block" onClick="login();">Log In</button>

                </div>
            </div>
        </div>
        <!--End Reg Block-->
    </form>
</div><!--/container-->
<!--=== End Content Part ===-->

<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
    });
	
    $.backstretch([
      "assets/img/bg/90.jpg",
      "assets/img/bg/91.jpg",
      "assets/img/bg/9.jpg",
      "assets/img/bg/93.jpg",
      ], {
        fade: 1000,
        duration: 4000
    });
</script>
<!--[if lt IE 9]>
    <script src="assets/plugins/respond.js"></script>
    <script src="assets/plugins/html5shiv.js"></script>
    <script src="assets/plugins/placeholder-IE-fixes.js"></script>
<![endif]-->

</body>
</html>
<script>
// 5.입력필드 검사함수
function login()
{
    // 6.form 을 f 에 지정
    var f = document.registForm;

    // 10.검사가 성공이면 form 을 submit 한다
    f.submit();

}
function join (){

}
</script>
