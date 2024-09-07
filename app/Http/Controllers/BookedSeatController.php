<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookedSeatRequest;
use App\Models\BookedSeat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookedSeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;
        DB::statement('set @no=0' . $per * $page);
        $data = BookedSeat::when($request->search, function (Builder $query, string $search){
            $query->where('name', 'LIKE', "%$search%");
        })->paginate($per, ['*', DB::raw('@no := +1 AS no')]);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookedSeatRequest $request)
    {
        $booked = BookedSeat::create($request->validated());
        if($booked){
            return response()->json([
                'success' => true,
                'message' => 'success menambahkan booked seat',
                'data' => $booked
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
        $booked = BookedSeat::findByUuid($uuid);
        if($booked){
            return response()->json([
                'success' => true,
                'message' => 'data ditemukan',
                'data' => $booked
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
    public function update(BookedSeatRequest $request, $uuid)
    {
        $booked = BookedSeat::findByUuid($uuid);
        if($booked){
            $booked->update($request->validated());
            return response()->json([
                'success' => true,
                'message' => 'data diperbarui',
                'data' => $booked
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
        $booked = BookedSeat::findByUuid($uuid);
        if($booked){
            $booked->delete();
            return response()->json([
                'success' => true,
                'message' => 'data di hapus'
            ]);
        }
    }
}
