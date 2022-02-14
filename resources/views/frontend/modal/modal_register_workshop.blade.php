<div class="modal fade" id="loginRegisterWorkShop{{$id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header tit-up">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ trans('custom.customer_login') }}</h4>
            </div>
            <div class="modal-body customer-box">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li><a class="{{Session::get('actionAuthFront') != 'register' ? 'active' : ''}}" href="#Login{{$id}}" data-toggle="tab">{{ trans('custom.login') }}</a></li>
                    <li><a class="{{Session::get('actionAuthFront') == 'register' ? 'active' : ''}}" href="#Registration{{$id}}" data-toggle="tab">{{ trans('custom.registration') }}</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane {{Session::get('actionAuthFront') != 'register' ? 'active show' : ''}}" id="Login{{$id}}">
                        <form role="form" class="form-horizontal" aria-label="form" method="POST" action="{{ route('login') }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="workshop_id" value="{{ $id }}">
                            <input type="hidden" name="form_login" value="1">

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="email" class="form-control text-dark @error('email') is-invalid @enderror" placeholder="{{ trans('custom.email') }}" autofocus="" autocomplete="off" value="{{ old('email') }}">

                                    @if ($errors->has('email') && Session::get('actionAuthFront') == 'login')
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input class="form-control text-dark {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ trans('custom.password') }}" type="password" name="password">
                                    @if ($errors->has('password') && Session::get('actionAuthFront') == 'login')
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-light btn-radius btn-brd grd1">
                                        {{ trans('custom.submit') }}
                                    </button>
                                    {{-- <a class="for-pwd" href="javascript:;">Forgot your password?</a> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane {{Session::get('actionAuthFront') == 'register' ? 'active show' : ''}}" id="Registration{{$id}}">
                        <form role="form" class="form-horizontal" aria-label="form" method="POST" action="{{ route('register') }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="workshop_id" value="{{ $id }}">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="first_name" class="form-control text-dark @error('first_name') is-invalid @enderror" placeholder="{{ trans('custom.first_name') }}" autofocus="" autocomplete="off" value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="last_name" class="form-control text-dark @error('last_name') is-invalid @enderror" placeholder="{{ trans('custom.last_name') }}" autocomplete="off" value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="tel" name="phone" class="form-control text-dark @error('phone') is-invalid @enderror" placeholder="{{ trans('custom.phone') }}" autocomplete="off" value="{{ old('phone') }}">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="email" class="form-control text-dark @error('email') is-invalid @enderror" placeholder="{{ trans('custom.email') }}" autofocus="" autocomplete="off" value="{{ old('email') }}">
                                    @if ($errors->has('email') && Session::get('actionAuthFront') == 'register')
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input class="form-control text-dark {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ trans('custom.password') }}" type="password" name="password">
                                    @if ($errors->has('password') && Session::get('actionAuthFront') == 'register')
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="password" name="password_confirmation" class="form-control text-dark @error('password_confirmation') is-invalid @enderror" placeholder="{{ trans('custom.confirm_password') }}" autofocus="" value="{{ old('password_confirmation') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-light btn-radius btn-brd grd1">
                                        {{ trans('custom.save_and_continue') }}
                                    </button>
                                    <button type="button" class="btn btn-light btn-radius btn-brd grd1">
                                        {{ trans('custom.cancel') }}
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

{{-- {{dd(Auth::)}} --}}
