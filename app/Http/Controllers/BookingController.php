<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class BookingController extends Controller
{
	public function index(){
		$sellers = User::where("role", 'Seller')->select(['id', 'fname', 'lname'])->get();

		return $this->_view('create', [
			"title" => 'Add Transaction',
			"sellers" => $sellers
		]);
	}

	public function getUserAddress(Request $req){
		echo json_encode(User::where('id', $req->id)->select('lat', 'lng')->first());
	}

	public function create(Request $req){
		dd($req);
	}

	private function _view($view, $data = array()){
		return view('transactions.' . $view, $data);
	}
}
