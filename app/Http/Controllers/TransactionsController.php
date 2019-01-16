<?php namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class TransactionsController extends BaseController
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $query = "SELECT entries.*
                        , categories.name AS category_name
                    FROM
                        entries
                        INNER JOIN categories 
                            ON (entries.category_id = categories.id)";
        
        $entry = \DB::select($query);
		
        return view('/transactions', ['resourceName'=>'transactions', 'records' => $entry]);
    }
    
    public function listTypes($type)
    {
        $typeCondition = $type=='income' ? 1:0;
        $query = "SELECT entries.*
                        , categories.name AS category_name
                    FROM
                        entries
                        INNER JOIN categories 
                            ON (entries.category_id = categories.id)
                    WHERE entries.type = ?";
        
        $entry = \DB::select($query, [$typeCondition]);
		
        return view('/transactionsListTypes', ['resourceName'=>'transactions', 'records' => $entry, 'type' => $typeCondition]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $urlParams = $request->query();
        $typeParam = (isset($urlParams['type']) && $urlParams['type'] == 'income') ? 1 : 0;

        $categories = Category::get();
        return view('/transactionsForm', ['categories' => $categories])->with('model', ['type'=>$typeParam]);
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
        info("form inputs", [$input]);
		try {
		
			$fieldLabelNames = array(
		        'category_id' => 'Category',		     
			);
	        $requiredFields = array(
				'category_id' => 'required',
	        );
	        $validator = \Validator::make($input, $requiredFields);
	        $validator->setAttributeNames($fieldLabelNames);

	        if($validator->fails())
		        throw new \Exception('Validation Failed.');
			
			if($request->exists('id'))
			{
                info("editim");
				$entry = Entry::findOrFail($request->get('id'));
			}
			else
			{
                info("krijim i ri");
				$entry = new Entry();
			}
			
			$entry->type = $request->get('type');
            $entry->category_id = $request->get('category_id');
            //$selectedCategory = Category::select('name')->where('id', $request->get('category_id'))->first();
            //if(isset($selectedCategory)) {
            //    $entry->category_name = $selectedCategory->name;
            //}
            $entry->description = $request->get('description');
			$entry->amount = $request->get('amount');
			$entry->date = $request->get('date');
			$entry->save();
			
			return redirect('transactions');
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
        $modelData = Entry::find($id);
        $categories = Category::get();
        return view('/transactionsForm', ['categories' => $categories])->with('model', $modelData);
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
			Entry::destroy($id);
		}
		catch (\Exception $e){}//skip errors
		
		return response()->json('ok', 200);
    }
}
