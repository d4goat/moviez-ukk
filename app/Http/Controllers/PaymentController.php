<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per = $request->per ?? 10;
        $page = $request->page ? $request->page - 1 : 0;

        DB::statement('set @no=0' . $per * $page);
        $data = Payment::with('bookings')->when($request->search, function (Builder $query, string $search){
            $query->whereHas('bookings', function (Builder $query) use ($search){
                $query->whereHas('users', function (Builder $query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%");
                });
            });
        })->paginate($per, ['*', DB::raw('@no := @no +  1 AS no')]);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        $validated = $request->validated();

        $payment = Payment::create($validated);
        if(!$payment){
          return response()->json([
            'success' => false,
            'message' => 'Failed create payment'
          ]);
        }
        return response()->json([
          'success' => true,
          'message' => 'Success create payment',
          'data' => $payment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $payment = Payment::findByUuid($uuid);

        if(!$payment){
            return response()->json([
                'success' => false,
                'message' => 'No data found'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' =>  'sucessfully fetch',
            'data' => $payment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentRequest $request, $uuid)
    {
        $payment = Payment::findByUuid($uuid);
        if(!$payment){
            return response()->json([
                'success' => false,
                'message' => 'No data found'
            ]);
        }
        
        $validated = $request->validated();
        
        if($payment->update($validated)){
            return response()->json([
                'success' => true,
                'message' => 'Success update payment',
                'data' => $payment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed update payment'
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $payment = Payment::findByUuid($uuid);
        if(!$payment){
            return response()->json([
                'success' => false,
                'message' => 'No data found'
            ]);
        }

        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Success delete payment'
        ]);
    }
}
