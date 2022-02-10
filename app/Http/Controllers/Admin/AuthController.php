<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
    public function login() {
        return view( 'auth.login' );
    }

    public function postLogin( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'email'    => 'required|email',
            'password' => 'required|min:6|max:12',
        ), array(
            'email.required'    => 'Email field is required',
            'password.required' => 'Password field is required',
            'password.min'      => 'Password must be at least 6 characters',
            'password.max'      => 'Password must not be greater than 12 characters',
        ) );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput();
        }

        $admin = User::where( 'email', $request->email );

        if ( !$admin->exists() ) {
            return redirect()->back()->with( 'error', 'Email not found our records!' );
        }

        $cre = $request->only( 'email', 'password' );

        if ( Auth::attempt( $cre ) ) {
            return redirect()->route( 'home' );
        } else {
            return redirect()->back()->with( 'error', 'Something wrong' );
        }

    }

    public function logout() {
        Auth::logout();
        return redirect()->route( 'showLogin' );
    }

    public function showRegister() {
        return view( 'auth.register' );
    }

    public function postRegister( Request $request ) {
        $validator = Validator::make( $request->all(), array(
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:12',
        ), array(
            'name.required'     => 'Name field is required',
            'email.required'    => 'Email field is required',
            'email.unique'      => 'Email is already exist',
            'password.required' => 'Password field is required',
            'password.min'      => 'Password must be at least 6 characters',
            'password.max'      => 'Password must not be greater than 12 characters',
        ) );

        if ( $validator->fails() ) {
            return redirect()->back()
                ->withErrors( $validator )
                ->withInput();
        }

        $user = User::create( array(
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make( $request->password ),
            'role'     => 'admin',
            'image'    => 'admin.png',
        ) );

        auth()->login( $user );
        return redirect()->route( 'home' )->with( 'success', 'Welcome ' . $user->name );
    }

}
