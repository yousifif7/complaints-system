@extends('layouts.nav_footer')

@section('styles')
  <style>
    .complaint-form-page { padding-bottom: 2rem; }
  </style>
@endsection

@section('content')
@section('op') {{ $cat->localized_name }} @endsection

@section('title', __('messages.submit_request_for', ['department' => $cat->localized_name]))

<br><hr>
<h2 class="text-center">{{ $cat->localized_name }}</h2>
<hr>

<div class="row justify-content-center complaint-form-page">
    <div class="col-md-8 order-md-1">
        <form class="form" action="{{ route('form.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="category" value="{{ $cat->id }}">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group mb-3">
                <label>{{ __('messages.citizen_name') }}</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.citizen_name_placeholder') }}" required>
            </div>

            <div class="form-group mb-3">
                <label>{{ __('messages.mobile_phone') }}</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="{{ __('messages.phone_placeholder') }}" required>
                <small class="form-text text-muted">{{ __('messages.phone_track_hint') }}</small>
            </div>

            <div class="form-group mb-3">
                <label>{{ __('messages.address') }}</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" placeholder="{{ __('messages.address_placeholder') }}" required>
            </div>

            <div class="form-group mb-3">
                <label>{{ __('messages.choose_request_category') }}</label>
                <select class="form-select @error('formtype') is-invalid @enderror" name="formtype" required>
                    <option value="">{{ __('messages.select') }} --</option>
                    @foreach ($reqtypes as $type)
                        <option value="{{ $type->id }}" @selected(old('formtype') == $type->id)>{{ $type->localized_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>{{ __('messages.request_content') }}</label>
                <textarea class="form-control @error('content') is-invalid @enderror" rows="4" name="content" required>{{ old('content') }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label>{{ __('messages.attach_file') }}</label>
                <input type="file" class="form-control" name="userfile" accept=".png,.jpg,.jpeg,.pdf">
            </div>

            <button class="button btn-center w-100" type="submit" style="background-color: {{ $appSettings->primary_color ?? '#0d6d8e' }}; color: white; border: none; padding: 10px;">
                {{ __('messages.confirm') }}
            </button>
        </form>
    </div>
</div>
<br><br>
@endsection
