<?php

namespace App\Transformers;

use App\Kost;
use App\Room;
use League\Fractal\TransformerAbstract;

class RoomTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Room $room)
    {
        $is_empty = null;
        if($room->is_empty == 1) $is_empty = 'No';
        else $is_empty = 'Yes';

        $kost = Kost::find($room->kost_id);

        return [
            'id'            => $room->id,
            'kost'          => $kost->nama,
            'name'          => $room->name,
            'description'   => $room->description,
            'is_empty'      => $is_empty,
        ];
    }
}
