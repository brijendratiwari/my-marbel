<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('customers_model', "Customer");
        $this->load->model('users_model', "Users");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
    }
    public function index(){
        
        $this->data['page']="profile";
        $this->data['title']="Profile";
        $user_info=$this->session->userdata('marbel_user');
        $this->data['user_info']=$this->Customer->getCustomers($user_info['user_id']);
        $this->load->template('admin/profile',$this->data);
    }
}