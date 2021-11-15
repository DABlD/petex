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
			$array = [];

			foreach($transactions as $transaction){
				$transaction->actions = "";

				$temp = User::where('id', $transaction->tid)->select('fname as rfname', 'lname as rlname', 'contact as rcontact')->first();
				$transaction = array_merge($transaction->toArray(), $temp != null ? $temp->toArray() : [
				    "rfname" => null,
				    "rlname" => null,
				    "rcontact" => null
				]);

				array_push($array, $transaction);
			}
			$transactions = $array;
		}
		else if(auth()->user()->role == "Seller"){
			$transactions = Transactions::where('sid', auth()->user()->id)
								->select('transactions.*')
								->get();

			$array = [];

			foreach($transactions as $transaction){
				$temp = User::where('id', $transaction->tid)->select('fname as rfname', 'lname as rlname', 'contact as rcontact')->first();
				$transaction->actions = $transaction->actions;


				$transaction = array_merge($transaction->toArray(), $temp != null ? $temp->toArray() : [
				    "rfname" => null,
				    "rlname" => null,
				    "rcontact" => null
				]);

				array_push($array, $transaction);
			}

			$transactions = $array;
		}
		else{
			$transactions = Transactions::where('tid', auth()->user()->id)->get();
			$array = [];

			foreach($transactions as $transaction){
				$transaction->actions = $transaction->actions;

				$temp = User::where('id', $transaction->tid)->select('fname as rfname', 'lname as rlname', 'contact as rcontact')->first();
				$transaction = array_merge($transaction->toArray(), $temp != null ? $temp->toArray() : [
				    "rfname" => null,
				    "rlname" => null,
				    "rcontact" => null
				]);

				array_push($array, $transaction);
			}
			$transactions = $array;
		}
		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE

    	return Datatables::of($transactions)->rawColumns(['actions'])->make(true);
	}
}