<?php
    include 'dbconnectlocal.php';

    if(isset($_POST['id']) && isset($_POST['suspended'])){
        $id = $_POST['id'];
        $suspended = $_POST['suspended'];
        
        if($suspended == 1)
        {
            $sql = "UPDATE exception SET suspended=0 WHERE id=$id AND customer_id=1";
        }
        else
        {
            $sql = "UPDATE exception SET suspended=1 WHERE id=$id AND customer_id=1";
        }

        mysqli_query($conn, $sql);
        echo $suspended == 1 ? "0" : "1";
    }
    else {
        echo "error transmitting ID";
    }
?>