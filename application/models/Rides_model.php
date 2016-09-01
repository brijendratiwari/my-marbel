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

                $max = -9999999;
                $max_speed = null;
                $max_power = null;
                $max_incline = null;
                $total_speed = 0;
                $total_power = 0;
                $max_incline = 0;
                $distance = 0;
                for ($i = 0; $i < count($result); $i++) {

                    if (isset($result[$i + 1]['latitude']) && isset($result[$i + 1]['longitude'])) {
                        $distance = $this->distanceCalculation($result[$i]['latitude'], $result[$i]['longitude'], $result[$i + 1]['latitude'], $result[$i + 1]['longitude']);
                        $hill_incline = $this->CalculateHillIncline($result[$i]['elevation'], $result[$i + 1]['elevation'], $distance);
                        $energy = $this->CalculateEnergy($result[$i]['board_batt'], $result[$i + 1]['board_batt']);
                    }
                    $power = $this->CalculatePower($result[$i]['voltage'], $result[$i]['current']);
                    $e_scop = $this->CalculateEscop($result[$i]['board_batt'], $distance);
                    $results['polyline'][$i] = array('lat' => $result[$i]['latitude'], 'lng' => $result[$i]['longitude']);
                    $results['graph_data'][$i] = array('speed' => round($result[$i]['location_speed'], 2), 'elevation' => $result[$i]['elevation'], 'time_stamp' => $result[$i]['time_stamp'] * 1000, 'battery' => $result[$i]['board_batt'], 'remote_batt' => $result[$i]['remote_batt'], 'hill_incline' => str_replace('NAN',0,$hill_incline), 'trip_distance' => str_replace('NAN',0,round($distance, 2)) , 'energy' => str_replace('NAN' ,0,$energy), 'power' => str_replace('NAN',0,$power), 'efficiency_score' =>str_replace('NAN',0, $e_scop),'voltage'=>$result[$i]['voltage'],'current'=>$result[$i]['current'],'voltage1'=>$result[$i]['voltage1'],'voltage2'=>$result[$i]['voltage2'],'voltage3'=>$result[$i]['voltage3'],'voltage4'=>$result[$i]['voltage4'],'voltage5'=>$result[$i]['voltage5'],'voltage6'=>$result[$i]['voltage6'],'voltage7'=>$result[$i]['voltage7'],'voltage8'=>$result[$i]['voltage8'],'voltage9'=>$result[$i]['voltage9'],'voltage10'=>$result[$i]['voltage10'],'rpm1'=>$result[$i]['rpm1'],'motor_direction1'=>str_replace('unknown',0,$result[$i]['motor_direction1']),'motor_amps1'=>$result[$i]['motor_amps1'],'motor_volts1'=>$result[$i]['motor_volts1'],'esc1'=>$result[$i]['esc1'],'rpm2'=>$result[$i]['rpm2'],'motor_direction2'=>str_replace('unknown',0,$result[$i]['motor_direction2']),'motor_amps2'=>$result[$i]['motor_amps2'],'motor_volts2'=>$result[$i]['motor_volts2'],'esc2'=>$result[$i]['esc2'],'wh'=>$result[$i]['wh'],'odometer'=>$result[$i]['odometer'],'remoteBLEConnection'=>$result[$i]['remoteBLEConnection'],'internalTemperature'=>$result[$i]['internalTemperature'],'throttle'=>$result[$i]['throttle'],'ble_conn_strength'=>$result[$i]['ble_conn_strength'],'board_state'=>$result[$i]['board_state']);
                    if ($results['graph_data'][$i]['speed'] > $max) {
                        $max = $results['graph_data'][$i]['speed'];
                        $max_speed = $results['graph_data'][$i]['speed'];
                    }
                    if ($results['graph_data'][$i]['power'] > $max) {
                        $max = $results['graph_data'][$i]['power'];
                        $max_power = $results['graph_data'][$i]['power'];
                    }
                    if ($results['graph_data'][$i]['hill_incline'] > $max) {
                        $max = $results['graph_data'][$i]['hill_incline'];
                        $max_incline = $results['graph_data'][$i]['hill_incline'];
                    }
                    $total_speed = $total_speed + $results['graph_data'][$i]['speed'];
                    $total_power = $total_power + $results['graph_data'][$i]['power'];
                }
                $results['maxincline'] = $max_incline;
                $results['maxspeed'] = $max_speed;
                $results['avgspeed'] = (round($total_speed / count($result), 2));
                $results['maxpower'] = $max_power;
                $results['avgpower'] = (round($total_power / count($result), 2));
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

        $this->db->select('round(MAX(current),1) as maxcurrent,round(AVG(current),1) as avgcurrent')->from('m_ride_points');
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


                    $results['graph_data'][$i] = array('speed' => $result[$i]['location_speed']);
                    if ($results['graph_data'][$i]['speed'] > $max) {
                        $max = $results['graph_data'][$i]['speed'];
                        $found_item = $results['graph_data'][$i]['speed'];
                    }
                    $total = $total + $results['graph_data'][$i]['speed'];
                }
                $results['maxspeed'] = round($found_item, 2);
                $results['avgspeed'] = (round($total / count($result), 2));
            }

            return $results;
        } else {

            return false;
        }
    }

    public function CalculateHillIncline($elevation1, $elevation2, $distance) {
        error_reporting(0);
        $hill_incline = 0;
        if ($elevation1 > 0 && $elevation2 > 0) {
            $deffrence_numbers = abs($elevation1 - $elevation2);
            if ($deffrence_numbers > 0) {
                $hill_incline = ($deffrence_numbers / ($distance * 1609.344)/100) * 100;
                 return round($hill_incline);
            }
        }
       
    }

    public function CalculateEnergy($battry, $battry2) {

        $deffrence_numbers = abs($battry - $battry2);
        $energy = 0;
        if ($deffrence_numbers > 0) {
            $energy = ($deffrence_numbers * 181.3);
            $energy = number_format(($energy), 0);
             return $energy;
        }
       
    }

    public function CalculatePower($voltage, $current) {
        $powers = 0;
        $powers = $voltage * $current;
        return $powers;
    }

    public function CalculateEscop($batteryPercentUsed, $distance) {
        $efficiency = 0;
        $efficiency = (($distance / 16) / ($batteryPercentUsed / 100)) * 100;
        return round($efficiency * 100);
    }

}
