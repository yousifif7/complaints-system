@extends('layouts.mainView')
@section('title', __('messages.edit_request_category'))
@section('op', __('messages.edit_request_category'))
@section('active3', 'active')

@section('content')
<form class="form container" method="POST" action="{{ route('admin.requesttypes.update', $reqtype->id) }}">
    @csrf @method('PUT')
    <h3 class="text-center text-success">{{ __('messages.edit') }}</h3>
    @include('partials.bilingual-fields', [
        'arName' => 'createdRequest',
        'enName' => 'createdRequest_en',
        'arLabel' => __('messages.request_category'),
        'enLabel' => __('messages.request_category_en'),
        'arValue' => $reqtype->request_name,
        'enValue' => $reqtype->request_name_en,
        'arRequired' => true,
    ])
    <div class="mb-3">
        <label>{{ __('messages.department') }}</label>
        <select class="form-select" name="formCat" required>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected($reqtype->category_id == $cat->id)>{{ $cat->catName }} @if($cat->catName_en)({{ $cat->catName_en }})@endif</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-primary w-100" type="submit">{{ __('messages.confirm') }}</button>
</form>
@endsection
