<?php echo View::make('partials.header') ?>

  <h1 class="display-6">Ledger(Income/Expense)</h1>
  <div class="row">
      <table class="table table-bordered">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Date</th>
            <th scope="col">Transactions</th>
            <th scope="col">Categories</th>
            <th scope="col">Debi</th>
            <th scope="col">Kredi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Income</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
  </div>

<?php echo View::make('partials.footer') ?>