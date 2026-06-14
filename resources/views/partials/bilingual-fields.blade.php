@php
    $arValue = $arValue ?? '';
    $enValue = $enValue ?? '';
    $arRequired = $arRequired ?? false;
@endphp

<div data-bilingual-group>
    <div class="mb-3">
        <label class="form-label">{{ $arLabel }}</label>
        <input
            type="text"
            class="form-control"
            name="{{ $arName }}"
            data-lang="ar"
            value="{{ old($arName, $arValue) }}"
            @if($arRequired) required @endif
        >
    </div>
    <div class="mb-3">
        <label class="form-label">{{ $enLabel }}</label>
        <input
            type="text"
            class="form-control"
            name="{{ $enName }}"
            data-lang="en"
            value="{{ old($enName, $enValue) }}"
        >
        <small class="text-muted">{{ __('messages.auto_translate_hint') }}</small>
    </div>
</div>
