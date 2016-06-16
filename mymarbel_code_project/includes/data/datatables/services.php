<?php
require_once '../../functions.php';

$table = 'm_services';
if (isset($_GET['status'])) {
    $status = $_GET['status'];
} else {
    $status = 'finished';
}
$primaryKey = '`s`.id';

$columns = array(
    array( 'db' => '`s`.id', 'dt' => 'id', 'field' => 'id' ),
    array(
        'db'        => '`s`.qa_date',
        'dt'        => 'qa_date',
        'field'     => 'qa_date',
        'formatter' => function( $d, $row ) {
            return date('M j, Y', $d);
        }
    ),
    array(
        'db'        => '`s`.due_date',
        'dt'        => 'due_date',
        'field'     => 'due_date',
        'formatter' => function( $d, $row ) {
            return date('M j, Y', time($d));
        }
    ),
    array(
        'db'        => '`s`.date',
        'dt'        => 'date',
        'field'     => 'date',
        'formatter' => function( $d, $row ) {
            return date('M j, Y', strtotime($d));
        }
    ),
    array( 'db' => '`o`.user_id', 'dt' => 'user_id', 'field' => 'user_id' ),
    array( 'db' => '`u`.first_name', 'dt' => 'first_name', 'field' => 'first_name' ),
    array( 'db' => '`u`.last_name',  'dt' => 'last_name', 'field' => 'last_name' ),
    array( 'db' => '`s`.priority',  'dt' => 'priority', 'field' => 'priority' ),
    array( 'db' => '`s`.status',  'dt' => 'status', 'field' => 'status', 'formatter' => function ($d, $row) { return ucfirst($d); }),
    array( 'db' => '`s`.suggested_response',  'dt' => 'suggested_response', 'field' => 'suggested_response'),
    array( 'db' => '`s`.tracking_out',  'dt' => 'tracking_number', 'field' => 'tracking_number'),
	array( 'db' => '`s`.order_id',  'dt' => 'order_id', 'field' => 'order_id'),
    array( 'db' => '`s`.tracking_in',  'dt' => 'tracking_in', 'field' => 'tracking_in')
	
);
 
$sql_details = array(
    'user' => SQL_USER,
    'pass' => SQL_PASSWORD,
    'db'   => SQL_DATABASE,
    'host' => SQL_HOST
);
 
require( '../../utils/datatables/ssp.class.php' );
echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, "FROM `{$table}` AS `s` LEFT JOIN `m_orders` AS `o` ON (`o`.`id` = `s`.`order_id`) LEFT JOIN `m_users` AS `u` ON (`u`.`id` = `o`.`user_id`)", sprintf("s.status = '%s'". (strcmp($status, 'inhouse') == 0 ? "OR s.status = 'onhold'" : ''), $status))
);
?>