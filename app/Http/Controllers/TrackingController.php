<?php

namespace App\Http\Controllers;

use App\Models\FormType;
use App\Models\Setting;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        if (!Setting::current()->tracking_enabled) {
            abort(404);
        }

        return view('tracking.index');
    }

    public function lookup(Request $request)
    {
        $request->validate([
            'ticket_number' => 'required|string',
            'phone' => 'required|string',
        ]);

        $complaint = FormType::with(['category', 'requestType'])
            ->where('ticket_number', $request->ticket_number)
            ->where('phone', $request->phone)
            ->first();

        if (!$complaint) {
            return back()
                ->withInput()
                ->withErrors(['ticket_number' => __('messages.complaint_not_found')]);
        }

        return view('tracking.show', compact('complaint'));
    }

    public function show(string $ticketNumber)
    {
        $complaint = FormType::with(['category', 'requestType'])
            ->where('ticket_number', $ticketNumber)
            ->firstOrFail();

        return view('tracking.show', compact('complaint'));
    }
}
