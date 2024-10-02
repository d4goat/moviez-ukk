<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0' . $per * $page);
        $data = User::when($request->search, function (Builder $query, string $search) {
            $query->where('name', 'LIKE', "%$search%");
        })->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        $validated['role_id'] = 2;

        $role = Role::findById($validated['role_id']);

        $user = User::create($validated);
        $user->assignRole($role);

        if(!$user){
            return response()->json([
                'success' => false,
                'message' => 'Failed create data',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success create data'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $data = User::findByUuid($uuid);

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetching data'
            ]);
        }

        return response()->json(compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $uuid)
    {
        $data = User::findByUuid($uuid);
        if(!$data){
            return response()->json([
                'message' => 'No data found'
            ]);
        }

        $validate = $request->validated();
        $validate['role_id'] = 2;

        $role = Role::findById($validate['role_id']);

        if($data->update($validate)){
            $data->syncRoles($role);
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
        $data = User::findByUuid($uuid);
        
        if(!$data){
            return response()->json([
                'message' => 'No data found'
            ]);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Success delete data'
        ]);
    }
}
