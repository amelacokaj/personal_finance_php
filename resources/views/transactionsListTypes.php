<?php echo View::make('partials.header') ?>

  <div class="row">
		<div class="col-md-10">
			<h2><?php echo $type==1 ? "Income" : "Expense"; ?></h2>
		</div>
		<div class="col-md-2">
			<a href="/<?php echo $resourceName; ?>/create?type=<?php echo $type; ?>" class="btn btn-success float-right">Shto Tjeter</a>
		</div>
	</div>
	<br>
		
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Category</th>
				<th>Description</th>
				<th>Amount</th>
				<th>Date</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($records as $index=>$item){ ?>	
			<tr>
				<th scope="row"><?php echo $index+1; ?></th>
				<td><a href="<?php echo "/".$resourceName."/".$item->id."/edit"; ?>"><?php echo $item->category_name; ?></a></td>
				<td><?php echo $item->description; ?></td>
				<td><?php echo $item->amount; ?></td>
				<td><?php echo date("d-m-Y", strtotime($item->date)); ?></td>
				<td><button class="btn btn-danger btn-sm float-right" 
						onclick="Utils.confirmDeletion('<?php echo $resourceName."','".$item->id."','".$item->category_name; ?>');">
						<i class="fa fa-trash" aria-hidden="true"></i>
					</button>
				</td>          
			</tr>
		<?php } ?>
		</tbody>
	</table>

<?php echo View::make('partials.footer') ?>