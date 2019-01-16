<?php echo View::make('partials.header') ?>

  <script src='/chartsjs/Chart.bundle.min.js'></script>

  <style>
  </style>
  
  <script>  
    var barChartData = {
      labels: JSON.parse('<?php echo json_encode($labels); ?>'),
      datasets: [{
        label: 'Income',
        data: JSON.parse('<?php echo json_encode($incomeData); ?>'),
        backgroundColor: "lightgreen",
        borderColor: "green",
        borderWidth: 1,
      },{
        label: 'Expense',
        data: JSON.parse('<?php echo json_encode($expenseData); ?>'),
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
        text: "Transactions by Date"
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
