@extends('frontend.layout.app')

@php
    $requestType = 'General';
    if(request()->general){
        $requestType = 'General';
    }elseif(request()->technical){
        $requestType = 'Technical';
    }elseif(request()->copy_right){
        $requestType = 'Copy Right';
    }

    $defaultBreadcrumbs = [
        'title' => $requestType.' Document',
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.general') => route('document',['general=1']),
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('content')
    <div id="overviews" class="section wb">
        <div class="container">
            <div class="container">
                <div class="row">
                    @foreach ($entry as $document)
                        <div class="col-md-4 col-sm-6 pb-4">
                            <div class="pricingTable">
                                <div class="pricingTable-header pb-3">
                                    <span class="heading">
                                        <h3 style="font-size: 16px">{{$document->NameLang}}</h3>
                                    </span>
                                    <span>{!! $document->DescriptionLang !!}</span>
                                </div>

                                <div class="pricingContent">
                                    <ul>
                                        @foreach($document->MultipleFiles as $file)
                                            <li class="la la-comments-o"><a href="{{ asset($file) }}" target="_blank">{{trans('custom.click_review')}}</a> || <a download="{{ asset($file) }}" href="{{ asset($file) }}" title="ImageName"> {{trans('custom.click_download')}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
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
