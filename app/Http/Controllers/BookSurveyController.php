<?php

namespace App\Http\Controllers;

use App\BookSurvey;
use App\Kost;
use App\Transformers\BookSurveyTransformer;
use App\User;
use Illuminate\Http\Request;
use Auth;

class BookSurveyController extends Controller
{
    public function index(){
        $book = BookSurvey::all();

        return fractal()
            ->collection($book)
            ->transformWith(new BookSurveyTransformer())
            ->toArray();
    }

    public function book(Request $request){
        $user = Auth::user();

        // Cek credit
        if($user->credit < 5)
            return response()->json(['message' => 'Credit tidak cukup'], 403);

        // Validasi request
        $this->validate($request, [
            'kost_id'    => 'required|integer',
            'book'  => 'required',
        ]);

        // Cek apakah kost ada
        $kost = Kost::find($request->kost_id);
        if($kost == null)
            return response()->json(['message' => 'Kost tidak ada'], 403);

        // Cek apakah user lain sudah membooking di jam yang sama
        $book_another_user_before = BookSurvey::where([
            'kost_id'   => $request->kost_id,
            'book'      => $request->book,
        ])->get();

        if($book_another_user_before->get(0) != null) return response()->json([
            'error'     => 'Tidak bisa membooking',
            'message'   => 'Sudah ada user lain yang membooking di jam yang sama',
        ], 403);

        // Cek book_request apakah sudah pernah dibuat
        $book_before = BookSurvey::where([
            'user_id'   => $user->id,
            'kost_id'   => $request->kost_id,
        ])->get();

        if($book_before->get(0) != null) return response()->json(['message' => 'Sudah pernah membooking ini'], 403);

        // Pengurangan credit
        $user->credit = $user->credit - 5;
        $user->save;

        $book = BookSurvey::create([
            'user_id'   => $user->id,
            'kost_id'   => $request->kost_id,
            'book'      => $request->book,
        ]);

        return fractal($book, new BookSurveyTransformer())->toArray();
    }
}
