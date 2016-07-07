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
}