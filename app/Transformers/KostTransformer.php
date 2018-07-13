<?php

namespace App\Transformers;

use App\Kost;
use League\Fractal\TransformerAbstract;

class KostTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Kost $kost)
    {
        return [
            'id'        => $kost->id,
            'user_id'   => $kost->user_id,
            'nama'      => $kost->nama,
            'deskripsi' => $kost->deskripsi,
            'address'   => $kost->address,
        ];
    }
}
