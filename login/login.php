<?php
include("db_con/connection.php"); //Establishing connection with our database
include('db_con/check_role.php');
session_start();

$error = ""; //Variable for storing our errors.
if(isset($_POST["submit"]))
{
  if(empty($_POST["username"]) || empty($_POST["password"]))
  {
    $error = "Both fields are required.";
  }else
  {
    // Define $username and $password
    $username=$_POST['username'];
    $password=$_POST['password'];

    // To protect from MySQL injection
    $username = stripslashes($username);
    $password = stripslashes($password);
    $username = mysqli_real_escape_string($db, $username);
    $password = mysqli_real_escape_string($db, $password);

    //Check username and password from database
    $sql="SELECT * FROM login WHERE username='$username' and password='$password'";
    $result=mysqli_query($db,$sql);

    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

    //If username and password exist in our database then create a session.
    //Otherwise echo error.
    if(mysqli_num_rows($result) == 1)
      {
        $_SESSION['login_user'] = $row['username']; // Initializing Session
        $role = check_role($row['access_level']);
        $_SESSION['role'] = $role;// Initializing Session Role

        // if($row['access_level'] == '8')
        // {
        header("location: $role/index.php"); // Redirecting To Other Page
        // }
        // else
        // {
        //   header("location: pengedar/profile.php"); // Redirecting To Other Page
        // }
      }
    else
      {
        $error = "Username atau Password Salah, Sila cuba lagi.";
      }
    }
  }
?>
