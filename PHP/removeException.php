<?php
session_start();

if(isset($_POST['newJustification1']))
{
    include 'dbconnect.php';
    echo 'It is set';

    $newJustification = $_POST['newJustification1'];
    echo $newJustification. '<br>'
    $exceptionValue = $_POST['exceptionValue'];
    echo $exceptionValue. '<br>'
    $exceptionId = $_POST['exceptionId'];
    echo $exceptionId. '<br>'
    $oldJustification = $_POST['oldJustification'];
    echo $oldJustification. '<br>'
    $oldReview = $_POST['oldReview'];
    echo $oldReview. '<br>'
    $ruleId = $_POST['ruleId'];
    echo $ruleId. '<br>'
    $date = date('y-m-d h:i:s');
    
    $customer_id = $_SESSION['customer'];
    $user_id = $_SESSION['user_id'];

    echo '-------- <br>';
    $sqlFetchID = "SELECT id FROM `resource` WHERE resource_ref=".$exceptionValue."";
    echo $sqlFetchID. '<br>';
    $result1 = mysqli_query($conn, $sqlFetchID);
    echo $result1 '<br>';
    $resourceID = mysqli_fetch_array($result1);

    echo 'Resource ID: ' .$resourceID. '';

    $sqlFetchID = "SELECT rule_id FROM `non_compliance` WHERE resource_id=".$resourceID."";
    $result2 = mysqli_query($conn, $sqlFetchID);
    $non_compliance_id = mysqli_fetch_array($result2);

    echo 'Compliance ID: ' .$non_compliance_id. '';

    

    echo $customer_id;

    $sql = "INSERT INTO `exception_audit`(`exception_id`, `user_id`, `customer_id`, `rule_id`, `action`, `action_dt`, `old_exception_value`, `old_justification`, `new_justification`, `old_review_date`) VALUES ('$exceptionId','$user_id','$customer_id','$ruleId','Delete','$date', '$exceptionValue', '$oldJustification', '$newJustification', '$oldReview')";
    mysqli_query($conn, $sql);

    echo "Inserting Exception Audit";
    
    $sql1 = "INSERT INTO `non_compliance_audit`(`non_compliance_id`, `resource_id`, `rule_id`, `user_id`, `action`, `action_dt`) VALUES ('".$non_compliance_id."', '".$resourceID."', '".$ruleId."', '$user_id', 'Delete', '".$date."') ";   
    mysqli_query($conn, $sql1);

    echo "Inserting Compliance Audit";

    $sql2 = "DELETE FROM `exception` WHERE id = $exceptionId";
    mysqli_query($conn, $sql2);

    echo "Deleting Exception";
    
    $conn->close();
}
else {
    echo 'Values not set';
}

?>