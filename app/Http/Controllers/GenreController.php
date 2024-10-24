<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{

    public function get(){
        return response()->json(['data' => Genre::all()]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = ($request->per) ?? 10;
        $page = ($request->page) ? $request->page - 1 : 0;

        DB::statement('set @no=0' . $per * $page);
        $data = Genre::when($request->search, function (Builder $query, string $search){
            $query->where('name', 'LIKE', "%$search%");
        })->paginate($per, ['*', DB::raw('@no := @no +  1 AS no')]);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GenreRequest $request)
    {
        $validated = $request->validated();

        $genre = Genre::create($validated);

        if($genre){
            return response()->json([
                'success' => true, 
                'message' => 'success menambahkan genre',
                'data' => $genre
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'terjadi kesalahan saat menambah data'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $genre = Genre::findByUuid($uuid);

        if($genre){
            return response()->json([
                'success' => true,
                'data' => $genre
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error mengambil data'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GenreRequest $request, $uuid)
    {
        $genre = Genre::findByUuid($uuid);
        $validated = $request->validated();

        if($genre->update($validated)){
            return response()->json([
                'success' => true,
                'message' => 'succes update data',
                'data' => $genre
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'gagal update data'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $genre = Genre::findByUuid($uuid);

        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'success hapus data'
        ]);
    }
}
