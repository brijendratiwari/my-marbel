<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('customers_model', "Customer");
        $this->load->model('users_model', "Users");
        $this->load->model('shipping_model', "Shipping");
        $this->load->model('services_model', "Services");
        $this->load->model('Orders_model', "Orders");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
         if($this->session->userdata['marbel_user']['type']!='admin'){
            redirect('logout');
        }
    }

    public function index() {

        $this->data['page'] = 'Services';
        $this->data['title'] = 'Services';
        $this->load->template('admin/services', $this->data);
    }

    public function get_services() {
        $sLimit = "";
        $lenght = 50;
        $str_point = 0;

        if ($this->input->get('status', TRUE)) {
            $status = $this->input->get('status', TRUE);
            ;
        } else {

            $status = 'finished';
        }
        $onhold = (strcmp($status, 'inhouse') == 0 ? " OR m_services.status = 'onhold'" : '');
        $condition = "m_services.status = " . "'" . $status . "'" . $onhold;
        if ($status == 'finished') {
            $col_sort = array("m_users.first_name", "m_users.last_name", "m_services.qa_date", "m_services.tracking_out", "m_services.status");
        } else if ($status == 'inhouse') {
            $col_sort = array("m_users.first_name", "m_users.last_name", "m_services.date", "m_services.priority", "m_services.due_date", "m_services.status");
        } elseif ($status == 'pending') {
            $col_sort = array("m_users.first_name", "m_users.last_name", "m_services.date", "m_services.suggested_response", "m_services.tracking_in");
        }
        $order_by = "m_services.id";
        $temp = 'asc';
        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $this->Services->db->select("m_services.id,m_services.due_date,m_services.qa_date,m_services.date,m_orders.user_id,m_users.first_name,m_users.last_name,m_services.priority,m_services.status,m_services.suggested_response,m_services.tracking_out,m_services.order_id,m_services.tracking_in");

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Services->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $this->Services->db->order_by($order_by, $temp);

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $this->Services->db->join("m_orders", "m_orders.id = m_services.order_id", "LEFT");
            $this->Services->db->join("m_users", "m_users.id = m_orders.user_id", "LEFT");

            $this->db->where($condition);
            $records = $this->Shipping->db->get("m_services", $lenght, $str_point);
            #echo $this->db->last_query(); die;
        } else {
            $this->Services->db->join("m_orders", "m_orders.id = m_services.order_id", "LEFT");
            $this->Services->db->join("m_users", "m_users.id = m_orders.user_id", "LEFT");
            $this->db->where($condition);
            $records = $this->Services->db->get("m_services");
            #echo $this->db->last_query(); die;
        }

        $this->db->select('*');
        $this->db->from('m_services');
        if ($this->input->get('status')) {
            $this->db->where($condition);
        }
        $total_record = $this->db->count_all_results();
//        $total_record = $this->db->count_all('master_subscriber');
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
           #echo  'service_id:'.$val['id'].'/ user_id :'.$val['user_id']; die;
            
            $user_url = '';
            $service_url = '';
     
            if ($status == 'finished') {
                $output['aaData'][] = array("DT_RowId" => $val['id'], ucwords($val['first_name']), ucwords($val['last_name']), date('M j, Y', $val['qa_date']), $val['tracking_out'], ucwords($val['status']), '<a href="' . base_url('edit_service/' . $val['id'] . '/fn') . '" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a> ');
            } else if ($status == 'inhouse') {
                $output['aaData'][] = array("DT_RowId" => $val['id'], ucwords($val['first_name']), ucwords($val['last_name']), date('M j, Y', strtotime($val['date'])), $val['priority'], Date('M j, Y', strtotime($val['due_date'])), ucwords($val['status']), '<a href="' . base_url('edit_service/' . $val['id'] . '/in') . '" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a> ');
            } elseif ($status == 'pending') {
                if($val['user_id']=='')
                $user_id=0;
                    else
                 $user_id=$val['user_id'];
                    
                if($val['id']=='')
                    $service_id=0;
                    else
                    $service_id=$val['id'];
                    
                $output['aaData'][] = array("DT_RowId" => $val['id'], ucwords($val['first_name']), ucwords($val['last_name']), date('M j, Y', strtotime($val['date'])), $val['suggested_response'], $val['tracking_in'], '<a href="' . base_url('new_services/'.$service_id.'/'.$user_id.'') . '" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a> ');
            }
        }

        echo json_encode($output);
        die;
    }

    public function new_services($service_id = false,$id = FALSE) {


        if ($service_id) {
            $service_id = $service_id;
        }
        if ($id) {
            $user_id = $id;
        }
        if($user_id==0){
            $this->session->set_flashdata('error', 'A customer id needs to be specified to add a service record');
            redirect('services?status=pending');
        }
        
        
        $this->data['page'] = "New Services";
        $tis->data['title'] = "New Services";
        $this->data['customer'] = $customer = $this->Customer->getCustomers($user_id);
        $this->data['orders'] = $this->Services->getOrders($user_id);
        $this->data['totalServiceRecords'] = $this->Services->getTotalServiceRecords();
        $this->data['admins'] = $this->Services->getAdmins();

        if ($service_id) {

            $this->data['service'] = $services = $this->Services->getService($service_id);
        }

        if ($this->input->post()) {
            if ($services) {

                $this->Services->updateNewService($service_id);
            } else {

                $this->Services->insertService();
            }
            $this->session->set_flashdata('success', 'Service Record has been added for order #' . $this->input->post('order_number'));
            redirect('new_services/'.$service_id.'/'.$user_id.'');
        }
        if ($customer == '') {
            $this->session->set_flashdata('error', 'A customer id needs to be specified to add a service record');
            redirect('services?status=pending');
        }

        $this->load->template('admin/new_services', $this->data);
        }
        
    public function new_order_service($user_id = false,$order_id = FALSE) {

     
      
        $this->data['page'] = "New Services";
        $tis->data['title'] = "New Services";
        $this->data['customer'] = $customer = $this->Customer->getCustomers($user_id);
        $this->data['orders'] = $this->Services->getOrders($user_id);
        $this->data['totalServiceRecords'] = $this->Services->getTotalServiceRecords();
        $this->data['admins'] = $this->Services->getAdmins();
        $this->data['orderId'] = $order_id;

        
        if ($this->input->post()) {


            $this->Services->insertService();
            $this->session->set_flashdata('success', 'Service Record has been added for order #' . $this->input->post('order_number'));
            redirect('order_service/'.$user_id.'/'.$order_id.'');
        }
        if ($customer == '') {
            $this->session->set_flashdata('error', 'A customer id needs to be specified to add a service record');
            redirect('services?status=pending');
        }

        $this->load->template('admin/new_services', $this->data);
        }

        public function new_cust_services($id = FALSE) {

             if ($id) {
            $user_id = $id;
        }
        $this->data['page'] = "New Services";
        $tis->data['title'] = "New Services";
        $this->data['customer'] = $customer = $this->Customer->getCustomers($user_id);
        $this->data['orders'] = $this->Services->getOrders($user_id);
        $this->data['totalServiceRecords'] = $this->Services->getTotalServiceRecords();
        $this->data['admins'] = $this->Services->getAdmins();



        if ($this->input->post()) {


            $this->Services->insertService();
            $this->session->set_flashdata('success', 'Service Record has been added for order #' . $this->input->post('order_number'));
            redirect('new_services/'.$user_id.'');
        }
        if ($customer == '') {
            $this->session->set_flashdata('error', 'A customer id needs to be specified to add a service record');
            redirect('services?status=pending');
        }

        $this->load->template('admin/new_services', $this->data);
    }

    public function edit_service($id = false, $param = false) {

        $this->data['service'] = $services = $this->Services->getService($id);
        $this->data['param'] = $param;
        if (!empty($services)) {

            $this->data['recentServiceLog'] = $this->Services->getRecentServiceLog($id);
            $this->data['page'] = "Edit service";
            $this->data['title'] = "Edit Service";
            if ($this->input->post()) {
                $this->Services->updateService($id);
                redirect('edit_service/' . $id . '/' . $param);
            }
        } else {
            $this->session->set_flashdata('error', 'Could not find this service record, please try another');
            redirect('services/');
        }

        $this->load->template('admin/edit_services', $this->data);
    }

    public function delete_services($id = false, $param = false) {

        $this->Services->deleteService($id);
        $this->session->set_flashdata('success', 'Deleted the service record for service id ' . $id);
        if ($param == 'fn')
            redirect('services?status=finished');

        if ($param == 'in')
            redirect('services?status=inhouse');
    }

}
