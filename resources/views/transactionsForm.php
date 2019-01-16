<?php echo View::make('partials.header') ?>

<div class="row">
	<form class="offset-md-2 col-md-8" action="/transactions" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<h2><?php echo (isset($model['id']) ? 'Edit':'Create') . ' ' .(isset($model['type']) && $model['type']==1 ? "Income" : "Expense"); ?> </h2></br>
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
			<label for="name" class="col-sm-3 col-form-label">Category</label>
			<div class="col-md-8">
				<select name="category_id" id="category_id" class="custom-select" required>
					<option value="">Open this select menu</option>
					<?php foreach ($categories as $category){ ?>
						<option value="<?php echo $category['id']; ?>" <?php if(isset($model['category_id']) && $category['id'] == $model['category_id']) echo 'selected="selected"'; ?> ><?php echo $category['name']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		
		<div class="form-group row">
			<label for="name" class="col-sm-3 col-form-label">Type</label>
			<div class="col-md-8">
				<!--label style="margin-right: 20px"><input type="radio" name="type" value="0" <?php //echo !isset($model['type']) || (isset($model['type']) && $model['type'] == 0) ? 'checked="checked"' : ''; ?> > Expense</label-->
				<label style="margin-right: 20px">
					   <input type="radio" name="type" value="0" <?php echo isset($model['type']) && $model['type'] == 0 ? 'checked="checked"' : ''; ?> > Expense</label>
				<label><input type="radio" name="type" value="1" <?php echo isset($model['type']) && $model['type'] == 1 ? 'checked="checked"' : ''; ?> > Income</label>
			</div>
		</div>
		<div class="form-group row">
			<label for="code" class="col-sm-3 col-form-label">Description</label>
			<div class="col-md-8">
				<input type="text" name="description" id="description" value="<?php echo isset($model['description'])?$model['description']:''; ?>" class="form-control" placeholder="Description">
			</div>
		</div>
		<div class="form-group row">
			<label for="code" class="col-sm-3 col-form-label">Amount</label>
			<div class="col-md-8">
				<input type="number" name="amount" id="amount" value="<?php echo isset($model['amount'])?$model['amount']:''; ?>" class="form-control" placeholder="Amount">
			</div>
		</div>
		<div class="form-group row">
			<label for="code" class="col-sm-3 col-form-label">Date</label>
			<div class="col-md-8">
				<input type="date" name="date" id="date" value="<?php echo isset($model['date'])?$model['date']:''; ?>" class="form-control" placeholder="Date">
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