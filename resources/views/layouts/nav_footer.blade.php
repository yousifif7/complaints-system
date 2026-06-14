<!DOCTYPE html>
<html lang="{{ $htmlLang }}" dir="{{ $htmlDir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $appSettings->localized_name ?? __('messages.app_name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/style.css?v=20260614">
    <style>
        :root { --primary-color: {{ $appSettings->primary_color ?? '#0d6d8e' }}; }
        * { font-family: 'Cairo', sans-serif; }
        .navbar-brand-area { background-color: var(--primary-color); }
        footer { background-color: var(--primary-color); color: white; }
        body { min-height: 100vh; display: flex; flex-direction: column; }
        .page-content { flex: 1 0 auto; }
        [dir="ltr"] .form-control:not([type="file"]), [dir="ltr"] .form-select, [dir="ltr"] label, [dir="ltr"] .form-text { text-align: left; }
        [dir="rtl"] .form-control:not([type="file"]), [dir="rtl"] label, [dir="rtl"] .form-text { text-align: right; }
    </style>
    @yield('styles')
</head>
<body>

<div class="navbar-header navbar-brand-area">
    <nav class="navbar navbar-dark">
        <span class="text-light">@yield('op')</span>
        <div class="d-flex align-items-center gap-2">
            @include('partials.language-switcher')
            <a class="text-light text-decoration-none" href="{{ route('complaints.index') }}">
                <b>{{ $appSettings->localized_name ?? __('messages.electronic_services') }}</b>
            </a>
        </div>
        @if(!empty($appSettings->logo_path))
            <img src="{{ asset('userFiles/' . $appSettings->logo_path) }}" height="40" alt="logo">
        @endif
    </nav>
</div>

<main class="page-content">
@yield('content')
</main>

<footer class="text-center text-lg-start p-3 mt-auto">
    <div class="text-center">
        <small>
            {{ $appSettings->localized_footer_text ?? __('messages.all_rights_reserved') }}
            @if(!empty($appSettings->website_url))
                | <a href="{{ $appSettings->website_url }}" class="text-white">{{ $appSettings->localized_name }}</a>
            @endif
            &copy; {{ date('Y') }}
        </small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/js/form-select-rtl.js?v=20260614"></script>
@yield('scripts')
</body>
</html>
