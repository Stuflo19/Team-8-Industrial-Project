async function updatesuspended(exceptionid, suspended)
{
    // fetch statement found from: https://code-boxx.com/call-php-file-from-javascript/ && https://sebhastian.com/call-php-function-from-javascript/ 
    await fetch("PHP/suspend.php", {mode: 'cors', method: "POST", headers: {"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"}, body: `id=${exceptionid}&suspended=${suspended}`})
    .then(res => res.text())
    .then((txt) => {
        document.getElementById("suspendButton").value = txt == 1 ? "Unsuspend" : "Suspend";
    })
    .catch((err) => { console.error(err); });

    location.reload();
    return false;
}

function historybutton(id, rows)
{
  // rows: holds the rows read in from the database from PHP
  var ids = id.split(",");
  var currRow;
  
  document.getElementById("historybody").innerHTML = "";

  //Loops through all of the rows read in
  for(var i = 0; i < rows.length; i++) {

    //check if the rule id & the exception name match the values of the button pressed.
    if(rows[i]['rule_id'] == ids[1] && rows[i]['exception_value'] == ids[0])
    {
      console.log(rows[i]['suspended']);
      var currentDate = new Date();
      var today = new Date(currentDate.getFullYear() +"/"+ (currentDate.getMonth()+1) +"/"+ currentDate.getDate() + " " + currentDate.getUTCHours() + ":" + currentDate.getUTCMinutes());
      var review = new Date(rows[i]['review_date'].replace('-','/'));
      currRow = rows[i]['id'];
      currSuspended = rows[i]['suspended'];

      const tr = document.getElementById('historybody').insertRow();
      tr.insertCell().appendChild(document.createTextNode(rows[i]['id']));
      tr.insertCell().appendChild(document.createTextNode(rows[i]['last_updated_by']));
      tr.insertCell().appendChild(document.createTextNode(rows[i]['justification']));
      tr.insertCell().appendChild(document.createTextNode(today < review ? review : "EXPIRED"));
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

// https://www.javascripttutorial.net/javascript-dom/javascript-appendchild/#:~:text=The%20appendChild()%20is%20a,of%20a%20specified%20parent%20node.&text=In%20this%20method%2C%20the%20childNode,()%20returns%20the%20appended%20child.
function addOption(name, id){
  let option = document.createElement("option");
  option.text = name;
  option.value = id;

  return option;
}

// function addException(rule_rescourceType, rows_resource, rows_non_compliant,rows_except){
//   // var rows_resource = <?php echo json_encode($resource); ?>;
//   // var rows_non_compliant = <?php echo json_encode($non_compliant); ?>;
//   // var rows_except = <?php echo json_encode($exception); ?>;
//   //console.log(rule_rescourceType);
//   var ruleID = rule_rescourceType.split(",")[0];
//   //var resourceTypeID = rule_rescourceType.split(",")[1];
//   var resource_name = "";
//   var resource_id = 0;
//   var non_compl = 1;
//   //console.log(ruleID);
//   //console.log(resourceTypeID);
//   var select_dropdown = document.querySelector('#resourceList');
//   while (select_dropdown.firstChild) 
//   {
//     select_dropdown.removeChild(select_dropdown.firstChild);
//   }

//   for(var i = 0; i < rows_non_compliant.length; i++) {
//     //looking if a rule has non-compliant resources
//     if(rows_non_compliant[i]['rule_id'] == ruleID)
//     {
//       //finding the name of a resource
//       for(var j = 0; j < rows_resource.length; j++)
//       {
//         if(rows_resource[j]['id'] == rows_non_compliant[i]['resource_id'])
//         {
//           //checking if a non-compliant resource has an axception -> making a resource compliant
//           for(var k=0; k<rows_except.length; k++)
//           {
//             if(rows_resource[j]['resource_name'] === rows_except[k]['exception_value'])
//             {
//               non_compl=0;
//               break;
//             }
//           } 

//           if(non_compl==1)
//           {
//             resource_name = rows_resource[j]['resource_name'];
//             resource_id = rows_resource[j]['id'];
//             console.log(resource_name, ruleID);

//             var resourceID_ruleID = resource_id+"_"+ruleID;
//             select_dropdown.appendChild(addOption(resource_name, resourceID_ruleID));
//           }
          
//           break;
//         }
//       }
//     }

//   }

// }