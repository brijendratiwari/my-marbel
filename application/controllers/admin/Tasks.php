<?php
class Tasks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model', "Users");
        $this->load->model('tasks_model', "Tasks");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
         if($this->session->userdata['marbel_user']['type']!='admin'){
            redirect('logout');
        }
    }
   public function index(){
        $this->data['page']='task';
        $this->data['title']='task';
        $id=$this->session->userdata['marbel_user']['user_id'];
        $this->data['category']=$this->Tasks->getTaskCategory();
        $this->data['assignee']=$this->Tasks->getTaskAssignee();
        $this->data['pending_task_to']=$this->Tasks->getTasks($id,false,'Pending');
        $this->data['completed_task_to']=$this->Tasks->getTasks($id,false,'Completed');
        $this->data['pending_task_by']=$this->Tasks->getTasks(false,$id,'Pending');
        $this->data['completed_task_by']=$this->Tasks->getTasks(false,$id,'Completed');
        $this->load->template('admin/tasks', $this->data);
        
    }
   public function add_task(){
       
       $this->data['page']='add task';
       $this->data['title']='add task';
       if($this->input->post()){
        $this->form_validation->set_rules('cd-taskname','Task Name','trim|required');
        $this->form_validation->set_rules('cd-category','Category','trim|required');
        $this->form_validation->set_rules('cd-assignee','Assignee','trim|required');
        $this->form_validation->set_rules('cd-duedate','Duedate','trim|required');
        $this->form_validation->set_rules('cd-regarding','Regarding','trim|required');
          if ($this->form_validation->run() == FALSE) {
            //validation fails
            $this->form_validation->set_error_delimiters('', '');
            $error = $this->form_validation->error_array();
            $result['result'] = false;
            $result['error'] = $error;
            echo json_encode($result);
            die;
        }else{
               
               $task=array(
                   'task_name'=>$this->input->post('cd-taskname'),
                   'task_cat_id'=>$this->input->post('cd-category'),
                   'task_assign_to'=>$this->input->post('cd-assignee'),
                   'task_assign_by'=>$this->session->userdata['marbel_user']['user_id'],
                   'task_due_date'=>$this->input->post('cd-duedate'),
                   'task_regarding'=>$this->input->post('cd-regarding'),
                   'task_status'=>'Pending',
                  );
               $this->db->insert('m_tasks',$task);
               if($this->db->insert_id()>0){
                   $result['result'] = TRUE;
                    $result['success'] =' Task assigned successfully';
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
   public function edit_task(){
       
   }
}