<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeatRequest;
use App\Models\Seats;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0' . $per * $page);
        $data = Seats::with('studio.cinema')->when($request->search, function (Builder $query, string $search) {
            $query->where('seat_number', 'LIKE', "%$search%")
            ->orWhereHas('studio.cinema', function ($query) use($search){
                $query->where('name', 'LIKE', "%$search%");
            });
        })->paginate($per, ['*', DB::raw("@no := @no + 1 AS no")]);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeatRequest $request)
    {
        $validated = $request->validated();
        $seat = Seats::create($validated);

        if(!$seat){
            return response()->json([
                'success' => false,
                'message' => 'Failed create seat data'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success create data',
            'data' => $seat
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        $seat = Seats::findByUuid($uuid);

        if(!$seat){
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'success fetching data',
            'data' => $seat
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeatRequest $request, $uuid)
    {
        $seat = Seats::findByUuid($uuid);

        if(!$seat){
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }

        $validated = $request->validated();

        if($seat->update($validated)){
            return response()->json([
                'success' => true,
                'message' => 'Success update data',
                'data' => $seat
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed update data'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $seat = Seats::findByUuid($uuid);
        if(!$seat){
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }
        $seat->delete();
        return response()->json([
            'success' => true,
            'message' => 'Success delete data'
        ]);
    }
}
