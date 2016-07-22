<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('users_model', "Users");
    }

    public function index() {
        $check_session = $this->Users->auth_check();
        if ($check_session == false) {
            $this->data['page'] = 'login';
            $this->data['title'] = 'Login';
            $this->load->view('login', $this->data);
        } else {
            redirect($this->session->userdata['marbel_user']['type']);
        }
    }

    public function ajax_login() {
        $email = $this->input->post('login__email');
        $password = $this->input->post('login__password');
        $login = $this->Users->login($email, $password);
        if ($login > 0) {
            echo $login;
        } else {
            $user_info = $this->session->userdata('marbel_user');

            if ($user_info != '') {
                echo base_url($user_info['type']);
            } else {

                echo '/logout';
            }
        }
    }

    public function logout() {

        $this->session->sess_destroy();
        redirect(base_url('login'));
    }

    public function forgot_password() {

        $this->data['page'] = 'Forgot Password';
        $this->data['title'] = 'Forgot Password';
        $this->load->view('forgot_password', $this->data);
    }

    public function ajax_forgot() {

        if ($this->input->post('reset_request_email')) {
            $email = $this->input->post('reset_request_email');
            $login = $this->Users->sendPasswordResetEmail($email);
            echo $login;
            die;
        } else if ($this->input->post('reset_key') != '') {
            $password = $this->Users->updatePassword($this->input->post('reset_email'), $this->input->post('reset_key'), $this->input->post('reset_password'));
            echo $password;
            die;
        }
    }

    public function reset_password($email = false, $key = false) {
        $check_session = $this->Users->auth_check();
        if ($check_session == false) {
            if ($email != '' && $key != '') {
                $this->data['page'] = 'Reset password';
                $this->data['title'] = 'Reset password';
                $this->data['resetKey'] = $key;
                $this->data['email'] = $email;
                $this->load->view('reset_password', $this->data);
            } else {

                redirect(base_url());
            }
        } else {
            redirect($this->session->userdata['marbel_user']['type']);
        }
    }

}
