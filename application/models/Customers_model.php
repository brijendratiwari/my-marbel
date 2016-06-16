<?php
class Customers_model extends CI_Model {

   function checkUserEmail($email){
       $this->db->select('id')-from('m_users');
       $this->db->where('email',$email);
       $this->db->limit(1);
       $query=$this->db->get();
       if($query->num_rows()>0){
           
           return $query->row();
       }else{
           
           return false;
       }
       
   }
   function getUserType() {
       $this->db->select('user_role_type,id,parent')->from('m_users_level');
       $this->db->where('status',1);
       $query=$this->db->get();
       if($query->num_rows()>0){
           
           return $query->result_array();
           
       }else{
           
           return false;
       }
        
    }
}