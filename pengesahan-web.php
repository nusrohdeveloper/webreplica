<?php /* Template Name: Auto Submit */ ?>

<?php

 $name = '';
 $email = '';
 $phone = '';
 $membership_id = "";
 $img_url = '';
 $username = '';
if(isset($_GET['username']) && isset($_GET['rm']) && $_GET['rm'] == 2){
	$findme = $_GET["username"];
	$results = $wpdb->get_results(
	$wpdb->prepare(
		 "SELECT * FROM user WHERE username = %s",
			 $findme));
  if(!empty($results)) {
	foreach($results as $r) {
	 $name = $r->name;
	 $email = $r->email;
	 $phone = $r->phone;
	 $membership_id = $r->$membership_id;
	 $img_url = $r->img_url;
	 $username = $r->username;
	 $status= $r->status;
	}
$wpdb->update(
	'user',
	array(
		'status' => 'Selesai Bayaran'
	),
	array( 'username' => $username ),
	array(
		'%s'	// value1
	),
	array( '%s' )
);
}


	 //php email
   $to = $email;
   $email_from = 'www.gajimasyuk.com';
   $headers = 'From: Gajimasyuk MMGUIA <support@mmguia.com>' . "\r\n" ;
    $headers .='Reply-To: '. $email_host . "\r\n" ;
    $headers .='X-Mailer: PHP/' . phpversion();
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
   $email_subject = "WEBSITE REPLIKA MMGUIA";
   $message = '<html><body align="center">';
   $message .= '<h2 style="text-align: center; "><font face="Verdana" color="#0000ff"><b>Assalamualaikum dan Salam Hormat, <br>Tahniah ' . strip_tags($nama) . '!!!</b></font></h2>
   <h4 style="text-align: center; "><b><font face="Helvetica">Anda telah berjaya memiliki sebuah laman web istimewa dari MMGUIA. <br> Gunakan webreplika ini sebaik mungkin untuk menambah rakan niaga mahupun kembangkan jaringan bisnes anda. Berikut adalah link Web Replika anda.</font><br>
   <span style="text-align: center; "><a href="http://www.gajimasyuk.com/user/'.$username.'">http://www.gajimasyuk.com/user/'.$username.'</a></span><br>
   <font face="Helvetica" color="#ff0000">SEMOGA BERJAYA!</font></b></h4><br><br>
   <span style="text-align: left; color: #ff0000;"  >This is a system generated email. Please do not reply to it. If you want to contact us, please reply to:</span>
   <span style="text-align: left; " >support@mmguia.com </span><br><br>';
   $message .= "</body></html>";
   $body = $message;
   sleep(3);
  // mail($to,$email_subject,$message,$headers);
  //  wp_mail( $to, $email_subject, $body, $headers );

	// $url = esc_url( get_permalink( get_page_by_title( 'thanks' ) ) );
	// wp_redirect($url);
	// exit();
	}
  if ($_SERVER['REQUEST_METHOD'] == 'GET'){
	  $username = $_GET['username'];
	  $name = ucwords(str_replace("-"," ",$_GET['name']));
	  $email = $_GET['email'];
	  $phone = $_GET['phone'];
	  $jumlah = '30';
	  $email = $_GET['email'];
	}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
    <style media="screen">
      body{
          background-color: #00000;
      }
      .margin-top-150{
        margin-top: 150px;
      }
    </style>
  </head>
  <body>
    <div class="row">
      <div class="col-sm-12">
        <div class="text-center margin-top-150">
          <form id="the_form"class="" action="billplzpost.php" method="post">
            <input type="hidden" name="name" value="<?php echo $username;?>">
            <input type="hidden" name="email" value="<?php echo $email;?>">
            <input type="hidden" name="phone" value="<?php echo $no_tel;?>">
			<input type="hidden" name="description" value="Web Replika">
            <input type="hidden" name="amaun" value="<?php echo $jumlah;?>">
            <input type="hidden" name="successpath" value="http://v2.gajimasyuk.com/thanks">
            <input type="image" src="images/LODING_03.png" name="" value="">
          </form>
        </div>
      </div>
    </div>
  </body>
  <script type="text/javascript" src="js/jquery-3.2.0.min.js" charset="utf-8"></script>
  <script>
    jQuery(function($) {
      // $( "#pengguna_form" ).trigger('click');
    //  jQuery("#the_form").trigger("submit",[true]);
    });

  </script>
</html>
