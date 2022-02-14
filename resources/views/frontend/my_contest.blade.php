@extends('frontend.layout.app')

@php
    $defaultBreadcrumbs = [
        'title' => trans('custom.my_contests'),
        'items' => [
            trans('custom.home') => route('homepage'),
            trans('custom.my_contests') => '#',
        ]
    ];
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('content')
    <div class="section wb">
        <div class="container">
            <div class="row">
                @forelse ($entries as $et)
                    @php
                        $entry = optional($et->contest);
                    @endphp
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="blog-item">
                            <div class="image-blog">
                                <img src="{{ asset($entry->image) }}" alt="{{ $entry->image }}" class="img-fluid">
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
                            <div class="blog-button">
                                @php
                                    $now = Carbon\Carbon::now()->toDateTimeString();
                                @endphp
                                @if ($et->start_date || $entry->end_at < $now)
                                    {{-- <a class="hover-btn-new orange" href="javascript:void(0)">
                                        <span>
                                            {{ trans('custom.started') }}
                                        </span>
                                    </a> --}}
                                    <a class="hover-btn-new orange" href="{{ route("view_contest_stat", ["regContestId" => $et->id]) }}">
                                        <span>
                                            {{ trans('custom.view_stat') }}
                                        </span>
                                    </a>
                                @else
                                    <a class="hover-btn-new orange" href="#" data-toggle="modal" data-target="#contest_register_{{ $et->id }}">
                                        <span>
                                            {{ trans('custom.start') }}
                                        </span>
                                    </a>
                                    <div class="modal fade" id="contest_register_{{ $et->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header tit-up text-center">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h2 class="modal-title p-0 d-block">
                                                        {{ trans('custom.are_you_sure_want_to_start_the_contest_now') }}
                                                    </h2>
                                                </div>
                                                <div class="modal-body customer-box text-center">
                                                    <small class="text-danger d-block">
                                                        <b>{{ trans('custom.once_started_can_not_pause') }}</b>
                                                    </small>
                                                    <form role="form" class="form-horizontal" aria-label="form" method="POST" action="{{ route('my_contest_start', ['id' => $et->id]) }}">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="_method" value="PUT">
                                                        <input type="hidden" name="registered_contest_id" value="{{ $et->id }}">
                                                        <input type="hidden" name="contest_id" value="{{ $entry->id }}">

                                                        <button type="submit" class="btn btn-light btn-radius btn-brd grd1">
                                                            {{ trans('custom.yes') }}
                                                        </button>
                                                        <a class="btn btn-light btn-radius btn-brd grd1" data-dismiss="modal" aria-hidden="true">
                                                            {{ trans('custom.no') }}
                                                        </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="meta-info-blog">
                                <span>
                                    {{trans('custom.start_from')}}:
                                    <a href="javascript:void(0)">
                                        {{ $entry->StartAtDate }}
                                    </a>
                                </span>
                                <span>
                                    {{trans('custom.end_at')}}:
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
    <script>
        localStorage.setItem('data_questions', '');
        localStorage.setItem('active_question', '');
        @if (Session::get('success_token_login'))
            new Noty({
                type: "success",
                text: "{{ Session::get('success_token_login') }}",
                timeout: 3000,
            }).show();
        @endif
    </script>
@endpush
