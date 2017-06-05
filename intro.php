<?php

// require_once "db_con/connection.php"; //Establishing connection with our database
// include 'mail.php';


$intro_title = "Hi, Welcome to Our Page";

$nama = '';
$no_tel = '';
$no_kp = '';
$email = '';
$img_url = '';
$no_idp = '';
$status = '';
$username = '';

if (isset($_GET['username'])) {
  $username = $_GET['username'];
}
if (isset($_POS['username'])) {
  $username = $_POSt['username'];
}

$sql = mysqli_query($db,"SELECT * FROM user WHERE username = '$username'");
$row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
$nama = $row["nama"];
$no_tel = $row["no_tel"];
$no_kp = $row["no_kp"];
$email = $row["email"];
$img_url = $row["img_url"];
$no_idp = $row["no_idp"];
$status = $row["status"];
$username = $row["username"];

 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introduction</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/intro.css">
  </head>
  <body>
    <div class="row"  id="no-margin">
      <div class="col-sm-12 text-center ">
        <div class="heading-text-welcome">
          <span style="color: red;">WARNING!</span> <br> Please be ready if you want to change your life, let's start with watching this video!
        </div>
      </div>
    </div>
    <div class="row"  id="no-margin">
      <div class="col-sm-12 text-center video-section">
        <div class="video-wrap">
          <div class="video-container">
            <iframe  src="https://www.youtube.com/embed/xoXYe9e01_Y" frameborder="0" allowfullscreen></iframe>
            </iframe>
          </div>
        </div>
        <div class="text-under-video" id="text-under-video">
          <span  style="margin: 0 0 20px 0; color: #ffffff;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean <br>
            <span style="color: yellow;"> CALL TO ACTION LINE</span></span>
          </div>
          <div class="line">
          </div>
      </div>
    </div>
    <div class="intro-img">
      <div class="row" id="no-margin">
        <div class="col-sm-6">
          <img class="img-responsive center-block" src="images/intro-1.jpg" alt="" width="460">
        </div>
        <div class="col-sm-6">
          <img class="img-responsive center-block" src="images/intro-2.jpg" alt="" width="460">
        </div>
      </div>
    </div>
    <!-- <div class="row"  id="no-margin">
      <div class="col-sm-12 text-center">
        <div class="cta">
          <button class="btn btn-lg btn-block btn-success" type="button" name="button">Let Go</button>
        </div>
      </div>
    </div> -->

    <div class="row" id="no-margin">
      <div class="col-sm-12 text-center padding-right-0">
        <div class="text-borang">
          We secure your information and we directly personal message this page owner!<br>
            You should be ready, after you fill this form we sure you will be amazed! <br>
    		</div>
        <div class="text-borang-bottom">
          Enter your name, contact number and email, BE READY FOR THE NEXT STEP
    		</div>
      </div>
    </div>
		<div class="row padding-bottom-20" id="no-margin">
		 <div class="col-sm-2 col-md-2 col-lg-3">

		 </div>
		 <div class="col-sm-8 col-md-8 col-lg-6 padding-right-0">
			 <div class="borang" id="welcome_form_container">
				 <form id="welcome_form" name="welcome_form" role="form" method="post" onsubmit="return validateFormProspek();"  >
						<div class="form-group">
							<div class="input-group ">
								<span class="input-group-addon" id="bg-white"><i class="fa fa-user"></i></span>
								<input name="nama_prospek" id="nama_prospek" type="text" class="form-control" autocomplete="off" placeholder="Nama" aria-describedby="basic-addon1" >
							</div>
						</div>
						<div class="form-group">
							<div class="input-group ">
								<span class="input-group-addon" id="bg-white"><i class="fa fa-whatsapp"></i></span>
								<input name="whatsapp" id="whatsapp" type="number" minlength=10 class="form-control" autocomplete="off" placeholder="No. Whatsapp / No. Telefon" aria-describedby="basic-addon1" >
							</div>
						</div>
						<div class="form-group">
							<div class="input-group ">
								<span class="input-group-addon" id="bg-white"><i class="fa fa-envelope"></i></span>
								<input name="email_prospek" id="email_prospek" type="email" class="form-control" autocomplete="off" placeholder="Email" aria-describedby="basic-addon1" >
							</div>
						</div>

						 <div class="margin-top-10">
							 <!-- <input type="hidden" name="email_to" value=<?php echo $email; ?>> -->
							 <!-- <input type="hidden" name="username" value=<?php echo $username; ?>> -->
								 <input class="btn btn-success btn-block" type="submit" id="btn-notify" name="notify_member" value="SUBMIT">
						 </div>
				 </form>
			 </div>
		 </div>

  </body>

  <script src="https://use.fontawesome.com/8028381aa5.js" charset="utf-8"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" charset="utf-8"></script>

</html>
