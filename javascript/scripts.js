function callAll(x, y, row)
{
  
  generateGraph(x, y);
  upcomingReviews(row);
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
  console.log("Below Here");
  console.log(exceptions[0]['review_date']);
  console.log("Above Here");

  document.getElementById("reviewbody").innerHTML = "";

  for(var i = 0; i < exceptions.length; i++) 
  {
    const currDate = new Date(); //Todays date
    console.log("CurrDate: " + currDate);
    var today = new Date(currDate.getFullYear() +"/"+ (currDate.getMonth()+1) +"/"+ currDate.getDate() + " " + currDate.getUTCHours() + ":" + currDate.getUTCMinutes());
    var review = new Date(exceptions[i]['review_date'].replace('-','/'));
    const msBetweenDates = review.getTime() - today.getTime();
    console.log("Review Date: " + review);
    console.log("Today's date: " + today);

    // convert ms to days                     hour  min  sec   ms
    const daysBetweenDates = msBetweenDates / (24 * 60 * 60 * 1000);
        
    console.log(daysBetweenDates); //Debug testing to show how many days until

    //If past review date
    if (daysBetweenDates < 0) 
    { 
          console.log('Expired'); 
        } 
        
        //If review date coming up within 30days
        else if(daysBetweenDates < 30) 
        { 
          console.log('date is within 30 days'); 

          const tr = document.getElementById('reviewbody').insertRow();
          tr.insertCell().appendChild(document.createTextNode(exceptions[i]['id']));
          tr.insertCell().appendChild(document.createTextNode(exceptions[i]['last_updated_by']));
          tr.insertCell().appendChild(document.createTextNode(exceptions[i]['justification']));
          tr.insertCell().appendChild(document.createTextNode(today < review ? review : "EXPIRED"));
        } 

        else 
        { //If review date is longer than 30 days out
          console.log('date is NOT within 30 days')
        }
    }
}
  

            