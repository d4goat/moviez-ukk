<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmCastRequest;
use App\Models\FilmCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilmCastsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0' . $per * $page);
        $data = FilmCast::with(['film'])->when($request->search, function (Builder $query, string $search){
            $query->whereHas('film', function ($q) use ($search){
                $q->where('cast_name', 'LIKE', "%$search%")
                ->orWhere('name', 'LIKE', "%$search%");
            });
        })->whereHas('film', function ($q) use ($request){
            $q->where('uuid', $request->uuid);
        })->paginate($per, ['*', DB::raw('@no := @no +  1 AS no')]);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FilmCastRequest $request)
    {
        $validated = $request->validated();

        $filmCast = FilmCast::create($validated);

        if(!$filmCast){
            return response()->json([
                'success' => false,
                'message' => 'failed create data film cast'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'success create data film cast',
            'data' => $filmCast
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $data = FilmCast::findByUuid($uuid);
        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'success fetching data film cast',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FilmCastRequest $request, string $uuid)
    {
        $filmCast = FilmCast::findByUuid($uuid);
        if(!$filmCast){
            return response()->json([
                'message' => 'data not found'
            ]);
        }

        $validated = $request->validated();
        if($filmCast->update($validated)){
            return response()->json([
                'success' => true,
                'message' => 'success update data film cast',
                'data' => $filmCast
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'failed update data film cast'
            ], 422 || 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $filmCast = FilmCast::findByUuid($uuid);
        if($filmCast){
            $filmCast->delete();
            return response()->json([
                'success' => true,
                'message' => 'success delete data'
            ]);
        }
    }
}
