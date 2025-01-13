<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index (Request $request) {
        $dataPayment = Payment::where('status', 'success')->whereHas("booking", function ($q) use ($request){
            $q->whereMonth("tanggal", $request->month);
        })->get()->sum('amount');

        $dataBooking = Booking::whereMonth('tanggal', $request->month)->whereHas('payments', function ($q) {
            $q->where('status', 'success');
        })->get()->count();

        return response()->json([
            'success' => true,
            'data_booking' => $dataBooking,
            'data_payment' => $dataPayment,
        ]);
    }
}
