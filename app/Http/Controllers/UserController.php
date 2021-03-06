<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('tipo')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->validateEmailAddress($request)) {
            if($request->id)
            User::find($request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'password' => $request->new_password?Hash::make($request->new_password):$request->password
                ]);
            else
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'type' => $request->type,
                    'password' => Hash::make($request->password),
                ]);

        } else {
            return response()->json(array(
                'code'      =>  422,
                'message'   =>  'Email já está cadastrado no sistema',
            ), 422);
        }

    }
    private function validateEmailAddress(Request $request) {
        $userQuery = User::query();
        if ($request->has('id')) {
            $userQuery->where('id', '!=', $request->id);
        }
        $user = $userQuery->where('email', $request->email)->first();
        if (!empty($user)) {
            return false;
        }

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return User::find($request->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function destroy(Request $request)
    {
        return User::find($request->id)->delete();
    }
}
