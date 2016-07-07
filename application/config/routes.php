<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['logout'] = 'login/logout';

$route['admin'] = 'admin/customers';


$route['resetPassword/(:any)/(:any)'] = 'login/reset_password/$1/$2';


$route['customers'] = 'admin/customers';
$route['customer_list'] = 'admin/customers/get_customers';
$route['add_customer'] = 'admin/customers/add_customer';
$route['edit_customer'] = 'admin/customers/edit_customer';
$route['edit_customer/(:num)'] = 'admin/customers/edit_customer/$1';
$route['deleteCustomer/(:num)'] = 'admin/customers/delete_customer/$1';
$route['get_customer_info/(:num)'] = 'admin/customers/get_customer_info/$1';
$route['reset_password_users'] = 'admin/customers/reset_password_users';
$route['send_password_email/(:num)'] = 'admin/customers/send_password_email/$1';
$route['send_password_email_profile/(:num)'] = 'admin/customers/send_password_email_profile/$1';


$route['get_child_user_level'] = 'admin/customers/get_child_user_level';


$route['orders'] = 'admin/orders';
$route['order_list'] = 'admin/orders/get_orders';
$route['add_order'] = 'admin/orders/add_order';
$route['edit_order/(:num)'] = 'admin/orders/edit_order/$1';
$route['delete_order/(:num)'] = 'admin/orders/delete_order/$1';
$route['update_orders'] = 'admin/orders/update_order_estimated_shipping_date';

$route['forgot_password']='login/forgot_password';

$route['profile'] = 'admin/profile';
$route['edit_profile'] = 'admin/customers/edit_profile';
$route['edit_customer_profile'] = 'customer/profile/edit_profile';

$route['shipping']='admin/shipping';
$route['shipping_list']='admin/shipping/get_shipping';

$route['shipped']='admin/shipped';
$route['shipped_list']='admin/shipped/get_shipped';

$route['services']='admin/services';
$route['services_list']='admin/services/get_services';
$route['new_services']='admin/services/new_services';
$route['new_services/(:any)/(:num)']='admin/services/new_services/$1/$2';
$route['new_services/(:any)/(:any)/(:any)']='admin/services/new_services/$1/$2/$3';
$route['new_services/(:num)/(:num)']='admin/services/new_services/$1/$2';
$route['new_services/(:num)']='admin/services/new_cust_services/$1';
$route['edit_service/(:num)/(:any)']='admin/services/edit_service/$1/$2';
$route['delete_services/(:num)/(:any)']='admin/services/delete_services/$1/$2';
$route['order_service/(:num)/(:num)']='admin/services/new_order_service/$1/$2';

$route['calendar']='admin/calendar';
$route['process']='admin/calendar/process';
$route['add_event']='admin/calendar/add_event';
$route['update_event']='admin/calendar/update_event/$1';
$route['delete_event/(:num)']='admin/calendar/event_delete/$1';

$route['email']='admin/email';
$route['send_email']='admin/email/send_email';

$route['customer'] = 'customer/dashboard';
$route['customer_profile'] = 'customer/profile';
$route['reset_password_customer'] = 'customer/profile/reset_password_customer';

$route['order']='customer/order';
$route['order_edit/(:num)']='customer/order/edit_order/$1';

$route['ride_reports']='customer/ridereports';

$route['support']='customer/support';
$route['upload']='customer/support/upload';

$route['tasks']='admin/tasks';
$route['add_task']='admin/tasks/add_task';
$route['edit_task/(:num)']='admin/tasks/edit_task/$1';
$route['update_task/(:num)']='admin/tasks/update_task/$1';
$route['get_task_assign_to_me']='admin/tasks/get_task_assign_to_me';
$route['get_task_assign_by_me']='admin/tasks/get_task_assign_by_me';
$route['get_task_completed_to_me']='admin/tasks/get_task_completed_to_me';
$route['get_completed_task_assign_by_me']='admin/tasks/get_completed_task_assign_by_me';

/*api  */
$route['saveuserinformation']='appsignin/save_user_information';
/*....api*/
