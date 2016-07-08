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
        $service=array();
        $this->db->select('s.id, s.order_id, o.user_id, o.order_number, s.status, s.type, s.priority, s.due_date, s.tracking_in, s.tracking_out, s.issue, s.date, s.suggested_response, s.suggested_response_admin_id, s.suggested_response_date, s.diagnostic_response, s.included_parts, s.test_ride_complete, s.test_ride_admin_id, s.test_ride_date, s.final_test_ride_complete, s.final_test_ride_admin_id, s.final_test_ride_date, s.qa_complete, s.qa_admin_id, s.qa_date, s.notes, s.customer_notes')->from('m_services s');
        $this->db->join('m_orders o','o.id = s.order_id','left');
        $this->db->where('s.id',$id);
        $query=$this->db->get();
        if($query->num_rows()>0){
            $service=array();
           $response=$query->row_array();
            $included_pts = array();
            foreach (explode(',', $response['included_parts']) as $part) {
                $included_pts[] = $part; 

            } 
            $service['id']=$response['id'];
            $service['customer']=$this->Customer->getCustomers($response['user_id']);
            $service['order']=$this->Services->getOrderByNumber($response['order_number']);
            $service['order_id']=$response['order_id'];
            $service['status']=$response['status'];
            $service['type']=$response['type'];
            $service['priority']=$response['priority'];
            $service['due_date']=  strtotime($response['due_date']);
            $service['tracking_in']=$response['tracking_in'];
            $service['tracking_out']=$response['tracking_out'];
            $service['issue']=$response['issue'];
            $service['date']=strtotime($response['date']);
            $service['suggested_response']=$response['suggested_response'];
            $service['suggested_response_admin']=$this->Customer->getCustomers($response['suggested_response_admin_id']);
            $service['suggested_response_date']=$response['suggested_response_date'];
            $service['diagnostic_response']=$response['diagnostic_response'];
            $service['included_parts']=$included_pts;
            $service['test_ride_complete']=$response['test_ride_complete'];
            $service['test_ride_admin_id']=$this->Customer->getCustomers($response['test_ride_admin_id']);
            $service['test_ride_date']=$response['test_ride_date'];
            $service['final_test_ride_complete']=$response['final_test_ride_complete'];
            $service['final_test_ride_admin']=$this->Customer->getCustomers($response['final_test_ride_admin_id']);
            $service['final_test_ride_date']=$response['final_test_ride_date'];
            $service['qa_complete']=$response['qa_complete'];
            $service['qa_admin']=$this->Customer->getCustomers($response['qa_admin_id']);
            $service['qa_date']=$response['qa_date'];
            $service['notes']=$response['notes'];
            $service['customer_notes']=$response['customer_notes'];
            $service['services']=array();
            $getServiceItems=$this->getServiceItem($response['id']);
            if($getServiceItems!=''){
                $i=0;
                foreach($getServiceItems as $getServiceItem){
                    $service['services'][$i]['name']=$getServiceItem['service_name'];
                    $service['services'][$i]['quantity']=$getServiceItem['quantity'];
                    $service['services'][$i]['rate']=$getServiceItem['rate'];
                    $service['services'][$i]['amount']=$getServiceItem['amount'];
                    $service['services'][$i]['description']=$getServiceItem['description'];
                    $service['services'][$i]['discount']=$getServiceItem['discount'];
                    $service['services'][$i]['date']=strtotime($getServiceItem['date']);
                    $service['services'][$i]['complete']=strtotime($getServiceItem['complete']);
                    $service['services'][$i]['admin_id']=$getServiceItem['admin_id'];
                    $service['services'][$i]['admin_name']=$getServiceItem['first_name'].' '.$getServiceItem['last_name'];
                    $service['services'][$i]['complete_date']=$getServiceItem['complete_date'];
               $i++;
                    }
           
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
            
            return $query->result_array();
        }
        
    }
    function updateNewService($id) {
        
        $tracking_out=$this->input->post('tracking_in');
        $type=$this->input->post('type');
        $status=$this->input->post('status');
        $priority=$this->input->post('priority');
        $due_date=$this->input->post('due_date');
        $issue=$this->input->post('issue');
        $responses=$this->input->post('response'); 
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
            
            if($response['suggested_response_date']==0)
                $times=time();
            else 
                $times=0;
            $this->db->where('id',$id);
            $this->db->update('m_services',array('tracking_out'=>$tracking_out,'type'=>$type,'status'=>$status,'priority'=>$priority,'due_date'=>$due_date,'issue'=>$issue,'suggested_response'=>$responses,'suggested_response_admin_id'=>$adminId,'suggested_response_date'=>$times));
           
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
        
        function getOrders($user_id) {	        
	$orders_info=array();
        $this->db->select('id, order_number, delivery_address, delivery_address_2, city, state, zip, country, order_total, order_status, invoice_url, order_date, est_ship_date, est_ship_location, product, wheel_color, wheel_size, firmware_version, deck_serial_number, main_serial_number, tracking_number, notes, priority')->from('m_orders');
        $this->db->where('user_id',$user_id);
        $this->db->order_by('id','Desc');
        $query=$this->db->get();
        if($query->num_rows()>0){
            $orders=$query->result_array();
          
            foreach($orders as $key=>$order){
            if ($order['order_status'] == 'deposit') {
                    $order['order_friendly_status'] = 'Deposit Paid';
                } else if ($order['order_status'] == 'balance') {
                        $order['order_friendly_status'] = 'Fully Paid';
                } else if ($order['order_status'] == 'refunded') {
                        $order['order_friendly_status'] = 'Refunded';
                } else if ($order['order_status'] == 'building') {
                        $order['order_friendly_status'] = 'Building';
                } else if ($order['order_status'] == 'qa') {
                        $order['order_friendly_status'] = 'Quality Assurance';
                } else if ($order['order_status'] == 'shipping') {
                        $order['order_friendly_status'] = 'Shipping';
                }  else if ($order['order_status'] == 'shipped') {
                        $order['order_friendly_status'] = 'Shipped';
                } else if ($order['order_status'] == 'hold') {
                        $order['order_friendly_status'] = 'On Hold';
                } 
                $estShipping = $order['est_ship_date'];
                $estShippingLocation = $order['est_ship_location'];
                if (intval(date('his', $estShipping)) == 120000 && intval(date('j', $estShipping)) == 1) { $estShipping = 'in '.date('M, Y', $estShipping); }
			else { $estShipping =  'by '.date('M j, Y', $estShipping); };
			if ($estShippingLocation!='') {
				$estShipping .= ' via '.$estShippingLocation;
			}
			$order['friendly_est_ship_date'] = $estShipping;
                        
                  $orders_info[]= $order;  
            }
            
             return $orders_info;
        }
	
}   
        function getOneOrder($user_id,$order_id) {	        
	$orders_info=array();
        $this->db->select('id, order_number, delivery_address, delivery_address_2, city, state, zip, country, order_total, order_status, invoice_url, order_date, est_ship_date, est_ship_location, product, wheel_color, wheel_size, firmware_version, deck_serial_number, main_serial_number, tracking_number, notes, priority')->from('m_orders');
        $this->db->where('user_id',$user_id);
        $this->db->where('id',$order_id);
        $query=$this->db->get();
        if($query->num_rows()>0){
            $orders=$query->result_array();
          
            foreach($orders as $key=>$order){
            if ($order['order_status'] == 'deposit') {
                    $order['order_friendly_status'] = 'Deposit Paid';
                } else if ($order['order_status'] == 'balance') {
                        $order['order_friendly_status'] = 'Fully Paid';
                } else if ($order['order_status'] == 'refunded') {
                        $order['order_friendly_status'] = 'Refunded';
                } else if ($order['order_status'] == 'building') {
                        $order['order_friendly_status'] = 'Building';
                } else if ($order['order_status'] == 'qa') {
                        $order['order_friendly_status'] = 'Quality Assurance';
                } else if ($order['order_status'] == 'shipping') {
                        $order['order_friendly_status'] = 'Shipping';
                }  else if ($order['order_status'] == 'shipped') {
                        $order['order_friendly_status'] = 'Shipped';
                } else if ($order['order_status'] == 'hold') {
                        $order['order_friendly_status'] = 'On Hold';
                } 
                $estShipping = $order['est_ship_date'];
                $estShippingLocation = $order['est_ship_location'];
                if (intval(date('his', $estShipping)) == 120000 && intval(date('j', $estShipping)) == 1) { $estShipping = 'in '.date('M, Y', $estShipping); }
			else { $estShipping =  'by '.date('M j, Y', $estShipping); };
			if ($estShippingLocation!='') {
				$estShipping .= ' via '.$estShippingLocation;
			}
			$order['friendly_est_ship_date'] = $estShipping;
                        
                  $orders_info[]= $order;  
            }
            
             return $orders_info;
        }
	
}   


function getOrderByNumber($order_number) {	        
	$order = array();
        $this->db->select('user_id, order_number, delivery_address, delivery_address_2, city, state, zip, country, order_total, order_status, invoice_url, order_date, est_ship_date, est_ship_location, product, wheel_color, wheel_size, firmware_version, deck_serial_number, main_serial_number, tracking_number, shipping_cost, notes, priority')->from('m_orders');
        $this->db->where('order_number',$order_number);
        $query=$this->db->get();
        if($query->num_rows()>0){
            
            $order=$query->row_array();
            if ($order['order_status'] == 'deposit') {
				$order['order_friendly_status'] = 'Deposit Paid';
			} else if ($order['order_status'] == 'balance') {
				$order['order_friendly_status'] = 'Fully Paid';
			} else if ($order['order_status'] == 'refunded') {
				$order['order_friendly_status'] = 'Refunded';
			} else if ($order['order_status'] == 'building') {
				$order['order_friendly_status'] = 'Building';
			} else if ($order['order_status'] == 'qa') {
				$order['order_friendly_status'] = 'Quality Assurance';
			} else if ($order['order_status'] == 'shipping') {
				$order['order_friendly_status'] = 'Shipping';
			} else if ($order['order_status'] == 'shipped') {
				$order['order_friendly_status'] = 'Shipped';
			} else if ($order['order_status'] == 'hold') {
				$order['order_friendly_status'] = 'On Hold';
			} 
        }
	return $order;
    }
    
    function getRecentServiceLog($orderId) {
           $orderLog = array();
            $this->db->select('mu.id, mu.first_name, mu.last_name, mol.notes, mol.date')->from('m_service_logs mol');
            $this->db->join('m_users mu','mu.id = mol.author_id','left');
            $this->db->where('mol.service_id',$orderId);
            $this->db->order_by('mol.date','Desc');
            $query=$this->db->get();
            if($query->num_rows()>0){
                
                $orders=$query->result_array();
                $i=0;
                foreach($orders as $order){
                  $orderLog[$i]['user_id']= $order['id'];
                  $orderLog[$i]['name']= $order['first_name'].' '.$order['last_name'];
                  $orderLog[$i]['notes']= $order['notes'];
                  $orderLog[$i]['date']= date("F j, Y, g:i a", strtotime($order['date']));
                $i++;    
                }
            }
		
		return $orderLog;
	}
        
     function updateService($id) {
		
         $id = $this->input->post('cd-service_id');
	$tracking_out = $this->input->post('cd-tracking-out');
	$type = $this->input->post('cd-type');
	$status = $this->input->post('cd-status');
	$priority = $this->input->post('cd-priority');
	$due_date = $this->input->post('cd-due');
	$issue = $this->input->post('cd-issue');
	$responses = $this->input->post('cd-response');
        $userdata=$this->session->userdata('marbel_user');
	$adminId = $userdata['user_id'];
	$diagnostic_response = $this->input->post('cd-diagnostic_response');
	$included_parts = '';
        $included_part=$this->input->post('included_parts');
         if (is_array($included_part)) {
            foreach ($included_part as $v) {
                    if ($included_parts!='') {$included_parts.=',';}
                    $included_parts.=$v;
            }
         }
	$test_ride_complete = ($this->input->post('test_ride')!='') ? 1 : 0;
	$final_test_ride_complete = ($this->input->post('final_test_ride')!='') ? 1 : 0;
	$qa_complete = ($this->input->post('qa_complete')!='') ? 1 : 0;
	$notes = $this->input->post('cd-notes');
	$customer_notes = $this->input->post('cd-customer_notes');
	$service_length = intval($this->input->post('service_item_count'));
	$services = array();
	for ($i = 0; $i < $service_length; $i++) {
		$services[] = array(
			'name' => $this->input->post('service_name_'.$i),
			'quantity' => $this->input->post('service_qty_'.$i),
			'rate' => $this->input->post('service_rate_'.$i),
			'amount' => $this->input->post('service_amt_'.$i),
			'description' => $this->input->post('service_description_'.$i),
			'discount' => $this->input->post('service_discount_'.$i),
			'complete' => (($this->input->post('service_finish_'.$i)!='') ? 1 : 0)
		);
	}
        $this->db->select('id, tracking_out, type, status, priority, due_date, issue, suggested_response, suggested_response_admin_id, suggested_response_date, diagnostic_response, included_parts, test_ride_complete, test_ride_admin_id, test_ride_date, final_test_ride_complete, final_test_ride_admin_id, final_test_ride_date, qa_complete, qa_admin_id, qa_date, notes, customer_notes')->from('m_services');
       $this->db->where('id',$id);
       $query=$this->db->get();
       if($query->num_rows()>0){
           $response=$query->row_array();
//           var_dump($response);die;
//           var_dump($responses);die;
           if (strcmp($tracking_out, $response['tracking_out']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the tracking number out from "%s" to "%s"', $response['tracking_out'], $tracking_out)); }
				if (strcmp($type, $response['type']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the type from "%s" to "%s"', $response['type'], $type)); }
				if (strcmp($status, $response['status']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the status from "%s" to "%s"', $response['status'], $status)); }
				if (strcmp($priority, $response['priority']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the priority from "%s" to "%s"', $response['priority'], $priority)); }
				if (strcmp($due_date, $response['due_date']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the due date from "%s" to "%s"', $response['due_date'], $due_date)); }
				if (strcmp($issue, $response['issue']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the issue from "%s" to "%s"', $response['issue'], $issue)); }
				if (strcmp($diagnostic_response, $response['diagnostic_response']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the diagnostic response from "%s" to "%s"', $response['diagnostic_response'], $diagnostic_response)); }
				if (strcmp($responses, $response['suggested_response']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the response from "%s" to "%s"', $response['suggested_response'], $responses)); }
				if (strcmp($included_parts, $response['included_parts']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the included parts from "%s" to "%s"', $response['included_parts'], $included_parts)); }
				if ($test_ride_complete != $response['test_ride_complete']) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the test ride complete from "%s" to "%s"', $response['test_ride_complete'] == 1, $test_ride_complete == 1)); }
				if ($final_test_ride_complete != $response['final_test_ride_complete']) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the final test ride complete from "%s" to "%s"', $response['final_test_ride_complete'] == 1, $final_test_ride_complete == 1)); }
				if (strcmp($notes, $response['notes']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the notes from "%s" to "%s"', $response['notes'], $notes)); }
				if (strcmp($customer_notes, $response['customer_notes']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the customer notes from "%s" to "%s"', $response['customer_notes'], $customer_notes)); }
				if ($qa_complete != $response['qa_complete']) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the quality assurance from "%s" to "%s"', $response['qa_complete'] == 1, $qa_complete == 1)); }
      
                        $this->db->select('id, service_name, quantity, rate, amount, description, discount, date, complete, admin_id')->from('m_service_items');
                        $this->db->where('id',$id);
                        $query2=$this->db->get();
                        if($query2->num_rows()>0){
                            $response2=$query2->row_array();
                            foreach ($services as $service) {
						$found = false;

                                                if (strcmp($service['name'], $response2['service_name']) == 0) {
                                                        $found = true;
                                                        if (strcmp($response2['quantity'], $service['quantity']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the service quantity for %s from "%s" to "%s"', $response2['service_name'], $response2['service_name'], $service['quantity'])); }
                                                        if (strcmp($response2['rate'], $service['rate']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the service rate for %s from "%s" to "%s"', $response2['service_name'], $response2['rate'], $service['rate'])); }
                                                        if (strcmp($response2['amount'], $service['amount']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the service amount for %s from "%s" to "%s"', $response2['service_name'], $$response2['amount'], $service['amount'])); }
                                                        if (strcmp($response2['description'], $service['description']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the service description for %s from "%s" to "%s"', $response2['service_name'], $response2['description'], $service['description'])); }
                                                        if (strcmp($response2['discount'], $service['discount']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the service discount for %s from "%s" to "%s"', $response2['service_name'], $response2['discount'], $service['discount'])); }
                                                        if (strcmp($response2['complete'], $service['complete']) !== 0) { $this->logServiceUpdate($id, $adminId, sprintf('Updated the service complete for %s from "%s" to "%s"', $response2['service_name'], $response2['complete'], $service['complete'])); }
                                                        $adminId=($service['complete'] == 1 && $service['complete'] != $response2['complete'] ? $adminId : 0);
                                                        $time=($service['complete'] == 1 && $service['complete'] != $response2['complete'] ? time() : 0);
                                                        $this->db->where('id',$id);
                                                        $this->db->update('m_service_items',array('quantity'=>$service['quantity'],'rate'=>$service['rate'],'amount'=>$service['amount'],'description'=>$service['description'],'discount'=>$service['discount'],'complete'=>$service['complete'],'admin_id'=>$adminId,'complete_date'=>$time));
                                                      
                                                }
							
						
						if (!$found) {
                                                    $time=($service['complete'] == 1 ? time() : 0);
                                                    $adminId=($service['complete'] == 1 ?$adminId : 0);
                                                    $this->db->insert('m_service_items',array('service_id'=>$id,'quantity'=>$service['quantity'],'rate'=>$service['rate'],'amount'=>$service['amount'],'service_name'=>$service['name'],'description'=>$service['description'],'discount'=>$service['discount'],'complete'=>$service['complete'],'admin_id'=>$adminId,'complete_date'=>$time));
                                                 
						}
					}
                            
                        }
                        $adminIds=($response!='' && ($response['suggested_response_admin_id'] == 0 || $response['suggested_response_admin_id'] == $adminId)) ? $adminId : $response['suggested_response_admin_id']; 
                        $times=($response['suggested_response_date'] == 0 )? time() : 0;
                        $adminIds2=($test_ride_complete == 1 && ($response['test_ride_admin_id'] == 0 || $response['test_ride_admin_id'] == $adminId)) ? $adminId : $response['test_ride_admin_id'];
                        $times2=($response['test_ride_admin_id'] == 0 && $response['test_ride_date'] == 0) ?time() : 0;
                        $adminIds3=($final_test_ride_complete == 1 && ($response['final_test_ride_admin_id'] == 0 || $response['final_test_ride_admin_id'] == $adminId)) ? $adminId :$response['final_test_ride_admin_id'];
                        $times3=($response['final_test_ride_date'] == 0 && $response['final_test_ride_admin_id'] == 0 )?  time() : 0;
                        $adminIds4=($qa_complete == 1 && ($response['qa_admin_id'] == 0 || $response['qa_admin_id'] == $adminId)) ?  $adminId : $response['qa_admin_id'];
                        $times4=($response['qa_date'] == 0) ? time() : 0;
                        $this->db->where('id',$id);
                        $this->db->update('m_services',array('tracking_out'=>$tracking_out,'type'=>$type,'status'=>$status,'priority'=>$priority,'due_date'=>$due_date,'issue'=>$issue,'suggested_response'=>$responses,'suggested_response_admin_id'=>$adminIds,'suggested_response_date'=>$times,'diagnostic_response'=>$diagnostic_response,'included_parts'=>$included_parts,'test_ride_complete'=>$test_ride_complete,'test_ride_admin_id'=>$adminIds2,'test_ride_date'=>$times2,'final_test_ride_complete'=>$final_test_ride_complete,'final_test_ride_admin_id'=>$adminIds3,'final_test_ride_date'=>$times3,'qa_complete'=>$qa_complete,'qa_admin_id'=>$adminIds4,'qa_date'=>$times4,'notes'=>$notes,'customer_notes'=>$customer_notes));
                        
              }
         
	}
        /* get countries from json file */

    function getCountries() {
        $jsonStr = file_get_contents(base_url() . "/assets/countries.json");
        return json_decode($jsonStr, true);
    }
   
}
