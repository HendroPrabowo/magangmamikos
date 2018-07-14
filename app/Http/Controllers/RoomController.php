<?php

namespace App\Http\Controllers;

use App\Kost;
use App\Room;
use App\Transformers\RoomTransformer;
use Illuminate\Http\Request;
use Auth;

class RoomController extends Controller
{
    public function index(){
        $rooms = Room::all();

        return fractal()
            ->collection($rooms)
            ->transformWith(new RoomTransformer())
            ->toArray();
    }

    public function create(Request $request, $id_kost){
        $user = Auth::user();
        $kost = Kost::find($id_kost);

        // Cek kost ada atau tidak
        if($kost == null)
            return response()->json(['message' => 'kost tidak ada'], 400);

        // Cek pemilik kost
        if($user->id != $kost->user_id)
            return response()->json(['message' => 'anda bukan pemilik kost ini'], 403);

        if($user->role != 1)
            return response()->json(['message' => 'akun anda bukan pemilik kost'], 403);

        $this->validate($request, [
            'name'          => 'required',
            'description'   => 'required|min:5',
        ]);

        $room = Room::create([
            'kost_id'       => $id_kost,
            'name'          => $request->name,
            'description'   => $request->description,
        ]);

        return fractal($room, new RoomTransformer())->toArray();
    }

    public function delete($id_room){
        $user = Auth::user();

        // Cek kamar
        $room = Room::find($id_room);
        if($room == null)
            return response()->json(['message' => 'ruangan tidak ada'], 400);

        $user_id = $room->kost->user_id;

        // Cek kepemilikan kost dan ruangan
        if($user->id != $user_id)
            return response()->json(['message' => 'anda bukan pemilik kost dan kamar ini'], 403);

        Room::destroy($id_room);

        return response()->json(['message' => 'success']);
    }
}
