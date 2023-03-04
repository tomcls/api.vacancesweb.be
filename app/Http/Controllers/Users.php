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
        $d = $request->all();
        if (!empty($d['password']) && !empty($d['email'])) {
            $user = User::where(['email' => $d['password']])->get();
            if ($user) {
                if (User::checkPasswordHash($d['password'], $user['password'])) {
                    return $user;
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
     * User signup
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signup(Request $request)
    {
        $d = $request->all();
        if (!empty($d['password']) && !empty($d['email']) && !empty($d['firstname']) && !empty($d['lastname'])) {

            $salt = User::randomString(10);
            $hash = User::hashWithSalt($d['password'], $salt);
            // insert user with active = false;
            // send email with token for acceptance

        } else {
            return 'error';
        }
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
