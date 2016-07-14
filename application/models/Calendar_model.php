<?php

class Calendar_model extends CI_Model {

    function calendar_process() {
        $table = 'm_calendar';
        $type = $this->input->post('type');

        if ($this->input->post('cal_type')) {

            $cal_type = $this->input->post('cal_type');
        }

        if ($type == 'new') {
            $startdate = $this->input->post('startdate') . '+' . $this->input->post('zone');
            $title = $this->input->post('title');
            $new = array('title' => $title, 'startdate' => $startdate, 'enddate' => $startdate, 'allDay' => 'false');
            $this->db->insert($table, $new);

            $lastid = $this->db->insert_id();
            echo json_encode(array('status' => 'success', 'eventid' => $lastid));
        }

        if ($type == 'changetitle') {
            $eventid = $this->input->post('eventid');
            $title = $this->input->post('title');
            $changetitle = array('title' => $title);
            $this->db->where('id', $eventid);
            $this->db->update($table, $changetitle);
            $afftectedRows = $this->db->affected_rows();
            if ($afftectedRows)
                echo json_encode(array('status' => 'success'));
            else
                echo json_encode(array('status' => 'failed'));
        }

        if ($type == 'resetdate') {
            $title = $this->input->post('title');
            $startdate = $this->input->post('start');
            $enddate = $this->input->post('end');
            $eventid = $this->input->post('eventid');
            $resetdate = array('title' => $title, 'startdate' => $startdate, 'enddate' => $enddate);
            $this->db->where('id', $eventid);
            $this->db->update($table, $resetdate);
            $afftectedRows = $this->db->affected_rows();
            if ($afftectedRows)
                echo json_encode(array('status' => 'success'));
            else
                echo json_encode(array('status' => 'failed'));
        }

        if ($type == 'remove') {
            $eventid = $this->input->post('eventid');
            $this->db->where('id', $eventid);
            $this->db->delete($table);
            $afftectedRows = $this->db->affected_rows();
            if ($afftectedRows)
                echo json_encode(array('status' => 'success'));
            else
                echo json_encode(array('status' => 'failed'));
        }

        if ($type == 'fetch') {
            $events = array();
            $this->db->select('mc.id,mc.title,mc.event_created_by,mc.event_created_to,mc.event_type,mc.startdate,mc.enddate,mc.allDay,mc.task_id,mcet.id as event_type_id,mcet.name as event_type,mcet.color_code')->from('m_calendar as mc')->join('m_cal_event_type as mcet', 'mcet.id=mc.event_type');
            if ($cal_type == 'personal') {
                //$this->db->where('mc.event_type', 1);
                $this->db->where('mc.event_created_by', $this->session->userdata['marbel_user']['user_id']);
                $this->db->or_where('mc.event_type', 2);
//               $this->db->where('mc.task_id !=', 0);
            }
            if ($cal_type == 'forall') {
                $this->db->where('mc.event_type !=', 1);
                $this->db->where('mc.task_id', 0);
            }
            $query = $this->db->get();
//            echo $this->db->last_query();die;
            if ($query->num_rows() > 0) {
                $getRecord = $query->result_array();
                $i = 0;
                $get_final = array();
                foreach ($getRecord as $record) {
                    $get_final[$i]['id'] = $record['id'];
                    $get_final[$i]['title'] = $record['title'];
                    $get_final[$i]['event_created_by'] = $record['event_created_by'];
                    $get_final[$i]['event_created_to'] = $record['event_created_to'];
                    $get_final[$i]['event_type'] = $record['event_type'];
                    $get_final[$i]['task_id'] = $record['task_id'];
                    $get_final[$i]['start'] = $record['startdate'];
                    $get_final[$i]['end'] = $record['enddate'];
                    $get_final[$i]['color_code'] = $record['color_code'];
                    $get_final[$i]['event_type_id'] = $record['event_type_id'];
                    $get_final[$i]['allDay'] = ($record['allDay'] == "true") ? true : false;
                    $i++;
                }
                echo json_encode($get_final);
            } else {

                echo json_encode(array('status' => 'failed'));
            }
        }
    }

    public function getAllEvents($month, $year) {
        $table = 'm_calendar';
        $this->db->select('*')->from($table)->where('MONTH(startdate)', $month)->where('YEAR(startdate)', $year);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $getRecord = $query->result_array();
            return $getRecord;
        } else {

            return FALSE;
        }
    }

    public function getEventById($event_id) {
        $table = 'm_calendar';
        $this->db->select('m_calendar.*,m_users.first_name,m_users.last_name,m_users.id as user_id,m_users.user_profile_pic')->from('m_calendar')->where('m_calendar.id', $event_id)->join('m_users','m_users.id = m_calendar.event_created_by','LEFT');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $getRecord = $query->row();
            return $getRecord;
        } else {

            return FALSE;
        }
    }

    public function getEventTypes() {

        $query = $this->db->where('active', 1)->get('m_cal_event_type');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

}
