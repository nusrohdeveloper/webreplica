<?php
require_once "db_con/connection.php"; //Establishing connection with our database

if(!empty($_POST["email"])){
  $email = $_POST["email"];
  $result = mysqli_query($db, "SELECT * FROM user WHERE email = '$email'");
  $num_rows = mysqli_num_rows($result);
   if( $num_rows == 0 ) {
     echo 0;

   }else{
     echo 1;

   }


}else{
  echo "<i class='fa fa-question' style='color:yellow'></i>";
}
?>
