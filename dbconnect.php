<!-- Script taken from guide at: https://www.doabledanny.com/Deploy-PHP-And-MySQL-to-Heroku -->
<?php
    //Get Heroku ClearDB connection information
    $cleardb_url = parse_url(getenv("mysql://b92604c5cbeb5a:41101b7b@us-cdbr-east-06.cleardb.net/heroku_7e33e8a8825b015?reconnect=true"));
    $cleardb_server = "us-cdbr-east-06.cleardb.net";
    $cleardb_username = "b92604c5cbeb5a";
    $cleardb_password = "41101b7b";
    $cleardb_db = "heroku_7e33e8a8825b015";
    $active_group = 'default';
    $query_builder = TRUE;
    // Connect to DB
    $conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
?>