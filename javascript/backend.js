function historybutton(id, rows)
{
  // rows: holds the rows read in from the database from PHP
  var ids = id.split(",");
  
  document.getElementById("historybody").innerHTML = "";

  //Loops through all of the rows read in
  for(var i = 0; i < rows.length; i++) {

    //check if the rule id & the exception name match the values of the button pressed.
    if(rows[i]['rule_id'] == ids[1] && rows[i]['exception_value'] == ids[0])
    {
      var currentDate = new Date();
      var today = new Date(currentDate.getFullYear() +"/"+ (currentDate.getMonth()+1) +"/"+ currentDate.getDate() + " " + currentDate.getUTCHours() + ":" + currentDate.getUTCMinutes());
      var review = new Date(rows[i]['review_date'].replace('-','/'));

      const tr = document.getElementById('historybody').insertRow();
      tr.insertCell().appendChild(document.createTextNode(rows[i]['id']));
      tr.insertCell().appendChild(document.createTextNode(rows[i]['last_updated_by']));
      tr.insertCell().appendChild(document.createTextNode(rows[i]['justification']));
      tr.insertCell().appendChild(document.createTextNode(today < review ? rows[i]['review_date'] : "EXPIRED"));
      var btn = document.createElement('input');
      btn.type = "button";
      btn.value = 'Suspend';
      btn.className = "btn btn-outline-warning";
      tr.insertCell().appendChild(btn);
    }
  }
}