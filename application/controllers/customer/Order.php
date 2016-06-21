<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
        function __construct() {
            parent::__construct();
            $this->load->database();
            $this->load->model('users_model', "Users");
            $this->load->model('services_model', "Services");
             $this->load->model('services_model', "Services");
              $this->load->model('orders_model', "Orders");
            if($this->Users->auth_check()==false){
                redirect('/login');
            }
        }
      public function index(){
           $this->data['page']='Order';
          $this->data['title']='Order';
          if($this->input->post()){
              
            $order_number = $this->input->post('cd-order-number');
            $orderId = $this->input->post('cd-order-id');
            $delivery_address = $this->input->post('cd-address');
            $delivery_address_2 = $this->input->post('cd-address2');
            $city = $this->input->post('cd-city');
            $state = $this->input->post('cd-state');
            $zip = $this->input->post('cd-zip');
            $country = $this->input->post('cd-country');
            $wheel_color = $this->input->post('cd-wheel-color');
            $wheel_size = $this->input->post('cd-wheel-size');
            $response=$this->Orders->updateOrder($this->session->userdata['marbel_user']['user_id'], $orderId, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $wheel_color, $wheel_size);
            if($response){
                $this->session->set_flashdata('success','Shipping information for order #'.$order_number.' has been updated');
                redirect('order');
            }else{
                
                 $this->session->set_flashdata('error','Could not update shipping for order #'.$order_number.'<br />This item has already shipped or was refunded');
                 redirect('order');
            }
            
          }
          $user_id=$this->session->userdata['marbel_user']['user_id'];
          $this->data['countries']=$this->Services->getCountries();
          $this->data['orders']=$this->Services->getOrders($user_id);
          $this->load->customer('customer/orders',$this->data);
      }
}
