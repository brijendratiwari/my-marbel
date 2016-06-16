<?php
require_once '../functions.php';

function verify_webhook($data, $hmac_header) {
	$calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SECRET, true));
	return ($hmac_header == $calculated_hmac);
}

$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$data = file_get_contents('php://input');
$verified = verify_webhook($data, $hmac_header);
if (!$verified) { 
	http_response_code('400');
	exit();
}
$data = json_decode($data, true);

if (isset($_GET['type'])) {
	if (strcmp($_GET['type'], 'customer_creation') == 0) {
		if (!SHOPIFY_DEBUG) {
			$err = insertUser($data['email'], $data['first_name'], $data['last_name'], 'customer', '', '', hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)), hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)), $db);
			if ($err > 1) {
				http_response_code('400');
				exit();
			}
			sendPasswordResetEmail($data['email'], $db);
		}
		file_put_contents('/var/www/mymarbel/includes/shopify/data.log', 'Added '.$data['first_name'].' '.$data['last_name'].' - '.$data['email'].' to our db'."\n", FILE_APPEND);
		file_put_contents('/var/www/mymarbel/includes/shopify/customers_created.json', json_encode($data)."\n", FILE_APPEND);
	} else if (strcmp($_GET['type'], 'order') == 0) {
		$status = 'cancelled';
		if ($data['cancelled_at'] == null) {
			if (strcmp($data['financial_status'], 'partially_paid') == 0) {
				$status = 'deposit';
			} else if (strcmp($data['financial_status'], 'paid') == 0) {
				$status = 'balance';
			}
		}
		$wheelColor = 'black';
		$wheelSize = 76;
		if (strcmp($data['line_items'][0]['variant_title'], 'Wheels') == 0) {
			$wheelColor = (strcmp($data['line_items'][0]['variant_title'], 'Black') == 0 ? 'black' : 'blue'); 
			$wheelSize = (strcmp($data['line_items'][0]['variant_title'], '100mm') == 0 ? 100 : 76); 
		}

		$customer = getCustomerByEmail($data['email'], $db);
		if (isset($customer) && !empty($customer)) {
			$orders = getOrders($customer['user_id'], $db);
			foreach ($orders as $o) {
				if (strcmp($o['order_status'], 'deposit') == 0 && !empty($o['invoice_url'])) {
					if (!SHOPIFY_DEBUG) {
						adminUpdateOrder($o['user_id'], $o['id'], str_replace('#', '', $data['name']), $data['shipping_address']['address1'], $data['shipping_address']['address2'], $data['shipping_address']['city'], $data['shipping_address']['province'], $data['shipping_address']['zip'], $data['shipping_address']['country_code'], $wheelColor, $wheelSize, 'Marbel Board', $data['total_price'], getShippingCost($data['shipping_address']['country_code']), 'balance', '',  time() + (60 * 60 * 24 * 21), '', '', '', '', '', '', $db, true);
					}
					file_put_contents('/var/www/mymarbel/includes/shopify/data.log', 'Updated Order '.$data['order_number'].'|'.$data['email'].'|'.$data['order_number'].'|'.$data['shipping_address']['address1'].'|'.$data['shipping_address']['address2'].'|'.$data['shipping_address']['city'].'|'.$data['shipping_address']['province'].'|'.$data['shipping_address']['zip'].'|'.$data['shipping_address']['country_code'].'|'.$data['total_price'].'|'.$status.' to our db'."\n", FILE_APPEND);		
				} else {
					if (!SHOPIFY_DEBUG) {
						$err = insertOrder($data['email'], str_replace('#', '', $data['name']), $data['shipping_address']['address1'], $data['shipping_address']['address2'], $data['shipping_address']['city'], $data['shipping_address']['province'], $data['shipping_address']['zip'], $data['shipping_address']['country_code'], $data['total_price'], $status, '', time(), time() + (60 * 60 * 24 * 21), '', 'Marbel Board', $wheelColor, $wheelSize, '', '', '', '', '', 0, $db);	
						file_put_contents('/var/www/mymarbel/includes/shopify/data.log', 'Added Order '.str_replace('#', '', $data['name']).'|'.$data['email'].'|'.$data['order_number'].'|'.$data['shipping_address']['address1'].'|'.$data['shipping_address']['address2'].'|'.$data['shipping_address']['city'].'|'.$data['shipping_address']['province'].'|'.$data['shipping_address']['zip'].'|'.$data['shipping_address']['country_code'].'|'.$data['total_price'].'|'.$status.' to our db'."\n", FILE_APPEND);			
					}
				}
			}
		} else {
			if (!SHOPIFY_DEBUG) {
				$err = insertUser($data['email'], $data['customer']['first_name'], $data['customer']['last_name'], 'customer', '', '', hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)), hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)), $db);
				$err = insertOrder($data['email'], str_replace('#', '', $data['name']), $data['shipping_address']['address1'], $data['shipping_address']['address2'], $data['shipping_address']['city'], $data['shipping_address']['province'], $data['shipping_address']['zip'], $data['shipping_address']['country_code'], $data['total_price'], $status, '', time(), time() + (60 * 60 * 24 * 21), '', 'Marbel Board', $wheelColor, $wheelSize, '', '', '', '', '', 0, $db);	
			}
			file_put_contents('/var/www/mymarbel/includes/shopify/data.log', 'Added Order '.str_replace('#', '', $data['name']).'|'.$data['email'].'|'.$data['order_number'].'|'.$data['shipping_address']['address1'].'|'.$data['shipping_address']['address2'].'|'.$data['shipping_address']['city'].'|'.$data['shipping_address']['province'].'|'.$data['shipping_address']['zip'].'|'.$data['shipping_address']['country_code'].'|'.$data['total_price'].'|'.$status.' to our db'."\n", FILE_APPEND);			
		}
	} else {
		file_put_contents('/var/www/mymarbel/includes/shopify/unknown.json', json_encode($data)."\n", FILE_APPEND);
	}
} else {
	file_put_contents('/var/www/mymarbel/includes/shopify/unknown.json', json_encode($data)."\n", FILE_APPEND);
}

?>