<?php

namespace App\Http\Controllers;

use App\Kost;
use App\Transformers\KostTransformer;
use App\Transformers\UserTransformer;
use App\User;
use Hamcrest\Thingy;
use Illuminate\Http\Request;
use Auth;
use League\Fractal\Resource\Collection;

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
        $user_fractal = fractal($user, new UserTransformer())->toArray();

        if($user->role == 2)
            return $user_fractal;

//        $kost_all = Kost::where('user_id', $user->id)->get();
//        $kost_array = fractal()
//            ->collection($kost)
//            ->transformWith(new KostTransformer())
//            ->toArray();

        $kost_all = User::find($user->id)->kosts;
        $kost_array = fractal()
            ->collection($kost_all)
            ->transformWith(new KostTransformer())
            ->toArray();

        return response()->json([
            'user'      => $user_fractal,
            'List Kost' => $kost_array,
        ]);
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
            'password'  => bcrypt($request->password),
            'api_token' => bcrypt($request->email),
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
            'password'  => bcrypt($request->password),
            'api_token' => bcrypt($request->email),
        ]);

        $data = User::find($user->id);

        $json = fractal($data, new UserTransformer())->toArray();

        return response()->json($json, 201);
    }
}
