<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmRequest;
use App\Models\Film;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    public function get(){
        return response()->json(['data' => Film::all()]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0' . $per * $page);
        $data = Film::when($request->search, function (Builder $query, string $search){
            $query->where('title', 'LIKE', "%$search%");
        })->paginate($per, ['*', DB::raw('@no := @no +  1 AS no')]);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FilmRequest $request)
    {
        $validate = $request->validated();

        if($request->hasFile('poster')){
            $validate['poster'] = '/storage/' . $request->file('poster')->store('poster', 'public');
        }

        $film = Film::create($validate);
        $film->genreFilms()->sync($request->genre_film_id);

        if($film){
            return response()->json([
                'success' => true,
                'message' => 'Sukses menambahkan film',
                'data' => $film
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan film'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        $film = Film::with(['genreFilms', 'reviews.user'])->where('uuid', $uuid)->first();

        return response()->json([
            'success' => true,
            'message' => 'successfully fetch data',
            'data' => $film,
        ]);
    }

    /**
     * Show FIlm with highest rating
     */

     public function topFilm(){
        $data = Film::whereHas('reviews')->where('release_date', '<=', Carbon::now())->where('end_date', '>=', Carbon::now())->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating')->get();

        return response()->json([
            'success' => true,
            'message' => 'successfully fetch data Top Film',
            'data' => $data
        ]);
     }

     public function nowShowing(){
        $data = Film::where('release_date', '<=', Carbon::now())
        ->where('end_date', '>=', Carbon::now())
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'successfully fetch data',
            'data' => $data
        ]);
     }

     public function comingSoon(Request $request){
        $data = Film::where('release_date', '>', Carbon::now())->get();

        if(!$data)return response()->json([]);

        return response()->json([
            'success' => true,
            'message' => 'successfully fetch data',
            'data' => $data
        ]);
     }

    /**
     * Update the specified resource in storage.
     */
    public function update(FilmRequest $request, $uuid)
    {
        $film = Film::findByUuid($uuid);
        $validate = $request->validated();

        $film->genreFilms()->sync($request->genre_film_id);

        if($request->hasFile('poster')){
            if($film->poster){
                Storage::delete('public/'.$film->poster);
            }
            $validate['poster'] = '/storage/' . $request->file('poster')->store('image', 'public');
        } else {
            if($film->poster){
                Storage::delete('public/'.$film->poster);
                $validate['poster'] = null;
            }
        }

        if($film->update($validate)){
            return response()->json([
                'success' => true,
                'message' => 'Sukses mengubah data film',
                'data' => $film
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data film'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $film = Film::findByUuid($uuid);
        if($film->trailer){
            Storage::delete('public/'.$film->trailer);
        }

        $film->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sukses menghapus film'
        ]);
    }
}
