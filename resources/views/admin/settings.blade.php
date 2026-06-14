@extends('layouts.mainView')
@section('title', __('messages.settings'))
@section('op', __('messages.branding_settings'))
@section('active4', 'active')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.organization_name_ar') }}</label>
                        <input type="text" class="form-control" name="organization_name" value="{{ old('organization_name', $settings->organization_name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.organization_name_en') }}</label>
                        <input type="text" class="form-control" name="organization_name_en" value="{{ old('organization_name_en', $settings->organization_name_en) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.primary_color') }}</label>
                        <input type="color" class="form-control form-control-color" name="primary_color" value="{{ old('primary_color', $settings->primary_color) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.website_url') }}</label>
                        <input type="url" class="form-control" name="website_url" value="{{ old('website_url', $settings->website_url) }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.contact_email') }}</label>
                            <input type="email" class="form-control" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.contact_phone') }}</label>
                            <input type="text" class="form-control" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.welcome_message_ar') }}</label>
                        <textarea class="form-control" name="welcome_message" rows="2">{{ old('welcome_message', $settings->welcome_message) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.welcome_message_en') }}</label>
                        <textarea class="form-control" name="welcome_message_en" rows="2">{{ old('welcome_message_en', $settings->welcome_message_en) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.footer_text_ar') }}</label>
                        <input type="text" class="form-control" name="footer_text" value="{{ old('footer_text', $settings->footer_text) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.footer_text_en') }}</label>
                        <input type="text" class="form-control" name="footer_text_en" value="{{ old('footer_text_en', $settings->footer_text_en) }}">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="tracking_enabled" id="tracking" value="1" @checked(old('tracking_enabled', $settings->tracking_enabled))>
                        <label class="form-check-label" for="tracking">{{ __('messages.enable_tracking') }}</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.organization_logo') }}</label>
                            <input type="file" class="form-control" name="logo" accept="image/*">
                            @if($settings->logo_path)
                                <img src="{{ asset('userFiles/' . $settings->logo_path) }}" height="50" class="mt-2">
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.header_image') }}</label>
                            <input type="file" class="form-control" name="header_image" accept="image/*">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
