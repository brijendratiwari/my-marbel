<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CustomersRides extends CI_Controller {

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

    public function index() {

        $this->data['page'] = 'Rides';
        $this->data['title'] = 'Rides';
        $this->load->template('admin/rides/rides', $this->data);
    }

    public function rides_list() {

        $sLimit = "";
        $lenght = 50;
        $str_point = 0;


        $col_sort = array("m_rides.ride_ID", "m_rides.ride_ID", "m_users.first_name", "m_users.last_name", "m_rides.start_time", "m_rides.trip_distance", "maxspeed", "averagespeed", "m_rides.trip_duration", "m_rides.efficiency");

        $order_by = "m_rides.ride_ID";
        $temp = 'desc';

        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'desc' ? 'desc' : 'asc';
            $order_by = $col_sort[$index];
        }
        $this->Rides->db->select("m_rides.ride_ID,m_users.first_name,m_users.last_name,m_rides.start_time,round(m_rides.trip_distance,2) as trip_distance,max(m_ride_points.speed) as maxspeed,round(AVG(m_ride_points.speed),2) as averagespeed, round((m_rides.trip_duration/60),2) AS trip_duration,round(m_rides.efficiency,2) as efficiency");

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {
                if ($col_sort[$i] == 'averagespeed' || $col_sort[$i] == 'maxspeed')
                    $col_sort[$i] = 'speed';
                $this->Rides->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $this->Rides->db->order_by($order_by, $temp);
        $this->Rides->db->group_by('m_rides.ride_id');
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $this->Rides->db->join("m_ride_points", "m_rides.ride_id = m_ride_points.ride_id", "LEFT");
            $this->Rides->db->join("m_users", "m_rides.userID = m_users.id", "LEFT");
            $records = $this->Rides->db->get("m_rides", $lenght, $str_point);
        } else {

            $this->Rides->db->join("m_users", "m_rides.userID = m_users.id", "LEFT");
            $this->Rides->db->join("m_ride_points", "m_rides.ride_id = m_ride_points.ride_id", "LEFT");
            $records = $this->Rides->db->get("m_rides");
        }
        #echo $this->db->last_query(); die;
        $this->db->select('m_rides.ride_ID,m_users.first_name,m_users.last_name,m_rides.start_time,round(m_rides.trip_distance,2) as trip_distance,max(m_ride_points.speed) as maxspeed,round(AVG(m_ride_points.speed),2) as averagespeed, round((m_rides.trip_duration/60),2) AS trip_duration,round(m_rides.efficiency,2) as efficiency');

        $this->db->from('m_rides');
        $this->Rides->db->join("m_users", "m_rides.userID = m_users.id", "LEFT");
        $this->Rides->db->join("m_ride_points", "m_rides.ride_id = m_ride_points.ride_id", "LEFT");
        $this->Rides->db->group_by('m_rides.ride_id');
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Rides->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $total_record = $this->Rides->db->get();
        #echo $this->db->last_query(); die;
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => count($total_record->result_array()),
            "iTotalDisplayRecords" => count($total_record->result_array()),
            "aaData" => array()
        );

        $result = $records->result_array();
        $i = 0;
        $final = array();
        foreach ($result as $val) {

            $output['aaData'][] = array("DT_RowId" => $val['ride_ID'], $val['ride_ID'], '<a href="' . base_url('ride_details/' . $val['ride_ID']) . '" title="View ride information"  class="btn btn-xs btn-info userRow"><i class="fa fa-eye"></i></a>', $val['first_name'], $val['last_name'], date('M j, Y h:i A', strtotime($val['start_time'])), $val['trip_distance'], $val['maxspeed'], $val['averagespeed'], $val['trip_duration'], $val['efficiency']);
        }

        echo json_encode($output);
        die;
    }

    public function ride_details($id = false) {
        $this->data['page'] = 'Ride Details';
        $this->data['title'] = 'Ride Details';
        $this->load->library('googlemaps');
        $this->data['rides_points'] = $ride_points = $this->Rides->getRidesPointsDetails($id);

        #echo "<pre>"; print_r($this->data['rides_points']); 
        #echo  reset($ride_points['polyline']); die;
        if (!empty($ride_points['polyline']) && $ride_points['polyline']!='') {
        $config['center'] = !empty($ride_points['polyline']) ? reset($ride_points['polyline']) : '';
        $config['zoom'] = 'auto';
        $config['styles'] = array(
            array("name" => "Red Parks", "definition" => array(
                    array("featureType" => "all", "stylers" => array(array("saturation" => "-30"))),
                    array("featureType" => "poi.park", "stylers" => array(array("saturation" => "10"), array("hue" => "#990000")))
                )),
            array("name" => "Black Roads", "definition" => array(
                    array("featureType" => "all", "stylers" => array(array("saturation" => "-70"))),
                    array("featureType" => "road.arterial", "elementType" => "geometry", "stylers" => array(array("hue" => "#000000")))
                )),
            array("name" => "No Businesses", "definition" => array(
                    array("featureType" => "poi.business", "elementType" => "labels", "stylers" => array(array("visibility" => "off")))
                ))
        );
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";
        $this->googlemaps->initialize($config);
        
            $polyline = array();
            $polyline['points'] = array_values($ride_points['polyline']);
            $polyline['strokeColor'] = '#00aeef';
            $polyline['strokeOpacity'] = '1.0';
            $polyline['strokeWeight'] = '10';
            $polyline['strokeBorder'] = 'red';
            $this->googlemaps->add_polyline($polyline);
     
        $this->data['map'] = $this->googlemaps->create_map();
   }
        $this->load->template('admin/rides/ride_details', $this->data);
    }

}
