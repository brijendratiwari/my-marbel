<?php

class Inventory_model extends CI_Model {
    
  public function getPartCategory(){
     $this->db->select('*'); 
     $this->db->from('m_part_categories'); 
     $resQuery = $this->db->get();
    if ($resQuery->num_rows() > 0) {
            return $resQuery->result_array();
        } else {
            return false;
     }
      
  }
 
  public function getPartType(){
     $this->db->select('*'); 
     $this->db->from('m_part_type'); 
     $resQuery = $this->db->get();
    if ($resQuery->num_rows() > 0) {
            return $resQuery->result_array();
        } else {
            return false;
     }
      
  }
 
  
  public function addPart($input){
     $this->db->insert('m_part',$input); 
     $this->db->from('m_part_type');
     return $this->db->insert_id();
  }
   
}
