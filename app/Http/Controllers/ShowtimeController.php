<?php

namespace App\Http\Controllers;

use App\Http\Requests\Showtimerequest;
use App\Models\Cinema;
use App\Models\ShowTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0' . $per * $page);
        $data = ShowTime::with(['film', 'studio.cinema'])->when($request->search, function(Builder $query, string $search){
           $query->whereHas('film', function ($query) use($search){
               $query->where('title', 'LIKE', "%$search%");
           })->orWhereHas('studio', function ($query) use($search){
               $query->where('name', 'LIKE', "%$search%");
           });
        })->when($request->uuid_film != 0, function ($q) use ($request){
            $q->whereHas('film', function ($q) use ($request){
                $q->where('uuid', $request->uuid_film);
            });
        })->when($request->uuid_studio != 0, function ($q) use ($request){
            $q->whereHas('studio', function ($q) use ($request){
                $q->where('uuid', $request->uuid_studio);
            });
        })->paginate($per, ['*', DB::raw("@no := @no + 1 AS no")]);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Showtimerequest $request)
    {
        $validated = $request->validated();

        $showtime = ShowTime::create($validated);
        if(!$showtime){
            return response()->json([
                'success' => false,
                'message' => 'Failed create data'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success create data',
            'data' => $showtime
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $showtime = ShowTime::findByUuid($uuid);
        if(!$showtime){
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success fetch data',
            'data' => $showtime
        ]);
    }

    public function getShowtime(Request $request)
    {
        $data = Cinema::when($request->city, function ($q) use ($request){
            $q->where('city', $request->city);
        })->whereHas('studios', function ($query) use ($request) {
            $query->whereHas('show_times', function ($q) use ($request){
                $q->whereHas('film', function ($q) use ($request) {
                    $q->where('uuid', $request->uuid);
                });
            });
        })
        ->with(['show_times' => function ($q) use ($request) {
            $q->whereHas('film', function ($q) use ($request) {
                $q->where('uuid', $request->uuid);
            });
            $q->with('studio');
        }])
        ->get();
    
        if ($data->isEmpty()) {
            return response()->json(['message' => 'Data not found', 'data' => []]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Success fetch data',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Showtimerequest $request, string $uuid)
    {
        $data = ShowTime::findByUuid($uuid);
        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }

        $validated = $request->validated();

        if($data->update($validated)){
            return response()->json([
                'success' => true,
                'message' => 'Success update data',
                'data' => $data
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
        $data = ShowTime::findByUuid($uuid);

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }

        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'success delete data'
        ]);
    }
}
