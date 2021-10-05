<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\User;
use App\Models\Pet;

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
		$transactions = Pet::all();

		// ADD USER ATTRIBUTES MANUALLY TO BE SEEN IN THE JSON RESPONSE
		foreach($transactions as $transaction){
			$transaction->actions = $transaction->actions;
		}

    	return Datatables::of($transactions)->rawColumns(['actions'])->make(true);
	}
}