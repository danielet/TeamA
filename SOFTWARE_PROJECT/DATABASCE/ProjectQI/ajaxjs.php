<?php
    // 1. 공통 인클루드 파일 
    include ("./include.php");

    // Fetching Values From URL
    $mail = $_POST['email'];
    $query = "select * from USER where U_ID = '".$mail."'";
    $result = mysqli_query($DB, $query);
    $chk_data = mysqli_fetch_array($result);
    // 5. 가입된 아이디가 있으면 되돌리기
    echo $chk_data[0];
?>