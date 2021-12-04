<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Transactions, Tracker, Variable};
use App\User;
use Image;

class BookingController extends Controller
{
	public function index(){
		$sellers = User::where("role", 'Seller')->select(['id', 'fname', 'lname'])->get();
		$price = Variable::where('name', 'price')->latest()->first();

		return $this->_view('create', [
			"title" => 'Add Transaction',
			"sellers" => $sellers,
			"price" => $price ? $price->value : null
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
		Transactions::insert(array_merge($req->except(['_token', 'size']), $array));
		$req->session()->flash('success', 'Transaction added successfully');
		return redirect()->route('transactions.index');
	}

	// SMS
	public function itexmo($number,$message){
		$ch = curl_init();
		$itexmo = array('1' => $number, '2' => $message, '3' => "TR-PETEX590172_7YU18", 'passwd' => "rlnh6gh7p&");
		curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS, 
		          http_build_query($itexmo));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		echo curl_exec ($ch);
		curl_close ($ch);
	}

	public function cancel($id){
// 		$transaction = Transactions::where('transactions.id', $id)
// 							->select(['transactions.*', 's.fname as sfname', 's.lname as slname', 'r.contact as rcontact'])
// 							->join('users as s', 's.id', '=', 'transactions.sid')
// 							->join('users as r', 'r.id', '=', 'transactions.tid')
// 							->first();

// 		if($transaction->tid){
// 			$message = 'Transaction with ' . $transaction->sfname . ' ' . $transaction->slname . ' is cancelled';
// 			$this->itexmo($transaction->rcontact, $message);
// 		}

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
			->where('trackers.logged_in', "Yes")
			->join('trackers', 'trackers.uid', '=', 'users.id')
			->select(['users.*', 'trackers.lat as lat2', 'trackers.lng as lng2', 'trackers.updated_at as last_online'])
			->get();

		foreach($drivers as $key => $driver){
			$temp = Transactions::where('tid', $driver->id)->where("schedule", null)->whereIn('status', ['Finding Driver', 'For Pickup','For Delivery'])->first();

//             echo count((array)$temp) . " " . $driver->fname . " - ";
//             echo count((array)$temp) != 0;
			
// 			echo '<br>';
            
			if(count((array)$temp) != 0){
			 //   echo " - " . $temp->schedule;
				// if($temp->schedule == "ASAP" || $temp->schedule == "" || $temp->schedule == null){
				// if($temp->schedule == "ASAP" || $temp->schedule == "" || $temp->schedule == null || now()->toDateString() >= $temp->schedule){
					unset($drivers[$key]);
					continue;
				// }
			}

			$transactions = Transactions::where([
				['status', '=', 'Delivered'],
				['tid', '=', $driver->id],
				['rating', '!=', null]
			])->pluck('rating')->toArray();
			
			if(now()->diffInMinutes(now()->parse($driver->last_online)) > 15){
			    unset($drivers[$key]);
			}

			$driver->ave_ratings = count($transactions) > 0 ? ((array_sum($transactions) / count($transactions)) / 5) * 100 : 0;
		}
    
		echo json_encode($drivers);
	}

	public function getDriversLocation2(Request $req){
		$drivers = User::where('role', 'Rider')
			->where('trackers.logged_in', "Yes")
			->join('trackers', 'trackers.uid', '=', 'users.id')
			->select(['users.*', 'trackers.lat as lat2', 'trackers.lng as lng2', 'trackers.updated_at as last_online'])
			->get();

		foreach($drivers as $key => $driver){
			$schedules = Transactions::where([
				['tid', '=', $driver->id],
				['schedule', '!=', "ASAP"],
				['schedule', '>', $req->schedule],
			])->get();

			if($schedules != null){
				foreach ($schedules as $schedule) {
					if(now()->parse($req->schedule)->diffInSeconds(now()->parse($schedule->schedule)) <= 3600){
						unset($drivers[$key]);
					}
				}
			}

			$transactions = Transactions::where([
				['status', '=', 'Delivered'],
				['tid', '=', $driver->id],
				['rating', '!=', null]
			])->pluck('rating')->toArray();
			
			if(now()->diffInMinutes(now()->parse($driver->last_online)) > 15){
			    unset($drivers[$key]);
			}

			$driver->ave_ratings = count($transactions) > 0 ? ((array_sum($transactions) / count($transactions)) / 5) * 100 : 0;
		}
    
		echo json_encode($drivers);
	}

	public function getDriverLocation(Request $req){
		echo json_encode(User::where('users.id', $req->id)
			->join('trackers', 'trackers.uid', '=', 'users.id')
			->select($req->fields ? json_decode($req->fields) : ['users.*', 'trackers.lat as rlat', 'trackers.lng as rlng'])
			->first());
	}

	public function assignDriver(Request $req){
		echo Transactions::where('id', $req->id)->update([
			'tid' => $req->tid, 
			'assigned_time' => now(), 
			'status' => "Finding Driver",
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

		if($temp != null){
			if(!($temp->schedule == "ASAP" || $temp->schedule == "" || $temp->schedule == null)){
				if(now()->toDateString() < $temp->schedule){
					$temp = null;
				}
			}
		}

		echo json_encode($temp);
	}

	// FOR SCHEDULE FETCH
	public function checkRiderDelivery2(Request $req){
		$cond = [
			['tid', '=', auth()->user()->id],
			['schedule', 'LIKE', "2%"],
			['status', '=', "Finding Driver"],
		];

		$temp = Transactions::where($cond)
			->select(
				'transactions.*',
				'users.lat as slat',
				'users.lng as slng',
				'users.address as saddress',
				'users.fname as sfname',
				'users.lname as slname',
				'users.contact as scontact'
			)
			->join('users', 'users.id', '=', 'transactions.sid')
			->first();

		if(count($temp) == 0){
			$cond = [
				['tid', '=', auth()->user()->id],
				['schedule', 'LIKE', "2%"],
				['status', '!=', "Delivered"],
				['status', '!=', "Cancelled"],
				['status', '!=', "Rider Cancel"],
			];

			$temp = Transactions::where($cond)
				->select(
					'transactions.*',
					'users.lat as slat',
					'users.lng as slng',
					'users.address as saddress',
					'users.fname as sfname',
					'users.lname as slname',
					'users.contact as scontact'
				)
				->join('users', 'users.id', '=', 'transactions.sid')
				->get();

			$temp2 = null;

			foreach ($temp as $transaction) {
				if(now()->diffInSeconds(now()->parse($transaction->schedule)) <= 3600){
					$temp2 = $transaction;
				}
			}

			$temp = $temp2;
		}

		echo json_encode($temp);
	}

	public function updateStatus(Request $req){
// 		$transaction = Transactions::where('transactions.id', $req->id)
// 							->select(['transactions.*', 'r.fname as rfname', 'r.lname as rlname', 's.contact as scontact'])
// 							->join('users as s', 's.id', '=', 'transactions.sid')
// 							->join('users as r', 'r.id', '=', 'transactions.tid')
// 							->first();

// 		if($transaction->tid){
// 			$message = null;

// 			if($req->status == "Rider Cancel"){
// 				$message = 'Transaction has been cancelled by Rider ' . $transaction->rfname . ' ' . $transaction->rlname;
// 			}
// 			else if($req->status == 'For Pickup' || $req->status == "For Delivery"){
// 				$message = 'Your transaction is ' . $req->status;
// 			}

// 			if($message){
// 				$this->itexmo($transaction->scontact, $message);
// 			}
// 		}

		echo Transactions::where('id', $req->id)->update($req->except(['_token', 'id']));
	}

	public function uploadProof(Request $req){
		$temp = Image::make($req->proof);
		$rand = random_int(100000, 999999);

		$name = $req->id . "-$rand."  . $req->proof->getClientOriginalExtension();

		$destinationPath = public_path('uploads/');
		$path = $destinationPath . $name;

		$temp->save($path);

// SMS
// 		$transaction = Transactions::where('transactions.id', $req->id)
// 			->select(['transactions.*', 's.contact as scontact'])
// 			->join('users as s', 's.id', '=', 'transactions.sid')
// 			->join('users as r', 'r.id', '=', 'transactions.tid')
// 			->first();

// 		if($transaction->tid){
// 			$message = null;

// 			$message = 'Delivery to ' . $transaction->fname . ' ' . $transaction->lname . ' has been completed';
// 			$this->itexmo($transaction->scontact, $message);
// 		}

		echo Transactions::where('id', $req->id)->update(["proof" => "uploads/" . $name, 'status' => "Delivered", 'delivery_time' => now()->toDateTimeString()]);
	}

	public function getAll(Request $req){
		echo json_encode(Transactions::where($req->cond ? json_decode($req->cond) : ['id', '>', 0])->select($req->fields ? json_decode($req->fields) : "*")->get());
	}

	private function _view($view, $data = array()){
		return view('transactions.' . $view, $data);
	}
}
