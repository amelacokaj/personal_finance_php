<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFailedLogin extends Model {

	protected $table = 'user_failed_logins';
	public $timestamps = false;

}
