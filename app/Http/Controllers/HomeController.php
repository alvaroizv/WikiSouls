<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.home');
    }

    public function edit(){
        return view('auth.edit');
    }

    function update(Request $request): RedirectResponse {
        $user = Auth::user();
        $rules = [
            'name'            => 'required|max:255',
            'email'           => 'required|max:255|email',
            'currentpassword' => 'nullable|current_password',
            'password'        => 'nullable|min:8|confirmed'
        ];
        $messages = [
            'name.required'                     => 'nombre obligatorio',
            'name.max'                          => 'nombre maximo',
            'email.required'                    => 'email obligatorio',
            'email.max'                         => 'email maximo',
            'email.email'                       => 'email email',
            'currentpassword.current_password'  => 'clave anterior no correcta',
            'password.min'                      => 'password minimo',
            'password.confirmed'                => 'passwords no coinciden',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        $user->name = $request->name;
        if($request->email != $user->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;
        }
        if($request->password != null && $request->currentpassword != null) {
            $user->password = Hash::make($request->password);
        }
        try {
            $result = $user->save();
            $message = 'Ok';
        } catch(\Exception $e) {
            $message = 'No';
            $result = false;
        }
        $messageArray = [
            'general' => $message
        ];
        if($result) {
            return redirect()->route('home')->with($messageArray);
        } else {
            return back()->withInput()->withErrors($messageArray);
        }
    }
}
