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
<head>
    <title>QI Project</title>
	<script type="text/javascript" src="include.js"></script>
    
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      .navbar-brand {
          padding:3px 3px;
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

<div class="sidebar left">Hello World</div>
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
                            <li><a onClick="view_table();">Step 1</a></li>
                            <!-- Main Demo -->
                            <!-- Main Demo -->
                            <li><a onClick="view_map();">Step 2</a></li>
                            <!-- Main Demo -->
                            <!-- Main Demo -->
                            <li><a onClick="test();">Step 3</a></li>
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
    <div id="viewData">
    <div class="container content" >
        <div class="row">
            <!-- Begin Content -->
            <div>
                <!--Striped and Hover Rows-->
                <div class="row">
                    <!--Hover Rows-->
                    <div>
                        <div class="panel panel-yellow margin-bottom-40">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-gear"></i>USER INFORMATION [SAMPLE]</h3>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>FIRSTNAME</th>
                                        <th>LASTNAME</th>
                                        <th>ID</th>
                                        <th>SALTVALUE</th>
                                        <th>SALTPASS</th>
                                        <th>LOGINCNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <?php
                                        $query = "select * from USER";
                                        $result = mysqli_query($DB, $query);
                                        //$chk_data = mysqli_fetch_array($result);
                                        $i = 0;
                                        while ($row = $result->fetch_assoc()) {
                                            echo"<tr>";
                                            echo"<td>$i</td>";
                                            echo"<td>$row[U_FIRSTNAME]</td>";
                                            echo"<td>$row[U_LASTNAME]</td>";
                                            echo"<td>$row[U_ID]</td>";
                                            echo"<td>$row[U_SALTVALUE]</td>";
                                            echo"<td>$row[U_SALTPASS]</td>";
                                            echo"<td>$row[LOGINCNT]</td>";
                                            echo"</tr>";
                                            $i++;
                                        }
                                    
                                        /* free result set */
                                        $result->close();
                                        /*while($row = $chk_data->fetch_assoc ()) {
                                        
                                        }*/
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--End Hover Rows-->
                </div>
                <!--End Striped and Hover Rows-->

            </div>
            <!-- End Content -->
        </div>
        <img src="assets/img/LOOGO.png" style="width: 500px;" />
    </div><!--/container-->
    </div>
    <!--=== End Content Part ===-->
</div><!--/wrapper-->

<script type="text/javascript">
    jQuery(document).ready(function() {
      	App.init();
      	
       //$(".sidebar.left").sidebar().trigger("sidebar:open");
    });
	// 5.입력필드 검사함수
	function login_chk()
	{
		// 6.form 을 f 에 지정
		var f = document.loginForm;

		// 7.입력폼 검사
		if(f.m_id.value == ""){
			// 8.값이 없으면 경고창으로 메세지 출력 후 함수 종료
			alert("아이디를 입력해 주세요.");
			return false;
		}

		if(f.m_pass.value == ""){
			alert("비밀번호를 입력해 주세요.");
			return false;
		}

		// 9.검사가 성공이면 form 을 submit 한다
		f.submit();

	}
	function view_table(){
		$.ajax({
			url : 'table.php',
			success : function(data) {    
				 $('#viewData').html(data);
			return false;
			},
			error : function(xhr, ajaxOptions, thrownError) {
			return false;
			}
		});

	}
	function view_map(){
		//맵 보여주기 viewData 태그
	   $.ajax({
			url : 'map.php',
			success : function(data) {    
				 $('#viewData').html(data);
			return false;
			},
			error : function(xhr, ajaxOptions, thrownError) {
			return false;
			}
		});

		$("#viewData").height(document.documentElement.clientHeight-134).css({
			cursor: "auto"
		});
	}
	function view_fix(){
	   $.ajax({
			url : 'fix.php',
			success : function(data) {    
				 $('#viewData').html(data);
			return false;
			},
			error : function(xhr, ajaxOptions, thrownError) {
			return false;
			}
		});
	}
</script>
</body>
</html>