<?php
// require_once 'config.php';
//
// $visitor_count = 0;
// try
// {
//     if (!file_exists($databaseFile))
//     {
//         $createQuery = "CREATE TABLE 'online' ('id' TEXT PRIMARY KEY NOT NULL, 'page_title' TEXT, 'page_url' TEXT, 'last_activity' INTEGER)";
//     }
//
//     $db = new PDO("sqlite:$databaseFile");
//
//     if (isset($createQuery))
//     {
//         $db->query($createQuery);
//     }
// }
// catch (PDOException $e)
// {
//     echo $e->getMessage();
// }
// $result = $db->query('SELECT COUNT() AS visitors, COUNT(DISTINCT page_url) AS pages FROM online')->fetch(PDO::FETCH_ASSOC);
// $result = $db->query('SELECT page_title, page_url, COUNT(page_url) AS count FROM online GROUP BY page_url ORDER BY count DESC');

// if ($result)
// {
//     $result = $result->fetchAll(PDO::FETCH_ASSOC);

//     foreach ($result as $page)
//     {
//         // if (empty($page['page_title']))
//         // {
//         //     $page['page_title'] = $unknownPages;
//         // }
//         $visitor_count = $page[visitors];
//         // echo "<p><b></b><a href='$page[page_url]' target='_top'>$page[page_title]</a></p>";
//     }
// }

        // $visitor_count = $result[visitors];
// if ($page['visitors'] <= 1)
// {
//     console.log("visitor melebihi 1");
//     // $visitors = 1;
//     // $visitorWord = $visitorSingular;
// }

// if($visitor_count > 499 && !isset($_POST['simpan_pengguna'])){
//     echo "<script>alert('Jumlah pelawat pada ketika ini telah mencapai limit. Sila cuba sebentar lagi.')</script>";
//     echo "<script>window.location.href = 'http://www.gajimasyuk.com';</script>";
// }


//  if(!isset($_GET['testing'])){
//     echo "<script>alert('Kami sedang menaik-taraf Laman Web Gajimasyk. Sila cuba sebentar lagi.');</script>";
//     echo "<script>window.location.href = 'http://www.gajimasyuk.com';</script>";
// }
//  echo "<script>alert('Kami sedang menaik-taraf Laman Web Gajimasyk. Sila cuba sebentar lagi.');</script>";
// echo "<script>window.location.href = 'http://www.gajimasyuk.com';</script>";

require_once "db_con/connection.php"; //Establishing connection with our database
include 'mail.php';

$errors = '';
$username = '';
$name = '';
$address = '';
$email = '';
$membership_id = '';
$phone = '';
$ic_no = '';
$avatar = '';
$img_url_ = '';

if (isset($_POST['simpan_pengguna'])){
  $username = $_POST['username'];
  $name = $_POST['name'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $membership_id = $_POST['membership_id'];
  $phone = $_POST['phone'];
  $ic_no = $_POST['ic_no'];
  $avatar = $_FILES['avatar'];
  date_default_timezone_set("Asia/Kuala_Lumpur");
  $created_at = date("h:i:s A d/m/Y l");
  $img_url = '';

  if ($_POST['username'] != '' && $_POST['name'] != ''
        && ( isset($_POST['ic_no']) && $_POST['ic_no'] != '' )
    	  && $_POST['email'] != '' && $_POST['phone'] != '' && strlen($phone) >= 10 && strlen($phone) <= 11
      	&& $username == str_replace(' ', '', $username) && $_POST['setuju'] == 1 && ctype_alnum($username)){

        $result = mysqli_query($db, "SELECT * FROM user WHERE username = '$username'");
        $num_rows = mysqli_num_rows($result);
    if( $num_rows == 0 ) {
        // echo 'dah masyuk<br>';

         if(isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0){
          // echo 'dah masyuk upload pls<br>';
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
            // echo "VALUES('$username','$name','$address', '$email ','$membership_id','$phone','$ic_no','$img_url_uploaded'";
             $sql =  "INSERT INTO user
                     ( username,
                       name,
                       address,
                       email,
                       membership_id,
                       phone,
                       ic_no,
                       img_url)"
                     . " VALUES(
                       '$username',
                       '$name',
                       '$address ',
                       '$email',
                       '$membership_id ',
                       '$phone ',
                       '$ic_no',
                       '$img_url_uploaded')";


             if(mysqli_query($db, $sql))
             {
              // echo 'uploads img<br>';
               move_uploaded_file($file_tmp,"images/uploads/".$newfilename);
              echo 'masuk';
                $to = $email;
            //     $email_subject = "WEBSITE REPLIKA MMGUIA";
            //     $message = '<html><body align="center">';
            //     $message .= '<h2 style="text-align: center; "><font face="Verdana" color="#0000ff"><b>Assalamualaikum dan Salam Hormat, <br>Hai ' . strip_tags($name) . '!!!</b></font></h2>
            //     <h4 style="text-align: center; "><font face="Helvetica">Anda hanya selangkah lagi untuk memiliki web pemasaran paling masyuk abad ini. Jika anda ingin muat naik BUKTI GAMBAR RESIT  PEMBAYARAN yang telah anda buat, sila klik link dibawah.</font><br><br>
            //     <span style="text-align: center; "><a href="http://www.gajimasyuk.com/pengesahan-web/'.$username.'">Pembayaran Gaji Masyuk</a></span><br><br>
            //     <h4 style="text-align: center; "><font face="Helvetica">PERHATIAN : ANDA WAJIB MEMBUAT PEMBAYARAN DALAM TEMPOH 48JAM DARI MASA TEMPAHAN DIBUAT ('.$created_at.'). TEMPAHAN AKAN DIHAPUSKAN DARI SISTEM JIKA TIDAK MENERIMA PEMBAYARAN DALAM TEMPOH YANG DIBERIKAN.</font><br><br>
            //     <font face="Helvetica" color="#ff0000">SEMOGA BERJAYA!</font></h4><br><br><br>
            //     <span style="text-align: left; color: #ff0000;"  >This is a system generated email. Please do not reply to it. If you want to contact us, please reply to:</span>
            //     <span style="text-align: left; " >support@mmguia.com </span><br><br>';
            //     $message .= "</body></html>";
            //
            // //     $args_array =  'username='.$username.'&name='.$name.'&email='.$email.'&no_tel='.$no_tel.'&img_url='.$img_url_uploaded;
            //    smtpmailer($to, $name , 'info@gajimasyuk.com', 'Gajimasyuk', $email_subject, $message);
            // //   header("Location: http://www.gajimasyuk.com/pengesahan-web.php?$args_array");
            //         echo "<script>alert('TAHNIAH, PIHAK KAMI TELAH MENERIMA TEMPAHAN DARI ANDA, SILA SEMAK EMAIL ANDA SEGERA.');</script>";
            // 	    echo "<script>
            // 	        window.location.href = 'http://www.gajimasyuk.com/pengesahan-web/$username/';
            // 	    </script>";

            //   $args_array =  'username='.$username.'&name='.$name.'&email='.$email.'&no_tel='.$no_tel.'&img_url='.$img_url_uploaded;
            //   header("Location: pengesahan-web.php?$args_array");
            header("Location: registration.php");
             }

           }else{
             $errors = "<li>Terdapat isu dengan Gambar.</li>";
           }
         }
       else
       {
         $errors = "<li>Gambar wajib diisi.</li>";
       }
     }
      else{
		$errors = "<li>Username telah wujud.</li>";
         }
   }
   else{
 	 $errors = "Terdapat kesalahan semasa mengisi borang.<br>";
//  	 $errors .= $_POST['kp_passport']."<br>".$_POST['no_passport'];
	//  if($no_idp != $no_idp2 ){$errors .= "<li>Nombor IDP: Perlu SAMA dan 6 - 7 digit</li>";}
	 if(strlen($phone)<10 || strlen($phone)>11 ){$errors .= "<li>Nombor Telefon: 10 - 11 digit</li>";}
   if( isset($_POST['ic_no']) || strlen($ic_no) > 12 ) { $errors .= "<li>Nombor KP: 12 digit</li>";}
	 if($_POST['email'] != $_POST['email'] ){$errors .= "<li>Email tidak sepadan</li>";}
	 if($username != str_replace(' ', '', $username) || !ctype_alnum($username)){$errors .= "<li>Username: Satu Perkataan, Huruf Kecil, Tiada Jarak & Tiada Simbol</li>";}
	 if($_POST['setuju'] != 1 ){$errors .= "<li>Tidak Pilih Persetujuan Syarat</li>";}
   }

}


?>

<!-- <base href="/"> -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Form</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/bootstrap-fileinput/bootstrap-fileinput.css">
<!-- <link rel="stylesheet" href="https://use.fontawesome.com/8028381aa5.js"> -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="assets/components.min.css">
<link rel="stylesheet" href="css/registration.css">

	<div id="content" class="">


			<div class="row" id='margin-bottom-20'>
				<div class="col-md-12 text-center heading-borang padding-right-0">
				<img src="images/profile.png" height="100" width="100">
					<h1><strong>REGISTRATION FORM</strong></h1>
				</div>
    </div>

			<div class="row">
				<div class="col-sm-3 col-md-3 col-lg-4 padding-right-0">
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 padding-right-0">
          <div id="pengguna_form_container">
            <form id="pengguna_form" name="pengguna_form" role="form" method="post"  enctype="multipart/form-data" >
            <div class="row">
              <div class="col-md-12 padding-right-0">
              <div class="form-group" id='error-text'>
							<?php echo $errors; ?>
						</div>

                <div class="form-group">
                  <small><span id='if-error'></span></small>
                  <div class="input-group ">
                    <span class="input-group-addon" id="bg-white"><i class="fa fa-address-card" id="username-icon"></i>&nbsp;</span>
                    <input pattern="[a-zA-Z0-9]{5,15}" title="5 hingga 15 huruf" name="username" id="username" type="text" class="form-control" autocomplete="off" placeholder="Username" aria-describedby="basic-addon1"  value="<?php echo $username; ?>"  required>
                    <span class="input-group-addon">
                      <span id="user-availability-status">
                        <i class="fa fa-spinner fa-pulse fa-fw" id="loaderIcon" style="display:none"></i>
                        <i class="fa fa-question" id="question-icon" ></i>
                      </span>
                    </span>
                  </div>
                  <span class='errors input-error' id='error-text'>
		  <small>*Username: Capital Letter, a Sentences, No Number & No (.*$#!?) </small>
		  </noscript>
		  </span>
                </div>
                Name:
                <div class="form-group">
                  <div class="input-group ">
                    <span class="input-group-addon" id="bg-white"><i class="fa fa-user"></i></span>
                    <input name="name" id="name" type="text" class="form-control" autocomplete="off" placeholder="Your Name" aria-describedby="basic-addon1"  value="<?php echo $name; ?>" required>
                  </div>
                </div>
                Address:
                <div class="form-group">
                  <div class="input-group ">
                    <span class="input-group-addon" id="bg-white"><i class="fa fa-user"></i></span>
                    <input name="address" id="address" type="text" class="form-control" autocomplete="off" placeholder="Your Address" aria-describedby="basic-addon1"  value="<?php echo $address; ?>" required>
                  </div>
                </div>
                Email:
                <div class="form-group">
                  <div class="input-group ">
                    <span class="input-group-addon" id="bg-white"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    <input pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" name="email" id="email" type="email" class="form-control" autocomplete="off" placeholder="Your Email Address" aria-describedby="basic-addon1" value="<?php echo $email; ?>" required>
                    <span class="input-group-addon">
                      <span id="email-availability-status">
                        <i class="fa fa-spinner fa-pulse fa-fw" id="loaderIcon" style="display:none"></i>
                        <i class="fa fa-question" id="question-icon" ></i>
                      </span>
                    </span>
                  </div>
                  <span class='errors input-error' id='error-text'>
		                  <small>*Example: somebody@gmail.com</small>
              		  </noscript>
            		  </span>
                </div>
              Membership Number:
              <div class="form-group">
                <div class="input-group ">
                  <span class="input-group-addon" id="bg-white"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                  <input pattern="(?=.*\d).{,12}" name="membership_id" id="membership_id" type="number" class="form-control" autocomplete="off" placeholder="ex: 123456" aria-describedby="basic-addon1" value="<?php echo $membership_id; ?>">
              </div>
            </div>
              Telephone Number:
                <div class="form-group">
                  <div class="input-group ">
                    <span class="input-group-addon" id="bg-white"><i class="fa fa-phone" aria-hidden="true"></i></span>
                    <input name="phone" id="phone" type="number" class="form-control" autocomplete="off" placeholder="ex: 0123456789" aria-describedby="basic-addon1" value="<?php echo $phone; ?>" required>
                  </div>
                </div>
                IC Number:
              <div class="form-group">
                <div class="input-group ">
                  <span class="input-group-addon" id="bg-white"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                  <input pattern="(?=.*\d).{12}" name="ic_no" id="ic_no" type="number" class="form-control" autocomplete="off" placeholder="IC Number without (-)." aria-describedby="basic-addon1" value="<?php echo $ic_no; ?>">
              </div>
            </div>
                <div class="form-group">
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="row row-eq-height in-form-row">
                      <div class="col-xs-6 ">
                        <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                          <img src="images/default-avatar-male-3.png" alt="" /> </div>
                          <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                        </div>
                        <div class="col-xs-6">
                          <div>
                            <span id='upload_span'>Upload Your Picture</span>
                            <p><small>Best Dimension: <br>150px X 150px</small></p>
                            <p><small>Saiz: Not More Than 500kb</small></p>
                            <span class="btn default btn-file span6">
                              <span class="fileinput-new"> Select image </span>
                              <span class="fileinput-exists"> Change </span>
                              <input type="file" name="avatar" id="avatar"  required> </span>
                              <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                     <div class="form-group">
			<div class="input-group ">
				<span class="input-group-addon" id="bg-white"><i class="fa fa-gift" aria-hidden="true"></i>&nbsp; <small>Web Replika</small>&nbsp; RM</span>
				<input name="kos_pos" id="kos_pos" type="number" class="form-control" autocomplete="off" value='50.00' aria-describedby="basic-addon1" readonly=""><input name="kos_web" id="kos_web" type="hidden" value='30.00'>
			</div>
			<span><small> * RM50 once in a lifetime</small></span>
		</div>
		<div class="form-group" id='setuju-div'>
  		<input type="checkbox" name="setuju" id="setuju" value="1" /> I agree to register and the information given is accurate. If the information provided is wrong, I will bear the consequences of its own carelessness and I would not blame any party


                <div class="text-center">
                  <button type="submit" class="btn btn-yellow btn-lg btn-block" name="simpan_pengguna">SUBMIT</button>
                </div>
              </div>
            </div>
					</form>
          </div>
				</div>
			</div>
	</div> <!-- end content -->
</div> <!-- end page-wrap -->
<script type="text/javascript" src="js/jquery-3.2.0.min.js" charset="utf-8"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" charset="utf-8"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" charset="utf-8"></script> -->
<script src="https://use.fontawesome.com/8028381aa5.js" charset="utf-8"></script>
<script src="assets/bootstrap-fileinput/bootstrap-fileinput.js" charset="utf-8"></script>
<script src="js/form_validation.js" charset="utf-8"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- <link rel="stylesheet" href="js/registration.js"> -->
<script src="js/registration.js" charset="utf-8"></script>
