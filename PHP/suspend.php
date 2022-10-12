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

        $sql = "UPDATE exception SET suspended=$suspended WHERE id=$id AND customer_id=$customer_id";
        mysqli_query($conn, $sql);
        echo $suspended;
    }
    else {
        echo "error transmitting ID";
    }

    $conn->close();
    header("../index.php");
?>