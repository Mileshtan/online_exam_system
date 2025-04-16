<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    //User Registration View
    public function loadRegister()
    {
        if (Auth::user() && Auth::user()->is_admin ==1) {
            return redirect('/admin/dashboard');
        }
        elseif(Auth::user() && Auth::user()->is_admin ==0){
            return redirect('/dashboard');
        }
        return view('register');
    }

    //User Registration Store
    public function studentRegister(Request $request)
    {
        $request->validate([
            'name'=>'string|required|min:1',
            'email'=>'string|email|required|max:100|unique:users',
            'password'=>'string|required|confirmed|min:6'
        ]);

        $user=new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();
        return back()->with('success','Your Registration has been successfull');
    }

    //User login
    public function loadLogin()
    {
        if (Auth::user() && Auth::user()->is_admin ==1) {
            return redirect('/admin/dashboard');
        }
        elseif(Auth::user() && Auth::user()->is_admin ==0){
            return redirect('/dashboard');
        }
        return view('login');
    }

    //User Logout
    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email'=>'string|required|email',
            'password'=>'string|required'
        ]);

        $userCredential=$request->only('email','password');

        if (Auth::attempt($userCredential)) {
            if (Auth::user()->is_admin == 1) {
                return redirect('admin/dashboard');
            } else {
                return redirect('/dashboard');
            }
            
        }
        else{
            return back()->with('error','Username and password is incorrect');
        }
    }

    public function loadDashboard()
    {
        return view('student.dashboard');
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }
}
