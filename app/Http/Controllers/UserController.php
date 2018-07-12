<?php

namespace App\Http\Controllers;

use App\Transformers\UserTransformer;
use App\User;
use Hamcrest\Thingy;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    /**
     * All User
     */
    public function index()
    {
        $users = User::all();

        return fractal()
            ->collection($users)
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required|min:5',
        ]);

        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json(['error' => 'Email of Password wrong'], 401);
        }

        $user = User::find(Auth::user()->id);

        return fractal($user, new UserTransformer())->toArray();
    }

    /**
     * Register a new anak kos account
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:5',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        $data = User::find($user->id);

        $json = fractal($data, new UserTransformer())->toArray();

        return response()->json($json, 201);
    }

    /**
     * Register a new pemilik kos account
     */
    public function store_pemilik_kos(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:5',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => 1,
            'password'  => bcrypt($request->password)
        ]);

        $data = User::find($user->id);

        $json = fractal($data, new UserTransformer())->toArray();

        return response()->json($json, 201);
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
    public function destroy($id)
    {
        //
    }
}
