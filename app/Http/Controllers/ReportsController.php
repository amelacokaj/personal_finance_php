<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;

class ReportsController extends BaseController
{
    
    public function index()
    {
        return view('/reports');
    }

    public function daily()
    {
        $groupAmountsByDate = [];
        $dateLabels = [];
        $incomeData = [];
        $expenseData = [];

        $query = "SELECT entries.date, entries.type, entries.amount
                        FROM entries
                        WHERE MONTH(entries.date) = MONTH(CURRENT_DATE())
                        AND YEAR(entries.date) = YEAR(CURRENT_DATE())
                        ORDER BY entries.date";
        
        $entries = \DB::select($query);
        foreach ($entries as $entry){
            $date = $entry->date;
            if (!isset($groupAmountsByDate[$date])) {
                $dateLabels[] = $date;
                $groupAmountsByDate[$date] = ["income" => 0, "expense" => 0];
            }

            if($entry->type == 1)
                $groupAmountsByDate[$date]["income"] += $entry->amount; 
            else
                $groupAmountsByDate[$date]["expense"] += $entry->amount;
        }
        
        foreach ($groupAmountsByDate as $dateKey=>$entry){            
            $incomeData[] = $entry["income"] > 0 ? ["t"=>$dateKey, "y"=>$entry["income"]] : [];
            $expenseData[] = $entry["expense"] > 0 ? ["t"=>$dateKey, "y"=>$entry["expense"]] : [];
        }

        return view('/daily-report', ['labels' => $dateLabels, 'incomeData' => $incomeData, 'expenseData' => $expenseData]);
    }

}
