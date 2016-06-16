<?php
require_once '../../functions.php';

$table = 'm_orders';
 
$primaryKey = '`o`.id';

$columns = array(
    array( 'db' => '`o`.id', 'dt' => 'id', 'field' => 'id' ),
    array( 'db' => '`o`.order_number',  'dt' => 'order_number', 'field' => 'order_number', 
        'formatter' => function ($d, $row) { 
            if (isset($d)) {
                return $d;
            }
            return 'Unknown';
        }),
    array(
        'db'        => '`o`.order_date',
        'dt'        => 'order_date',
        'field' => 'order_date',
        'formatter' => function( $d, $row ) {
            return date('M j, Y', $d);
        }
    ),
    array( 'db' => '`u`.first_name', 'dt' => 'first_name', 'field' => 'first_name' ),
    array( 'db' => '`u`.last_name',  'dt' => 'last_name', 'field' => 'last_name' ),
    array( 'db' => '`o`.order_status',  'dt' => 'order_status', 'field' => 'order_status', 
        'formatter' => function ($d, $row) { 
            return ucfirst($d);
        } ),
    array( 'db' => '`o`.est_ship_date',  'dt' => 'est_ship_date', 'field' => 'est_ship_date',
        'formatter' => function( $d, $row ) {
            if ($d == 0) { return $d; }
            if (intval(date('his', $d)) == 120000 && intval(date('j', $d)) == 1) { return 'in '.date('M, Y', $d);}
            return 'by '.date('M j, Y', $d);
        }),
    array( 'db' => '`o`.tracking_number',  'dt' => 'tracking_number', 'field' => 'tracking_number'),
    array( 'db' => '`o`.order_total',  'dt' => 'order_total', 'field' => 'order_total',
        'formatter' => function($d, $row) {
            setlocale(LC_MONETARY, 'en_US.UTF-8');
            return money_format('%.2n', $d);
        } )
);
 
$sql_details = array(
    'user' => SQL_USER,
    'pass' => SQL_PASSWORD,
    'db'   => SQL_DATABASE,
    'host' => SQL_HOST
);
 
require( '../../utils/datatables/ssp.class.php' );
echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, "FROM `{$table}` AS `o` LEFT JOIN `m_users` AS `u` ON (`u`.`id` = `o`.`user_id`)" )
);
?>