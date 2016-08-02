<?php

class Webapi_model extends CI_Model {

    function checkRideId($id = false) {

        $this->db->select('ride_ID')->from('m_rides');
        $this->db->where('ride_ID', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            return true;
        } else {

            return false;
        }
    }

    function getUserInfo($user_id = false) {

        $this->db->select('mu.id as user_id, mu.email, mu.first_name, mu.last_name, mu.type, mu.register_date, mu.last_activity, mu.phone, mu.notes, mu.email_secondary,mu.bio,mu.height,mu.weight,mu.terrain,mu.company,mu.address_one,mu.address_two,mu.city,mu.state_or_region,mu.postal_code,mu.country,mu.accepts,mu.alias,mu.privacy_setting,mu.units,mu.range_alarm,mu.notifications,mu.primary_riding_style,mu.safety_brake,mu.preferred_braking_force,mu.reverse_turned,mu.locked_settings,mu.parental_lock,mu.user_profile_pic,mu.twitter_handle,mu.linkedin_handle,mu.instagram_handle,mu.reddit_handle,mu.comments, mua.password as db_password, mua.salt');

        $this->db->from('m_users as mu');
        $this->db->join('m_user_auth as mua', 'mua.user_id = mu.id', 'LEFT');
        $this->db->where('mu.id', $user_id);
        $res = $this->db->get();

        if ($res->num_rows() > 0) {
            $returnValue = array();
            $userDetails = $res->row_array();
            if ($userDetails["user_profile_pic"] != '') {

                $user_profile = base_url('assets/profile-imgs/' . $userDetails["user_profile_pic"]);
            } else {

                $user_profile = '';
            }
            $returnValue["userFirstName"] = $userDetails["first_name"];
            $returnValue["userLastName"] = $userDetails["last_name"];
            $returnValue["userEmail"] = $userDetails["email"];
            $returnValue["userId"] = $userDetails["user_id"];
            $returnValue["userType"] = $userDetails["type"];
            $returnValue["register_date"] = $userDetails["register_date"];
            $returnValue["userEmailSecondary"] = $userDetails["email_secondary"];
            $returnValue["userBio"] = $userDetails["bio"];
            $returnValue["height"] = $userDetails["height"];
            $returnValue["weight"] = $userDetails["weight"];
            $returnValue["terrain"] = $userDetails["terrain"];
            $returnValue["company"] = $userDetails["company"];
            $returnValue["addressOne"] = $userDetails["address_one"];
            $returnValue["addressTwo"] = $userDetails["address_two"];
            $returnValue["city"] = $userDetails["city"];
            $returnValue["stateRegion"] = $userDetails["state_or_region"];
            $returnValue["postalCode"] = $userDetails["postal_code"];
            $returnValue["country"] = $userDetails["country"];
            $returnValue["alias"] = $userDetails["alias"];
            $returnValue["privacySetting"] = $userDetails["privacy_setting"];
            $returnValue["units"] = $userDetails["units"];
            $returnValue["rangeAlarm"] = $userDetails["range_alarm"];
            $returnValue["notification"] = $userDetails["notifications"];
            $returnValue["primaryRidingStyle"] = $userDetails["primary_riding_style"];
            $returnValue["safetyBrake"] = $userDetails["safety_brake"];
            $returnValue["preferredBrakingForce"] = $userDetails["preferred_braking_force"];
            $returnValue["reverseTurned"] = $userDetails["reverse_turned"];
            $returnValue["lockedSettings"] = $userDetails["locked_settings"];
            $returnValue["parentalLock"] = $userDetails["parental_lock"];
            $returnValue["linkedinHandle"] = $userDetails["linkedin_handle"];
            $returnValue["instagramHandle"] = $userDetails["instagram_handle"];
            $returnValue["redditHandle"] = $userDetails["reddit_handle"];
            $returnValue["userComments"] = $userDetails["comments"];
            $returnValue["userProfilePicture"] = $user_profile;

            return $returnValue;
        } else {
            return false;
        }
    }

    public function saveUserInfo($filename) {

        $data = array(
            'first_name'                => ($this->input->get_post('userFirstName')) ? $this->input->get_post('userFirstName') : '',
            'last_name'                 => ($this->input->get_post('userLastName')) ? $this->input->get_post('userLastName') : '',
            'email'                     => ($this->input->get_post('userEmail')) ? $this->input->get_post('userEmail') : '',
            'type'                      => ($this->input->get_post('userType')) ? $this->input->get_post('userType') : '',
            'notes'                     => ($this->input->get_post('message')) ? $this->input->get_post('message') : '',
            'email_secondary'           => ($this->input->get_post('email_secondary'))?$this->input->get_post('email_secondary') : '',
            'bio'                       => ($this->input->get_post('bio')) ? $this->input->get_post('bio') : '',
            'height'                    => ($this->input->get_post('height')) ? $this->input->get_post('height') : '',
            'weight'                    => ($this->input->get_post('weight')) ? $this->input->get_post('weight') : '',
            'terrain'                   => ($this->input->get_post('terrain')) ? $this->input->get_post('terrain') : '',
            'company'                   => ($this->input->get_post('company')) ? $this->input->get_post('company') : '',
            'address_one'               => ($this->input->get_post('addressOne')) ? $this->input->get_post('addressOne') : '',
            'address_two'               => ($this->input->get_post('addressTwo')) ? $this->input->get_post('addressTwo') : '',
            'city'                      => ($this->input->get_post('city')) ? $this->input->get_post('city') : '',
            'state_or_region'           => ($this->input->get_post('stateRegion')) ? $this->input->get_post('stateRegion') : '',
            'postal_code'               => ($this->input->get_post('postalCode')) ? $this->input->get_post('postalCode') : '',
            'country'                   => ($this->input->get_post('country')) ? $this->input->get_post('country') : '',
            'privacy_setting'           => ($this->input->get_post('privacySetting')) ? $this->input->get_post('privacySetting') : '',
            'units'                     => ($this->input->get_post('units')) ? $this->input->get_post('units') : '',
            'range_alarm'               => ($this->input->get_post('rangeAlarm')) ? $this->input->get_post('rangeAlarm') : '',
            'notifications'             => ($this->input->get_post('notifications')) ? $this->input->get_post('notifications') : '',
            'primary_riding_style'      => ($this->input->get_post('primaryRidingStyle')) ? $this->input->get_post('primaryRidingStyle') : '',
            'safety_brake'              => ($this->input->get_post('safetyBrake')) ? $this->input->get_post('safetyBrake') : '',
            'preferred_braking_force'   => ($this->input->get_post('preferredBrakingForce')) ? $this->input->get_post('preferredBrakingForce') : '',
            'reverse_turned'            => ($this->input->get_post('reverseTurned')) ? $this->input->get_post('reverseTurned') : '',
            'locked_settings'           => ($this->input->get_post('lockedSettings')) ? $this->input->get_post('lockedSettings') : '',
            'register_date'             => time(),
            'user_profile_pic'          => $filename
        );


        $this->db->insert('m_users', $data);

        if ($this->db->insert_id()) {
            $inser_id = $this->db->insert_id();
            if ($this->input->get_post('userPassword')) {
                $password = $this->input->get_post('userPassword');
                $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                $password = hash('sha512', $password . $random_salt);
                $user_auth = array('user_id' => $inser_id, 'password' => $password, 'salt' => $random_salt);
                $this->db->insert('m_user_auth', $user_auth);
            }
            return $inser_id;
        } else {

            return false;
        }
    }

    public function userUpdateInfos($user_id = false, $filename = false) {



        $data = array(
            'first_name'                    => ($this->input->get_post('userFirstName')) ? $this->input->get_post('userFirstName') : '',
            'last_name'                     => ($this->input->get_post('userLastName')) ? $this->input->get_post('userLastName') : '',
            'email'                         => ($this->input->get_post('userEmail')) ? $this->input->get_post('userEmail') : '',
            'type'                          => ($this->input->get_post('userType')) ? $this->input->get_post('userType') : '',
            'notes'                         => ($this->input->get_post('message')) ? $this->input->get_post('message') : '',
            'email_secondary'               => ($this->input->get_post('email_secondary'))? $this->input->get_post('email_secondary'): '',
            'bio'                           => ($this->input->get_post('bio')) ? $this->input->get_post('bio') : '',
            'height'                        => ($this->input->get_post('height')) ? $this->input->get_post('height') : '',
            'weight'                        => ($this->input->get_post('weight')) ? $this->input->get_post('weight') : '',
            'terrain'                       => ($this->input->get_post('terrain')) ? $this->input->get_post('terrain') : '',
            'company'                       => ($this->input->get_post('company')) ? $this->input->get_post('company') : '',
            'address_one'                   => ($this->input->get_post('addressOne')) ? $this->input->get_post('addressOne') : '',
            'address_two'                   => ($this->input->get_post('addressTwo')) ? $this->input->get_post('addressTwo') : '',
            'city'                          => ($this->input->get_post('city')) ? $this->input->get_post('city') : '',
            'state_or_region'               => ($this->input->get_post('stateRegion')) ? $this->input->get_post('stateRegion') : '',
            'postal_code'                   => ($this->input->get_post('postalCode')) ? $this->input->get_post('postalCode') : '',
            'country'                       => ($this->input->get_post('country')) ? $this->input->get_post('country') : '',
            'privacy_setting'               => ($this->input->get_post('privacySetting')) ? $this->input->get_post('privacySetting') : '',
            'units'                         => ($this->input->get_post('units')) ? $this->input->get_post('units') : '',
            'range_alarm'                   => ($this->input->get_post('rangeAlarm')) ? $this->input->get_post('rangeAlarm') : '',
            'notifications'                 => ($this->input->get_post('notifications')) ? $this->input->get_post('notifications') : '',
            'primary_riding_style'          => ($this->input->get_post('primaryRidingStyle')) ? $this->input->get_post('primaryRidingStyle') : '',
            'safety_brake'                  => ($this->input->get_post('safetyBrake')) ? $this->input->get_post('safetyBrake') : '',
            'preferred_braking_force'       => ($this->input->get_post('preferredBrakingForce')) ? $this->input->get_post('preferredBrakingForce') : '',
            'reverse_turned'                => ($this->input->get_post('reverseTurned')) ? $this->input->get_post('reverseTurned') : '',
            'locked_settings'               => ($this->input->get_post('lockedSettings')) ? $this->input->get_post('lockedSettings') : '',
            'user_profile_pic'              => $filename
        );
        $this->db->where('id', $user_id);
        $this->db->update('m_users', $data);

        if ($this->input->get_post('userPassword')) {
            $password = $this->input->get_post('userPassword');
            $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            $password = hash('sha512', $password . $random_salt);
            $this->db->where('user_id', $user_id);
            $this->db->update('m_user_auth', array('password' => $password, 'salt' => $random_salt));
        }
        return true;
    }

    function saveBoardDetails() {

        if ($this->input->get_post('serial_number')) {

            $board = array(
                'board_id'              => ($this->input->get_post('board_id'))?$this->input->get_post('board_id'):"",
                'board_name'            => ($this->input->get_post('board_name'))?$this->input->get_post('board_name'):"",
                'user_id'               => ($this->input->get_post('user_id'))?$this->input->get_post('user_id'):"",
                'serial_number'         => ($this->input->get_post('serial_number'))?$this->input->get_post('serial_number'):"",
                'firmware_version'      => ($this->input->get_post('firmware_version'))?$this->input->get_post('firmware_version'):"",
                'wheel_size'            => ($this->input->get_post('wheel_size'))?$this->input->get_post('wheel_size'):"",
                'odometer'              => ($this->input->get_post('odometer'))?$this->input->get_post('odometer'):"",
                'ride_count'            => ($this->input->get_post('ride_count'))?$this->input->get_post('ride_count'):"",
                'batt_charge_count'     => ($this->input->get_post('batt_charge_count'))?$this->input->get_post('batt_charge_count'):"",
                'lock_status'           => ($this->input->get_post('lock_status'))?$this->input->get_post('lock_status'):"",
                'parent_lock_status'    => ($this->input->get_post('parent_lock_status'))?$this->input->get_post('parent_lock_status'):"",
                'user_email'            => ($this->input->get_post('user_email'))?$this->input->get_post('user_email'):"",
                'batt_serial_number'    => ($this->input->get_post('batt_serial_number'))?$this->input->get_post('batt_serial_number'):"",
                'motor_version'         => ($this->input->get_post('motor_version'))?$this->input->get_post('motor_version'):"",
                'aio_circuit_version'   => ($this->input->get_post('aio_circuit_version'))?$this->input->get_post('aio_circuit_version'):"",
                'deck_version'          => ($this->input->get_post('deck_version'))?$this->input->get_post('deck_version'):"",
                'production_date'       => ($this->input->get_post('production_date'))?$this->input->get_post('production_date'):""
            );
            $checkBoardId = $this->checkBoardId($this->input->get_post('serial_number'));
            if ($checkBoardId) {
                $this->db->where('serial_number', $this->input->get_post('serial_number'));
                $this->db->update('m_boards', $board);
                return 'Board details updated successfully';
            } else {

                $this->db->insert('m_boards', $board);
                if ($this->db->insert_id()) {

                    return 'Board details save successfully';
                }
            }
        }
    }

    function checkBoardId($id = false) {
        if ($id != false) {
            $this->db->select('serial_number')->from('m_boards');
            $this->db->where('serial_number', $id);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {

                return true;
            } else {

                return false;
            }
        } else {

            return false;
        }
    }

}
