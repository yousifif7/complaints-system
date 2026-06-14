@extends('layouts.mainView')
@section('title', __('messages.requests'))
@section('op', __('messages.citizen_requests'))
@section('active1', 'active')

@section('styles')
<style>
    .content-cell { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    th { color: #333; }
</style>
@endsection

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.forms') }}" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="{{ __('messages.search_placeholder') }}" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">{{ __('messages.all_statuses') }}</option>
                    <option value="1" @selected(request('status') == '1')>{{ __('messages.status_active') }}</option>
                    <option value="2" @selected(request('status') == '2')>{{ __('messages.status_completed') }}</option>
                    <option value="3" @selected(request('status') == '3')>{{ __('messages.status_pending') }}</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">{{ __('messages.all_departments') }}</option>
                    @foreach($category as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->localized_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">{{ __('messages.search') }}</button>
            </div>
        </form>
        <div class="mt-2">
            <a href="{{ route('admin.export', request()->query()) }}" class="btn btn-sm btn-outline-success">{{ __('messages.export_csv') }}</a>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table id="datatable" class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>{{ __('messages.ticket_number') }}</th>
                <th>{{ __('messages.department') }}</th>
                <th>{{ __('messages.category') }}</th>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.phone_number') }}</th>
                <th>{{ __('messages.attachment') }}</th>
                <th>{{ __('messages.date') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($myrequest as $item)
                <tr>
                    <td><strong>{{ $item->ticket_number ?? $item->legacy_reference }}</strong></td>
                    <td>{{ $item->category?->localized_name }}</td>
                    <td>{{ $item->requestType?->localized_name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        @if ($item->file)
                            <a class="btn btn-outline-secondary btn-sm" target="_blank" rel="noopener" href="{{ $item->file_url }}">
                                @if($item->isPdfAttachment())
                                    {{ __('messages.pdf') }}
                                @else
                                    {{ __('messages.view_attachment') }}
                                @endif
                            </a>
                        @endif
                    </td>
                    <td>{{ $item->created_at?->format('Y-m-d H:i') }}</td>
                    <td class="{{ $item->status_css_class }}">
                        {{ $item->status_label }}
                    </td>
                    <td>
                        <a class="btn btn-secondary btn-sm" target="_blank" href="{{ route('form.show', $item->id) }}">{{ __('messages.view') }}</a>
                        @if ($item->status !== \App\Enums\ComplaintStatus::COMPLETED)
                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#update-{{ $item->id }}">{{ __('messages.update') }}</button>
                        @endif
                        <form action="{{ route('admin.forms.destroy', $item->id) }}" method="POST" class="d-inline" data-confirm="{{ __('messages.delete_request_confirm') }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">{{ __('messages.delete') }}</button>
                        </form>
                        <div class="collapse mt-2" id="update-{{ $item->id }}">
                            <form action="{{ route('admin.forms.update', $item->id) }}" method="POST" data-confirm="{{ __('messages.update_status_confirm') }}">
                                @csrf @method('PUT')
                                <select class="form-select form-select-sm mb-1" name="status">
                                    <option value="1" @selected($item->status == '1')>{{ __('messages.status_active') }}</option>
                                    <option value="2" @selected($item->status == '2')>{{ __('messages.status_completed') }}</option>
                                    <option value="3" @selected($item->status == '3')>{{ __('messages.status_pending') }}</option>
                                </select>
                                <select class="form-select form-select-sm mb-1" name="priority">
                                    <option value="low" @selected($item->priority == 'low')>{{ __('messages.priority_low') }}</option>
                                    <option value="medium" @selected($item->priority == 'medium')>{{ __('messages.priority_medium') }}</option>
                                    <option value="high" @selected($item->priority == 'high')>{{ __('messages.priority_high') }}</option>
                                    <option value="urgent" @selected($item->priority == 'urgent')>{{ __('messages.priority_urgent') }}</option>
                                </select>
                                <textarea class="form-control form-control-sm mb-1" name="internal_notes" placeholder="{{ __('messages.internal_note_placeholder') }}"></textarea>
                                <button type="submit" class="btn btn-success btn-sm w-100">{{ __('messages.save') }}</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $myrequest->links() }}</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            paging: false,
            info: false,
            searching: false,
            order: []
        });
    });
</script>
@endsection
