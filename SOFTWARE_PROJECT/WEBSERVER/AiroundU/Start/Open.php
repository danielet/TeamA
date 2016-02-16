<?php
    include ("../server/include.php");
    if($_SESSION[USER_ID]){
    ?>
	<script>
	alert("You already logined.");
	location.replace("Main.php");
	</script>
    <?
   }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="utf-8">
    <title>AiroundU</title>
    <script src="../Resource/Scripts/app.js"></script>

    <script>
      var map;
      function initMap() {

      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0TpDbluv-HUkadtVlsV9kiwZJ8mHrkE0&callback=initMap"
            async defer></script><script src="Open.view.js"></script>
    <script src="Open.app.js"></script>
    <style type="text/css">
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #map {
            height: 100%;
        }
        /*.x-btn-icon .buttonCassaCon {
            background-image: url('../Resource/Themes/login.png') !important;
            background-size:cover; 
            border: 1px solid #2571be;
        }*/
        .buttonCassaCon {
            width:50px!important; height:50px!important;
            background-image: url('../Resource/Themes/login.png') !important; background-color: #ffffff; border:none;
            background-size:cover; background-repeat:no-repeat;
        }
        .x-btn-over {
            background-color: #E2EFF8 !important;
        }
        /*.adminImg {
            width:100px!important; height:100px!important;
            background-image: url('../Resource/Themes/administrator.png') !important; background-color: #ffffff; border:none;
            background-size:cover; background-repeat:no-repeat;
        }*/
    </style>
</head>
<body>

</body>
</html>
