<?php
class Users_model extends CI_Model {

    public $table = "m_users";
    function login($email='', $password='') {
                $this->db->select('mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.register_date, mu.last_activity, mu.phone, mua.password, mua.salt')->from('m_users mu');
                $this->db->join('m_user_auth mua','mua.user_id = mu.id');
                $this->db->where('mu.email',$email);
                $this->db->limit('1');
                $getInfo=$this->db->get();
                if($getInfo->num_rows()>0){
                    $result=$getInfo->row();
                    $sait=$result->salt;
                    $user_id=$result->id;
                    $db_password=$result->password;
                    $type=$result->type;
                    $ip_address = $this->getClientIP(); 
                    $password = hash('sha512', $password.$sait); 
                    $time = time();
                    $checkbrute=$this->checkbrute($user_id);
                    if($checkbrute){
                        return 1;
                    }else{
                      
                        if ($db_password == $password){
                            
                            $userTypeName='';    
                            if($type==1)
                             $userTypeName='admin';
                             if($type==2)
                               $userTypeName='employee';
                             if($type==3)
                               $userTypeName='investor';
                             if($type==4)
                               $userTypeName='customer';
                             if($type==5)
                               $userTypeName='dealer';
                            $user_browser = $_SERVER['HTTP_USER_AGENT'];
                            $mUser = array(
                                    'user_id'       => $result->id,
                                    'email' 	=> $result->email,
                                    'first_name'    => $result->first_name,
                                    'last_name'     => $result->last_name,
                                    'type'          => $userTypeName, 
                                    'type_id'          => $result->type,
                                    'register_date' => $result->register_date,
                                    'last_activity' => $result->last_activity,
                                    'phone'         => $result->phone,
                                    'ip_address'    => $ip_address,
                                    'loggedin_time' => $time,
                                    );
                            $this->session->set_userdata('marbel_user',$mUser);
                            $this->session->set_userdata('login_string',hash('sha512', $password . $user_browser));
                           
                            $update=array('last_activity'=>$time);
                            $this->db->where('id',$user_id);
                            $this->db->update('m_users', $update);
                            $insert=array('user_id'=>$user_id,'ip'=>$ip_address,'time'=>$time);
                            $this->db->insert('m_user_login_ip',$insert);
                            return 0;
                        }else
                        {   
                            
                            $insert=array('user_id'=>$user_id,'ip'=>$ip_address,'time'=>$time);
                            $this->db->insert('m_user_login_attempts',$insert);
                            return 2;
                         }
                        
                    }
                    
                }else 
                {     exit;
                    return 2;
		}
	}
        
     function getClientIP() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if (isset($_SERVER['CF-CONNECTING-IP']))
			$ipaddress = $_SERVER['CF-CONNECTING-IP'];
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if (isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
        
        function checkbrute($user_id) {
            $this->db->select('time')->from('m_user_login_attempts');
            $this->db->where('id',$user_id);
            $this->db->where('time > ','UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 HOUR)');
            $query=$this->db->get();
            if($query->num_rows()>5){
                return true;
                
            }else{
                
                return false;
            }
  
	}
        
        function auth_check(){
            if($this->session->userdata('marbel_user')!=''){
                
                return true;
            }else{
                
                return false;
            }
            
        }
       function sendPasswordResetEmail($email) {
           $this->db->select('mua.salt')->from('m_user_auth mua');
           $this->db->join('m_users mu','mu.id = mua.user_id');
           $this->db->where('mu.email',$email);
           $this->db->limit(1);
           $query=$this->db->get();
           $salt='';
           if($query->num_rows()==0){
               
               $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
               $insert=array('user_id'=>'(SELECT id FROM m_users WHERE email ='. $email.')','password'=>$salt,'salt'=>$salt);
               $this->db->insert('m_user_auth',$insert);
              
           }
           $key = hash('sha512', 'reset-password-key' . $salt);
           $users = $this->getUserEmailData($email);
           $mergeVars = array(
				array(
					'rcpt' => $email,
					'vars' => array(
						array(
							'name' => 'resetlink', 
							'content' => 'http://mymarbel.com/reset-password/'.$email.'/'.$key
						)
					)
				)
			);
            $this->sendTemplateEmail('password-reset-template', $users, 'Password reset for MyMarbel', $mergeVars);
            return 0;
		
	}
        
        function getUserEmailData($userStr) {	        
		$users = array();
		$sql = 'SELECT mu.id, mu.email, mu.first_name, mu.last_name, mu.phone, mo.order_number, mo.delivery_address, mo.delivery_address_2, mo.city, mo.state, mo.zip, mo.country, mo.invoice_url, mo.shipping_cost FROM m_users mu LEFT JOIN m_orders mo ON mo.user_id = mu.id WHERE ';

		$userArr = explode(",", str_replace(" ", "", $userStr));
		$query = "";
		$refType = "";
		foreach ($userArr as $k => $user) {
			if (!empty($query)) { $query .= " OR "; }
			$query .= "mu.email = ?";
			$refType .= "s";
		}
                
                $query=$this->db->query($sql.$query." GROUP BY mu.email ORDER BY mo.id DESC ", array($userStr)); 
                if($query->num_rows()>0){
                    $email_info=$query->row();
                    $users[] = array(
					'id'             => $email_info->id,	
					'email'          => $email_info->email,
					'first_name'     => $email_info->first_name,
					'last_name'      => $email_info->last_name,
					'phone'          => $email_info->phone,
					'address'        => $email_info->delivery_address,
					'address_2'      => $email_info->delivery_address_2,	
					'city'           => $email_info->city,
					'state'          => $email_info->state,
					'zip_code'       => $email_info->zip,
					'country'        => $email_info->country,
					'invoice_url'    => $email_info->invoice_url,
					'shipping_costs' => $email_info->shipping_cost,
					'order_number'   => $email_info->order_number
				);
                }
                return $users;
                
	}
        
        function sendTemplateEmail($template_name, $to, $subject, $mergeVars = array()) {
		$mandrill = $this->get_mandrill();
		$template_content = array();
		$msgTo = array();
		foreach ($to as $user) {
			$msgTo[] = array(
				'email' => $user['email'],
				'name' => $user['first_name'].' '.$user['last_name'],
				'type' => 'to'
			);
			$hasMergeVars = false;
			foreach ($mergeVars as $merge) {
				if (strcmp($merge['rcpt'], $user['email']) == 0) {
					$hasMergeVars = true;
				}
			}
			if (!$hasMergeVars) {
				$mergeVars[] = array(
					'rcpt' => $user['email'],
					'vars' => array()
				);
			}
			$index = -1;
			foreach ($mergeVars as $i => $merge) {
				if (strcmp($merge['rcpt'], $user['email']) == 0) {
					$index = $i;
					break;
				}
			}
			if ($index >= 0) {
				$mergeVars[$index]['vars'][] = array(
					'name' => 'firstname',
					'content' => $user['first_name']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'lastname',
					'content' => $user['last_name']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'email',
					'content' => $user['email']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'address1',
					'content' => $user['address']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'address2',
					'content' => $user['address_2']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'city',
					'content' => $user['city']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'state',
					'content' => $user['state']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'zipcode',
					'content' => $user['zip_code']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'country',
					'content' => $user['country']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'phone_number',
					'content' => $user['phone']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'invoice_url',
					'content' => $user['invoice_url']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'shipping_costs',
					'content' => $user['shipping_costs']
				);
				$mergeVars[$index]['vars'][] = array(
					'name' => 'order_number',
					'content' => $user['order_number']
				);
			}
		}
		$emptyFrom = false;
		foreach ($this->get_templates($mandrill) as $template) {
			if (strcmp($template['slug'], $template_name) == 0) {
				if (empty($template['from_email'])) {
					$emptyFrom = true;
				}
			}
		}
		$message = array(
			'to' => $msgTo,
			'important' => false,
			'subject' => $subject,
			'track_opens' => true,
			'track_clicks' => true,
			'merge' => true,
			'merge_language' => 'mailchimp',
			'merge_vars' => $mergeVars,
		);
		if ($emptyFrom) {
			$message['from_email'] = CONTACT_EMAIL;
		}
		$async = true;
		$ip_pool = 'Main Pool';
		$send_at = date("F j, Y, g:i a");
		return $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
	}
      function get_mandrill() {
		require_once 'utils/mail/mandrill/Mandrill.php';
		return new Mandrill(MANDRILL_API_KEY);
	}  
        
        function get_templates($mandrill) {
		return $mandrill->templates->getList();
	}
 }