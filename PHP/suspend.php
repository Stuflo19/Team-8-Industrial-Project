<?php
    include 'dbconnectlocal.php';

    if(isset($_POST['id']) && isset($_POST['suspended'])){
        $id = $_POST['id'];
        $suspended = $_POST['suspended'];
        
        $suspended == 1 ? $suspended = 0: $suspended = 1;

        $sql = "UPDATE exception SET suspended=$suspended WHERE id=$id AND customer_id=1";

        mysqli_query($conn, $sql);
        echo $suspended;
    }
    else {
        echo "error transmitting ID";
    }

    $conn->close();
    header("../index.php")
?>