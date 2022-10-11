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

<body onload ='callAll(<?php echo count($non_compliant_ids)?> , <?php echo mysqli_num_rows($result)?> , <?php echo json_encode($exception) ?>)'>

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
      <h1 class="m-auto"> Company Name </h1>
      <h2><i class='fa fa-refresh p-2'></i>Last checked: date</h2>
    </div>
  </nav>

  <main class="container-fluid p-5">

    <div class="row text-center">
      
      <!-- Placeholder for pie chart when we get it working -->
      <div class="col-lg-5 chart"> 
        <h3>Overall Compliance</h3>
        <!-- Doughnut Chart -->
        <div>
          <canvas id="myChart" style="max-height: 75vh;"></canvas>
        </div>
          
      </div>
      <div class="col-lg-1"></div>
      <!-- Review Dates -->
      <div class="col-lg-5 " >
        <div class="row-lg mt-4">
          <h3>Upcoming Reviews for Existing Exceptions</h3>
        </div>
          <div class="d-flex align-items-center p-2">
          <table class="table fixed_header" style="color:white">
            <thead style="position: sticky; top:0;" class="thead-dark stickyHead">
              <tr class="stickyHead">
                <th class="stickyHead" scope="col-lg">Exception No.</th>
                <th class="stickyHead" scope="col-lg">Resource</th>
                <th class="stickyHead" scope="col-lg">Rule ID</th>
                <th class="stickyHead" scope="col-lg">Creator</th>
                <th class="stickyHead" scope="col-lg">Justification</th>
                <th class="stickyHead" scope="col-lg">Review date</th>
              </tr>
            </thead>
            <!-- If Michael Cera becomes a visible collaborator on the site, we have a problem -->
            <tbody id="reviewbody"> 
              <tr>
                <td>1</td>
                <td>dh-dc1</td>
                <td>4</td>
                <td>Michael Cera</td>
                <td>The resource would not work</td>
                <td>2011/04/25 06:94:20</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div> 
    </div>
      
      <div class="row">
        <div class="col-lg text-center mt-4">
        
          <!-- Complaince Rule and Status -->
          <?php 
            echo '<h3>Compliance Rules</h3>';
            while($result_rule=mysqli_fetch_array($query))
            {
          ?>
          <div class = "row mb-2">
            <div class="col-lg">
              <!-- Compliance Rule Card -->
            
              <div class="card cardColor text-center m-auto">
                <div class="d-flex justify-content-between">
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

                          $num_non_comp =0;
                          $num_comp = 0;
                         
                          $display_non_comp = "SELECT COUNT(resource_id) FROM non_compliance LEFT JOIN resource TB WHERE non_compliance.resource_id=resource.resourseid";

                          foreach($compliant as $result_non_compl)
                          {
                            if ($result_rule['id'] == $result_non_compl['rule_id'])
                            {
                        
      
                                if($quer2== NULL || $quer2['suspended'] == 1)
                                {
                                  $num_non_comp =  $num_non_comp +1;
                            
                                
                                }
                            }
                          }
                          break;
                        }
                      }
                    ?>
                    <div class="<?php echo $status;?>"> <?php echo $status_text;?></div>
                    <div id="<?php echo $num_comp;?>" class = "compliance_counter"> <?php echo "Compliant Resources: " . $display_comp;?></div>
                    <div id="<?php echo $display_non_comp;?>" class = "compliance_counter"> <?php echo "Non-Compliant Resources: " . $display_non_comp;?></div>
                    <?php  $display_non_comp =0;  $display_comp =0; ?>
                  </div>
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
                    <button type="button" id="<?php echo 'Rule' . $result_rule['id'];?>" class="btn btn-outline-warning float-right m-1" data-toggle="modal" data-target="#newExcModal">Add Exception</button>
                    
                  </div>
                </div>
              </div>
              
          </div>
          <?php } ?>
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
            <form>
              <div class="form-group">
                <label for="resources-list" class="col-form-label">Select a cloud resource:</label>
                <select style= "width:100%; color: white; background-color: #333333" id="resources-list">
                  <!-- Temp until we can read in resources from the db -->
                  <option label="T1"></option>
                  <option label="T2"></option>
                  <option label="T3"></option>
                  <option label="T4"></option>
                </select>
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Justification:</label>
                <textarea class="form-control" id="message-text" style="color: white; background-color: #333333"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
            <button type="button" class="btn btn-primary">Submit</button>
          </div>
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
  </main>


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
  
</body>
