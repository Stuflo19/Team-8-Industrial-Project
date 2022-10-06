<?php
  include 'PHP/dbconnect.php';
  include 'PHP/readdb.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <!-- page title -->
  <title> Prototype | Home </title>

  <!-- import viewport properties -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- import bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'> 
  <!-- import css file -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="javascript/scripts.js"></script>
  <script src="javascript/backend.js"></script>
  <link rel="stylesheet" href="CSS/master.css">
</head>


<body onload ="generateGraph(<?php echo count($non_compliant_ids)?> , <?php echo mysqli_num_rows($result)?>)">

  <header class="container-fluid p-1">

  </header>

  <!-- navigation bar with links -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="collapse navbar-collapse d-flex justify-content-around" id="navbarNav">
      <ul class="mb-auto pl-0">
        <li>Username: Customer Name</li>
        <li>Role: Customer Role</li>
      </ul>
      <br>
      <h1 class=m-auto> Company Name </h1>
      <h2><i class='fa fa-refresh p-2'></i>Last checked: date</h2>
    </div>
  </nav>

  <main class="container-fluid p-5">

    <div class="row">
      <div class="col-lg">
        <div class="col-lg-7"> 
          <h3>Compliance Rules</h3>
        </div>
          <!-- Complaince Rule and Status -->
          <?php 
            while($result_rule=mysqli_fetch_array($query))
            {
          ?>
          <div class = "row mb-2"> 
            <div class="col-lg">
              <!-- Compliance Rule Card -->
              <div class="card cardColor text-center m-auto">
                <div class="card-body m-1 p-1">
                  <p class="card-text pb-1 m-auto"> <?php echo $result_rule["name"];?> </p>
                  <?php 
                      $status ="active-status"; // compliant
                      $status_text ="Compliant";
                      foreach($compliant as $result_non_compl)
                      {
                        if ($result_rule['id'] == $result_non_compl['rule_id'])
                        {
                          $status ="exception-status";
                          $status_text ="Non-Compliant";
                          break;
                        }
                      }
                    ?>
                    <div class="<?php echo $status;?>"> <?php echo $status_text;?></div>
                  </div>
                  
                  <button class="btn btn-outline-warning m-1" type="button"  data-toggle="collapse" data-target="#Rule<?php echo $result_rule['id'];?>" aria-expanded="false" aria-controls="collapseExample">
                    View details
                  </button>
                  <div class="collapse" id="<?php echo 'Rule' . $result_rule['id'];?>">
                    <div class="card-body">
                    <table class="table table-striped" style="color:white">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">Resource</th>
                          <th scope="col">Status</th>
                          <th scope ="col">History</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php
                            foreach($result as $row) {
                              $checked = false;
                              if($row['resource_type_id'] == $result_rule['resource_type_id']){
                                echo '
                                <tr>
                                <td style="text-align: left">'.$row["resource_name"].'</td>';
                                
                                if(in_array($row["id"], $non_compliant_ids))
                                {
                                  foreach(array_keys($non_compliant_ids, $row['id']) as $index) {
                                    $non_compliant_rules[$index] == $result_rule["id"] ? $checked = true : $checked = false;
                                    if($checked) {break;}
                                  };

                                  if($checked)
                                  {
                                    foreach($exception as $exc)
                                    {
                                      if($result_rule['id'] == $exc['rule_id'] && $row['resource_name'] == $exc['exception_value'])
                                      {
                                        $checked = $exc['suspended'] == 0 ? false : true;
                                        break;
                                      }
                                    }
                                  }
                                }

                              //if the resource exists in the id array && ruleID at index of resource in the rules array
                              if($checked)
                              {
                                echo '<td style="vertical-align: middle"><div class="exception-status"> Non-Compliant</div></td>';
                              }
                              else
                              {
                                echo '<td style="vertical-align: middle"><div class="active-status">Compliant</div></td>';
                              } 
                              echo "<td style='vertical-align: middle'><button type='button' class='btn btn-outline-warning historybutton' data-toggle='modal' data-target='#historyModal' id='{$row["resource_name"]},{$result_rule["id"]}' onclick='historybutton(this.id, ".json_encode($exception).")'>Exception History</button></td></tr>";
                            }
                          }
                        ?>
                      </tbody>
                    </table>
                    </div>
                    <?php
                      $var = "Non-Compliant";
                      if(strcmp($status_text, $var) == 0)
                      {
                        echo "<button type='button' class='btn btn-outline-warning float-right m-1' data-toggle='modal' data-target='#newExcModal' id=". $result_rule['id']." name=". $result_rule['id'] . "," . $result_rule['resource_type_id']." onclick='addException(this.name)' >
                        Add Exception
                        </button>";
                      }
                    ?>
                  </div>
                </div>
              </div>
              
            </div>
          <?php } ?>
      </div>

      <!-- Placeholder for pie chart when we get it working -->
      <div class="col-lg-5" position="absolute">
        <h3>Overall Compliance</h3>
        <p> The objective is to get a pie chart display in here similar to the interface on our university attendance tracker "SEATs", which visualises a percentage of how many rules are compliant, those that have exceptions and those that are non-compliant
          <!-- Doughnut Chart -->
          <div>
            <canvas id="myChart"></canvas>
          </div>
          
        </div>

    </div>
  <!-- Add exception Modal -->
  <div class="modal fade" id="newExcModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark" style="background-color: #115e67">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Add Exception</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post">
              <div class="form-group">
                <label for="resourceList" class="col-form-label">Select a cloud resource:</label>
                <select style= "width:100%; color: white; background-color: #333333" name="resourceList" id="resourceList">
                  <!-- OPTIONS created dynamically -->
                </select>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Justification:</label>
                <textarea class="form-control" id="newJustification" name="newJustification" style="color: white; background-color: #333333" maxlength="200" required></textarea>
              </div>
              <!-- Exception Value = resource name  -->
              <div class="form-group">
                <label for="message-text" class="col-form-label">Review Date:</label>
                <!-- Code taken from https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/date -->
                <input type="date" id="newReviewDate" name="newReviewDate" value="<?php echo date("Y-m-d")?>" min="<?php echo date("Y-m-d", strtotime("+1 day"))?>" max="<?php echo date("Y-m-d", strtotime("+1 year"))?>">
                <!-- <input id="today" type="date"> -->
                
              </div>
              
              </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>   
            </form>
          <?php
              //id
              $len_exception = count($exception)+1;
              //last_updates = today's day
              $date = date("Y-m-d H:i:sa");
              //ruleID
              $justif = $_POST['newJustification'];
              //echo $justif;
              $IDs = $_POST['resourceList'];
              $ruleID = intval(explode("_",$IDs)[1]);
              //exception_value
              $resourceID= intval(explode("_",$IDs)[0]);
              $exception_value = "";
              while($row =mysqli_fetch_array($result_res))
              {
                if($row['id'] == $resourceID)
                {
                  $exception_value = $row['resource_name'];
                }
              }

              //customer_id & last_updated_by are FIXED values
           
              $addExceptionS="INSERT INTO exception(id, customer_id, rule_id,last_updated_by, exception_value, justification, review_date, last_updated, suspended) VALUES (".$len_exception. ", 1,". $ruleID .",'system','" . $exception_value . "','".$justif."', '" . $_POST['newReviewDate'] . "','". $date ."',0 );";
              //echo $addException;
              $insertQ = mysqli_query($conn,$addExceptionS);


            ?>


        </div>
      </div>
    </div>


    <!-- View History Modal -->
    <div class="modal fade bd-example-modal-lg" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-dark" style="background-color: #115e67">
          <div class="modal-header">
            <h3 class="modal-title" id="historyModalLabel">Exception History</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <table class="table table-striped" id="historytable" style="color:white">
            <thead class="thead-dark">
              <th scope="col">Exception ID</th>
              <th scope="col">Created By</th>
              <th scope="col">Justification</th>
              <th scope="col">Review Date</th>
              <th scope="col">Suspend</th>
            </thead>
            <!-- Table body populated by Javascript historybutton function -->
            <tbody id ="historybody">
            </tbody>
          </table>
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
          </div>
        </div>
      </div>
    </div>

  <!-- Footer -->
  <footer class="container-fluid page-footer footerDesign">
    <div class="row">
      <div class="col-lg-4">

        <!-- Store description -->
        <h6 class="mt-3">Footer Heading 1</h6>
        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sit amet leo nunc. Aliquam augue nulla, ullamcorper in fringilla eget, pulvinar id tellus. Vestibulum eros tortor, porttitor a tortor sit amet, consectetur auctor nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Ut lacinia sagittis sapien id cursus.</p>
      </div>

    </div>

    <div class="row">


      <div class="col font-italic text-justify mt-2">

        <p>This web app was developed by Stuart Florence, Neil McGuigan, Laura Naslenaite, Gregor Davis and Euan Storrie. </p>

      </div>

    </div>

  </footer>
  <!-- import bootstrap JS, Popper.js, and jQuery  -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
  <script>
    function addException(rule_rescourceType){
  var rows_resource = <?php echo json_encode($resource); ?>;
  var rows_non_compliant = <?php echo json_encode($non_compliant); ?>;
  var rows_except = <?php echo json_encode($exception); ?>;
  //console.log(rule_rescourceType);
  var ruleID = rule_rescourceType.split(",")[0];
  //var resourceTypeID = rule_rescourceType.split(",")[1];
  var resource_name = "";
  var resource_id = 0;
  var non_compl = 1;
  //console.log(ruleID);
  //console.log(resourceTypeID);
  var select_dropdown = document.querySelector('#resourceList');
  while (select_dropdown.firstChild) 
  {
    select_dropdown.removeChild(select_dropdown.firstChild);
  }

  for(var i = 0; i < rows_non_compliant.length; i++) {
    //looking if a rule has non-compliant resources
    if(rows_non_compliant[i]['rule_id'] == ruleID)
    {
      //finding the name of a resource
      for(var j = 0; j < rows_resource.length; j++)
      {
        if(rows_resource[j]['id'] == rows_non_compliant[i]['resource_id'])
        {
          //checking if a non-compliant resource has an axception -> making a resource compliant
          for(var k=0; k<rows_except.length; k++)
          {
            if(rows_resource[j]['resource_name'] === rows_except[k]['exception_value'])
            {
              non_compl=0;
              break;
            }
          } 

          if(non_compl==1)
          {
            resource_name = rows_resource[j]['resource_name'];
            resource_id = rows_resource[j]['id'];
            console.log(resource_name, ruleID);

            var resourceID_ruleID = resource_id+"_"+ruleID;
            select_dropdown.appendChild(addOption(resource_name, resourceID_ruleID));
          }
          
          break;
        }
      }
    }

  }

}
  </script>

</body>