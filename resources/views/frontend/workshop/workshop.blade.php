@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.workshop'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.workshop') => '#',
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp
@push('after_styles')
    <style>
        .image-bg{
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            height: 390px;
        }
    </style>
@endpush
@section('content')
    <div id="overviews" class="section wb">
        <div class="container">
            <div class="container">
                <div class="section-title row text-center">
                    <div class="col-md-8 offset-md-2">
                        <h3>{{trans('custom.upcoming_workshop')}}</h3>
                        {{-- <p class="lead">There are no workshop event right now!!!</p> --}}
                    </div>
                </div>

                <div class="row">
                    @foreach ($workShops as $workShop)
                        @if($workShop->UpCommingWorkShop)
                        <div class="col-lg-6 col-md-6 col-12 mb-4">
                            <div class="course-item">
                                {{-- <div class="image-blog">
                                    <img src="{{ asset($workShop->image) }}" alt="" class="img-fluid" style="object-fit: none;">
                                </div> --}}
                                <a href="{{ route('workshop_details', ['id' => $workShop->id]) }}">
                                    <div class="image-blog course-br image-bg" style="
                                        background-image: url('{{ asset($workShop->image) }}');"></div>

                                <div class="course-br">
                                    <div class="course-title">
                                        <h2 style="text-overflow: ellipsis; white-space: nowrap;overflow: hidden;">
                                            {{ $workShop->TitleLang }}
                                        </h2>
                                    </div>
                                    <div class="course-desc" style="overflow: hidden;height: 75px;margin-bottom: 20px;">
                                        <p>{{ $workShop->WorkShopDescriptionLang }}</p>
                                    </div>
                                </a>
                                    @if($workShop->CheckUserAlreadyJoin)
                                        <div class="pricingTable-sign-up">
                                            <a class="hover-btn-new orange"><span>{{trans('custom.joined')}}</span></a>
                                        </div>
                                    @else
                                        @if(backpack_user())
                                            <div class="pricingTable-sign-up">
                                                <a class="hover-btn-new orange" data-toggle="modal" data-target="#modelConfirmUserAlreadyLogin{{$workShop->id}}"><span>{{trans('custom.join')}}</span></a>
                                            </div>
                                        @else
                                            <div class="pricingTable-sign-up">
                                                <a class="hover-btn-new orange" data-toggle="modal" data-target="#loginRegisterWorkShop{{$workShop->id}}"><span>{{trans('custom.join')}}</span></a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="course-meta-bot">
                                    <ul>
                                        <li><i class="fa fa-users" aria-hidden="true"></i> {{ $workShop->CountWorkShopJoiner }} Joiner{{$workShop->CountWorkShopJoiner > 1 ? 's' : ''}}</li>
                                        <li><i class="fa fa-calendar" aria-hidden="true"></i> {{trans('custom.start_date')}} : {{ $workShop->StartDateFormat }}</li>
                                        <li><i class="fa fa-users" aria-hidden="true"></i> {{trans('custom.end_date')}} : {{$workShop->EndDateFormat }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @include('frontend.modal.modal_register_workshop', ['id' => $workShop->id])
                        @include('frontend.modal.join_for_user_login', ['id' => $workShop->id])
                        @endif
                    @endforeach
                </div>

                <div class="section-title row text-center">
                    <div class="col-md-8 offset-md-2 my-4">
                        <h3>{{ trans('custom.workshop_history') }}</h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($workShops as $workShop)
                        @if(!$workShop->UpCommingWorkShop)
                        <div class="col-lg-6 col-md-6 col-12 mb-4">
                            <div class="course-item">
                                {{-- <div class="image-blog">
                                    <img src="{{ asset($workShop->image) }}" alt="" class="img-fluid" style="object-fit: none;">
                                </div> --}}
                                <a href="{{ route('workshop_details', ['id' => $workShop->id]) }}">
                                    <div class="image-blog course-br image-bg" style="
                                        background-image: url('{{ asset($workShop->image) }}');"></div>

                                    <div class="course-br">
                                        <div class="course-title">
                                            <h2 style="text-overflow: ellipsis; white-space: nowrap;overflow: hidden;">
                                                {{-- <a href="{{ route('workshop_details', ['id' => $workShop->id]) }}" title=""> --}}
                                                    {{ $workShop->TitleLang }}
                                                {{-- </a> --}}
                                            </h2>
                                        </div>
                                        <div class="course-desc" style="overflow: hidden;height: 75px;margin-bottom: 20px;">
                                            <p>{{ $workShop->WorkShopDescriptionLang }}</p>
                                        </div>
                                    </div>
                                </a>
                                <div class="course-meta-bot">
                                    <ul>
                                        <li><i class="fa fa-users" aria-hidden="true"></i> {{ $workShop->CountWorkShopJoiner }} Joiner{{$workShop->CountWorkShopJoiner > 1 ? 's' : ''}}</li>
                                        <li><i class="fa fa-calendar" aria-hidden="true"></i> {{trans('custom.start_date')}} : {{ $workShop->StartDateFormat }}</li>
                                        <li><i class="fa fa-users" aria-hidden="true"></i> {{trans('custom.end_date')}} : {{$workShop->EndDateFormat }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- {{dd(Auth::user())}} --}}

{{-- @push('after_scripts')
    <script>

        $( document ).ready(function() {
            // $('.tt').tooltip();
        });
    </script>
@endpush --}}
