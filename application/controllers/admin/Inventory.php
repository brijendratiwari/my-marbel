<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('customers_model', "Customer");
        $this->load->model('users_model', "Users");
        $this->load->model('shipping_model', "Shipping");
        $this->load->model('services_model', "Services");
        $this->load->model('inventory_model', "inventory");
        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
        if ($this->session->userdata['marbel_user']['type'] != 'admin') {
            redirect('logout');
        }
    }

    public function index() {
        $this->data['page'] = 'Inventory';
        $this->data['title'] = 'Inventory Explainer';
        $userid = $this->session->userdata['marbel_user']['user_id'];
        $this->load->template('admin/inventory/inventory', $this->data);
    }

    public function get_part() {
        $sLimit = "";
        $lenght = 10;
        $str_point = 0;
        $id_to = $this->session->userdata['marbel_user']['user_id'];

        $col_sort = array("m_part.part_id", "m_part.part_unique_number", "m_part.part_name", "part_category_name", "part_type_name", "m_part.part_quantity", "m_part.part_cost", "part_manufacturer");

        $order_by = "m_part.part_id";
        $temp = 'Desc';

        if (isset($_GET['iSortCol_0'])) {
            $index = $_GET['iSortCol_0'];
            $temp = $_GET['sSortDir_0'] === 'asc' ? 'asc' : 'desc';
            $order_by = $col_sort[$index];
        }
        $this->inventory->db->select("m_part.part_id,m_part.part_unique_number,m_part.part_name,m_part.part_cost,m_part.part_quantity,m_part.part_manufacturer,part_category_name,part_type_name");


        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->inventory->db->or_like($col_sort[$i], $words, "both");
            }
        }

        $this->inventory->db->order_by($order_by, $temp);

        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $str_point = intval($_GET['iDisplayStart']);
            $lenght = intval($_GET['iDisplayLength']);
            $this->db->join('m_part_categories', 'm_part_categories.part_category_id=part_category', 'left');
            $this->db->join('m_part_type', 'm_part_type.part_type_id=part_type', 'left');
            $this->db->where('part_user_id', $id_to);
            $records = $this->inventory->db->get("m_part", $lenght, $str_point);
        } else {
            $this->db->join('m_part_categories', 'm_part_categories.part_category_id=part_category', 'left');
            $this->db->join('m_part_type', 'm_part_type.part_type_id=part_type', 'left');
            $this->db->where('part_user_id', $id_to);
            $records = $this->inventory->db->get("m_part");
        }

        $this->inventory->db->select('*');
        $this->inventory->db->from('m_part');
        $this->db->join('m_part_categories', 'm_part_categories.part_category_id=part_category', 'left');
        $this->db->join('m_part_type', 'm_part_type.part_type_id=part_type', 'left');
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $words = $_GET['sSearch'];
            for ($i = 0; $i < count($col_sort); $i++) {

                $this->inventory->db->or_like($col_sort[$i], $words, "both");
            }
        }
        $total_record = $this->inventory->db->count_all_results();
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $total_record,
            "iTotalDisplayRecords" => $total_record,
            "aaData" => array()
        );

        $result = $records->result_array();

        $i = 0;
        $final = array();
        foreach ($result as $val) {

            $output['aaData'][] = array("DT_RowId" => $val['part_id'], '<a class="btn btn-xs btn-info" href="' . base_url() . 'inventory/view/' . $val['part_id'] . '" data-id="' . $val['part_id'] . '"><i class="fa fa-eye"></i></a>', $val['part_unique_number'], $val['part_name'], ucfirst($val['part_category_name']), ucfirst($val['part_type_name']), $val['part_quantity'], $val['part_cost'], $val['part_manufacturer'], ' <a class="btn btn-xs btn-success" href="' . base_url() . 'inventory/edit/' . $val['part_id'] . '" data-id="' . $val['part_id'] . '"><i class="fa fa-edit"></i></a>');
        }

        echo json_encode($output);
        die;
    }

    public function addPart() {

        $this->data['page'] = "New Part";
        $tis->data['title'] = "New Part";
        $this->data['part_category'] = $this->inventory->getPartCategory();
        $this->data['part_type'] = $this->inventory->getPartType();
        $this->data['random_number'] = mt_rand(100000, 999999);
        $this->data["style_to_load"] = array("assets/css/chosen/chosen.min.css", "assets/css/switch/bootstrap-switch.min.css");
        $this->data['scripts_to_load'] = array("assets/js/chosen/chosen.jquery.min.js", "assets/js/jquery.number.min.js", "assets/js/switch/bootstrap-switch.min.js", "assets/js/jquery.form.min.js");

        if ($this->input->post()) {
            $input = $this->input->post();
            $this->form_validation->set_rules('part_name', 'Name', 'required');
            $this->form_validation->set_rules('part_description', 'Description', 'required');
            $this->form_validation->set_rules('part_category', 'Category', 'required');
            $this->form_validation->set_rules('part_type', 'Type', 'required');
            $this->form_validation->set_rules('part_quantity', 'Quantity', 'required|numeric');
            $this->form_validation->set_rules('part_reorder_quantity', 'Reorder Quantity', 'numeric');
            $this->form_validation->set_rules('part_cost', 'Cost', 'required');
            $this->form_validation->set_rules('part_weight', 'Weight', 'required');
            $this->form_validation->set_rules('part_lead_time', 'Lead Time', 'required|numeric');
            $this->form_validation->set_rules('part_manufacturer', 'Manufacturer', 'required');
            $this->form_validation->set_rules('part_manufacturer_contact', 'Manufacturer Contact', 'required');
            $this->form_validation->set_rules('part_notes', 'Notes', 'required');
            $this->form_validation->set_rules('part_last_order', 'Last Order', 'required');
            $this->form_validation->set_rules('part_image', 'Image', 'callback_image_validate');
            if (isset($input['part_auto_reorder'])) {
                $this->form_validation->set_rules('part_reorder_quantity', 'Reorder Quantity', 'required');
            } else {
                $input['part_auto_reorder'] = 0;
            }
            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
            if ($this->form_validation->run() == FALSE) {

                $this->load->template('admin/inventory/add_part', $this->data);
            } else {


                $input['part_user_id'] = $this->session->userdata['marbel_user']['user_id'];
                $input['created_at'] = date('Y-m-d H:i:s');
                if (isset($input['part_auto_reorder'])) {
                    $input['part_auto_reorder'] = 1;
                } else {
                    $input['part_auto_reorder'] = 0;
                }
                if (!empty($_FILES)) {
                    if (isset($_FILES['part_image']['name'])) {
                        $filename = explode('.', $_FILES['part_image']['name']);
                        $image = time() . '_' . $_FILES['part_image']['name'];
                        move_uploaded_file($_FILES['part_image']['tmp_name'], './assets/inventory-imgs/' . basename($image));
                    }
                    $input['part_image'] = $image;
                }

                $insert_id = $this->inventory->addPart($input);
                if ($insert_id) {
                    $this->session->set_flashdata('success', 'Part Added Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong');
                }
                redirect('inventory');
            }
        } else {


            $this->load->template('admin/inventory/add_part', $this->data);
        }
    }

    public function image_validate() {
        if (($_FILES['part_image']['size'] > 0)) {

            if ($_FILES['part_image']['type'] == 'image/jpeg' || $_FILES['part_image']['type'] == 'image/png' || $_FILES['part_image']['type'] == 'image/jpg') {
                return true;
            } else {
                $this->form_validation->set_message('image_validate', 'Part Image must be jpeg,png or jpg ');
                return false;
            }
        } else {
            return TRUE;
        }
    }

    public function view_part($id) {
        $this->data['page'] = "View Part";
        $this->data['title'] = "View Part";
        if ($id > 0) {
            $this->data['part_detail'] = $this->inventory->getPartDetail($id);
        } else {
            $this->data['part_detail'] = array();
        }
        $this->data['user_detail'] = $this->session->userdata['marbel_user'];
        $this->load->template('admin/inventory/view_part', $this->data);
    }

    public function edit_part($id) {
        $this->data['page'] = "Edit Part";
        $this->data['title'] = "Edit Part";
        if ($id > 0) {
            $this->data['part_detail'] = $this->inventory->getPartDetail($id);
            $this->data['part_category'] = $this->inventory->getPartCategory();
            $this->data['part_type'] = $this->inventory->getPartType();
            $this->data["style_to_load"] = array("assets/css/chosen/chosen.min.css", "assets/css/switch/bootstrap-switch.min.css");
            $this->data['scripts_to_load'] = array("assets/js/chosen/chosen.jquery.min.js", "assets/js/jquery.number.min.js", "assets/js/switch/bootstrap-switch.min.js", "assets/js/jquery.form.min.js");

            if ($this->input->post()) {
                $input = $this->input->post();
                $this->form_validation->set_rules('part_name', 'Name', 'required');
                $this->form_validation->set_rules('part_description', 'Description', 'required');
                $this->form_validation->set_rules('part_category', 'Category', 'required');
                $this->form_validation->set_rules('part_type', 'Type', 'required');
                $this->form_validation->set_rules('part_quantity', 'Quantity', 'required|numeric');
                $this->form_validation->set_rules('part_reorder_quantity', 'Reorder Quantity', 'numeric');
                $this->form_validation->set_rules('part_cost', 'Cost', 'required');
                $this->form_validation->set_rules('part_weight', 'Weight', 'required');
                $this->form_validation->set_rules('part_lead_time', 'Lead Time', 'required|numeric');
                $this->form_validation->set_rules('part_manufacturer', 'Manufacturer', 'required');
                $this->form_validation->set_rules('part_manufacturer_contact', 'Manufacturer Contact', 'required');

                $this->form_validation->set_rules('part_notes', 'Notes', 'required');
                $this->form_validation->set_rules('part_last_order', 'Last Order', 'required');
                $this->form_validation->set_rules('part_image', 'Image', 'callback_image_validate');
                if (isset($input['part_auto_reorder'])) {
                    $this->form_validation->set_rules('part_reorder_quantity', 'Reorder Quantity', 'required');
                } else {
                    $input['part_auto_reorder'] = 0;
                }
                $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
                if ($this->form_validation->run() == FALSE) {
                    $this->load->template('admin/inventory/edit_part', $this->data);
                } else {

                    if (isset($input['part_auto_reorder'])) {
                        $input['part_auto_reorder'] = 1;
                    } else {
                        $input['part_auto_reorder'] = 0;
                    }
                    if (!empty($_FILES)) {
                        if (isset($input['pervious_image'])) {
                            $pervious_image = $input['pervious_image'];
                        } else {
                            $pervious_image = '';
                        }
                        if (array_key_exists('part_image', $_FILES) && ($_FILES['part_image']['size'] > 0)) {
                            IF ($pervious_image != '') {
                                $path = "./assets/inventory-imgs/$pervious_image";
                                if (file_exists($path)) {
                                    chmod($path, 0777);
                                    unlink($path);
                                }
                            }
                            $filename = explode('.', $_FILES['part_image']['name']);
                            $image = time() . '_' . $_FILES['part_image']['name'];
                            move_uploaded_file($_FILES['part_image']['tmp_name'], './assets/inventory-imgs/' . basename($image));
                            $input['part_image'] = $image;
                        } else {
                            $input['part_image'] = $pervious_image;
                        }
                    }
                    unset($input['pervious_image']);
                    $insert_id = $this->inventory->updatePart($id, $input);
                    if ($insert_id) {
                        $this->session->set_flashdata('success', 'Part Updated Successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Something went wrong');
                    }
                    redirect('inventory');
                }
            } else {


                $this->load->template('admin/inventory/edit_part', $this->data);
            }
        } else {
            redirect('inventory');
        }
    }

    public function update_image() {
        if ($this->input->post()) {
            if (!empty($_FILES)) {
                $this->form_validation->set_rules('part_image', 'Image', 'callback_image_validate');
                if ($this->form_validation->run() == FALSE) {
                    //validation fails
                    $this->form_validation->set_error_delimiters('', '');
                    $error = $this->form_validation->error_array();
                    $result['result'] = false;
                    $result['error'] = $error;
                    echo json_encode($result);
                    die;
                } else {
                    $pervious_image = $this->input->post('pervious_image');
                    if (array_key_exists('part_image', $_FILES) && ($_FILES['part_image']['size'] > 0)) {
                        IF ($pervious_image != '') {
                            $path = "./assets/inventory-imgs/$pervious_image";
                            if (file_exists($path)) {
                                chmod($path, 0777);
                                unlink($path);
                            }
                        }
                        $filename = explode('.', $_FILES['part_image']['name']);
                        $image = time() . '_' . $_FILES['part_image']['name'];
                        move_uploaded_file($_FILES['part_image']['tmp_name'], './assets/inventory-imgs/' . basename($image));
                        $updatedata['part_image'] = $image;
                    } else {
                        $updatedata['part_image'] = $pervious_image;
                    }
                    $updatedata['part_id'] = $this->input->post('part_id');
                    $res = $this->inventory->update_image($updatedata);
                    if ($res == 1) {
                        $result['result'] = TRUE;
                        $result['image_name'] = $updatedata['part_image'];
                    } else {
                        $result['result'] = FALSE;
                        $result['image_name'] = $updatedata['part_image'];
                    }
                    echo json_encode($result);
                    die;
                }
            }
        }
    }

    public function createEventCron() {

        $parts = $this->inventory->getAll();
        if (!empty($parts)) {
            foreach ($parts as $val) {
                if($val['part_auto_reorder']==1){
                if ($val['part_quantity'] <= $val['part_reorder_quantity']) {
                    $this->CreateReorderEvent($val);
                }
                }
            }
        }
       
    }
    
    public function createReorderEvent($part_array){
         if (!empty($part_array)) {
            $date_time = '';
            $timezone = "+05:30";
            $start_date = date('Y-m-d');
            $start_time = date('H:i:s');
            $date_time = $start_date . 'T' . $start_time . $timezone;
            $eventdata = array(
                'title' => 'Part Reorder',
                'description' => "Part Number $part_array[part_unique_number] get to low",
                'event_type' => 11,
                'event_created_by' => $part_array['part_user_id'],
                'startdate' => $date_time,
                'enddate' => $date_time,
                'start_date' => date('Y-m-d H:i:s'),
                'end_date' => date('Y-m-d H:i:s'),
            );
            $this->inventory->addEvent($eventdata);
            return TRUE;
        }
    }

}
