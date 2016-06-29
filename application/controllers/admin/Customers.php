<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

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

    /* customer index page */

    public function index() {

        $this->data['user_type'] = $this->Customer->getUserType();
        $this->data['page'] = 'Customers';
        $this->data['title'] = 'Customers';
        $this->load->template('admin/customers', $this->data);
    }

    /* datatable for getting customer list... */

    public function get_customers() {
        $sLimit = "";
        $lenght = 50;
        $str_point = 0;


        $col_sort = array("id","email", "first_name", "last_name","last_activity", "phone", "notes");

        $order_by = "id";
        $temp = 'asc';

        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $this->Customer->db->select("id,email,first_name,last_name,last_activity,phone,notes");

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Customer->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $this->Customer->db->order_by($order_by, $temp);

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $records = $this->Customer->db->get("m_users", $lenght, $str_point);
        } else {
            $records = $this->Customer->db->get("m_users");
        }

        $this->db->select('*');
        $this->db->from('m_users');
         if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Customer->db->or_like($col_sort[$i], $words, "both");
            }
        }
        $total_record = $this->Customer->db->count_all_results();

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $total_record,
            "iTotalDisplayRecords" => $total_record,
            "aaData" => array()
        );

        $result = $records->result_array();

        $i = 0;
        $final = array();
        foreach ($result as $val) {

            $output['aaData'][] = array("DT_RowId" => $val['id'],$val['id'], '<a href="#" data-toggle="modal" class="userRow" data-target="#usersProfileModal" data-id="'.$val['id'].'">'.$val['email'].'</a>', '<a href="#" data-toggle="modal" class="userRow" data-target="#usersProfileModal" data-id="'.$val['id'].'">'.$val['first_name'].'</a>', '<a href="#" data-toggle="modal" class="userRow" data-target="#usersProfileModal" data-id="'.$val['id'].'">'.$val['last_name'].'</a>', '<a href="#" data-toggle="modal" class="userRow" data-target="#usersProfileModal" data-id="'.$val['id'].'">'.date('M j, Y', $val['last_activity']).'</a>', '<a href="#" data-toggle="modal" class="userRow" data-target="#usersProfileModal" data-id="'.$val['id'].'">'.$val['phone'].'</a>', '<a href="#" data-toggle="modal" class="userRow" data-target="#usersProfileModal" data-id="'.$val['id'].'">'.$val['notes'].'</a>', '<a href="edit_customer/'.$val['id'].'" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a> <a href="javascript:deleteCustomer('.$val['id'].')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>');
        }

        echo json_encode($output);
        die;
    }

    /* add customer  */

    public function add_customer() {

        
        $this->form_validation->set_rules('cd-email', 'Email', 'trim|required|valid_email|is_unique[m_users.email]');
        $this->form_validation->set_rules('cd-phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('cd-first', 'FirstName', 'trim|required');
        $this->form_validation->set_rules('cd-last', 'LastName', 'trim|required');
        $this->form_validation->set_rules('cd-password', 'Password', 'trim|required');

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
            
            if ( $this->input->post()) {
            $email = $this->input->post('cd-email');
            $first_name = $this->input->post('cd-first');
            $last_name = $this->input->post('cd-last');
            $password = $this->input->post('cd-password');
            if ($this->input->post('cd-type-parent') != '') {
                $type = $this->input->post('cd-type-parent');
                $parent_type = $this->input->post('cd-type');
                ;
            } else {
                $type = $this->input->post('cd-type');
                $parent_type = $this->input->post('cd-type');
            }
            $phone = $this->input->post('cd-phone');
            $email_second = $this->input->post('cd-email-second');
            $bio = $this->input->post('cd-bio');
            $height = $this->input->post('cd-height');
            $weight = $this->input->post('cd-weight');
            $company = $this->input->post('cd-company');
            $address_one = $this->input->post('cd-address-one');
            $address_two = $this->input->post('cd-address-two');
            $city = $this->input->post('cd-city');
            $state_region = $this->input->post('cd-state-region');
            $postal_code = $this->input->post('cd-postal-code');
            $country = $this->input->post('cd-country');
            $accepts_marketing = $this->input->post('cd-accepts-marketing');
            $alias = $this->input->post('cd-alias');
            $privacy_setting = $this->input->post('cd-privacy-setting');
            $units = $this->input->post('cd-units');
            $rangealarm = $this->input->post('cd-rangealarm');
            $notifications_rides = $this->input->post('cd-notifications-rides');
            $primary_riding_style = $this->input->post('cd-primary-riding-style');
            $safety_brake = $this->input->post('cd-safety-brake');
            $preferred_braking_force = $this->input->post('cd-preferred-braking-force');
            $reverse_turned = $this->input->post('cd-reverse-turned');
            $locked_settings = $this->input->post('cd-locked-settings');
            $terrain = $this->input->post('cd-terrain');
            $twitter_handle = $this->input->post('cd-twitter-handle');
            $linkedin_handle = $this->input->post('cd-linkedin-handle');
            $instagram_handle = $this->input->post('cd-instagram-handle');
            $reddit_handle = $this->input->post('cd-reddit-handle');
            $notes = $this->input->post('cd-notes');
            $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            $password = hash('sha512', $password . $random_salt);
            $data_insert = array(
                'email' => $this->input->post('cd-email'),
                'first_name' => $this->input->post('cd-first'),
                'last_name' => $last_name,
                'parent_type' => $parent_type,
                'type' => $type,
                'parent_type' => $phone,
                'email_secondary' => $email_second,
                'bio' => $bio,
                'height' => $height,
                'weight' => $weight,
                'company' => $company,
                'address_one' => $address_one,
                'address_two' => $address_two,
                'city' => $city,
                'state_or_region' => $state_region,
                'postal_code' => $postal_code,
                'country' => $country,
                'accepts' => $accepts_marketing,
                'alias' => $alias,
                'privacy_setting' => $privacy_setting,
                'units' => $units,
                'range_alarm' => $rangealarm,
                'notifications' => $notifications_rides,
                'primary_riding_style' => $primary_riding_style,
                'safety_brake' => $safety_brake,
                'preferred_braking_force' => $preferred_braking_force,
                'reverse_turned' => $reverse_turned,
                'locked_settings' => $locked_settings,
                'terrain' => $terrain,
                'twitter_handle' => $twitter_handle,
                'linkedin_handle' => $linkedin_handle,
                'instagram_handle' => $instagram_handle,
                'reddit_handle' => $reddit_handle,
                'notes' => $notes,
                'phone' => $phone,
                'last_activity' => time(),
                'register_date' => time()
            );

                $this->db->insert('m_users', $data_insert);
                $user_id = $this->db->insert_id();
                if ($user_id != '') {
                    $user_auth = array('user_id' => $user_id, 'password' => $password, 'salt' => $random_salt);
                    $this->db->insert('m_user_auth', $user_auth);
                    $result['result'] = TRUE;
                    $result['success'] = $first_name . ' ' . $last_name . ' was added successfully';
                    echo json_encode($result);
                    die;
                    
                } else {
                    
                    $result['result'] = FALSE;
                    $result['success'] = $first_name . ' ' . $last_name . '.<br />Unknown Error';
                    echo json_encode($result);
                    die;

                }
            
            }
            
        }
       
    }
   function get_child_user_level(){
      $id=$this->input->post('id');
      $result=$this->Customer->getChildUserLevel($id);
      if($result!=''){
          
          echo json_encode($result);
      }
   } 
  public function edit_customer($id=false) {
  
        if($id){
            $first_name=$this->input->post('cd-first_name');
            $last_name=$this->input->post('cd-last_name');
            $this->data['page'] = 'Edit Customers';
            $this->data['title'] = 'Edit Customers';
            if($this->input->post()){
                
                $this->Customer->updateCustomer($id);
                $this->session->set_flashdata('success','User ' . $first_name . ' ' . $last_name . ' has been updated');
                redirect('edit_customer/'.$id);
            }
            $this->data['customer']=$this->Customer->getCustomers($id);
            $this->data['user_type'] = $this->Customer->getUserType();
            $this->load->template('admin/edit_customer', $this->data);
        }
        else
        {
            redirect('customers');
        }
  }
  
  
  /* delet customer */
  
  public function delete_customer($id = false){

     if($id){
         
         $this->Customer->deleteCustomer($id);
         $this->session->set_flashdata('success','User has been deleted');
         redirect('customers');
     }      
      
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
 public function get_customer_info($id=fasle){
    if($id!=''){
        
        $this->data['user_info']=$this->Customer->getCustomerInfo($id);
        $this->data['user_orders']=$this->Services->getOrders($id);
    }
    echo  $this->load->view('admin/load_customer_info',$this->data,True);
 }
}
