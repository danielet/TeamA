<?
// config
$db_host = "localhost";
$db_user = "root";
$db_pass = "apmsetup";
$db_name = "airoundu";

// sqlconnection
function sql_connect($db_host, $db_user, $db_pass, $db_name)
{
    $my_db = new mysqli($db_host,$db_user,$db_pass,$db_name);
    mysqli_query($my_db,"set names utf8");
    if ( mysqli_connect_errno() ) {
        echo mysqli_connect_error();
        exit;
    }
    return $my_db;
}

?>