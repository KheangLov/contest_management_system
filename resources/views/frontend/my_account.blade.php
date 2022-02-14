@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('backpack::base.my_account'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('backpack::base.my_account') => '#',
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
    $user = backpack_user() ?? Auth::user();
@endphp

@section('content')
    <div class="section wb">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4">
                    <form class="form" action="{{ route('backpack.account.info.store') }}" method="post">

                        {!! csrf_field() !!}
                        <input type="hidden" name="isBackendRoles" value="true" />
                        <div class="card padding-10 customer-box">

                            <div class="card-header">
                                {{ trans('backpack::base.update_account_info') }}
                            </div>

                            <div class="card-body backpack-profile-form bold-labels tab-content">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-4">
                                        @php
                                            $label = trans('custom.first_name');
                                            $field = 'first_name';
                                        @endphp
                                        <input required class="form-control" type="text" placeholder="{{ $label }}" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                                    </div>

                                    <div class="col-md-6 form-group mb-4">
                                        @php
                                            $label = trans('custom.last_name');
                                            $field = 'last_name';
                                        @endphp
                                        <input required class="form-control" type="text" placeholder="{{ $label }}" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                                    </div>

                                    <div class="col-md-12 form-group mb-0">
                                        @php
                                            $label = trans('custom.email');
                                            $field = backpack_authentication_column();
                                        @endphp
                                        <input required class="form-control" type="{{ backpack_authentication_column()=='email'?'email':'text' }}" placeholder="{{ $label }}" name="{{ $field }}" value="{{ old($field) ? old($field) : $user->$field }}">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-light btn-radius btn-brd grd1">
                                    {{ trans('backpack::base.save') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="col-12">
                    <form class="form" action="{{ route('backpack.account.password') }}" method="post">

                        {!! csrf_field() !!}
                        <input type="hidden" name="isBackendRoles" value="true" />
                        <div class="card padding-10 customer-box">

                            <div class="card-header">
                                {{ trans('backpack::base.change_password') }}
                            </div>

                            <div class="card-body backpack-profile-form bold-labels tab-content">
                                <div class="row">
                                    <div class="col-md-4 form-group mb-0">
                                        @php
                                            $label = trans('backpack::base.old_password');
                                            $field = 'old_password';
                                        @endphp
                                        <input autocomplete="new-password" required placeholder="{{ $label }}" class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                                    </div>

                                    <div class="col-md-4 form-group mb-0">
                                        @php
                                            $label = trans('backpack::base.new_password');
                                            $field = 'new_password';
                                        @endphp
                                        <input autocomplete="new-password" required placeholder="{{ $label }}" class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                                    </div>

                                    <div class="col-md-4 form-group mb-0">
                                        @php
                                            $label = trans('backpack::base.confirm_password');
                                            $field = 'confirm_password';
                                        @endphp
                                        <input autocomplete="new-password" required placeholder="{{ $label }}" class="form-control" type="password" name="{{ $field }}" id="{{ $field }}" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-light btn-radius btn-brd grd1"><i class="la la-save"></i> {{ trans('backpack::base.change_password') }}</button>
                            </div>

                        </div>

                    </form>
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->
@endsection

@push('after_scripts')
    @if (session()->has('success') && session()->get('success'))
        <script>
            new Noty({
                type: '{{ session()->get("success") ? "success" : "error" }}',
                text: '{{ session()->get("message") }}',
                timeout: 3000,
            }).show();
        </script>
    @endif
@endpush
