<?php
    session_start();
    include 'dbconnect.php';
    include 'readdb.php';

    $len_exception = count($exception1)+1;
    //last_updates = today's day
    $date = date("Y-m-d H:i:sa");
    
   if (isset($_POST['newJustification']) || isset($_POST['resourceList']) )
   {
    $justif = $_POST['newJustification'];
    //echo $justif;
    $IDs = $_POST['resourceList'];
    //echo $IDs;
    $IDs = explode("_",$IDs);
    $ruleID = intval($IDs[1]);
    //exception_value
    $resourceID= intval($IDs[0]);
    $exception_value =  $IDs[2];
    $customer_id = $_SESSION['customer'];
    $user_id = $_SESSION['user_id'];

    $sql2 = "SELECT * FROM non_compliance WHERE resource_id=".$resourceID."";
    $result = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_array($result);
    $non_compliance_id = $row['id'];

    $addExceptionS="INSERT INTO exception(id,customer_id, rule_id,last_updated_by, exception_value, justification, review_date, last_updated, suspended) VALUES (".$len_exception.",".$customer_id.",". $ruleID .",'".$user_id."','" . $exception_value . "','".$justif."', '" . $_POST['newReviewDate'] . "','". $date ."',0 );";
    $insertQ = mysqli_query($conn,$addExceptionS);
    
    $sql = "INSERT INTO `exception_audit`(`exception_id`, `user_id`, `customer_id`, `rule_id`, `action`, `action_dt`, `new_exception_value`, `new_justification`, `new_review_date`) VALUES ('$len_exception','$user_id','$customer_id','$ruleID','Create','$date','$exception_value','$justif', '" . $_POST['newReviewDate'] . "')";
    $addAuditt = mysqli_query($conn, $sql); 
    $sql1 = "INSERT INTO `non_compliance_audit` (`non_compliance_id`, `resource_id`, `rule_id`, `user_id`, `action`, `action_dt`) VALUES ('".$non_compliance_id."', '".$resourceID."', '".$ruleID."', '$user_id', 'Exception', '".$date."') ";   
        if (!mysqli_query($conn, $sql1))
            {
                die('Error: ' . mysqli_query());
            }
    
    }
    $conn->close();
    header("..index.php");
 ?>

