<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Calendar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model', "Users");
        $this->load->model('Calendar_model', "Calendar");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
        if ($this->session->userdata['marbel_user']['type'] != 'admin') {
            redirect('logout');
        }
    }

    public function index() {
        $this->data['page'] = 'Calender';
        $this->data['title'] = 'Calender';

        $this->load->template('admin/calender', $this->data);
    }

    public function process() {

        if ($this->input->post()) {

            $this->Calendar->calendar_process();
        }
    }

    public function getEvents($date = FALSE) {

        if ($date == FALSE) {

            $month = date('m');
            $year = date('Y');
        } else {

            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
            $month = $month + 1;
        }

        $this->data['events'] = $this->Calendar->getAllEvents($month, $year);

        $this->load->view('admin/events', $this->data);
    }

    public function getSingleEvent($event_id = FALSE) {

        if ($event_id != '') {

            $this->data['event'] = $this->Calendar->getEventById($event_id);

            $this->load->view('admin/update_event', $this->data);
        }
    }

    public function add_event() {

        $this->form_validation->set_rules('cd-title', 'Event Name', 'trim|required');
        $this->form_validation->set_rules('cd-location', 'Location', 'trim|required');
        $this->form_validation->set_rules('cd-date-start', 'Date Time', 'trim|required');
        $this->form_validation->set_rules('cd-date-end', 'Date Time', 'trim|required');
        $this->form_validation->set_rules('cd-description', 'Description', 'trim|required');

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
            $end_date_time = '';
            $start_date_time = '';
            $timezone = "+05:30";
            if ($this->input->post('cd-date-start')) {
                $startDate = explode(' ', $this->input->post('cd-date-start'));
                $start_date = date('Y-m-d', strtotime($startDate[0]));
                $start_time = date('H:i:s', strtotime($startDate[1] . ' ' . $startDate[2]));
                $start_date_time = $start_date . 'T' . $start_time . $timezone;
            }
            if ($this->input->post('cd-date-end')) {
                $endDate = explode(' ', $this->input->post('cd-date-end'));
                $end_date = date('Y-m-d', strtotime($endDate[0]));
                $end_time = date('H:i:s', strtotime($endDate[1] . ' ' . $endDate[2]));
                $end_date_time = $end_date . 'T' . $end_time . $timezone;
            }

            $data_insert = array(
                'title' => $this->input->post('cd-title'),
                'description' => $this->input->post('cd-description'),
                'location' => $this->input->post('cd-location'),
                'startdate' => $start_date_time,
                'enddate' => $end_date_time,
                'allDay' => 'false'
            );
            $this->db->insert('m_calendar', $data_insert);
            $id = $this->db->insert_id();
            if ($id != '') {

                $result['result'] = TRUE;
                $result['success'] = 'Evnet created successfully';
                echo json_encode($result);
                die;
            } else {

                $result['result'] = FALSE;
                $result['success'] = 'Unknown Error';
                echo json_encode($result);
                die;
            }
        }
    }

    public function update_event() {

        $this->form_validation->set_rules('cd-title', 'Event Name', 'trim|required');
        $this->form_validation->set_rules('cd-location', 'Location', 'trim|required');
        $this->form_validation->set_rules('cd-date-start', 'Date Time', 'trim|required');
        $this->form_validation->set_rules('cd-date-end', 'Date Time', 'trim|required');
        $this->form_validation->set_rules('cd-description', 'Description', 'trim|required');
        $this->form_validation->set_rules('event_id', 'Event Id', 'trim|required');

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
            $end_date_time = '';
            $start_date_time = '';
            $timezone = "+05:30";
            if ($this->input->post('cd-date-start')) {
                $startDate = explode(' ', $this->input->post('cd-date-start'));
                $start_date = date('Y-m-d', strtotime($startDate[0]));
                $start_time = date('H:i:s', strtotime($startDate[1] . ' ' . $startDate[2]));
                $start_date_time = $start_date . 'T' . $start_time . $timezone;
            }
            if ($this->input->post('cd-date-end')) {
                $endDate = explode(' ', $this->input->post('cd-date-end'));
                $end_date = date('Y-m-d', strtotime($endDate[0]));
                $end_time = date('H:i:s', strtotime($endDate[1] . ' ' . $endDate[2]));
                $end_date_time = $end_date . 'T' . $end_time . $timezone;
            }

            $data_update = array(
                'title' => $this->input->post('cd-title'),
                'description' => $this->input->post('cd-description'),
                'location' => $this->input->post('cd-location'),
                'startdate' => $start_date_time,
                'enddate' => $end_date_time,
                'allDay' => 'false'
            );
            $id = $this->input->post('event_id');
            $this->db->where('id', $id);
            $this->db->update('m_calendar', $data_update);

            if ($this->db->affected_rows() > 0) {

                $result['result'] = TRUE;
                $result['success'] = 'Evnet updated successfully';
                echo json_encode($result);
                die;
            } else {

                $result['result'] = FALSE;
                $result['success'] = 'Unknown Error';
                echo json_encode($result);
                die;
            }
        }
    }

    public function event_delete($id = false) {
        if ($id != '') {
            $this->db->where('id', $id);
            $this->db->delete('m_calendar');
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('success', 'Event deleted successfully');
                redirect('calendar');
            } else {
                $this->session->set_flashdata('error', 'Some thing went wrong! Please try again.');
                redirect('calendar');
            }
        } else {

            $this->session->set_flashdata('error', 'Some thing went wrong! Please try again.');
                redirect('calendar');
        }
    }

}
