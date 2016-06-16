<?php
require_once '../../functions.php';

$table = 'm_users';
 
$primaryKey = 'id';

$columns = array(
    array( 'db' => 'id', 'dt' => 'id' ),
    array( 'db' => 'email', 'dt' => 'email' ),
    array( 'db' => 'first_name', 'dt' => 'first_name' ),
    array( 'db' => 'last_name',  'dt' => 'last_name' ),
    array( 'db' => 'type',  'dt' => 'type' ),
    array(
        'db'        => 'register_date',
        'dt'        => 'register_date',
        'formatter' => function( $d, $row ) {
            return date('M j, Y', $d);
        }
    ),
    array(
        'db'        => 'last_activity',
        'dt'        => 'last_activity',
        'formatter' => function( $d, $row ) {
            return date("M j, Y", $d);
        }
    ),
    array( 'db' => 'phone',  'dt' => 'phone', 
        'formatter' => function ($d, $row) {
            return preg_replace("/[^0-9]/","",$d);
        } ),
    array( 'db' => 'notes',  'dt' => 'notes' ),
);
 
$sql_details = array(
    'user' => SQL_USER,
    'pass' => SQL_PASSWORD,
    'db'   => SQL_DATABASE,
    'host' => SQL_HOST
);
 
require( '../../utils/datatables/ssp.class.php' );
echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
);
?>