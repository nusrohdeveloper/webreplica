<?php
require 'connection.php';
// include('check_role.php');
session_start();
date_default_timezone_set("Asia/Kuala_Lumpur");


$user_check=$_SESSION['login_user'];

$sql = mysqli_query($db,"SELECT access_level, username FROM login WHERE username='$user_check' ");

$row=mysqli_fetch_array($sql,MYSQLI_ASSOC);

$login_user=$row['username'];
// $role=check_role($row['access_level']);

if(!isset($_SESSION['role']))
{
  header("Location: ../index.php");
}

if($_SESSION['role'] != $role)
{
  header("Location:  ../".$_SESSION['role']."/index.php" );
}

if(!isset($user_check))
{
  header("Location: ../index.php");
}
