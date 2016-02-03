<?
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 로그인한 회원은 뒤로 보내기
if($_SESSION[user_id]){
    ?>
    <script>
        alert("You already logined.");
        history.back();
    </script>
    <?
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
    <form name="registForm" method="post" action="./join_server.php" style="margin:0px;">
        <!--Reg Block-->
        <div class="reg-block">
            <div class="reg-block-header">
                <h2>Sign Up</h2>
            </div>
            <div class="input-group margin-bottom-20">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" name="first" class="form-control" placeholder="First name">
            </div>
            <div class="input-group margin-bottom-20">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" name="last" class="form-control" placeholder="Last name">
            </div>
            <div class="input-group margin-bottom-20">
                <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                <input type="text" name="address" class="form-control" placeholder="Address">
            </div>
            <div class="input-group margin-bottom-20">
                <span class="input-group-addon"><i class="fa fa-empire"></i></span>
                <input type="text" name="affiliation" class="form-control" placeholder="affiliation">
            </div>
            <div class="input-group margin-bottom-20">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Email">
                <input type="button" name="id" data-toggle="modal"  data-target="#responsive" class="btn-u btn-block" value="Check">

                    <div class="modal fade" id="responsive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" name="xbtn" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel4">Responsive Modal</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Check E-mail</h4>
                                            <p><input class="form-control" type="text" name="checkemail"  /></p>
                                            <div id="label_email"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn-u btn-u-sea" onClick="check_email();">Search</button>
                                    <button type="button" class="btn-u btn-u-primary" data-dismiss="modal" onClick="use_email();">Use it!</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Bootstrap Modals With Forms -->
            </div>
            <div class="input-group margin-bottom-20">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="input-group margin-bottom-30">
                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                <input type="password" name="password2" class="form-control" placeholder="Confirm Password">
            </div>
            <hr>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <!--멤버 저장 목적-->
                    <button type="submit" class="btn-u btn-block" onClick="member_save();">Register</button>
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

</body>
</html>
<script type="text/javascript">
// 5.입력필드 검사함수
//함수명_변경
function member_save()
{
    // 6.form 을 f 에 지정
    var f = document.registForm;

    // 10.검사가 성공이면 form 을 submit 한다
    f.submit();

}
function check_email(){
    var value = document.getElementsByName("checkemail")[0].value;
    $.ajax({
        type: 'POST',
        url: 'ajaxjs.php',
        data: {
            'email': value
        },
        success: function(value){
            if(value.toString() == ""){
                document.all("label_email").innerHTML="It can be use";
            }else{
                document.all("label_email").innerHTML="It can't be use";
            }
        }
    });
}
function use_email(){
    if($('#label_email').html() == "It can be use"){
        $('input[name="email"]').val($('input[name="checkemail"]').val());
    }
}
</script>
