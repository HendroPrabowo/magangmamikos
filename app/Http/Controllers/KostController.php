<?php

namespace App\Http\Controllers;

use App\Kost;
use App\Transformers\KostDetailTransformer;
use App\Transformers\KostTransformer;
use App\Transformers\RoomTransformer;
use App\User;
use Illuminate\Http\Request;
use Auth;

class KostController extends Controller
{
    public function index(){
        $kost = Kost::all();

        return fractal()
            ->collection($kost)
            ->transformWith(new KostTransformer())
            ->toArray();
    }

    public function detail(){
        $kost = Kost::all();

        return fractal()
            ->collection($kost)
            ->transformWith(new KostDetailTransformer())
            ->toArray();
    }

    public function create(Request $request, $id){
        $user = User::find($id);
        if($user->role != 1)
            return response()->json([
                'error'     => 'Tidak bisa menambahkan kost',
                'message'   => 'Akun anda bukan akun pemilik kost',
            ]);

        $this->validate($request, [
            'nama'          => 'required',
            'deskripsi'     => 'required|min:5',
        ]);

        $kost = Kost::create([
            'user_id'   => $id,
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return fractal($kost, new KostTransformer())->toArray();
    }

    public function delete($id){
        $kost = Kost::find($id);
        if($kost == null)
            return response()->json([
                'error'     => 'Cant delete',
                'message'   => 'Kost tidak ada',
            ]);

        $kost->delete();
        return response()->json([
            'message'   => 'Success',
        ]);
    }

    public function show(){
        $user = Auth::user();

        $kosts = $user->kosts;
        return fractal()
            ->collection($kosts)
            ->transformWith(new KostTransformer())
            ->toArray();
    }
}
