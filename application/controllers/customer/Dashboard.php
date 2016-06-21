<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
        function __construct() {
            parent::__construct();
            $this->load->database();
            $this->load->model('users_model', "Users");
            $this->load->model('services_model', "Services");
            if($this->Users->auth_check()==false){
                redirect('/login');
            }
        }
      public function index(){
          
          $this->data['page']='Dashboard';
          $this->data['title']='Dashboard';
          $user_id=$this->session->userdata['marbel_user']['user_id'];
          $this->data['orders']=$this->Services->getOrders($user_id);
          $this->load->customer('customer/dashboard',$this->data);
      } 
}
