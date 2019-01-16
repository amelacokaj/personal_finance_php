<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $monthAggregates = ["income" => 0, "expense" => 0];
        $monthQuery = "SELECT entries.type, entries.amount
                    FROM entries
                    WHERE MONTH(entries.date) = MONTH(CURRENT_DATE())
                    AND YEAR(entries.date) = YEAR(CURRENT_DATE())";
        
        $monthEntires = \DB::select($monthQuery);
        foreach ($monthEntires as $entry){
            if($entry->type == 1)
                $monthAggregates["income"] += $entry->amount; 
            else
                $monthAggregates["expense"] += $entry->amount; 
        }


        $todayAggregates = ["income" => 0, "expense" => 0];
        $todayQuery = "SELECT entries.*
                    FROM entries
                    WHERE entries.date = CURRENT_DATE()";
        
        $todayEntires = \DB::select($todayQuery);
        foreach ($todayEntires as $entry){
            if($entry->type == 1)
                $todayAggregates["income"] += $entry->amount; 
            else
                $todayAggregates["expense"] += $entry->amount;
        }


        //info("monthEntires", [$monthEntires, $monthAggregates]);
        return view('/home', ['monthAggregates' => $monthAggregates, 'todayAggregates' => $todayAggregates, 'amount' => $entry]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function calendar(Request $request)
    {
        //https://fullcalendar.io/demo-events.json?start=2018-11-25&end=2019-01-06&_=1544798586140

        $urlParams = $request->query();
        $startParam = $urlParams['start'];
        $endParam = $urlParams['end'];

        $query = "SELECT
                        entries.*
                        , entries.date as 'start' 
                        , categories.name AS title
                    FROM
                        entries
                        INNER JOIN categories 
                            ON (entries.category_id = categories.id)
                    WHERE entries.date >= ? AND entries.date <= ?";
        
        $entries = \DB::select($query, [$startParam, $endParam]);

        //Array me te dhenat e perpunuara
        $calendarItems = [];
        foreach ($entries as $entry){
            $item = new \stdClass();
            $item->title = $entry->title .' ('.$entry->amount.'Lek)';
            $item->allDay = true;
            $item->start = $entry->start;
            $item->color = $entry->type == 0 ? 'red' : 'blue';
            $item->url = "/transactions/{$entry->id}/edit";
            $calendarItems[] = $item;
        }

        //foreach mbi entires sic e bejme te tabelat
        //ne vend qe te shfaqim te dhenat do te bejme hyrjen ne nji array e cila do te formatohet sipas nevojes qe kalendarit
        //dhe do te kthehet ne vend te $entries 
        
        //info("urlParams", [$urlParams, $calendarItems]);

        return response()->json($calendarItems, 200);
    }


}
