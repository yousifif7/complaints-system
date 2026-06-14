<?php

namespace App\Http\Controllers;

use App\Enums\ComplaintStatus;
use App\Models\FormType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function complaints(Request $request): StreamedResponse
    {
        $query = FormType::with(['category', 'requestType'])->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $filename = 'complaints-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                __('messages.export_ticket_number'),
                __('messages.export_department'),
                __('messages.export_category'),
                __('messages.export_name'),
                __('messages.export_phone'),
                __('messages.export_address'),
                __('messages.export_status'),
                __('messages.export_priority'),
                __('messages.export_submitted_at'),
            ]);

            $query->chunk(200, function ($complaints) use ($handle) {
                foreach ($complaints as $complaint) {
                    fputcsv($handle, [
                        $complaint->ticket_number,
                        $complaint->category?->localized_name,
                        $complaint->requestType?->localized_name,
                        $complaint->name,
                        $complaint->phone,
                        $complaint->address,
                        ComplaintStatus::label($complaint->status),
                        $complaint->priority_label,
                        $complaint->created_at?->format('Y-m-d H:i'),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
