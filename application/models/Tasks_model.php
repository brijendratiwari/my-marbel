<?php

class Tasks_model extends CI_Model {

    public function getTaskCategory($id = false) {

        $this->db->select('cat_name,cat_id')->from('m_task_category');
        $this->db->where('cat_status', 1);
        if ($id != '') {

            $this->db->where('cat_id', $id);
        }
        $this->db->order_by('cat_name', 'Asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            if ($id != '') {

                $nameCategory = $query->row_array();
                return $nameCategory['cat_name'];
            } else {
                return $query->result_array();
            }
        } else {
            return false;
        }
    }

    public function getTaskAssignee() {
        $assignee_type = array(1, 6, 7, 8, 9, 10, 11, 12);
        $this->db->select('m_users.id,m_users.first_name,m_users.last_name,m_users.type,m_users.parent_type,m_users_level.user_role_type')->from('m_users');
        $this->db->join('m_users_level', 'm_users.type=m_users_level.id', 'left');
        $this->db->where_in('m_users.type', $assignee_type);
        $this->db->order_by('m_users_level.user_role_type', 'asc');
        $query = $this->db->get();
        #echo $this->db->last_query(); die;
        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function getTaskRegarding() {
        
        $this->db->select('m_users.id,m_users.first_name,m_users.last_name,m_users.type,m_users.parent_type,m_users_level.user_role_type')->from('m_users');
        $this->db->join('m_users_level', 'm_users.type=m_users_level.id', 'left');
        $this->db->order_by('m_users_level.user_role_type', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {
            return false;
        }
    }
    public function getTasks($id_to = false, $id_by = false, $status = false) {

        $this->db->select('*')->from('m_tasks');
        $this->db->where('task_status', $status);
        if ($id_to) {
            $this->db->where('task_assign_to', $id_to);
        }
        if ($id_by) {
            $this->db->where('task_assign_by', $id_by);
        }
        $this->db->order_by('task_due_date', 'asc');
        $this->db->limit(0, 10);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $task = array();
            $task = $query->result_array();
            $i = 0;
            foreach ($task as $result) {
                $task[$i]['regarding_name'] = $this->getAssigneeNameById($result['task_regarding']);
                $task[$i]['assign_to_name'] = $this->getAssigneeNameById($result['task_assign_to']);
                $task[$i]['assign_by_name'] = $this->getAssigneeNameById($result['task_assign_by']);
                $task[$i]['category_name'] = $this->getTaskCategory($result['task_cat_id']);

                $i++;
            }
//            echo "<pre>";print_r($task); 
            return $task;
        } else {
            return false;
        }
    }

    public function getAssigneeNameById($id) {

        $this->db->select('first_name,last_name')->from('m_users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $nameassignee = $query->row_array();
            return $nameassignee['first_name'] . ' ' . $nameassignee['last_name'];
        }
    }

    public function getTasksById($task_id = false) {
        $this->db->select('*')->from('m_tasks');
        if ($task_id) {

            $this->db->where('task_id', $task_id);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $task = array();
            $task = $query->row_array();
            $task['assign_to_name'] = $this->getAssigneeNameById($task['task_assign_to']);
            $task['assign_by_name'] = $this->getAssigneeNameById($task['task_assign_by']);
            $task['category_name'] = $this->getTaskCategory($task['task_cat_id']);

            #echo "<pre>";print_r($task);  die;
            return $task;
        } else {
            return false;
        }
    }
    public function deleteTasks($id=false){
        
        $this->db->where('task_id',$id);
        $this->db->delete('m_tasks');
        $this->db->where('task_id',$id);
        $this->db->delete('m_calendar');
        if($this->db->affected_rows()){
            
            return true;
            
        }else{
            
            return false;
        }
    }

}
