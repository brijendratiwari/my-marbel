<?php

class Rides_model extends CI_Model {

    public function getRidesPointsDetails($id = false) {

        $this->db->select('*')->from('m_ride_points');
        $this->db->where('ride_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results = array();
            $result = $query->result_array();
            if ($result) {

                $max = -9999999; //will hold max val
                $found_item = null; //will hold item with max val;
                $total = 0;
                $speed = 0;
                for ($i = 0; $i < count($result); $i++) {

                    if (isset($result[$i + 1]['latitude']) && isset($result[$i + 1]['longitude'])) {
                        $speed = $this->distanceCalculation($result[$i]['latitude'], $result[$i]['longitude'], $result[$i + 1]['latitude'], $result[$i + 1]['longitude']);
                    }

                    $results['polyline'][$i] = array('lat' => $result[$i]['latitude'], 'lng' => $result[$i]['longitude']);
                    $results['graph_data'][$i] = array('speed' => str_replace('NAN', 0, round($speed / 0.000277778, 2)), 'elevation' => $result[$i]['elevation'], 'time_stamp' => $result[$i]['time_stamp'] * 1000, 'power' => $result[$i]['board_batt']);
                    if ($results['graph_data'][$i]['speed'] > $max) {
                        $max = $results['graph_data'][$i]['speed'];
                        $found_item = $results['graph_data'][$i]['speed'];
                    }
                    $total = $total + $results['graph_data'][$i]['speed'];
                }
                $results['maxspeed'] = $found_item;
                $results['avgspeed'] = (round($total / count($result), 2));
            }

            return $results;
        } else {

            return false;
        }
    }

    public function getRideById($id = false) {

        $this->db->select('m_rides.*, m_users.first_name,m_users.last_name,m_users.user_profile_pic')->from('m_rides');
        $this->db->join('m_users', 'm_users.id=m_rides.userID', 'left');
        $this->db->where('ride_ID', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getRidePontsByRideId($id = false) {

        $this->db->select('round(MAX(speed),1) as maxspeed,round(AVG(speed),1) as avgspeed,round(MAX(current),1) as maxcurrent,round(AVG(current),1) as avgcurrent,round(MAX(wh),1) as maxpowes,round(AVG(wh),1) as avgpower, MAX(elevation) as max_elevation')->from('m_ride_points');
        $this->db->where('ride_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'mi', $decimals = 2) {
        // Calculate the distance in degrees
        $degrees = rad2deg(acos((sin(deg2rad($point1_lat)) * sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat)) * cos(deg2rad($point2_lat)) * cos(deg2rad($point1_long - $point2_long)))));

        // Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
        switch ($unit) {
            case 'km':
                $distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
                break;
            case 'mi':
                $distance = ($degrees * 69.05482); // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
                break;
            case 'nmi':
                $distance = $degrees * 59.97662; // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
        }
        return $distance;
    }

   public function getRidesPointsMaxSpeed($id = false) {

        $this->db->select('*')->from('m_ride_points');
        $this->db->where('ride_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results = array();
            $result = $query->result_array();
            if ($result) {

                $max = -9999999; //will hold max val
                $found_item = null; //will hold item with max val;
                $total = 0;
                $speed = 0;
                for ($i = 0; $i < count($result); $i++) {

                    if (isset($result[$i + 1]['latitude']) && isset($result[$i + 1]['longitude'])) {
                        $speed = $this->distanceCalculation($result[$i]['latitude'], $result[$i]['longitude'], $result[$i + 1]['latitude'], $result[$i + 1]['longitude']);
                    }

                    $results['graph_data'][$i] = array('speed' => str_replace('NAN', 0, round($speed / 0.000277778, 2)));
                    if ($results['graph_data'][$i]['speed'] > $max) {
                        $max = $results['graph_data'][$i]['speed'];
                        $found_item = $results['graph_data'][$i]['speed'];
                    }
                    $total = $total + $results['graph_data'][$i]['speed'];
                }
                $results['maxspeed'] = $found_item;
                $results['avgspeed'] = (round($total / count($result), 2));
            }

            return $results;
        } else {

            return false;
        }
    } 
}
