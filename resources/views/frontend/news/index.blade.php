@if(count($news))
    <div class="section-title row text-center mb-4">
        <div class="col-md-8 offset-md-2">
            <h3>{{ trans('custom.hot_news') }}</h3>
        </div>
    </div><!-- end title -->
    <div class="row mb-5">
        @foreach ($news as $value)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="blog-item">
                    {{-- <div class="image-blog">
                        <img src="{{ asset($value->image) }}" alt="" class="img-fluid">
                    </div> --}}
                    <div class="blog-title">
                        <h2>
                            <a
                                href="{{ route('news_detail', ['id' => $value->id]) }}"
                                data-toggle="tooltip"
                                data-placement="bottom"
                                title="{{ $value->TitleLang }}"
                            >
                                {{ $value->TitleLang }}
                            </a>
                        </h2>
                    </div>
                    <div class="blog-desc" style="overflow: hidden;height: 75px;margin-bottom: 20px;">
                        <p>
                            {{ $value->DescriptionStripeString }}
                        </p>
                    </div>
                    <div class="meta-info-blog">
                        <span>
                            {{ trans('custom.created_at') }}:
                            <a href="javascript:void(0)">
                                {{ $value->CreatedAtFormat }}
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
