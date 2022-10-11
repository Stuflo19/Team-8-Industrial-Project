<?php
    include 'dbconnect.php';

    $newJustification = $_POST['newJustification'];
    $newReview = $_POST['newReviewDate'];
    $exceptionValue = $_POST['exceptionValue'];
    $exceptionId = $_POST['exceptionId'];
    $ruleId = $_POST['ruleId'];
    $oldJustification = $_POST['oldJustification'];
    $oldReview = $_POST['oldReview'];
    $date = date('d-m-y h:i:s');

    $sql = "INSERT INTO `exception_audit`(`exception_id`, `user_id`, `customer_id`, `rule_id`, `action`, `action_dt`, `old_exception_value`, `new_exception_value`, `old_justification`, `new_justification`, `old_review_date`, `new_review_date`) VALUES (".$newJustification.",'1','1',".$ruleId.",'Review',".$date.",".$exceptionValue.",".$exceptionValue.",".$oldJustification.",".$newJustification.",".$oldReview.",".$newReview.")";
    mysqli_query($conn, $sql);
?>