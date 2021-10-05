<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Transactions, Tracker};
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
		$array = [
			"sid" => auth()->user()->id,
			"created_at" => now()->toDateTimeString(),
			"updated_at" => now()->toDateTimeString()
		];
		Transactions::insert(array_merge($req->except(['_token']), $array));
		$req->session()->flash('success', 'Transaction added successfully');
		return redirect()->route('transactions.index');
	}

	public function cancel($id){
		echo Transactions::where('id', $id)->update(['status' => 'Cancelled']);
	}

	public function uploadLocation(Request $req){
		if(Tracker::where('uid', auth()->user()->id)->get()->count() > 0){
			echo Tracker::where('uid', auth()->user()->id)->update(["lat" => $req->lat, "lng" => $req->lng]);
		}
		else{
			$array = [
				"uid" => auth()->user()->id,
				"created_at" => now()->toDateTimeString(),
				"updated_at" => now()->toDateTimeString()
			];

			echo  Tracker::insert(array_merge($req->all(), $array));
		}
	}

	public function getDriversLocation(){
		echo json_encode(User::where('role', 'Rider')->join('trackers', 'trackers.uid', '=', 'users.id')->select(['users.*', 'trackers.lat as lat2', 'trackers.lng as lng2'])->get());
	}

	private function _view($view, $data = array()){
		return view('transactions.' . $view, $data);
	}
}
