@extends('layouts.nav_footer')

@section('title', __('messages.login'))

@section('content')
<div class="container" style="max-width: 480px; margin-top: 3rem;">
    <div class="card shadow">
        <div class="card-body p-4">
            <h3 class="text-center mb-4" style="color: {{ $appSettings->primary_color ?? '#0d6d8e' }}">{{ __('messages.admin_panel') }}</h3>

            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('loginAdmin') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.email') }}</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.password') }}</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">{{ __('messages.remember_me') }}</label>
                </div>
                <button type="submit" class="btn w-100 text-white" style="background-color: {{ $appSettings->primary_color ?? '#0d6d8e' }}">
                    {{ __('messages.login') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
