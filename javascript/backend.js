var currFilter;

async function updatesuspended(data) {
  split = data.split(',');
  // fetch statement found from: https://code-boxx.com/call-php-file-from-javascript/ && https://sebhastian.com/call-php-function-from-javascript/ 
  await fetch("PHP/suspend.php", {mode: 'cors', method: "POST", headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, body: `id=${split[0]}&suspended=${split[1]}&ruleid=${split[2]}` })
    .then(res => res.text())
    .then((txt) => {
      console.log(txt);
    })
    .catch((err) => { console.error(err); });

  location.reload();
  return false;
}

function refresh() {
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
      var review = new Date(exception[i]['review_date'].replaceAll('-', '/'));
      var review_date = review.toUTCString();
      currRow = exception[i]['id'];
      currSuspended = exception[i]['suspended'];

      const tr = document.getElementById('historybody').insertRow();
      tr.insertCell().appendChild(document.createTextNode(exception[i]['id']));
      tr.insertCell().appendChild(document.createTextNode(today < review ? review_date : "EXPIRED"));
      tr.insertCell().appendChild(document.createTextNode(exception[i]['justification']));
      tr.insertCell().appendChild(document.createTextNode(exception[i]['last_updated_by']));
      // This is the most painful button you'll see in this project
      if(user_role == "1"){
        var btn = document.createElement('input');
        btn.type = "submit";
        btn.value = exception[i]['suspended'] == 0 ? 'Suspend' : "Unsuspend";
        btn.id = exception[i]['id'] + "," + exception[i]['suspended'] + "," + exception[i]['rule_id'];
        btn.addEventListener("click", function () {
          updatesuspended(this.id);
        });
        btn.className = "btn btn-outline-warning";
        tr.insertCell().appendChild(btn);
      }
    }
  }

  return false;
}

// Fetch function to the 
async function logout() {
  await fetch("PHP/logout.php", { mode: 'cors', method: "POST", headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }})
  .then(res => res.text())
  .catch((err) => { console.error(err); });
  
  refresh();
  return false;
}

//Function to detect a filter change
async function filter(id) {
  ids = id.split(',');

  //gets the selection box and checks is current value
  var selectBox = document.getElementById(id);
  currFilter = selectBox.options[selectBox.selectedIndex].value;

  //loops through all rules and updates their contents
  // for(let i = 0; i < rules.length; i++) {
    result_rule = rules[ids[1]-1];
    await generateResources();
  // }

  return false;
}

//Function to generate resources inside of rule cards
async function generateResources() {
  var non_comp_counter = 0;
  var comp_counter = 0;

  //populate description paragraph
  document.getElementById("Description" + result_rule.id).innerHTML = result_rule.description;

  //empties the table
  document.getElementById("Table" + result_rule.id).innerHTML = "";

  //loops  through all resources
  for (let i = 0; i < resource.length; i++) {
    var checked = false;
    var exc_check = false;
    var sus_check = false;

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
              var excDate = new Date(exception[k]['review_date']);
              var currDate = new Date();

              if(currDate < excDate)
              {
                exc_check = true;
                exception[k]['suspended'] == 0 ? sus_check = false : sus_check = true;
                checked = exception[k]['suspended'] == 0 ? false : true;
                break;
              }
            }
          }
       }
        //if the resource exists in the id array && ruleID at index of resource in the rules array
      }

      //Skips the row if a filter is active
      if(currFilter == "Non-Compliant" && checked == false){continue;} 
      if(currFilter == "Compliant" && checked == true){continue;}
      
       //incrementing display counter
       if(checked == false){comp_counter++;}
       if(checked == true){non_comp_counter++;}
       
      //Creates div for compliance displaying
      var div = document.createElement('Div');
      div.innerHTML = checked ? "Non-Compliant" : "Compliant";
      div.className = checked ? "exception-status" : "active-status";

      var exceptionicon = document.createElement('i');
      exceptionicon.setAttribute('class', !exc_check ? 'fa fa-xmark fa-lg' : 'fa fa-check fa-lg');

      var suspendedicon = document.createElement('i');
      suspendedicon.setAttribute('class', !sus_check ? 'fa fa-xmark fa-lg' : 'fa fa-check fa-lg');

      //creates a button to display exception history
      var btn = document.createElement('input');
      btn.type = "button";
      btn.value = "Exception History";
      btn.id = resource[i].resource_ref + "," + result_rule.id;
      btn.addEventListener("click", function () {
        console.log(this.id);
        historybutton(this.id);
      });
      btn.setAttribute('data-toggle', 'modal');
      btn.setAttribute('data-target', '#historyModal');
      btn.className = "btn btn-outline-warning historybutton";
      
      //Insert the data into the table
      tr.insertCell().appendChild(document.createTextNode(resource[i]['resource_name']));
      tr.insertCell().appendChild(div);
      tr.insertCell().appendChild(exceptionicon);
      tr.insertCell().appendChild(suspendedicon);
      tr.insertCell().appendChild(btn);
    }
  }
  //getting the amount of compliant and non-compliant resources for each rule
  document.getElementById('non_comp_notification' + result_rule.id).innerHTML = non_comp_counter;
  document.getElementById('comp_notification' + result_rule.id).innerHTML = comp_counter;
}
//  Code was found on https://www.javascripttutorial.net/javascript-dom/javascript-appendchild/#:~:text=The%20appendChild()%20is%20a,of%20a%20specified%20parent%20node.&text=In%20this%20method%2C%20the%20childNode,()%20returns%20the%20appended%20child.
// Dynamicaly adding options
function addOption(name, id){
  let option = document.createElement("option");
  option.text = name;
  option.value = id;

  return option;
}