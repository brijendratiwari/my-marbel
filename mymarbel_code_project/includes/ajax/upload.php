<?php
include_once '../functions.php';
sec_session_start();
if (!login_check($db) || $_SESSION['marbel_user']['type'] != 'customer') {
    header('Location: ../');
}
$orders = getOrders($_SESSION['marbel_user']['user_id'], $db);
if (isset($_FILES["file"]) && $_FILES["file"]["error"]== UPLOAD_ERR_OK) {
    $uploadDirectory = ROOT_PATH .'../'. CONTACT_UPLOADS_DIRECTORY;
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        die();
    }

    if ($_FILES["file"]["size"] > CONTACT_ALLOWED_FILESIZE) {
        die("File size is too big!");
    }

    switch (strtolower($_FILES['file']['type'])) {
        case 'image/png': 
        case 'image/gif': 
        case 'image/jpeg': 
        case 'image/pjpeg':
        case 'text/plain':
        case 'text/html':
        case 'application/x-zip-compressed':
        case 'application/pdf':
        case 'application/msword':
        case 'application/vnd.ms-excel':
        case 'video/mp4':
        break;
        default:
        die('Unsupported File!'); 
    }

    $fileName = strtolower($_FILES['file']['name']);
    $fileExt = substr($fileName, strrpos($fileName, '.'));
    $rand = rand(0, 9999999999);
    $newFileName = $_SESSION['marbel_user']['user_id'].'-'.$rand.$fileExt;
file_put_contents('/var/www/mymarbel/data.log', $uploadDirectory.$newFileName."\n", FILE_APPEND);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadDirectory.$newFileName )) {
        $from = $_SESSION['marbel_user']['email'];
        $fromName = $_SESSION['marbel_user']['first_name'].' '.$_SESSION['marbel_user']['last_name'];
        $subject = $fromName.' has submitted a support form VIA MyMarbel.com/customer/support';
        $text = "Message: ".$_POST['cd-notes']."\n\n";
        $text .= "Uploaded Attachment: http://mymarbel.com/". CONTACT_UPLOADS_DIRECTORY .$newFileName."\n\n";

            // $text .= "Orders:";
            // foreach ($orders as $order) {
            //     $text .= "\n  Order Number: ".$order['order_number']."\n";
            //     $text .= "    Order Total: ".$order['order_total']."\n";
            //     $text .= "    Order Status: ".$order['order_status']."\n";
            //     $text .= "    Order Date: ".date('F j, Y', $order['order_date'])."\n";

            //     if (!empty($order['est_ship_date'])) {
            //         $text .= "    Estimated Shipping Date: ".$order['est_ship_date']."\n";
            //     }
            //     if (!empty($order['tracking_number'])) {
            //         $text .= "    Tracking Number: http://wwwapps.ups.com/WebTracking/processRequest?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=en_US&tracknum=".$order['tracking_number']."\n";
            //     }
            //     $text .= "    Firmware Version: ".$order['firmware_version']."\n";
            //     $text .= "    Deck Serial Number: ".$order['deck_serial_number']."\n";
            //     $text .= "    Main Serial Number: ".$order['main_serial_number']."\n";
            //     $text .= "    Shipping Address: ".$order['delivery_address']. ' '.$order['delivery_address_2']. ', '.$order['city'] . ', ' . $order['state'] .', ' . $order['country'] .'. ' . $order['zip'] . "\n";
            // }
        $mail = sendContactEmail($from, $fromName, $subject, $text);
        if(!$mail->send()) {
            die ('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        } else {
            die('Message has been sent');
        }
    } else {
        die('Error uploading file!');
    }    
} else if (isset($_POST['cd-notes'])) {
    $from = $_SESSION['marbel_user']['email'];
    $fromName = $_SESSION['marbel_user']['first_name'].' '.$_SESSION['marbel_user']['last_name'];
    $subject = $fromName.' has submitted a support form VIA MyMarbel.com/customer/support';
    $text = "Message: ".$_POST['cd-notes']."\n\n";
    $text .= "Orders:";
    // foreach ($orders as $order) {
    //     $text .= "\n  Order Number: ".$order['order_number']."\n";
    //     $text .= "    Order Total: ".$order['order_total']."\n";
    //     $text .= "    Order Status: ".$order['order_status']."\n";
    //     $text .= "    Order Date: ".date('F j, Y', $order['order_date'])."\n";

    //     if (!empty($order['est_ship_date'])) {
    //         $text .= "    Estimated Shipping Date: ".$order['est_ship_date']."\n";
    //     }
    //     if (!empty($order['tracking_number'])) {
    //         $text .= "    Tracking Number: http://wwwapps.ups.com/WebTracking/processRequest?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=en_US&tracknum=".$order['tracking_number']."\n";
    //     }
    //     $text .= "    Firmware Version: ".$order['firmware_version']."\n";
    //     $text .= "    Deck Serial Number: ".$order['deck_serial_number']."\n";
    //     $text .= "    Main Serial Number: ".$order['main_serial_number']."\n";
    //     $text .= "    Shipping Address: ".$order['delivery_address']. ' '.$order['delivery_address_2']. ', '.$order['city'] . ', ' . $order['state'] .', ' . $order['country'] .'. ' . $order['zip'] . "\n";
    // }
    $mail = sendContactEmail($from, $fromName, $subject, $text);
    if(!$mail->send()) {
        die('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
    } else {
        die('Message has been sent');
    }
} else {
    die('Something wrong with upload!');
}