<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Appsignin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('users_model','Users');
    }

    public function index() {


        $returnValue = array();
        if (empty($_REQUEST["userEmail"]) || empty($_REQUEST["userPassword"])) {
            $returnValue["status"] = "400";
            $returnValue["message"] = "Missing required information";
            echo json_encode($returnValue);
            return;
        }

        $userEmail = htmlentities($_REQUEST["userEmail"]);
        $userPassword = htmlentities($_REQUEST["userPassword"]);

        $userDetails = $this->Users->getAppUserByEmail($userEmail);


        if (empty($userDetails)) {
            $returnValue["status"] = "403";
            $returnValue["message"] = "User not found";
            echo json_encode($returnValue);
            return;
        }



        $userSecuredPassword = $userDetails["db_password"];
        $userSalt = $userDetails["salt"];
        $userPassword = hash('sha512', $userPassword . $userSalt);
        if ($userSecuredPassword == $userPassword) {
            $returnValue["status"] = "200";
            $returnValue["userFirstName"] = $userDetails["first_name"];
            $returnValue["userLastName"] = $userDetails["last_name"];
            $returnValue["userEmail"] = $userDetails["email"];
            $returnValue["userId"] = $userDetails["user_id"];
            $returnValue["userType"] = $userDetails["type"];
            $returnValue["register_date"] = $userDetails["register_date"];
            $returnValue["message"] = $userDetails["notes"];
        } else {
            $returnValue["status"] = "401";
            $returnValue["message"] = "Incorrect Password";
            echo json_encode($returnValue);
            return;
        }

        echo json_encode($returnValue);
    }

}
