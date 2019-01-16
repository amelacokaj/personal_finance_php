<?php echo View::make('partials.header') ?>

<div class="row">
	<form class="offset-md-2 col-md-8" action="/categories" method="post">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<?php $model = isset($model)?$model:[]; ?>
		<h2>Krijo/Modifiko Kategorine</h2></br>
		
		<hr>
		
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
			<label for="name" class="col-sm-3 col-form-label">Name</label>
			<div class="col-md-8">
				<input type="text" name="name" id="name" value="<?php echo isset($model['name'])?$model['name']:''; ?>" class="form-control" placeholder="Emri">
			</div>
		</div>

		<div class="form-group row">
			<label for="account_id" class="col-sm-3 col-form-label">Account Code</label>
			<div class="col-md-8">
				<select name="account_id" id="account_id" class="custom-select" required>
					<option value="">Open this select menu</option>
					<?php foreach ($accounts as $account){ ?>
						<option value="<?php echo $account['id']; ?>" <?php if(isset($model['account_id']) && $account['id'] == $model['account_id']) echo 'selected="selected"'; ?> ><?php echo $account['code'].' '.$account['name']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		
		<?php if(isset($model['id'])): ?>
			<input type="hidden" name="id" value="<?php echo $model['id']; ?>">		
		<?php endif; ?>

		<hr>
		
        <div class="row d-flex justify-content-center" style="margin-top: 20px; margin-bottom: 50px">
			<button type="submit" class="btn btn-primary">Ruaj Ndryshimet</button>
        </div>
	</form>
</div>

<?php echo View::make('partials.footer') ?>