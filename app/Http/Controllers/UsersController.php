<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use App\Http\Controllers\BaseController;

class UsersController extends BaseController
{	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$users = User::leftJoin('locations', 'locations.id', '=', 'users.locations_id')
					->select(['users.*', 'locations.name AS location_name'])
					->where('users.deleted', 0)
					->paginate(25);
					
		return view('/users', ['resourceName'=>'users', 'records' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$locations = Location::where('location_types_id', '>', 0)->get()->toArray();
		array_unshift($locations, ['name'=>'Admin','id'=>0]);
		return view('/usersForm', ['locations' => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$input = $request->all();
		$validator;
		$emailTaken = false;
		
		try {
		
			$fieldLabelNames = array(
		        'email' => 'Email',
		        'firstname' => 'Firstname',
			);
	        $requiredFields = array(
				'email' => 'required|email',
		        'firstname' => 'required',
	        );
			
			if($request->exists('id'))
			{
				$user = User::findOrFail($request->get('id'));
				
				//check if it was changed
			    if(Str::lower($user->email) != Str::lower($request->get('email')))
			    {   //now check if someone else has it already
				    $emailTaken = User::where('email', $request->get('email'))->exists();
			    }
			}
			else
			{
				//create
				$user = new User();
				$user->created_at = date('Y-m-d H:i:s');
				$user->password = $request->get('password');
				
				$requiredFields['password'] = 'required|min:4';
				$fieldLabelNames['password'] = 'Password';
				
			    $emailTaken = User::where('email', $request->get('email'))->exists();
			}
			
		    if ($emailTaken)
				throw new Exception('Email_taken');
				
	        $validator = \Validator::make($input, $requiredFields);
	        $validator->setAttributeNames($fieldLabelNames);

	        if($validator->fails())
		        throw new \Exception('Validation Failed.');

			$user->email = $request->get('email');
			$user->firstname = $request->get('firstname');
			$user->lastname = $request->get('lastname');
			$user->locations_id = $request->get('locations_id');
			//$users->description = $request->get('description');
			$user->tel = $request->get('tel');
			$user->status = 1;
			$user->save();
			
			return redirect('users');
		}
		catch (\Exception $e)
		{
			info($e->getMessage(), [$e->getLine()]);
			if($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)
			{
				$validator = \Validator::make($input, ['Record_not_found'=>'required'], ['Record_not_found.required'=>'The record you are trying to edit does not exits!']);
				$validator->fails();
			}
			if($e->getMessage() == 'Email_taken')
			{
				$validator = \Validator::make($input, ['Record_not_found'=>'required'], ['Record_not_found.required'=>'Email is already in use, please try another one.']);
				$validator->fails();
			}
		}
		
		return back()->withErrors($validator)->withInput()->with('model', $input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //details
		
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$userData = User::find($id);		
		$locations = Location::where('location_types_id', '>', 0)->get()->toArray();
		array_unshift($locations, ['name'=>'Admin','id'=>0]);
		
		return view('/usersForm', ['locations' => $locations])->with('model', $userData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
		try {
			$user = User::find($id);
			$user->deleted = 1;
			$user->save();
		}
		catch (\Exception $e){}//skip errors
		
		return response()->json('ok', 200);
    }
	
	
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function newPassword($id)
    {
		$userData = User::find($id);
		return view('/usersPassword')->with('model', $userData);
    }
	
    /**
     * Update/Change Password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
		$input = $request->all();
		
		try {
		
	        $requiredFields = array(
		        'id' => 'required',
		        'password' => 'required|min:4',
	        );
	        $validator = \Validator::make($input, $requiredFields);

	        if($validator->fails())//ketu behet kontrolli
		        throw new \Exception('Validation Failed.');
			
			$user = User::findOrFail($request->get('id'));
			$user->password = $request->get('password');
			$user->save();
			
			return redirect('users');
		}
		catch (\Exception $e)
		{
			info($e->getMessage(), [$e->getLine()]);
			if($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException)
			{
				$validator = \Validator::make($input, ['Record_not_found'=>'required'], ['Record_not_found.required'=>'The record you are trying to edit does not exits!']);
				$validator->fails();
			}
		}
		
		return back()->withErrors($validator)->with('model', $input);
    }
	
}
