<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
* and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Boards extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('customers_model', "Customer");
        $this->load->model('users_model', "Users");
        $this->load->model('services_model', "Services");
        $this->load->model('rides_model', "Rides");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
        if ($this->session->userdata['marbel_user']['type'] != 'admin') {
            redirect('logout');
        }
    }
   public function index(){
       $this->data['page'] = 'Boards';
        $this->data['title'] = 'Boards';
        $this->load->template('admin/boards/boards', $this->data);
       
   }
   public function boards_list(){
        $sLimit = "";
        $lenght = 50;
        $str_point = 0;


        $col_sort = array("m_boards.brd_id","m_boards.brd_id","m_boards.odometer","m_boards.ride_count", "m_users.first_name", "m_users.last_name", "m_boards.serial_number", "m_boards.firmware_version", "m_boards.timestamp", "m_boards.wheel_size", "m_boards.batt_charge_count", "m_boards.lock_status", "m_boards.parent_lock_status", "m_boards.batt_serial_number", "m_boards.motor_version", "m_boards.aio_circuit_version", "m_boards.deck_version", "m_boards.production_date");

        $order_by = "brd_id";
        $temp = 'asc';

        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $this->Customer->db->select("m_boards.user_id,m_boards.brd_id,m_boards.odometer,m_boards.ride_count, m_users.first_name, m_users.last_name, m_boards.serial_number, m_boards.firmware_version, m_boards.timestamp, m_boards.wheel_size, m_boards.batt_charge_count, m_boards.lock_status, m_boards.parent_lock_status, m_boards.batt_serial_number, m_boards.motor_version ,m_boards.aio_circuit_version, m_boards.deck_version,m_boards.production_date");

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
            $this->db->join('m_users','m_users.id=m_boards.user_id','LEFT');
            $records = $this->Customer->db->get("m_boards", $lenght, $str_point);
            
        } else {
            $this->db->join('m_users','m_users.id=m_boards.user_id','LEFT');
            $records = $this->Customer->db->get("m_boards");
        }

        $this->db->select('m_boards.user_id,m_boards.brd_id,m_boards.odometer,m_boards.ride_count, m_users.first_name, m_users.last_name, m_boards.serial_number, m_boards.firmware_version, m_boards.timestamp, m_boards.wheel_size, m_boards.batt_charge_count, m_boards.lock_status, m_boards.parent_lock_status, m_boards.batt_serial_number, m_boards.motor_version ,m_boards.aio_circuit_version, m_boards.deck_version,m_boards.production_date');
        $this->db->from('m_boards');
         $this->db->join('m_users','m_users.id=m_boards.user_id','LEFT');
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

            $output['aaData'][] = array("DT_RowId" => $val['brd_id'], $val['brd_id'], '<a href="' . base_url('get_customer_info/' . $val['user_id']) . '" title="View board information"  class="btn btn-xs btn-info userRow"><i class="fa fa-eye"></i></a>', $val['odometer'], $val['ride_count'], $val['first_name'], $val['last_name'],$val['serial_number'],$val['firmware_version'],date('M j, Y h:i A', strtotime($val['timestamp'])),$val['wheel_size'],$val['batt_charge_count'],$val['lock_status'], $val['parent_lock_status'], $val['batt_serial_number'], $val['motor_version'], $val['aio_circuit_version'], $val['deck_version'], (!empty($val['production_date']) && $val['production_date']!='0000-00-00 00:00:00')?date('M j, Y', strtotime($val['production_date'])):"");
        }

        echo json_encode($output);
        die;
   }
}