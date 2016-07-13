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
  
  public function getPartDetail($id){
    $this->db->select("m_part.*,part_category_name,part_type_name");
    $this->db->from('m_part');
    $this->db->where('m_part.part_id',$id);
    $this->db->join('m_part_categories','m_part_categories.part_category_id=part_category','left');
    $this->db->join('m_part_type','m_part_type.part_type_id=part_type','left');
    $resQuery = $this->db->get();
    if ($resQuery->num_rows() > 0) {
           $data = $resQuery->result_array();
           return $data[0];
        } else {
            return false;
     } 
  }
  
  public function update_image($update_data){
      if(!empty($update_data)){
       $this->db->where('part_id',$update_data['part_id']);
       $this->db->update('m_part',array('part_image'=>$update_data['part_image']));
       return true;   
      }
      
  }
  
  
  public function updatePart($id,$data){
      
     if((!empty($data)) && ($id>0)){
       $this->db->where('part_id',$id);
       $this->db->update('m_part',$data);
     return TRUE;
      }
  }
   
}
