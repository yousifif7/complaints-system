@extends('layouts.mainView')
@section('title', __('messages.departments'))
@section('op', __('messages.add_department'))
@section('active2', 'active')

@section('content')
<div class="container">
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">{{ __('messages.add_department') }}</button>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight">
        <div class="offcanvas-header">
            <h5>{{ __('messages.add_new_department') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                @include('partials.bilingual-fields', [
                    'arName' => 'createdCatName',
                    'enName' => 'createdCatName_en',
                    'arLabel' => __('messages.department_name'),
                    'enLabel' => __('messages.department_name_en'),
                    'arRequired' => true,
                ])
                <button class="btn btn-success w-100" type="submit">{{ __('messages.confirm') }}</button>
            </form>
        </div>
    </div>

    <hr>
    <h3 class="text-center text-success">{{ __('messages.added_departments') }}</h3>
    <table id="datatable" class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ __('messages.department_name') }}</th>
                <th>{{ __('messages.department_name_en') }}</th>
                <th>{{ __('messages.edit') }}</th>
                <th>{{ __('messages.delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->catName }}</td>
                    <td>{{ $item->catName_en ?? '—' }}</td>
                    <td><a class="btn btn-secondary btn-sm" href="{{ route('admin.categories.edit', $item->id) }}">{{ __('messages.edit') }}</a></td>
                    <td>
                        <form action="{{ route('admin.categories.destroy', $item->id) }}" method="POST" data-confirm="{{ __('messages.delete_department_confirm') }}">
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
