<?
// 1. 공통 인클루드 파일
include ("./include.php");

// 2. 로그인 안한 회원은 로그인 페이지로 보내기
if(!$_SESSION[user_id]){
    ?>
    <script>
        alert("로그인 하셔야 합니다.");
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

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Web Fonts -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin">

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- CSS Header and Footer -->
    <link rel="stylesheet" href="assets/css/headers/header-v8.css">
    <link rel="stylesheet" href="assets/css/footers/footer-v1.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="assets/plugins/animate.css">
    <link rel="stylesheet" href="assets/plugins/line-icons/line-icons.css">
    <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/plugins/login-signup-modal-window/css/style.css">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="assets/css/custom.css">
    <style>
        .navbar-brand {
            padding:3px 3px;
        }
    </style>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
      #viewData{
      height: 100%;
      }
    </style>
</head>

<body class="header-fixed header-fixed-space-v2 ">
<nav class="navbar navbar-inverse easy-sidebar">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle easy-sidebar-toggle" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="#">Point Data</a> 
    </div> 
  </div>
  <!-- /.container-fluid --> 
</nav>
<div class="container">
<h1>Bootstrap Easy Sidebar Example</h1>
<button class="btn btn-danger easy-sidebar-toggle">Toggle Sidebar</button>

<!-- JS Global Compulsory -->
<script type="text/javascript" src="assets/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery/jquery-migrate.min.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="assets/plugins/back-to-top.js"></script>
<script type="text/javascript" src="assets/plugins/smoothScroll.js"></script>
<script type="text/javascript" src="assets/plugins/modernizr.js"></script>
<script type="text/javascript" src="assets/plugins/jquery.parallax.js"></script>
<script type="text/javascript" src="assets/js/plugins/sidebar.js"></script>
<script src="assets/plugins/login-signup-modal-window/js/main.js"></script> <!-- Gem jQuery -->
<!-- JS Customization -->
<script type="text/javascript" src="assets/js/custom.js"></script>
<!-- JS Page Level -->
<script type="text/javascript" src="assets/js/app.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
    });
</script>

<script type="text/javascript" src="assets/plugins/backstretch/jquery.backstretch.min.js"></script>

<script>
$('.easy-sidebar-toggle').click(function(e) {
    e.preventDefault();
    $('body').toggleClass('toggled');
    $('.navbar.easy-sidebar').removeClass('toggled');
});
$('html').on('swiperight', function(){
    $('body').addClass('toggled');
});
$('html').on('swipeleft', function(){
    $('body').removeClass('toggled');
});

</script>
<!--[if lt IE 9]>
    <script src="assets/plugins/respond.js"></script>
    <script src="assets/plugins/html5shiv.js"></script>
    <script src="assets/plugins/placeholder-IE-fixes.js"></script>
<![endif]-->

</body>
</html>