<?php

class Customers_model extends CI_Model {

    function checkUserEmail($email) {
        $this->db->select('id') - from('m_users');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->row();
        } else {

            return false;
        }
    }

    function getUserType() {
        $this->db->select('user_role_type,id,parent')->from('m_users_level');
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return false;
        }
    }

    function getChildUserLevel($id) {
        $this->db->select('parent,id,user_role_type,status')->from('m_users_level');
        $this->db->where('status', 1);
        $this->db->where('parent', $id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->result_array();
        } else {

            return false;
        }
    }

    function getCustomers($id) {
        $this->db->select('mu.id, mu.email, mu.first_name, mu.last_name, mu.type, mu.parent_type, mu.register_date, mu.last_activity, mu.phone, mu.notes, muli.ip,mu.email_secondary,mu.bio,mu.height,mu.weight,mu.terrain,mu.company,mu.address_one,mu.address_two,mu.city,mu.state_or_region,mu.postal_code,mu.country,mu.accepts,mu.alias,mu.privacy_setting,mu.units,mu.range_alarm,mu.notifications,mu.primary_riding_style,mu.safety_brake,mu.preferred_braking_force,mu.reverse_turned,mu.locked_settings,mu.user_profile_pic,mu.reddit_handle,mu.instagram_handle,mu.linkedin_handle,mu.twitter_handle,mu.parental_lock,mu.comments')->from('m_users mu');
        $this->db->join('m_user_login_ip muli', 'muli.user_id = mu.id AND muli.time = mu.last_activity', 'left');
        $this->db->where('mu.id', $id);
        $this->db->order_by('mu.id ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = array();
            $result = $query->row_array();
            $result['parent_name'] = $this->getLevelUsersName($result['parent_type']);
            $result['child_name'] = $this->getLevelUsersName($result['type']);

            return $result;
        } else {
            return false;
        }
    }

    function getLevelUsersName($id) {


        $this->db->select('user_role_type')->from('m_users_level');
        $this->db->where('status', 1);
        $this->db->where('id', $id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            $data = $query->row_array();
            return $data['user_role_type'];
        } else {

            return false;
        }
    }

    function updateCustomer($id) {

        $update_data = array(
            'email' => $this->input->post('cd-email'),
            'first_name' => $this->input->post('cd-first_name'),
            'last_name' => $this->input->post('cd-last_name'),
            'parent_type' => $this->input->post('cd-parent'),
            'phone' => $this->input->post('cd-phone'),
            'notes' => $this->input->post('cd-notes'),
            'email_secondary' => $this->input->post('cd-email-second'),
            'bio' => $this->input->post('cd-bio'),
            'weight' => $this->input->post('cd-weight'),
            'height' => $this->input->post('cd-height'),
            'company' => $this->input->post('cd-company'),
            'address_one' => $this->input->post('cd-address-one'),
            'address_two' => $this->input->post('cd-address-two'),
            'city' => $this->input->post('cd-city'),
            'state_or_region' => $this->input->post('cd-state-region'),
            'postal_code' => $this->input->post('cd-postal-code'),
            'country' => $this->input->post('cd-country'),
            'alias' => $this->input->post('cd-alias'),
            'twitter_handle' => $this->input->post('cd-twitter-handle'),
            'linkedin_handle' => $this->input->post('cd-linkedin-handle'),
            'instagram_handle' => $this->input->post('cd-instagram-handle'),
            'reddit_handle' => $this->input->post('cd-reddit-handle'),
//            'note_orders'=>$this->input->post('cd-note-order'),
//            'note_services'=>$this->input->post('cd-note-services'),
//            'note_tasks'=>$this->input->post('cd-note-task'),
            'comments' => $this->input->post('cd-comments'),
            'type' => $this->input->post('cd-type'),
            'parent_type' => $this->input->post('cd-parent'),
        );
        $this->db->where('id', $id);
        $this->db->update('m_users', $update_data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {

            return false;
        }
    }

    function deleteCustomer($id) {
        $this->db->where('id', $id);
        $this->db->delete('m_users');
        $this->db->where('user_id', $id);
        $this->db->delete('m_user_auth');
    }

    function updateProfile($id) {

        if ($this->input->post()) {
            $first_name = $this->input->post('cd-first');
            $last_name = $this->input->post('cd-last');
            /* $password = $this->input->post('cd-password'); */
            $profile = NULL;
            if (isset($_FILES['cd-profile']['name'])) {

                $filename = explode('.', $_FILES['cd-profile']['name']);

                $profile = $first_name . '.' . $filename[1];

                move_uploaded_file($_FILES['cd-profile']['tmp_name'], __DIR__ . '/../../assets/profile-imgs/' . basename($profile));
            } else {
                $profile = $this->Users->getUserImage($id);
            }

            $data_update = array(
                'email' => $this->input->post('cd-email'),
                'first_name' => $this->input->post('cd-first'),
                'last_name' => $this->input->post('cd-last'),
                'phone' => $this->input->post('cd-phone'),
                'bio' => $this->input->post('cd-bio'),
                'height' => $this->input->post('cd-height'),
                'weight' => $this->input->post('cd-weight'),
                'company' => $this->input->post('cd-company'),
                'address_one' => $this->input->post('cd-address-one'),
                'address_two' => $this->input->post('cd-address-two'),
                'city' => $this->input->post('cd-city'),
                'state_or_region' => $this->input->post('cd-state-region'),
                'postal_code' => $this->input->post('cd-postal-code'),
                'country' => $this->input->post('cd-country'),
                'accepts' => $this->input->post('cd-accepts-marketing'),
                'privacy_setting' => $this->input->post('cd-privacy-setting'),
                'units' => $this->input->post('cd-units'),
                'range_alarm' => $this->input->post('cd-rangealarm'),
                'notifications' => $this->input->post('cd-notifications-rides'),
                'primary_riding_style' => $this->input->post('cd-primary-riding-style'),
                'safety_brake' => $this->input->post('cd-safety-brake'),
                'preferred_braking_force' => $this->input->post('cd-preferred-braking-force'),
                'reverse_turned' => $this->input->post('cd-reverse-turned'),
                'locked_settings' => $this->input->post('cd-locked-settings'),
                'parental_lock' => $this->input->post('cd-parental-lock'),
                'terrain' => $this->input->post('cd-terrain'),
//                'note_support_ticket' => $this->input->post('cd-support-ticket'),
//                'note_tasks' => $this->input->post('cd-note-task'),
//                'note_services' => $this->input->post('cd-note-services'),
//                'note_orders' => $this->input->post('cd-notes-order'),
                'comments' => $this->input->post('cd-comments'),
                'user_profile_pic' => $profile,
                'last_activity' => time()
            );

            $this->db->where('id', $id);
            $this->db->update('m_users', $data_update);
            if ($this->db->affected_rows() > 0) {
                /* if ($password != '') {


                  $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                  $password = hash('sha512', $password . $random_salt);
                  $user_auth = array('password' => $password, 'salt' => $random_salt);
                  $this->db->where('user_id',$id);
                  $this->db->update('m_user_auth', $user_auth);


                  } */
                $result['result'] = TRUE;
                $result['success'] = $first_name . ' ' . $last_name . ' was Updated successfully';
                echo json_encode($result);
                die;
            } else {

                $result['result'] = FALSE;
                $result['error'] = $first_name . ' ' . $last_name . '.<br />Unknown Error';
                echo json_encode($result);
                die;
            }
        }
        $result['result'] = FALSE;
        $result['error'] = $first_name . ' ' . $last_name . '.<br />Unknown Error';
        echo json_encode($result);
        die;
    }

    function getCustomerInfo($id) {
        $this->db->select('*')->from('m_users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->row_array();
        }
    }

    function checkEmail($email, $id) {
        $this->db->select('email')->from('m_users');
        $this->db->where('email', $email);
        $this->db->where('id != ', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    function getEmailByUserId($id = false) {

        $this->db->select('email')->from('m_users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $info = $query->row_array();
            return $info['email'];
        } else {

            return false;
        }
    }

    function getUsersTasks($id = false) {

        $this->db->select('m_tasks.task_name,m_tasks.task_status,m_tasks.task_details,m_tasks.task_due_date,m_task_category.cat_name,m_users. 	first_name')->from('m_tasks');
        $this->db->join('m_users', 'm_users.id=m_tasks.task_regarding');
        $this->db->join('m_task_category', 'm_task_category.cat_id=m_tasks.task_cat_id');
        $this->db->where('m_tasks.task_regarding', $id);
        $this->db->where('m_tasks.task_status !=', 'Finished');
        $this->db->order_by('m_tasks.task_id', 'Desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $info = $query->result_array();
        } else {

            return false;
        }
    }

    function checkUserPassword($id = false) {

        $this->db->select('user_id')->from('m_user_auth');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->row_array();
        } else {

            return false;
        }
    }

    function getRideDetailByUserId($id = false) {

        $this->db->select('sum(trip_distance) as tripdistance, sum(trip_duration) as tripduration ,sum(efficiency) as efficiency,ride_ID')->from('m_rides');
        $this->db->where('userID', $id);
        $this->db->order_by('ride_ID', 'desc');
        $this->db->limit(30);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = array();

            $results = $query->row_array();
            $result['trip_duration'] = round($results['tripduration'] / 3600, 1);
            $result['trip_distance'] = round($results['tripdistance'], 1);
            $result['efficiencys'] = round($results['efficiency']);
            $result['odometers'] = $this->getRidesPointsDetail($results['ride_ID']);

            return $result;
        } else {

            return false;
        }
    }

    function getRidesPointsDetail($id = false) {

        $this->db->select('sum(odometer) as odometer')->from('m_ride_points');
        $this->db->where('ride_id', $id);
        $this->db->order_by('ride_point_id', 'desc');
        $this->db->limit(30);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = array();
            $results = $query->row_array();
            return $result['odometers'] = round($results['odometer'], 1);
        } else {

            return false;
        }
    }

    function getNotes($id) {

        $this->db->select('*')->from('m_notes');
        $this->db->where('created_to', $id);
        $this->db->order_by('note_id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $response = $query->result_array();
            $i = 0;
            foreach ($response as $result) {

                $response[$i]['comments'] = $this->getCommentsByNoteId($result['note_id']);
                $response[$i]['comment_count'] = count($this->getCommentsByNoteId($result['note_id']));
                $i++;
            }

            return $response;
        } else {

            return false;
        }
    }

    function getNotesById($id) {

        $this->db->select('*')->from('m_notes');
        $this->db->where('note_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->row_array();
        } else {

            return false;
        }
    }

    function getCommentsById($id) {

        $this->db->select('*')->from('m_notes_comment');
        $this->db->where('cmt_id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return $query->row_array();
        } else {

            return false;
        }
    }

    function getCommentsByNoteId($id) {

        $this->db->select('*')->from('m_notes_comment');
        $this->db->where('noteID', $id);
        $this->db->order_by('cmt_id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            $response = $query->result_array();
            $i = 0;
            foreach ($response as $result) {

                if ($result['created_by'] == $this->session->userdata['marbel_user']['user_id']) {
                    $commented_by = 'commented by you';
                } else {
                    $commented_by = 'commented by ' . getUserName($result['created_by']);
                }
                $response[$i]['created'] = $commented_by;
                $i++;
            }
            return $response;
        } else {

            return false;
        }
    }

}
