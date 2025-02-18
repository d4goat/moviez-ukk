<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookedSeatRequest;
use App\Models\BookedSeat;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\ShowTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

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
        })->paginate($per, ['*', DB::raw('@no := @no +  1 AS no')]);
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookedSeatRequest $request)
    {
        try {
            $bookedSeats = collect($request->seat_id)->map(function ($seatId) use ($request) {
                return BookedSeat::create([
                    'booking_id' => $request->booking_id,
                    'seat_id' => $seatId
                ]);
            });

            Config::$serverKey = getenv('MIDTRANS_SERVER_KEY');
            Config::$clientKey = getenv('MIDTRANS_CLIENT_KEY');
            Config::$isProduction = false; // Set false for sandbox mode
            // Config::$curlOptions = array(
            //     CURLOPT_SSL_VERIFYHOST => 0,
            //     CURLOPT_SSL_VERIFYPEER => 0,
            // );


            $payment = Payment::findByUuid($request->uuid);

            $transaction_details = array(
                'order_id' => $payment->uuid,
                'gross_amount' => $payment->amount,
                'callback' => [
                    "finish" => 'https://957a-2407-0-3002-5d13-d034-88ed-c467-9a87.ngrok-free.app/landing/invoice'
                ]
            );

            $snapToken = Snap::getSnapToken(['transaction_details' => $transaction_details]);

            if ($bookedSeats->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error occured while booking seat'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Successfully booked seats',
                'data' => $bookedSeats,
                'uuid' => $payment->uuid,
                'token' => @$snapToken
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error occurred while booking seats: ' . $e->getMessage()
            ], 500);
        }
    }

    public function callback(Request $request){
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'capture'){
                $payment = Payment::findByUuid($request->order_id);
                $payment->update(['status' => 'Completed']);
                return response()->json(['messagse' => 'berhasil membayar']);
            } else {
                return response()->json(['message' => 'gagal membayar']);
            }
        }
    }

    public function showByBooking(Request $request){
        $request->validate([
            'uuid' => 'required|exists:show_times,uuid',
        ]);

        $data = ShowTime::where('uuid', $request->uuid)->with(['bookings' => function ($q) {
            $q->whereDay('tanggal', Carbon::now());
            $q->whereHas('payments', function ($q) {
                $q->where("status", 'success');
            });
            $q->with(['booked_seats.seat']);
        }])->first();

        if(!$data){
            return response()->json([
                'success' => false,
                'message' => 'no data found',
                'data' => []
            ], 500);
        }


        return response()->json([
            'success' => true,
            'message' => 'success fetch data',
            'data' => $data,
        ], 200);
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
