@extends('layouts.mainView')
@section('title', __('messages.request_categories'))
@section('op', __('messages.request_categories'))
@section('active3', 'active')

@section('content')
<div class="container">
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">{{ __('messages.add_category') }}</button>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight">
        <div class="offcanvas-header">
            <h5>{{ __('messages.add_new_request_category') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" action="{{ route('admin.requesttypes.store') }}">
                @csrf
                @include('partials.bilingual-fields', [
                    'arName' => 'createdRequest',
                    'enName' => 'createdRequest_en',
                    'arLabel' => __('messages.request_category'),
                    'enLabel' => __('messages.request_category_en'),
                    'arRequired' => true,
                ])
                <div class="mb-3">
                    <label>{{ __('messages.department') }}</label>
                    <select class="form-select" name="formCat" required>
                        <option value="">{{ __('messages.select') }} --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->catName }} @if($cat->catName_en)({{ $cat->catName_en }})@endif</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-success w-100" type="submit">{{ __('messages.confirm') }}</button>
            </form>
        </div>
    </div>

    <hr>
    <h3 class="text-center text-success">{{ __('messages.request_categories_list') }}</h3>
    <table id="datatable" class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('messages.request_category') }}</th>
                <th>{{ __('messages.request_category_en') }}</th>
                <th>{{ __('messages.department') }}</th>
                <th>{{ __('messages.edit') }}</th>
                <th>{{ __('messages.delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requesttypes as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->request_name }}</td>
                    <td>{{ $item->request_name_en ?? '—' }}</td>
                    <td>{{ $item->category?->catName }}</td>
                    <td><a class="btn btn-secondary btn-sm" href="{{ route('admin.requesttypes.edit', $item->id) }}">{{ __('messages.edit') }}</a></td>
                    <td>
                        <form action="{{ route('admin.requesttypes.destroy', $item->id) }}" method="POST" data-confirm="{{ __('messages.delete_request_type_confirm') }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">{{ __('messages.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>$(document).ready(function () { $('#datatable').DataTable(); });</script>
@endsection
