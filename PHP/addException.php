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

    $sql2 = "SELECT * FROM non_compliance WHERE resource_id=".$resourceID."";
    $result = mysqli_query($conn, $sql2);
    $row = mysqli_fetch_array($result);
    $non_compliance_id = $row['id'];

    
    $addExceptionS="INSERT INTO exception( customer_id, rule_id,last_updated_by, exception_value, justification, review_date, last_updated, suspended) VALUES ( 1,". $ruleID .",'system','" . $exception_value . "','".$justif."', '" . $_POST['newReviewDate'] . "','". $date ."',0 );";
    $insertQ = mysqli_query($conn,$addExceptionS);

    $sql1 = "INSERT INTO `non_compliance_audit` (`non_compliance_id`, `resource_id`, `rule_id`, `user_id`, `action`, `action_dt`) VALUES ('".$non_compliance_id."', '".$resourceID."', '".$ruleID."', 'system', 'Exception added (resource -> compliant)', '".$date."') ";   
    if (!mysqli_query($conn, $sql1))
        {
            die('Error: ' . mysqli_query());
        }
    
    }
    //$conn->close();
    header("..index.php");
    ?>
