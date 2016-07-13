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
            $returnValue["data"] = array();
            $returnValue["status"] = "400";
            $returnValue["message"] = "Missing required information";
            $returnValue["result"] = "No Information found.";
            
            echo json_encode($returnValue); die;
            
        }

        $userEmail = htmlentities($_REQUEST["userEmail"]);
        $userPassword = htmlentities($_REQUEST["userPassword"]);

        $userDetails = $this->Users->getAppUserByEmail($userEmail);
       
         if (empty($userDetails)) {
             $returnValue["data"] = array();
            $returnValue["status"] = "403";
            $returnValue["message"] = "User not found";
            $returnValue["result"] = "No Information found.";
            
            echo json_encode($returnValue); die;
         
        }

        $userSecuredPassword = $userDetails["db_password"];
        $userSalt = $userDetails["salt"];
        $userPassword = hash('sha512', $userPassword . $userSalt);
        if ($userSecuredPassword == $userPassword) {
            if($userDetails["user_profile_pic"]!=''){
                
                 $user_profile=base_url('assets/profile-imgs/'.$userDetails["user_profile_pic"]);
            }else{
                
                $user_profile='';
            }
            
            $returnValue["data"]["userFirstName"] = $userDetails["first_name"];
            $returnValue["data"]["userLastName"] = $userDetails["last_name"];
            $returnValue["data"]["userEmail"] = $userDetails["email"];
            $returnValue["data"]["userId"] = $userDetails["user_id"];
            $returnValue["data"]["userType"] = $userDetails["type"];
            $returnValue["data"]["register_date"] = $userDetails["register_date"];
            $returnValue["data"]["userEmailSecondary"] = $userDetails["email_secondary"];
            $returnValue["data"]["userBio"] = $userDetails["bio"];
            $returnValue["data"]["height"] = $userDetails["height"];
            $returnValue["data"]["weight"] = $userDetails["weight"];
            $returnValue["data"]["terrain"] = $userDetails["terrain"];
            $returnValue["data"]["company"] = $userDetails["company"];
            $returnValue["data"]["addressOne"] = $userDetails["address_one"];
            $returnValue["data"]["addressTwo"] = $userDetails["address_two"];
            $returnValue["data"]["city"] = $userDetails["city"];
            $returnValue["data"]["stateRegion"] = $userDetails["state_or_region"];
            $returnValue["data"]["postalCode"] = $userDetails["postal_code"];
            $returnValue["data"]["country"] = $userDetails["country"];
            $returnValue["data"]["alias"] = $userDetails["alias"];
            $returnValue["data"]["privacySetting"] = $userDetails["privacy_setting"];
            $returnValue["data"]["units"] = $userDetails["units"];
            $returnValue["data"]["rangeAlarm"] = $userDetails["range_alarm"];
            $returnValue["data"]["notification"] = $userDetails["notifications"];
            $returnValue["data"]["primaryRidingStyle"] = $userDetails["primary_riding_style"];
            $returnValue["data"]["safetyBrake"] = $userDetails["safety_brake"];
            $returnValue["data"]["preferredBrakingForce"] = $userDetails["preferred_braking_force"];
            $returnValue["data"]["reverseTurned"] = $userDetails["reverse_turned"];
            $returnValue["data"]["lockedSettings"] = $userDetails["locked_settings"];
            $returnValue["data"]["parentalLock"] = $userDetails["parental_lock"];
            $returnValue["data"]["linkedinHandle"] = $userDetails["linkedin_handle"];
            $returnValue["data"]["instagramHandle"] = $userDetails["instagram_handle"];
            $returnValue["data"]["redditHandle"] = $userDetails["reddit_handle"];
            $returnValue["data"]["noteOrders"] = $userDetails["note_orders"];
            $returnValue["data"]["noteServices"] = $userDetails["note_services"];
            $returnValue["data"]["noteTasks"] = $userDetails["note_tasks"];
            $returnValue["data"]["noteSupportTicket"] = $userDetails["note_support_ticket"];
            $returnValue["data"]["userProfilePicture"] =$user_profile;
            $returnValue["status"] = "200";
            $returnValue["message"] = "success";
            $returnValue["result"] = "User Information.";
            echo json_encode($returnValue); die;
            
            
        } else {
             $returnValue["data"] = array();
            $returnValue["status"] = "401";
            $returnValue["message"] = "Incorrect Password";
            $returnValue["result"] = "No Information found.";
           
            echo json_encode($returnValue); die;
      
        }
    
        
    }
    public function save_user_information(){
        $returnValue = array();
        $message='';
        $password='';
        $user_id='';
        if (empty($_REQUEST["userEmail"])) { $message='Email field is required.'; }
        if (empty($_REQUEST["userFirstName"])) {$message.='Firstname field is required.';}
        if (empty($_REQUEST["userLastName"])) {$message.='Lastname field is required.';}
        if (empty($_REQUEST["userType"])) {$message.='user type field is required.';}
        if($message!=''){
            
            $returnValue["status"] = "400";
            $returnValue["message"] = $message;
            echo json_encode($returnValue);
             die;
           
        }else{
                if(isset($_REQUEST['userId']))
                    $user_id=$_REQUEST['userId'];
            
                 if(isset($_REQUEST['password']))
                    $password=$_REQUEST['password'];
                
                if(isset($_REQUEST['userProfilePicture'])){
                    
                    $data=$_REQUEST['userProfilePicture'];
                    $img = str_replace('data:image/jpeg;base64,', '', $data);
                    $img = str_replace(' ', '+', $img);
                    $data = base64_decode($img);
                    $file = CONTACT_UPLOADS_DIRECTORY_IMAGE .$_REQUEST["userFirstName"].'_'.uniqid() . '.jpeg'; 
                    $filename= $_REQUEST["userFirstName"].'_'.uniqid() . '.jpeg';
                    @file_put_contents($file, $data);
                }else{
                    $filename=$this->Users->getUserImage($user_id);
                }
               
                    $data=array(
                            'first_name'=>(isset($_REQUEST['userFirstName']))?$_REQUEST['userFirstName']:'',
                            'last_name'=>(isset($_REQUEST['userLastName']))?$_REQUEST['userLastName']:'',
                            'email'=>(isset($_REQUEST['userEmail']))?$_REQUEST['userEmail']:'',
                            'type'=>(isset($_REQUEST['userType']))?$_REQUEST['userType']:'',
                             'notes'=>(isset($_REQUEST['message']))?$_REQUEST['message']:'',
                             'email_secondary'=>(isset($_REQUEST['email_secondary']))?:'',
                             'bio'=>(isset($_REQUEST['bio']))?$_REQUEST['bio']:'',
                             'height'=>(isset($_REQUEST['height']))?$_REQUEST['height']:'',
                             'weight'=>(isset($_REQUEST['weight']))?$_REQUEST['weight']:'',
                             'terrain'=>(isset($_REQUEST['terrain']))?$_REQUEST['terrain']:'',
                             'company'=>(isset($_REQUEST['company']))?$_REQUEST['company']:'',
                             'address_one'=>(isset($_REQUEST['addressOne']))?$_REQUEST['addressOne']:'',
                             'address_two'=>(isset($_REQUEST['addressTwo']))?$_REQUEST['addressTwo']:'',
                             'city'=>(isset($_REQUEST['city']))?$_REQUEST['city']:'',
                             'state_or_region'=>(isset($_REQUEST['stateRegion']))?$_REQUEST['stateRegion']:'',
                             'postal_code'=>(isset($_REQUEST['postalCode']))?$_REQUEST['postalCode']:'',
                             'country'=>(isset($_REQUEST['country']))?$_REQUEST['country']:'',
                             'privacy_setting'=>(isset($_REQUEST['privacySetting']))?$_REQUEST['privacySetting']:'',
                             'units'=>(isset($_REQUEST['units']))?$_REQUEST['units']:'',
                             'range_alarm'=>(isset($_REQUEST['rangeAlarm']))?$_REQUEST['rangeAlarm']:'',
                             'notifications'=>(isset($_REQUEST['notifications']))?$_REQUEST['notifications']:'',
                             'primary_riding_style'=>(isset($_REQUEST['primaryRidingStyle']))?$_REQUEST['primaryRidingStyle']:'',
                             'safety_brake'=>(isset($_REQUEST['safetyBrake']))?$_REQUEST['safetyBrake']:'',
                             'preferred_braking_force'=>(isset($_REQUEST['preferredBrakingForce']))?$_REQUEST['preferredBrakingForce']:'',
                             'reverse_turned'=>(isset($_REQUEST['reverseTurned']))?$_REQUEST['reverseTurned']:'',
                            'locked_settings'=>(isset($_REQUEST['lockedSettings']))?$_REQUEST['lockedSettings']:'',
                            'register_date'=>time(),
                            'user_profile_pic'=>$filename
                         );
                    if($user_id!=''){
                        
                         $this->db->where('id',$user_id);
                         $this->db->update('m_users',$data);
                         if($password!=''){
                             
                            $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                            $password = hash('sha512', $password . $random_salt);
                            $this->db->where('user_id',$user_id);
                            $this->db->update('m_user_auth',array('password'=>$password,'salt'=>$random_salt));
                         }
                         $returnValue["status"] = "200";
                         $returnValue["message"] = "User informatiom updated successfully .";
                         echo json_encode($returnValue);
                            die;

                    }else{
                         $check_email=$this->Users->checkUserEmail($_REQUEST["userEmail"]);
                         if($check_email==''){
                                $this->db->insert('m_users',$data);
                                $inser_id=$this->db->insert_id();
                                if($password!=''){

                                   $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
                                   $password = hash('sha512', $password . $random_salt);
                                   $user_auth = array('user_id'=>$inser_id,'password' => $password, 'salt' => $random_salt);
                                   $this->db->insert('m_user_auth', $user_auth);
                                }
                                $returnValue["status"] = "200";
                                $returnValue["message"] = "User informatiom added successfully.";
                                echo json_encode($returnValue);
                                die;
                         }else{
                    
                            $returnValue["status"] = "401";
                            $returnValue["message"] = "Email already exist.Please try with other email";
                            echo json_encode($returnValue);
                            die;
                           }
                        }
                
      
        }
        
    }
  public function create_ride(){
       $returnValue = array();
       $message='';
       if (empty($_REQUEST["board_id"])) { $message='Board id field is required.'; }
        if (empty($_REQUEST["ride_name"])) {$message.='Ride name field is required.';}
        
        if($message!=''){
            
            $returnValue["status"] = "400";
            $returnValue["message"] =$message;
            $returnValue["result"] = 'Validation Error!';
            echo json_encode($returnValue);
             die;
           
        }else
        {
            $ride=array(
                'board_ID'=>$_REQUEST["board_id"],
                'ride_name'=>$_REQUEST["ride_name"],
                'trip_distance'=>$_REQUEST["trip_distance"],
                'trip_duration'=>$_REQUEST["trip_duration"],
                'est_start_st'=>$_REQUEST["est_start_st"],
                'est_finish_st'=>$_REQUEST["est_finish_st"],
                'temp_f'=>$_REQUEST["temp_f"],
                'humidity'=>$_REQUEST["humidity"],
              );
            if(isset($_REQUEST["ride_ID"]) && $_REQUEST["ride_ID"]!=''){
                
                $this->db->where('ride_ID',$_REQUEST["ride_ID"]) ;
                $this->db->update('m_rides',$ride);
                if($this->db->affected_rows()>0){
                $returnValue["status"] = "200";
                $returnValue["message"] ='Ride updated successfully';
                $returnValue["result"] = 'success';
                echo json_encode($returnValue);
                 die;
                }else{
                    $returnValue["status"] = "400";
                    $returnValue["message"] ='Some thing went wrough ! please try again.';
                    $returnValue["result"] = 'failed';
                    echo json_encode($returnValue);
                    die;
                }
            }else{
                
                $this->db->insert('m_rides',$ride);
                if($this->db->insert_id()>0){
                    
                    $returnValue["status"] = "200";
                $returnValue["message"] ='Ride Inserted successfully';
                $returnValue["result"] = 'success';
                echo json_encode($returnValue);
                 die;
                }else{
                    $returnValue["status"] = "400";
                    $returnValue["message"] ='Some thing went wrough ! please try again.';
                    $returnValue["result"] = 'failed';
                    echo json_encode($returnValue);
                    die;
                }
            }
        }
  } 
}
