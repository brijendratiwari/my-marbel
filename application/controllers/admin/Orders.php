<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('orders_model', "Orders");
        $this->load->model('users_model', "Users");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
    }

    /* order index page */

    public function index() {

        $data['countries'] = $this->getCountries();
        $data['page'] = 'Orders';
        $data['title'] = 'Orders';
        $this->load->template('admin/orders', $data);
    }

    /* datatable for getting order list... */

    public function get_orders() {
        $sLimit = "";
        $lenght = 50;
        $str_point = 0;


        $col_sort = array("m_orders.id", "m_orders.order_number", "m_orders.order_date", "m_users.first_name", "m_users.last_name", "m_orders.order_status", "m_orders.est_ship_date", "m_orders.tracking_number", "m_orders.order_total");

        $order_by = "m_orders.id";
        $temp = 'asc';

        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $this->Orders->db->select("m_orders.id,m_orders.order_number,m_orders.order_date,m_users.first_name,m_users.last_name,m_orders.order_status,m_orders.est_ship_date,m_orders.tracking_number,m_orders.order_total");

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Orders->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $this->Orders->db->order_by($order_by, $temp);

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $this->Orders->db->join("m_users", "m_orders.user_id = m_users.id", "LEFT");
            $records = $this->Orders->db->get("m_orders", $lenght, $str_point);
        } else {
            $this->Orders->db->join("m_users", "m_orders.user_id = m_users.id", "LEFT");
            $records = $this->Orders->db->get("m_orders");
        }

        $this->db->select('*');
        $this->db->from('m_orders');
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

            $output['aaData'][] = array("DT_RowId" => $val['id'], $val['order_number'], date('M j, Y', $val['order_date']), $val['first_name'], $val['last_name'], $val['order_status'], $val['tracking_number'], $val['order_total'], '<a href="' . base_url('index.php/edit_order/' . $val['id'] . '') . '" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a> <a href="javascript:deleteOrder('.$val['order_number'].')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>');
        }

        echo json_encode($output);
        die;
    }

    /* add order  */

    public function add_order() {


        $this->form_validation->set_rules('cd-email', 'Email', 'trim|required');
        $this->form_validation->set_rules('cd-address', 'Address', 'trim|required');
        $this->form_validation->set_rules('cd-city', 'City', 'trim|required');
        $this->form_validation->set_rules('cd-state', 'State', 'trim|required');
        $this->form_validation->set_rules('cd-zip', 'Zip', 'trim|required');

        //run validation on form input
        if ($this->form_validation->run() == FALSE) {
            //validation fails
            $this->form_validation->set_error_delimiters('', '');
            $error = $this->form_validation->error_array();
            $result['result'] = false;
            $result['error'] = $error;
            echo json_encode($result);
            die;
        } else {


            $email = $this->input->post('cd-email');
            $order_number = $this->input->post('cd-number');
            $delivery_address = $this->input->post('cd-address');
            $delivery_address_2 = $this->input->post('cd-address2');
            $city = $this->input->post('cd-city');
            $state = $this->input->post('cd-state');
            $zip = $this->input->post('cd-zip');
            $country = $this->input->post('cd-country');
            $status = $this->input->post('cd-status');
            $invoice_url = $this->input->post('cd-invoice');
            $date = strtotime($this->input->post('cd-date'));
            $est_ship_date = strtotime($this->input->post('cd-est-ship-date'));
            $est_ship_location = $this->input->post('cd-est-ship-location');
            $product = $this->input->post('cd-product');
            $wheel_color = $this->input->post('cd-wheel-color');
            $wheel_size = $this->input->post('cd-wheel-size');
            $firmware_version = $this->input->post('cd-firmware');
            $deck_serial_number = $this->input->post('cd-deck');
            $main_serial_number = $this->input->post('cd-main-serial');
            $tracking_number = $this->input->post('cd-tracking');
            $notes = $this->input->post('cd-notes');
//            $priority = $this->input->post('cd-priority');
            $priority = 3;
            $order_total = 0;

            $response = $this->Orders->save_order($email, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $order_total, $status, $invoice_url, $date, $est_ship_date, $est_ship_location, $product, $wheel_color, $wheel_size, $firmware_version, $deck_serial_number, $main_serial_number, $tracking_number, $notes, $priority);

            if ($response == 0) {
                $result['result'] = TRUE;
                $result['success'] = 'Order was added successfully';
                echo json_encode($result);
                die;
            }
            if ($response == 1) {
                $result['result'] = FALSE;
                $result['failed'] = 'Email address not found!!';
                echo json_encode($result);
                die;
            }

            if ($response == 2) {
                $result['result'] = FALSE;
                $result['failed'] = 'Order number exist!!';
                echo json_encode($result);
                die;
            }
        }
    }

    /* get countries from json file */

    protected function getCountries() {
        $jsonStr = file_get_contents(base_url() . "/assets/countries.json");
        return json_decode($jsonStr, true);
    }

    /* get order for edit by order id .... */

    public function edit_order($order_id = FALSE) {

        if ($order_id) {

            $data['page'] = 'Orders';
            $data['title'] = 'Orders';

            if ($this->input->post()) {



                $this->form_validation->set_rules('cd-wheel_color', 'Whell Color', 'trim|required');
                //run validation on form input
                if ($this->form_validation->run() == FALSE) {

                    $data['countries'] = $this->getCountries();
                    $data['order'] = $this->Orders->getOrder($order_id);
                    /* get recent order log ... */
                    $data['recentOrderLog'] = $this->Orders->getRecentOrderLog($order_id);
                    /* get customer details ... */
                    $data['customer'] = $this->Orders->getCustomer($data['order'][0]['user_id']);
                    $data['order_id'] = $order_id;
                    $this->load->template('admin/edit_order', $data);
                } else {


                    /* update order */

                    $order_number = $this->input->post('cd-order_number');
                    $delivery_address = $this->input->post('cd-address');
                    $delivery_address_2 = $this->input->post('cd-address2');
                    $city = $this->input->post('cd-city');
                    $state = $this->input->post('cd-state');
                    $zip = $this->input->post('cd-zip');
                    $country = $this->input->post('cd-country');
                    $wheel_color = $this->input->post('cd-wheel_color');
                    $wheel_size = $this->input->post('cd-wheel_size');
                    $product = $this->input->post('cd-product');
                    $order_total = $this->input->post('cd-order_total');
                    $shipping_cost = $this->input->post('cd-shipping_cost');
                    $order_status = $this->input->post('cd-order_status');
                    $invoice_url = $this->input->post('cd-invoice_url');
                    $est_ship_date = $this->input->post('cd-est_ship_date');
                    $est_ship_location = $this->input->post('cd-est_ship_location');
                    $firmware_version = $this->input->post('cd-firmware_version');
                    $deck_serial_number = $this->input->post('cd-deck_serial_number');
                    $main_serial_number = $this->input->post('cd-main_serial_number');
                    $tracking_number = $this->input->post('cd-tracking_number');
                    $notes = $this->input->post('cd-notes');
                    $priority = $this->input->post('cd-priority');
                    $user_id = $this->input->post('cd-userid');

                    $response = $this->Orders->adminUpdateOrder($user_id, $order_id, $order_number, $delivery_address, $delivery_address_2, $city, $state, $zip, $country, $wheel_color, $wheel_size, $product, $order_total, $shipping_cost, $order_status, $invoice_url, $est_ship_date, $est_ship_location, $firmware_version, $deck_serial_number, $main_serial_number, $tracking_number, $notes, $priority);

                    if ($response) {
                        $this->session->set_flashdata('success', 'Order was updated successfully!!');
                        redirect('edit_order/' . $order_id . '');
                    } else {
                        $this->session->set_flashdata('error', 'Order not update,try again!!');
                        redirect('edit_order/' . $order_id . '');
                    }
                }
            } else {

                $data['countries'] = $this->getCountries();
                $data['order'] = $this->Orders->getOrder($order_id);
                /* get recent order log ... */
                $data['recentOrderLog'] = $this->Orders->getRecentOrderLog($order_id);
                /* get customer details ... */
                $data['customer'] = $this->Orders->getCustomer($data['order'][0]['user_id']);
                $data['order_id'] = $order_id;
                $this->load->template('admin/edit_order', $data);
            }
        } else {
            redirect('orders');
        }
    }

    /* remove order */

    public function delete_order($order_number = FALSE) {

        if ($order_number) {

            $response = $this->Orders->deleteOrder($order_number);

            if ($response) {
                $this->session->set_flashdata('success', 'Order was deleted successfully!!');
                redirect('orders');
            } else {
                $this->session->set_flashdata('error', 'Order not delete,try again!!');
                redirect('orders');
            }
        }else{
            
            redirect('orders');
        }
    }

}
