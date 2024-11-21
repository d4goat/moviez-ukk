<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = ($request->per) ?? 10;
        $page = ($request->page) ? $request->page - 1 : 0;

        DB::statement('set @no=0' . $per * $page);
        $data = Booking::with(['user', 'payment', 'show_time.film'])->when($request->search, function (Builder $query, string $search) {
            $query->WhereHas('user', function ($q) use ($search){
                $q->where('tanggal', 'LIKE', "%$search%")
                ->orWhere('nama', 'LIKE', "%$search%");
            });
        })->paginate($per, ['*', DB::raw('@no := @no +  1 AS no')]);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request)
    {
        $validated = $request->validated();

        $validated['invoice_number'] = 'INVOICE' . rand(1000000, 9999999);


        $booking = Booking::create($validated);

        if($booking){
            return response()->json([
                'success' => true,
                'message' => 'successfully booking',
                'data' => $booking
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'failed booking'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($uuid)
    {
        $booking = Booking::findByUuid($uuid);

        if(!$booking){
          return response()->json([
            'success' => false,
            'message' => 'error fetching data / no data found'
          ]);  
        }

        return response()->json([
            'success' => true,
             'data' => $booking
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookingRequest $request, $uuid)
    {
        $booking = Booking::findByUuid($uuid);
        $validated = $request->validated();

        if($booking->update($validated)){
            return response()->json([
                'success' => true,
                'message' => 'success update data booking',
                'data' => $booking
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'failed update data booking'
            ], 500 || 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($uuid)
    {
        $booking = Booking::findByUuid($uuid);

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'success delete data'
        ]);
    }
}
