<?php

namespace App\Http\Controllers;

use App\Models\FormType;
use Illuminate\Http\Request;
use App\Notifications\SmsReply;
use Illuminate\Support\Facades\Notification;

class SmsController extends Controller
{
    public function index()
    {
 
        return '1';
    }
 
    public function show(FormType $sms)
    {
        return view('invoices', compact('sms'));
    }

    public function sendNotification(Request $request) 
    {   
        $request->validate([
            'sms_id'=>'required|exists:sms,id',
        ]);
 
        $user = auth()->user();
 
        $sms = FormType::find($request->sms_id)->first();
 
        $sms['buttonText'] = 'View Invoice';
        $sms['invoiceUrl'] = route('show.sms');
        $sms['thanks'] = 'Your thank you message';
   
        Notification::send($user, new SmsReply($sms));
    
        return back()->with('You have successfully send the sms');
    }
}
