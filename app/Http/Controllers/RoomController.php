<?php

namespace App\Http\Controllers;

use App\Room;
use App\Transformers\RoomTransformer;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(){
        $rooms = Room::all();

        return fractal()
            ->collection($rooms)
            ->transformWith(new RoomTransformer())
            ->toArray();
    }

    public function create(Request $request, $id){
        $this->validate($request, [
            'name'          => 'required',
            'description'   => 'required|min:5',
        ]);

        $room = Room::create([
            'kost_id'       => $id,
            'name'          => $request->name,
            'description'   => $request->description,
        ]);

        return fractal($room, new RoomTransformer())->toArray();
    }
}
