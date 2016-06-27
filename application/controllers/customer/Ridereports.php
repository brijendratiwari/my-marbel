<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ridereports extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('customers_model', "Customer");
        $this->load->model('users_model', "Users");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
         if($this->session->userdata['marbel_user']['type']!='customer'){
                redirect('logout');
            }
    }
    public function index(){
        
        $this->data['page']="Ride reports";
        $this->data['title']="Ride reports";
      
        $this->load->customer('customer/ride_reports',$this->data);
    }
}