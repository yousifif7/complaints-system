@extends('layouts.mainView')
@section('title', __('messages.admin_dashboard'))
@section('op', __('messages.admin_dashboard'))
@section('active_dashboard', 'active')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card stat-card p-3"><h6>{{ __('messages.total_requests') }}</h6><h2>{{ $stats['total'] }}</h2></div></div>
    <div class="col-md-3"><div class="card stat-card p-3"><h6>{{ __('messages.status_active') }}</h6><h2 class="text-danger">{{ $stats['active'] }}</h2></div></div>
    <div class="col-md-3"><div class="card stat-card p-3"><h6>{{ __('messages.status_pending') }}</h6><h2 class="text-warning">{{ $stats['pending'] }}</h2></div></div>
    <div class="col-md-3"><div class="card stat-card p-3"><h6>{{ __('messages.status_completed') }}</h6><h2 class="text-success">{{ $stats['completed'] }}</h2></div></div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card p-3"><h6>{{ __('messages.today_requests') }}</h6><h3>{{ $stats['today'] }}</h3></div></div>
    <div class="col-md-4"><div class="card p-3"><h6>{{ __('messages.week_requests') }}</h6><h3>{{ $stats['this_week'] }}</h3></div></div>
    <div class="col-md-4"><div class="card p-3"><h6>{{ __('messages.departments_count') }}</h6><h3>{{ $categoriesCount }}</h3></div></div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>{{ __('messages.recent_requests') }}</span>
                <a href="{{ route('admin.forms') }}">{{ __('messages.view_all') }}</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>{{ __('messages.number') }}</th><th>{{ __('messages.name') }}</th><th>{{ __('messages.department') }}</th><th>{{ __('messages.status') }}</th></tr></thead>
                    <tbody>
                        @foreach($recent as $item)
                            <tr>
                                <td>{{ $item->ticket_number }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->category?->localized_name }}</td>
                                <td>{{ $item->status_label }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">{{ __('messages.requests_by_department') }}</div>
            <ul class="list-group list-group-flush">
                @forelse($byCategory as $row)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $row->category?->localized_name ?? __('messages.undefined') }}</span>
                        <span class="badge bg-primary">{{ $row->total }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">{{ __('messages.no_data') }}</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
