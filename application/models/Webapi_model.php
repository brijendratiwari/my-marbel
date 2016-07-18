<?php
class Webapi_model extends CI_Model {
    
    function checkRideId($id=false){
        
        $this->db->select('ride_ID')->from('m_rides');
        $this->db->where('ride_ID',$id);
        $query=$this->db->get();
        if($query->num_rows()>0){
            
            return true;
            
        }else{
            
            return false;
        }
        
    }
}
