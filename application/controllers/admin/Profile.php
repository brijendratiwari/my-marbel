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
         if($this->session->userdata['marbel_user']['type']!='admin'){
            redirect('logout');
        }
    }
    public function index(){
        
        $this->data['page']="profile";
        $this->data['title']="Profile";
        $user_info=$this->session->userdata('marbel_user');
        $this->data['regarding_task'] = $this->Customer->getUsersTasks($user_info['user_id']);
        $this->data['user_info']=$this->Customer->getCustomers($user_info['user_id']);
        $this->data['user_orders']=$this->Services->getOrders($user_info['user_id']);
        $this->load->template('admin/profile/profile',$this->data);
    }
}