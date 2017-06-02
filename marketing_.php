<?php
//  if(!isset($_GET['testing'])){
//     echo "<script>alert('Kami sedang menaik-taraf Laman Web Gajimasyk. Sila cuba sebentar lagi.');</script>";
//     echo "<script>window.location.href = 'http://www.gajimasyuk.com';</script>";
// }
require_once "db_con/connection.php"; //Establishing connection with our database
include 'mail.php';

$errors ='';
$nama = '';
$email = '';
$no_tel = '';
$no_idp = '';
$img_url = '';
$username_penaja = '';

// prospek varibles
$username = '';
$nama_prospek = '';
$no_kp = '';
$no_passport = '';
$email_prospek = '';
$no_tel_prospek = '';
$status = '';
$alamat1 = '';
$poskod = '';
$daerah = '';
$negeri = '';
$errors = '';
$sql = '';

if (($_SERVER['REQUEST_METHOD'] == 'GET' || ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username_penaja']) )) && $_GET['username'] != '' ){


    if (isset($_GET['username'])) {
		$findme = $_GET["username"];
	}
	if (isset($_POST['username_penaja'])) {
		$findme = $_POST["username_penaja"];
	}


  $sql = mysqli_query($db,"SELECT * FROM wp_members_idp WHERE username = '$findme'");
  $row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
  $nama = $row['nama'];
 	$no_ic = $row['no_kp'];
 	$email = $row['email'];
 	$no_tel = $row['no_tel'];
 	$no_idp = $row['no_idp'];
 	$img_url = $row['img_url'];
 	$username_penaja = $row['username'];
 	$status = $row['status'];
 // 	$status = $r->status;
  // $nama = $row["nama"];
  // $no_tel = $row["no_tel"];
  // $email = $row["email"];
  // $alamat = $row["alamat"];
  // // $poskod = $row["poskod"];
  // // $daerah = $row["daerah"];
  // // $negeri = $row["negeri"];
  // $status = $row["status"];
  // $updated_at = $row["updated_at"];
  // $username = $row["username"];


	// $results = $wpdb->get_results(
	// 	$wpdb->prepare(
	// 		 $sql,
	// 		 $findme));
  // if(!empty($results)) {
	// 	foreach($results as $r) {
	// 	 $nama = $r->nama;
	// 	 $no_ic = $r->no_kp;
	// 	 $email = $r->email;
	// 	 $no_tel = $r->no_tel;
	// 	 $no_idp = $r->no_idp;
	// 	 $img_url = $r->img_url;
	// 	 $username_penaja = $r->username;
	// 	 $status = $r->status;
	// 	}
	// }
	 if($status != 'Selesai Bayaran' & ($no_idp != '' || $no_idp != '88888888')){
	    echo "<script>alert('MAAF, NAMA PENGGUNA TIDAK TERDAPAT DALAM SENARAI.');</script>";
	    echo "<script>
	        window.location.href = 'http://www.gajimasyuk.com';
	    </script>";
	   //wp_redirect( home_url(), 301 );
	  //  exit();
	 }
}else {
  header("Location: http://gajimasyuk.com");
  die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	  $username = $_POST['username'];
	  $nama_prospek = $_POST['nama'];
	  if (isset($_POST['no_ic'])) {
	    $no_kp = $_POST['no_ic'];
	  }
	  if (isset($_POST['no_passport'])) {
      $no_passport = $_POST['no_passport'];
	  }
	  // $no_passport = $_POST['no_passport'];
	  $kp_passport = $_POST['kp_passport'];
	  $email_prospek = $_POST['email_prospek'];
	  $email_prospek2= $_POST['email_prospek2'];
	  $no_tel_prospek = trim($_POST['no_tel_prospek']);
	  $alamat1 = $_POST['alamat1'];
	  $poskod = $_POST['poskod'];
	  $daerah = $_POST['daerah'];
	  $negeri = $_POST['negeri'];
	  $pakej = $_POST['pakej'];
	  $kos_pos = $_POST['kos_pos'];
	  $jumlah = $_POST['jumlah'];
	  $alamat = $alamat1 . ", " . $poskod . " " . $daerah . ", " . $negeri;
    $errors_uploading= array();
	  $no_idp_penaja = $_POST['no_idp'];
	  $username_penaja = trim($_POST['username_penaja']);
	  $email = $_POST['email'];
	  $no_tel = $_POST['no_tel'];
	  date_default_timezone_set("Asia/Kuala_Lumpur");
	  $created_at = date("h:i:s A d/m/Y l");

	  if($jumlah == ''){
	   if ($_POST['pakej']=='PAKEJ-3G'){
 	   	$jumlah = '110';
 	   }else{
 	    	$jumlah = '120';
 	   }
 	  // if($_POST['negeri'] == 'Sabah' || $_POST['negeri'] == 'Sarawak' || $_POST['negeri'] == 'Labuan'){
 	  //	$jumlah += '11';
 	  // }else{
 	  //	$jumlah += '7';
 	  // }
 	  }


  if ($_POST['username'] != '' && $_POST['nama'] != ''
  && ( isset($_POST['no_ic']) && $_POST['no_ic'] != '' && $_POST['kp_passport'] == 'no_ic' || isset($_POST['no_passport']) && $_POST['no_passport'] != '' && $_POST['kp_passport'] == 'no_passport' )
  && $_POST['email_prospek'] != '' && $_POST['email_prospek'] == $_POST['email_prospek2'] && $_POST['no_tel_prospek'] != '' && $_POST['alamat1'] != ''
  && $_POST['poskod'] != '' && $_POST['pakej'] != '' && strlen($no_tel_prospek) >= 10 && strlen($no_tel_prospek) <= 11 && ctype_digit($no_tel_prospek)
  && (strlen($no_passport) == 8 && $_POST['kp_passport'] == 'no_passport' || strlen($no_kp) == 12 && $_POST['kp_passport'] == 'no_ic' )
  && $username == str_replace(' ', '', $username) && $_POST['setuju'] == 1 && ctype_alnum($username)){
 	// all data cannot be empty

  	// search for username

   $result = mysqli_query($db, "SELECT * FROM wp_members_idp WHERE username = '$username'");
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
          // echo "VALUES('$username','$nama_prospek', '$alamat ', '$no_kp', '$email_prospek ', '$no_tel_prospek ', '$created_at', '88888888', 'Tiada Bayaran', '$img_url_uploaded', '$pakej', '$no_idp_penaja'";
          $sql =  "INSERT INTO wp_members_idp
                  (username, nama, alamat, no_kp, email, no_tel, created_at, no_idp, status, img_url, pakej, no_idp_penaja, no_passport)"
                  . " VALUES('$username','$nama_prospek', '$alamat ', '$no_kp', '$email_prospek ', '$no_tel_prospek ', '$created_at', '88888888', 'Tiada Bayaran', '$img_url_uploaded', '$pakej', '$no_idp_penaja', '$no_passport')";

          if(mysqli_query($db, $sql))
          {
            // echo 'uploads img<br>';
            move_uploaded_file($file_tmp,"images/uploads/".$newfilename);
            // echo 'sql executed<br>';
            $args_array =       'username='.$username.'&nama='.str_replace(' ', '-', $nama_prospek).'&email_prospek='.$email_prospek.
    		                    '&no_tel_prospek='.$no_tel_prospek.'&alamat='.str_replace(' ', '-', $alamat).'&pakej='.$pakej.
                        		'&kos_pos='.$kos_pos.'&jumlah='.$jumlah.'&username_penaja='.$username_penaja.'&email='.$email.
                        		'&no_tel='.$no_tel.'&no_idp='.$no_idp_penaja .'&img_url='.$img_url.'&no_kp='.$no_kp;

            $to = $email_prospek;
            $email_subject = "WEBSITE REPLIKA MMGUIA";
            $message = '<html><body align="center">';
            $message .= '<h2 style="text-align: center; "><font face="Verdana" color="#0000ff"><b>Assalamualaikum dan Salam Hormat, <br>Hai ' . strip_tags($nama_prospek) . '!!!</b></font></h2>
            <h4 style="text-align: center; "><font face="Helvetica">Anda hanya selangkah lagi untuk memiliki web pemasaran paling masyuk abad ini. Jika anda ingin muat naik BUKTI GAMBAR RESIT  PEMBAYARAN yang telah anda buat, sila klik link dibawah.</font><br><br>
            <span style="text-align: center; "><a href="http://www.gajimasyuk.com/pengesahan.php?'.$args_array.'">Pembayaran Gaji Masyuk</a></span><br><br>
            <h4 style="text-align: center; "><font face="Helvetica">PERHATIAN : ANDA WAJIB MEMBUAT PEMBAYARAN DALAM TEMPOH 48JAM DARI MASA TEMPAHAN DIBUAT ('.$created_at.'). TEMPAHAN AKAN DIHAPUSKAN DARI SISTEM JIKA TIDAK MENERIMA PEMBAYARAN DALAM TEMPOH YANG DIBERIKAN.</font><br><br>
            <font face="Helvetica" color="#ff0000">SEMOGA BERJAYA!</font></h4><br><br><br>
            <span style="text-align: left; color: #ff0000;"  >This is a system generated email. Please do not reply to it. If you want to contact us, please reply to:</span>
            <span style="text-align: left; " >support@mmguia.com </span><br><br>';
            $message .= "</body></html>";

            smtpmailer($to, $nama , 'info@gajimasyuk.com', 'Gajimasyuk', $email_subject, $message);
            echo "<script>alert('TAHNIAH, PIHAK KAMI TELAH MENERIMA TEMPAHAN DARI ANDA, SILA SEMAK EMAIL ANDA SEGERA..');</script>";
    	    echo "<script>
    	        window.location.href = 'http://www.gajimasyuk.com/pengesahan.php?$args_array';
    	    </script>";
            // header("Location: http://www.gajimasyuk.com/pengesahan.php?$args_array");
            // header("Location: http://www.gajimasyuk.com/pengesahan.php?$args_array");
          }

        }else{
          $errors = "<li>Terdapat isu dengan Gambar.</li>";
        }
      }
      else
      {
        $errors = "<li>Gambar wajib diisi.</li>";
      }
  	}else{
  		$errors = "<li>Username telah wujud.</li>";
  	}
    }else{
    	 $errors = "Terdapat kesalahan semasa mengisi borang.";
	 if(strlen($no_tel_prospek)<10 || strlen($no_tel_prospek)>11 ){$errors .= "<li>Nombor Telefon: 10 - 11 digit</li>";}
	 if(!ctype_digit($no_tel_prospek) ){$errors .= "<li>Nombor Telefon: Hanya nombor tanpa simbol</li>";}
	 if( isset($_POST['no_ic']) &&  $_POST['kp_passport'] == 'no_ic' && ( strlen($no_kp) < 12 || strlen($no_kp) > 12 ) ){ $errors .= "<li>Nombor KP: 12 digit</li>";}
	 if( isset($_POST['no_passport']) &&  $_POST['kp_passport'] == 'no_passport' && ( strlen($no_passport) < 8 || strlen($no_passport) > 8)  ){$errors .= "<li>Nombor Pasport: 8 digit Cth: A1234567</li>";}
	 if($_POST['email_prospek'] != $_POST['email_prospek2'] ){$errors .= "<li>Email tidak sepadan</li>";}
	 if($username != str_replace(' ', '', $username) || !ctype_alnum($username)){$errors .= "<li>Username: Satu Perkataan, Huruf Kecil, Tiada Jarak & Tiada Simbol</li>";}
	 if(strlen($poskod) < 5 || strlen($poskod) > 5 ){$errors .= "<li>Alamat (Poskod): 5 digit</li>";}
	 if($_POST['setuju'] != 1 ){$errors .= "<li>Tidak Pilih Persetujuan Syarat</li>";}

  	// error in submitted data
  }
 }
 ?>

<!DOCTYPE html>
<html>
  <head>
    <style media="screen">
	@font-face {
	font-family: century-gothic;
	src: url(font/century-gothic.ttf);
	}


	html,
	body {
    background-image:url(images/login/mmg.png);
    background-repeat: repeat;
	 margin:0;
	 padding:0;
	 height:100%;

	}

	.card.hovercard {
    background-image:url(images/login/mmg3.png);
    background-repeat: repeat;
	  /*position: relative;*/
	  padding: 30px 0px;
	  overflow: hidden;
	  text-align: center;
		/*background: #990d1a;*/
	  /*background-color: rgba(214, 224, 226, 0.2);*/
	}
	 .avatar {
	  float: right;
	  /*top: -95px;*/
	  margin-bottom: 12px;
		/*padding-top: 20px;*/
	}
	.heading-top{
		float: left;
		font-family: "Roboto", Helvetica, Arial, sans-serif;
		color: #f9b430;
		font-size: 30px;
		font-weight: 700;
	}
	.heading-text, .lg-left{
		float: left;
	}
	 .avatar img {
	  width: 120px;
	  height: 120px;
	  max-width: 180px;
	  max-height: 180px;
	  -webkit-border-radius: 50%;
	  -moz-border-radius: 50%;
	  border-radius: 50%;
	  border: 3px solid white;
	}
	.avatar-desc{
		padding-left: 10px;
		border-left: 3px solid white;
		font-family: "century-gothic";
		color: white;
		font-size: 18px;
		float: left;
	}

	.card.hovercard .info .title {
	  font-family: "century-gothic";
	  margin-bottom: 20px;
	  font-size: 40px;
	  font-weight: 900;
	  line-height: 1;
	  color: white;
	  vertical-align: middle;
	}
	.card.hovercard .info .no-tel {
	  font-family: "century-gothic";
	  padding-bottom: 30px;
	  font-size: 25px;
	  line-height: 1;
	  color: white;
	  vertical-align: middle;
	}
	.card.hovercard .info .desc {
	  font-family: 'century-gothic';
	  padding: 0 15%;
	  overflow: scroll;
	  font-size: 12px;
	  line-height: 24px;
	  color: white;
	  padding-bottom: 30px;
	}
	.margin-bottom-20{
	  margin-bottom: 20px;
	}
	.margin-top-20{

	}
	.padding-bottom-20{
		padding-bottom: 20px;
	}
	.margin-top-10{
		margin-top: 10px;
	}
	#no-margin{
		margin-bottom: 0;
		margin-right: 0px;
	}
	#no-margin-top{
		/*margin-right: 0px;*/
		margin-bottom: 0;
	}
	#pembeli_form_container{
		padding: 0 10px;
	}

	input[type=number]::-webkit-inner-spin-button,
	input[type=number]::-webkit-outer-spin-button {
	    -webkit-appearance: none;
	    -moz-appearance: none;
	    appearance: none;
	    margin: 0;
	}

	#daerah{
		margin-bottom: 0;
	}
	/**{
	  border-radius: 0 !important;
	}*/

	input.form-control{
		width: 100%;
	}
	.form-control.row{
		margin-bottom: 0;
	}
	.padding-right-0{
		padding-right: 0px !important;
	}
	.padding-right-left-0{
	    padding-right: 0px !important;
	    padding-left: 0px !important;
	}

	.btn.default{
	    background-color: #e1e5ec;
	    border-color: #e1e5ec;
	}
	.btn.red{
	       color: #fff;
	    background-color: #e12330;
	    border-color: #dc1e2b;
	}
	.fileinput{
	  width: 100%;
	}
	.fileinput p{
	  margin: 10px 0;
	}
	#error-text{
	color: red;
	}
     #content img{
        width: 100%;
        height: auto;
        max-width: 100%;
      }

	@media only screen and (min-width: 481px)  and (max-width: 770px) {
			.avatar{
				float: none;
			}
			.avatar-desc{
				padding-top: 10px;
				border-top: 3px solid white;
				border-left: 0px solid white;
				font-family: "century-gothic";
				color: white;
				font-size: 15px;
			}
			.heading-top{
				font-size: 25px;
				float: none;
			}
			.heading-text, .lg-left{
				float: none;
			}
			.avatar-desc{
				margin: 0 10px;
				padding-left: 0px;
				float: none;
			}
	}
	@media only screen and (max-width: 480px) {
			#footer {
				height: auto;
	      padding: 0;
	      font-size: 1.2em;
			}
	    .margin-top-20{
	      margin-top: 20px;
	    }
			.margin-bottom-20{
			  margin-bottom: 0;
			}


	    .padding-right-0{
		    padding-right: 0px !important;
			}
			.avatar{
				float: none;
			}
			.avatar-desc{
				padding-top: 10px;
				border-top: 3px solid white;
				border-left: 0px solid white;
				font-family: "century-gothic";
				color: white;
				font-size: 15px;
			}
			.heading-top{
				font-size: 20px;
				float: none;
			}
			.heading-text, .lg-left{
				float: none;
			}

			.avatar-desc{
				margin: 0 10px;
				padding-left: 0px;
				float: none;
			}
	}
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <!--<script src="//www.gajimasyuk.com/ovc/counter.js"></script>-->
    <title><?php echo $username_penaja; ?> @ gajimasyuk.com | MMGUIA  </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap-fileinput/bootstrap-fileinput.css">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/8028381aa5.js"> -->

  </head>
  <body>
		<div class="card hovercard">
			<div class="row"  id="no-margin">
				<div class="col-sm-5">
          <?php
            if (strpos($img_url, 'gajimasyuk') == false) {
                $img_url = "images/uploads/$img_url";
            }
            // if (strpos($img_url, 'images/uploads') == false) {
            //     $img_url = "../images/uploads/$img_url";
            // }
           ?>
					<div class="avatar text-xs-center"><img alt="" src=<?php echo $img_url; ?>></div>
				</div>
				<div class="col-sm-7 heading-text ">
					<span class="heading-top  ">Assalamualaikum <span class="">& Salam Hormat.</span></span>
					<div class="row" id="no-margin-top">
						<div class="col-xs-12">
							<div class="avatar-desc ">
								<span class="lg-left">Nama Saya <?php echo $nama; ?></span><br>
								<span class="lg-left">Ahli Yang Ke: <?php echo $no_idp; ?></span><br>
								<span class="lg-left">No Tel: <?php echo $no_tel; ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
   <div id="page-wrap">
      <div id="content" class="text-center">
        <?php
            include '_mmg-images.php';
         ?>
	    </div> <!-- end page-wrap -->
   </div>
	 <br>
	 <div class="row padding-bottom-20" id="no-margin">
		 <div class="col-sm-3 col-md-3 col-lg-4">

		 </div>
		 <div class="col-sm-6 col-md-6 col-lg-4 padding-right-0">
			 <div id="pembeli_form_container">
         <form id="pembeli_form" name="pembeli_form" role="form" method="post"   enctype="multipart/form-data">
          <div class="row"  id="no-margin">
           <div class="col-md-12 ">
             <h4>Maklumat Diri</h4>
             <hr>
           </div>
          </div>

           <div class="form-group" id='error-text'>
             <?php echo $errors; ?>
           </div>
           <div class="form-group">
             <div class="input-group ">
               <span class="input-group-addon" id="bg-white"><i class="fa fa-user"></i></span>
               <input name="nama" id="nama" type="text" class="form-control" autocomplete="off" placeholder="Nama (Seperti Di Dalam Kad Pengenalan)" aria-describedby="basic-addon1" value="<?php echo $nama_prospek ; ?>" required>
             </div>
           </div>
           <div class="form-group">
             <div class="input-group ">
               <span class="input-group-addon" id="bg-white"><i class="fa fa-address-card" aria-hidden="true"></i></span>
               <input name="no_ic" id="no_ic" type="number" class="form-control" autocomplete="off" placeholder="No Kad Pengenalan Tanpa (-)." aria-describedby="basic-addon1" value="<?php echo $no_kp; ?>" <?php if( $no_passport != ''){ echo 'disabled=""'; };  ?>>
               <span class="input-group-addon" id="bg-white"><input name="kp_passport" value="no_ic" type="radio" <?php if( $no_passport == ''){ echo 'checked'; }; ?>></span>
             </div>
           </div>
           <div class="form-group">
             <div class="input-group ">
               <span class="input-group-addon" id="bg-white"><i class="fa fa-address-card" aria-hidden="true"></i></span>
               <input name="no_passport" id="no_passport" type="text" class="form-control" autocomplete="off" placeholder="No Passport" aria-describedby="basic-addon1" value="<?php echo $no_passport; ?>" <?php if( $no_passport != ''){ echo 'checked'; }; if( $no_passport == ''){ echo 'disabled=""'; }; ?> >
               <span class="input-group-addon" id="bg-white"><input name="kp_passport" value="no_passport" type="radio" <?php if( $no_passport != ''){ echo 'checked'; }; ?>></span>
             </div>
             <div id="status-passport">

             </div>
           </div>
            <div class="form-group" id="address">
                <div class="row no-gutters" id="no-margin" >
                  <div class="col-md-12 padding-right-0">
                    <div class="input-group ">
                      <span class="input-group-addon" id="bg-white"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                      <input name="alamat1" id="alamat1" type="text" class="form-control" autocomplete="off" placeholder="Alamat Penghantaran" aria-describedby="basic-addon1" value="<?php echo $alamat1; ?>" required>
                    </div>
                  </div>
                </div>
                <div class="row margin-top-10" id="no-margin">
                  <div class="col-xs-4 padding-right-0">
                    <input id = "poskod" name = "poskod" type="number" autocomplete="off" placeholder="Poskod" class="form-control" value="<?php echo $poskod; ?>" required/>
                  </div>
                    <div class="col-xs-8 padding-right-0">
                      <input id = "daerah" name = "daerah" type="text" autocomplete="off" placeholder="Daerah" class="form-control" value="<?php echo $daerah; ?>"  required/>
                    </div>
                </div>
                <div class="row margin-top-10"  id="no-margin">
                  <div class="col-md-12 padding-right-0">
                    <select id = "negeri" name = "negeri" class="form-control" required>
                      <option value="">Pilih Negeri</option>
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
                <input name="no_tel_prospek" id="no_tel_prospek" type="number" class="form-control" autocomplete="off" placeholder="No Telefon, Cth: 0123456789" aria-describedby="basic-addon1" value="<?php echo $no_tel_prospek; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group ">
                <span class="input-group-addon" id="bg-white"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                <input name="email_prospek" id="email_prospek" type="email" class="form-control" autocomplete="off" placeholder="Email, Cth: nama@email.com" aria-describedby="basic-addon1" value="<?php echo $email_prospek; ?>" required>
              </div>
            </div>
             <div class="form-group">
              <div class="input-group ">
                <span class="input-group-addon" id="bg-white"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                <input name="email_prospek2" id="email_prospek2" type="email" class="form-control" autocomplete="off" placeholder="Ulangan Email, Cth: nama@email.com" aria-describedby="basic-addon1"  required>
              </div>
            </div>
            <div class="row"  id="no-margin">
               <div class="col-md-12 ">
                 <h4>Maklumat Penaja</h4>
                 <hr>
               </div>
             </div>
             <div class="form-group">
               <div class="input-group ">
                 <span class="input-group-addon" id="bg-white"><i class="fa fa-user-plus"></i></span>
                 <input name="username_penaja" id="username_penaja" type="text" class="form-control" autocomplete="off" value="<?php echo $username_penaja; ?>" aria-describedby="basic-addon1" readonly="">
                 <input name="email" id="email" type="hidden" value=<?php echo $email; ?>>
                 <input name="no_tel" id="no_tel" type="hidden" value=<?php echo $no_tel; ?>>
               </div>
             </div>
             <div class="form-group">
               <div class="input-group ">
                 <span class="input-group-addon" id="bg-white"><i class="fa fa-id-badge"></i></span>
                 <input name="no_idp" id="no_idp" type="text" class="form-control" autocomplete="off" value=<?php echo $no_idp; ?> aria-describedby="basic-addon1" readonly="">
               </div>
             </div>
             <div class="row"  id="no-margin">
               <div class="col-md-12 ">
                 <h4>Maklumat Pembelian</h4>
                 <hr>
               </div>
             </div>
              <div class="form-group">
                <select id = "pakej" name = "pakej" class="form-control" required>
                  <option value="">Pilih Pakej</option>
                  <option value="PAKEJ-3G">PAKEJ 3G - RM110.00</option>
                  <option value="PAKEJ-4G">PAKEJ 4G - RM120.00</option>
                </select>
              </div>
             <!-- <div class="form-group">-->
             <!--  <div class="input-group ">-->
             <!--    <span class="input-group-addon" id="bg-white"><i class="fa fa-truck" aria-hidden="true"></i>&nbsp; <small>Kos Penghantaran</small>&nbsp; RM</span>-->
             <!--    <input name="kos_pos" id="kos_pos" type="number" class="form-control" autocomplete="off" placeholder="00.00" aria-describedby="basic-addon1" readonly="">-->
             <!--  </div>-->
             <!--</div>-->

              <div class="form-group">
               <div class="input-group ">
                 <span class="input-group-addon" id="bg-white"> <small>Jumlah</small>&nbsp; RM</span>
                 <input name="jumlah" id="jumlah" type="number" class="form-control" autocomplete="off" placeholder="00.00" aria-describedby="basic-addon1" readonly="">
               </div>
             </div>

             <div class="row"  id="no-margin">
               <div class="col-md-12 ">
                 <h4>Maklumat Web Replika</h4>
                 <hr>
               </div>
             </div>
             <div class="form-group">
               <small><span id='if-error'></span></small>
               <div class="input-group ">
                 <span class="input-group-addon" id="bg-white"><i class="fa fa-gift" id="username-icon"></i>&nbsp;
                 <small class="hidden-xs">gajimasyuk.com/user/</small></span>
                 <input pattern="[a-zA-Z0-9]{5,15}" title="5 hingga 15 huruf" name="username" id="username" type="text" class="form-control" autocomplete="off" placeholder="Username Website" aria-describedby="basic-addon1" value="<?php echo $username; ?>" required>
                 <span class="input-group-addon">
                   <span id="user-availability-status">
                     <i class="fa fa-spinner fa-pulse fa-fw" id="loaderIcon" style="display:none"></i>
                     <i class="fa fa-question" id="question-icon" ></i>
                   </span>
                 </span>

               </div>
               <span class='errors input-error' id='error-text'>
               <small>*Username: Satu Perkataan, Tiada Jarak, Huruf Kecil & Tiada (.*$#!?) </small>
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
                                     <span id='upload_span'>Upload Gambar Anda</span>
                                     <p><small>Dimensi Terbaik: <br>150px X 150px</small></p>
                                     <p><small>Saiz: Tidak Melebihi 500kb</small></p>
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
                       <div class="form-group" id='setuju-div'>
                   <input type="checkbox" name="setuju" id="setuju" value="1"  required/> Saya bersetuju untuk daftar dan segala maklumat yang diberikan adalah tepat. Sekiranya maklumat yang diberikan salah, saya akan menanggung akibat kecuaian saya sendiri dan tidak akan menyalahkan mana-mana pihak.
                    </div>

            <div class="margin-top-10">
             <input class="btn btn-success btn-block" type="submit" name="simpan_pengguna"  id="simpan_pengguna" value="DAFTAR SEKARANG">
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
   <script>

   $(document).ready(function() {
         $(document).ready(function() {
            $('#email_prospek,#email_prospek2').bind('copy paste', function (e) {
               e.preventDefault();
          });
    });
     $('input[type=radio][name=kp_passport]').click(function(){
         var related_class=$(this).val();
         $('#'+related_class).prop('disabled',false);
         $('#'+related_class).prop('required',true);

         $('input[type=radio][name=kp_passport]').not(':checked').each(function(){
             var other_class=$(this).val();
             $('#'+other_class).prop('disabled',true);
             $('#'+other_class).removeAttr('required');
         });
     });

     $('#username').on('keypress', function(e) {
         if (e.which == 32)
             return false;
     });

     $("#username").on('keyup',function(){
     this.value = this.value.toLowerCase();
     });



     $("#no_ic").on('keypress',function(){
     if($(this).val().length==12){
         //alert("No. IDP tidak kurang 6 huruf & tidak lebih 7 huruf");
         $(this).focus();
         return false;
        }
     });
     $("#no_ic").on('blur',function(){
     if($(this).val().length<12){
     //alert("No. IDP tidak kurang 6 huruf & tidak lebih 7 huruf");
         $(this).focus();
         return false;
        }
     });
    //  function said_validate(passport)
    // {
    //     var regsaid = /[a-zA-Z]{1}[0-9]{7}/;
    //
    //     if(regsaid.test(passport) == false)
    //     {
    //         document.getElementById("status-passport").innerHTML = "Passport is not yet valid.";
    //         $(".no_passport").focus();
    //         return false;
    //     }
    //     else
    //     {
    //         // document.getElementById("status-passport").innerHTML = "You have entered a valid Passport number!";
    //     }
    // }

     $("#daerah").on('blur',function(){
     if(!isNaN($(this).val())){
        // $(this).parent().parent().addClass('has-error');
         $(this).focus();
         return false;
        }
     });
     $("#no_passport").on('blur',function(){
       var txt = $("#no_passport").val();
       var regsaid = /^[a-zA-Z]{1}[0-9]{6}$/;
       if(regsaid.test(txt) == true){
      //  if (!txt.match(/[a-zA-Z]{1}[0-9]{7}/)) {
          // document.getElementById("status-passport").innerHTML = "";
          $("#status-passport").hide();
       }
       if(regsaid.test(txt) == false){
      //  if (!txt.match(/[a-zA-Z]{1}[0-9]{7}/)) {
          // document.getElementById("status-passport").innerHTML = "";
          $("#status-passport").show();
          $("#status-passport").html('<small><span id="error-text">Format Passport Salah. Cth: A123456</span></small>');
          $("#no_passport").focus();
          return false;
       }
     });
     $("#no_tel_prospek").on('keypress',function(e){
      var deleteKeyCode = 8;
      var backspaceKeyCode = 46;
     if($(this).val().length==11 && e.which != 46 ){
         $(this).focus();
         return false;
        }
     });
     $("#no_tel_prospek").on('blur',function(){
     if($(this).val().length<10){
         $(this).focus();
         return false;
        }
     });
     $("#negeri , #pakej").on('change',function(){
     assignPrice();
     });

     $('#username').keypress(function (e) {
       var txt = String.fromCharCode(e.which);
       if (!txt.match(/^[A-Za-z0-9]+$/)) {
           return false;
       }
     });
     $('#no_tel_prospek').on('keydown',function(e){
        var deleteKeyCode = 8;
        var backspaceKeyCode = 46;
        var tabKeyCode = 9;
        if ((e.which>=48 && e.which<=57) || (e.which>=96 && e.which<=105) || (e.which>=37 && e.which<=40)  || e.which === deleteKeyCode || e.which === backspaceKeyCode || e.which === tabKeyCode)
        {
            $(this).removeClass('error');
            return true;
        }
        else
        {
            $(this).addClass('error');
            return false;
        }
    });
     $("#username").keyup(function(e){
     var str = $.trim( $(this).val() );
     if( str != "" ) {
       var regx = /^[A-Za-z0-9]+$/;
       if (!regx.test(str)) {
         $(".input-error-2").html("Hanya Huruf dan Nombor sahaja");
         return false;
       }
     }
     else {
        //empty value -- do something here
     }
     });
     function assignPrice() {
      var negeri = $("select#negeri option:selected").val();
      var pakej = $("select#pakej option:selected").val();
      var kos_pos = 0;
      var kos_pakej = 0;

    //   if(negeri == ''){
    //     kos_pos = 0;
    //   }else if(negeri == 'Sabah' || negeri == 'Sarawak'|| negeri == 'Labuan'){
    //     kos_pos = 11;
    //   }else {
    //     kos_pos = 7;
    //   }
      if(pakej == ''){
        kos_pakej = 0;
      }
      if(pakej == 'PAKEJ-3G'){
        kos_pakej = 110;
      }else if(pakej == 'PAKEJ-4G'){
        kos_pakej = 120;
      }
      total = kos_pos + kos_pakej;
    //   $('#kos_pos').val(kos_pos);
      $('#jumlah').val(total);
     }
     $("#poskod").on('keypress',function(){
       if($(this).val().length>=5){
           return false;
          }
     });
     function checkAvailability() {
     var indicator;
     var flag;
     var username_value = $("#username").val();
     if(username_value != '')
     {
       $("#question-icon").hide();
       jQuery.ajax({
       url: "check_availability.php",
       data:'username='+$("#username").val(),
       type: "POST",
       success:function(data){
         if(data == 1){
           $('#username').parent().parent().addClass('has-error');
           indicator = "<i class='fa fa-times' id='username-not-available' style='color:red'></i>";
           flag = 1;
         }else{
           $('#username').parent().parent().removeClass('has-error');
           indicator = "<i class='fa fa-check' id='username-available' style='color:green'></i>";
           flag = 0;
         }
         $("#user-availability-status").html(indicator);
         $("#loaderIcon").hide();
         return flag;
       },
       error:function (){}
       });
     }else {
       $('#username').parent().parent().addClass('has-error');
       return 1;
     }
     }

   });
	 jQuery(function($) {

	 });


	 </script>


</div>
  </body>
	</html>
