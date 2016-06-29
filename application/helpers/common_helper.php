<?php
function getServices($id=false){
    $CI= & get_instance();
    $CI->db->select('*')->from('m_services');
    $CI->db->where('order_id',$id);
    $query=$CI->db->get();
   
    if($query->num_rows()>0){
        
        return $query->result_array();
    }else{
        
        return false;
    }
}
