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
  <script src="https://kit.fontawesome.com/1f40dabfaa.js" crossorigin="anonymous"></script>
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
      <button class="btn text-secondary border-bottom-0 border rounded-pill ms-n5" style="margin-right: 10px" onclick=refresh();><i class='fa fa-refresh p-2' style="color:white"></button></i>
      <h2 id="date" style="margin: 0"></h2>
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
      <div class="col-lg-6 " >
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
                <th class="stickyHead" scope="col-lg">Review</th>
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
          <div class="row m-auto">
            <h3 class="text-center">Compliance Rules</h3>
            <div style = "margin-left: auto; margin-right: 0"> 
              <select name="filter" style="color: white; background-color: #333333" id="filter-list" onchange="filter()">
                <option value="No Filter">No Filter</option>
                <option value="Compliant">Compliant</option>
                <option value="Non-Compliant">Non-Compliant</option>
              </select>
            </div>
          </div>
          <?php
            foreach($query as $result_rule)
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

                    $non_comp_total =0;
                    $non_comp_except =0;

                    foreach($compliant as $result_non_compl)
                    {
                      if ($result_rule['id'] == $result_non_compl['rule_id'])
                      {
                        $quer = "SELECT * FROM resource WHERE id=".$result_non_compl['resource_id'];
                          $quer1 = mysqli_query($conn, $quer);
                          $quer2 = mysqli_fetch_array($quer1);

                          $quer = "SELECT * FROM exception WHERE exception_value='".$quer2['resource_ref']."'";
                          $quer1 = mysqli_query($conn, $quer);
                          $quer2 = mysqli_fetch_array($quer1);

                          if($quer2== NULL || $quer2['suspended'] == 1)
                          {
                            $non_comp_total =  $non_comp_total +1;
                            if($quer2['suspended'] == 1)
                            {
                              $non_comp_except = $non_comp_except+1;
                            }
                            $status ="exception-status";
                            $status_text ="Non-Compliant";
                            break;
                          }
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
                    <p id="<?php echo 'Description' . $result_rule['id'];?>"></p>

                    <table class="table table-striped" style="color:white">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col" style="width: 40%">Resource</th>
                          <th scope="col">Status</th>
                          <th scope="col">Exception</th>
                          <th scope="col">Suspended</th>
                          <th scope ="col">History</th>
                        </tr>
                      </thead>
                      <tbody id="<?php echo 'Table' . $result_rule['id'];?>">
                        <?php
                          echo '<script>
                                  var result_rule = '. json_encode($result_rule) .';
                                  generateResources();
                                </script>';
                        ?>
                      </tbody>
                    </table>
                    </div>
                    <?php
                      $var = "Non-Compliant";
                      if(strcmp($status_text, $var) == 0 && $non_comp_total > $non_comp_except )
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
            <form id="form" > 
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
              <!-- Exception Value = resource ref  -->
              <div class="form-group">
                <label for="message-text" class="col-form-label">Review Date:</label>
                <input type="radio" onclick="checkCustom()" name="newReviewDate" value="<?php echo date('Y-m-d', strtotime('+1 month'));?>">After 1 month
                <br>
                <input type="radio" onclick="checkCustom()" name="newReviewDate" value="<?php echo date("Y-m-d", strtotime("+3 month"));?>">After 3 months              
                <br>
                <input type="radio" onclick="checkCustom()" name="newReviewDate" value="<?php echo date("Y-m-d", strtotime("+6 month"))?>">After 6 months
                <br>
                <input type="radio" onclick="checkCustom()" name="newReviewDate" value="<?php echo date("Y-m-d", strtotime("+9 month"))?>">After 9 months
                <br>
                <input type="radio" onclick="checkCustom()" name="newReviewDate" value="<?php echo date("Y-m-d", strtotime("+1 year"))?>">After 12 months
                <br>
                <input type="radio" onclick="checkCustom()" id='custom' name="newReviewDate" value="">Custom

                <div id="addCustom" style="display: none">
                  <!-- Help from https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/date -->
                  <input type="date" disabled id="customReviewDate" onChange="setNewValue()" name="ReviewDate" value="<?php echo date("Y-m-d")?>" min="<?php echo date("Y-m-d", strtotime("+30 day"))?>" max="<?php echo date("Y-m-d", strtotime("+1 year"))?>"> 
                </div>
              </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                  <input type="submit" class="btn btn-outline-warning" onclick='formCompleted()' value="Submit">
                </div> 
            </form>   
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
<?php
    $_POST = array();
?>
<script>
function addException(rule_rescourceType){
  var rows_resource = <?php echo json_encode($resource); ?>;
  var rows_non_compliant = <?php echo json_encode($non_compliant); ?>;
  var rows_except = <?php echo json_encode($exception1); ?>;
  console.log(rule_rescourceType);
  var ruleID = rule_rescourceType.split(",")[0];
  //var resourceTypeID = rule_rescourceType.split(",")[1];
  var resource_name = "";
  var resource_id = 0;
  var resource_ref = " ";
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
        non_compl = 1;
        if(rows_resource[j]['id'] == rows_non_compliant[i]['resource_id'])
        {            
          console.log(rows_resource[j]['resource_ref']);

          //checking if a non-compliant resource has an axception -> making a resource compliant
          for(var k=0; k<rows_except.length; k++)
          {
            if(rows_resource[j]['resource_ref'] === rows_except[k]['exception_value'])
            {
              
                console.log(rows_resource[j]['resource_name']);
                non_compl=0;
                break;
              
            }
          } 
          
          if(non_compl==1)
          {
            resource_name = rows_resource[j]['resource_name'];
            resource_id = rows_resource[j]['id'];
            resource_ref = rows_resource[j]['resource_ref'];
            console.log(resource_name, ruleID,resource_ref);

            var resourceID_ruleID_ref = resource_id+"_"+ruleID+"_"+resource_ref;
            select_dropdown.appendChild(addOption(resource_name, resourceID_ruleID_ref));
            console.log(resourceID_ruleID_ref);

          }
          
          //break;
        }
      }
    }

  }

}

// Code found  at : https://gist.github.com/jesperorb/a6c12f7d4418a167ea4b3454d4f8fb61
function formCompleted(){
  const form = document.getElementById('form');
  console.log("Enetered1")
  form.addEventListener('click', function(event){
    const formattedFormData = new FormData(form);
    postData(formattedFormData);
  });
  }
  
  async function postData(formattedFormData){
    const response = await fetch('PHP/addException.php',{
        method: 'POST',
        body: formattedFormData
    });
    location.reload();

    const data = await response.text();
    console.log(data);
    //location.reload();
  }

</script>
<script>
//making calendar visible
function checkCustom() {
  if (document.getElementById('custom').checked) {
    document.getElementById('addCustom').style.display = 'block';
    document.getElementById('customReviewDate').removeAttribute('disabled');

  }
  else
  {
    document.getElementById('addCustom').style.display= 'none';
    document.getElementById('customReviewDate').setAttribute('disabled', '');

  }
}
//setting radio button's value to be the value chosen on a calendar
function setNewValue()
{
  document.getElementById('custom').value = document.getElementById('customReviewDate').value;
  console.log(document.getElementById('custom').value);
}
</script>
