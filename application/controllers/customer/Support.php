<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends CI_Controller {

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
        
        $this->data['page']="Support";
        $this->data['title']="Support";
      
        $this->load->customer('customer/support',$this->data);
    }
}