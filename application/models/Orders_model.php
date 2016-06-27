<?php

class Orders_model extends CI_Model {

    public function save_order($email, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $order_total, $order_status, $invoice_url, $order_date, $est_ship_date, $est_ship_location, $product, $wheel_color, $wheel_size, $firmware_version, $deck_serial_number, $main_serial_number, $tracking_number, $notes, $priority) {


        /* get user id by the email */
        $u_result = $this->db->select('id')->from('m_users')->where('email', $email)->get();
        if ($u_result->num_rows() > 0) {
            $user_data = $u_result->result_array();
            $user_id = $user_data[0]['id'];
            /* get order id */
            $o_result = $this->db->select('id')->from('m_orders')->where('order_number', $order_number)->get();
            if ($o_result->num_rows() == 0) {
//            $order_data = $o_result->result_array();
//            $id = $order_data[0]['id'];

                /* insert data in order table.. */
                $order_data = array(
                    'user_id' => $user_id,
                    'order_number' => $order_number,
                    'delivery_address' => $delivery_address,
                    'delivery_address_2' => $delivery_address_2,
                    'city' => $city,
                    'state' => $state,
                    'zip' => $zip,
                    'country' => $country,
                    'order_total' => $order_total,
                    'invoice_url' => $invoice_url,
                    'order_date' => $order_date,
                    'order_status' => $order_status,
                    'est_ship_date' => $est_ship_date,
                    'est_ship_location' => $est_ship_location,
                    'product' => $product,
                    'wheel_color' => $wheel_color,
                    'wheel_size' => $wheel_size,
                    'firmware_version' => $firmware_version,
                    'firmware_version' => $firmware_version,
                    'deck_serial_number' => $deck_serial_number,
                    'main_serial_number' => $main_serial_number,
                    'tracking_number' => $tracking_number,
                    'notes' => $notes,
                    'priority' => $priority
                );
                $this->db->insert('m_orders', $order_data);
                if ($this->db->affected_rows() > 0) {
                    return 0;
                }
            } else {
                return 2;
            }
        } else {
            return 1;
        }
    }

    public function getOrder($order_id) {

        $this->db->select('user_id, order_number, delivery_address, delivery_address_2, city, state, zip, country, order_total, order_status, invoice_url, order_date, est_ship_date, est_ship_location, product, wheel_color, wheel_size, firmware_version, deck_serial_number, main_serial_number, tracking_number, shipping_cost, notes, priority');
        $this->db->from('m_orders');
        $this->db->where('id', $order_id);
        $res = $this->db->get();

        if ($res->num_rows() > 0) {

            $order_data = $res->result_array();

            if ($order_data[0]['order_status'] == 'deposit') {
                $order_data[0]['order_friendly_status'] = 'Deposit Paid';
            } else if ($order_data[0]['order_status'] == 'balance') {
                $order_data[0]['order_friendly_status'] = 'Fully Paid';
            } else if ($order_data[0]['order_status'] == 'refunded') {
                $order_data[0]['order_friendly_status'] = 'Refunded';
            } else if ($order_data[0]['order_status'] == 'building') {
                $order_data[0]['order_friendly_status'] = 'Building';
            } else if ($order_data[0]['order_status'] == 'qa') {
                $order_data[0]['order_friendly_status'] = 'Quality Assurance';
            } else if ($order_data[0]['order_status'] == 'shipping') {
                $order_data[0]['order_friendly_status'] = 'Shipping';
            } else if ($order_data[0]['order_status'] == 'shipped') {
                $order_data[0]['order_friendly_status'] = 'Shipped';
            } else if ($order_data[0]['order_status'] == 'hold') {
                $order_data[0]['order_friendly_status'] = 'On Hold';
            }

            return $order_data;
        } else {

            return FALSE;
        }
    }

    public function getRecentOrderLog($order_id) {

        $this->db->select('mu.id as user_id, mu.first_name, mu.last_name, mol.notes, mol.date');
        $this->db->from('m_order_logs as mol');
        $this->db->where('mol.order_id', $order_id);
        $this->db->join('m_users as mu', 'mu.id = mol.author_id', 'LEFT');
        $this->db->order_by('mol.date', 'DESC');
        $res = $this->db->get();

        if ($res->num_rows() > 0) {

            return $res->result_array();
        } else {

            return FALSE;
        }
    }

    public function getCustomer($user_id) {

        $this->db->select('mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.parent_type, mu.register_date, mu.last_activity, mu.phone, mu.notes, muli.ip');
        $this->db->from('m_users as mu');
        $this->db->where('mu.id', $user_id);
        $this->db->join('m_user_login_ip as muli', 'muli.user_id = mu.id', 'LEFT');
        $this->db->join('m_user_login_ip as muli1', 'muli1.time = mu.last_activity', 'LEFT');
        $res = $this->db->get();

        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {

            return FALSE;
        }
    }

    public function adminUpdateOrder($userId, $orderId, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $wheel_color, $wheel_size, $product, $order_total, $shipping_cost, $order_status, $invoice_url, $est_ship_date, $est_ship_location, $firmware_version, $deck_serial_number, $main_serial_number, $tracking_number, $notes, $priority, $checkEmpty = false) {


        $this->db->select('id, order_status, order_number, delivery_address, delivery_address_2, city, state, zip, country, wheel_color, wheel_size, product, order_total, shipping_cost, invoice_url, est_ship_date, est_ship_location, firmware_version, deck_serial_number, main_serial_number, tracking_number, notes, priority');
        $this->db->from('m_orders');
        $this->db->where('id', $orderId);
        $res = $this->db->get();

        if ($res->num_rows() > 0) {

            /* update order log */

            $order_data = $res->result_array();

            $id = $order_data[0]['id'];

            if (strcmp($delivery_address, $order_data[0]['delivery_address']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the delivery address from "%s" to "%s"', $order_data[0]['delivery_address'], $delivery_address));
            }
            if (strcmp($delivery_address_2, $order_data[0]['delivery_address_2']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the delivery address 2 from "%s" to "%s"', $order_data[0]['delivery_address_2'], $delivery_address_2));
            }
            if (strcmp($city, $order_data[0]['city']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the city from "%s" to "%s"', $order_data[0]['city'], $city));
            }
            if (strcmp($state, $order_data[0]['state']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the state from "%s" to "%s"', $order_data[0]['state'], $state));
            }
            if (strcmp($zip, $order_data[0]['zip']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the zip code from "%s" to "%s"', $order_data[0]['zip'], $zip));
            }
            if (strcmp($country, $order_data[0]['country']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the country from "%s" to "%s"', $order_data[0]['country'], $country));
            }
            if (strcmp($wheel_color, $order_data[0]['wheel_color']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the wheel color from "%s" to "%s"', $order_data[0]['wheel_color'], $wheel_color));
            }
            if (strcmp($wheel_size, $order_data[0]['wheel_size']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the wheel size from "%s" to "%s"', $order_data[0]['wheel_size'], $wheel_size));
            }
            if (strcmp($product, $order_data[0]['product']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the product from "%s" to "%s"', $order_data[0]['product'], $product));
            }
            if (strcmp($order_total, $order_data[0]['order_total']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the total from "%s" to "%s"', $order_total, $order_data[0]['order_total']));
            }
            if (strcmp($order_status, $order_data[0]['order_status']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the status from "%s" to "%s"', $order_data[0]['order_status'], $order_status));
            }
            if (strcmp($shipping_cost, $order_data[0]['shipping_cost']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the shipping cost from "%s" to "%s"', $order_data[0]['shipping_cost'], $shipping_cost));
            }
            if (strcmp($invoice_url, $order_data[0]['invoice_url']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the invoice url from "%s" to "%s"', $order_data[0]['invoice_url'], $invoice_url));
            }
            if (strcmp(strtotime($est_ship_date), $order_data[0]['est_ship_date']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the estimated shipping date from "%s" to "%s"', $order_data[0]['est_ship_date'], strtotime($est_ship_date)));
            }
            if (strcmp($est_ship_location, $order_data[0]['est_ship_location']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the estimated shipping location from "%s" to "%s"', $order_data[0]['est_ship_location'], $est_ship_location));
            }
            if (strcmp($firmware_version, $order_data[0]['firmware_version']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the firmware version from "%s" to "%s"', $order_data[0]['firmware_version'], $firmware_version));
            }
            if (strcmp($deck_serial_number, $order_data[0]['deck_serial_number']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the deck serial number from "%s" to "%s"', $order_data[0]['deck_serial_number'], $deck_serial_number));
            }
            if (strcmp($main_serial_number, $order_data[0]['main_serial_number']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the main serial number from "%s" to "%s"', $order_data[0]['main_serial_number'], $main_serial_number));
            }
            if (strcmp($tracking_number, $order_data[0]['tracking_number']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the tracking number from "%s" to "%s"', $order_data[0]['tracking_number'], $tracking_number));
            }
            if (strcmp($notes, $order_data[0]['notes']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the notes from "%s" to "%s"', $order_data[0]['notes'], $notes));
            }
            if (strcmp($priority, $order_data[0]['priority']) !== 0) {
                $this->logOrderUpdate($id, $userId, sprintf('Updated the Shipping Priority from "%s" to "%s"', $order_data[0]['priority'], $priority));
            }


            /* update order */

            $this->db->where('order_number', $order_number);
            $this->db->update('m_orders', array('delivery_address' => $delivery_address, 'delivery_address_2' => $delivery_address_2, 'city' => $city, 'state' => $state, 'zip' => $zip, 'country' => $country, 'wheel_color' => $wheel_color, 'wheel_size' => $wheel_size, 'product' => $product, 'order_total' => $order_total, 'shipping_cost' => $shipping_cost, 'order_status' => $order_status, 'invoice_url' => $invoice_url, 'est_ship_date' => $est_ship_date, 'est_ship_location' => $est_ship_location, 'firmware_version' => $firmware_version, 'deck_serial_number' => $deck_serial_number, 'main_serial_number' => $main_serial_number, 'tracking_number' => $tracking_number, 'notes' => $notes, 'priority' => $priority));

            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* update order log */

    protected function logOrderUpdate($orderId, $userId, $text) {

        $this->db->insert('m_order_logs', array('author_id' => $userId, 'order_id' => $orderId, 'notes' => $text));
    }

    public function deleteOrder($order_number) {

        $this->db->where('order_number', $order_number);
        $this->db->delete('m_orders');
        if ($this->db->affected_rows() > 0) {

            return TRUE;
        } else {

            return FALSE;
        }
    }
    /*update order by customer*/
   public  function updateOrder($userId, $orderId, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $wheel_color, $wheel_size) {
            $this->db->select('id, order_status, order_number, delivery_address, delivery_address_2, city, state, zip, country, wheel_color, wheel_size')->from('m_orders');
            $this->db->where('id',$orderId);
            $this->db->where('order_status != ', 'shipping');
            $this->db->where('order_status != ', 'refunded');
            $query=$this->db->get();
            if($query->num_rows()>0){
                $response=$query->row_array();
                if (strcmp($delivery_address, $response['delivery_address']) !== 0) { $this->logOrderUpdate($response['id'], $userId, sprintf('Updated the delivery address to "%s"', $delivery_address)); }
                if (strcmp($delivery_address_2, $response['delivery_address_2']) !== 0) { $this->logOrderUpdate($response['id'], $userId, sprintf('Updated the delivery address 2 to "%s"', $delivery_address_2)); }
                if (strcmp($city, $response['city']) !== 0) { $this->logOrderUpdate($response['id'], $userId, sprintf('Updated the city to "%s"', $city)); }
                if (strcmp($state, $response['state']) !== 0) { $this->logOrderUpdate($response['id'], $userId, sprintf('Updated the state to "%s"', $state)); }
                if (strcmp($zip, $response['zip']) !== 0) { $this->logOrderUpdate($response['id'], $userId, sprintf('Updated the zip code to "%s"', $zip)); }
                if (strcmp($country,$response['country']) !== 0) { $this->logOrderUpdate($response['id'], $userId, sprintf('Updated the country to "%s"', $country)); }
                if (strcmp($wheel_color, $response['wheel_color']) !== 0) { $this->logOrderUpdate($response['id'], $userId, sprintf('Updated the wheel color to "%s"', $wheel_color)); }
                if (strcmp($wheel_size, $response['wheel_size']) !== 0) { $this->logOrderUpdate($response['id'], $userId, sprintf('Updated the wheel size to "%s"', $wheel_size)); }
                $this->db->where('order_number',$order_number);
                $this->db->update('m_orders',array('delivery_address'=>$delivery_address,'delivery_address_2'=>$delivery_address_2,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'wheel_color'=>$wheel_color,'wheel_size'=>$wheel_size));
               
		return TRUE;
                
                }
                return FALSE;
	}

}
