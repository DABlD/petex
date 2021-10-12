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
	    			['status', '!=', 'cancelled'],
	    			['status', '!=', 'delivered'],
	    		])->whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'deliveries' => Transactions::whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'cancelled' => Transactions::where('status', 'cancelled')->whereRaw('Date(created_at) = CURDATE()')->get()->count()
	    	]);
	    }
	    else if(auth()->user()->role == "Seller"){
	    	return $this->_view('dashboard', [
	    		'title' => 'Dashboard',
	    		'users' => User::all()->count(),
	    		'ongoing' => Transactions::where([
	    			['status', '!=', 'cancelled'],
	    			['status', '!=', 'delivered'],
	    			['sid', '=', auth()->user()->id]
	    		])->whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'deliveries' => Transactions::where('sid', auth()->user()->id)->whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'cancelled' => Transactions::where([
	    			['status', '=', 'cancelled'],
	    			['sid', '=', auth()->user()->id]
	    		])->whereRaw('Date(created_at) = CURDATE()')->get()->count()
	    	]);
	    }
	    else if(auth()->user()->role == "Rider"){
	    	return $this->_view('dashboard', [
	    		'title' => 'Dashboard',
	    		'users' => User::all()->count(),
	    		'ongoing' => Transactions::where([
	    			['status', '!=', 'cancelled'],
	    			['status', '!=', 'delivered'],
	    			['tid', '=', auth()->user()->id]
	    		])->whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'deliveries' => Transactions::where('tid', auth()->user()->id)->whereRaw('Date(created_at) = CURDATE()')->get()->count(),
	    		'cancelled' => Transactions::where([
	    			['status', '=', 'cancelled'],
	    			['tid', '=', auth()->user()->id]
	    		])->whereRaw('Date(created_at) = CURDATE()')->get()->count()
	    	]);
	    }
    }

    private function _view($view, $data = array()){
    	return view($view, $data);
    }
}
