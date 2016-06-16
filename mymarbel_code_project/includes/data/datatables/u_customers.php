<?php
 
require_once '../../functions.php';

    sleep(1); 
    $pk = $_POST['pk'];
    if(!empty($pk)) {
        deleteUser($pk, $db);
    } else {
        header('HTTP 400 Bad Request', true, 400);
        echo "This field is required!";
    }
?>
 