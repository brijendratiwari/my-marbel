<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Email extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->model('email_model', "Emails");
        $this->load->model('users_model', "Users");

        if ($this->Users->auth_check() == false) {
            redirect('/login');
        }
    }

    public function index() {

        $data['page'] = 'Email';
        $data['title'] = 'Email';

        $mandrill = $this->get_mandrill();
        $data['templates'] = $this->get_templates($mandrill);

         /* send email */
        if ($this->input->post()) {

            $this->load->library('Mandrill');
            if ($this->input->post('to')) {
                $toArr = explode(',', $this->input->post('to'));
                $to = '';
                foreach ($toArr as $usrs) {
                    if (empty(trim($usrs))) {
                        continue;
                    }
                    if (!empty($to)) {
                        $to .= ', ';
                    }
                    $to .= trim($usrs);
                }
            }
            if ($this->input->post('template-only')) {
                $users = $this->Emails->getUserEmailData($to);
                   $data['users'] = $users;
            $data['to'] = $to;
//                echo '<pre>';
//                print_r($users);
//                die;
                $subject = $this->input->post('subject');
                if (!empty($users)) {
                    try {
                        $result = $this->sendTemplateEmail($this->input->post('template'), $users, $subject);
                        $this->session->set_flashdata('success','<div class="alert alert-success">Email has been sent to '.sizeof($result).' users</div>');
                    } catch (Mandrill_Error $e) {
                        $error = get_class($e) . ' - ' . $e->getMessage();
                        $this->session->set_flashdata('error','<div class="alert alert-success">'.$error.'</div>');
                    }
                }
            } else if ($this->input->post('body-only')) {
                $users = $this->Emails->getUserEmailData($to);
                   $data['users'] = $users;
            $data['to'] = $to;
                $subject = $this->input->post('subject');
                $body = $this->input->post('body');
                if (!empty($users)) {
                    try {
                        $result = $this->sendTemplateBodyEmail($this->input->post('template'), $users, $subject, $body);
                        $this->session->set_flashdata('success','<div class="alert alert-success">Email has been sent to '.sizeof($result).' users</div>');
                    } catch (Mandrill_Error $e) {
                        $error = get_class($e) . ' - ' . $e->getMessage();
                        $this->session->set_flashdata('error','<div class="alert alert-success">'.$error.'</div>');
                    }
                }
            }

            if ($this->input->post('custom_filters_country') || $this->input->post('custom_filters_start_date') || $this->input->post('custom_filters_end_date') || $this->input->post('custom_filters_status')) {
                $country = $this->input->post('custom_filters_country');
                $start_date = $this->input->post('custom_filters_start_date');
                $end_date = $this->input->post('custom_filters_end_date');
                $status = $this->input->post('custom_filters_status');
                $data['emails'] = $this->Emails->getEmails($country, $start_date, $end_date, $status);
            }
            
         
        }


        $this->load->template('admin/email', $data);
    }

    /* get templates */

    protected function get_templates($mandrill) {

        return $mandrill->templates->getList();
    }

    /* get maindrill object */

    protected function get_mandrill() {
        $this->load->library('Mandrill');
        return new Mandrill(MANDRILL_API_KEY);
    }


    protected function sendTemplateEmail($template_name, $to, $subject, $mergeVars = array()) {
        $mandrill = $this->get_mandrill();
        $template_content = array();
        $msgTo = array();
//        var_dump($to);die;
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

    protected function sendTemplateBodyEmail($template_name, $to, $subject, $body,$mergeVars = array()) {
		$mandrill = $this->get_mandrill();
		$template_content = array(
			array(
				'name' => 'body',
				'content' => $body
			)
		);
		$msgTo = array();
		foreach ($to as $user) {
			$msgTo[] = array(
				'email' => $user['email'],
				'name' => $user['first_name'].' '.$user['last_name'],
				'type' => 'to'
			);
		}
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
			'merge_vars' => $mergeVars
		);
		if ($emptyFrom) {
			$message['from_email'] = CONTACT_EMAIL;
		}
		$async = true;
		$ip_pool = 'Main Pool';
		$send_at = date("F j, Y, g:i a");
		return $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
	}
    
}
