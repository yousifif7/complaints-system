<!DOCTYPE html>
<html lang="{{ $htmlLang }}" dir="{{ $htmlDir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.request_details') }} {{ $myrequest->ticket_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Cairo', sans-serif; }
        table, th, td { border: 2px solid #333 !important; }
        .td-header { text-align: center; font-weight: bold; }
    </style>
</head>
<body class="p-4">
    @php
        $headerImage = !empty($appSettings->header_image_path)
            ? asset('userFiles/' . $appSettings->header_image_path)
            : '/header.jpg';
    @endphp

    <div class="container">
        @if(file_exists(public_path(parse_url($headerImage, PHP_URL_PATH) ?? $headerImage)))
            <img src="{{ $headerImage }}" class="w-100 mb-3" alt="header">
        @endif

        <table class="table">
            <tr>
                <td class="td-header">{{ __('messages.request_date') }}: {{ $myrequest->created_at?->format('d/m/Y') }}</td>
                <td class="td-header">{{ __('messages.request_type') }}: {{ $myrequest->requestType?->localized_name }}</td>
                <td class="td-header">{{ __('messages.ticket_number') }}: {{ $myrequest->ticket_number ?? $myrequest->legacy_reference }}</td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <td><b>{{ __('messages.request_status') }}:</b> {{ $myrequest->status_label }}</td>
                <td><b>{{ __('messages.priority') }}:</b> {{ $myrequest->priority_label }}</td>
                <td><b>{{ __('messages.department') }}:</b> {{ $myrequest->category?->localized_name }}</td>
            </tr>
            <tr>
                <td colspan="2"><b>{{ __('messages.phone_number') }}:</b> {{ $myrequest->phone }}</td>
                <td><b>{{ __('messages.name') }}:</b> {{ $myrequest->name }}</td>
            </tr>
            <tr>
                <td colspan="3"><b>{{ __('messages.address') }}:</b> {{ $myrequest->address }}</td>
            </tr>
            <tr>
                <td colspan="3"><b>{{ __('messages.request_details') }}:</b> {{ $myrequest->content }}</td>
            </tr>
            @if($myrequest->internal_notes && auth()->check())
                <tr>
                    <td colspan="3"><b>{{ __('messages.internal_notes') }}:</b> {{ $myrequest->internal_notes }}</td>
                </tr>
            @endif
            <tr>
                <td colspan="3">
                    <b>{{ __('messages.attachments') }}:</b><br>
                    @if ($myrequest->file)
                        <a target="_blank" href="{{ $myrequest->file_url }}">
                            @if($myrequest->isPdfAttachment())
                                {{ __('messages.pdf') }}
                            @else
                                <img src="{{ $myrequest->file_url }}" style="max-height: 400px;" class="mt-2">
                            @endif
                        </a>
                    @else
                        <span class="text-muted">{{ __('messages.no_attachments') }}</span>
                    @endif
                </td>
            </tr>
        </table>

        @if(auth()->check() && $myrequest->notes->count())
            <h5>{{ __('messages.activity_log') }}</h5>
            <ul class="list-group mb-3">
                @foreach($myrequest->notes as $note)
                    <li class="list-group-item">
                        <small class="text-muted">{{ $note->created_at?->format('Y-m-d H:i') }}</small> —
                        {{ $note->note }}
                        @if($note->user) <em>({{ $note->user->name }})</em> @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <button onclick="window.print()" class="btn btn-primary">{{ __('messages.print') }}</button>
    </div>
</body>
</html>
