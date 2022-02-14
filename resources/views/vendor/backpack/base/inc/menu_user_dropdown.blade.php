@php
    $authUser = backpack_auth()->user();
@endphp
<li class="nav-item dropdown pr-4">
  <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
    <img class="img-avatar" src="{{ $authUser->profile ? asset($authUser->profile) : backpack_avatar_url($authUser) }}" alt="{{ $authUser->FullName }}">
  </a>
  <div class="dropdown-menu {{ config('backpack.base.html_direction') == 'rtl' ? 'dropdown-menu-left' : 'dropdown-menu-right' }} mr-4 pb-1 pt-1">
    <a class="dropdown-item" href="{{ route('backpack.account.info') }}"><i class="la la-user"></i> {{ trans('backpack::base.my_account') }} ({{ $authUser->FullName }})</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ backpack_url('logout') }}"><i class="la la-lock"></i> {{ trans('backpack::base.logout') }}</a>
  </div>
</li>
