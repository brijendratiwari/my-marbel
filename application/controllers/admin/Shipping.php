<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('customers_model', "Customer");
        $this->load->model('users_model', "Users");
        $this->load->model('shipping_model', "Shipping");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
    }
    public function index(){
        
       $this->data['page']='Shipping';
       $this->data['title']='Shipping';
       $this->load->template('admin/shipping',$this->data);
    }
    public function get_shipping() {
         $sLimit = "";
        $lenght = 50;
        $str_point = 0;


        $col_sort = array("m_orders.id",  "m_users.first_name", "m_users.last_name", "m_orders.order_date", "m_orders.est_ship_date", "m_orders.est_ship_date", "m_users.last_activity", "m_orders.order_status","m_orders.wheel_color","m_orders.wheel_size","m_orders.priority");

        $order_by = "m_orders.id";
        $temp = 'asc';

        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $this->Shipping->db->select("m_orders.id,m_users.first_name,m_users.last_name,m_orders.wheel_color,m_orders.wheel_size,m_orders.priority,m_users.last_activity,m_orders.order_status,m_orders.order_date,m_orders.est_ship_date");

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Shipping->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $this->Shipping->db->order_by($order_by, $temp);

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $this->Shipping->db->join("m_users", "m_orders.user_id = m_users.id", "LEFT");
            $this->db->where('m_orders.est_ship_date > ','0');
            $this->db->where('m_orders.order_status != ','refunded');
            $this->db->where('m_orders.country','US');
            $this->db->where('m_orders.order_status != ' ,'deposit');
            $this->db->where('m_orders.order_status != ','hold');
            $this->db->where('m_orders.order_status != ','shipped');
            $records = $this->Shipping->db->get("m_orders", $lenght, $str_point);
            #echo $this->db->last_query(); die;
        } else {
            $this->Shipping->db->join("m_users", "m_orders.user_id = m_users.id", "LEFT");
             $this->db->where('m_orders.est_ship_date > ', '0');
            $this->db->where('m_orders.order_status != ','refunded');
            $this->db->where('m_orders.country','US');
            $this->db->where('m_orders.order_status != ','deposit');
            $this->db->where('m_orders.order_status != ','hold');
            $this->db->where('m_orders.order_status != ','shipped');
            $records = $this->Shipping->db->get("m_orders");
            #echo $this->db->last_query(); die;
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

            $output['aaData'][] = array("DT_RowId" => $val['id'], $val['first_name'], $val['last_name'], date('M j, Y', $val['order_date']), date('M j, Y',$val['est_ship_date']), Date('M j, Y',$val['last_activity']), $val['order_status'], $val['wheel_color'], $val['wheel_size'],$val['priority'], '<a href="#" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a> ');
        }

        echo json_encode($output);
        die;
    }
    
}
