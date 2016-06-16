<?php
require_once '../../functions.php';

$table = 'm_orders';

$primaryKey = '`o`.id';

$columns = array(
    array( 'db' => '`o`.id', 'dt' => 'id', 'field' => 'id' ),
    array( 'db' => '`u`.first_name', 'dt' => 'first_name', 'field' => 'first_name' ),
    array( 'db' => '`u`.last_name',  'dt' => 'last_name', 'field' => 'last_name' ),
	array( 'db' => '`o`.tracking_number',  'dt' => 'tracking_number', 'field' => 'tracking_number' ),
    array( 'db' => '`o`.order_status',  'dt' => 'order_status', 'field' => 'order_status', 
        'formatter' => function ($d, $row) { 
            return ucfirst($d);
        }),
    array( 'db' => '`o`.order_date',  'dt' => 'order_date', 'field' => 'order_date', 
        'formatter' => function($d, $row) {
            return date('M j, Y', $d);
        }),
    array( 'db' => '`o`.order_status',  'dt' => 'order_status', 'field' => 'order_status' ),
    array( 'db' => '`mol`.date',  'dt' => 'date', 'field' => 'date', 
        'formatter' => function($d, $row) {
            return date('M j, Y', strtotime($d));
        }),
    );

$sql_details = array(
    'user' => SQL_USER,
    'pass' => SQL_PASSWORD,
    'db'   => SQL_DATABASE,
    'host' => SQL_HOST
    );

require( '../../utils/datatables/ssp.class.php' );
echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, "FROM `{$table}` AS `o` LEFT JOIN `m_users` AS `u` ON (`u`.`id` = `o`.`user_id`) LEFT JOIN (SELECT order_id, date FROM `m_order_logs` WHERE notes LIKE '%to \"shipped\"%' ORDER BY date DESC ) mol ON (mol.order_id = o.id)", ' order_status = \'shipped\'')
    );
?>