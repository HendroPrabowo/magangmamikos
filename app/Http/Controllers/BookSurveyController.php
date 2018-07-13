<?php

namespace App\Http\Controllers;

use App\BookSurvey;
use App\Transformers\BookSurveyTransformer;
use App\User;
use Illuminate\Http\Request;

class BookSurveyController extends Controller
{
    public function index(){
        $book = BookSurvey::all();

        return fractal()
            ->collection($book)
            ->transformWith(new BookSurveyTransformer())
            ->toArray();
    }

    public function book(Request $request, $user_id){
        $user = User::find($user_id);
        // Validasi apakah user ada
        if($user == null)
            return response()->json(['error' => 'User not Exist'], 400);

        // Validari role
        if($user->role == 1)
            return response()->json([
                'error' => 'Anda bukan anak kos'
            ], 401);

        // Validasi credit
        if($user->credit < 5)
            return response()->json(['error' => 'Credit tidak cukup'], 400);

        // Validasi request
        $this->validate($request, [
            'kost_id'    => 'required|integer'
        ]);

        // Validasi book_request apakah sudah pernah dibuat
        $book_before = BookSurvey::where([
            'user_id'   => $user_id,
            'kost_id'   => $request->kost_id,
        ])->get();

        if($book_before->get(0) != null) return response()->json(['message' => 'Sudah pernah membooking ini']);

        // Pengurangan credit
        $user->credit = $user->credit - 5;
        $user->save;

        $book = BookSurvey::create([
            'user_id'   => $user_id,
            'kost_id'   => $request->kost_id,
        ]);

        return fractal($book, new BookSurveyTransformer())->toArray();
    }
}
