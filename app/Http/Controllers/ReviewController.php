<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0' . $per * $page);
        $data = Review::when($request->search, function (Builder $query, string $search){
            $query->whereHas('users', function (Builder $query) use ($search){
                $query->where('name', 'LIKE', "%$search%");
            });
        });

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request)
    {
        $validated = $request->validated();
        $review = Review::create($validated);
        if(!$review){
            return response()->json([
                'success' => false,
                'message' => 'Failed create review'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success create review',
            'data' => $review
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        $review = Review::findByUuid($uuid);

        if(!$review){
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'success fetching data',
            'data' => $review
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewRequest $request, string $uuid)
    {
        $data = Review::findByUuid($uuid);

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
        } else{
            return response()->json([
                'success' => false,
                'message' => 'Failed update data'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $data = Review::findByUuid($uuid);

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }

        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Success delete data'
        ]);
    }
}
