@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.contest'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.contest') => '#',
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
    $user = backpack_user();
@endphp

@section('content')
    <div id="overviews" class="section wb">
        <div class="container">
            <div class="row">
                @forelse ($entries as $entry)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="blog-item">
                            <div class="image-blog">
                                <img src="{{ asset($entry->image) }}" alt="" class="img-fluid">
                            </div>
                            <div class="meta-info-blog">
                                <span>
                                    <i class="fa fa-calendar"></i>
                                    <a href="javascript:void(0)">
                                        {{ $entry->CreatedAtDate->toDateString() }}
                                    </a>
                                </span>
                                <span>
                                    <i class="fa fa-tag"></i>
                                    <a href="javascript:void(0)">
                                        {{ optional($entry->level)->LevelCategory }}
                                    </a>
                                </span>
                            </div>
                            <div class="blog-title">
                                <h2 class="text-truncate">
                                    <a
                                        href="{{ route('contest_detail', ['id' => $entry->id]) }}"
                                        data-toggle="tooltip"
                                        data-placement="bottom"
                                        title="{{ $entry->TitleLang }}"
                                    >
                                        {{ $entry->TitleLang }}
                                    </a>
                                </h2>
                            </div>
                            <div class="blog-desc">
                                <p>
                                    {{ $entry->DescriptionStripeString }}
                                </p>
                            </div>
                            @if ($user && !$user->isBackendRoles())
                                <div class="blog-button">
                                    @if (!in_array($user->id, $entry->registeredContests->pluck('created_by')->toArray()))
                                        <a class="hover-btn-new orange" href="#" data-toggle="modal" data-target="#contest_register_{{ $entry->id }}">
                                            <span>
                                                {{ trans('custom.register') }}
                                            </span>
                                        </a>
                                        <div class="modal fade" id="contest_register_{{ $entry->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header tit-up text-center">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h2 class="modal-title p-0">{{ trans('custom.are_you_sure_to_join_this_contest') }}</h2>
                                                    </div>
                                                    <div class="modal-body customer-box text-center">
                                                        <form role="form" class="form-horizontal" aria-label="form" method="POST" action="{{ backpack_url('registered_contest') }}">
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="http_referrer" value="{{ backpack_url('registered_contest') }}">
                                                            <input type="hidden" name="contest_id" value="{{ $entry->id }}">
                                                            <input type="hidden" name="register_from_frontend" value="1">
                                                            <input type="hidden" name="isBackendRoles" value="1">

                                                            <button type="submit" class="btn btn-light btn-radius btn-brd grd1">{{ trans('custom.yes') }}</button>
                                                            <a class="btn btn-light btn-radius btn-brd grd1" data-dismiss="modal" aria-hidden="true">{{ trans('custom.no') }}</a>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <a class="hover-btn-new orange" href="javascript:void(0)">
                                            <span>
                                                {{ trans('custom.registered') }}
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                            <div class="meta-info-blog">
                                <span>
                                    {{ trans('custom.start_from') }}:
                                    <a href="javascript:void(0)">
                                        {{ $entry->StartAtDate }}
                                    </a>
                                </span>
                                <span>
                                    {{ trans('custom.end_at') }}:
                                    <a href="javascript:void(0)">
                                        {{ $entry->EndAtDate }}
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div><!-- end col -->
                @empty
                    <div class="col-12 text-center">
                        <p>{{ trans('custom.no_contests') }}</p>
                    </div>
                @endforelse
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->
@endsection

@push('after_scripts')
    <script type="text/javascript">
        $(function() {
            $('.blog-title h2 a').tooltip();
        });
    </script>
@endpush
