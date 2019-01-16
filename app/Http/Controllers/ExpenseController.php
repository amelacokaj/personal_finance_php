<?php namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class ExpenseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];
		return view('/expense', ['resourceName'=>'expense', 'records' => $result]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/colorsForm');
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
		try {
		
			$fieldLabelNames = array(
		        'name' => 'Name',		     
			);
	        $requiredFields = array(
		        'name' => 'required',
	        );
	        $validator = \Validator::make($input, $requiredFields);
	        $validator->setAttributeNames($fieldLabelNames);

	        if($validator->fails())
		        throw new \Exception('Validation Failed.');
			
			if($request->exists('id'))
			{
				$Color = Color::findOrFail($request->get('id'));
			}
			else
			{
				$Color = new Color();
			}
			
			$Color->name = $request->get('name');
			$Color->save();
			
			return redirect('colors');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modelData = Color::find($id);
		return view('/colorsForm')->with('model', $modelData);
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
			Color::destroy($id);
		}
		catch (\Exception $e){}//skip errors
		
		return response()->json('ok', 200);
    }
}
