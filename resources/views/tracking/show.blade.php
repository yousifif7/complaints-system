@extends('layouts.nav_footer')

@section('title', __('messages.request_status') . ' ' . $complaint->ticket_number)

@section('content')
@section('op', __('messages.request_status'))

<div class="container" style="max-width: 700px; margin-top: 2rem;">
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
            <br><strong>{{ __('messages.ticket_number') }}: {{ $complaint->ticket_number }}</strong>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header text-white" style="background-color: {{ $appSettings->primary_color ?? '#0d6d8e' }}">
            <h5 class="mb-0">{{ __('messages.ticket_number') }}: {{ $complaint->ticket_number }}</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-6"><strong>{{ __('messages.status') }}:</strong>
                    <span class="badge bg-{{ $complaint->status == '2' ? 'success' : ($complaint->status == '3' ? 'warning' : 'danger') }}">
                        {{ $complaint->status_label }}
                    </span>
                </div>
                <div class="col-sm-6"><strong>{{ __('messages.submitted_at') }}:</strong> {{ $complaint->created_at?->format('Y-m-d') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6"><strong>{{ __('messages.department') }}:</strong> {{ $complaint->category?->localized_name }}</div>
                <div class="col-sm-6"><strong>{{ __('messages.category') }}:</strong> {{ $complaint->requestType?->localized_name }}</div>
            </div>
            <div class="mb-3"><strong>{{ __('messages.request_subject') }}:</strong><br>{{ $complaint->content }}</div>

            <div class="alert alert-info">
                {{ __('messages.track_info_message') }}
            </div>

            <a href="{{ route('complaints.track.index') }}" class="btn btn-outline-secondary">{{ __('messages.search_another_request') }}</a>
            <a href="{{ route('complaints.index') }}" class="btn btn-primary" style="background-color: {{ $appSettings->primary_color ?? '#0d6d8e' }}; border: none;">{{ __('messages.home') }}</a>
        </div>
    </div>
</div>
@endsection
