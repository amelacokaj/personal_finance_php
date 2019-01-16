<?php echo View::make('partials.header') ?>

	<div class="row">
		<div class="col-md-10">
			<h2 class="">Accounts</h2>
		</div>
		<div class="col-md-2">
			<a href="/<?php echo $resourceName; ?>/create" class="btn btn-success float-right">Shto Tjeter</a>
		</div>
	</div>
	<br>
		
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Code</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$recordsCount = count($records);	
		for($i=0; $i<$recordsCount; $i++) { ?>	
			<tr>
				<th scope="row"><?php echo $i+1; ?></th>
				<td><a href="<?php echo "/".$resourceName."/".$records[$i]->id."/edit"; ?>"><?php echo $records[$i]->name; ?></a></td>
				<td><?php echo $records[$i]->code; ?></td>
				<td><button class="btn btn-danger btn-sm float-right" 
						onclick="Utils.confirmDeletion('<?php echo $resourceName."','".$records[$i]->id."','".$records[$i]->name; ?>');">
						<i class="fa fa-trash" aria-hidden="true"></i>
					</button>
				</td>          
			</tr>
		<?php } ?>
		</tbody>
	</table>
<?php echo View::make('partials.footer') ?>
