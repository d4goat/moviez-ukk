<?php

namespace App\Http\Controllers;

use App\Http\Requests\CinemaRequest;
use App\Models\Cinema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CinemaController extends Controller
{

    public function get(){
        return response()->json(['data' => Cinema::all()]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;
        DB::statement('set @no=0' . $per * $page);

        $data = Cinema::when($request->search, function (Builder $query, string $search) {
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('city', 'LIKE', "%$search%")
                ->orWhere('address', 'LIKE', "%$search%");
            })->paginate($per, ['*', DB::raw('@no := @no +  1 AS no')]);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CinemaRequest $request)
    {
        $validated = $request->validated();

        $cinema = Cinema::create($validated);

        if ($cinema) {
            return response()->json([
                'success' => true,
                'message' => 'success menambahkan cinema',
                'data' => $cinema
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
    public function show($uuid)
    {
        $cinema = Cinema::findByUuid($uuid);
        if ($cinema) {
            return response()->json([
                'success' => true,
                'data' => $cinema
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CinemaRequest $request, $uuid)
    {
        $cinema = Cinema::findByUuid($uuid);
        $validated = $request->validated();
        if ($cinema->update($validated)) {
            return response()->json([
                'success' => true,
                'message' => 'data berhasil diupdate',
                'data' => $cinema
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $cinema = Cinema::findByUuid($uuid);
        $cinema->delete();
        return response()->json([
            'success' => true,
            'message' => 'data berhasil dihapus',
        ]);
    }
}
