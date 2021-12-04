<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;

use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

class TransactionsController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Seller/Admin/Rider');
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Transactions'
        ]);
    }

    public function income(){
        return $this->_view('income', [
            'title' => 'Income Report'
        ]);
    }

    public function getIncome(Request $req){
        $from = $req->from . " 00:00:00";
        $to = $req->to . " 23:59:59";

        $transactions = Transactions::where([
            ['created_at', '>=', $from],
            ['created_at', '<=', $to],
            ['tid', 'like', auth()->user()->id]
        ])->select(['created_at', 'price', 'status'])->get();

        // $days = now()->parse($from)->diff(now()->parse($to))->format("%a");
        $labels = array();

        $temp1 = now()->parse($from)->toDateString();
        $temp2 = now()->parse($to)->toDateString();

        while($temp1 <= $temp2){
            $curDay = now()->parse($temp1)->format('M j, y');
            $labels[$curDay] = 0;

            foreach($transactions as $transaction){
                $td = now()->parse($transaction->created_at)->toDateString();

                if($td == $temp1){
                    $labels[$curDay] += $transaction->price;
                }
            }

            $temp1 = now()->parse($temp1)->addDay()->toDateString();
        }

        echo json_encode(['labels' => $labels, 'transactions' => $transactions]);
    }

    public function export($from, $to){
        if($from != "NA"){
            $from = now()->parse($from)->toFormattedDateString();
        }
        else{
            $from = null;
        }
        $to = now()->parse($to)->toFormattedDateString();

        $title = $from ? "$from - $to" : "$to";
        return Excel::download(new TransactionsExport($from, $to, $title), $title . " Report.xlsx");
    }

    public function payment($type, $id, Request $req){
        if($type == "success"){
            $transaction = Transactions::where('sid', $id)->latest()->first();
            $transaction->paid = true;
            $transaction->save();

            $req->session()->flash('success', 'Booking has been paid');
        }
        else{
            $req->session()->flash('error', 'Booking ' . $type);
        }

        return redirect()->route('transactions.index');
    }

    private function _view($view, $data = array()){
    	return view('transactions.' . $view, $data);
    }
}
