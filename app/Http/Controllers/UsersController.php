<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Image;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Seller/Admin/Rider');
    }

    public function index(){
        return $this->_view('index', [
            'title' => 'User Management'
        ]);
    }

    public function create(){
    	return $this->_view('create', [
    		'title' => 'Add User'
    	]);
    }

    public function edit(User $user){
        return $this->_view('edit', [
            'title' => 'Edit User Details',
            'user' => array_except($user, ['password'])
        ]);
    }

    public function store(Request $request){

        $images = $request->file('files');
        $files = [];

        foreach($images as $image){
            $temp = Image::make($image);
            $rand = random_int(100000, 999999);

            $name = $request->fname . '_' . $request->lname . "-$rand."  . $image->getClientOriginalExtension();

            $destinationPath = public_path('uploads/');
            $path = $destinationPath . $name;

            array_push($files, "uploads/" . $name);
            $temp->save($path);
        }

        $data = $request->except(['confirm_password', '_token', 'files']);

        if(User::create(array_merge($data, ["files" => json_encode($files)]))){
            $request->session()->flash('success', 'User Successfully Added.');
            return redirect()->route('users.index');
        }
        else{
            $request->session()->flash('error', 'There was a problem adding the user. Try again.');
            return back();
        }
    }

    public function update(Request $req){
        if(User::where('id', $req->id)->update($req->except(['_token']))){
            $req->session()->flash('success', 'Profile Successfully Updated.');
            return redirect()->route('users.index');
        }
        else{
            $req->session()->flash('error', 'There was a problem updating the user. Try again.');
            return back();
        }
    }

    public function delete(User $user){
        $user->deleted_at = now()->toDateTimeString();
        echo $user->save();
    }

    public function get(User $user){
    	echo json_encode($user);
    }

    private function _view($view, $data = array()){
    	return view('users.' . $view, $data);
    }
}
