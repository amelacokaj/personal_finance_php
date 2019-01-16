<?php echo View::make('partials.header') ?>

  <link href='/fullcalendar-3.9.0/fullcalendar.min.css' rel='stylesheet' />
  <link href='/fullcalendar-3.9.0/fullcalendar.print.css' rel='stylesheet' media='print' />
  
  <script src='/fullcalendar-3.9.0/fullcalendar.min.js'></script>

  <style>
    #calendar {
      margin: 40px auto;
    }
  </style>
  
  <script>

    $(function() {

      $('#calendar').fullCalendar({
        themeSystem: 'bootstrap4',
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay,listMonth'
        },
        weekNumbers: true,
        eventLimit: true, // allow "more" link when too many events
        events: '/home/calendar'
      });

    });

  </script>

  <div class="row">
    <div class="col-md-4">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="row">MONTH</th>
            <th scope="row"> </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Income</th>
            <td><?php echo $monthAggregates["income"]; ?> leke</td>
          </tr>
          <tr>
            <th scope="row">Expense</th>
            <td><?php echo $monthAggregates["expense"]; ?> leke</td>
          </tr>
          <tr>
            <th scope="row">Balance</th>
            <td><?php echo $monthAggregates["income"] - $monthAggregates["expense"]; ?> leke</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col-md-4 offset-md-4">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="row">TODAY</th>            
            <th scope="row"> </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Income</th>
            <td><?php echo $todayAggregates["income"]; ?> leke</td>
          </tr>
          <tr>
            <th scope="row">Expense</th>
            <td><?php echo $todayAggregates["expense"]; ?> leke</td>
          </tr>
          <tr>
            <th scope="row">Balance</th>
            <td><?php echo $todayAggregates["income"] - $todayAggregates["expense"]; ?> leke</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div id='calendar'></div>


<?php echo View::make('partials.footer') ?>
