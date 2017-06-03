<?php

require_once "db_con/connection.php"; //Establishing connection with our database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST["simpan_pengguna"])){

        $username = $_POST["username"];
        $datetime_resit = mysqli_real_escape_string($db, $_POST['dtp_input1']);
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $updated_at = date("h:i:s A d/m/Y l");
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

            if($file_size > 500000){
               $errors_uploading[]='File size must be less than 2 MB';
            }

            $resit = $newfilename;

            if(empty($errors_uploading)==true){
              move_uploaded_file($file_tmp,"images/resit/".$newfilename);
            }
          }

       $sql =  "UPDATE user SET
                  datetime_resit = '$datetime_resit',
                  status = 'Sedang Diproses',
                  resit = '$resit',
                  updated_at = '$updated_at'
                WHERE username = '$username'";
        if(empty($errors_uploading)==true && mysqli_query($db, $sql))
        {
          header("Location: ../thanks.php");
        } else{
          header("Location: ../pengesahan-web.php/$username");
        }

      }
}

 $name = '';
 $email = '';
 $phone = '';
 $membership_id = "";
 $img_url = '';
 $username = '';



if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['username'] != ''){

    $username = $_GET['username'];
    // $nama = ucwords(str_replace("-"," ",$_GET['nama']));
    // $email = $_GET['email'];
    // $no_tel = $_GET['no_tel'];
    $jumlah = '50';
    // $email = $_GET['email'];

    $sql = mysqli_query($db,"SELECT * FROM user WHERE username = '$username'");
    $row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
    $name = $row["name"];
    $address = $row["address"];
    $email = $row["email"];
    $membership_id = $row["membership_id"];
    $phone = $row["phone"];
    $ic_no = $row["ic_no"];
    $img_url = $row["img_url"];
    $status = $row["status"];
    $username = $row["username"];
    $created_at = $row["created_at"];

      // if( empty($row) ){
      //         echo "<script>alert('Link ini tidak aktif lagi, Sila Daftar semula. ');</script>";
      //         echo "<script>
      //                 window.location.href = 'http://www.gajimasyuk.com/';
      //             </script>";
      //     }

    $date11 = DateTime::createFromFormat('h:i:s A d/m/Y l', $created_at);
    // $date11 = $date->format('Y-m-d H:i');
    $date48h = date('Y/m/d H:i:s', strtotime($date11 . " +48 hours"));
    $date48h = date('Y-m-d H:i', strtotime($date11 . " +48 hours"));
    $date48 = date('h:i:s A d/m/Y l', strtotime($date11 . " +48 hours"));
    $date1 = new DateTime("now");
    $date2 = new DateTime($date48h);

    // if( ( $date1 > $date2 )  ){
    //     $query = "DELETE FROM user WHERE username = " . $username . " ";
    //     mysqli_query($db, $query);
    //     echo "<script>alert('Link ini tidak aktif lagi, Sila Daftar semula. ');</script>";
    //     echo "<script>s
    //             window.location.href = 'http://www.gajimasyuk.com/';
    //         </script>";
    // }


    if($status == "Selesai Bayaran"){
        echo "<script>alert('Pengguna telah membuat bayaran.');</script>";
        echo "<script>
                window.location.href = 'http://www.gajimasyuk.com/user/$username';
            </script>";
    }

    if($status == "Sedang Diproses"){
        echo "<script>alert('Permohonan kelulusan pembayaran masih dalam proses. Admin akan menghantar email setelah web anda diaktifkan. ');</script>";
        echo "<script>
                window.location.href = 'http://www.gajimasyuk.com/';
            </script>";
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
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <title>Daftar Web Gajimasyuk</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/sbootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap-fileinput/bootstrap-fileinput.css"> -->
    <link rel="stylesheet" href="csss/bootstrap.css">
  <?php
    // echo " <script>var date48h = '$date48h'</script>";
    ?>
    <link href="datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="css/payment.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap-fileinput/bootstrap-fileinput.css">
<?php
  echo " <script>var date48h = '$date48h'</script>";
  ?>
  <link href="datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
  </head>
  <body>
    <?php
        $username_prospek = $username;
        include "_modal_pembayaran_manual.php";

    ?>
    <div id="container">
		 <div id="page-wrap" >
			 <div class="row">
				 <div class="col-sm-12">
						 <div class="panel panel-default">
							 <div class="panel-body text-center">
								 <h2>PURCHASE DETAILS</h2>
							 </div>
					 </div>
				 </div>
			 </div>
			 <div class="row">
				 <div class="col-md-7">
						 <div class="panel panel-default">
							 <div class="panel-body ">
								 <h4>REGISTRATION DETAILS</h4>
								 <hr>
								 <div class="row">
									 <div class="col-xs-3 text-left">
										 Name
									 </div>
									 <div class="col-xs-1 text-center">
										 :
									 </div>
									 <div class="col-xs-8 text-left">
										 <?php echo $name ?>

									 </div>
								 </div>
								 <div class="row">
									 <div class="col-xs-3 text-left">
										 <span class="hidden-xs">Phone.</span> Number
									 </div>
									 <div class="col-xs-1 text-center">
										 :
									 </div>
									 <div class="col-xs-8 text-left">
										 <?php echo $phone ?>

									 </div>
								 </div>
								 <div class="row">
									 <div class="col-xs-3 text-left">
										 Email
									 </div>
									 <div class="col-xs-1 text-center">
										 :
									 </div>
									 <div class="col-xs-8 text-left">
										 <?php echo $email ?>

									 </div>
								 </div>
							</div>
					 </div>
				 </div>
				 <div class="col-md-5">
						 <div class="panel panel-default">
							 <div class="panel-body">
								 <h4>PAYMENT DETAILS </h4>
								 <hr>
								 <div class="row">
									 <div class="col-xs-7 text-left">
										 Web Replika Gajimasyuk
									 </div>
									 <div class="col-xs-2 text-right">
										 RM
									 </div>
									 <div class="col-xs-3 text-right">
										<!-- <?php echo number_format((float)$jumlah - $kos_pos, 2, '.', '') ?> -->
									 </div>
								 </div>
								 <hr>
								 <div class="row">
									 <div class="col-xs-7 text-left">
										 Total
									 </div>
									 <div class="col-xs-2 text-right">
										 RM
									 </div>
									 <div class="col-xs-3 text-right">
										 <!-- <?php echo number_format((float)$jumlah, 2, '.', '') ?> -->

									 </div>
								 </div>

								 </div>
							 </div>
					 </div>
				 </div>
			 </div>
			 <div class="row">
				 <div class="col-sm-12">
					 <div class="panel panel-default">
						 <div class="panel-body text-center">
						     <div class="row">
                                <div class="col-sm-12 text-center text-success">
                                   <h2>PAYMENT METHOD</h2>
                                   <h3>Billplz Online Payment | Cash Deposit</h3>
                                   <hr>
                                    <div class="row">
                                       <div class="col-sm-6">Resevation Recorded:<br><b><?php echo $created_at;?></b></div>
                                        <div class="col-sm-6">Due Date of Reservation: <br><strong><?php echo $date48;?></strong></div>
                                   </div>
                                   <div class="row" >
                                        <!--<div class="col-sm-2">-->

                                        <!--</div>-->
                                         <div class="col-sm-12 text-center">
                                             <div class="row">
                                                <div class="col-sm-12 bg-red">
                                                    <h4><b>YOU MUST UPLOAD THE PAYMENT PROOF WITHIN 48 HOURS.</b></h4><br><br>
                                                    <div class="col-sm-2"></div>
                                                    <div class="col-sm-8 offset-sm-2" id="demo2"></div>
                                                </div>
                                             </div>

                                        </div>
                                    </div>

                                   <script>
                                    // Set the date we're counting down to

                                    var date48hours = '<?php echo $date48h; ?>';
                                    var countDownDate = new Date(date48hours).getTime();
                                    //  var asd = new Date().getTime();
                                    // var asdasd = new Date(date48h);
                                    //  var asd = new Date();
                                    //  alert(asdasd+'|'+asd);

                                    // Update the count down every 1 second
                                    var x = setInterval(function() {

                                      // Get todays date and time
                                      var now = new Date().getTime();

                                      // Find the distance between now an the count down date
                                      var distance = countDownDate - now;
                                    //   console.log(distance);
                                      // Time calculations for days, hours, minutes and seconds
                                      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                      // Display the result in the element with id="demo"
                                      document.getElementById("demo2").innerHTML =
                                        "<div class='row'><div class='col-sm-3 col-xs-6'><div class='text-big'>" + days + "</div><br>Hari</div><div class='col-sm-3 col-xs-6'><div class='text-big'>" + hours + "</div><br>Jam </div><div class='col-sm-3 col-xs-6'><div class='text-big'>" + minutes + "</div><br>Minit </div><div class='col-sm-3 col-xs-6'><div class='text-big'>" + seconds + "</div><br>Saat </div></div>"

                                      document.getElementById("demo").innerHTML = days + "Hari " + hours + "Jam "
                                      + minutes + "Minit " + seconds + "Saat ";

                                      // If the count down is finished, write some text
                                      if (distance < 0) {
                                        clearInterval(x);
                                        document.getElementById("demo").innerHTML = "EXPIRED";
                                        document.getElementById("demo2").innerHTML = "EXPIRED";
                                      }
                                    }, 1000);
                                    </script>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <div class="text-center margin-top-20">
                                  <!-- <form id="the_form"class="" action="billplzpost.php" method="post"> -->
                                    <!-- <input type="hidden" name="nama" value="<?php echo $username;?>">
                                    <input type="hidden" name="email" value="<?php echo $email;?>">
                                    <input type="hidden" name="phone" value="<?php echo $phone;?>">
                        			<input type="hidden" name="description" value="Web Replika">
                                    <input type="hidden" name="amaun" value="<?php echo $jumlah;?>">
                                    <input type="hidden" name="successpath" value="http://www.gajimasyuk.com/thanks"> -->
                                    <input class="img-responsive img-center" type="image" src="images/BILLPLZ.png" name="" value="">
                                    <!-- <input type="hidden" name="collection_id" value = "wthbd6sm"> -->
                                  </form>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="text-center margin-top-20">
                                    <a data-toggle="modal" data-target="#myModal"> <img class="img-responsive img-center" src="images/manual.png" /></a>

                                </div>
                             </div>
                        </div>
					 </div>
				 </div>
			 </div>
		</div>
    </div><!-- end container -->
  </body>

   <script src="https://use.fontawesome.com/8028381aa5.js" charset="utf-8"></script>
    <script type="text/javascript" src="js/jquery-3.2.0.min.js" charset="utf-8"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="datetimepicker/bootstrap-datetimepicker.js" charset="UTF-8"></script>
   <script type="text/javascript" src="datetimepicker/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
 <script src="assets/bootstrap-fileinput/bootstrap-fileinput.js" charset="utf-8"></script>
    <script>
        $(".readonly").on('keydown paste', function(e){
            e.preventDefault();
        });


     $('.form_datetime').datetimepicker({
        // language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
    jQuery(function($) {
    //   $( "#pengguna_form" ).trigger('click');
    //  jQuery("#the_form").trigger("submit",[true]);
    });

    </script>



</html>
