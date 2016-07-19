<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Mymarbelapis extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('users_model', 'Users');
        $this->load->model('webapi_model', 'Webapi');
    }

    public function index() {
        $returnValue = array();
        $returnValue['data'] = array();
        $this->form_validation->set_rules('userEmail', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('userPassword', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {

            $returnValue["message"] = $this->form_validation->error_array();
            $returnValue["result"] = 'failed';
            echo json_encode($returnValue);
            die;
        } else {
            $userEmail = htmlentities($this->input->get_post("userEmail"));
            $userPassword = htmlentities($this->input->get_post("userPassword"));
            $userDetails = $this->Users->getAppUserByEmail($userEmail);
            if ($userDetails) {

                $userSecuredPassword = $userDetails["db_password"];
                $userSalt = $userDetails["salt"];
                $userPassword = hash('sha512', $userPassword . $userSalt);
                if ($userSecuredPassword == $userPassword) {
                    $user_info = $this->Webapi->getUserInfo($userDetails['user_id']);
                    $returnValue["status"] = "200";
                    $returnValue["message"] = "success";
                    $returnValue["result"] = "User Information.";
                    $returnValue['data'] = $user_info;
                    echo json_encode($returnValue);
                    die;
                } else {

                    $returnValue["message"] = "Incorrect Password.";
                    $returnValue["result"] = "Failed";
                    echo json_encode($returnValue);
                    die;
                }
            } else {

                $returnValue["message"] = "No Information found.";
                $returnValue["result"] = "failed";
                echo json_encode($returnValue);
                die;
            }
        }
    }

    public function users_signup() {
        $returnValue = array();
        $returnValue["data"] = array();
        $this->form_validation->set_rules('userEmail', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('userPassword', 'Password', 'trim|required');
        $this->form_validation->set_rules('userFirstName', 'First Name', 'trim|required');
        $this->form_validation->set_rules('userLastName', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('userType', 'User type', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {

            $returnValue["message"] = $this->form_validation->error_array();
            $returnValue["result"] = 'failed';
            echo json_encode($returnValue);
            die;
        } else {
             if ($this->input->get_post('userProfilePicture')) {

                $filename = $this->updateProfilePicture($this->input->get_post('userProfilePicture'),$this->input->get_post('userFirstName'));
            } else {
                $filename = $this->Users->getUserImage($user_id);
            }
            if ($this->input->get_post('userId')) {
                $user_id = $this->input->get_post('userId');
                $check_email = $this->Users->checkUserEmailForUpdate($this->input->get_post('userEmail'), $user_id);
                if ($check_email == false) {

                    $response = $this->Webapi->userUpdateInfos($user_id,$filename);
                 
                    if ($response) {
                        $returnValue["data"]['userId'] = $user_id;
                        $returnValue["status"] = "200";
                        $returnValue["message"] = "User informatiom updated successfully .";
                        echo json_encode($returnValue);
                        die;
                    } else {
                        $returnValue["message"] = "Some thing went wrong ! Please try again.";
                        $returnValue["result"] = 'failed';
                        echo json_encode($returnValue);
                        die;
                    }
                } else {


                    $returnValue["message"] = "Email already exist.Please try with other email";
                    $returnValue["result"] = 'failed';
                    echo json_encode($returnValue);
                    die;
                }
            } else {
                $check_email = $this->Users->checkUserEmail($_REQUEST["userEmail"]);
                if ($check_email == '') {
                    $response = $this->Webapi->saveUserInfo($filename);
                    if ($response) {
                        $returnValue["data"]['userId'] = $response;
                        $returnValue["status"] = "200";
                        $returnValue["message"] = "User informatiom added successfully.";
                        echo json_encode($returnValue);
                        die;
                    } else {

                        $returnValue["message"] = "Some thing went wrong ! Please try again.";
                        $returnValue["result"] = 'failed';
                        echo json_encode($returnValue);
                        die;
                    }
                } else {


                    $returnValue["message"] = "Email already exist.Please try with other email";
                    $returnValue["result"] = 'failed';
                    echo json_encode($returnValue);
                    die;
                }
            }
        }
    }

    public function rides() {
        $returnValue = array();
        $returnValue["data"] = array();
        $this->form_validation->set_rules('board_ID', 'Board id', 'trim');
        if ($this->form_validation->run() == FALSE) {


           
            $returnValue["message"] = $this->form_validation->error_array();
            $returnValue["result"] = 'Validation Error!';
            echo json_encode($returnValue);
            die;
        } else {

            $ride = array(
                'board_ID' => ($this->input->get_post('board_ID')) ? $this->input->get_post('board_ID') : "",
                'trip_distance' => ($this->input->get_post("trip_distance")) ? $this->input->get_post("trip_distance") : "",
                'trip_duration' => ($this->input->get_post("trip_duration")) ? $this->input->get_post("trip_duration") : "",
                'est_start_st' => ($this->input->get_post("est_start_st")) ? $this->input->get_post("est_start_st") : "",
                'est_finish_st' => ($this->input->get_post("est_finish_st")) ? $this->input->get_post("est_finish_st") : "",
                'temp_f' => ($this->input->get_post("temp_f")) ? $this->input->get_post("temp_f") : "",
                'humidity' => ($this->input->get_post("humidity")) ? $this->input->get_post("humidity") : "",
                'ride_name' => ($this->input->get_post('ride_name')) ? $this->input->get_post('ride_name') : ""
            );

            if ($this->input->get_post('ride_ID')) {

                $ride_check = $this->Webapi->checkRideId($this->input->get_post('ride_ID'));
                if ($ride_check) {
                    $this->db->where('ride_ID', $this->input->get_post('ride_ID'));
                    $this->db->update('m_rides', $ride);


                    $returnValue["data"]['ride_ID'] = $this->input->get_post('ride_ID');
                    $returnValue["status"] = "200";
                    $returnValue["message"] = 'Ride updated successfully';
                    $returnValue["result"] = 'success';
                    echo json_encode($returnValue);
                    die;
                } else {

                   
                    $returnValue["message"] = 'Ride id does not exist!';
                    $returnValue["result"] = 'failed';
                    echo json_encode($returnValue);
                    die;
                }
            } else {
                $this->db->insert('m_rides', $ride);
                if ($this->db->insert_id() > 0) {
                    $returnValue["data"]['ride_ID'] = $this->db->insert_id();
                    $returnValue["status"] = "200";
                    $returnValue["message"] = 'Ride inserted successfully';
                    $returnValue["result"] = 'success';
                    echo json_encode($returnValue);
                    die;
                } else {

                   
                    $returnValue["message"] = 'Some thing went wrough ! please try again.';
                    $returnValue["result"] = 'failed';
                    echo json_encode($returnValue);
                    die;
                }
            }
        }
    }

    public function ridespoints() {

        $ride_points = json_decode($this->input->get_post('ride_points'), 1);

        if (is_array($ride_points) && count($ride_points) > 0) {
            $i = 0;
            foreach ($ride_points as $key => $value) {

                if (isset($ride_points[$key]['ride_id']) && $ride_points[$key]['ride_id'] != '') {
                    $this->db->insert('m_ride_points', $value);
                    $i = 1;
                }
            }
            if ($i == 1) {
                $returnValue["status"] = "200";
                $returnValue["message"] = 'Ride points inserted successfully';
                $returnValue["result"] = 'success';
                echo json_encode($returnValue);
                die;
            } else {

                
                $returnValue["message"] = 'Ride id can not be empty or Some thing went wrough! Please try again.';
                $returnValue["result"] = 'failed';
                echo json_encode($returnValue);
                die;
            }
        } else {

           
            $returnValue["message"] = 'Data format not valid! Please send valid format.';
            $returnValue["result"] = 'failed';
            echo json_encode($returnValue);
            die;
        }
    }
    public function updateProfilePicture($image = false, $userName = false) {

        if ($image) {

            $data = $image;
            $img = str_replace('data:image/jpeg;base64,', '', $data);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file = CONTACT_UPLOADS_DIRECTORY_IMAGE.$image . '_' . uniqid() . '.jpeg';
            $filename = $userName . '_' . uniqid() . '.jpeg';
            @file_put_contents($file, $data);
            return $filename;
        } else {
            return false;
        }
    }
}
