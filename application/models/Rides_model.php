<?php

class Rides_model extends CI_Model {

    public function getRidesPointsDetails($id = false) {

        $this->db->select('*')->from('m_ride_points');
        $this->db->where('ride_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            if ($results) {
                foreach ($results as $key => $value) {

                    $results['polyline'][$key] = array('lat' => $value['latitude'], 'lng' => $value['longitude']);
                }
            }
            return $results;
        } else {

            return false;
        }
    }

    public function getRideById($id=false) {

        $this->db->select('m_rides.*, m_users.first_name,m_users.last_name,m_users.user_profile_pic')->from('m_rides');
        $this->db->join('m_users','m_users.id=m_rides.userID','left');
        $this->db->where('ride_ID', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return false;
        }
    }
     public function getRidePontsByRideId($id=false) {

        $this->db->select('MAX(speed) as maxspeed,AVG(speed) as avgspeed,round(MAX(current),1) as maxcurrent,round(AVG(current),1) as avgcurrent,round(MAX(wh),1) as maxpowes,round(AVG(wh),1) as avgpower')->from('m_ride_points');
        $this->db->where('ride_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return false;
        }
    }

}
