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

function historybutton(id, rows) {
  // rows: holds the rows read in from the database from PHP
  var ids = id.split(",");
  var currRow;

  document.getElementById("historybody").innerHTML = "";

  //Loops through all of the rows read in
  for (var i = 0; i < rows.length; i++) {

    //check if the rule id & the exception name match the values of the button pressed.
    if (rows[i]['rule_id'] == ids[1] && rows[i]['exception_value'] == ids[0]) {
      console.log(rows[i]['suspended']);
      var currentDate = new Date();
      var today = new Date(currentDate.getFullYear() + "/" + (currentDate.getMonth() + 1) + "/" + currentDate.getDate() + " " + currentDate.getUTCHours() + ":" + currentDate.getUTCMinutes());
      var review = new Date(rows[i]['review_date'].replace('-', '/'));
      currRow = rows[i]['id'];
      currSuspended = rows[i]['suspended'];

      const tr = document.getElementById('historybody').insertRow();
      tr.insertCell().appendChild(document.createTextNode(rows[i]['id']));
      tr.insertCell().appendChild(document.createTextNode(rows[i]['last_updated_by']));
      tr.insertCell().appendChild(document.createTextNode(rows[i]['justification']));
      tr.insertCell().appendChild(document.createTextNode(today < review ? review : "EXPIRED"));
      // This is the most painful button you'll see in this project
      var btn = document.createElement('input');
      btn.type = "button";
      btn.value = rows[i]['suspended'] == 0 ? 'Suspend' : "Unsuspend";
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

function filter() {
  var selectBox = document.getElementById("filter-list");
  currFilter = selectBox.options[selectBox.selectedIndex].value;

  console.log(currFilter);
  generateResources();
  return false;
}

function generateResources(result_rule, resource, non_compliance, exception) {
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

      if(currFilter == "Non-Compliant" && !checked)
      {
        continue;
      } 

      var div = document.createElement('Div');
      div.innerHTML = checked ? "Non-Compliant" : "Compliant";
      div.className = checked ? "exception-status" : "active-status";

      tr.insertCell().appendChild(document.createTextNode(resource[i]['resource_name']));
      tr.insertCell().appendChild(div);
        // echo '<td style="vertical-align: middle">' + checked ? '<div class="exception-status"> Non-Compliant' : '<div class="active-status"> Compliant' + '</div></td>';
        // echo "<td style='vertical-align: middle'><button type='button' class='btn btn-outline-warning historybutton' data-toggle='modal' data-target='#historyModal' id='{resource[i]["resource_name"]},{$result_rule["id"]}' onclick='historybutton(this.id, ".json_encode($exception).")'>Exception History</button></td></tr>";
    }
  }
}