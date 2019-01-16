<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFailedLogin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;

class AuthController extends Controller {

	public function logout()
	{
		Auth::logout();
		return redirect('login');
	}

	public function loginForm()
    {
		if(Auth::check())
		{
			return redirect('home');
		}
		
		return view('login');
    }
	
	public function login(Request $request)
    {	
		$input = $request->all();
		try {
		
			$validator = \Validator::make( $input,
										  ['email' => 'required|email',
										   'password' => 'required']);
			
			if($validator->passes())
			{
				$remember = ($request->has('remember') && $request->get('remember')==1)? true : false;
				
				$credentials = array(
					'email' => $request->get('email'),
					'password' => $request->get('password'),
					'status' => 1);//active only
				
				if (Auth::attempt($credentials, $remember)) 
				{
					return redirect()->intended('home');
				}
				else //failed
				{
					$attemptingUser = User::where('email', $request->get('email'))->first();
					if($attemptingUser)
					{
						if($attemptingUser->status == 2)//blocked
						{
							sleep(10);
							throw new \Exception('blocked_user');
						}
						else
							$this->registerUserThrottling($attemptingUser->id, $request->getClientIp());
					}
					else
						$this->registerUserThrottling(0, $request->getClientIp());
						
					throw new \Exception('login_failed');
				}
			}
			else 
				throw new \Exception('Validation Failed.');
				
		}
		catch (\Exception $e)
		{
			info($e->getMessage(), [$e->getLine()]);
			
			if($e->getMessage() == 'login_failed')
			{
				$validator = \Validator::make($input, ['login_failed'=>'required'], ['login_failed.required'=>'Your login email and/or password are invalid: please double-check and try again.']);
				$validator->fails();
			}
			
			if($e->getMessage() == 'blocked_user')
			{
				$validator = \Validator::make($input, ['blocked_user'=>'required'], ['blocked_user.required'=>'You have been blocked from the system due to continues incorrect credentials. <br> Ask the administrator for assistance to restore your account.']);
				$validator->fails();
			}
		}
		
		return back()->withErrors($validator)->withInput();
	}


	/**
	 * Implements login throttling
	 * Reduces the efectiveness of brute force attacks
	 *
	 * @param int $user_id
	 */
	public function registerUserThrottling($user_id, $client_ip)
	{
		$failedLogin = new UserFailedLogin();
		$failedLogin->id_users = $user_id;
		$failedLogin->ip_address = $client_ip;
		$failedLogin->attempted = time();
		$failedLogin->save();

		$attempts = UserFailedLogin::where('ip_address', $client_ip)
								   ->where('attempted', '>=', (time() - 3600*2))//last 2 hours
								   ->count();

		switch ($attempts) {
			case 1:
				sleep(2);
				break;
			case 2:
				sleep(4);
				break;
			case 3:
				sleep(6);
				break;
			default:
				sleep(10);
				break;
		}

		if ($attempts > 3)
		{
			if($user_id > 0)
			{
				$blockUser = User::find($user_id);
				$blockUser->status = 2;
				$blockUser->save();
			}
		}
	}


	public function emailCredentialsForgot()
	{
		$statusCode = 500;
		$statusMsg = "";

		if($request->exists('email'))
		{
			$result = User::where('email', $request->get('email'))->get();

			if(count($result) > 0) {
				foreach ($result as $user) {
					$this->sendForgotEmail($user);
				}

				if (count($result) > 1)
					$statusMsg = "Many accounts seem to have the same email address, therefore you will recieve multiple emails for each user. Check the appropriate username on the email to reset its password.";
				else
					$statusMsg = "Your password reset link was sent to your email. <br>Please follow the link on the email to recover your account.";

				$statusCode = 412;
			}
			else
			{
				$statusMsg = "The provided email could not be found in our system. Please enter a correct email or username.";
				$statusCode = 406;
			}
		}
		else if($request->exists('username'))
		{
			$user = User::where('username', $request->get('username'))->first();
			if ($user != null)
			{
				$this->sendForgotEmail($user);
				$statusMsg = "Your password reset link was sent to {$user->email}. <br>Please follow the link on the email to recover your account.";
				$statusCode = 412;
			}
			else
			{
				$statusMsg = "The provided username could not be found in our system. Please enter a correct username or email.";
				$statusCode = 406;
			}
		}

		return Response::make($statusMsg, $statusCode);
	}

	private function sendForgotEmail($user)
	{
		$user->email_code = str_random(20).time();
		$user->save();

		$backUrl = Request::root().'/#/reset-password/'.$user->username.'/'.$user->email_code;
		$dynamic_vars = array("FIRST_NAME"=>$user->firstname,
			"USERNAME"=>$user->username,
			"REDIRECT_LINK_TO_PASSWORD_RECOVERY"=>$backUrl,
		);

		$this->sendEmail($user->email, $user->firstname, 'Login Credentials ', 'email_credentials_forgot', $dynamic_vars);
	}

	public function resetPassword()
	{
		$statusCode = 500;
		$statusMsg = "";

		$user = User::where('username', $request->get('username'))
					->where('email_code', $request->get('email_code'))
					->first();

		if($user != null)
		{
			$user->password = $request->get('password');
			$user->email_code = '';
			$user->status = 1;
			$user->save();
			$statusCode = 200;
		}
		else
		{
			$statusMsg = "The provided information was incorrect, it may have been expired, please try requesting another password reset.";
			$statusCode = 406;
		}

		return Response::make($statusMsg, $statusCode);
	}
}
