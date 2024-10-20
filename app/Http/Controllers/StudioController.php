<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudioRequest;
use App\Models\Studio;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0' . $per * $page);
        $data = Studio::with(['cinema'])->when($request->search, function (Builder $query, string $search){
            $query->where('name', 'LIKE', "%$search%")
            ->orWhereHas('cinema', function ($q) use ($search){
                $q->where('name', 'LIKE', "%$search%");
            });
        })->paginate($per, ['*', DB::raw("@no := @no + 1 AS no")]);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudioRequest $request)
    {
        $validated = $request->validated();
        $studio = Studio::create($validated);

        if(!$studio){
            return response()->json([
                'success' => false,
                'message' => 'Failed create data'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success create data',
            'data' => $studio
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $data = Studio::findByUuid($uuid);

        if(!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching data'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success fetching data',
            'data' => $data
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudioRequest $request, string $uuid)
    {
        $data = Studio::findByUuid($uuid);
        if(!$uuid){
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
        } else{
            return response()->json([
                'success' => false,
                'message' => 'failed update data'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $data = Studio::findByUuid($uuid);

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
