var currFilter;

async function updatesuspended(exceptionid, suspended) {
  // fetch statement found from: https://code-boxx.com/call-php-file-from-javascript/ && https://sebhastian.com/call-php-function-from-javascript/ 
  await fetch("PHP/suspend.php", { mode: 'cors', method: "POST", headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, body: `id=${exceptionid}&suspended=${suspended}` })
    .then(res => res.text())
    .then((txt) => {
      document.getElementById("suspendButton").value = txt == 1 ? "Unsuspend" : "Suspend";
    })
    .catch((err) => { console.error(err); });

  location.reload();
  return false;
}
function addException(rule_rescourceType,rows_resource,rows_non_compliant,rows_except){
  console.log(rule_rescourceType);
  var ruleID = rule_rescourceType.split(",")[0];
  //var resourceTypeID = rule_rescourceType.split(",")[1];
  var resource_name = "";
  var resource_id = 0;
  var resource_ref = " ";
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
    console.log("Enetered2");
    const data = await response.text();
    console.log(data);
    location.reload();
  
  }

function historybutton(id) {
  // rows: holds the rows read in from the database from PHP
  var ids = id.split(",");
  var currRow;

  document.getElementById("historybody").innerHTML = "";

  //Loops through all of the rows read in
  for (var i = 0; i < exception.length; i++) {

    //check if the rule id & the exception name match the values of the button pressed.
    if (exception[i]['rule_id'] == ids[1] && exception[i]['exception_value'] == ids[0]) {
      var currentDate = new Date();
      var today = new Date(currentDate.getFullYear() + "/" + (currentDate.getMonth() + 1) + "/" + currentDate.getDate() + " " + currentDate.getUTCHours() + ":" + currentDate.getUTCMinutes());
      var review = new Date(exception[i]['review_date'].replace('-', '/'));
      currRow = exception[i]['id'];
      currSuspended = exception[i]['suspended'];

      const tr = document.getElementById('historybody').insertRow();
      tr.insertCell().appendChild(document.createTextNode(exception[i]['id']));
      tr.insertCell().appendChild(document.createTextNode(exception[i]['last_updated_by']));
      tr.insertCell().appendChild(document.createTextNode(exception[i]['justification']));
      tr.insertCell().appendChild(document.createTextNode(today < review ? review : "EXPIRED"));
      // This is the most painful button you'll see in this project
      var btn = document.createElement('input');
      btn.type = "button";
      btn.value = exception[i]['suspended'] == 0 ? 'Suspend' : "Unsuspend";
      btn.id = "suspendButton";
      btn.addEventListener("click", function () {
        updatesuspended(currRow, currSuspended);
      });
      btn.className = "btn btn-outline-warning";
      tr.insertCell().appendChild(btn);
    }
  }

  return false;
}

//Function to detect a filter change
async function filter() {
  //gets the selection box and checks is current value
  var selectBox = document.getElementById("filter-list");
  currFilter = selectBox.options[selectBox.selectedIndex].value;

  //loops through all rules and updates their contents
  for(let i = 0; i < rules.length; i++) {
    result_rule = rules[i];
    await generateResources();
  }

  return false;
}

//Function to generate resources inside of rule cards
async function generateResources() {
  //empties the table
  document.getElementById("Table" + result_rule.id).innerHTML = "";

  //loops  through all resources
  for (let i = 0; i < resource.length; i++) {
    var checked = false;

    //checks if the rule applies to the resource
    if (resource[i]['resource_type_id'] == result_rule['resource_type_id']) {
      //create a table row.
      var tr = document.getElementById('Table' + result_rule['id']).insertRow();

      //if the resource id is in the non_compliance table
      if (JSON.stringify(non_compliance).includes(resource[i]['id'])) {
        //loop to set the resource to non-compliant if there is a match in the non_compliance table
        for (let j = 0; j < non_compliance.length; j++) {
          non_compliance[j]['rule_id'] == result_rule["id"] && non_compliance[j]['resource_id'] == resource[i]['id'] ? checked = true : checked = false;
          if (checked) { break; }
        }

        //If the resource is set to be non-compliant
        if (checked) {
          //check to see if the resource contains an exception
          for(let k = 0; k < exception.length; k++)
          {
            if (result_rule['id'] == exception[k]['rule_id'] && resource[i]['resource_ref'] == exception[k]['exception_value']) {
              checked = exception[k]['suspended'] == 0 ? false : true;
              break;
            }
          }
       }
        //if the resource exists in the id array && ruleID at index of resource in the rules array
      }

      //Skips the row if a filter is active
      if(currFilter == "Non-Compliant" && checked == false){continue;} 
      if(currFilter == "Compliant" && checked == true){continue;}

      //Creates div for compliance displaying
      var div = document.createElement('Div');
      div.innerHTML = checked ? "Non-Compliant" : "Compliant";
      div.className = checked ? "exception-status" : "active-status";

      //creates a button to display exception history
      var btn = document.createElement('input');
      btn.type = "button";
      btn.value = "Exception History";
      btn.id = resource[i].resource_name + "," + result_rule.id;
      btn.addEventListener("click", function () {
        historybutton(this.id);
      });
      btn.setAttribute('data-toggle', 'modal');
      btn.setAttribute('data-target', '#historyModal');
      btn.className = "btn btn-outline-warning historybutton";
      
      //Insert the data into the table
      tr.insertCell().appendChild(document.createTextNode(resource[i]['resource_name']));
      tr.insertCell().appendChild(div);
      tr.insertCell().appendChild(btn);
    }
  }
}
// https://www.javascripttutorial.net/javascript-dom/javascript-appendchild/#:~:text=The%20appendChild()%20is%20a,of%20a%20specified%20parent%20node.&text=In%20this%20method%2C%20the%20childNode,()%20returns%20the%20appended%20child.
function addOption(name, id){
  let option = document.createElement("option");
  option.text = name;
  option.value = id;

  return option;
}



