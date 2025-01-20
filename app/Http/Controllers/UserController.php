<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        if($request->hasFile('photo')){
            $validated['image'] = '/storage/' . $request->file('photo')->store('users', 'public');
        }

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

        if($request->hasFile('photo')){
            if($data->photo){
                Storage::delete('public/'.$data->photo);
            }
            $validate['photo'] = $request->file('photo')->store('image', 'public');
        } else {
            if($data->photo){
                Storage::delete('public/'.$data->photo);
                $validate['photo'] = null;
            }
        }

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

    public function updateAkun (Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data = $request->all();

        if(auth()->user()->photo != null && auth()->user()->photo != ''){
            $old_photo = str_replace('/storage/', '', auth()->user()->photo);
            Storage::disk('public')->delete($old_photo);
        }

        if($request->hasFile('photo')) {
            $data['photo'] = '/storage/' . $request->file('photo')->store('users', 'public');
        } else {
            $data['photo'] = null;
        }

        auth()->user()->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Success update data',
            'data' => auth()->user()
        ]);
    }

    public function updateSecurity(Request $request) {
        $data = $request->validate([
          'old_password' => 'required|string',
          'password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = User::find(auth()->user()->id);
        if (!Hash::check($data['old_password'], $user->password)) {
          return response()->json([
            'message' => 'Password Lama tidak valid'
          ], 400);
        }

        if(Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Password baru tidak boleh sama dengan password lama'
            ], 500);
        }
    
        $user->password = bcrypt($data['password']);
        if ($user->update()) {
          return response()->json([
            'message' => 'Berhasil memperbarui password'
          ]);
        } else {
          return response()->json([
            'message' => 'Gagal memperbarui password'
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
