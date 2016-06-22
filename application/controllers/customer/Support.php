<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Support extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('customers_model', "Customer");
        $this->load->model('users_model', "Users");
        $this->load->model('services_model', "Services");
        $this->load->library('My_phpmailer');
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
    }
    public function index(){
        
        $this->data['page']="Support";
        $this->data['title']="Support";
      
        $this->load->customer('customer/support',$this->data);
    }
    public function upload(){
        $this->load->helper('my_mail');
        if($this->input->post('cd-notes') == ''){
            die('Please write something!!');
        }
        $orders = $this->Services->getOrders($this->session->userdata['marbel_user']['user_id']);
        if (isset($_FILES["file"]) && $_FILES["file"]["error"]== UPLOAD_ERR_OK) {
                    $uploadDirectory = CONTACT_UPLOADS_DIRECTORY;
                    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
                        die();
                    }

                    if ($_FILES["file"]["size"] > CONTACT_ALLOWED_FILESIZE) {
                        die("File size is too big!");
                    }

                    switch (strtolower($_FILES['file']['type'])) {
                        case 'image/png': 
                        case 'image/gif': 
                        case 'image/jpeg': 
                        case 'image/pjpeg':
                        case 'text/plain':
                        case 'text/html':
                        case 'application/x-zip-compressed':
                        case 'application/pdf':
                        case 'application/msword':
                        case 'application/vnd.ms-excel':
                        case 'video/mp4':
                        break;
                        default:
                        die('Unsupported File!'); 
                    }

                    $fileName = strtolower($_FILES['file']['name']);
                    $fileExt = substr($fileName, strrpos($fileName, '.'));
                    $rand = rand(0, 9999999999);
                    $newFileName = $this->session->userdata['marbel_user']['user_id'].'-'.$rand.$fileExt;
                    file_put_contents($uploadDirectory.'/data.log', $uploadDirectory.$newFileName."\n", FILE_APPEND);
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadDirectory.$newFileName )) {
                        $from = $this->session->userdata['marbel_user']['email'];
                        $fromName = $this->session->userdata['marbel_user']['first_name'].' '.$this->session->userdata['marbel_user']['last_name'];
                        $subject = $fromName.' has submitted a support form VIA '.base_url().'customer/support';
                        $text = "Message: ".$this->input->post('cd-notes')."\n\n";
                        $text .= "Uploaded Attachment: ".base_url('assets/uploads/'.$newFileName);
                        $mail = mymail('sandeep@ignisitsolutions.com',$subject, $text,FALSE,$from,$fromName);
                        if(!$mail) {
                            die ($mail);
                        } else {
                            die('Message has been sent');
                        }
                    } else {
                        die('Error uploading file!');
                    }    
        } else if ($this->input->post('cd-notes')) {
                $from = $this->session->userdata['marbel_user']['email'];
                $fromName = $this->session->userdata['marbel_user']['first_name'].' '.$this->session->userdata['marbel_user']['last_name'];
                $subject = $fromName.' has submitted a support form VIA'. base_url().'/customer/support';
                $text = "Message: ".$this->input->post('cd-notes')."\n\n";
//                $text .= "Orders:";
                $mail = mymail('sandeep@ignisitsolutions.com',$subject, $text,FALSE,$from,$fromName);
                        if(!$mail) {
                            die ($mail);
                        } else {
                            die('Message has been sent');
                        }
        } else {
                 die('Something wrong with upload!');
        }
    }
    
    
}