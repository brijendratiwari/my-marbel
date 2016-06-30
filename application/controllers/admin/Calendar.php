<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Calendar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model', "Users");
        $this->load->model('Calendar_model', "Calendar");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
         if($this->session->userdata['marbel_user']['type']!='admin'){
            redirect('logout');
        }
    }

    public function index() {
        $this->data['page'] = 'Calender';
        $this->data['title'] = 'Calender';

        $this->load->template('admin/calender', $this->data);
    }
    public function process(){
        
        if($this->input->post()){
            
            $this->Calendar->calendar_process();
        }
    }
}
