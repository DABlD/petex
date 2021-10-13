<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\User;
use App\Models\Transactions;

class DatatablesController extends Controller
{
	public function users(){
		$users = User::where('deleted_at', null)->get();

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($users as $user){
			$user->fullname = $user->fullname;
			$user->actions = $user->actions;
		}

    	return Datatables::of($users)->rawColumns(['actions'])->make(true);
	}

	public function transactions(){
		if(auth()->user()->role == "Admin"){
			$transactions = Transactions::all();
			foreach($transactions as $transaction){
				$transaction->actions = "";
			}
		}
		else if(auth()->user()->role == "Seller"){
			$transactions = Transactions::where('sid', auth()->user()->id)->get();
			foreach($transactions as $transaction){
				$transaction->actions = $transaction->actions;
			}
		}
		else{
			$transactions = Transactions::where('tid', auth()->user()->id)->get();
			foreach($transactions as $transaction){
				$transaction->actions = $transaction->actions;
			}
		}
		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE

    	return Datatables::of($transactions)->rawColumns(['actions'])->make(true);
	}
}