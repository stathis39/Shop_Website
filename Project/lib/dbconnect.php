<?php
$host='localhost';
$user='root';
$pass='';
$db='adise21_matrexa';
//require_once "config_local.php";

/*$con=mysqli_connect($host,$user,$pass,$db);
if($con)
    echo 'connected successfully to adise21_matrexa database';

//$user=$DB_USER;
//$pass=$DB_PASS;

*/

/* You should enable error reporting for mysqli before attempting to make a connection */

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $mysqli=new mysqli($host,$user,$pass,$db,null);

    /* Set the desired charset after establishing a connection */
    mysqli_set_charset($mysqli, 'utf8mb4');

?>