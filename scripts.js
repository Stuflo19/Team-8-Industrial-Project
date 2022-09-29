function generateGraph()
{
  Chart.defaults.color = "#FFFFFF";
    const data = {
        labels: [
          'Compliant',
          'Non-Compliant',
        ],
        
        datasets: [{
          label: 'My First Dataset',
          data: [267, 170], //Number of compliant to non-compliant rules. Will need to be replaced when db is linked
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

            