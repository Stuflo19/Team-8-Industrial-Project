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

async function filter() {
  var selectBox = document.getElementById("filter-list");
  currFilter = selectBox.options[selectBox.selectedIndex].value;
  for(let i = 0; i < rules.length; i++) {
    result_rule = rules[i];
    await generateResources();
  }
  return false;
}

async function generateResources() {
  console.log("Round 2");
  document.getElementById("Table" + result_rule.id).innerHTML = "";
  for (let i = 0; i < resource.length; i++) {
    var checked = false;
    if (resource[i]['resource_type_id'] == result_rule['resource_type_id']) {
      var tr = document.getElementById('Table' + result_rule['id']).insertRow();
      if (JSON.stringify(non_compliance).includes(resource[i]['id'])) {
        for (let j = 0; j < non_compliance.length; j++) {
          non_compliance[j]['rule_id'] == result_rule["id"] && non_compliance[j]['resource_id'] == resource[i]['id'] ? checked = true : checked = false;
          if (checked) { break; }
        }

        if (checked) {
          for(let k = 0; k < exception.length; k++)
          {
            if (result_rule['id'] == exception[k]['rule_id'] && resource[i]['resource_name'] == exception[k]['exception_value']) {
              checked = exception[k]['suspended'] == 0 ? false : true;
              break;
            }
          }
       }
        //if the resource exists in the id array && ruleID at index of resource in the rules array
      }

      if(currFilter == "Non-Compliant" && checked == false){continue;} 
      if(currFilter == "Compliant" && checked == true){continue;}

      var div = document.createElement('Div');
      div.innerHTML = checked ? "Non-Compliant" : "Compliant";
      div.className = checked ? "exception-status" : "active-status";

      var btn = document.createElement('input');
      btn.type = "button";
      btn.value = "Exception History";
      btn.id = resource[i].resource_name + "," + result_rule.id;
      btn.addEventListener("click", function () {
        document.getElementById("historyModal").style.display = 'block';
        historybutton(this.id);
      });
      btn.setAttribute('data-toggle', 'modal');
      btn.setAttribute('data-target', '#historyModal');
      btn.className = "btn btn-outline-warning";


      tr.insertCell().appendChild(document.createTextNode(resource[i]['resource_name']));
      tr.insertCell().appendChild(div);
      tr.insertCell().appendChild(btn);
        // echo '<td style="vertical-align: middle">' + checked ? '<div class="exception-status"> Non-Compliant' : '<div class="active-status"> Compliant' + '</div></td>';
        // echo "<td style='vertical-align: middle'><button type='button' class='btn btn-outline-warning historybutton' data-toggle='modal' data-target='#historyModal' id='{resource[i]["resource_name"]},{$result_rule["id"]}' onclick='historybutton(this.id, ".json_encode($exception).")'>Exception History</button></td></tr>";
    }
  }
}