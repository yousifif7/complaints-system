<!DOCTYPE html>
<html lang="{{ $htmlLang }}" dir="{{ $htmlDir }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.admin_dashboard'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/style.css?v=20260614">
    <style>
        :root { --primary-color: {{ $appSettings->primary_color ?? '#0d6d8e' }}; }
        * { font-family: 'Cairo', sans-serif; }
        .admin-nav { background: #f8f9fa; border-bottom: 2px solid var(--primary-color); }
        .admin-nav .nav-link.active { color: var(--primary-color) !important; font-weight: 700; }
        .stat-card { border-inline-start: 4px solid var(--primary-color); }
        [dir="ltr"] .form-control, [dir="ltr"] label { text-align: left; }
        [dir="rtl"] .form-control, [dir="rtl"] label { text-align: right; }
    </style>
    @yield('styles')
</head>
<body>

<nav class="navbar navbar-dark" style="background-color: var(--primary-color);">
    <span class="navbar-brand">@yield('op', __('messages.admin_panel')) — {{ $appSettings->localized_name ?? __('messages.app_name') }}</span>
    <div class="d-flex align-items-center gap-2">
        @include('partials.language-switcher')
        <a href="{{ route('complaints.index') }}" class="btn btn-sm btn-outline-light" target="_blank">{{ __('messages.public_site') }}</a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-light">{{ __('messages.logout') }}</button>
        </form>
    </div>
</nav>

<ul class="nav admin-nav justify-content-center py-2">
    <li class="nav-item"><a class="nav-link @yield('active_dashboard')" href="{{ route('admin.dashboard') }}">{{ __('messages.admin_dashboard') }}</a></li>
    <li class="nav-item"><a class="nav-link @yield('active1')" href="{{ route('admin.forms') }}">{{ __('messages.requests') }}</a></li>
    <li class="nav-item"><a class="nav-link @yield('active2')" href="{{ route('admin.categories.create') }}">{{ __('messages.departments') }}</a></li>
    <li class="nav-item"><a class="nav-link @yield('active3')" href="{{ route('admin.requesttypes.create') }}">{{ __('messages.request_categories') }}</a></li>
    <li class="nav-item"><a class="nav-link @yield('active4')" href="{{ route('admin.settings') }}">{{ __('messages.settings') }}</a></li>
</ul>

<div class="container-fluid py-3">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script>
    window.autoTranslateConfig = {
        url: @json(route('admin.translate')),
        enabled: @json(config('complaints.auto_translate_enabled', true)),
    };
</script>
<script src="/js/auto-translate.js"></script>
<script src="/js/confirm-actions.js"></script>
<script src="/js/form-select-rtl.js?v=20260614"></script>
@yield('scripts')
</body>
</html>
