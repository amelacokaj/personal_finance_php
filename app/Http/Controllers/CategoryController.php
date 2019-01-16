<?php namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Account;
use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = "SELECT
                        categories.id
                        , categories.name
                        , accounts.name AS account_name
                        , accounts.code AS account_code
                    FROM
                        categories
                        INNER JOIN accounts 
                            ON (categories.account_id = accounts.id)";
        
        $categories = \DB::select($query);
		
		return view('/categories', ['resourceName'=>'categories', 'records' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::get();
        return view('/categoriesForm', ['accounts' => $accounts])->with('model', ['accounts']);
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
				$category = Category::findOrFail($request->get('id'));
			}
			else
			{
				$category = new Category();
			}
			
			$category->name = $request->get('name');
			$category->account_id = $request->get('account_id');
			$category->save();
			
			return redirect('categories');
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
        $modelData = Category::find($id);
        $accounts = Account::get();
        return view('/categoriesForm', ['accounts' => $accounts])->with('model', $modelData);        
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
			Category::destroy($id);
		}
		catch (\Exception $e){}//skip errors
		
		return response()->json('ok', 200);
    }
}
