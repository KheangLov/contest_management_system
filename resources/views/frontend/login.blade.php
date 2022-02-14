@extends('frontend.layout.app')

@section('content')
    <form class="form-signin" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="text-center mb-4">
            <h1 class="h3 mb-3 font-weight-normal">Login</h1>
        </div>

        @if(Session::get('fail'))
            <div class="alert alert-danger">
                {{Session::get('fail')}}
            </div>
        @endif
        {{-- {{dd(Auth::user()->id)}} --}}
        <input type="hidden" id="workshop_id" name="workshop_id" value="{{request()->workshop_id}}">
        <div class="form-label-group">
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ trans('custom.email')}}" autofocus="" autocomplete="off" value="{{ old('email') }}">
            <label for="">{{ trans('custom.email')}}</label>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-label-group">
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ trans('custom.password')}}" autofocus="" autocomplete="off" value="{{ old('password') }}">
            <label for="">{{ trans('custom.password')}}</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> {{trans('custom.remember_me')}}
            </label>
        </div>
        
        <div class="row mx-0">
            <button class="btn btn-lg btn-primary btn-block" type="submit">{{ trans('custom.login')}}</button>
        
            <a class="mt-3" href="{{ route('formRegister',['workshop_id' => request()->workshop_id]) }}">
                <label>{{trans('custom.dont_you_have_user')}}</label>
            </a>
        </div>
    </form>
@endsection