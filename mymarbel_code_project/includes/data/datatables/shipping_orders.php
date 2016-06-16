<?php
require_once '../../functions.php';

$table = 'm_orders';

$primaryKey = '`o`.id';

$columns = array(
    array( 'db' => '`o`.id', 'dt' => 'id', 'field' => 'id' ),
    array( 'db' => '`u`.first_name', 'dt' => 'first_name', 'field' => 'first_name' ),
    array( 'db' => '`u`.last_name',  'dt' => 'last_name', 'field' => 'last_name' ),
	array( 'db' => '`o`.wheel_color', 'dt' => 'wheel_color', 'field' => 'wheel_color' ),
	array( 'db' => '`o`.wheel_size', 'dt' => 'wheel_size', 'field' => 'wheel_size' ),
	array( 'db' => '`o`.priority', 'dt' => 'priority', 'field' => 'priority' ),
	 array( 'db' => '`u`.last_activity',  'dt' => 'last_activity', 'field' => 'last_activity',
	   'formatter' => function($d, $row) {
            return date('M j, Y', $d);
        }),
    array( 'db' => '`o`.order_status',  'dt' => 'order_status', 'field' => 'order_status', 
        'formatter' => function ($d, $row) { 
            return ucfirst($d);
        }),
    array( 'db' => '`o`.order_date',  'dt' => 'order_date', 'field' => 'order_date', 
        'formatter' => function($d, $row) {
            return date('M j, Y', $d);
        }),
    array( 'db' => '`o`.est_ship_date',  'dt' => 'est_ship_date', 'field' => 'est_ship_date',
        'formatter' => function( $d, $row ) {
            if ($d == 0) { return 'None'; }
            if (intval(date('his', $d)) == 120000 && intval(date('j', $d)) == 1) { return 'in '.date('M, Y', $d);}
            return 'by '.date('M j, Y', $d);
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
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, "FROM `{$table}` AS `o` LEFT JOIN `m_users` AS `u` ON (`u`.`id` = `o`.`user_id`)", 'est_ship_date > 0 AND order_status != \'refunded\' AND country = "US" AND order_status != \'deposit\' AND order_status != \'hold\' AND order_status != \'shipped\'')
    );
?>