<?php
session_start();

if(isset($_POST['newJustification1']))
{
    include 'dbconnect.php';
    $sqlFetchID = "SELECT id FROM `resource` WHERE resource_ref=".$exceptionValue."";
    $result1 = mysqli_query($conn, $sqlFetchID);
    $resourceID = mysqli_fetch_array($result1);

    $sqlFetchID = "SELECT rule_id FROM `non_compliance` WHERE resource_id=".$resourceID."";
    $result2 = mysqli_query($conn, $sqlFetchID);
    $non_compliance_id = mysqli_fetch_array($result2);


    $newJustification = $_POST['newJustification'];
    $exceptionValue = $_POST['exceptionValue'];
    $exceptionId = $_POST['exceptionId'];
    $oldJustification = $_POST['oldJustification'];
    $oldReview = $_POST['oldReview'];
    $ruleId = $_POST['ruleId'];
    $date = date('y-m-d h:i:s');
    
    $customer_id = $_SESSION['customer'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO `exception_audit`(`exception_id`, `user_id`, `customer_id`, `rule_id`, `action`, `action_dt`, `old_exception_value`, `old_justification`, `new_justification`, `old_review_date`) VALUES ('$exceptionId','$user_id','$customer_id','$ruleId','Delete','$date', '$exceptionValue', '$oldJustification', '$newJustification', '$oldReview')";
    mysqli_query($conn, $sql);

    $sql1 = "INSERT INTO `non_compliance_audit`(`non_compliance_id`, `resource_id`, `rule_id`, `user_id`, `action`, `action_dt`) VALUES ('".$non_compliance_id."', '".$resourceID."', '".$ruleId."', '$user_id', 'Delete', '".$date."') ";   
    mysqli_query($conn, $sql1);

    $sql2 = "DELETE FROM exception WHERE id = $exceptionId";
    mysqli_query($conn, $sql2);

    $conn->close();
}

?>