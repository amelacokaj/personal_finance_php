@extends('layouts.app')

@section('content')
<div class="row">
	<form class="form-horizontal col-md-offset-2 col-md-8" action="/<?php echo isset($client)?'change-pass':'users/change-pass'; ?>" method="post">
		<?php $model = isset($model)?$model:[]; ?>
		<h2>Change User Password</h2></br>
		
		<?php if (count($errors) > 0) { ?>
			<div class="alert alert-danger">
				<ul>
					<?php foreach ($errors->all() as $error){ ?>
						<li><?php echo $error; ?></li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
		
		<div id="divCheckPasswordMatch"></div>
		
		<div class="form-group required">
			<label for="password" class="col-sm-3 control-label">New Password</label>
			<div class="col-sm-8">
				<input type="password" name="password" id="password" class="form-control" placeholder="Password">
			</div>
		</div>
		<div class="form-group required">
			<label for="passwordConfirm" class="col-sm-3 control-label">Confirm Password</label>
			<div class="col-sm-8">
				<input type="password" id="passwordConfirm" class="form-control" placeholder="Password">
			</div>
		</div>
		
		<input type="hidden" name="id" value="<?php echo $model['id']; ?>">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<hr>
		<div class="form-group">
			<div class="col-md-offset-3 col-sm-8">
				<button type="submit" class="btn btn-primary">Change Password</button>
			</div>
		</div>
	</form>
</div>

<script>

	$(document).ready(function ()
	{
		$('form').on('submit', function(){
		
			var password = $("#password").val();
			var confirmPassword = $("#passwordConfirm").val();
			
			if (password != confirmPassword)
			{
				$("#divCheckPasswordMatch")
					.addClass("alert alert-warning")
					.html("Passwords do not match!");
				
				return false;
			}
			else
				return true;
			
		});		
	});
	
</script>
@endsection

