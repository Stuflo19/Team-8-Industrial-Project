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
      var review = new Date(exception[i]['review_date'].replace('-', '/'));
      currRow = exception[i]['id'];
      currSuspended = exception[i]['suspended'];

      const tr = document.getElementById('historybody').insertRow();
      tr.insertCell().appendChild(document.createTextNode(exception[i]['id']));
      tr.insertCell().appendChild(document.createTextNode(exception[i]['last_updated_by']));
      tr.insertCell().appendChild(document.createTextNode(exception[i]['justification']));
      tr.insertCell().appendChild(document.createTextNode(today < review ? review : "EXPIRED"));
      // This is the most painful button you'll see in this project
      if(user_role == "1"){
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
              exc_check = true;
              exception[k]['suspended'] == 0 ? sus_check = false : sus_check = true;
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
}
// https://www.javascripttutorial.net/javascript-dom/javascript-appendchild/#:~:text=The%20appendChild()%20is%20a,of%20a%20specified%20parent%20node.&text=In%20this%20method%2C%20the%20childNode,()%20returns%20the%20appended%20child.
function addOption(name, id){
  let option = document.createElement("option");
  option.text = name;
  option.value = id;

  return option;
}

async function addReview()
{
  var newJustification = document.getElementById("revJustification").value;
  var newReviewDate = document.getElementById("revDate").value;

  await fetch("PHP/addReview.php", { mode: 'cors', method: "POST", headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, body: `newJustification=${newJustification}&newReviewDate=${newReviewDate}&exceptionValue=${oldData[0]}&exceptionId=${oldData[1]}&ruleId=${oldData[2]}&oldJustification=${oldData[3]}&oldReview=${oldData[4]}`})
  .then(res => res.text())
  .then((txt) => {
    console.log(txt);
  })
  .catch((err) => { console.error(err); });
  
  refresh();
  return false;
}