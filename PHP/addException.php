<?php
    include 'dbconnect.php';
    include 'readdb.php';

    $len_exception = count($exception)+1;
    //last_updates = today's day
    $date = date("Y-m-d H:i:sa");
    //ruleID
    // $justif = $_POST['newJustification'];
    // //echo $justif;
    // $IDs = $_POST['resourceList'];
    // $ruleID = intval(explode("_",$IDs)[1]);
    // //exception_value
    // $resourceID= intval(explode("_",$IDs)[0]);
    // $exception_value = "";
    // while($row =mysqli_fetch_array($result_res))
    // {
    //     if($row['id'] == $resourceID)
    //     {
    //         $exception_value = $row['resource_name'];
    //     }
    // }

    //customer_id & last_updated_by are FIXED values

    //$addExceptionS="INSERT INTO exception(id, customer_id, rule_id,last_updated_by, exception_value, justification, review_date, last_updated, suspended) VALUES (".$len_exception. ", 1,". $ruleID .",'system','" . $exception_value . "','".$justif."', '" . $_POST['newReviewDate'] . "','". $date ."',0 );";
    //$insertQ = mysqli_query($conn,$addExceptionS);

    //$conn->close();
    header( "../index.php");

?>