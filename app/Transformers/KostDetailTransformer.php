<?php

namespace App\Transformers;

use App\Kost;
use League\Fractal\TransformerAbstract;

class KostDetailTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Kost $kost)
    {
//        $is_empty = null;
//        if($room->is_empty == 0) $is_empty = 'No';
//        else $is_empty = 'Yes';

        $rooms = fractal()
            ->collection($kost->rooms)
            ->transformWith(new RoomTransformer())
            ->toArray();

        return [
            'id'        => $kost->id,
            'user_id'   => $kost->user_id,
            'nama'      => $kost->nama,
            'deskripsi' => $kost->deskripsi,
            'list room' => $rooms,
        ];
    }
}
