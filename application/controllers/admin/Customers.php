<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {
        function __construct() {
            parent::__construct();
            $this->load->database();
            $this->load->model('customers_model', "Customers");
            $this->load->model('users_model', "Users");
            if($this->Users->auth_check()==false){
                redirect('/login');
            }
        }
      public function index(){
          if($_POST){
           $email=$this->input->post('cd-email');
           $first_name=$this->input->post('cd-first');
           $last_name=$this->input->post('cd-last');
           $password=$this->input->post('cd-password');
           if($this->input->post('cd-type-parent')!=''){
               $type=$this->input->post('cd-type-parent');
               $parent_type = $this->input->post('cd-type');;
           }else
           {
                 $type = $this->input->post('cd-type');
                 $parent_type = $this->input->post('cd-type');
           }
           $phone=$this->input->post('cd-phone');
           $email_second=$this->input->post('cd-email-second');
           $bio=$this->input->post('cd-bio');
           $height=$this->input->post('cd-height');
           $weight=$this->input->post('cd-weight');
           $company=$this->input->post('cd-company');
           $address_one=$this->input->post('cd-address-one');
           $address_two=$this->input->post('cd-address-two');
           $city=$this->input->post('cd-city');
           $state_region=$this->input->post('cd-state-region');
           $postal_code=$this->input->post('cd-postal-code');
           $country=$this->input->post('cd-country');
           $accepts_marketing=$this->input->post('cd-accepts-marketing');
           $alias=$this->input->post('cd-alias');
           $privacy_setting=$this->input->post('cd-privacy-setting');
           $units=$this->input->post('cd-units');
           $rangealarm=$this->input->post('cd-rangealarm');
           $notifications_rides=$this->input->post('cd-notifications-rides');
           $primary_riding_style=$this->input->post('cd-primary-riding-style');
           $safety_brake=$this->input->post('cd-safety-brake');
           $preferred_braking_force=$this->input->post('cd-preferred-braking-force');
           $reverse_turned=$this->input->post('cd-reverse-turned');
           $locked_settings=$this->input->post('cd-locked-settings');
           $terrain=$this->input->post('cd-terrain');
           $twitter_handle=$this->input->post('cd-twitter-handle');
           $linkedin_handle=$this->input->post('cd-linkedin-handle');
           $instagram_handle=$this->input->post('cd-instagram-handle');
           $reddit_handle=$this->input->post('cd-reddit-handle');
           $notes = $this->input->post('cd-notes');
           $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
           $password = hash('sha512', $password . $random_salt);
           $data_insert=array(
                
                'email'                     => $email,
                'first_name'                => $first_name,
                'last_name'                 => $last_name,
                'password'                  => $password,
                'parent_type'               => $parent_type,
                'type'                      => $type,
                'parent_type'               => $phone,
                'parent_type'               => $email_second,
                'parent_type'               => $bio,
                'height'                    => $height,
                'weight'                    => $weight,
                'company'                   => $company,
                'address_one'               => $address_one,
                'address_two'               => $address_two,
                'city'                      => $city,
                'state_region'              => $state_region,
                'postal_code'               => $postal_code,
                'country'                   => $country,
                'parent_type'               => $accepts_marketing,
                'alias'                     => $alias,
                'privacy_setting'           => $privacy_setting,
                'units'                      => $units,
                'rangealarm'                 => $rangealarm,
                'notifications_rides'        => $notifications_rides,
                'primary_riding_style'       => $primary_riding_style,
                'safety_brake'               => $safety_brake,
                'preferred_braking_force'    => $preferred_braking_force,
                'reverse_turned'             => $reverse_turned,
                'locked_settings'            => $locked_settings,
                'terrain'                    => $terrain,
                'twitter_handle'             => $twitter_handle,
                'linkedin_handle'            => $linkedin_handle,
                'instagram_handle'           => $instagram_handle,
                'reddit_handle'              => $reddit_handle,
                'notes'                      => $notes,
              );
            
            $info=$this->Customers->checkUserEmail($email);
            if($info!=''){
                       $this->session->set_flashdata('error', 'Could not add '.$first_name.' '.$last_name.'.<br />\''.$email.'\' is already in use');
                       redirect('customers');
                }
                else
                {
                    $this->db->insert('m_users',$data_insert);
                    $user_id=$this->db->insert_id();
                    if($user_id!=''){
                        
                        $user_auth=array('user_id'=>$user_id,'password'=>$password,'salt'=>$salt);
                        $this->db->insert('m_user_auth',$user_auth);
                        $this->session->set_flashdata('success', $first_name.' '.$last_name.' was added successfully');
                        redirect('customers');
                    }  
                    else
                    {
                        $this->session->set_flashdata('error', $first_name.' '.$last_name.'.<br />Unknown Error');
                        redirect('customers');
                    }
                }
          }
          $this->data['user_type']=$this->Customers->getUserType();
          $this->data['page']='Customers';
          $this->data['title']='Customers';
          $this->load->template('admin/customers',$this->data);
      } 
}
