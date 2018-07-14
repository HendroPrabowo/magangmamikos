<?php

namespace App\Http\Controllers;

use App\Kost;
use App\Room;
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

    public function create(Request $request){
        $user = Auth::user();

        if($user->role != 1)
            return response()->json([
                'error'     => 'Tidak bisa menambahkan kost',
                'message'   => 'Akun anda bukan akun pemilik kost',
            ]);

        $this->validate($request, [
            'nama'          => 'required',
            'deskripsi'     => 'required|min:5',
            'address'       => 'required',
        ]);

        $kost = Kost::create([
            'user_id'   => $user->id,
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'address'   => $request->address,
        ]);

        return fractal($kost, new KostTransformer())->toArray();
    }

    public function delete($id){
        $user = Auth::user();
        $kost = Kost::find($id);

        // Cek kost apakah anda
        if($kost == null)
            return response()->json(['message' => 'kost tidak ada'], 400);

        // Cek kepemilikan kost
        if($user->id != $kost->user_id)
            return response()->json(['message' => 'kost ini punya akun lain'], 403);

        // Hapus semua roomnya dulu
        Room::where('kost_id', $kost->id)->delete();

        // Hapus kost
        $kost->delete();
        return response()->json(['message' => 'kost berhasil dihapus']);
    }

    public function show(){
        $user = Auth::user();

        $kosts = $user->kosts;
        return fractal()
            ->collection($kosts)
            ->transformWith(new KostTransformer())
            ->toArray();
    }

    public function kostAndRoom(){
        $user = Auth::user();

        return fractal()
            ->collection($user->kosts)
            ->transformWith(new KostDetailTransformer())
            ->toArray();
    }
}
