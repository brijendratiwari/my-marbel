<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
        function __construct() {
            parent::__construct();
            $this->load->database();
            $this->load->model('users_model', "Users");
            if($this->Users->auth_check()==false){
                redirect('/login');
            }
             if($this->session->userdata['marbel_user']['type']!='admin'){
            redirect('logout');
        }
        }
      public function index(){
          
          $this->data['page']='Dashboard';
          $this->data['title']='Dashboard';
          $this->load->template('admin/dashboard/dashboard',$this->data);
      } 
}

