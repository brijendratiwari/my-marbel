<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('customers_model', "Customer");
        $this->load->model('users_model', "Users");
        $this->load->model('shipping_model', "Shipping");
        $this->load->model('services_model', "Services");
        $this->load->model('inventory_model', "inventory");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
         if($this->session->userdata['marbel_user']['type']!='admin'){
            redirect('logout');
        }
    }

    public function index() {
        $this->data['page'] = 'Inventory';
        $this->data['title'] = 'Inventory Explainer';
        $this->load->template('admin/inventory/inventory', $this->data);
    }

    public function get_part() {
         $sLimit = "";
        $lenght = 10;
        $str_point = 0;
        $col_sort = array("m_part.part_id","m_part.part_name", "m_part.part_cost", "m_part.part_quantity","part_category_name","part_type_name",'part_manufacturer');
        $order_by = "m_part.part_id";
        $temp = 'Desc';
        $id_to = $this->session->userdata['marbel_user']['user_id'];
        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $this->inventory->db->select("m_part.part_id,m_part.part_name,m_part.part_cost,m_part.part_quantity,m_part.part_manufacturer,part_category_name,part_type_name");

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->inventory->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $this->inventory->db->order_by($order_by, $temp);

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $this->db->join('m_part_categories','m_part_categories.part_category_id=part_category','left');
            $this->db->join('m_part_type','m_part_type.part_type_id=part_type','left');
            $this->db->where('part_user_id', $id_to);
            $records = $this->inventory->db->get("m_part", $lenght, $str_point);
        } 
        
         if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->inventory->db->or_like($col_sort[$i], $words, "both");
            }
        }
        $total_record = $this->inventory->db->count_all_results();

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

            $output['aaData'][] = array("DT_RowId" => $val['part_id'],$val['part_name'], $val['part_category_name'], $val['part_type_name'],$val['part_quantity'],$val['part_cost'],$val['part_manufacturer'], ' <a class="btn btn-xs btn-success edit-task" href="#" data-id="'. $val['part_id'].'" data-toggle="modal" data-target="#editTaskModal"><i class="fa fa-eye"></i> View</a>');
        }

        echo json_encode($output);
        die;
    }

    public function addPart() {
         
        $this->data['page'] = "New Part";
        $tis->data['title'] = "New Part";
        $this->data['part_category'] = $this->inventory->getPartCategory();
        $this->data['part_type'] = $this->inventory->getPartType();
         $this->data["style_to_load"] = array("assets/css/chosen/chosen.min.css","assets/css/switch/bootstrap-switch.min.css");
        $this->data['scripts_to_load'] = array("assets/js/chosen/chosen.jquery.min.js","assets/js/jquery.number.min.js","assets/js/switch/bootstrap-switch.min.js","assets/js/jquery.form.min.js");
       
        if ($this->input->post()) {
              
              $this->form_validation->set_rules('part_name', 'Name', 'required'); 
              $this->form_validation->set_rules('part_description', 'Description', 'required'); 
              $this->form_validation->set_rules('part_category', 'Category', 'required'); 
              $this->form_validation->set_rules('part_type', 'Type', 'required'); 
              $this->form_validation->set_rules('part_main_material', 'Material', 'required'); 
              $this->form_validation->set_rules('part_quantity', 'Quantity', 'required|numeric'); 
              $this->form_validation->set_rules('part_reorder_quantity', 'Reorder Quantity','numeric'); 
              $this->form_validation->set_rules('part_cost', 'Cost', 'required|numeric'); 
              $this->form_validation->set_rules('part_weight', 'Weight', 'required|numeric'); 
              $this->form_validation->set_rules('part_lead_time', 'Lead Time', 'required|numeric'); 
              $this->form_validation->set_rules('part_manufacturer', 'Manufacturer', 'required'); 
              $this->form_validation->set_rules('part_manufacturer_contact', 'Manufacturer Contact', 'required'); 
              $this->form_validation->set_rules('part_price', 'Price', 'required|numeric'); 
              
              if ($this->form_validation->run() == FALSE) {
                $this->form_validation->set_error_delimiters('', '');
                $error = $this->form_validation->error_array();
               
                $result['result'] = false;
                $result['error'] = $error;
                echo json_encode($result);
                die;
            }else{
               $input = $this->input->post();
               $input['part_user_id']=$this->session->userdata['marbel_user']['user_id'];
               $input['created_at']=date('Y-m-d H:i:s');
               if($input['part_auto_reorder']=='on'){
               $input['part_auto_reorder']=1;    
               }else{
                $input['part_auto_reorder']=0;    
               }
               $insert_id = $this->inventory->addPart($input);
               if($insert_id){
                 $this->session->set_flashdata('success', 'Part Added Successfully');   
               }else{
                 $this->session->set_flashdata('error', 'Something went wrong');   
               }
               
                $result['result'] = True;
                echo json_encode($result);
                die;
            }
            
        }
        

        $this->load->template('admin/inventory/add_part', $this->data);
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
