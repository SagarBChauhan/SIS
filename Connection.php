<?php
$host="localhost";
$user="root";
$password="root";
$database="SIS";
$con=mysqli_connect($host, $user, $password, $database);
if($con)
{
    $con_status='Server Online';
}
else
{
    $con_status='Server Online';
}
