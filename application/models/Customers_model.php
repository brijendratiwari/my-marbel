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
   function getChildUserLevel($id){
       $this->db->select('parent,id,user_role_type,status')->from('m_users_level');
       $this->db->where('status',1);
       $this->db->where('parent',$id);
       $this->db->order_by('id','ASC');
       $query=$this->db->get();
       if($query->num_rows()>0){
           
           return $query->result_array();
       }else{
           
           return false;
       }
   }
   function getCustomers($id){
        $this->db->select('mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.parent_type, mu.register_date, mu.last_activity, mu.phone, mu.notes, muli.ip,mu.email_secondary,mu.bio,mu.height,mu.weight,mu.terrain,mu.company,mu.address_one,mu.address_two,mu.city,mu.state_or_region,mu.postal_code,mu.country,mu.accepts,mu.alias,mu.privacy_setting,mu.units,mu.range_alarm,mu.notifications,mu.primary_riding_style,mu.safety_brake,mu.preferred_braking_force,mu.reverse_turned,mu.locked_settings,mu.user_profile_pic,mu.reddit_handle,mu.instagram_handle,mu.linkedin_handle,mu.twitter_handle')->from('m_users mu');
        $this->db->join('m_user_login_ip muli','muli.user_id = mu.id AND muli.time = mu.last_activity','left');
        $this->db->where('mu.id',$id);
        $this->db->order_by('mu.id ASC');
        $query=$this->db->get();
        if($query->num_rows()>0){
           $result=array();
           $result=$query->row_array();
           $result['parent_name']=$this->getLevelUsersName($result['parent_type']);
           $result['child_name']=$this->getLevelUsersName($result['type']);
               
           return $result;
        }
        else
        {
            return false;
        }
       
   }
   function getLevelUsersName($id){
       
       
       $this->db->select('user_role_type')->from('m_users_level');
       $this->db->where('status',1);
       $this->db->where('id',$id);
       $this->db->order_by('id','ASC');
       $query=$this->db->get();
       if($query->num_rows()>0){
           
            $data=$query->row_array();
           return $data['user_role_type'];
       }else{
           
           return false;
       }
		
		
    }   
    function updateCustomer($id){
   
        $update_data=array(
            'email'=>$this->input->post('cd-email'),
            'first_name'=>$this->input->post('cd-first_name'),
            'last_name'=>$this->input->post('cd-last_name'),
            'parent_type'=>$this->input->post('cd-parent'),
            'phone'=>$this->input->post('cd-phone'),
            'notes'=>$this->input->post('cd-notes'),
            'email_secondary'=>$this->input->post('cd-email-second'),
            'bio'=>$this->input->post('cd-bio'),
            'weight'=>$this->input->post('cd-weight'),
            'height'=>$this->input->post('cd-height'),
            'company'=>$this->input->post('cd-company'),
            'address_one'=>$this->input->post('cd-address-one'),
            'address_two'=>$this->input->post('cd-address-two'),
            'city'=>$this->input->post('cd-city'),
            'state_or_region'=>$this->input->post('cd-state-region'),
            'postal_code'=>$this->input->post('cd-postal-code'),
            'country'=>$this->input->post('cd-country'),
            'accepts'=>$this->input->post('cd-accepts-marketing'),
            'alias'=>$this->input->post('cd-alias'),
            'privacy_setting'=>$this->input->post('cd-privacy-setting'),
            'range_alarm'=>$this->input->post('cd-rangealarm'),
            'notifications'=>$this->input->post('cd-notifications-rides'),
            'primary_riding_style'=>$this->input->post('cd-primary-riding-style'),
            'safety_brake'=>$this->input->post('cd-safety-brake'),
            'preferred_braking_force'=>$this->input->post('cd-preferred-braking-force'),
            'reverse_turned'=>$this->input->post('cd-reverse-turned'),
            'locked_settings'=>$this->input->post('cd-locked-settings'),
            'terrain'=>$this->input->post('cd-terrain'),
            'twitter_handle'=>$this->input->post('cd-twitter-handle'),
            'linkedin_handle'=>$this->input->post('cd-linkedin-handle'),
            'instagram_handle'=>$this->input->post('cd-instagram-handle'),
            'reddit_handle'=>$this->input->post('cd-reddit-handle'),
             );
             $this->db->where('id',$id);
             $this->db->update('m_users',$update_data);
              $random_salt = '';
                if ($this->input->post('cd-password')!='') {
                    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                    $password = hash('sha512', $this->input->post('cd-password') . $random_salt);
                    $update_password=array('password'=>$this->input->post('cd-password'),'salt'=>$random_salt);
                    $this->db->where('user_id',$id);
                    $this->db->update('m_user_auth',$update_password);
                }  
    }
    
    function deleteCustomer($id){
         $this->db->where('id', $id);
         $this->db->delete('m_users');
          $this->db->where('user_id', $id);
         $this->db->delete('m_user_auth');
       
    }
}