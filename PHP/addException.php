<?php
    include 'dbconnect.php';
    include 'readdb.php';

    $len_exception = count($exception)+1;
    //last_updates = today's day
    $date = date("Y-m-d H:i:sa");
    //ruleID
   // if (isset($justif) || isset($justif) || isset($justif))

    echo $_POST['newJustification'];

   if (isset($_POST['newJustification']) || isset($_POST['resourceList']) )
   {
      
   
    $justif = $_POST['newJustification'];
    //echo $justif;
    $IDs = $_POST['resourceList'];
    //echo $IDs;
    $IDs = explode("_",$IDs);
    $ruleID = intval($IDs[1]);
    //exception_value
    //echo $ruleID 
    $resourceID= intval($IDs[0]);
    $exception_value =  $IDs[2];
   
     
    //$exception_value = explode("_",$IDs)[2];
    //echo $exception_value;
    // while($row =mysqli_fetch_array($result_res))
    // {
    //   if($row['id'] == $resourceID)
    //   {
    //     $exception_value = $row['resource_name'];
    //   }
    // }

    //customer_id & last_updated_by are FIXED values
 
    $addExceptionS="INSERT INTO exception(id, customer_id, rule_id,last_updated_by, exception_value, justification, review_date, last_updated, suspended) VALUES (".$len_exception. ", 1,". $ruleID .",'system','" . $exception_value . "','".$justif."', '" . $_POST['newReviewDate'] . "','". $date ."',0 );";
    //echo $addExceptionS;
    $insertQ = mysqli_query($conn,$addExceptionS);
    //mysqli_refresh($conn);

    header("Location: https://issue-br-issue-13.herokuapp.com/");
    //session_reset();
    $conn->close();
    //echo "<meta http-equiv='refresh' content='0'>";
   }
   header("../index.php");


?>
