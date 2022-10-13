<?php
    session_start();
    include 'dbconnect.php';

    if(isset($_POST['id']) && isset($_POST['suspended'])){
        $id = $_POST['id'];
        $suspended = $_POST['suspended'];
        $ruleid = $_POST['ruleid'];
        $customer_id = $_SESSION['customer'];
        $user_id = $_SESSION['user_id'];
        $date = date("Y-m-d H:i:sa");
        
        $suspended == 1 ? $suspended = 0: $suspended = 1;
        $suspended == 1 ? $action="Suspended" : $action = "Unsuspended";

        $sql = "INSERT INTO `exception_audit`(`exception_id`, `user_id`, `customer_id`, `rule_id`, `action`, `action_dt`) VALUES ('$id','$user_id','$customer_id','$ruleid','$action','$date');";
        mysqli_query($conn, $sql); 

        //getting required values for adding a new entry to non_compliant_audit table
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

        $sql1 = "INSERT INTO `non_compliance_audit` (`non_compliance_id`, `resource_id`, `rule_id`, `user_id`, `action`, `action_dt`) VALUES ('".$non_compliance_id."', '".$resource_id."', '".$rule_id."', '".$_SESSION['user_id']."', '".$action."', '".$date."') ";   
        if (!mysqli_query($conn, $sql1))
        {
          die('Error: ' . mysqli_query());
        }
        
        $sql = "UPDATE exception SET suspended=$suspended WHERE id=$id AND customer_id=$customer_id";
        mysqli_query($conn, $sql);
        echo $suspended;
    }
    else {
        echo "error transmitting ID";
    }

    //$conn->close();
    header("../index.php")
    
?>