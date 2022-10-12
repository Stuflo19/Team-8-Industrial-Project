<?php
    include 'dbconnect.php';

    if(isset($_POST['id']) && isset($_POST['suspended'])){
        $id = $_POST['id'];
        $suspended = $_POST['suspended'];
        
        $suspended == 1 ? $suspended = 0: $suspended = 1;

        $sql = "UPDATE exception SET suspended=$suspended WHERE id=$id AND customer_id=1";

        $res = mysqli_query($conn, $sql);
        if($suspended==1)
        {
            $action="Suspended (resource->noncompliant)";
        }
        else{
            $action="Unsuspended (resource->compliant)";
        }

        $sql1 = "SELECT * FROM exception WHERE id=$id";
        $result = mysqli_query($conn, $sql1);
        $row = mysqli_fetch_array($result);
        $resource_ref = $row['exception_value'];
        $user_id = $row['last_updated_by'];


        $sql2 = "SELECT * FROM resource WHERE resource_ref='".$resource_ref."'";
        $result = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_array($result);
        $resource_id = $row['id'];

        $sql2 = "SELECT * FROM non_compliance WHERE resource_id=".$resource_id."";
        $result = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_array($result);
        $non_compliance_id = $row['id'];
        $rule_id = $row['rule_id'];

        $date = date("Y-m-d H:i:sa");

        $sql1 = "INSERT INTO `non_compliance_audit` (`non_compliance_id`, `resource_id`, `rule_id`, `user_id`, `action`, `action_dt`) VALUES ('".$non_compliance_id."', '".$resource_id."', '".$rule_id."', 'system', '".$action."', '".$date."') ";   
        if (!mysqli_query($conn, $sql1))
        {
          die('Error: ' . mysqli_query());
        }
        
        // echo "<script>console.log('.$sql1.');</script>"; 
        echo $suspended;
    }
    else {
        echo "error transmitting ID";
    }

    //$conn->close();
    header("../index.php")
?>