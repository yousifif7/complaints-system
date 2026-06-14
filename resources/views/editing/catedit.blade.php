@extends('layouts.mainView')
@section('title', __('messages.edit_department'))
@section('op', __('messages.edit_department'))
@section('active2', 'active')

@section('content')
<form class="form container" method="POST" action="{{ route('admin.categories.update', $category->id) }}">
    @csrf @method('PUT')
    <h3 class="text-center text-success">{{ __('messages.edit_department') }}</h3>
    @include('partials.bilingual-fields', [
        'arName' => 'createdCatName',
        'enName' => 'createdCatName_en',
        'arLabel' => __('messages.department_name'),
        'enLabel' => __('messages.department_name_en'),
        'arValue' => $category->catName,
        'enValue' => $category->catName_en,
        'arRequired' => true,
    ])
    <button class="btn btn-primary w-100 mt-3" type="submit">{{ __('messages.confirm') }}</button>
</form>
@endsection
