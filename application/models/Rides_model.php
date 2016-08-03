<?php
class Rides_model extends CI_Model{
    
    public function getRidesPointsDetails($id=false){
        
        $this->db->select('*')->from('m_ride_points');
        $this->db->where('ride_id',$id);
        $query=$this->db->get();
        if($query->num_rows()>0){
            $results=$query->result_array();
            if($results){
            foreach($results as $key=>$value){
                
                $results['polyline'][$key]=$value['latitude']." ,".$value['longitude'];
             
                }
            }
            return $results;
        }else{
            
            return false;
        }
        
    
    }
}