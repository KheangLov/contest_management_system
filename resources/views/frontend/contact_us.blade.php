@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.contact'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.contact') => '#',
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('content')
    <div id="contact" class="section wb">
        <div class="container">
            <div class="section-title text-center">
                <h3>{!! trans('custom.contact_us_title') !!}</h3>
                <p class="lead">{!! trans('custom.contact_us_description') !!}</p>
            </div><!-- end title -->

            <div class="row">
                <div class="col-xl-6 col-md-12 col-sm-12">
                    <div class="contact_form">
                        <form action="{{ route('send_mail_contact_us') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="row row-fluid">
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <input type="text" name="first_name" class="form-control m-0" placeholder="{{ trans('custom.contact_us_first_name_placeholder') }}">
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <input type="text" name="last_name" class="form-control m-0" placeholder="{{ trans('custom.contact_us_last_name_placeholder') }}">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <input type="email" name="email" class="form-control m-0" placeholder="{{ trans('custom.contact_us_email_placeholder') }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <input type="text" name="phone" class="form-control m-0" placeholder="{{ trans('custom.contact_us_phone_placeholder') }}">
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                                    <textarea class="form-control m-0" name="message" rows="6" placeholder="{{ trans('custom.contact_us_message_placeholder') }}"></textarea>
                                    @if ($errors->has('message'))
                                        <span class="text-danger">
                                            <strong>{{ $errors->first('message') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center pd">
                                    <button type="submit" class="btn btn-light btn-radius btn-brd grd1 btn-block">
                                        {{ trans('custom.contact_us_send_mail_button') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- end col -->
                <div class="col-xl-6 col-md-12 col-sm-12">
                    <div class="map-box h-100">
                        {{-- <div id="custom-places" class="small-map h-100"></div> --}}
                        {!! config('settings.contact_map_iframe') !!}
                    </div>
                    {{-- <input type="hidden" id="latlng_hidden" value="{{ config('settings.contact_us_latlng') }}"> --}}
                </div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->
@endsection

@push('after_scripts')
    {{-- <script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script> --}}
    <!-- Mapsed JavaScript -->
    {{-- <script src="{{ asset('js/mapsed.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/01-custom-places-example.js') }}"></script> --}}
    @if (session()->has('res_obj'))
        @php
            $resObj = session()->get('res_obj');
        @endphp
        <script>
            new Noty({
                type: '{{ $resObj["success"] ? "success" : "error" }}',
                text: '{{ $resObj["message"] }}',
                timeout: 3000,
            }).show();
        </script>
    @endif
@endpush
