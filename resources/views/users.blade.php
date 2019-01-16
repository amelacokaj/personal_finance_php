@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10">
			<h2 class="">Perdoruesit</h2>
		</div>
		<div class="col-md-2"> 
			<a href="/<?php echo $resourceName; ?>/create" class="btn btn-success pull-right">Shto Tjeter</a>
		</div>
	</div>
	<br>

	<table class="table table-hover">
		<thead>
			<tr>
			<th>&nbsp;</th>
			<th>Email</th>
			<th>Emri</th>
			<th>Mbiemri</th>
			<th>Niveli i Aksesit</th>
			<th>Gjendja</th>
			<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$usersCount = count($records);
		
		for($i=0; $i < $usersCount; $i++) {
			$statusLabel = '';
			$statusClass = '';
			if($records[$i]->status==0)
			{
				$statusLabel = "Jo Aktiv";
				$statusClass = 'warning';
			}
			else if($records[$i]->status==1)
			{
				$statusLabel = "Aktiv";
				$statusClass = '';		
			}
			else// if($records[$i]->status==2)//default
			{
				$statusLabel = "Bllokuar";
				$statusClass = 'danger';
			}
		?>
			<tr class="<?php echo $statusClass; ?>">
				<th scope="row">&nbsp;</th>
				<td><a href="<?php echo "/".$resourceName."/".$records[$i]->id."/edit"; ?>"><?php echo $records[$i]->email; ?></a></td>
				<td><?php echo $records[$i]->firstname; ?></td>
				<td><?php echo $records[$i]->lastname; ?></td>
				<td><?php echo $records[$i]->locations_id == 0 ? 'Admin' : $records[$i]->location_name ; ?></td>
				<td><?php echo $statusLabel; ?></td>
				<td><button class="btn btn-danger btn-sm float-right" 
							onclick="Utils.confirmDeletion('<?php echo $resourceName."','".$records[$i]->id."','".$records[$i]->firstname.' '.$records[$i]->lastname; ?>');">
						<i class="fa fa-trash" aria-hidden="true"></i>
					</button>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	
	<?php echo $records->render(); ?>
	<br>

@endsection