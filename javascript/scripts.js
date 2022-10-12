var oldData = [];

function callAll(x, y, row)
{
  setDate();
  generateGraph(x, y);
  upcomingReviews(row);
}

function setDate() {
  var today = new Date();
  document.getElementById("date").innerHTML = "Last Checked: " + today.toDateString() + " " + today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
}

function hide() {
  if(user_role3 == "2")
  {
    document.getElementById("uprev").style.display = 'none';
  }
}

function hide1() {
  if(user_role4 == "2")
  {
    document.getElementById("uprev1").style.display = 'none';
  }
}

function hide2() {
  if(user_role5 == "2")
  {
    document.getElementById("uprev2").style.display = 'none';
  }
}

function generateGraph(noncompliant, compliant)
{
  trueComp = compliant - noncompliant
  Chart.defaults.color = "#FFFFFF";
    const data = {
        labels: [
          'Compliant',
          'Non-Compliant',
        ],
        
        datasets: [{
          label: 'My First Dataset',
          data: [trueComp, noncompliant], //Number of compliant to non-compliant rules. Will need to be replaced when db is linked
          backgroundColor: [
            '#40b640', //Compliant Colour
            '#d63030' //Non-Compliant Colour
          ],
          borderColor: [
            '#000000'
          ],
          hoverOffset: 4
        }]
      };

      const config = {
        type: 'doughnut',
        data: data,
      };
    
      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
      
}

// Help from https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/abs
function upcomingReviews(exceptions) 
{
  var numOfUpcoming = 0;

  document.getElementById("reviewbody").innerHTML = "";
  document.getElementById("expiredbody").innerHTML = "";

  for(var i = 0; i < exceptions.length; i++) 
  {
    const currDate = new Date(); //Todays date
    
    var review = new Date(exceptions[i]['review_date'].replaceAll('-','/'));

    const msBetweenDates = review.getTime() - currDate.getTime();
    console.log('Current Date: ' + currDate + ' | Review Date: ' + review);

    // convert ms to days                     hour  min  sec   ms
    const daysBetweenDates = msBetweenDates / (24 * 60 * 60 * 1000);
    console.log('Exception No: ' + exceptions[i].id + ' | Days: ' + daysBetweenDates);

    //Button to review exceptions
    var revBtn = document.createElement('button');
    revBtn.type = "button";
    revBtn.textContent = "Review ";
    
    revBtn.id = exceptions[i].exception_value + "," + exceptions[i].id + "," + exceptions[i].rule_id + "," + exceptions[i].justification + "," + exceptions[i].review_date;
    revBtn.addEventListener("click", function () {
      oldData = [];
      // Button click
      var ids = this.id.split(',');
      for (var i = 0; i < ids.length; i++) {
        oldData.push(ids[i]);
      }
      console.log(oldData);
    });
    
      revBtn.setAttribute('data-toggle', 'modal');
      revBtn.setAttribute('style', 'justify-content: center; align-items: center;');
      revBtn.setAttribute('data-target', '#reviewException');
      revBtn.className = "btn btn-outline-warning historybutton";
      
      var revIcon = document.createElement('i');
      revIcon.type = "i";
      revIcon.className = "fa fa-solid fa-circle-exclamation";
      revIcon.value = "Review";

      revBtn.appendChild(revIcon);  
        
      //If review date coming up within 30days
      if(daysBetweenDates < 31 && daysBetweenDates > 0) 
      {  
        numOfUpcoming = numOfUpcoming + 1;
        const tr = document.getElementById('reviewbody').insertRow();

        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['id']));
        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['exception_value']));
        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['rule_id']));
        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['last_updated_by']));
        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['justification']));
        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['review_date'].replaceAll('-','/')));
        if(user_role1 == "2")
        {
          tr.insertCell().appendChild(revBtn);
        }
      }
      else if(daysBetweenDates < 0)
      {
        const tr = document.getElementById('expiredbody').insertRow();

        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['id']));
        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['exception_value']));
        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['rule_id']));
        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['last_updated_by']));
        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['justification']));
        tr.insertCell().appendChild(document.createTextNode(exceptions[i]['review_date'].replaceAll('-','/')));
        if(user_role2 == "2")
        {
          tr.insertCell().appendChild(revBtn);
        }
      }
    }
    if(numOfUpcoming == 0)
    {
      document.getElementById("reviewbody").innerHTML = "There are no upcoming review dates";
    }
}
  

            