<?php
global $wpdb;

	if(isset($_GET['username']) && isset($_GET['rm']) && $_GET['rm'] == 2){
//	$username = ucwords(str_replace("-"," ",$_GET['username']));
	$findme = $_GET["username"];
	$results = $wpdb->get_results(
	$wpdb->prepare(
		 "SELECT * FROM user WHERE username = %s",
			 $findme));
	  if(!empty($results)) {
		foreach($results as $r) {
		 $nama = $r->nama;
		 $email = $r->email;
		 $no_tel = $r->no_tel;
		 $no_idp = $r->no_idp;
		 $img_url = $r->img_url;
		 $username = $r->username;
		 $status= $r->status;
		}
		$wpdb->update(
			    	'wp_members_idp',
			    	array(
			    		'status' => 'Selesai Bayaran'
			    	),
			    	array( 'username' => $username ),
			    	array(
			    		'%s'	// value1
			    	),
			    	array( '%s' )
			    );
		$url = esc_url( get_permalink( get_page_by_title( 'thanks' ) ) );
		wp_redirect($url);
	  }

	}

	$nama = '';
	$email = '';
	$no_tel = '';
	$alamat1 = '';
	$poskod = '';
	$daerah = '';
	$negeri = '';
	$pakej = '';
	$kos_pos = '';
	$jumlah = '';
	$username = '';
	$email = '';
	$no_tel = '';
	$no_kp = '';
	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
	  $nama = $_GET['nama'];
	  $nama = ucwords(str_replace("-"," ",$_GET['nama']));
	  $email_prospek = $_GET['email_prospek'];
	  $no_tel = $_GET['no_tel_prospek'];
	  $alamat = $_GET['alamat'];
	  $alamat = ucwords(str_replace("-"," ",$_GET['alamat']));
	  $pakej = $_GET['pakej'];
	  $kos_pos = $_GET['kos_pos'];
	  $jumlah = $_GET['jumlah'];
	  $username = $_GET['username_penaja'];
	  $username_prospek = $_GET['username'];
	  $email = $_GET['email'];
	  $no_kp = $_GET['no_kp'];
	  $no_tel_penaja = $_GET['no_tel'];
	  $no_idp = $_GET["no_idp"];
	}
?>

<!DOCTYPE html>
<html>
  <head>
		<style media="screen">
			* {
			  border-radius: 0 !important;
			}
			body.page-id-72.wrapall{
				background: #EEE;

			}
			#container {
				font-family: "Roboto", Helvetica, Arial, sans-serif;
				background: #EEE;
				padding: 10px 80px;
				min-height:100%;
				position:relative;
			}
			#container .row{
				margin-bottom: 10px;
			}
			.row.row-eq-height {
			  display: -webkit-box;
			  display: -webkit-flex;
			  display: -ms-flexbox;
			  display: flex;
			}
      @media only screen and (max-width: 480px) {
        #container {
          padding: 30px 20px;
        }
      }
		</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
    <link rel="stylesheet" href="https://use.fontawesome.com/8028381aa5.js">

  </head>
  <body>
    <div id="container">



		 <div id="page-wrap" >
			 <div class="row">
				 <div class="col-sm-12">
						 <div class="panel panel-default">
							 <div class="panel-body text-center">
								 <h2>MAKLUMAT PEMBELIAN</h2>
							 </div>
					 </div>
				 </div>
			 </div>
			 <div class="row">
				 <div class="col-sm-12">
					 <div class="panel panel-success">
						 <div class="panel-body">
							 <h4>PENAJA</h4>
							 <div class="row">
								 <div class="col-sm-4">
									 <div class="panel panel-default">
										 <div class="panel-body text-center">
											 <span><?php echo $username ?></span>
										 </div>
									 </div>
								 </div>
								 <div class="col-sm-4">
									 <div class="panel panel-default">
										 <div class="panel-body text-center">
											 <span><?php echo $no_tel_penaja ?></span>
										 </div>
									 </div>
								 </div>
								 <div class="col-sm-4">
									 <div class="panel panel-default">
										 <div class="panel-body text-center">
											 <span><?php echo 'NO. IDP : '. $no_idp ?></span>
										 </div>
									 </div>
								 </div>
							 </div>
						 </div>
					 </div>
				 </div>
			 </div>
			 <div class="row">
				 <div class="col-md-7">
						 <div class="panel panel-default">
							 <div class="panel-body ">
								 <h4>MAKLUMAT PENDAFTARAN</h4>
								 <hr>
								 <div class="row">
									 <div class="col-xs-3 text-left">
										 Nama
									 </div>
									 <div class="col-xs-1 text-center">
										 :
									 </div>
									 <div class="col-xs-8 text-left">
										 <?php echo $nama ?>

									 </div>
								 </div>
								 <div class="row">
									 <div class="col-xs-3 text-left">
										 <span class="hidden-xs">No.</span> Telefon
									 </div>
									 <div class="col-xs-1 text-center">
										 :
									 </div>
									 <div class="col-xs-8 text-left">
										 <?php echo $no_tel ?>

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
										 <?php echo $email_prospek ?>

									 </div>
								 </div>
								 <div class="row">
									 <div class="col-xs-3 text-left">
										 Alamat
									 </div>
									 <div class="col-xs-1 text-center">
										 :
									 </div>
									 <div class="col-xs-8 text-left">
										 <?php echo $alamat ?>

									 </div>
								 </div>
							 </div>
					 </div>
				 </div>
				 <div class="col-md-5">
						 <div class="panel panel-default">
							 <div class="panel-body">
								 <h4>MAKLUMAT BAYARAN </h4>
								 <hr>
								 <div class="row">
									 <div class="col-xs-7 text-left">
										 <?php echo $pakej ?>
									 </div>
									 <div class="col-xs-2 text-right">
										 RM
									 </div>
									 <div class="col-xs-3 text-right">
										 <?php echo number_format((float)$jumlah - $kos_pos, 2, '.', '') ?>
									 </div>
								 </div>
								 <div class="row">
									 <div class="col-xs-7 text-left">
										 Kos Penghantaran
									 </div>
									 <div class="col-xs-2 text-right">
										 RM
									 </div>
									 <div class="col-xs-3 text-right">
										 <?php echo number_format((float)$kos_pos, 2, '.', '') ?>

									 </div>
								 </div>
								 <hr>
								 <div class="row">
									 <div class="col-xs-7 text-left">
										 Jumlah
									 </div>
									 <div class="col-xs-2 text-right">
										 RM
									 </div>
									 <div class="col-xs-3 text-right">
										 <?php echo number_format((float)$jumlah, 2, '.', '') ?>

									 </div>
								 </div>

								 </div>
							 </div>
					 </div>
				 </div>
			 </div>
			 <div class="row">
			 	 <div class="col-sm-12">
					 <div class="pull-right">
						 <form class="" action="billplzpost.php" method="post">
							 <input type="hidden" name="nama" value="<?php echo $username_prospek;?>">
							 <input type="hidden" name="email" value="<?php echo $email_prospek;?>">
							 <input type="hidden" name="telefonbimbit" value="<?php echo $no_tel;?>">
							 <input type="hidden" name="amaun" value="<?php echo $jumlah;?>">
							 <input type="hidden" name="description" value="<?php echo $pakej;?>">
							 <input type="hidden" name="reference_label" value="Alamat">
							 <input type="hidden" name="reference_1" value="<?php echo $alamat;?>">
							 <input type="hidden" name="successpath" value="http://v2.gajimasyuk.com/thanks">
							 <input type="hidden" name="deliver" value ="email">
							 <input type="image" src="images/next-1.jpg" name="" value="">
						 </form>
					 </div>
			 	 </div>
			 </div>

		</div> <!-- end page-wrap -->
   </div>

		</div>
  </body>
</html>
