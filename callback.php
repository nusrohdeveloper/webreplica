<?php

require_once 'billplz.php';
require_once 'configuration.php';
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'gajimasy_v2');
define('DB_PASSWORD', '[^1a?^t=(9kl');
define('DB_DATABASE', 'gajimasy_v2');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

/*
 * Get Data. Die if input is tempered or X Signature not enabled
 */
$data = billplz::getCallbackData($x_signature);
$tranID = $data['id'];

$billplz = new billplz;
$moreData = $billplz->check_bill($api_key, $tranID, $mode);

/*
 * Dalam variable $moreData ada maklumat berikut (array):
 * 1. reference_1
 * 2. reference_1_label
 * 3. reference_2
 * 4. reference_2_label
 * 5. amount
 * 6. description
 * 7. id // bill_id
 * 8. name
 * 9. email
 * 10. paid
 * 11. collection_id
 * 12. due_at
 * 13. mobile
 * 14. url
 * 15. callback_url
 * 16. redirect_url
 *
 * Contoh untuk akses data email: $moreData['email'];
 *
 * Dalam variable $data ada maklumat berikut:
 * 1. x_signature
 * 2. id // bill_id
 * 3. paid
 * 4. paid_at
 * 5. amount
 * 6. collection_id
 * 7. due_at
 * 8. email
 * 9. mobile
 * 10. name
 * 11. paid_at
 * 12. state
 * 13. url
 *
 * Contoh untuk ases data bill_id: $data['id']
 *
 */

/*
 * Jika bayaran telah dibuat
 */
if ($data['paid']) {

    $bill_id = $data['id'];
    $username = strtolower(trim($data['name']));
    $email = strtolower(trim($data['email']));

    // error_log("success payment has been recorded $username $bill_id");
    $sql =  "UPDATE user SET status = 'Selesai Bayaran', bill_id = '$bill_id' WHERE username = '$username' AND email = '$email'";
    mysqli_query($db, $sql);
}
/*
 * Jika bayaran tidak dibuat
 */ else {
    // error_log('Faield payment has been recorded');
}
