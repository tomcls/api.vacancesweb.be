<?php

namespace App\Http\Controllers;

use App\Models\PasswordResets;
use App\Models\User;
use Illuminate\Http\Request;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * User login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $d = $request->validate([
            "email" => ['required', 'email'],
            "password" => ['required', 'string', "min:6", "max:30"],
        ]);
        $user = User::where(['email' => $d['email']])->first();
        if ($user) {
            if (User::checkPasswordHash($d['password'], $user['password'])) {
                $token = $user->createToken('LOGIN_SECRET_KEY')->plainTextToken;
                return response(['user'=>$user,'token'=>$token], 201);
            } else {
                return response(['error'=>'password not matched'], 401);
            }
        } else {
            return response(['error'=>'user not found'], 401);
        }
    }
    /**
     * User signup
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request)
    {

        $d = $request->validate([
            "firstname" => ['required', 'string', "min:2", "max:150"],
            "lastname" => ['required', 'string', "min:2", "max:150"],
            "email" => ['required', 'email', "unique:users,email"],
            "password" => ['required', 'string', "min:6", "max:30", 'confirmed'],
            "company_name" => ['sometimes'],
            "company_vat" => ['sometimes'],
            "lang" => ['required', 'string', "min:2", "max:2"],
        ]);

        $salt = User::randomString(10);
       

        $user = User::create([
            "firstname" => $d['firstname'],
            "lastname" => $d['lastname'],
            "email" => $d['email'],
            "password" => User::hashWithSalt($d['password'], $salt),
            "company_name" => $d['company_name'],
            "company_vat" => $d['company_vat'],
            "lang" => $d['lang'],
        ]);

        // insert user with active = false;
        // send email with token for acceptance
        return response($user, 201);
    }
    
    public function verify(Request $request)
    {
        $d = $request->all();
        if (!empty($d['token'])) {
            $pr = PasswordResets::where('token', $d['token'])->first();
            if ($pr) {
                $user = User::where('email', $pr['email'])->first();
                if (!empty($user)) {
                    // update the user active = true

                    // log the user in mean return a token 

                    // redirect to user space


                } else {
                    return 'error';
                }
            } else {
                return 'error';
            }
        } else {
            return 'error';
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
