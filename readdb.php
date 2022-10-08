<?php
/*===========================================  
  READING ALL FROM RESOURCE WHERE CUSTOMER_ID
  ===========================================*/
  $sql = "SELECT * FROM resource WHERE account_id = 1";
  $result = mysqli_query($conn, $sql);


  /*========================================== 
  READING ALL FROM EXCEPTION WHERE CUSTOMER_ID
  ============================================*/
  $sql = "SELECT * FROM exception WHERE customer_id = 1";
  $exceptions = mysqli_query($conn, $sql);
  foreach($exceptions as $e)
  {
    $exception[] = $e;
  }
  
/*===============================  
  READING ALL FROM NON_COMPLIANCE
  ===============================*/
  $sql = "SELECT * FROM non_compliance";
  $compliant = mysqli_query($conn, $sql);
  while (($row = mysqli_fetch_array($compliant, MYSQLI_ASSOC)) != false){
    $non_compliant_ids[] = $row['resource_id'];
    $non_compliant_rules[] = $row['rule_id']; 
  }

/*======================  
  READING ALL FROM RULES
  ======================*/
  $query = mysqli_query($conn,"SELECT * FROM rule");


/* READ TO GET CUSTOMER NAME */
$sql = "SELECT login.user_id, user.customer_id, customer.name FROM customer INNER JOIN users ON customer.id = users.customer_id INNER JOIN login ON user.id = login.user_id";
$result1 = mysqli_query($conn,$sql);
$test = mysqli_fetch_assoc($result1);
  
$conn->close();
?>