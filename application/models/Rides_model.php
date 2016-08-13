<?php
class Rides_model extends CI_Model {

    public function getRidesPointsDetails($id = false) {

        $this->db->select('*')->from('m_ride_points');
        $this->db->where('ride_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            if ($result) {
                foreach ($result as $key => $value) {

                    $results['polyline'][$key] = array('lat' => $value['latitude'], 'lng' => $value['longitude']);
                    $results['graph_data'][$key]=array('speed'=>$value['speed'],'elevation'=>$value['elevation'],'time_stamp'=>$value['time_stamp']*1000,'power'=>$value['board_batt']);
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

        $this->db->select('round(MAX(speed),1) as maxspeed,round(AVG(speed),1) as avgspeed,round(MAX(current),1) as maxcurrent,round(AVG(current),1) as avgcurrent,round(MAX(wh),1) as maxpowes,round(AVG(wh),1) as avgpower, MAX(elevation) as max_elevation')->from('m_ride_points');
        $this->db->where('ride_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return false;
        }
    }

}
