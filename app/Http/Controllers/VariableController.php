<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variable;

class VariableController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Seller/Admin/Rider');
    }

    public function get(Request $req){
    	$temp = Variable::where('name', $req->name)->latest('created_at')->first();
    	echo $temp ? $temp->value : null;
    }

    public function update(Request $req){
    	echo Variable::create(['name' => $req->name, 'value' => $req->value]);
    }
}
