<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Transactions;

class DashboardController extends Controller
{
    public function index(){
    	if(auth()->user()->role == "Admin"){
	    	return $this->_view('dashboard', [
	    		'title' => 'Dashboard',
	    		'users' => User::all()->count(),
	    		'ongoing' => Transactions::where([
	    			['status', '!=', 'Cancelled'],
	    			['status', '!=', 'Delivered'],
	    		])->whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'deliveries' => Transactions::whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'cancelled' => Transactions::where('status', 'Cancelled')->whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'all_cancelled' => json_encode(Transactions::whereIn('status', ['Cancelled', 'Rider Cancel'])->select(['lat', 'lng'])->get()),
	    	]);
	    }
	    else if(auth()->user()->role == "Seller"){
	    	return $this->_view('dashboard', [
	    		'title' => 'Dashboard',
	    		'users' => User::all()->count(),
	    		'ongoing' => Transactions::where([
	    			['status', '!=', 'Cancelled'],
	    			['status', '!=', 'Delivered'],
	    			['sid', '=', auth()->user()->id]
	    		])->whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'deliveries' => Transactions::where('sid', auth()->user()->id)->whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'totalTransactions' => Transactions::where('sid', auth()->user()->id)->get()->count(),
	    		'cancelled' => Transactions::where([
	    			['status', '=', 'Cancelled'],
	    			['sid', '=', auth()->user()->id]
	    		])->whereRaw('Date(created_at) = CURDATE()')->get()->count()
	    	]);
	    }
	    else if(auth()->user()->role == "Rider"){
	    	return $this->_view('dashboard', [
	    		'title' => 'Dashboard',
	    		'users' => User::all()->count(),
	    		'ongoing' => Transactions::where([
	    			['status', '!=', 'Cancelled'],
	    			['status', '!=', 'Delivered'],
	    			['tid', '=', auth()->user()->id]
	    		])->whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'deliveries' => Transactions::where('tid', auth()->user()->id)->whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'totalTransactions' => Transactions::where('tid', auth()->user()->id)->get()->count(),
	    		'cancelled' => Transactions::where([
	    			['status', '=', 'Cancelled'],
	    			['tid', '=', auth()->user()->id]
	    		])->whereRaw('Date(created_at) = CURDATE()')->get()->count()
	    	]);
	    }
    }

    public function getData(Request $req){
    	$from = $req->from . " 00:00:00";
    	$to = $req->to . " 23:59:59";

    	$id = auth()->user()->role == "Admin" ? "%" : auth()->user()->id;

    	$transactions = Transactions::where([
    		['created_at', '>=', $from],
    		['created_at', '<=', $to],
    		['sid', 'like', $id]
    	])->select('created_at')->get();

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
	    			$labels[$curDay]++;
	    		}
	    	}

    		$temp1 = now()->parse($temp1)->addDay()->toDateString();
    	}

    	echo json_encode($labels);
    }

    private function _view($view, $data = array()){
    	return view($view, $data);
    }
}
