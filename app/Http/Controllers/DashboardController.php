<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index (Request $request) {
        $dataPayment = Payment::whereMonth('created_at', $request->month)->get()->sum('amount');

        $dataBooking = Booking::whereMonth('tanggal', $request->month)->get()->count();

        return response()->json([
            'success' => true,
            'data_booking' => $dataBooking,
            'data_payment' => $dataPayment,
        ]);
    }
}
