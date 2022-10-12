<?php

if(isset($_POST['newJustification']))
{
        include 'dbconnect.php';   

        $newJustification = $_POST['newJustification'];
        $newReview = $_POST['newReviewDate'];
        $exceptionValue = $_POST['exceptionValue'];
        $exceptionId = $_POST['exceptionId'];
        $ruleId = $_POST['ruleId'];
        $oldJustification = $_POST['oldJustification'];
        $oldReview = $_POST['oldReview'];
        $date = date('y-m-d h:i:s');
        $type = "Review";
        $customer_id = 1;
        $user_id = "system";
    
        $sql = "UPDATE `exception` SET `customer_id`='$customer_id', `last_updated_by`='$user_id', `justification`='$newJustification',`review_date`='$newReview',`last_updated`='$date' WHERE `id` = $exceptionId";
        mysqli_query($conn, $sql);

        $sql = "INSERT INTO `exception_audit`(`exception_id`, `user_id`, `customer_id`, `rule_id`, `action`, `action_dt`, `old_exception_value`, `new_exception_value`, `old_justification`, `new_justification`, `old_review_date`, `new_review_date`) VALUES ('$exceptionId','$user_id','1','$ruleId','Review','$date','$exceptionValue','$exceptionValue','$oldJustification','$newJustification','$oldReview','$newReview')";
        mysqli_query($conn, $sql);
    
        echo "Success";
    
        $conn->close();
        header("../index.php");
    }
    else {
        echo 'Values not set';
    }
?>