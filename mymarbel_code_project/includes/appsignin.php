<?php 
include_once 'functions.php';


$returnValue = array();
if(empty($_REQUEST["userEmail"]) || empty($_REQUEST["userPassword"]))
{
    $returnValue["status"]="400";
    $returnValue["message"]="Missing required information";
    echo json_encode($returnValue);
    return;
}

$userEmail = htmlentities($_REQUEST["userEmail"]);
$userPassword = htmlentities($_REQUEST["userPassword"]);

$userDetails = getAppUserByEmail($userEmail, $db);


if(empty($userDetails))
{
    $returnValue["status"]="403";
    $returnValue["message"]="User not found";
    echo json_encode($returnValue);
    return;   
}

 

$userSecuredPassword = $userDetails["db_password"];
$userSalt = $userDetails["salt"];
$userPassword = hash('sha512', $userPassword . $userSalt);
if($userSecuredPassword == $userPassword)
{
    $returnValue["status"]="200";
    $returnValue["userFirstName"] = $userDetails["first_name"];
    $returnValue["userLastName"] = $userDetails["last_name"];
    $returnValue["userEmail"] = $userDetails["email"];
    $returnValue["userId"] = $userDetails["user_id"];
	$returnValue["userType"] = $userDetails["type"];
	$returnValue["register_date"] = $userDetails["register_date"];
	$returnValue["message"]= n;
	
} else {
    $returnValue["status"]="401";
    $returnValue["message"]="Incorrect Password";
    echo json_encode($returnValue);
    return;
}

echo json_encode($returnValue);

?>