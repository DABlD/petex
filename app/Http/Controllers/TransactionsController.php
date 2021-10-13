<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

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

    private function _view($view, $data = array()){
    	return view('transactions.' . $view, $data);
    }
}
