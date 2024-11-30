<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index (Request $request) {
        $dataPayment = Payment::whereMonth('created_at', Carbon::now())->get()->sum('amount');

        $dataBooking = Booking::whereMonth('tanggal', Carbon::now())->get()->count();

        $data = [$dataBooking, $dataPayment];
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
