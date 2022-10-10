<?php
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
    $add_update = $IDs[3];

    // if($add_update == 1)
    // {
        $addExceptionS="INSERT INTO exception(id, customer_id, rule_id,last_updated_by, exception_value, justification, review_date, last_updated, suspended) VALUES (".$len_exception. ", 1,". $ruleID .",'system','" . $exception_value . "','".$justif."', '" . $_POST['newReviewDate'] . "','". $date ."',0 );";
        $insertQ = mysqli_query($conn,$addExceptionS);
    // }
    // else
    // {
    //     $updateException = "UPDATE exception SET justification ='".$justif."', review_date='".$_POST['newReviewDate']."', last_updated='".$date."' WHERE  exception_value = '".$exception_value."'";
    //     $insertQ = mysqli_query($conn,$updateException);
    // }
    

    }
    //$conn->close();
    header("..index.php");
    ?>
