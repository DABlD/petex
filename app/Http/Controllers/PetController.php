<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class PetController extends Controller
{
    
    public function __construct(){
        $this->middleware('permissions:' . 'Seller');
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'Pet Listing'
        ]);
    }

    private function _view($view, $data = array()){
    	return view('pets.' . $view, $data);
    }
}
