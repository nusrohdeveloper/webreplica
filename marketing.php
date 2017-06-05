<?php

require_once "db_con/connection.php";

$id_prefered = '';
$error = '';
//agent variables
$agent_username = '';
$agent_membership_id = '';
$agent_name = '';
$agent_email = '';
$agent_phone = '';
$img_url = '';

//user variables
$username = '';
$name = '';
$ic_no = '';
$email = '';
$membership_id= '';
$phone = '';
$status = '';
$address = '';
$zip_code = '';
$city = '';
$state = '';
$errors = '';
$sql = '';

if (($_SERVER['REQUEST_METHOD'] == 'GET' || ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agent_username']) )) && $_GET['username'] != '' ){


    if (isset($_GET['username'])) {
		$findme = $_GET["username"];
	}
	if (isset($_POST['agent_username'])) {
		$findme = $_POST["agent_username"];
	}


  $sql = mysqli_query($db,"SELECT * FROM user WHERE username = '$findme'");
  $row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
  $agent_name = $row['name'];
 	$agent_email = $row['email'];
 	$agent_phone = $row['phone'];
 	$agent_membership_id = $row['membership_id'];
 	$img_url = $row['img_url'];
 	$agent_username = $row['username'];
 	$status = $row['status'];

	 if($status != '1' & ($agent_membership_id != '' || $agent_membership_id != '88888888')){
	    echo "<script>alert('SORRY, NOT AVAILABLE IN USER NAME LIST.');</script>";
	    // header("Location: marketing.php?");
	   //wp_redirect( home_url(), 301 );
	  //  exit();
	 }
}else {
  // header("Location: marketing.php?");
  // die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	  $username = $_POST['username'];
	  $name= $_POST['name'];
	  $ic_no= $_POST['ic_no'];
	  $email = $_POST['email'];
	  $phone = trim($_POST['phone']);
	  $address = $_POST['address'];
	  $zip_code = $_POST['zip_code'];
	  $city = $_POST['city'];
	  $state = $_POST['state'];
	  $fulladdress = $address . ", " . $zip_code. " " . $city . ", " . $state;
    $errors_uploading= array();
	  $agent_membership_id = $_POST['agent_membership_id'];
	  $agent_usernamea = trim($_POST['agent_username']);
	  $agent_email = $_POST['agent_email'];
	  $agent_phone = $_POST['agent_phone'];
	  date_default_timezone_set("Asia/Kuala_Lumpur");
	  $created_at = date("h:i:s A d/m/Y l");


  if ($_POST['username'] != '' && $_POST['name'] != ''
  && ( isset($_POST['ic_no']) && $_POST['ic_no'] != '' )
  && $_POST['email'] != '' && $_POST['email'] && $_POST['phone'] != '' && $_POST['address'] != ''
  && $_POST['zip_code'] != '' && strlen($phone) >= 10 && strlen($phone) <= 11 && ctype_digit($phone)
  && (strlen($ic_no) == 12 )
  && $username == str_replace(' ', '', $username) && $_POST['agree'] == 1 && ctype_alnum($username)){

   $result = mysqli_query($db, "SELECT * FROM user WHERE username = '$username'");
   $num_rows = mysqli_num_rows($result);
   if (empty($row)){
    $id_prefered = 'member001';
    }
    else {
      preg_match('/[a-z]{6}(\d{3})/', $row['membership_id'], $matches);
      $membership_id = $matches[1] + 1 ;
      $id_prefered ='member'.sprintf('%03d',$membership_id);

    }
  	if( $num_rows == 0 ) {

      if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0){
        $file_name = $_FILES['avatar']['name'];
        $file_size =$_FILES['avatar']['size'];
        $file_tmp =$_FILES['avatar']['tmp_name'];
        $file_type=$_FILES['avatar']['type'];
        $tmp = explode('.', $file_name);
        $file_extension = end($tmp);
        $newfilename = round(microtime(true)) . '.' . $file_extension;
        $file_ext=strtolower($file_extension);

        $expensions= array("jpeg","jpg","png");

        if(in_array($file_ext,$expensions)=== false){
           $errors_uploading[]="extension not allowed, please choose a JPEG or PNG file.";
        }

        if($file_size > 2097152){
           $errors_uploading[]='File size must be excately 2 MB';
        }

        $img_url_uploaded = $newfilename;

        if(empty($errors_uploading)==true){
            $sql =  "INSERT INTO user
                  (username, name, address, ic_no, email, phone, created_at, membership_id, status, img_url)"
                  . " VALUES('$username','$name', '$fulladdress ', '$ic_no', '$email ', '$phone ', '$created_at', '$id_prefered', '1', '$img_url_uploaded')";

          if(mysqli_query($db, $sql))
          {
              move_uploaded_file($file_tmp,"images/uploads/".$newfilename);
              $args_array =       'username='.$username.'&name='.str_replace(' ', '-', $name).'&email='.$email.
    		                    '&phone='.$phone.'&address='.str_replace(' ', '-', $fulladdress).
                        		'&agent_usernamea='.$agent_username.'&email='.$email.
                        		'&phone='.$phone.'&membership_id='.$agent_membership_id .'&img_url='.$img_url.'&ic_no='.$ic_no;

          //   message phpmailer
          //   $to = $email;
          //   $email_subject = "WEB REPLICA";
          //   $message = '';
          //   $message .= '';
          //   $message .= "</body></html>";
          //
          //   smtpmailer($to, $nama , 'info@gajimasyuk.com', 'Gajimasyuk', $email_subject, $message);
          //   echo "<script>alert('TAHNIAH, PIHAK KAMI TELAH MENERIMA TEMPAHAN DARI ANDA, SILA SEMAK EMAIL ANDA SEGERA..');</script>";
    	    // echo "<script>
    	    //     window.location.href = 'http://www.gajimasyuk.com/pengesahan.php?$args_array';
    	    // </script>";
              }

        }else{
          $errors = "<li>There are issues with the picture.</li>";
        }
      }
      else
      {
        $errors = "<li>Profile picture is required.</li>";
      }
  	}else{
  		$errors = "<li>Username already exists.</li>";
  	}
    }else{
    	 $errors = "There is a mistake when filling in the form.";
	 if(strlen($phone)<10 || strlen($phone)>11 ){$errors .= "<li>Phone Number: 10 - 11 digits</li>";}
	 if(!ctype_digit($phone) ){$errors .= "<li>Phone Number: Number only without special character</li>";}
	 if( isset($_POST['ic_no']) && ( strlen($ic_no) < 12 || strlen($ic_no) > 12 ) ){ $errors .= "<li>ID Number: 12 digits</li>";}
	 if($username != str_replace(' ', '', $username) || !ctype_alnum($username)){$errors .= "<li>Username: One word, lowercase, no space and no special character</li>";}
	 if(strlen($zip_code) < 5 || strlen($zip_code) > 5 ){$errors .= "<li>Address (Zip Code): 5 digits</li>";}
	 if($_POST['agree'] != 1 ){$errors .= "<li>Not choose terms approval</li>";}

  }
 }
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="" />
    <meta http-equiv="pragma" content="no-cache" />
    <title><?php echo $agent_username; ?>@webreplica.com</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap-fileinput/bootstrap-fileinput.css">
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/8028381aa5.js"> -->

  </head>
  <body>
		<div class="card hovercard">
			<div class="row"  id="no-margin">
				<div class="col-sm-5">
          <?php
              if ($img_url !='' && strpos($img_url, 'webreplica') == false) {
                  $img_url = "images/uploads/$img_url";
              } else {
                  $img_url = "images/default-avatar-male-3.png";
              }
            // if (strpos($img_url, 'images/uploads') == false) {
            //     $img_url = "../images/uploads/$img_url";
            // }
           ?>
					<div class="avatar text-xs-center"><img src=<?php echo $img_url; ?>></div>
				</div>
				<div class="col-sm-7 heading-text ">
					<span class="heading-top  ">Welcome, I'm your agent.</span>
					<div class="row" id="no-margin-top">
						<div class="col-xs-12">
							<div class="avatar-desc ">
								<span class="lg-left">Name <?php echo $agent_name; ?></span><br>
								<span class="lg-left">Membership ID: <?php echo $agent_membership_id; ?></span><br>
								<span class="lg-left">Phone: <?php echo $agent_phone; ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
   <div id="page-wrap">
      <div id="content" class="text-center">
        <?php
            include '_marketing-images.php';
         ?>
	    </div> <!-- end page-wrap -->
   </div>
	 <br>
	 <div class="row padding-bottom-20" id="no-margin">
		 <div class="col-sm-3 col-md-3 col-lg-4">

		 </div>
		 <div class="col-sm-6 col-md-6 col-lg-4 padding-right-0">
			 <div id="user_form_container">
         <form id="user_form" name="user_form" role="form" method="post"   enctype="multipart/form-data">
          <div class="row"  id="no-margin">
           <div class="col-md-12 ">
             <h4>User Information</h4>
             <hr>
           </div>
          </div>

           <div class="form-group" id='error-text'>
             <?php echo $errors; ?>
           </div>
           <div class="form-group">
             <div class="input-group ">
               <span class="input-group-addon" id="bg-white"><i class="fa fa-user"></i></span>
               <input name="name" id="name" type="text" class="form-control" autocomplete="off" placeholder="Name" aria-describedby="basic-addon1" value="<?php echo $name ; ?>" required>
             </div>
           </div>
           <div class="form-group">
             <div class="input-group ">
               <span class="input-group-addon" id="bg-white"><i class="fa fa-address-card" aria-hidden="true"></i></span>
               <input name="ic_no" id="ic_no" type="number" class="form-control" autocomplete="off" placeholder="ID Number" aria-describedby="basic-addon1" value="<?php echo $ic_no; ?>" required>
             </div>
           </div>
            <div class="form-group" id="address">
                <div class="row no-gutters" id="no-margin" >
                  <div class="col-md-12 padding-right-0">
                    <div class="input-group ">
                      <span class="input-group-addon" id="bg-white"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                      <input name="address" id="address" type="text" class="form-control" autocomplete="off" placeholder="Address" aria-describedby="basic-addon1" value="<?php echo $address; ?>" required>
                    </div>
                  </div>
                </div>
                <div class="row margin-top-10" id="no-margin">
                  <div class="col-xs-4 padding-right-0">
                    <input id = "zip_code" name = "zip_code" type="number" autocomplete="off" placeholder="Zip Code" class="form-control" value="<?php echo $zip_code; ?>" required/>
                  </div>
                    <div class="col-xs-8 padding-right-0">
                      <input id = "city" name = "city" type="text" autocomplete="off" placeholder="City / Province" class="form-control" value="<?php echo $city; ?>"  required/>
                    </div>
                </div>
                <div class="row margin-top-10"  id="no-margin">
                  <div class="col-md-12 padding-right-0">
                    <select id = "state" name = "state" class="form-control" required>
                      <option value="">State</option>
                      <option value="Perlis">Perlis</option>
                      <option value="Kedah">Kedah</option>
                      <option value="Pulau Pinang">Pulau Pinang</option>
                      <option value="Perak">Perak</option>
                      <option value="Pahang">Pahang</option>
                      <option value="Selangor">Selangor</option>
                      <option value="Kuala Lumpur">Kuala Lumpur</option>
                      <option value="Puterajaya">Puterajaya</option>
                      <option value="Negeri Sembilan">Negeri Sembilan</option>
                      <option value="Melaka">Melaka</option>
                      <option value="Labuan">Labuan</option>
                      <option value="Johor">Johor</option>
                      <option value="Kelantan">Kelantan</option>
                      <option value="Terengganu">Terengganu</option>
                      <option value="Sabah">Sabah</option>
                      <option value="Sarawak">Sarawak</option>
                    </select>
                  </div>
                </div>
            </div>
            <div class="form-group">
              <div class="input-group ">
                <span class="input-group-addon" id="bg-white"><i class="fa fa-phone" aria-hidden="true"></i></span>
                <input name="phone" id="phone" type="number" class="form-control" autocomplete="off" placeholder="Phone Number" aria-describedby="basic-addon1" value="<?php echo $phone; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <small><span id='email-if-error'></span></small>
              <div class="input-group ">
                <span class="input-group-addon" id="bg-white"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                <input name="email" id="email" type="email" class="form-control" autocomplete="off" placeholder="E-Mail" aria-describedby="basic-addon1" value="<?php echo $email; ?>" required>
                <span class="input-group-addon">
                  <span id="email-availability-status">
                    <i class="fa fa-spinner fa-pulse fa-fw" id="loaderIcon" style="display:none"></i>
                    <i class="fa fa-question" id="question-icon" ></i>
                  </span>
                </span>
              </div>
              <span class='errors input-error' id='error-text'>
              <small>*E-Mail: someone@example.com</small>
              </span>
            </div>
            <div class="row"  id="no-margin">
               <div class="col-md-12 ">
                 <h4>Agent Information</h4>
                 <hr>
               </div>
             </div>
             <div class="form-group">
               <div class="input-group ">
                 <span class="input-group-addon" id="bg-white"><i class="fa fa-user-plus"></i></span>
                 <input name="agent_username" id="agent_username" type="text" class="form-control" autocomplete="off" value="<?php echo $agent_username; ?>" aria-describedby="basic-addon1" readonly="">
                 <input name="agent_email" id="agent_email" type="hidden" value=<?php echo $agent_email; ?>>
                 <input name="agent_phone" id="agent_phone" type="hidden" value=<?php echo $agent_phone; ?>>
               </div>
             </div>
             <div class="form-group">
               <div class="input-group ">
                 <span class="input-group-addon" id="bg-white"><i class="fa fa-id-badge"></i></span>
                 <input name="agent_membership_id" id="agent_membership_id" type="text" class="form-control" autocomplete="off" value="<?php echo $agent_membership_id; ?>" aria-describedby="basic-addon1" readonly="">
               </div>
             </div>
             <div class="row"  id="no-margin">
               <div class="col-md-12 ">
                 <h4>Web Replica Information</h4>
                 <hr>
               </div>
             </div>
             <div class="form-group">
               <small><span id='if-error'></span></small>
               <div class="input-group ">
                 <span class="input-group-addon" id="bg-white"><i class="fa fa-gift" id="username-icon"></i>&nbsp;
                 <small class="hidden-xs">webreplica.com/user/</small></span>
                 <input pattern="[a-zA-Z0-9]{5,15}" title="5 hingga 15 huruf" name="username" id="username" type="text" class="form-control" autocomplete="off" placeholder="Username" aria-describedby="basic-addon1" value="<?php echo $username; ?>" required>
                 <span class="input-group-addon">
                   <span id="user-availability-status">
                     <i class="fa fa-spinner fa-pulse fa-fw" id="loaderIcon" style="display:none"></i>
                     <i class="fa fa-question" id="question-icon" ></i>
                   </span>
                 </span>
               </div>
               <span class='errors input-error' id='error-text'>
               <small>*Username: One word, no space, lowercase & no (. * $ # !?) </small>
               </span>
               <small><span class='errors input-error-2' id='error-text'><span></small>
             </div>
             <div class="form-group">
                           <div class="fileinput fileinput-new" data-provides="fileinput">
                             <div class="row row-eq-height in-form-row" id="no-margin">
                               <div class="col-xs-6 ">
                                 <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                   <img src="images/default-avatar-male-3.png" alt="" /> </div>
                                   <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                    </div>
                                 </div>
                                 <div class="col-xs-6">
                                   <div>
                                     <span id='upload_span'>Profile Picture</span>
                                     <p><small>Best Dimension: <br>150px X 150px</small></p>
                                     <p><small>Size: Not More Than 500KB</small></p>
                                     <span class="btn default btn-file span6">
                                       <span class="fileinput-new"> Select image </span>
                                       <span class="fileinput-exists"> Change </span>
                                       <input type="file" name="avatar" id="avatar" required> </span>
                                       <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                     </div>
                                   </div>
                                 </div>
                               </div>
                             </div>
                       <div class="form-group" id='agree-div'>
                   <input type="checkbox" name="agree" id="agree" value="1"  required/> I agree to register and the information given is accurate. If the information provided is wrong, I will bear the consequences of its own negligence and I would not blame any party.
                    </div>

            <div class="margin-top-10">
             <input class="btn btn-success btn-block" type="submit" name="save_user"  id="save_user" value="REGISTER">
            </div>
        </form>
			 </div>
		 </div>
	 </div>
   <script type="text/javascript" src="js/jquery-3.2.0.min.js" charset="utf-8"></script>
   <script src="assets/bootstrap-fileinput/bootstrap-fileinput.js" charset="utf-8"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" charset="utf-8"></script>
   <script src="https://use.fontawesome.com/8028381aa5.js" charset="utf-8"></script>
   <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" charset="utf-8"></script>
   <script src="js/form_validation.js" charset="utf-8"></script>
</div>
  </body>
	</html>
