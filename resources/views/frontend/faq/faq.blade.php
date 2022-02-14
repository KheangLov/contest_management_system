@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.faq'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.faq') => route('faq')
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('content')
<div id="overviews" class="section wb">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 blog-post-single">
                <div class="blog-comments mt-0">
                    <h4>{{trans('custom.frequently_asked_questions')}}</h4>
                    <div id="comment-blog">
                        <ul class="comment-list">
                            @if($entry)
                                @foreach ($entry as $faqs)
                                    <li class="comment">
                                        <div class="avatar"><img alt="" src="images/person-icon.png" class="avatar"></div>
                                        <div class="comment-container px-0 pb-0">
                                            {{-- <h5 class="comment-author"><a href="#">John Smith</a></h5> --}}
                                            <div class="comment-meta">
                                                <a href="#" class="comment-date link-style1">{{ $faqs->CreatedAtFormat }}</a>
                                                {{-- <a class="comment-reply-link link-style3" href="#respond">Reply »</a> --}}
                                            </div>
                                            <div class="comment-body">
                                                <p>{!! $faqs->description !!}</p>
                                            </div>
                                        </div>
                                        @if($faqs->FaqByParentId)
                                            @foreach ($faqs->FaqByParentId as $faq)
                                                <ul class="children">
                                                    <li class="comment">
                                                        <div class="avatar"><img alt="" src="images/person-icon.png" class="avatar"></div>
                                                        <div class="comment-container px-0 pb-0">
                                                            {{-- <h5 class="comment-author"><a href="#">Thomas Smith</a></h5> --}}
                                                            <div class="comment-meta">
                                                                <a href="#" class="comment-date link-style1">{{ $faq->CreatedAtFormat }}</a>
                                                                {{-- <a class="comment-reply-link link-style3" href="#respond">Reply »</a> --}}
                                                            </div>
                                                            <div class="comment-body">
                                                                <p>{!! $faq->description !!}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            @endforeach
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 blog-post-single">
                <div class="comments-form">
                    <h4>{{trans('custom.leave_your_question')}}</h4>
                    <div class="comment-form-main">
                        <form  method="GET" action="{{ route('faq_question') }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control border" name="question_message" placeholder="{{trans('custom.message')}}" id="question_message" cols="30" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 post-btn">
                                    <button type="submit" class="hover-btn-new orange"><span>{{trans('custom.post_question')}}</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

