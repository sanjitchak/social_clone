<?php
ob_start();
session_start();
$timezone = date_default_timezone_set("Asia/Kolkata") ;
$conn = mysqli_connect("localhost","root","","social");
if(mysqli_connect_errno())
{
    echo "Cannot connect :". mysqli_connect_errno();
}

?>