<?php

class Services_model extends CI_Model {
    
    function getTotalServiceRecords() {
        
            $this->db->select('COUNT(*)')->from('m_services');
            return $this->db->count_all_results();
            
	}
    function getAdmins(){
        
        $this->db->select('mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.register_date, mu.last_activity, mu.phone, mu.notes, muli.ip')->from('m_users mu');
        $this->db->join('m_user_login_ip muli','muli.user_id = mu.id AND muli.time = mu.last_activity','left');
        $this->db->where('mu.type','1');
        $this->db->order_by('mu.id','ASC');
        $query=$this->db->get();
        if($query->num_rows()>0){
            
            return $query->result_array();
        }
    }
    
    function getService($id=false){
        $this->db->select('s.id, s.order_id, o.user_id, o.order_number, s.status, s.type, s.priority, s.due_date, s.tracking_in, s.tracking_out, s.issue, s.date, s.suggested_response, s.suggested_response_admin_id, s.suggested_response_date, s.diagnostic_response, s.included_parts, s.test_ride_complete, s.test_ride_admin_id, s.test_ride_date, s.final_test_ride_complete, s.final_test_ride_admin_id, s.final_test_ride_date, s.qa_complete, s.qa_admin_id, s.qa_date, s.notes, s.customer_notes')->from('m_services s');
        $this->db->join('m_orders o','o.id = s.order_id','left');
        $this->db->where('s.id',$id);
        $query=$this->db->get();
        if($query->num_rows()>0){
            $service=array();
           $response=$query->row_array();
            
            $service['id']=$response['id'];
            $service['customer']=$this->Customer->getCustomers($response['user_id']);
            $service['order']=$this->Orders->getOrder($response['order_number']);
            $service['order_id']=$response['order_id'];
            $service['user_id']=$response['user_id'];
            $service['order_number']=$response['order_number'];
            $service['status']=$response['status'];
            $service['type']=$response['type'];
            $service['priority']=$response['priority'];
            $service['due_date']=  strtotime($response['due_date']);
            $service['tracking_in']=$response['tracking_in'];
            $service['tracking_out']=$response['tracking_out'];
            $service['issue']=$response['issue'];
            $service['date']=strtotime($response['date']);
            $service['suggested_response']=$response['suggested_response'];
            $service['suggested_response_admin_id']=$this->Customer->getCustomers($response['suggested_response_admin_id']);
            $service['suggested_response_date']=$response['suggested_response_date'];
            $service['diagnostic_response']=$response['diagnostic_response'];
            $service['included_parts']=$response['included_parts'];
            $service['test_ride_complete']=$response['test_ride_complete'];
            $service['test_ride_admin_id']=$this->Customer->getCustomers($response['test_ride_admin_id']);
            $service['test_ride_date']=$response['test_ride_date'];
            $service['final_test_ride_complete']=$response['final_test_ride_complete'];
            $service['final_test_ride_admin_id']=$this->Customer->getCustomers($response['final_test_ride_admin_id']);
            $service['final_test_ride_date']=$response['final_test_ride_date'];
            $service['qa_complete']=$response['qa_complete'];
            $service['qa_admin']=$this->Customer->getCustomers($response['qa_admin_id']);
            $service['qa_date']=$response['qa_date'];
            $service['notes']=$response['notes'];
            $service['customer_notes']=$response['customer_notes'];
            $service['service']=array();
            $getServiceItem=$this->getServiceItem($response['id']);
            if($getServiceItem!=''){
                $service['services']['name']=$getServiceItem['name'];
                $service['services']['quantity']=$getServiceItem['quantity'];
                $service['services']['rate']=$getServiceItem['rate'];
                $service['services']['amount']=$getServiceItem['amount'];
                $service['services']['description']=$getServiceItem['description'];
                $service['services']['discount']=$getServiceItem['discount'];
                $service['services']['date']=strtotime($getServiceItem['date']);
                $service['services']['admin_id']=$getServiceItem['admin_id'];
                $service['services']['admin_name']=$getServiceItem['admin_name'].' '.$adminLastName;
                $service['services']['complete_date']=$getServiceItem['complete_date'];
           
            }
            
            
        }
        return $service;
    }
    
    function getServiceItem($id=false){
        $this->db->select('s.id, s.service_name, s.quantity, s.rate, s.amount, s.description, s.discount, s.date, s.complete, s.admin_id, c.first_name, c.last_name, s.complete_date')->from('m_service_items s');
        $this->db->join('m_users c','c.id = s.admin_id','left');
        $this->db->where('s.service_id',$id);
        $query=$this->db->get();
        #echo $this->db->last_query(); die;
        if($query->num_rows()>0){
            
            return $query->row_array();
        }
        
    }
    function updateNewService($id) {
        
        $tracking_out=$this->input->post('tracking_in');
        $type=$this->input->post('type');
        $status=$this->input->post('status');
        $priority=$this->input->post('priority');
        $due_date=$this->input->post('due_date');
        $issue=$this->input->post('issue');
        $response=$this->input->post('response'); 
        $adminId=$this->input->post('admin_id');
        $this->db->select('id, tracking_out, type, status, priority, due_date, issue, suggested_response, suggested_response_admin_id, suggested_response_date, diagnostic_response, included_parts, test_ride_complete, test_ride_admin_id, test_ride_date, final_test_ride_complete, final_test_ride_admin_id, final_test_ride_date, qa_complete, qa_admin_id, qa_date, notes, customer_notes')->from('m_services');
        $this->db->where('id',$id);
        $query=$this->db->get();
        if($query->num_rows()>0){
            $response=$query->row_array();
            if (strcmp($tracking_out, $response['tracking_out']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the tracking number out from "%s" to "%s"', $response['tracking_out'], $tracking_out)); }
            if (strcmp($type, $response['type']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the type from "%s" to "%s"', $response['type'], $type)); }
            if (strcmp($status, $response['status']) !== 0) { 
                    $this->logServiceUpdate($id, $adminId, sprintf('Updated the status from "%s" to "%s"', $response['status'], $status), $db); 
                    if (strcmp($service, 'inhouse') == 0) {
                        $this->db->where('service_id',$id);
                        $this->db->update('m_services',array('check_in'=>'UNIX_TIMESTAMP(NOW()',));

                    }
            }
            if (strcmp($priority, $response['priority']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the priority from "%s" to "%s"', $response['priority'], $priority)); }
            if (strcmp($due_date, $response['due_date']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the due date from "%s" to "%s"', $response['due_date'], $due_date)); }
            if (strcmp($issue, $response['issue']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the issue from "%s" to "%s"',  $response['issue'], $issue)); }
            
            if($response!='' && ($response['suggested_response_admin_id'] == 0 || $response['suggested_response_admin_id'] == $adminId))
             $adminId=$adminId;
            else
              $adminId= $response['suggested_response_admin_id'];
            
            if($response['response_date']==0)
                $times=time();
            else 
                $times=0;
            $this->db->where('id',$id);
            $this->db->update('m_services',array('tracking_out'=>$tracking_out,'type'=>$type,'status'=>$status,'priority'=>$priority,'due_date'=>$due_date,'issue'=>$issue,'suggested_response'=>$response,'suggested_response_admin_id'=>$adminId,'suggested_response_date'=>$times));
           
           }
		
	}
        
        function logServiceUpdate($id, $userId, $text) {
            
            $insertServices=array('author_id'=>$userId,'service_id'=>$id,'notes'=>$text);
            $this->db->insert('m_service_logs',$insertServices);
	}
        
        function insertService() {
                if($this->input->post()){
                    $insert_services=array(
                        'order_id'=>$this->input->post('order_number'),
                        'tracking_in'=>$this->input->post('order_number'),
                        'type'=>$this->input->post('type'),
                        'status'=>$this->input->post('status'),
                        'priority'=>$this->input->post('priority'),
                        'due_date'=>$this->input->post('due_date'),
                        'issue'=>$this->input->post('issue'),
                        'suggested_response'=>$this->input->post('response'),
                        'suggested_response_admin_id'=>$this->input->post('admin_id'),
                        'due_date'=>'NOW()',
                        
                    );        
                    $this->db->insert('m_services',$insert_services);     
                }
	}

	function deleteService($id) {
                $this->db->where('id',$id);
                $this->db->delete('m_services');
                $this->db->where('service_id',$id);
                $this->db->delete('m_service_items');
		
	}

}
