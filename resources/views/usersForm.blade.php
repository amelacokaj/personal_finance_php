@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="row">
	<form class="offset-md-2 col-md-8" action="/<?php echo isset($client)?'edit-account':'users'; ?>" method="post">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<?php $model = isset($model)?$model:[]; ?>
		
		<h2><?php echo isset($client)?'Ndryso te dhenat personale':(isset($model['id'])?'Modifiko':'Regjistro').' Perdorues'; ?></h2></br>
		
		<?php if (count($errors) > 0) { ?>
			<div class="alert alert-danger">
				<ul>
					<?php foreach ($errors->all() as $error){ ?>
						<li><?php echo $error; ?></li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
		
		<div class="form-group row">
			<label for="email" class="col-sm-3 col-form-label">Email</label>
			<div class="col-sm-8">
				<input type="email" name="email" id="email" value="<?php echo isset($model['email'])?$model['email']:''; ?>" class="form-control" placeholder="Email">
			</div>
		</div>
		
		<?php if(!isset($model['id'])): ?>
			<div class="form-group row">
				<label for="password" class="col-sm-3 col-form-label">Password</label>
				<div class="col-sm-8">
					<input type="password" name="password" id="password" class="form-control" placeholder="Password">
				</div>
			</div>
		<?php endif; ?>

		<?php if(isset($locations)): ?>
		<div class="form-group row">
			<label for="locations_id" class="col-sm-3 col-form-label">Niveli i Aksesit</label>
			<div class="col-sm-8">
				<select name="locations_id" id="locations_id" class="form-control">
					<?php foreach ($locations as $location){ ?>
						<option value="<?php echo $location['id']; ?>" <?php if(isset($model['locations_id']) && $location['id'] == $model['locations_id']) echo 'selected="selected"'; ?> ><?php echo $location['name']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<?php endif; ?>
		<div class="form-group row">
			<label for="firstname" class="col-sm-3 col-form-label">Emri</label>
			<div class="col-sm-8">
				<input type="input" name="firstname" id="firstname" value="<?php echo isset($model['firstname'])?$model['firstname']:''; ?>" class="form-control" placeholder="Firstname">
			</div>
		</div>
		<div class="form-group row">
			<label for="lastname" class="col-sm-3 col-form-label">Mbiemri</label>
			<div class="col-sm-8">
				<input type="input" name="lastname" id="lastname" value="<?php echo isset($model['lastname'])?$model['lastname']:''; ?>" class="form-control" placeholder="Lastname">
			</div>
		</div>
		<div class="form-group row">
			<label for="phone" class="col-sm-3 col-form-label">Telefon</label>
			<div class="col-sm-8">
				<input type="input" name="phone" id="phone" value="<?php echo isset($model['phone'])?$model['phone']:''; ?>" class="form-control" placeholder="Phone">
			</div>
		</div>
		
		<?php if(isset($model['id'])): ?>
			<input type="hidden" name="id" value="<?php echo $model['id']; ?>">
		<?php endif; ?>

		<hr>
		
        <div class="row d-flex justify-content-center" style="margin-top: 20px; margin-bottom: 50px">
			<button type="submit" class="btn btn-primary" style="margin-right: 30px;">Save Changes</button>
			<?php if(isset($client)){ ?>
				<a href="/change-pass" type="button" class="btn btn-warning">Change Password</a>
			<?php }else if(isset($model['id'])){ ?>
				<a href="/users/change-pass/<?php echo $model['id']; ?>" type="button" class="btn btn-warning">Change Password</a>
			<?php } ?>
        </div>
	</form>
</div>
</div>

@endsection