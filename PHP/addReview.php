<?php

if(isset($_POST['newJustification']))
{
        include 'dbconnectlocal.php';   

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
        $user_id = 1;
    
        $sql = "INSERT INTO `exception_audit`(`id`, `exception_id`, `user_id`, `customer_id`, `rule_id`, `action`, `action_dt`, `old_exception_value`, `new_exception_value`, `old_justification`, `new_justification`, `old_review_date`, `new_review_date`) VALUES ('1','$exceptionId','system','1','$ruleId','Review','$date','$exceptionValue','$exceptionValue','$oldJustification','$newJustification','$oldReview','$newReview')";
        mysqli_query($conn, $sql);
    
        echo "Success";
    
        $conn->close();
        header("../index.php");
    }
    else {
        echo 'Values not set';
    }
?>