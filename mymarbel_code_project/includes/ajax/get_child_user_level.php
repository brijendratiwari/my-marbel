<?php
require_once '../functions.php';
$id = $_POST['id'];
$getChildLevelUsers = getChildLevelUsers($id, $db);
if ($getChildLevelUsers > 0) {
   
    echo json_encode($getChildLevelUsers);
}  
?>