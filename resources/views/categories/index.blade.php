@extends('layouts.nav_footer')

@section('title')
{{ $appSettings->localized_name }} | {{ __('messages.electronic_services') }}
@endsection

@section('styles')
  <style>
    .category-card {
      background-color: rgba(201, 201, 201, 0.486);
      transition: transform 0.2s;
    }
    .category-card:hover {
      transform: translateY(-3px);
    }
  </style>
@endsection

@section('content')
@section('op') {{ __('messages.complaints_suggestions') }} @endsection

<div class="intro w-100">
    <h5 class="intro-text">{{ $appSettings->localized_welcome_message }}</h5>
</div>
<br>

@if (session('success'))
    <div class="alert alert-success text-center" role="alert">
        {{ session('success') }}
        @if (session('ticket_number'))
            <br><strong>{{ __('messages.ticket_number') }}: {{ session('ticket_number') }}</strong>
            <br><a href="{{ route('complaints.track.show', session('ticket_number')) }}" class="alert-link">{{ __('messages.track_request_link') }}</a>
        @endif
    </div>
@endif

<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-secondary mb-0">{{ __('messages.choose_department') }}</h3>
        @if(($appSettings->tracking_enabled ?? true))
            <a href="{{ route('complaints.track.index') }}" class="btn btn-outline-light" style="background-color: {{ $appSettings->primary_color ?? '#0d6d8e' }}">
                {{ __('messages.track_previous_request') }}
            </a>
        @endif
    </div>
    <hr class="dropdown-divider">

    <div class="row justify-content-center m-1">
        @forelse ($categories as $item)
            <div class="col-12 col-lg-3 col-md-4 col-sm-12 m-1">
                <div class="card category-card">
                    <div class="card-body text-center">
                        <p class="fw-bold">{{ $item->localized_name }}</p>
                        <a class="btn" href="{{ route('category.cat', $item->id) }}" style="background-color: #b8ceca;">{{ __('messages.submit_request') }}</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">{{ __('messages.no_departments') }}</div>
            </div>
        @endforelse
    </div>
</div>
<br><br>
@endsection
