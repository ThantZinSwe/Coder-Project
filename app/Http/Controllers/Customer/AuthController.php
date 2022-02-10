<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {
    public function showLogin() {
        return view( 'customer.login' );
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
            return redirect()->back()
                ->withErrors( $validator )
                ->withInput();
        }

        $user = User::where( 'email', $request->email );

        if ( !$user->exists() ) {
            return redirect()->back()->with( 'error', 'Email not found in our records!' );
        }

        if ( !Hash::check( $request->password, $user->first()->password ) ) {
            return redirect()->back()->with( 'error', 'Password incorrect!' );
        }

        auth()->login( $user->first() );
        return redirect()->route( 'index' )->with( 'success', 'Welcome Back ' . $user->first()->name );
    }

    public function logout() {
        Auth::logout();
        return redirect()->route( 'index' )->with( 'success', 'Logout success' );
    }

    public function showRegister() {
        return view( 'customer.register' );
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
            'role'     => 'user',
            'image'    => 'user.png',
        ) );

        auth()->login( $user );
        return redirect()->route( 'index' )->with( 'success', 'Welcome ' . $user->name );
    }

}
