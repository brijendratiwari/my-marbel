<?php 
	include_once '../../functions.php';

	$csv = array_map('str_getcsv', file('..//orders.csv'));
	foreach ($csv as $line) {
		if (is_array($line) && sizeof($line) > 1) {
			$email = $line[0];
			$tracking = $line[1];
			if (!empty($email) && !empty($tracking)) {
				if (!$db->query(sprintf("UPDATE m_orders SET tracking_number = '%s', order_status = 'shipping' WHERE user_id = (SELECT id FROM m_users WHERE email = '%s');", $tracking, $email))) {
					echo($db->error);
				}
			}
		}
	}

	if ($stmt = $db->prepare("SELECT id FROM m_orders WHERE order_status != 'shipping' AND order_status != 'refunded' AND country != 'US' ORDER BY order_date ASC")) {
	    $stmt->execute();
	    $stmt->store_result();	 
	    $stmt->bind_result($id);
	    $i = 0;
	    while ($stmt->fetch()) {
			$estimate = '';
			if ($i < 75) {
				$estimate = 'End of December via Distribution from Frankfurt, Germany';
			} else if ($i < 275) {
				$estimate = 'January 2016 via Distribution from Frankfurt, Germany or Sydney, Australia';
			} else {
				$estimate = 'February 2016 via Distribution from Frankfurt, Germany or Sydney, Australia';
			}

			if (!$db->query(sprintf("UPDATE m_orders SET est_ship_date = '%s' WHERE id = '%s';", $estimate, $id))) {
				echo($db->error);
			}
			$i += 1;
	    }
	}

	if ($stmt = $db->prepare("SELECT id FROM m_orders WHERE order_status != 'shipping' AND order_status != 'refunded' AND country = 'US' ORDER BY order_date ASC")) {
	    $stmt->execute();
	    $stmt->store_result();	 
	    $stmt->bind_result($id);
	    $i = 0;
	    while ($stmt->fetch()) {
			$estimate = '';
			if ($i < 20) {
				$estimate = 'December 4th';
			} else if ($i < 120) {
				$estimate = 'December 11th';
			} else if ($i < 220) {
				$estimate = 'December 18th';
			} else {
				$estimate = 'December 21st - December 31st';
			}

			if (!$db->query(sprintf("UPDATE m_orders SET est_ship_date = '%s' WHERE id = '%s';", $estimate, $id))) {
				echo($db->error);
			}
			$i += 1;
	    }
	}

	$csv = array_map('str_getcsv', file('/var/www/mymarbel/includes/data/shipping_costs.csv'));
	foreach ($csv as $line) {
		$code = $line[0];
		$cost = $line[1];
		if (!empty($code) && !empty($cost)) {
			if (!$db->query(sprintf("UPDATE m_orders SET shipping_cost = '%s' WHERE country = '%s';", $cost, $code))) {
				echo($db->error);
			}
		}
	}
?>