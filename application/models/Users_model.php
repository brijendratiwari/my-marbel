<?php

class Users_model extends CI_Model {

    public $table = "m_users";

    function login($email = '', $password = '') {
        $this->db->select('mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.register_date, mu.last_activity, mu.phone, mua.password, mua.salt')->from('m_users mu');
        $this->db->join('m_user_auth mua', 'mua.user_id = mu.id');
        $this->db->where('mu.email', $email);
        $this->db->limit('1');
        $getInfo = $this->db->get();
        if ($getInfo->num_rows() > 0) {
            $result = $getInfo->row();
            $sait = $result->salt;
            $user_id = $result->id;
            $db_password = $result->password;
            $type = $result->type;
            $ip_address = $this->getClientIP();
            $password = hash('sha512', $password . $sait);
            $time = time();
            $checkbrute = $this->checkbrute($user_id);
            if ($checkbrute) {
                return 1;
            } else {

                if ($db_password == $password) {

                    $userTypeName = '';
                    if ($type == 1)
                        $userTypeName = 'admin';
                    if ($type == 2)
                        $userTypeName = 'employee';
                    if ($type == 3)
                        $userTypeName = 'investor';
                    if ($type == 4)
                        $userTypeName = 'customer';
                    if ($type == 5)
                        $userTypeName = 'dealer';
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $mUser = array(
                        'user_id' => $result->id,
                        'email' => $result->email,
                        'first_name' => $result->first_name,
                        'last_name' => $result->last_name,
                        'type' => $userTypeName,
                        'type_id' => $result->type,
                        'register_date' => $result->register_date,
                        'last_activity' => $result->last_activity,
                        'phone' => $result->phone,
                        'ip_address' => $ip_address,
                        'loggedin_time' => $time,
                    );
                    $this->session->set_userdata('marbel_user', $mUser);
                    $this->session->set_userdata('login_string', hash('sha512', $password . $user_browser));

                    $update = array('last_activity' => $time);
                    $this->db->where('id', $user_id);
                    $this->db->update('m_users', $update);
                    $insert = array('user_id' => $user_id, 'ip' => $ip_address, 'time' => $time);
                    $this->db->insert('m_user_login_ip', $insert);
                    return 0;
                }else {

                    $insert = array('user_id' => $user_id, 'ip' => $ip_address, 'time' => $time);
                    $this->db->insert('m_user_login_attempts', $insert);
                    return 2;
                }
            }
        } else {
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

//    function checkbrute($user_id) {
//        $this->db->select('time')->from('m_user_login_attempts');
//        $this->db->where('user_id', $user_id);
//        $this->db->where('time > ', 'UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 3 MINUTE)');
//        $query = $this->db->get();
//        echo $this->db->last_query(); die;
//        if ($query->num_rows() > 5) {
//            return true;
//        } else {
//
//            return false;
//        }
//    }
    function checkbrute($user_id) {
        $this->db->select('time')->from('m_user_login_attempts');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() > 5) {
             $this->db->select('time')->from('m_user_login_attempts');
             $this->db->where('user_id', $user_id);
             $this->db->order_by('id','DESC');
             $this->db->limit(1);
             $query1=$this->db->get();
             $attempt=$query1->row();
             $to_time = $attempt->time;
             $from_time = time();
            if(round(abs($to_time - $from_time) / 60) >= 120){
                $this->db->where('user_id', $user_id);
                $this->db->delete('m_user_login_attempts');
                return FALSE;
            }else{
                return TRUE;
            }
            
        } else {

            return FALSE;
        }
    }

    function auth_check() {
        if ($this->session->userdata('marbel_user')) {
            
            if($this->session->userdata['marbel_user']['type']!='' && ($this->session->userdata['marbel_user']['type']=='admin')){
                
                 return true;
                 
            }elseif ($this->session->userdata['marbel_user']['type']!='' && ($this->session->userdata['marbel_user']['type']=='customer')){
                
                 return true;
            }
           
        } else {

            return false;
        }
    }

    function sendPasswordResetEmail($email) {
        
        $this->db->select('mua.salt')->from('m_user_auth mua');
        $this->db->join('m_users mu', 'mu.id = mua.user_id');
        $this->db->where('mu.email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        $salt = '';
        if ($query->num_rows() == 0) {
           
            $this->db->select('id')->from('m_users');
            $this->db->where('email', $email);
            $query1 = $this->db->get();
            if ($query1->num_rows() > 0) {
              
                $user_data = $query1->result_array();
                $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                $insert = array('user_id' => $user_data[0]['user_id'], 'password' => $salt, 'salt' => $salt);
                $this->db->insert('m_user_auth', $insert);
            } else {
                
                return 0;
            }
        }else{
           
             $user_data=$query->result_array();
             $salt = $user_data[0]['salt'];
        }
        $key = hash('sha512', 'reset-password-key' . $salt);
        $users = $this->getUserEmailData($email);
        #echo base_url('resetPassword/' . $email . '/' . $key . ''); die;
        $mergeVars = array(
            array(
                'rcpt' => $email,
                'vars' => array(
                    array(
                        'name' => 'resetlink',
                        'content' => base_url('resetPassword/' . $email . '/' . $key . '')
                    )
                )
            )
        );
        $this->sendTemplateEmail('password-reset-template', $users, 'Password reset for MyMarbel', $mergeVars);
        return TRUE;
    }

    function getUserEmailData($userStr) {
        $users = array();
        $sql = 'SELECT mu.id, mu.email, mu.first_name, mu.last_name, mu.phone, mo.order_number, mo.delivery_address, mo.delivery_address_2, mo.city, mo.state, mo.zip, mo.country, mo.invoice_url, mo.shipping_cost FROM m_users mu LEFT JOIN m_orders mo ON mo.user_id = mu.id WHERE ';

        $userArr = explode(",", str_replace(" ", "", $userStr));
        $query = "";
        $refType = "";
        foreach ($userArr as $k => $user) {
            if (!empty($query)) {
                $query .= " OR ";
            }
            $query .= "mu.email = ?";
            $refType .= "s";
        }

        $query = $this->db->query($sql . $query . " GROUP BY mu.email ORDER BY mo.id DESC ", array($userStr));
        if ($query->num_rows() > 0) {
            $email_info = $query->row();
            $users[] = array(
                'id' => $email_info->id,
                'email' => $email_info->email,
                'first_name' => $email_info->first_name,
                'last_name' => $email_info->last_name,
                'phone' => $email_info->phone,
                'address' => $email_info->delivery_address,
                'address_2' => $email_info->delivery_address_2,
                'city' => $email_info->city,
                'state' => $email_info->state,
                'zip_code' => $email_info->zip,
                'country' => $email_info->country,
                'invoice_url' => $email_info->invoice_url,
                'shipping_costs' => $email_info->shipping_cost,
                'order_number' => $email_info->order_number
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
                'name' => $user['first_name'] . ' ' . $user['last_name'],
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
        $this->load->library('Mandrill');
        return new Mandrill(MANDRILL_API_KEY);
    }

    function get_templates($mandrill) {
        return $mandrill->templates->getList();
    }

    /* function for API */

    function getAppUserByEmail($email) {


        $this->db->select('mu.id as user_id, mu.email, mu.first_name, mu.last_name, mu.type, mu.register_date, mu.last_activity, mu.phone, mu.notes, mu.email_secondary,mu.bio,mu.height,mu.weight,mu.terrain,mu.company,mu.address_one,mu.address_two,mu.city,mu.state_or_region,mu.postal_code,mu.country,mu.accepts,mu.alias,mu.privacy_setting,mu.units,mu.range_alarm,mu.notifications,mu.primary_riding_style,mu.safety_brake,mu.preferred_braking_force,mu.reverse_turned,mu.locked_settings,mu.parental_lock,mu.user_profile_pic,mu.twitter_handle,mu.linkedin_handle,mu.instagram_handle,mu.reddit_handle,mu.comments, mua.password as db_password, mua.salt');

        $this->db->from('m_users as mu');
        $this->db->join('m_user_auth as mua', 'mua.user_id = mu.id', 'LEFT');
        $this->db->where('mu.email', $email);
        $res = $this->db->get();

        if ($res->num_rows() > 0) {
            
            return $res->row_array();
            
        } else {
            return FALSE;
        }
    }

    function updatePassword($email, $resetKey, $newPassword) {
        $this->db->select('mua.salt,mua.user_id');
        $this->db->from('m_user_auth as mua');
        $this->db->join('m_users as mu', 'mu.id = mua.user_id');
        $this->db->where('mu.email', $email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $user_data = $query->result_array();
            $salt = $user_data[0]['salt'];
            $key = hash('sha512', 'reset-password-key' . $salt);
//         echo $key.'<br>';
//         echo $resetKey.'<br>';die;
            if (strcmp($key, $resetKey) !== 0) {
                return 1;
            }
            $newSalt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            $password = hash('sha512', $newPassword . $newSalt);
            $this->db->where('user_id', $user_data[0]['user_id']);
            $this->db->update('m_user_auth', array('password' => $password, 'salt' => $newSalt));
            if ($this->db->affected_rows() > 0) {
                return 0;
            } else {
                return 'error';
            }
        }
        return 2;
    }
    public function getUserImage($id){
        $this->db->select('user_profile_pic')->from('m_users');
        $this->db->where('id',$id);
        $query=$this->db->get();
        if($query->num_rows()>0){
            $image=$query->row();
            return $image->user_profile_pic;
        }else{
            
            return false;
        }
        
    }
    public function checkUserEmail($email){
        $this->db->select('email')->from('m_users');
        $this->db->where('email',$email);
        $query=$this->db->get();
        if($query->num_rows()>0){
           
            return $query->num_rows();
        }
        
    }
    public function checkUserEmailForUpdate($email=false,$user_id=false){
        $this->db->select('email')->from('m_users');
        $this->db->where('email',$email);
        $this->db->where('id !=',$user_id);
        $query=$this->db->get();
        if($query->num_rows()>0){
           
            return true;
        }else{
            return false;
        }
        
    }
}
