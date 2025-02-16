<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dataPayment = Payment::where('status', 'success')->whereHas("booking", function ($q) use ($request) {
            $q->whereYear("tanggal", $request->year);
            $q->whereMonth("tanggal", $request->month);
        })->get()->sum('amount');

        $dataBooking = Booking::whereYear("tanggal", $request->year)->whereMonth('tanggal', $request->month)->whereHas('payments', function ($q) {
            $q->where('status', 'success');
        })->get()->count();

        $monthlyBookings = Booking::selectRaw('MONTH(tanggal) as month, COUNT(*) as total, SUM(total_price) as total_price')
            ->whereYear('tanggal', $request->year)
            ->whereHas('payments', function ($q) {
                $q->where('status', 'success');
            })
            ->groupBy('month')
            ->get();

        // Inisialisasi semua bulan dengan nilai 0
        $allMonths = collect(range(1, 12))->mapWithKeys(function ($month) use ($monthlyBookings) {
            $bookingData = $monthlyBookings->firstWhere('month', $month);
            return [
                $month => [
                    'total_bookings' => $bookingData ? $bookingData->total : 0,
                    'total_price' => $bookingData ? $bookingData->total_price : 0,
                ]
            ];
        })->sortKeys();

        // Format label bulan (Januari, Februari, ...)
        $labels = $allMonths->keys()->map(function ($month) {
            return \DateTime::createFromFormat('!m', $month)->format('F');
        })->values();

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Bookings',
                    'data' => $allMonths->pluck('total_bookings')->values(),
                    'backgroundColor' => '#42A5F5',
                    'borderColor' => '#42A5F5',
                ],
            ]
        ];

        $chartDataAmount = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Price',
                    'data' => $allMonths->pluck('total_price')->values(),
                    'backgroundColor' => '#66BB6A',
                    'borderColor' => '#66BB6A',
                ],
            ]
        ];


        return response()->json([
            'success' => true,
            'chart' => $chartData,
            'chart_amount' => $chartDataAmount,
            'data_booking' => $dataBooking,
            'data_payment' => $dataPayment,
        ]);
    }
}
