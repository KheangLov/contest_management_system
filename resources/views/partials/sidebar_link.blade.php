@php
    $isRoleOrPermissionOrNone = true;
    if (isset($roles) && $roles) {
        if (isset($rolePermissionDefaul) && $rolePermissionDefaul) {
            $isRoleOrPermissionOrNone = backpack_user()->hasAnyRole($roles);
        } else {
            $isRoleOrPermissionOrNone = backpack_user()->{$roles}();
        }

    }

    if (!isset($roles) && isset($permission) && $permission) {
        if (isset($rolePermissionDefaul) && $rolePermissionDefaul) {
            $isRoleOrPermissionOrNone = backpack_user()->can($permission);
        } else {
            $isRoleOrPermissionOrNone = backpack_user()->{$permission}();
        }
    }
@endphp

@if($isRoleOrPermissionOrNone)
    @if(!isset($nolink)) <li class="nav-item"> @endif
        <a
            href="{!! isset($nolink) ? '#' : $entry[0] !!}"
            class="nav-link {{ !isset($nolink) ? '' : 'nav-dropdown-toggle'  }} text-truncate"
            data-toggle="tooltip"
            data-placement="bottom"
            title="{!! $entry[1] !!}"
        >
            <i class="nav-icon {!! isset($entry[2]) && $entry[2] ? $entry[2] : 'la la-angle-right' !!}"></i>

            @if(!isset($nolink)) <span> @endif
                {!! $entry[1] !!}
            @if(!isset($nolink)) </span> @endif
        </a>
    @if(!isset($nolink)) </li> @endif
@endif
