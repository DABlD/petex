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
		$drivers = User::where('role', 'Rider')
			->join('trackers', 'trackers.uid', '=', 'users.id')
			->select(['users.*', 'trackers.lat as lat2', 'trackers.lng as lng2'])
			->get();

		foreach($drivers as $driver){
			$transactions = Transactions::where([
				['status', '=', 'Delivered'],
				['tid', '=', $driver->id],
				['rating', '!=', null]
			])->pluck('rating');

			$driver->ave_ratings = array_sum($transactions) / count($transactions);
		}

		echo json_encode($drivers);
	}

	public function getDriverLocation(Request $req){
		echo json_encode(User::where('users.id', $req->id)
			->join('trackers', 'trackers.uid', '=', 'users.id')
			->select(['users.*', 'trackers.lat as rlat', 'trackers.lng as rlng'])
			->first());
	}

	public function assignDriver(Request $req){
		echo Transactions::where('id', $req->id)->update([
			'tid' => $req->tid, 
			'assigned_time' => now(), 
			'status' => "For Pickup",
			'eta' => $req->eta
		]);
	}

	public function checkRiderDelivery(Request $req){
		$temp = Transactions::where('tid', auth()->user()->id)
			->select(
				'transactions.*',
				'users.lat as slat',
				'users.lng as slng',
				'users.address as saddress',
				'users.fname as sfname',
				'users.lname as slname',
				'users.contact as scontact'
				// 'r.lat as rlat',
				// 'r.lng as rlng'
			)
			->join('users', 'users.id', '=', 'transactions.sid')
			->join('users as r', 'r.id', '=', 'transactions.tid')
			->latest('created_at')
			->first();

		echo json_encode($temp);
	}

	public function updateStatus(Request $req){
		echo Transactions::where('id', $req->id)->update($req->except(['_token', 'id']));
	}

	private function _view($view, $data = array()){
		return view('transactions.' . $view, $data);
	}
}
