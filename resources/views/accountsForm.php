<?php echo View::make('partials.header') ?>

<div class="row">
	<form class="offset-md-2 col-md-8" action="/accounts" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<?php $model = isset($model)?$model:[]; ?>
		<h2>Krijo/Modifiko Llogarine</h2></br>
		
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
				<input type="text" name="name" id="name" value="<?php echo isset($model['name'])?$model['name']:''; ?>" class="form-control" placeholder="Account Name">
			</div>
		</div>
		<div class="form-group row">
			<label for="code" class="col-sm-3 col-form-label">Account Code</label>
			<div class="col-md-8">
				<input type="number" name="code" id="code" value="<?php echo isset($model['code'])?$model['code']:''; ?>" class="form-control" placeholder="Account Code">
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