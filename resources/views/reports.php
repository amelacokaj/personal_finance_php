<?php echo View::make('partials.header') ?>

  <script src='/chartsjs/Chart.bundle.min.js'></script>

  <style>
  </style>
  
  <script>  
    var barChartData = {
      labels: [
        new Date("2015-3-15 13:3").toLocaleString(), 
        new Date("2015-3-25 13:2").toLocaleString(), 
        new Date("2015-3-25 13:5").toLocaleString(), 
        new Date("2015-4-25 14:12").toLocaleString()
      ],
      datasets: [{
        label: 'Expense',
        data: [{
            t: new Date("2015-3-15 13:3"),
            y: 2000
          },
          {
            t: new Date("2015-3-25 13:2"),
            y: 4000
          },
          {
            t: new Date("2015-3-25 13:5"),
            y: 1200
          },
          {
            t: new Date("2015-4-25 14:12"),
            y: 500
          }
        ],
        backgroundColor: "lightgreen",
        borderColor: "green",
        borderWidth: 1,
      }, {
        label: 'Income',
        data: [{
            t: new Date("2015-3-15 13:3"),
            y: 50
          },
          {
            t: new Date("2015-3-25 13:2"),
            y: 10000
          },
          {},
          {
            t: new Date("2015-4-25 14:12"),
            y: 2500
          }
        ],
        backgroundColor: "lightblue",
        borderColor: "blue",
        borderWidth: 1,
      }]
    };

    var chartOptions = {
      responsive: true,
      legend: {
        position: "top"
      },
      title: {
        display: true,
        text: "Chart.js Bar Chart"
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    };
  
    $(function() {
      var ctx = document.getElementById("chartview").getContext("2d");
      window.myBar = new Chart(ctx, {
        type: "bar",
        data: barChartData,
        options: chartOptions
      });
    });
  </script>

  <canvas id="chartview"></canvas>

<?php echo View::make('partials.footer') ?>
