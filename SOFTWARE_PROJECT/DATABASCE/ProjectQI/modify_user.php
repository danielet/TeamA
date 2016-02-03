<?
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 로그인 안한 회원은 로그인 페이지로 보내기
if(!$_SESSION[user_id]){
    ?>
    <script>
        alert("You need login.");
        location.replace("login.php");
    </script>
    <?
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title>QI Project</title>
    <script type="text/javascript" src="include.js"></script>
    <style>
        .navbar-brand {
            padding:3px 3px;
        }
    </style>
</head>

<body class="header-fixed header-fixed-space-v2 ">
<div class="wrapper">
    <!--=== Header v8 ===-->
    <div class="header-v8 header-sticky">
        <!-- Topbar blog -->
        <div class="blog-topbar">
            <div class="topbar-search-block">
                <div class="container">
                    <form action="">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="search-close"><i class="icon-close"></i></div>
                    </form>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-xs-8">
                        <div class="topbar-time">Tuesday, Jan 26th 2016, Jack</div>
                        </ul>
                    </div>
                    <div class="col-sm-4 col-xs-4 clearfix">
                        <i class="fa fa-search search-btn pull-right"></i>
                        <ul class="topbar-list topbar-log_reg pull-right visible-sm-block visible-md-block visible-lg-block">
                            <li class="cd-log_reg home"><a class="cd-signin" href="./logout.php">Logout</a></li>
                            <li class="cd-log_reg"><a class="cd-signin" href="./modify_pass.php">Change Password</a></li>
                            <li class="cd-log_reg"><a class="cd-signup" href="./modify_user.php">UserInfo</a></li>
                        </ul>
                    </div>
                </div><!--/end row-->
            </div><!--/end container-->
        </div>
        <!-- End Topbar blog -->

        <!-- Navbar -->
        <div class="navbar mega-menu" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="res-container">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <div class="navbar-brand">
                        <a href="main.php">
                            <img src="assets/img/qi.jpg" alt="Logo">
                        </a>
                    </div>
                </div><!--/end responsive container-->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-responsive-collapse">
                    <div class="res-container">
                        <ul class="nav navbar-nav">

                            <!-- Main Demo -->
                            <li><a>Step 1</a></li>
                            <!-- Main Demo -->
                            <!-- Main Demo -->
                            <li><a>Step 2</a></li>
                            <!-- Main Demo -->
                            <!-- Main Demo -->
                            <li><a>Step 3</a></li>
                            <!-- Main Demo -->
                        </ul>
                    </div><!--/responsive container-->
                </div><!--/navbar-collapse-->
            </div><!--/end contaoner-->
        </div>
        <!-- End Navbar -->
    </div>
    <!--=== End Header v8 ===-->

    <!-- End Interactive Slider v2 -->

    <!--=== Content Part ===-->
    <?
        $sql = "select * from USER where U_ID = '".trim($_SESSION[user_id])."'";
        $result = mysqli_query($DB, $sql);
        $chk_data = mysqli_fetch_array($result);
        
    ?>
    <div class="container content">
        <div class="row">
            <!-- Begin Content -->
            <div>
                <!-- Horizontal Form -->
                <div class="row">
                    <div class="panel panel-red margin-bottom-40">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-adjust"></i> USER INFO CHANGE </h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" name="registForm" method="post" action="./modify_user_server.php" role="form">
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 control-label">Id</label>
                                    <div class="col-lg-10"  style="padding-top: 7px;">
                                        <?php 
                                    echo $_SESSION[user_id];
                                    ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword1" class="col-lg-2 control-label">FIRSTNAME</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="first" class="form-control" id="first" placeholder="first name here" value="<?echo$chk_data[U_FIRSTNAME];?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword2" class="col-lg-2 control-label">LASTNAME</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="last" class="form-control" id="last" placeholder="last name here" value="<?echo$chk_data[U_LASTNAME];?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button type="submit" class="btn-u btn-u-red" onClick="userinfo_change();">Change User Info</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Horizontal Form -->
            </div>
        </div>
    </div>
    <!--/container-->
    <!--=== End Content Part ===-->
</div><!--/wrapper-->
<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
    });
</script>

<script>
// 5.입력필드 검사함수
function userinfo_change()
{
    // 6.form 을 f 에 지정
    var f = document.registForm;
    f.submit();

}
</script>
<!--[if lt IE 9]>
    <script src="assets/plugins/respond.js"></script>
    <script src="assets/plugins/html5shiv.js"></script>
    <script src="assets/plugins/placeholder-IE-fixes.js"></script>
<![endif]-->

</body>
</html>