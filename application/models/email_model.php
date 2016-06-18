<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Email_model extends CI_Model {

    public function getUserEmailData($usersStr) {

        $this->db->select('mu.id, mu.email, mu.first_name, mu.last_name, mu.phone, mo.order_number, mo.delivery_address as address, mo.delivery_address_2 as address_2, mo.city, mo.state, mo.zip as zip_code, mo.country, mo.invoice_url, mo.shipping_cost as shipping_costs ');
        $this->db->from('m_users as mu');

        $userArr = explode(",", str_replace(" ", "", $usersStr));

        if (count($userArr) > 1) {
            foreach ($userArr as $k => $user) {
                $this->db->or_where('mu.email', $user);
            }
        } else {

            $this->db->where('mu.email', $userArr[0]);
        }

        $this->db->join('m_orders as mo', 'mo.user_id = mu.id', 'LEFT');
        $this->db->group_by('mu.email');
        $this->db->order_by('mo.id', 'DESC');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {
            return FALSE;
        }
    }

    public function getEmails($country, $start_date, $end_date, $status) {
        $emails = array();

        $this->db->select('mu.email');
        $this->db->from('m_users as mu');

        if (!empty($country)) {
            if($country == 'US'){
                $this->db->where('mo.country',"US");
            }else{
                $this->db->where('mo.country !=',"US");
            }
            
        }
        if (!empty($start_date) || !empty($end_date)) {
            if (empty($start_date)) {
                $start_date = 0;
            }
            if (empty($end_date)) {
                $end_date = time();
            }
            $this->db->where('mo.order_date >=', strtotime($start_date));
            $this->db->where('mo.order_date <=', strtotime($end_date));
        }
        if (!empty($status)) {
            if (strcmp($status, 'all_waiting') == 0) {
                $this->db->where_not('mo.order_status', 'refunded');
                $this->db->where_not('mo.order_status', 'shipped');
                $this->db->where_not('mo.order_status', 'hold');
            } else {
                $this->db->where('mo.order_status', $status);
            }
        }
        $this->db->join('m_orders mo', 'mo.user_id = mu.id');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {
            return FALSE;
        }
    }

}
