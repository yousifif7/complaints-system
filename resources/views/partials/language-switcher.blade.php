<div class="language-switcher btn-group btn-group-sm" role="group" aria-label="{{ __('messages.language') }}">
    <a href="{{ route('language.switch', 'ar') }}"
       class="btn {{ app()->getLocale() === 'ar' ? 'btn-light' : 'btn-outline-light' }}">
        {{ __('messages.arabic') }}
    </a>
    <a href="{{ route('language.switch', 'en') }}"
       class="btn {{ app()->getLocale() === 'en' ? 'btn-light' : 'btn-outline-light' }}">
        {{ __('messages.english') }}
    </a>
</div>
