<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // COMMENTED THE FUNCTION CALL IN THE RegisterUsers.php BECAUSE VALIDATION HAS BEEN DONE IN JS.
        // return Validator::make($data, [
            // 'fname' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:6', 'confirmed'],
        // ]);
    }

    public function register(Request $request)
    {
        // dd($request->all());     
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

        $data = array_merge($request->except(["files"]), ["files" => json_encode($files)]);
        event(new Registered($user = $this->create($data)));

        $request->session()->put('success', 'Successfully Registered');

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        unset($data['confirm_password']);

        return User::create($data);
        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        // ]);
    }
}
