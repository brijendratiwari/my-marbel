<?php

function getServices($id = false) {
    $CI = & get_instance();
    $CI->db->select('*')->from('m_services');
    $CI->db->where('order_id', $id);
    $query = $CI->db->get();

    if ($query->num_rows() > 0) {

        return $query->result_array();
    } else {

        return false;
    }
}

function getUserImages($id) {
    $CI = & get_instance();
    $CI->db->select('user_profile_pic')->from('m_users');
    $CI->db->where('id', $id);
    $query = $CI->db->get();
    if ($query->num_rows() > 0) {
        $image = $query->row();
        return $image->user_profile_pic;
    }
}
