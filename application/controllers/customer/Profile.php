<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('customers_model', "Customer");
        $this->load->model('users_model', "Users");
        $this->load->model('services_model', "Services");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
         if($this->session->userdata['marbel_user']['type']!='customer'){
                redirect('logout');
            }
    }
    public function index(){
        
        $this->data['page']="profile";
        $this->data['title']="Profile";
        $user_info=$this->session->userdata('marbel_user');
        $this->data['user_info']=$this->Customer->getCustomers($user_info['user_id']);
        $this->data['user_orders']=$this->Services->getOrders($user_info['user_id']);
        $this->load->customer('customer/profile',$this->data);
    }
    
     public function edit_profile(){

        $this->form_validation->set_rules('cd-email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('cd-phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('cd-first', 'FirstName', 'trim|required');
        $this->form_validation->set_rules('cd-last', 'LastName', 'trim|required');
        $this->form_validation->set_rules('cd-profile', 'profile', 'callback_image_validate');
        #$this->form_validation->set_rules('cd-password', 'Password', 'trim|required');

        //run validation on form input
        if ($this->form_validation->run() == FALSE) {
            //validation fails
            $this->form_validation->set_error_delimiters('', '');
            $error = $this->form_validation->error_array();
            $result['result'] = false;
            $result['error'] = $error;
            echo json_encode($result);
            die;
        }else{
            $session=$this->session->userdata('marbel_user');
            $this->Customer->updateProfile($session['user_id']);
            
        }
 }
 
 public function email_check() {
         if($this->input->post('cd-user_id')){
            $isExist = $this->Customer->checkEmail($this->input->post('cd-email'), $this->input->post('cd-user_id'));
         }else{
             
              $isExist = $this->Customer->checkEmail($this->input->post('cd-email'), $this->session->userdata['marbel_user']['user_id']);
         }
        if ($isExist) {
            $this->form_validation->set_message('email_check', 'This email is already exist, try with different email address.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
     public function reset_password_customer() {
        $id = $this->input->post('id');
        $password = $this->input->post('cd-password');
        if ($this->input->post('id')) {
            $this->form_validation->set_rules('cd-password', 'Password', 'trim|required|matches[cd-confirm-password]');
            $this->form_validation->set_rules('cd-confirm-password', 'Confirm Password', 'trim|required');
            //run validation on form input
            if ($this->form_validation->run() == FALSE) {
                //validation fails
                $this->form_validation->set_error_delimiters('', '');
                $error = $this->form_validation->error_array();
                $result['result'] = false;
                $result['error'] = $error;
                echo json_encode($result);
                die;
            } else {

                if ($password != '') {

                    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                    $password = hash('sha512', $password . $random_salt);
                    $user_auth = array('password' => $password, 'salt' => $random_salt);
                    $this->db->where('user_id', $id);
                    $this->db->update('m_user_auth', $user_auth);
                    $result['result'] = TRUE;
                    $result['success'] = 'Password reset Successfully';
                    echo json_encode($result);
                    die;
                }
            }
        } else {

            $result['result'] = false;
            $result['error'] = 'Some thing went wrough ! Please try again.';
            echo json_encode($result);
            die;
        }
    }
    public function image_validate() {
        if (($_FILES['cd-profile']['size'] > 0)) {

            if ($_FILES['cd-profile']['type'] == 'image/jpeg' || $_FILES['cd-profile']['type'] == 'image/png' || $_FILES['cd-profile']['type'] == 'image/jpg') {
                return true;
            } else {
                $this->form_validation->set_message('image_validate', 'Profile image must be jpeg,png or jpg ');
                return false;
            }
        } else {
            return TRUE;
        }
    }
}