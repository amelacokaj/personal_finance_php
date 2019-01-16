<?php echo View::make('partials.header') ?>

  <div class="row">
		<div class="col-md-10">
			<h2>Ledger/Transactions</h2>
		</div>
		<div class="col-md-2">
			<a href="/<?php echo $resourceName; ?>/create" class="btn btn-success float-right">Shto Tjeter</a>
		</div>
	</div>
	<br>
		
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Date</th>
				<th>Transactions</th>
				<th>Description</th>
				<th>Type</th>
				<th>Debi</th>
				<th>Kredi</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($records as $index=>$item){ ?>	
			<tr>
				<td><?php echo date("d-m-Y", strtotime($item->date)); ?></td>
				<td><a href="<?php echo "/".$resourceName."/".$item->id."/edit"; ?>"><?php echo $item->category_name; ?></a></td>
				<td><?php echo $item->description; ?></td>
				<td><?php echo $item->type == 0 ? "debit" : "kredit"; ?></td>
				<td><?php echo $item->type == 0 ? $item->amount : ""; ?></td>
				<td><?php echo $item->type == 1 ? $item->amount : ""; ?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>

<?php echo View::make('partials.footer') ?>