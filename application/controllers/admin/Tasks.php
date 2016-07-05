<?php

class Tasks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model', "Users");
        $this->load->model('tasks_model', "Tasks");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
        if ($this->session->userdata['marbel_user']['type'] != 'admin') {
            redirect('logout');
        }
    }

    public function index() {
        $this->data['page'] = 'task';
        $this->data['title'] = 'task';
        $id = $this->session->userdata['marbel_user']['user_id'];
        $this->data['category'] = $this->Tasks->getTaskCategory();
        $this->data['assignee'] = $this->Tasks->getTaskAssignee();
        $this->data['pending_task_to'] = $this->Tasks->getTasks($id, false, 'Pending');
        $this->data['completed_task_to'] = $this->Tasks->getTasks($id, false, 'Completed');
        $this->data['pending_task_by'] = $this->Tasks->getTasks(false, $id, 'Pending');
        $this->data['completed_task_by'] = $this->Tasks->getTasks(false, $id, 'Completed');
        $this->load->template('admin/tasks', $this->data);
    }

    public function add_task() {

        $this->data['page'] = 'add task';
        $this->data['title'] = 'add task';
        if ($this->input->post()) {
            $this->form_validation->set_rules('cd-taskname', 'Task Name', 'trim|required');
            $this->form_validation->set_rules('cd-category', 'Category', 'trim|required');
            $this->form_validation->set_rules('cd-assignee', 'Assignee', 'trim|required');
            $this->form_validation->set_rules('cd-duedate', 'Duedate', 'trim|required');
            $this->form_validation->set_rules('cd-regarding', 'Regarding', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                //validation fails
                $this->form_validation->set_error_delimiters('', '');
                $error = $this->form_validation->error_array();
                $result['result'] = false;
                $result['error'] = $error;
                echo json_encode($result);
                die;
            } else {

                $task = array(
                    'task_name' => $this->input->post('cd-taskname'),
                    'task_cat_id' => $this->input->post('cd-category'),
                    'task_assign_to' => $this->input->post('cd-assignee'),
                    'task_assign_by' => $this->session->userdata['marbel_user']['user_id'],
                    'task_due_date' => $this->input->post('cd-duedate'),
                    'task_regarding' => $this->input->post('cd-regarding'),
                    'task_status' => 'Pending',
                );
                $this->db->insert('m_tasks', $task);
                if ($this->db->insert_id() > 0) {
                    $result['result'] = TRUE;
                    $result['success'] = 'Task assigned successfully';
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
    }

    public function edit_task($task_id = false) {
        if ($task_id != '') {

            $this->data['tasks'] = $this->Tasks->getTasksById($task_id);
        }
        echo $this->load->view('admin/load_edit_task', $this->data, True);
    }

    public function update_task($task_id) {

        if ($this->input->post()) {

            $this->db->where('task_id', $task_id);
            $this->db->update('m_tasks', array('task_status' => $this->input->post('cd-status'), 'task_completed_date' => date('Y-m-d')));
            $this->session->set_flashdata('success', 'Task status updated successfully');
            redirect(base_url('tasks'));
        }
    }
    
    public function get_task_assign_to_me(){
        
         $sLimit = "";
        $lenght = 10;
        $str_point = 0;
        $col_sort = array("m_tasks.task_id","m_task_category.cat_name", "m_tasks.task_name", "m_tasks.task_regarding","m_tasks.task_due_date");
        $order_by = "m_tasks.task_id";
        $temp = 'Desc';
        $id_to = $this->session->userdata['marbel_user']['user_id'];
        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $this->Tasks->db->select("m_tasks.task_id,m_task_category.cat_name,m_tasks.task_name,m_tasks.task_regarding,m_tasks.task_due_date");

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Tasks->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $this->Tasks->db->order_by($order_by, $temp);

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $this->db->join('m_task_category','m_task_category.cat_id=m_tasks.task_cat_id','left');
            $this->db->where('task_assign_to', $id_to);
            $this->db->where('task_status', 'Pending');
            $records = $this->Tasks->db->get("m_tasks", $lenght, $str_point);
        } else {
            $this->db->join('m_task_category','m_task_category.cat_id=m_tasks.task_cat_id','left');
            $this->db->where('task_assign_to', $id_to);
            $this->db->where('task_status', 'Pending');
            $records = $this->Tasks->db->get("m_tasks");
        }
        #echo $this->db->last_query(); die;
        $this->db->select('m_tasks.task_id,m_task_category.cat_name,m_tasks.task_name,m_tasks.task_regarding,m_tasks.task_due_date');
        $this->db->from('m_tasks');
        $this->db->join('m_task_category','m_task_category.cat_id=m_tasks.task_cat_id','left');
        $this->db->where('task_status', 'Pending');
        $this->db->where('task_assign_to', $id_to);
         if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Tasks->db->or_like($col_sort[$i], $words, "both");
            }
        }
        $total_record = $this->Tasks->db->count_all_results();

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

            $output['aaData'][] = array("DT_RowId" => $val['task_id'],'<span style="color: #00aeef;"><i class="fa fa-circle"></i></span> '.$val['cat_name'], $val['task_name'], $val['task_regarding'], date('m/d/Y', strtotime($val['task_due_date'])), ' <a class="btn btn-xs btn-success edit-task" href="#" data-id="'. $val['task_id'].'" data-toggle="modal" data-target="#editTaskModal"><i class="fa fa-eye"></i> View</a>');
        }

        echo json_encode($output);
        die;
    }
     public function get_task_assign_by_me(){
        
         $sLimit = "";
        $lenght = 10;
        $str_point = 0;
        $col_sort = array("m_tasks.task_id","m_task_category.cat_name", "m_tasks.task_name", "m_tasks.task_regarding","m_tasks.task_due_date");
        $order_by = "m_tasks.task_id";
        $temp = 'Desc';
        $id_by = $this->session->userdata['marbel_user']['user_id'];
        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $this->Tasks->db->select("m_tasks.task_id,m_task_category.cat_name,m_tasks.task_name,m_tasks.task_regarding,m_tasks.task_due_date,CONCAT_WS(' ', m_users.first_name, m_users.last_name) AS assign_to_name");

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Tasks->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $this->Tasks->db->order_by($order_by, $temp);

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $this->db->join('m_task_category','m_task_category.cat_id=m_tasks.task_cat_id','left');
            $this->db->join('m_users','m_users.id=m_tasks.task_assign_to','left');
            $this->db->where('task_assign_by', $id_by);
            $this->db->where('task_status', 'Pending');
            $records = $this->Tasks->db->get("m_tasks", $lenght, $str_point);
        } else {
            $this->db->join('m_task_category','m_task_category.cat_id=m_tasks.task_cat_id','left');
            $this->db->join('m_users','m_users.id=m_tasks.task_assign_to','left');
            $this->db->where('task_assign_by', $id_by);
            $this->db->where('task_status', 'Pending');
            $records = $this->Tasks->db->get("m_tasks");
        }
        #echo $this->db->last_query(); die;
        $this->db->select("m_tasks.task_id,m_task_category.cat_name,m_tasks.task_name,m_tasks.task_regarding,m_tasks.task_due_date,CONCAT_WS(' ', m_users.first_name, m_users.last_name) AS assign_to_name");
        $this->db->from('m_tasks');
        $this->db->join('m_task_category','m_task_category.cat_id=m_tasks.task_cat_id','left');
          $this->db->join('m_users','m_users.id=m_tasks.task_assign_to','left');
        $this->db->where('task_status', 'Pending');
        $this->db->where('task_assign_by', $id_by);
         if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Tasks->db->or_like($col_sort[$i], $words, "both");
            }
        }
        $total_record = $this->Tasks->db->count_all_results();

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

            $output['aaData'][] = array("DT_RowId" => $val['task_id'],'<span style="color: #00aeef;"><i class="fa fa-circle"></i></span> '.$val['cat_name'], $val['task_name'], $val['task_regarding'], date('m/d/Y', strtotime($val['task_due_date'])), $val['assign_to_name']);
        }

        echo json_encode($output);
        die;
    }
    
     public function get_task_completed_to_me(){
        
          $sLimit = "";
        $lenght = 10;
        $str_point = 0;
        $col_sort = array("m_tasks.task_id","m_task_category.cat_name", "m_tasks.task_name", "m_tasks.task_regarding","m_tasks.task_due_date");
        $order_by = "m_tasks.task_id";
        $temp = 'Desc';
        $id_to = $this->session->userdata['marbel_user']['user_id'];
        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $this->Tasks->db->select("m_tasks.task_id,m_task_category.cat_name,m_tasks.task_name,m_tasks.task_regarding,m_tasks.task_due_date");

        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Tasks->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $this->Tasks->db->order_by($order_by, $temp);

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $this->db->join('m_task_category','m_task_category.cat_id=m_tasks.task_cat_id','left');
            $this->db->where('task_assign_to', $id_to);
            $this->db->where('task_status', 'Completed');
            $records = $this->Tasks->db->get("m_tasks", $lenght, $str_point);
        } else {
            $this->db->join('m_task_category','m_task_category.cat_id=m_tasks.task_cat_id','left');
            $this->db->where('task_assign_to', $id_to);
            $this->db->where('task_status', 'Completed');
            $records = $this->Tasks->db->get("m_tasks");
        }
        #echo $this->db->last_query(); die;
        $this->db->select('m_tasks.task_id,m_task_category.cat_name,m_tasks.task_name,m_tasks.task_regarding,m_tasks.task_due_date');
        $this->db->from('m_tasks');
        $this->db->join('m_task_category','m_task_category.cat_id=m_tasks.task_cat_id','left');
        $this->db->where('task_status', 'Completed');
        $this->db->where('task_assign_to', $id_to);
         if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->Tasks->db->or_like($col_sort[$i], $words, "both");
            }
        }
        $total_record = $this->Tasks->db->count_all_results();

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

            $output['aaData'][] = array("DT_RowId" => $val['task_id'],'<span><i class="fa fa-check"></i></span> '.$val['cat_name'], $val['task_name'], $val['task_regarding'], date('m/d/Y', strtotime($val['task_due_date'])));
        }

        echo json_encode($output);
        die;
    }
}