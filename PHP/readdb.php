<?php
/*===========================================  
  READING ALL FROM RESOURCE WHERE CUSTOMER_ID
  ===========================================*/
  $sql = "SELECT * FROM resource WHERE account_id = 1";
  $result = mysqli_query($conn, $sql);
  while (($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) != false)
  {
    $resources[] = $row;
  }

  $sql = "SELECT * FROM resource WHERE account_id = 1";
  $result = mysqli_query($conn, $sql);
  foreach($result as $e)
  {
    $resource[] = $e;
  }
  
  $sql = "SELECT * FROM resource WHERE account_id = 1";
  $result_res = mysqli_query($conn, $sql);


  /*========================================== 
  READING ALL FROM EXCEPTION WHERE CUSTOMER_ID
  ============================================*/
  $sql = "SELECT * FROM exception WHERE customer_id = 1";
  $exceptions = mysqli_query($conn, $sql);
  while (($row = mysqli_fetch_array($exceptions, MYSQLI_ASSOC)) != false)
  {
    $exception[] = $row;
  }

  $sql = "SELECT * FROM exception WHERE customer_id = 1";
  $exceptions = mysqli_query($conn, $sql);
  foreach($exceptions as $e)
  {
    $exception1[] = $e;
  }
  
/*===============================  
  READING ALL FROM NON_COMPLIANCE
  ===============================*/
  $sql = "SELECT * FROM non_compliance";
  $compliant = mysqli_query($conn, $sql);
  while (($row = mysqli_fetch_array($compliant, MYSQLI_ASSOC)) != false){
    $non_compliant_ids[] = $row['resource_id'];
    $non_compliant_rules[] = $row['rule_id']; 
    $non_compliance[] = $row;
  }

  
  $sql = "SELECT * FROM non_compliance";
  $compliant = mysqli_query($conn, $sql);
  foreach($compliant as $e)
  {
    $non_compliant[] = $e;
  }

/*======================  
  READING ALL FROM RULES
  ======================*/
  $query = mysqli_query($conn,"SELECT * FROM rule");
  while (($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) != false){
    $rules[] = $row;
  }

  //$query = mysqli_query($conn,"SELECT * FROM rule");

  /* READ TO GET CUSTOMER NAME */
  $sql = "SELECT * FROM user";
  $custname = mysqli_query($conn,$sql);


  /* READ TO GET USER ROLE */
  $sql = "SELECT * FROM user";
  $custrole = mysqli_query($conn,$sql);


  // Adding to JS vars resource, non_compliance, exception
  echo '<Script>
          var resource = '. json_encode($resources) .';
          var non_compliance = '. json_encode($non_compliance) .';
          var exception = '. json_encode($exception) .';
          var rules = '. json_encode($rules) .';
        </Script>';

  //$conn->close();
?>