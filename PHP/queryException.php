<?php
    include 'PHP/dbconnectlocal.php'

    $sql = "SELECT * FROM exception"
    $exceptions = mysqli_query($conn, $sql);

    $conn->close();
?>