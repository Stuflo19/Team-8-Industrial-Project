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

  for(var i = 0; i < exceptions.length; i++) 
  {
    const currDate = new Date(); //Todays date
    var review = new Date(exceptions[i]['review_date']); //Review Date
    
    const msBetweenDates = review.getTime() - currDate.getTime(); //Calculates time between dates in milliseconds

    // convert ms to days                     hour  min  sec   ms
    const daysBetweenDates = msBetweenDates / (24 * 60 * 60 * 1000);
    console.log(daysBetweenDates);

    //Button to review exceptions
    var revBtn = document.createElement('button');
    revBtn.type = "button";
    revBtn.textContent = "Review ";
    revBtn.id = exceptions[i].exception_value + "," + exceptions[i].id;
    revBtn.addEventListener("click", function () {
      // Button Click
    });
    
    revBtn.setAttribute('data-toggle', 'modal');
    revBtn.setAttribute('style', 'justify-content: center; align-items: center;');
    //btn.setAttribute('data-target', '#reviewModal');
    revBtn.className = "btn btn-outline-warning historybutton";
    
    //Adds exalamtion icon to indicate the review is up and coming
    var revIcon = document.createElement('i');
    revIcon.type = "i";
    revIcon.className = "fa fa-solid fa-circle-exclamation";
    revIcon.value = "Review";

    //Adds icon into button
    revBtn.appendChild(revIcon);
    
    //If review date coming up within 30days
    if(daysBetweenDates < 30 && daysBetweenDates > 0) 
    { 
      numOfUpcoming = numOfUpcoming + 1;
      const tr = document.getElementById('reviewbody').insertRow();
      
      var scrollId = document.createElement('a'); 
      scrollId.appendChild(document.createTextNode(exceptions[i]['rule_id']));
      scrollId.setAttribute('href', '#RuleCard' + exceptions[i]['rule_id']);
      
      tr.insertCell().appendChild(document.createTextNode(exceptions[i]['id']));
      tr.insertCell().appendChild(document.createTextNode(exceptions[i]['exception_value']));
      tr.insertCell().appendChild(scrollId);
      tr.insertCell().appendChild(document.createTextNode(exceptions[i]['last_updated_by']));
      tr.insertCell().appendChild(document.createTextNode(exceptions[i]['justification']));
      tr.insertCell().appendChild(document.createTextNode(exceptions[i]['review_date'].replaceAll('-', '/')));
      tr.insertCell().appendChild(revBtn);
    } 

  }
  if(numOfUpcoming == 0)
  {
    document.getElementById("reviewbody").innerHTML = "There are no upcoming review dates";
  }
}
  