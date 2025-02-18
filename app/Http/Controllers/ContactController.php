<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'type' => 'required|in:Complaint,Suggestion,Other...',
            'message' => 'required',
        ]);

        try{
            Mail::to(env('MAIL_USERNAME'))->send(new ContactUsMail($request->email, $request->name, $request->type, $request->subject, $request->message));

            return response()->json([
                'success' => true,
                'message' => 'success send message'
            ]);
        } catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
