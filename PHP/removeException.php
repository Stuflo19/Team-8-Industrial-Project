<?php
// session_start();

// if(isset($_POST['']))
// {
//     include 'dbconnect.php';

//     $newJustification = $_POST['newJustification'];
//     $exceptionId = $_POST['exceptionId'];
//     $ruleId = $_POST['ruleId'];
//     $date = date('y-m-d h:i:s');
//     $customer_id = $_SESSION['customer'];
//     $user_id = $_SESSION['user_id'];

//     $sql1 = "INSERT INTO `exception_audit`(`exception_id`, `user_id`, `customer_id`, `rule_id`, `action`, `action_dt`) VALUES ('$exceptionId','$user_id','$customer_id','$ruleId','Delete','$date')";
//     mysqli_query($conn, $sql1);

//     $sql = "DELETE FROM exception WHERE id = $exceptionId";
//     mysqli_query($conn, $sql);

    

//     $conn->close();
// }

?>