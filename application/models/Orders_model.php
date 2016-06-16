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
        if ($o_result->num_rows() == 0){
//            $order_data = $o_result->result_array();
//            $id = $order_data[0]['id'];
            
            /* insert data in order table.. */
            $order_data = array(
                                'user_id'=>$user_id,
                                'order_number'=>$order_number,
                                'delivery_address'=>$delivery_address,
                                'delivery_address_2'=>$delivery_address_2,
                                'city'=>$city,
                                'state'=>$state,
                                'zip'=>$zip,
                                'country'=>$country,
                                'order_total'=>$order_total,
                                'invoice_url'=>$invoice_url,
                                'order_date'=>$order_date,
                                'order_status'=>$order_status,
                                'est_ship_date'=>$est_ship_date,
                                'est_ship_location'=>$est_ship_location,
                                'product'=>$product,
                                'wheel_color'=>$wheel_color,
                                'wheel_size'=>$wheel_size,
                                'firmware_version'=>$firmware_version,
                                'firmware_version'=>$firmware_version,
                                'deck_serial_number'=>$deck_serial_number,
                                'main_serial_number'=>$main_serial_number,
                                'tracking_number'=>$tracking_number,
                                'notes'=>$notes,
                                'priority'=>$priority
                                
                
            );
            $this->db->insert('m_orders',$order_data);
            if($this->db->affected_rows() > 0){
                return 0;
            }
        }else{
            return 2;
        }    
        
        } else {
            return 1;
        }
    }

}
