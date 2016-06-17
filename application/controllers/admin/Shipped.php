<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shipped extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('customers_model', "Customer");
        $this->load->model('users_model', "Users");
        $this->load->model('shipping_model', "Shipping");
        $this->load->model('shipped_model', "Shipped");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
    }
    public function index(){
        
       $this->data['page']='Shipped';
       $this->data['title']='Shipped';
       $this->load->template('admin/shipped',$this->data);
    }
    public function get_shipped() {
         $sLimit = "";
        $lenght = 50;
        $str_point = 0;


        $col_sort = array("m_orders.id",  "m_users.first_name", "m_users.last_name","m_orders.order_date", "m_orders.tracking_number", "mol.shipped_date");

        $order_by = "m_orders.id";
        $temp = 'asc';

        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $this->Shipping->db->select("m_orders.id,m_users.first_name,m_users.last_name,m_orders.tracking_number,m_orders.order_status,m_orders.order_date,mol.shipped_date");

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Shipped->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $this->Shipped->db->order_by($order_by, $temp);

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $this->Shipped->db->join("m_users", "m_orders.user_id = m_users.id", "LEFT");
            $this->Shipped->db->join("(SELECT order_id, date as shipped_date FROM `m_order_logs` WHERE notes LIKE '%to \"shipped\"%' ORDER BY date DESC ) mol", "mol.order_id = m_orders.id", "LEFT");
            $this->db->where('m_orders.order_status','shipped');
            $records = $this->Shipped->db->get("m_orders", $lenght, $str_point);
            #echo $this->db->last_query(); die;
        } else {
            $this->Shipped->db->join("m_users", "m_orders.user_id = m_users.id", "LEFT");
            $this->Shipped->db->join("(SELECT order_id, date as shipped_date FROM `m_order_logs` WHERE notes LIKE '%to \"shipped\"%' ORDER BY date DESC ) mol", "mol.order_id = m_orders.id", "LEFT");
         
            $this->db->where('m_orders.order_status ','shipped');
            $records = $this->Shipped->db->get("m_orders");
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

            $output['aaData'][] = array("DT_RowId" => $val['id'], $val['first_name'], $val['last_name'], date('M j, Y', $val['order_date']),$val['tracking_number'],date('M j, Y',strtotime($val['shipped_date'])), '<a href="#" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a> ');
        }

        echo json_encode($output);
        die;
    }
    
}
