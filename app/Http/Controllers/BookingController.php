<?php

namespace App\Http\Controllers;

use App\Excel\ReportBookingExcel;
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
        $data = Booking::with(['user', 'payments', 'show_time.film'])->when($request->search, function (Builder $query, string $search) {
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
        $booking = Booking::with(['show_time.film', 'booked_seats.seat', 'user'])->where('uuid', $uuid)->first();

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

    public function history (Request $request){
        $per = ($request->per) ?? 10;
        $page = ($request->page) ? $request->page - 1 : 0;

        DB::statement('set @no=0' . $per * $page);
        $data = Booking::with(['user', 'payments', 'show_time.film', 'show_time.studio.cinema'])->whereHas('user', function ($q) use ($request){
            $q->where('uuid', $request->uuid);
        })->when($request->search, function (Builder $query, string $search) {
            $query->WhereHas('user', function ($q) use ($search){
                $q->where('tanggal', 'LIKE', "%$search%")
                ->orWhere('nama', 'LIKE', "%$search%");
            });
        })->paginate($per, ['*', DB::raw('@no := @no +  1 AS no')]);

        return response()->json($data);   
    }

    public function report(Request $request){
        $data = Booking::whereYear('tanggal', $request->tahun)->whereHas('payments', function ($q) {
            $q->where("status", "success");
        })->with(['user', 'show_time', 'booked_seats.seat'])->get();

        $data->map(function ($a) {
            $a->seat = $a->booked_seats->map(function ($b) {
                return $b->seat->seat_number;
            })->implode(", ");
        });

        $excel = new ReportBookingExcel($data, $request->tahun);

        $excel->download("Report Booking Tahun $request->tahun");
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
