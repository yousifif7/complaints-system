@extends('layouts.nav_footer')

@section('title', __('messages.track_request_status'))

@section('content')
@section('op', __('messages.track_request_status'))

<div class="container" style="max-width: 520px; margin-top: 2rem;">
    <div class="card shadow">
        <div class="card-body p-4">
            <h4 class="text-center mb-4">{{ __('messages.track_request_heading') }}</h4>
            <p class="text-muted text-center">{{ __('messages.track_request_hint') }}</p>

            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('complaints.track.lookup') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.ticket_number') }}</label>
                    <input type="text" class="form-control" name="ticket_number" value="{{ old('ticket_number') }}" placeholder="{{ __('messages.ticket_number_example') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.phone_number') }}</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                </div>
                <button type="submit" class="btn w-100 text-white" style="background-color: {{ $appSettings->primary_color ?? '#0d6d8e' }}">{{ __('messages.search') }}</button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('complaints.index') }}">{{ __('messages.back_to_home') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
