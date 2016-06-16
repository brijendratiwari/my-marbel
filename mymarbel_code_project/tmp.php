<?php 

include_once 'includes/functions.php';


if ($stmt = $db->prepare("SELECT id FROM m_users WHERE last_activity > UNIX_TIMESTAMP(DATE_ADD(NOW(), INTERVAL -28 DAY))")) {
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id);
	$sql = '';
	while ($stmt->fetch()) {
		if (!empty($sql)) { $sql .= " OR "; }
		$sql .= sprintf("(user_id = '%s' AND country = 'US' AND (order_status = 'qa' OR order_status = 'building' OR order_status = 'balance' OR order_status = 'deposit') AND est_ship_date > 0)", $id);
	}
	echo 'UPDATE m_orders SET est_ship_date = \'1454821200\' WHERE '.$sql;
}
?>