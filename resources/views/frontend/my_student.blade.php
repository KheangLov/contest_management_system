@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.my_students'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.my_students') => '#',
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('content')
    <div class="section wb">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="blog-button">
                        <a class="hover-btn-new orange" href="#" data-toggle="modal" data-target="#create_student">
                            <span>{{ trans('custom.create_student') }}</span>
                        </a>
                    </div>
                    <div class="modal fade" id="create_student" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header tit-up">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">{{ trans('custom.create_student') }}</h4>
                                </div>
                                <div class="modal-body customer-box">
                                    <div class="tab-content">
                                        <form role="form" class="form-horizontal" aria-label="form" method="POST" action="{{ route('create_student') }}">
                                            {!! csrf_field() !!}
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="text" name="first_name" class="form-control text-dark @error('first_name') is-invalid @enderror" placeholder="{{ trans('custom.first_name') }}" autofocus="" autocomplete="off" value="{{ old('first_name') }}">
                                                    @error('first_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('first_name')  }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="text" name="last_name" class="form-control text-dark @error('last_name') is-invalid @enderror" placeholder="{{ trans('custom.last_name') }}" autocomplete="off" value="{{ old('last_name') }}">
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('last_name') }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="date" name="dob" class="form-control text-dark @error('dob') is-invalid @enderror" placeholder="{{ trans('custom.date_of_birth') }}" autocomplete="off" value="{{ old('dob') }}">
                                                    @error('dob')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('dob') }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="tel" name="phone" class="form-control text-dark @error('phone') is-invalid @enderror" placeholder="{{ trans('custom.phone') }}" autocomplete="off" value="{{ old('phone') }}">
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('phone') }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="email" name="email" class="form-control text-dark @error('email') is-invalid @enderror" placeholder="{{ trans('custom.email') }}" autofocus="" autocomplete="off" value="{{ old('email') }}">
                                                    @if ($errors->has('email') && Session::get('frontend_login_popup') === 'register')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="text" name="school" class="form-control text-dark @error('school') is-invalid @enderror" placeholder="{{ trans('custom.school') }}" autocomplete="off" value="{{ old('school') }}">
                                                    @error('school')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('school') }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <input type="text" name="address" class="form-control text-dark @error('address') is-invalid @enderror" placeholder="{{ trans('custom.address') }}" autocomplete="off" value="{{ old('address') }}">
                                                    @error('address')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('address') }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-10">
                                                    <button type="submit" class="btn btn-light btn-radius btn-brd grd1">
                                                        {{ trans('custom.save_and_continue') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @forelse ($entries as $entry)
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="our-team">
                            <div class="team-img">
                                <img src="{{ asset($entry->ProfileOrDefault) }}" alt="{{ $entry->ProfileOrDefault }}">
                                <div class="social">
                                    <ul>
                                        <li>
                                            <a href="{{ route('my_student_detail', ['id' => $entry->id]) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="team-content px-3 m-0">
                                <h3 class="title" style="max-height: 45px;">{{ $entry->FullName }}</h3>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>{{ trans('custom.no_students') }}</p>
                    </div>
                @endforelse
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->
@endsection

@push('after_scripts')
    @if (old())
        <script>
            $(function() {
                $('#create_student').modal('show');
            });
        </script>
    @endif
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
