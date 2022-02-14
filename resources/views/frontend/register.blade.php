@extends('frontend.layout.app')

@section('content')
    <form class="form-signin" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="text-center mb-4">
            <h1 class="h3 mb-3 font-weight-normal">{{trans('custom.register')}}</h1>
        </div>

        <input type="hidden" id="workshop_id" name="workshop_id" value="{{request()->workshop_id}}">
        <div class="form-label-group">
            <input type="text" id="firstName" name="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="{{trans('custom.first_name')}}" autofocus="" autocomplete="off" value="{{ old('first_name') }}">
            <label for="">{{trans('custom.first_name')}}</label>

            @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-label-group">
            <input type="text" id="lastName" name="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="{{trans('custom.last_name')}}" autofocus="" autocomplete="off" value="{{ old('last_name') }}">
            <label for="">{{trans('custom.last_name')}}</label>
            @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        
        </div>

        <div class="form-label-group">
            <input type="text" id="numberPhone" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="{{trans('custom.number_phone')}}" autofocus="" autocomplete="off" value="{{ old('phone') }}">
            <label for="">{{trans('custom.number_phone')}}</label>
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-label-group">
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{trans('custom.email')}}" autofocus="" autocomplete="off" value="{{ old('email') }}">
            <label for="">{{trans('custom.email')}}</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-label-group">
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{trans('custom.password')}}" autofocus="" autocomplete="off" value="{{ old('password') }}">
            <label for="">{{trans('custom.password')}}</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-label-group">
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{trans('custom.confirm_password')}}" autofocus="" autocomplete="off" value="{{ old('password_confirmation') }}">
            <label for="">{{trans('custom.confirm_password')}}</label>
        </div>


        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> {{trans('custom.remember_me')}}
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">{{trans('custom.sign_in')}}</button>
    </form>
@endsection