<?php

namespace App\Transformers;

use App\BookSurvey;
use App\Kost;
use App\User;
use League\Fractal\TransformerAbstract;
use Ramsey\Uuid\Generator\RandomBytesGenerator;

class BookSurveyTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(BookSurvey $book_survey)
    {
        $user = User::find($book_survey->user_id);
        $kost = Kost::find($book_survey->kost_id);

        return [
            'id'        => $book_survey->id,
            'user_id'   => $book_survey->user_id,
            'kost_id'   => $book_survey->kost_id,

            'user'      => $user->name,
            'kost'      => $kost->nama,
        ];
    }
}
