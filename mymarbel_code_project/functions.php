<?php
include_once 'config.php';

/**
	* DATABASE
	*/

	$db = getDb();

	function getDb() {
		return new mysqli(SQL_HOST, SQL_USER, SQL_PASSWORD, SQL_DATABASE);
	}

/** 
	* SECURITY 
  */

	function sec_session_start() {
		session_start();
                if(isset($_SESSION["marbel_user"])) {
                     if(!isLoginSessionExpired()) {
                        
                     } else {
                         
                             header("Location:/logout");
                     }
                }
	}

/**
	* LOGIN
	*/

	function login($email, $password, $db) {
		if ($stmt = $db->prepare("SELECT mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.register_date, mu.last_activity, mu.phone, mua.password, mua.salt FROM m_users mu LEFT JOIN m_user_auth mua ON mua.user_id = mu.id WHERE mu.email = ? LIMIT 1")) {
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();

			$stmt->bind_result($user_id, $email, $first_name, $last_name, $type, $register_date, $last_activity, $phone, $db_password, $salt);
			$stmt->fetch();
			$ip_address = getClientIP();
			$password = hash('sha512', $password . $salt);
			if ($stmt->num_rows == 1) {
				$stmt->close();
				if (checkbrute($user_id, $db)) {
					return 1;
				} else {
					if ($db_password == $password) {
                                            $userTypeName='';    
                                                if($type==1)
                                                 $userTypeName='admin';
                                                 if($type==2)
                                                   $userTypeName='employee';
                                                 if($type==3)
                                                   $userTypeName='investor';
                                                 if($type==4)
                                                   $userTypeName='customer';
                                                 if($type==5)
                                                   $userTypeName='dealer';
                                            $user_browser = $_SERVER['HTTP_USER_AGENT'];
						$mUser = array(
							'user_id'       => $user_id,
							'email' 	     	=> $email,
							'first_name'    => $first_name,
							'last_name'     => $last_name,
							'type'          => $userTypeName, 
                                                        'type_id'          => $type,
							'register_date' => $register_date,
							'last_activity' => $last_activity,
							'phone'         => $phone,
							'ip_address'    => $ip_address,
                                                        'loggedin_time' => time(),
							);
						$_SESSION['marbel_user'] = $mUser;
						$_SESSION['login_string'] = hash('sha512', $password . $user_browser);
						$time = time();
						$db->query(sprintf("UPDATE m_users SET last_activity = '%s' WHERE id = '%s';", $time, $user_id));
						$db->query(sprintf("INSERT INTO m_user_login_ip (user_id, ip, time) VALUES ('%s', '%s', '%s');", $user_id, $ip_address, $time));
						return 0;
					} else {
						$db->query(sprintf("INSERT INTO m_user_login_attempts (user_id, ip, time) VALUES ('%s', '%s', '%s');", $user_id, $ip_address, time()));
						return 2;
					}
				}
			} else {
				$stmt->close();
				return 2;
			}
		}
	}
	
	
	function getAppUserByEmail($email, $db) {	        
		$customer = array();
		if ($stmt = $db->prepare("SELECT mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.register_date, mu.last_activity, mu.phone, mu.notes, mua.password, mua.salt FROM m_users mu LEFT JOIN m_user_auth mua ON mua.user_id = mu.id WHERE mu.email = ? ORDER BY id ASC;")) {
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($user_id, $email, $first_name, $last_name, $type, $register_date, $last_activity, $phone, $notes, $db_password, $salt);		
			while ($stmt->fetch()) {
				$customer = array(
					'user_id'       => $user_id,
					'email'         => $email,
					'first_name'    => $first_name,
					'last_name'     => $last_name,
					'type'          => $type,
					'register_date' => $register_date,
					'last_activity' => $last_activity, 
					'phone'         => $phone, 
					'notes'         => $notes,
					'db_password'   => $db_password, 
					'salt'         =>  $salt 
					);
			}
			
			$stmt->close();
		}
		return $customer;
		
	/*	$customer = array();
		if ($stmt = $db->prepare("SELECT mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.register_date, mu.last_activity, mu.phone, mu.notes, muli.ip FROM m_users mu LEFT JOIN m_user_login_ip muli ON muli.user_id = mu.id AND muli.time = mu.last_activity WHERE mu.email = ? ORDER BY id ASC;")) {
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($user_id, $email, $first_name, $last_name, $type, $register_date, $last_activity, $phone, $notes, $last_ip);
			while ($stmt->fetch()) {
				$customer = array(
					'user_id'       => $user_id,
					'email'         => $email,
					'first_name'    => $first_name,
					'last_name'     => $last_name,
					'type'          => $type,
					'register_date' => $register_date,
					'last_activity' => $last_activity, 
					'last_ip'       => $last_ip, 
					'phone'         => $phone, 
					'notes'         => $notes
					);
			}
			$stmt->close();
		}
		return $customer;
		*/
	}
	

	function checkbrute($user_id, $db) {
		if ($stmt = $db->prepare("SELECT time FROM m_user_login_attempts WHERE user_id = ? AND time > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 HOUR))")) {
			$stmt->bind_param('i', $user_id);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows > 5) {
				$stmt->close();
				return true;
			}
			$stmt->close();
		}
		return false;
	}

	function login_check($db) {
		if (isset($_SESSION['marbel_user'], $_SESSION['login_string'])) {
			$marbel_user = $_SESSION['marbel_user'];
			$login_string = $_SESSION['login_string'];
			$user_browser = $_SERVER['HTTP_USER_AGENT'];
			if ($stmt = $db->prepare("SELECT password FROM m_user_auth WHERE user_id = ? LIMIT 1")) {
				$stmt->bind_param('i', $marbel_user['user_id']);
				$stmt->execute();
				$stmt->store_result();
				if ($stmt->num_rows == 1) {
					$stmt->bind_result($password);
					$stmt->fetch();
					$stmt->close();
					$login_check = hash('sha512', $password . $user_browser);
					if ($login_check == $login_string) {
						return true;
					}
				}
				$stmt->close();
			}
		}
		return false;
	}

/**
	* USER FUNCTIONS
	*/

	function insertUser($email, $first_name, $last_name, $type, $parent_type, $phone, $notes, $password, $salt, $db) {
		if ($stmt = $db->prepare("SELECT id FROM m_users WHERE email = ? LIMIT 1")) {
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();

			$stmt->bind_result($user_id);
			$stmt->fetch();
			if ($stmt->num_rows == 0) {
				$db->query(sprintf("INSERT INTO m_users (email, first_name, last_name, type, parent_type, register_date, last_activity, phone, notes) VALUES ('%s', '%s', '%s', '%s', '%s', UNIX_TIMESTAMP(NOW()), UNIX_TIMESTAMP(NOW()), '%s', '%s');", mysqli_real_escape_string($db, $email), mysqli_real_escape_string($db, $first_name), mysqli_real_escape_string($db, $last_name), $type, $parent_type, mysqli_real_escape_string($db, $phone), mysqli_real_escape_string($db, $notes)));
				$stmt->execute();
				$stmt->store_result();

				$stmt->bind_result($user_id);
				$stmt->fetch();
				if ($stmt->num_rows == 1) {
					$stmt->close();
					$db->query(sprintf("INSERT INTO m_user_auth (user_id, password, salt) VALUES ('%s', '%s', '%s');", $user_id, $password, $salt));
					return 0;
				} else {
					return 2;
				}
			} else {
				return 1;
			}
		}
		return 3;
	}


        function adminUpdateCustomer($user_id, $first_name, $last_name, $type, $parent_type, $email, $phone, $password, $salt, $notes, $db) {
		$db->query(sprintf("UPDATE m_users SET email = '%s', first_name = '%s', last_name = '%s', type = '%s', parent_type = '%s', phone = '%s', notes = '%s' WHERE id = '%s';", mysqli_real_escape_string($db, $email), mysqli_real_escape_string($db, $first_name), mysqli_real_escape_string($db, $last_name), $type,$parent_type, mysqli_real_escape_string($db, $phone), mysqli_real_escape_string($db, $notes), $user_id));
		if (!empty($password) && !empty($salt)) {
			$db->query(sprintf("UPDATE m_user_auth SET password = '%s', salt = '%s' WHERE user_id = '%s';", $password, $salt, $user_id));
		}
		return 0;
	}

	function updateUser($user_id, $email, $first_name, $last_name, $type, $phone, $notes, $password, $salt, $db) {
		$db->query(sprintf("UPDATE m_users SET email = '%s', first_name = '%s', last_name = '%s', phone = '%s' WHERE id = '%s';", mysqli_real_escape_string($db, $email), mysqli_real_escape_string($db, $first_name), mysqli_real_escape_string($db, $last_name), mysqli_real_escape_string($db, $phone), $user_id));
		if (!empty($password)) {
			$db->query(sprintf("UPDATE m_user_auth SET password = '%s', salt = '%s' WHERE user_id = '%s';", $password, $salt, $user_id));
			$user_browser = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['login_string'] = hash('sha512', $password . $user_browser);
		}
		return 0;
	}

	function deleteUser($user_id, $db) {
		$db->query(sprintf('DELETE FROM m_users WHERE id = "%s"', $user_id));
		$db->query(sprintf('DELETE FROM m_user_auth WHERE user_id = "%s"', $user_id));	
	}


	function getTotalCustomers($db) {
		if ($stmt = $db->prepare("SELECT COUNT(*) FROM m_users")) {
			$stmt->execute();
			$stmt->store_result();

			$stmt->bind_result($count);
			$stmt->fetch();
			if ($stmt->num_rows == 1) {
				$stmt->close();
				return $count;
			}
			$stmt->close();
		}
		return 0;
	}

	function getCustomers($custPerPage, $pageNumber, $db) {	        
		$customers = array();
		if ($stmt = $db->prepare("SELECT mu.id, mu.email, mu.first_name, mu.last_name, mu.type mu.register_date, mu.last_activity, mu.phone, mu.notes, muli.ip FROM m_users mu LEFT JOIN m_user_login_ip muli ON muli.user_id = mu.id AND muli.time = mu.last_activity WHERE mu.type = 'customer' ORDER BY id ASC LIMIT ?, ?;")) {
			$stmt->bind_param('ii', floor($pageNumber * $custPerPage), $custPerPage);
			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($user_id, $email, $first_name, $last_name, $type, $register_date, $last_activity, $phone, $notes, $last_ip);
			while ($stmt->fetch()) {
				$customers[] = array(
					'user_id'       => $user_id,
					'email'         => $email,
					'first_name'    => $first_name,
					'last_name'     => $last_name,
					'type'          => $type,
					'register_date' => $register_date,
					'last_activity' => $last_activity, 
					'last_ip'       => $last_ip, 
					'phone'         => $phone, 
					'notes'         => $notes
					);
			}
			$stmt->close();
		}
		return $customers;
	}

	function getAdmins($db) {	        
		$customers = array();
		if ($stmt = $db->prepare("SELECT mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.register_date, mu.last_activity, mu.phone, mu.notes, muli.ip FROM m_users mu LEFT JOIN m_user_login_ip muli ON muli.user_id = mu.id AND muli.time = mu.last_activity WHERE mu.type = 'admin' ORDER BY id ASC;")) {
			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($user_id, $email, $first_name, $last_name, $type, $register_date, $last_activity, $phone, $notes, $last_ip);
			while ($stmt->fetch()) {
				$customers[] = array(
					'user_id'       => $user_id,
					'email'         => $email,
					'first_name'    => $first_name,
					'last_name'     => $last_name,
					'type'          => $type,
					'register_date' => $register_date,
					'last_activity' => $last_activity, 
					'last_ip'       => $last_ip, 
					'phone'         => $phone, 
					'notes'         => $notes
					);
			}
			$stmt->close();
		}
		return $customers;
	}
        function getUserType($db) {	        
		$userType = array();
		if ($stmt = $db->prepare("SELECT user_role_type,id,parent FROM m_users_level  WHERE status = '1'")) {
			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($user_role_type,$id, $parent);
			while ($stmt->fetch()) {
				$userType[] = array(
					'id'                     => $id,
					'user_role_type'         => $user_role_type,
					'parent' =>$parent
					);
			}
			$stmt->close();
		}
		return $userType;
	}
        
	function getCustomer($id, $db) {	        
		$customer = array();
		if ($stmt = $db->prepare("SELECT mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.parent_type, mu.register_date, mu.last_activity, mu.phone, mu.notes, muli.ip FROM m_users mu LEFT JOIN m_user_login_ip muli ON muli.user_id = mu.id AND muli.time = mu.last_activity WHERE mu.id = ? ORDER BY id ASC;")) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($user_id, $email, $first_name, $last_name, $type,$type_parent, $register_date, $last_activity, $phone, $notes, $last_ip);
			while ($stmt->fetch()) {
				$customer = array(
					'user_id'       => $user_id,
					'email'         => $email,
					'first_name'    => $first_name,
					'last_name'     => $last_name,
					'type'          => $type,
                                        'parent_type'   => $type_parent,
					'register_date' => $register_date,
					'last_activity' => $last_activity, 
					'last_ip'       => $last_ip, 
					'phone'         => $phone, 
					'notes'         => $notes
					);
			}
			$stmt->close();
		}
		return $customer;
	}
	function getCustomerByEmail($email, $db) {	        
		$customer = array();
		if ($stmt = $db->prepare("SELECT mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.register_date, mu.last_activity, mu.phone, mu.notes, muli.ip FROM m_users mu LEFT JOIN m_user_login_ip muli ON muli.user_id = mu.id AND muli.time = mu.last_activity WHERE mu.email = ? ORDER BY id ASC;")) {
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($user_id, $email, $first_name, $last_name, $type, $register_date, $last_activity, $phone, $notes, $last_ip);
			while ($stmt->fetch()) {
				$customer = array(
					'user_id'       => $user_id,
					'email'         => $email,
					'first_name'    => $first_name,
					'last_name'     => $last_name,
					'type'          => $type,
					'register_date' => $register_date,
					'last_activity' => $last_activity, 
					'last_ip'       => $last_ip, 
					'phone'         => $phone, 
					'notes'         => $notes
					);
			}
			$stmt->close();
		}
		return $customer;
	}

	function updatePassword($email, $resetKey, $newPassword, $db) {
		if ($stmt = $db->prepare("SELECT mua.salt FROM m_user_auth mua LEFT JOIN m_users mu ON mu.id = mua.user_id WHERE mu.email = ? LIMIT 1")) {
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows == 1) {
				$stmt->bind_result($salt);
				$stmt->fetch();
				$key = hash('sha512', 'reset-password-key' . $salt);
				if (strcmp($key, $resetKey) !== 0) { return 1; }
				$newSalt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
				$password = hash('sha512', $newPassword . $newSalt);
				if (!$db->query(sprintf("UPDATE m_user_auth SET password = '%s', salt = '%s' WHERE user_id = (SELECT id FROM m_users WHERE email = '%s');", $password, $newSalt, $email))) {
					return $db->error;
				}	
				return 0;
			}
		}
		return 2;
	}

/**
	*	ORDER FUNCTIONS
	*/

	function adminUpdateOrder($userId, $orderId, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $wheel_color, $wheel_size, $product,$order_total, $shipping_cost, $order_status, $invoice_url, $est_ship_date, $est_ship_location, $firmware_version, $deck_serial_number, $main_serial_number, $tracking_number, $notes, $priority, $db, $checkEmpty = false) {
		if ($stmt = $db->prepare("SELECT id, order_status, order_number, delivery_address, delivery_address_2, city, state, zip, country, wheel_color, wheel_size, product, order_total, shipping_cost, invoice_url, est_ship_date, est_ship_location, firmware_version, deck_serial_number, main_serial_number, tracking_number, notes, priority FROM m_orders WHERE id = ?;")) {
			$stmt->bind_param('i', $orderId);
			$stmt->execute();
			$stmt->store_result();

			$stmt->bind_result($id, $order_status2, $order_number2, $delivery_address2, $delivery_address_22, $city2, $state2, $zip2, $country2, $wheel_color2, $wheel_size2, $product2, $order_total2, $shipping_cost2, $invoice_url2, $est_ship_date2, $est_ship_location2, $firmware_version2, $deck_serial_number2, $main_serial_number2, $tracking_number2, $notes2, $priority2);
			$stmt->fetch();
			if ($stmt->num_rows >= 1) {
				if (strcmp($delivery_address, $delivery_address2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the delivery address from "%s" to "%s"', $delivery_address2, $delivery_address), $db); }
				if (strcmp($delivery_address_2, $delivery_address_22) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the delivery address 2 from "%s" to "%s"', $delivery_address_22, $delivery_address_2), $db); }
				if (strcmp($city, $city2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the city from "%s" to "%s"', $city2, $city), $db); }
				if (strcmp($state, $state2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the state from "%s" to "%s"', $state2, $state), $db); }
				if (strcmp($zip, $zip2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the zip code from "%s" to "%s"', $zip2, $zip), $db); }
				if (strcmp($country, $country2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the country from "%s" to "%s"', $country2, $country), $db); }
				if (strcmp($wheel_color, $wheel_color2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the wheel color from "%s" to "%s"', $wheel_color2, $wheel_color), $db); }
				if (strcmp($wheel_size, $wheel_size2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the wheel size from "%s" to "%s"', $wheel_size2, $wheel_size), $db); }
				if (strcmp($product, $product2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the product from "%s" to "%s"', $product2, $product), $db); }
				if (strcmp($order_total, $order_total2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the total from "%s" to "%s"', $order_total2, $order_total), $db); }
				if (strcmp($order_status, $order_status2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the status from "%s" to "%s"', $order_status2, $order_status), $db); }
				if (strcmp($shipping_cost, $shipping_cost2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the shipping cost from "%s" to "%s"', $shipping_cost2, $shipping_cost), $db); }
				if (strcmp($invoice_url, $invoice_url2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the invoice url from "%s" to "%s"', $invoice_url2, $invoice_url), $db); }
				if (strcmp(strtotime($est_ship_date), $est_ship_date2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the estimated shipping date from "%s" to "%s"', $est_ship_date2, strtotime($est_ship_date)), $db); }
				if (strcmp($est_ship_location, $est_ship_location2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the estimated shipping location from "%s" to "%s"', $est_ship_location2, $est_ship_location), $db); }
				if (strcmp($firmware_version, $firmware_version2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the firmware version from "%s" to "%s"', $firmware_version2, $firmware_version), $db); }
				if (strcmp($deck_serial_number, $deck_serial_number2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the deck serial number from "%s" to "%s"', $deck_serial_number2, $deck_serial_number), $db); }
				if (strcmp($main_serial_number, $main_serial_number2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the main serial number from "%s" to "%s"', $main_serial_number2, $main_serial_number), $db); }
				if (strcmp($tracking_number, $tracking_number2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the tracking number from "%s" to "%s"', $tracking_number2, $tracking_number), $db); }
				if (strcmp($notes, $notes2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the notes from "%s" to "%s"', $notes2, $notes), $db); }
				if (strcmp($priority, $priority2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the Shipping Priority from "%s" to "%s"', $priority2, $priority), $db); }

				$sql = sprintf("UPDATE m_orders SET delivery_address = '%s', delivery_address_2 = '%s', city = '%s', state = '%s', zip = '%s', country = '%s', wheel_color = '%s', wheel_size = '%s', product = '%s', order_total = '%s', shipping_cost = '%s', order_status = '%s', invoice_url = '%s', est_ship_date = '%s', est_ship_location = '%s', firmware_version = '%s', deck_serial_number = '%s', main_serial_number = '%s', tracking_number = '%s', notes = '%s', priority = '%s' WHERE id = '%s';", mysqli_real_escape_string($db, $delivery_address), mysqli_real_escape_string($db, $delivery_address_2), mysqli_real_escape_string($db, $city), mysqli_real_escape_string($db, $state), mysqli_real_escape_string($db, $zip), mysqli_real_escape_string($db, $country), mysqli_real_escape_string($db, $wheel_color), mysqli_real_escape_string($db, $wheel_size), mysqli_real_escape_string($db, $product), mysqli_real_escape_string($db, $order_total), mysqli_real_escape_string($db, $shipping_cost), mysqli_real_escape_string($db, $order_status), mysqli_real_escape_string($db, $invoice_url), mysqli_real_escape_string($db, strtotime($est_ship_date)), mysqli_real_escape_string($db, $est_ship_location), mysqli_real_escape_string($db, $firmware_version), mysqli_real_escape_string($db, $deck_serial_number), mysqli_real_escape_string($db, $main_serial_number), mysqli_real_escape_string($db, $tracking_number), mysqli_real_escape_string($db, $notes), mysqli_real_escape_string($db, $priority), $orderId);
				$db->query($sql);
			}
		}
	}

	function getRecentOrderLog($orderId, $db) {
		$orderLog = array();
		if ($stmt = $db->prepare("SELECT mu.id, mu.first_name, mu.last_name, mol.notes, mol.date FROM m_order_logs mol LEFT JOIN m_users mu ON mu.id = mol.author_id WHERE mol.order_id = ? ORDER BY mol.date DESC;")) {
			$stmt->bind_param('i', $orderId);
			$stmt->execute();
			$stmt->store_result();

			$stmt->bind_result($userId, $firstName, $lastName, $notes, $date);
			while ($stmt->fetch()) {
				if (strpos($notes, 'estimated shipping date') !== FALSE) {
					$str = parseString($notes, "\"", "\"");
					$date1 = $str[0];
					$date2 = $str[1];
					$notes = str_replace($date1, date("F j, Y", $date1), $notes);
					$notes = str_replace($date2, date("F j, Y", $date2), $notes);
				}
				$orderLog[] = array(
					'user_id' => $userId,
					'name' => $firstName.' '.$lastName, 
					'notes' => $notes,
					'date' => date("F j, Y, g:i a", strtotime($date))
					);
			}
		}
		return $orderLog;
	}

	function updateOrder($userId, $orderId, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $wheel_color, $wheel_size, $db) {
		if ($stmt = $db->prepare("SELECT id, order_status, order_number, delivery_address, delivery_address_2, city, state, zip, country, wheel_color, wheel_size FROM m_orders WHERE id = ? AND order_status != 'shipping' AND order_status != 'refunded';")) {
			$stmt->bind_param('i', $orderId);
			$stmt->execute();
			$stmt->store_result();

			$stmt->bind_result($id, $order_status2, $order_number2, $delivery_address2, $delivery_address_22, $city2, $state2, $zip2, $country2, $wheel_color2, $wheel_size2);
			$stmt->fetch();
			if ($stmt->num_rows >= 1) {
				if (strcmp($delivery_address, $delivery_address2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the delivery address to "%s"', $delivery_address), $db); }
				if (strcmp($delivery_address_2, $delivery_address_22) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the delivery address 2 to "%s"', $delivery_address_2), $db); }
				if (strcmp($city, $city2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the city to "%s"', $city), $db); }
				if (strcmp($state, $state2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the state to "%s"', $state), $db); }
				if (strcmp($zip, $zip2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the zip code to "%s"', $zip), $db); }
				if (strcmp($country, $country2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the country to "%s"', $country), $db); }
				if (strcmp($wheel_color, $wheel_color2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the wheel color to "%s"', $wheel_color), $db); }
				if (strcmp($wheel_size, $wheel_size2) !== 0) { logOrderUpdate($id, $userId, sprintf('Updated the wheel size to "%s"', $wheel_size), $db); }

				$db->query(sprintf("UPDATE m_orders SET delivery_address = '%s', delivery_address_2 = '%s', city = '%s', state = '%s', zip = '%s', country = '%s', wheel_color = '%s', wheel_size = '%s' WHERE order_number = '%s';", mysqli_real_escape_string($db, $delivery_address), mysqli_real_escape_string($db, $delivery_address_2), mysqli_real_escape_string($db, $city), mysqli_real_escape_string($db, $state), mysqli_real_escape_string($db, $zip), mysqli_real_escape_string($db, $country), mysqli_real_escape_string($db, $wheel_color), mysqli_real_escape_string($db, $wheel_size), $order_number));
				return 0;
			}
			return 1;
		}
		return 2;
	}

	function logOrderUpdate($orderId, $userId, $text, $db) {
		$sql = sprintf("INSERT INTO m_order_logs (author_id, order_id, notes) VALUES('%s', '%s', '%s')", $userId, $orderId, mysqli_real_escape_string($db, $text));
		$db->query($sql);
	}

	function deleteOrder($order_number, $db) {
		$db->query(sprintf('DELETE FROM m_orders WHERE order_number = "%s"', $order_number));
	}

	function insertOrder($email, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $order_total, $order_status, $invoice_url, $order_date, $est_ship_date, $est_ship_location, $product, $wheel_color, $wheel_size, $firmware_version, $deck_serial_number, $main_serial_number, $tracking_number, $notes, $priority, $db) {
		if ($stmt = $db->prepare("SELECT id FROM m_users WHERE email = ? LIMIT 1")) {
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();

			$stmt->bind_result($user_id);
			$stmt->fetch();
			if ($stmt->num_rows == 1) {
				$stmt->close();
				if ($stmt = $db->prepare("SELECT id FROM m_orders WHERE order_number = ? LIMIT 1")) {
					$stmt->bind_param('s', $order_number);
					$stmt->execute();
					$stmt->store_result();

					$stmt->bind_result($id);
					$stmt->fetch();
					if ($stmt->num_rows == 0) {
						$stmt->close();
						$sql = (sprintf("INSERT INTO m_orders (user_id, order_number, delivery_address, delivery_address_2, city, state, zip, country, order_total, order_status, invoice_url, order_date, est_ship_date, est_ship_location, product, wheel_color, wheel_size, firmware_version, deck_serial_number, main_serial_number, tracking_number, notes, priority) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');", $user_id, mysqli_real_escape_string($db, $order_number), mysqli_real_escape_string($db, $delivery_address), mysqli_real_escape_string($db, $delivery_address_2), mysqli_real_escape_string($db, $city), mysqli_real_escape_string($db, $state), mysqli_real_escape_string($db, $zip), mysqli_real_escape_string($db, $country), mysqli_real_escape_string($db, $order_total), mysqli_real_escape_string($db, $order_status), mysqli_real_escape_string($db, $invoice_url), mysqli_real_escape_string($db, $order_date), mysqli_real_escape_string($db, $est_ship_date), mysqli_real_escape_string($db, $est_ship_location), mysqli_real_escape_string($db, $product), mysqli_real_escape_string($db, $wheel_color), mysqli_real_escape_string($db, $wheel_size), mysqli_real_escape_string($db, $firmware_version), mysqli_real_escape_string($db, $deck_serial_number), mysqli_real_escape_string($db, $main_serial_number), mysqli_real_escape_string($db, $tracking_number), mysqli_real_escape_string($db, $notes), mysqli_real_escape_string($db, $priority)));
						$db->query($sql);
						return 0;
					} else {
						return 2;
					}
				}
			} else {
				$stmt->close();
				return 1;
			}
		}
		return 2;
	}

	function getOrder($order_id, $db) {	        
		$order = array();
		if ($stmt = $db->prepare("SELECT user_id, order_number, delivery_address, delivery_address_2, city, state, zip, country, order_total, order_status, invoice_url, order_date, est_ship_date, est_ship_location, product, wheel_color, wheel_size, firmware_version, deck_serial_number, main_serial_number, tracking_number, shipping_cost, notes, priority FROM m_orders WHERE id = ? ORDER BY id ASC LIMIT 1")) {
			$stmt->bind_param('s', $order_id);
			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($user_id, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $order_total, $order_status, $invoice_url, $order_date, $est_ship_date, $est_ship_location, $product, $wheel_color, $wheel_size, $firmware_version, $deck_serial_number, $main_serial_number, $tracking_number, $shipping_costs, $notes, $priority);
			while ($stmt->fetch()) {
				$order = array(
					'user_id'             => $user_id,
					'order_number'        => $order_number,
					'delivery_address'    => $delivery_address,
					'delivery_address_2'  => $delivery_address_2,
					'city'                => $city,
					'state'               => $state,
					'zip'                 => $zip,
					'country'             => $country,
					'order_total'         => $order_total,
					'order_status'        => $order_status,
					'invoice_url'         => $invoice_url,
					'order_date'          => $order_date,
					'est_ship_date'       => $est_ship_date,
					'est_ship_location'   => $est_ship_location,
					'product'             => $product,
					'wheel_color'         => $wheel_color,
					'wheel_size'          => $wheel_size,
					'firmware_version'    => $firmware_version, 
					'deck_serial_number'  => $deck_serial_number, 
					'main_serial_number'  => $main_serial_number,
					'tracking_number'     => $tracking_number,
					'shipping_cost'       => $shipping_costs,
					'notes'               => $notes,
					'priority'               => $priority
					);
				if ($order['order_status'] == 'deposit') {
					$order['order_friendly_status'] = 'Deposit Paid';
				} else if ($order['order_status'] == 'balance') {
					$order['order_friendly_status'] = 'Fully Paid';
				} else if ($order['order_status'] == 'refunded') {
					$order['order_friendly_status'] = 'Refunded';
				} else if ($order['order_status'] == 'building') {
					$order['order_friendly_status'] = 'Building';
				} else if ($order['order_status'] == 'qa') {
					$order['order_friendly_status'] = 'Quality Assurance';
				} else if ($order['order_status'] == 'shipping') {
					$order['order_friendly_status'] = 'Shipping';
				} else if ($order['order_status'] == 'shipped') {
					$order['order_friendly_status'] = 'Shipped';
				} else if ($order['order_status'] == 'hold') {
					$order['order_friendly_status'] = 'On Hold';
				} 
			}
			$stmt->close();
		}
		return $order;
	}


function getOrderByNumber($order_number, $db) {	        
	$order = array();
	if ($stmt = $db->prepare("SELECT user_id, order_number, delivery_address, delivery_address_2, city, state, zip, country, order_total, order_status, invoice_url, order_date, est_ship_date, est_ship_location, product, wheel_color, wheel_size, firmware_version, deck_serial_number, main_serial_number, tracking_number, shipping_cost, notes, priority FROM m_orders WHERE order_number = ? ORDER BY id ASC LIMIT 1")) {
		$stmt->bind_param('s', $order_number);
		$stmt->execute();
		$stmt->store_result();	 
		$stmt->bind_result($user_id, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $order_total, $order_status, $invoice_url, $order_date, $est_ship_date, $est_ship_location, $product, $wheel_color, $wheel_size, $firmware_version, $deck_serial_number, $main_serial_number, $tracking_number, $shipping_costs, $notes, $priority);
		while ($stmt->fetch()) {
			$order = array(
				'user_id'             => $user_id,
				'order_number'        => $order_number,
				'delivery_address'    => $delivery_address,
				'delivery_address_2'  => $delivery_address_2,
				'city'                => $city,
				'state'               => $state,
				'zip'                 => $zip,
				'country'             => $country,
				'order_total'         => $order_total,
				'order_status'        => $order_status,
				'invoice_url'         => $invoice_url,
				'order_date'          => $order_date,
				'est_ship_date'       => $est_ship_date,
				'est_ship_location'   => $est_ship_location,
				'product'             => $product,
				'wheel_color'         => $wheel_color,
				'wheel_size'          => $wheel_size,
				'firmware_version'    => $firmware_version, 
				'deck_serial_number'  => $deck_serial_number, 
				'main_serial_number'  => $main_serial_number,
				'tracking_number'     => $tracking_number,
				'shipping_cost'       => $shipping_costs,
				'notes'               => $notes,
				'priority'               => $priority
				);
			if ($order['order_status'] == 'deposit') {
				$order['order_friendly_status'] = 'Deposit Paid';
			} else if ($order['order_status'] == 'balance') {
				$order['order_friendly_status'] = 'Fully Paid';
			} else if ($order['order_status'] == 'refunded') {
				$order['order_friendly_status'] = 'Refunded';
			} else if ($order['order_status'] == 'building') {
				$order['order_friendly_status'] = 'Building';
			} else if ($order['order_status'] == 'qa') {
				$order['order_friendly_status'] = 'Quality Assurance';
			} else if ($order['order_status'] == 'shipping') {
				$order['order_friendly_status'] = 'Shipping';
			} else if ($order['order_status'] == 'shipped') {
				$order['order_friendly_status'] = 'Shipped';
			} else if ($order['order_status'] == 'hold') {
				$order['order_friendly_status'] = 'On Hold';
			} 
		}
		$stmt->close();
	}
	return $order;
}

function getOrders($user_id, $db) {	        
	$orders = array();
	if ($stmt = $db->prepare("SELECT id, order_number, delivery_address, delivery_address_2, city, state, zip, country, order_total, order_status, invoice_url, order_date, est_ship_date, est_ship_location, product, wheel_color, wheel_size, firmware_version, deck_serial_number, main_serial_number, tracking_number, notes, priority FROM m_orders mo WHERE mo.user_id = ? ORDER BY id ASC")) {
		$stmt->bind_param('s', $user_id);
		$stmt->execute();
		$stmt->store_result();	 
		$stmt->bind_result($orderId, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $order_total, $order_status, $invoice_url, $order_date, $est_ship_date, $est_ship_location,  $product, $wheel_color, $wheel_size, $firmware_version, $deck_serial_number, $main_serial_number, $tracking_number, $notes, $priority);
		while ($stmt->fetch()) {
			$order = array(
				'user_id'             => $user_id,
				'id'                  => $orderId, 
				'order_number'        => $order_number,
				'delivery_address'    => $delivery_address,
				'delivery_address_2'  => $delivery_address_2,
				'city'                => $city,
				'state'               => $state,
				'zip'                 => $zip,
				'country'             => $country,
				'order_total'         => $order_total,
				'order_status'        => $order_status,
				'invoice_url'         => $invoice_url,
				'order_date'          => $order_date,
				'est_ship_date'       => $est_ship_date,
				'est_ship_location'   => $est_ship_location,
				'product'             => $product,
				'wheel_color'         => $wheel_color,
				'wheel_size'          => $wheel_size,
				'firmware_version'    => $firmware_version, 
				'deck_serial_number'  => $deck_serial_number, 
				'main_serial_number'  => $main_serial_number,
				'tracking_number'     => $tracking_number,
				'notes'               => $notes,
				'priority'               => $priority
				);
			if ($order['order_status'] == 'deposit') {
				$order['order_friendly_status'] = 'Deposit Paid';
			} else if ($order['order_status'] == 'balance') {
				$order['order_friendly_status'] = 'Fully Paid';
			} else if ($order['order_status'] == 'refunded') {
				$order['order_friendly_status'] = 'Refunded';
			} else if ($order['order_status'] == 'building') {
				$order['order_friendly_status'] = 'Building';
			} else if ($order['order_status'] == 'qa') {
				$order['order_friendly_status'] = 'Quality Assurance';
			} else if ($order['order_status'] == 'shipping') {
				$order['order_friendly_status'] = 'Shipping';
			}  else if ($order['order_status'] == 'shipped') {
				$order['order_friendly_status'] = 'Shipped';
			} else if ($order['order_status'] == 'hold') {
				$order['order_friendly_status'] = 'On Hold';
			} 
			$estShipping = $order['est_ship_date'];
			$estShippingLocation = $order['est_ship_location'];

			if (intval(date('his', $estShipping)) == 120000 && intval(date('j', $estShipping)) == 1) { $estShipping = 'in '.date('M, Y', $estShipping); }
			else { $estShipping =  'by '.date('M j, Y', $estShipping); };
			if (!empty($estShippingLocation)) {
				$estShipping .= ' via '.$estShippingLocation;
			}
			$order['friendly_est_ship_date'] = $estShipping;

			$orders[] = $order;
		}
		$stmt->close();
	}
	return $orders;
}


/**
	* SERVICE FUNCTIONS
	*/

	function getService($service_id, $db) {	        
		$order = array();
		if ($stmt = $db->prepare("SELECT s.id, s.order_id, o.user_id, o.order_number, s.status, s.type, s.priority, s.due_date, s.tracking_in, s.tracking_out, s.issue, s.date, s.suggested_response, s.suggested_response_admin_id, s.suggested_response_date, s.diagnostic_response, s.included_parts, s.test_ride_complete, s.test_ride_admin_id, s.test_ride_date, s.final_test_ride_complete, s.final_test_ride_admin_id, s.final_test_ride_date, s.qa_complete, s.qa_admin_id, s.qa_date, s.notes, s.customer_notes FROM m_services s LEFT JOIN m_orders o ON o.id = s.order_id WHERE s.id = ? ORDER BY s.id ASC LIMIT 1")) {
			$stmt->bind_param('s', $service_id);
			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($id, $order_id, $user_id, $order_number, $status, $type, $priority, $due_date, $tracking_in, $tracking_out, $issue, $date, $suggested_response, $suggested_response_admin_id, $suggested_response_date, $diagnostic_response, $included_parts, $test_ride_complete, $test_ride_admin_id, $test_ride_date, $final_test_ride_complete, $final_test_ride_admin_id, $final_test_ride_date, $qa_complete, $qa_admin_id, $qa_date, $notes, $customer_notes);
			while ($stmt->fetch()) {
				$included_pts = array();
				foreach (explode(',', $included_parts) as $part) { $included_pts[] = $part; } 
				$service = array(
					'id' => $id,
					'customer' => getCustomer($user_id, $db),
					'order' => getOrderByNumber($order_number, $db), 
					'order_id' => $order_id,
					'status' => $status, 
					'type' => $type, 
					'priority' => $priority, 
					'due_date' => strtotime($due_date), 
					'tracking_in' => $tracking_in, 
					'tracking_out' => $tracking_out, 
					'issue' => $issue, 
					'date' => strtotime($date), 
					'suggested_response' => $suggested_response, 
					'suggested_response_admin' => getCustomer($suggested_response_admin_id, $db), 
					'suggested_response_date' => $suggested_response_date, 
					'diagnostic_response' => $diagnostic_response, 
					'included_parts' => $included_pts, 
					'test_ride_complete' => $test_ride_complete, 
					'test_ride_admin' => getCustomer($test_ride_admin_id, $db), 
					'test_ride_date' => $test_ride_date, 
					'final_test_ride_complete' => $final_test_ride_complete, 
					'final_test_ride_admin' => getCustomer($final_test_ride_admin_id, $db), 
					'final_test_ride_date' => $final_test_ride_date, 
					'qa_complete' => $qa_complete, 
					'qa_admin' => getCustomer($qa_admin_id, $db), 
					'qa_date' => $qa_date, 
					'notes' => $notes, 
					'customer_notes' => $customer_notes,
					'services' => array()
				);
				if ($stmt2 = $db->prepare("SELECT s.id, s.service_name, s.quantity, s.rate, s.amount, s.description, s.discount, s.date, s.complete, s.admin_id, c.first_name, c.last_name, s.complete_date FROM m_service_items s LEFT JOIN m_users c ON c.id = s.admin_id WHERE service_id = ?;")) {
					$stmt2->bind_param('i', $service_id);
					$stmt2->execute();
					$stmt2->store_result();
					$stmt2->bind_result($serviceId, $serviceName, $serviceQuantity, $serviceRate, $serviceAmount, $serviceDesc, $serviceDiscount, $serviceDate, $serviceComplete, $serviceAdminId, $adminFirstName, $adminLastName, $serviceCompleteDate);
					if ($stmt2->num_rows >= 1) {
						while ($stmt2->fetch()) {
							$service['services'][] = array(
								'name' => $serviceName, 
								'quantity' => $serviceQuantity,
								'rate' => $serviceRate,
								'amount' => $serviceAmount,
								'description' => $serviceDesc, 
								'discount' => $serviceDiscount, 
								'date' => strtotime($serviceDate),
								'complete' => $serviceComplete,
								'admin_id' => $serviceAdminId,
								'admin_name' => $adminFirstName.' '.$adminLastName,
								'complete_date' => $serviceCompleteDate
							);
						}
					}
				}
			}
			$stmt->close();
		}
		return $service;
	}

	function getRecentServiceLog($orderId, $db) {
		$orderLog = array();
		if ($stmt = $db->prepare("SELECT mu.id, mu.first_name, mu.last_name, mol.notes, mol.date FROM m_service_logs mol LEFT JOIN m_users mu ON mu.id = mol.author_id WHERE mol.service_id = ? ORDER BY mol.date DESC;")) {
			$stmt->bind_param('i', $orderId);
			$stmt->execute();
			$stmt->store_result();

			$stmt->bind_result($userId, $firstName, $lastName, $notes, $date);
			while ($stmt->fetch()) {
				$orderLog[] = array(
					'user_id' => $userId,
					'name' => $firstName.' '.$lastName, 
					'notes' => $notes,
					'date' => date("F j, Y, g:i a", strtotime($date))
					);
			}
		}
		return $orderLog;
	}

	function logServiceUpdate($id, $userId, $text, $db) {
		$sql = sprintf("INSERT INTO m_service_logs (author_id, service_id, notes) VALUES('%s', '%s', '%s')", $userId, $id, mysqli_real_escape_string($db, $text));
		$db->query($sql);
	}


	function insertService($order_id, $tracking_in, $type, $status, $priority, $due_date, $issue, $response, $admin_id, $db) {
		$sql = sprintf("INSERT INTO m_services (order_id, tracking_in, type, status, priority, due_date, issue, suggested_response, suggested_response_admin_id, date) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW())", mysqli_real_escape_string($db, $order_id), mysqli_real_escape_string($db, $tracking_in), mysqli_real_escape_string($db, $type), mysqli_real_escape_string($db, $status), mysqli_real_escape_string($db, $priority), mysqli_real_escape_string($db, $due_date), mysqli_real_escape_string($db, $issue), mysqli_real_escape_string($db, $response), mysqli_real_escape_string($db, $admin_id));
		$db->query($sql);
	}

	function deleteService($id, $db) {
		$db->query(sprintf("DELETE FROM m_services WHERE id = '%s'", mysqli_real_escape_string($db, $id)));
		$db->query(sprintf("DELETE FROM m_service_items WHERE service_id = '%s'", mysqli_real_escape_string($db, $id)));
	}

	function updateNewService($id, $tracking_out, $type, $status, $priority, $due_date, $issue, $response, $adminId, $db) {
		if ($stmt = $db->prepare("SELECT id, tracking_out, type, status, priority, due_date, issue, suggested_response, suggested_response_admin_id, suggested_response_date, diagnostic_response, included_parts, test_ride_complete, test_ride_admin_id, test_ride_date, final_test_ride_complete, final_test_ride_admin_id, final_test_ride_date, qa_complete, qa_admin_id, qa_date, notes, customer_notes FROM m_services WHERE id = ?;")) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id, $tracking_out2, $type2, $status2, $priority2, $due_date2, $issue2, $response2, $suggested_response_admin_id2, $response_date2, $diagnostic_response2, $included_parts2, $test_ride_complete2, $test_ride_admin_id2, $test_ride_date2, $final_test_ride_complete2, $final_test_ride_admin_id2, $final_test_ride_date2, $qa_complete2, $qa_admin_id2, $qa_date2, $notes2, $customer_notes2);
			$stmt->fetch();
			if ($stmt->num_rows >= 1) {
				if (strcmp($tracking_out, $tracking_out2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the tracking number out from "%s" to "%s"', $tracking_out2, $tracking_out), $db); }
				if (strcmp($type, $type2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the type from "%s" to "%s"', $type2, $type), $db); }
				if (strcmp($status, $status2) !== 0) { 
					logServiceUpdate($id, $adminId, sprintf('Updated the status from "%s" to "%s"', $status2, $status), $db); 
					if (strcmp($service, 'inhouse') == 0) {
						$db->query('UPDATE m_services SET check_in = UNIX_TIMESTAMP(NOW()) WHERE service_id = '.$id);
					}
				}
				if (strcmp($priority, $priority2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the priority from "%s" to "%s"', $priority2, $priority), $db); }
				if (strcmp($due_date, $due_date2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the due date from "%s" to "%s"', $due_date2, $due_date), $db); }
				if (strcmp($issue, $issue2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the issue from "%s" to "%s"', $issue2, $issue), $db); }
				$sql = sprintf("UPDATE m_services SET tracking_out = '%s', type = '%s', status = '%s', priority = '%s', due_date = '%s', issue = '%s', suggested_response = '%s', suggested_response_admin_id = '%s', suggested_response_date = '%s' WHERE id = '%s';", mysqli_real_escape_string($db, $tracking_out), mysqli_real_escape_string($db, $type), mysqli_real_escape_string($db, $status), mysqli_real_escape_string($db, $priority), mysqli_real_escape_string($db, $due_date), mysqli_real_escape_string($db, $issue), mysqli_real_escape_string($db, $response), (!empty($response) && ($suggested_response_admin_id2 == 0 || $suggested_response_admin_id2 == $adminId) ? mysqli_real_escape_string($db, $adminId) : mysqli_real_escape_string($db, $suggested_response_admin_id2)), ($response_date2 == 0 ? mysqli_real_escape_string($db, time()) : 0), $id);
				$db->query($sql);
			}
		}
	}

	function updateService($id, $tracking_out, $type, $status, $priority, $due_date, $issue, $response, $adminId, $diagnostic_response, $included_parts, $test_ride_complete, $final_test_ride_complete, $qa_complete, $notes, $customer_notes, $services, $db) {
		if ($stmt = $db->prepare("SELECT id, tracking_out, type, status, priority, due_date, issue, suggested_response, suggested_response_admin_id, suggested_response_date, diagnostic_response, included_parts, test_ride_complete, test_ride_admin_id, test_ride_date, final_test_ride_complete, final_test_ride_admin_id, final_test_ride_date, qa_complete, qa_admin_id, qa_date, notes, customer_notes FROM m_services WHERE id = ?;")) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id, $tracking_out2, $type2, $status2, $priority2, $due_date2, $issue2, $response2, $suggested_response_admin_id2, $response_date2, $diagnostic_response2, $included_parts2, $test_ride_complete2, $test_ride_admin_id2, $test_ride_date2, $final_test_ride_complete2, $final_test_ride_admin_id2, $final_test_ride_date2, $qa_complete2, $qa_admin_id2, $qa_date2, $notes2, $customer_notes2);
			$stmt->fetch();
			if ($stmt->num_rows >= 1) {
				if (strcmp($tracking_out, $tracking_out2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the tracking number out from "%s" to "%s"', $tracking_out2, $tracking_out), $db); }
				if (strcmp($type, $type2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the type from "%s" to "%s"', $type2, $type), $db); }
				if (strcmp($status, $status2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the status from "%s" to "%s"', $status2, $status), $db); }
				if (strcmp($priority, $priority2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the priority from "%s" to "%s"', $priority2, $priority), $db); }
				if (strcmp($due_date, $due_date2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the due date from "%s" to "%s"', $due_date2, $due_date), $db); }
				if (strcmp($issue, $issue2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the issue from "%s" to "%s"', $issue2, $issue), $db); }
				if (strcmp($diagnostic_response, $diagnostic_response2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the diagnostic response from "%s" to "%s"', $diagnostic_response2, $diagnostic_response), $db); }
				if (strcmp($response, $response2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the response from "%s" to "%s"', $response2, $response), $db); }
				if (strcmp($included_parts, $included_parts2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the included parts from "%s" to "%s"', $included_parts2, $included_parts), $db); }
				if ($test_ride_complete != $test_ride_complete2) { logServiceUpdate($id, $adminId, sprintf('Updated the test ride complete from "%s" to "%s"', $test_ride_complete2 == 1, $test_ride_complete == 1), $db); }
				if ($final_test_ride_complete != $final_test_ride_complete2) { logServiceUpdate($id, $adminId, sprintf('Updated the final test ride complete from "%s" to "%s"', $final_test_ride_complete2 == 1, $final_test_ride_complete == 1), $db); }
				if (strcmp($notes, $notes2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the notes from "%s" to "%s"', $notes2, $notes), $db); }
				if (strcmp($customer_notes, $customer_notes2) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the customer notes from "%s" to "%s"', $customer_notes2, $customer_notes), $db); }
				if ($qa_complete != $qa_complete2) { logServiceUpdate($id, $adminId, sprintf('Updated the quality assurance from "%s" to "%s"', $qa_complete2 == 1, $qa_complete == 1), $db); }
				if ($stmt2 = $db->prepare("SELECT id, service_name, quantity, rate, amount, description, discount, date, complete, admin_id FROM m_service_items WHERE service_id = ?;")) {
					$stmt2->bind_param('i', $id);
					$stmt2->execute();
					$stmt2->store_result();
					$stmt2->bind_result($serviceId, $serviceName, $serviceQuantity, $serviceRate, $serviceAmount, $serviceDesc, $serviceDiscount, $serviceDate, $serviceComplete, $serviceAdminId);
					foreach ($services as $service) {
						$found = false;
						if ($stmt2->num_rows >= 1) {
							while ($stmt2->fetch()) {
								if (strcmp($service['name'], $serviceName) == 0) {
									$found = true;
									if (strcmp($serviceQuantity, $service['quantity']) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the service quantity for %s from "%s" to "%s"', $serviceName, $serviceQuantity, $service['quantity']), $db); }
									if (strcmp($serviceRate, $service['rate']) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the service rate for %s from "%s" to "%s"', $serviceName, $serviceRate, $service['rate']), $db); }
									if (strcmp($serviceAmount, $service['amount']) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the service amount for %s from "%s" to "%s"', $serviceName, $serviceAmount, $service['amount']), $db); }
									if (strcmp($serviceDescription, $service['description']) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the service description for %s from "%s" to "%s"', $serviceName, $serviceDescription, $service['description']), $db); }
									if (strcmp($serviceDiscount, $service['discount']) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the service discount for %s from "%s" to "%s"', $serviceName, $serviceDiscount, $service['discount']), $db); }
									if (strcmp($serviceComplete, $service['complete']) !== 0) { logServiceUpdate($id, $adminId, sprintf('Updated the service complete for %s from "%s" to "%s"', $serviceName, $serviceComplete, $service['complete']), $db); }
									$sql2 = sprintf("UPDATE m_service_items SET quantity = '%s', rate = '%s', amount = '%s', description = '%s', discount = '%s', complete = '%s', admin_id = '%s', complete_date = '%s' WHERE id = '%s'", mysqli_real_escape_string($db, $service['quantity']), mysqli_real_escape_string($db, $service['rate']), mysqli_real_escape_string($db, $service['amount']), mysqli_real_escape_string($db, $service['description']), mysqli_real_escape_string($db, $service['discount']), mysqli_real_escape_string($db, $service['complete']), ($service['complete'] == 1 && $service['complete'] != $serviceComplete ? mysqli_real_escape_string($db, $adminId) : 0), ($service['complete'] == 1 && $service['complete'] != $serviceComplete ? mysqli_real_escape_string($db, time()) : 0), mysqli_real_escape_string($db, $serviceId));
									$db->query($sql2);
								}
							}
						}
						if (!$found) {
							$sql = (sprintf("INSERT INTO m_service_items (service_id, quantity, rate, amount, service_name, description, discount, complete, admin_id, complete_date) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');", mysqli_real_escape_string($db, $id), mysqli_real_escape_string($db, $service['quantity']), mysqli_real_escape_string($db, $service['rate']),  mysqli_real_escape_string($db, $service['amount']), mysqli_real_escape_string($db, $service['name']), mysqli_real_escape_string($db, $service['description']), mysqli_real_escape_string($db, $service['discount']), mysqli_real_escape_string($db, $service['complete']), ($service['complete'] == 1 ? mysqli_real_escape_string($db, $adminId) : 0), ($service['complete'] == 1 ? mysqli_real_escape_string($db, time()) : 0)));
							$db->query($sql);
						}
					}
				}
				$sql = sprintf("UPDATE m_services SET tracking_out = '%s', type = '%s', status = '%s', priority = '%s', due_date = '%s', issue = '%s', suggested_response = '%s', suggested_response_admin_id = '%s', suggested_response_date = '%s', diagnostic_response = '%s', included_parts = '%s', test_ride_complete = '%s', test_ride_admin_id = '%s', test_ride_date = '%s', final_test_ride_complete = '%s', final_test_ride_admin_id = '%s', final_test_ride_date = '%s', qa_complete = '%s', qa_admin_id = '%s', qa_date = '%s', notes = '%s', customer_notes = '%s' WHERE id = '%s';", mysqli_real_escape_string($db, $tracking_out), mysqli_real_escape_string($db, $type), mysqli_real_escape_string($db, $status), mysqli_real_escape_string($db, $priority), mysqli_real_escape_string($db, $due_date), mysqli_real_escape_string($db, $issue), mysqli_real_escape_string($db, $response), (!empty($response) && ($suggested_response_admin_id2 == 0 || $suggested_response_admin_id2 == $adminId) ? mysqli_real_escape_string($db, $adminId) : mysqli_real_escape_string($db, $suggested_response_admin_id2)), ($response_date2 == 0 ? mysqli_real_escape_string($db, time()) : 0), mysqli_real_escape_string($db, $diagnostic_response), mysqli_real_escape_string($db, $included_parts), mysqli_real_escape_string($db, $test_ride_complete), ($test_ride_complete == 1 && ($test_ride_admin_id2 == 0 || $test_ride_admin_id2 == $adminId) ? mysqli_real_escape_string($db, $adminId) : mysqli_real_escape_string($db, $test_ride_admin_id2)), ($test_ride_admin_id2 == 0 && $test_ride_date2 == 0 ? mysqli_real_escape_string($db, time()) : 0), mysqli_real_escape_string($db, $final_test_ride_complete), ($final_test_ride_complete == 1 && ($final_test_ride_admin_id2 == 0 || $final_test_ride_admin_id2 == $adminId) ? mysqli_real_escape_string($db, $adminId) : mysqli_real_escape_string($db, $final_test_ride_admin_id2)), ($final_test_ride_date2 == 0 && $final_test_ride_admin_id2 == 0 ? mysqli_real_escape_string($db, time()) : 0), mysqli_real_escape_string($db, $qa_complete), ($qa_complete == 1 && ($qa_admin_id2 == 0 || $qa_admin_id2 == $adminId) ? mysqli_real_escape_string($db, $adminId) : mysqli_real_escape_string($db, $qa_admin_id2)), ($qa_date2 == 0 && $qa_admin_id == 0 ? mysqli_real_escape_string($db, time()) : 0), mysqli_real_escape_string($db, $notes), mysqli_real_escape_string($db, $customer_notes), $id);
				$db->query($sql);
			}
		}
	}

	function getTotalServiceRecords($db) {
		if ($stmt = $db->prepare("SELECT COUNT(*) FROM m_services")) {
			$stmt->execute();
			$stmt->store_result();

			$stmt->bind_result($count);
			$stmt->fetch();
			if ($stmt->num_rows == 1) {
				$stmt->close();
				return $count;
			}
			$stmt->close();
		}
		return 0;
	}

/**
	*	EMAIL FUNCTIONS
	*/

	function sendContactEmail($from, $fromName, $subject, $text, $attachmentPath = '', $attachmentFileName = '') {
		require 'utils/mail/mailer/PHPMailerAutoload.php';
		$email = new PHPMailer();
		$email->From      = $from;
		$email->FromName  = $fromName;
		$email->Subject   = $subject;
		$email->Body      = $text;
		$email->AddAddress( CONTACT_EMAIL );

		if (!empty($attachmentPath)) {
			$file_to_attach = $attachmentPath;
			$email->AddAttachment( $file_to_attach , $attachmentFileName );
		}
		return $email;
	}

	function getEmails($country, $start_date, $end_date, $status, $db) {
		$emails = array();
		$query = '';
		if (!empty($country)) {
			$query .= ' AND '.(strcmp($country, 'US') == 0 ? 'mo.country = "US"' : 'mo.country != "US"').' ';
		}
		if (!empty($start_date) || !empty($end_date)) {
			if (empty($start_date)) { $start_date = 0; }
			if (empty($end_date)) { $end_date = time(); }
			$query .= ' AND mo.order_date >= '.strtotime($start_date).' AND mo.order_date <= '.strtotime($end_date).' ';
		}
		if (!empty($status)) {
			if (strcmp($status, 'all_waiting') == 0) {
				$query .= ' AND mo.order_status != \'refunded\' AND mo.order_status != \'shipped\' AND mo.order_status != \'hold\' ';
			} else {
				$query .= ' AND mo.order_status = "'.$status.'" ';
			}
		}
		if (!empty($query)) {
			if ($stmt = $db->prepare('SELECT mu.email FROM m_users mu, m_orders mo WHERE mo.user_id = mu.id '.$query)) {
				$stmt->execute();
				$stmt->store_result();	 
				$stmt->bind_result($email);
				while ($stmt->fetch()) {
					$emails[] = $email;
				}
			}		
		}
		return $emails;
	}

	function get_mandrill() {
		require_once 'utils/mail/mandrill/Mandrill.php';
		return new Mandrill(MANDRILL_API_KEY);
	}

	function get_templates($mandrill) {
		return $mandrill->templates->getList();
	}

	function get_senders($mandrill) {
		$senders = $mandrill->users->senders();
		$retArray = array();
		foreach ($senders as $sender) {
			$retArray[] = $sender['address'];
		}
		return $retArray;
	}

	function getUserEmailData($userStr, $db) {	        
		$users = array();
		$sql = 'SELECT mu.id, mu.email, mu.first_name, mu.last_name, mu.phone, mo.order_number, mo.delivery_address, mo.delivery_address_2, mo.city, mo.state, mo.zip, mo.country, mo.invoice_url, mo.shipping_cost FROM m_users mu LEFT JOIN m_orders mo ON mo.user_id = mu.id WHERE ';

		$userArr = split(",", str_replace(" ", "", $userStr));
		$query = "";
		$refType = "";
		foreach ($userArr as $k => $user) {
			if (!empty($query)) { $query .= " OR "; }
			$query .= "mu.email = ?";
			$refType .= "s";
		}
		if ($stmt = $db->prepare($sql.$query." GROUP BY mu.email ORDER BY mo.id DESC ")) {
			$params = array($refType);
			foreach ($userArr as $user) { array_push($params,"$user"); }
			$ref = new ReflectionClass('mysqli_stmt'); 
			$method = $ref->getMethod("bind_param"); 
			$method->invokeArgs($stmt, $params); 

			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($id, $email, $first_name, $last_name, $phone, $order_number, $address, $address_2, $city, $state, $zip_code, $county, $invoice_url, $shipping_cost);
			while ($stmt->fetch()) {
				$users[] = array(
					'id' 				  	 => $id,	
					'email'          => $email,
					'first_name'     => $first_name,
					'last_name'      => $last_name,
					'phone'          => $phone,
					'address'        => $address,
					'address_2'      => $address_2,	
					'city'           => $city,
					'state'          => $state,
					'zip_code'       => $zip_code,
					'country'        => $county,
					'invoice_url'    => $invoice_url,
					'shipping_costs' => $shipping_cost,
					'order_number'   => $order_number
				);
			}
			$stmt->close();
		}
		return $users;
	}


	function getUserEmailDataById($userStr, $db) {	        
		$users = array();
		$sql = 'SELECT mu.id, mu.email, mu.first_name, mu.last_name, mu.phone, mo.order_number, mo.delivery_address, mo.delivery_address_2, mo.city, mo.state, mo.zip, mo.country, mo.invoice_url, mo.shipping_cost FROM m_users mu LEFT JOIN m_orders mo ON mo.user_id = mu.id WHERE ';

		$userArr = split(",", str_replace(" ", "", $userStr));
		$query = "";
		$refType = "";
		foreach ($userArr as $k => $user) {
			if (!empty($query)) { $query .= " OR "; }
			$query .= "mu.id = ?";
			$refType .= "i";
		}
		if ($stmt = $db->prepare($sql.$query." GROUP BY mu.email ORDER BY mo.id DESC ")) {
			$params = array($refType);
			foreach ($userArr as $user) { array_push($params,"$user"); }
			$ref = new ReflectionClass('mysqli_stmt'); 
			$method = $ref->getMethod("bind_param"); 
			$method->invokeArgs($stmt, $params); 

			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($id, $email, $first_name, $last_name, $phone, $order_number, $address, $address_2, $city, $state, $zip_code, $county, $invoice_url, $shipping_cost);
			while ($stmt->fetch()) {
				 $users[] = array(
					'id' 				  	 => $id,	
					'email'          => $email,
					'first_name'     => $first_name,
					'last_name'      => $last_name,
					'phone'          => $phone,
					'address'        => $address,
					'address_2'      => $address_2,
					'city'           => $city,
					'state'          => $state,
					'zip_code'       => $zip_code,
					'country'        => $county,
					'invoice_url'    => $invoice_url,	
					'shipping_costs' => $shipping_cost,
					'order_number'   => $order_number
				);
			}
			$stmt->close();
		}
		return $users;
	}

	function sendTemplateBodyEmail($template_name, $to, $subject, $body) {
		$mandrill = get_mandrill();
		$template_content = array(
			array(
				'name' => 'body',
				'content' => $body
			)
		);
		$msgTo = array();
		foreach ($to as $user) {
			$msgTo[] = array(
				'email' => $user['email'],
				'name' => $user['first_name'].' '.$user['last_name'],
				'type' => 'to'
			);
		}
		$hasMergeVars = false;
		foreach ($mergeVars as $merge) {
			if (strcmp($merge['rcpt'], $user['email']) == 0) {
				$hasMergeVars = true;
			}
		}
		if (!$hasMergeVars) {
			$mergeVars[] = array(
				'rcpt' => $user['email'],
				'vars' => array()
			);
		}
		$index = -1;
		foreach ($mergeVars as $i => $merge) {
			if (strcmp($merge['rcpt'], $user['email']) == 0) {
				$index = $i;
				break;
			}
		}
		if ($index >= 0) {
			$mergeVars[$index]['vars'][] = array(
				'name' => 'firstname',
				'content' => $user['first_name']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'lastname',
				'content' => $user['last_name']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'email',
				'content' => $user['email']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'address1',
				'content' => $user['address']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'address2',
				'content' => $user['address_2']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'city',
				'content' => $user['city']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'state',
				'content' => $user['state']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'zipcode',
				'content' => $user['zip_code']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'country',
				'content' => $user['country']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'phone_number',
				'content' => $user['phone']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'invoice_url',
				'content' => $user['invoice_url']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'shipping_costs',
				'content' => $user['shipping_costs']
			);
			$mergeVars[$index]['vars'][] = array(
				'name' => 'order_number',
				'content' => $user['order_number']
			);
		}

		$emptyFrom = false;
		foreach (get_templates($mandrill) as $template) {
			if (strcmp($template['slug'], $template_name) == 0) {
				if (empty($template['from_email'])) {
					$emptyFrom = true;
				}
			}
		}
		$message = array(
			'to' => $msgTo,
			'important' => false,
			'subject' => $subject,
			'track_opens' => true,
			'track_clicks' => true,
			'merge' => true,
			'merge_language' => 'mailchimp',
			'merge_vars' => $mergeVars
		);
		if ($emptyFrom) {
			$message['from_email'] = CONTACT_EMAIL;
		}
		$async = true;
		$ip_pool = 'Main Pool';
		$send_at = date("F j, Y, g:i a");
		return $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
	}

	function sendTemplateEmail($template_name, $to, $subject, $mergeVars = array()) {
		$mandrill = get_mandrill();
		$template_content = array();
		$msgTo = array();
		foreach ($to as $user) {
			$msgTo[] = array(
				'email' => $user['email'],
				'name' => $user['first_name'].' '.$user['last_name'],
				'type' => 'to'
			);
			$hasMergeVars = false;
			foreach ($mergeVars as $merge) {
				if (strcmp($merge['rcpt'], $user['email']) == 0) {
					$hasMergeVars = true;
				}
			}
			if (!$hasMergeVars) {
				$mergeVars[] = array(
					'rcpt' => $user['email'],
					'vars' => array()
				);
			}
			$index = -1;
			foreach ($mergeVars as $i => $merge) {
				if (strcmp($merge['rcpt'], $user['email']) == 0) {
					$index = $i;
					break;
				}
			}
			if ($index >= 0) {
				$mergeVars[$index]['vars'][] = array(
					'name' => 'firstname',
					'content' => $user['first_name']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'lastname',
					'content' => $user['last_name']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'email',
					'content' => $user['email']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'address1',
					'content' => $user['address']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'address2',
					'content' => $user['address_2']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'city',
					'content' => $user['city']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'state',
					'content' => $user['state']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'zipcode',
					'content' => $user['zip_code']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'country',
					'content' => $user['country']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'phone_number',
					'content' => $user['phone']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'invoice_url',
					'content' => $user['invoice_url']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'shipping_costs',
					'content' => $user['shipping_costs']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'order_number',
					'content' => $user['order_number']
				);
			}
		}
		$emptyFrom = false;
		foreach (get_templates($mandrill) as $template) {
			if (strcmp($template['slug'], $template_name) == 0) {
				if (empty($template['from_email'])) {
					$emptyFrom = true;
				}
			}
		}
		$message = array(
			'to' => $msgTo,
			'important' => false,
			'subject' => $subject,
			'track_opens' => true,
			'track_clicks' => true,
			'merge' => true,
			'merge_language' => 'mailchimp',
			'merge_vars' => $mergeVars,
		);
		if ($emptyFrom) {
			$message['from_email'] = CONTACT_EMAIL;
		}
		$async = true;
		$ip_pool = 'Main Pool';
		$send_at = date("F j, Y, g:i a");
		return $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
	}

	function sendPasswordResetEmail($email, $db) {	
		if ($stmt = $db->prepare("SELECT mua.salt FROM m_user_auth mua LEFT JOIN m_users mu ON mu.id = mua.user_id WHERE mu.email = ? LIMIT 1")) {
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($salt);
			$stmt->fetch();
			if ($stmt->num_rows == 0) {
				$salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
				$db->query(sprintf("INSERT INTO m_user_auth (user_id, password, salt) VALUES ((SELECT id FROM m_users WHERE email = '%s'), '%s', '%s');", $email, $salt, $salt));
			}
			$key = hash('sha512', 'reset-password-key' . $salt);
			$users = getUserEmailData($email, $db);
			$mergeVars = array(
				array(
					'rcpt' => $email,
					'vars' => array(
						array(
							'name' => 'resetlink', 
							'content' => 'http://mymarbel.com/reset-password/'.$email.'/'.$key
						)
					)
				)
			);
			sendTemplateEmail('password-reset-template', $users, 'Password reset for MyMarbel', $mergeVars);
			return 0;
		}
	}

/**
	* UTILITIES
	*/

	function escUrl($url) {
		if ('' == $url) { return $url; }
		$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*"()\\x80-\\xff]|i', '', $url);
		$strip = array('%0d', '%0a', '%0D', '%0A');
		$url = (string) $url;

		$count = 1;
		while ($count) {
			$url = str_replace($strip, '', $url, $count);
		}

		$url = str_replace(';//', '://', $url);
		$url = htmlentities($url);

		$url = str_replace('&amp;', '&#038;', $url);
		$url = str_replace("'", '&#039;', $url);

		if ($url[0] !== '/') {
			return '';
		} else {
			return $url;
		}
	}

	function getClientIP() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if (isset($_SERVER['CF-CONNECTING-IP']))
			$ipaddress = $_SERVER['CF-CONNECTING-IP'];
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if (isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	function getCountries() {
		$jsonStr = file_get_contents("/var/www/mymarbel/includes/data/countries.json");
		return json_decode($jsonStr, true);
	}

	function getShippingCost($countryCode) {
		$csv = array_map('str_getcsv', file('/var/www/mymarbel/includes/data/shipping_costs.csv'));
		foreach ($csv as $line) {
			$code = $line[0];
			$cost = $line[1];
			if (!empty($code) && !empty($cost)) {
				if (strcmp($code, $countryCode) == 0) {
					return $cost;
				}
			}
		}
		return 0;
	}

	function parseString($string,$start,$end){ 
		preg_match_all('/' . preg_quote($start, '/') . '(.*?)'. preg_quote($end, '/').'/i', $string, $m); 
		$out = array(); 

		foreach($m[1] as $key => $value){ 
			$type = explode('::',$value); 
			if(sizeof($type)>1) { 
				if(!is_array($out[$type[0]])) { $out[$type[0]] = array(); } 
				$out[$type[0]][] = $type[1]; 
			} else { 
				$out[] = $value;
			} 
		} 
		return $out; 
	} 
     function isLoginSessionExpired() {
         $login_session_duration=0;
        if(isset($_SESSION['marbel_user']['type']) && $_SESSION['marbel_user']['type']=='admin')
	$login_session_duration = 12*60*60; 
        if(isset($_SESSION['marbel_user']['type']) && $_SESSION['marbel_user']['type']=='employee')
	$login_session_duration = 12*60*60;
        if(isset($_SESSION['marbel_user']['type']) && $_SESSION['marbel_user']['type']=='dealer')
	$login_session_duration = 12*60*60;
        if(isset($_SESSION['marbel_user']['type']) && $_SESSION['marbel_user']['type']=='customer')
	$login_session_duration = 12*30*24*60*60;
         if(isset($_SESSION['marbel_user']['type']) && $_SESSION['marbel_user']['type']=='investor')
	$login_session_duration = 1*60*60;
        $current_time = time(); 
	if(isset($_SESSION['marbel_user']['loggedin_time']) and isset($_SESSION['marbel_user'])){  
		if(((time() - $_SESSION['marbel_user']['loggedin_time']) > $login_session_duration)){ 
			return true; 
		} 
	}
        
	return false;
    }
     
function buildMenu($parent, $menu,$child = 0) {
    
        $childClass = '';
        if($child == 1){
            
            $childClass= "class='child-li'";
        }
    
        $html = "";
        $nav='';
       if($menu['parent_menus'][$parent][0]==1){
          $nav="id='nav'";
       }
        if (isset($menu['parent_menus'][$parent])) {

            $html .= "<ul ".$nav." >";

                foreach ($menu['parent_menus'][$parent] as $menu_id) {
                        if (!isset($menu['parent_menus'][$menu_id])) {
                                $html .= "<li ".$childClass." class='parent-li'  id='".$menu['menus'][$menu_id]['id']."'>" . $menu['menus'][$menu_id]['user_role_type'] . "</li>";
                        }
                        if (isset($menu['parent_menus'][$menu_id])) {
                                $html .= "<li   id='".$menu['menus'][$menu_id]['id']."'>" . $menu['menus'][$menu_id]['user_role_type'];
                                $html .= buildMenu($menu_id, $menu,1);
                                $html .= "</li>";
                        }

                }
                $html .= "</ul>";
        }
        return $html;
}
function getChildLevelUsers($id,$db){
         
		$user_level = array();
		if ($stmt = $db->prepare("SELECT parent,id,user_role_type,status from m_users_level WHERE parent = ? and status='1' ORDER BY id ASC;")) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($parent, $id, $user_role_type, $status);
			while ($stmt->fetch()) {
				$user_level[] = array(
                                            'parent'            => $parent,
                                            'id'                => $id,
                                            'user_role_type'    => $user_role_type,
                                            'status'            => $status
					);
			}
			$stmt->close();
		}
		return $user_level;
}
 function getLevelUsersName($id,$db){
         
		
		if ($stmt = $db->prepare("SELECT parent,id,user_role_type,status from m_users_level WHERE id = ? and status='1' ORDER BY id ASC;")) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$stmt->store_result();	 
			$stmt->bind_result($parent, $id, $user_role_type, $status);
			while ($stmt->fetch()) {
				$user_role_type;
			}
			$stmt->close();
		}
		return $user_role_type;
}   
