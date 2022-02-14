@push('after_styles')
    <link rel="stylesheet" href="{{ asset('fancybox/jquery.fancybox.min.css') }}" />
    <style>
        .carousel-inner .carousel-item img {
            display: block;
            width: 100%;
        }
        .object-fit-contain {
            -o-object-fit: contain;
            object-fit: contain;
            width: 100%;
        }
        .gallery-item {
            background-size: cover;
            background-position: 50%;
            background-repeat: no-repeat;
            background-color: #333;
            height: 430px !important;
        }

        /* // Extra small devices (portrait phones, less than 576px) */
        @media (max-width: 575px) {
            .gallery-item {
                height: 220px !important;
            }
         }

        /* // Small devices (landscape phones, 576px and up)  322*/
        @media (min-width: 576px) and (max-width: 767px) {
            .gallery-item {
                height: 322px !important;
            }
         }

        /* // Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) and (max-width: 991px) {
            .gallery-item {
                height: 290px !important;
            }
         }

        /* // Large devices (desktops, 992px and up) */
        @media (min-width: 992px) and (max-width: 1199px) {
            .gallery-item {
                height: 300px !important;
            }
         }
         .fancybox-thumbs {
            top: auto;
            width: auto;
            bottom: 0;
            left: 0;
            right : 0;
            height: 95px;
            padding: 10px 10px 5px 10px;
            box-sizing: border-box;
            background: rgba(0, 0, 0, 0.3);
        }
        .fancybox-show-thumbs .fancybox-inner {
            right: 0;
            bottom: 95px;
        }
        .fancybox-thumbs {
            top: auto;
            width: auto;
            bottom: 0;
            left: 0;
            right : 0;
            height: 95px;
            padding: 10px 10px 5px 10px;
            box-sizing: border-box;
            background: rgba(0, 0, 0, 0.3);
        }
        .fancybox-show-thumbs .fancybox-inner {
            right: 0;
            bottom: 95px;
        }
    </style>
@endpush
<div class="slider-preview-content mt-3">
    <div id="myCarousel" class="carousel slide text-center">
        <div class="carousel-inner">
            @if ($entry->MergeImageGallery)
                @foreach ($entry->MergeImageGallery as $key => $image)
                    <div class="carousel-item {{ $key == 0 ? ' active' : '' }}" data-slide-number="{{ $key }}">
                        <a href="{{ $image }}" data-fancybox="slider-{{ $entry->id }}">
                            <img src="{{ $image }}" class="img-fluid gallery-item object-fit-contain">
                        </a>
                    </div>
                @endforeach
            @endif
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <ul class="carousel-indicators list-inline mx-auto px-2">
            @if ($entry->MergeImageGallery)
                @foreach ($entry->MergeImageGallery as $key => $image)
                    <li class="list-inline-item {{ $key == 0 ? ' active' : '' }}">
                        <a id="carousel-selector-0" class="{{ $key == 0 ? ' selected' : '' }}" data-slide-to="{{ $key }}" data-target="#myCarousel">
                            <img src="{{ $image }}" height="50">
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
@push('after_scripts')
    <script src="{{ asset('fancybox/jquery.fancybox.min.js') }}"></script>
    <script>
        $(function () {
            $('[data-fancybox]').fancybox({
                animationEffect : 'fade',
                thumbs : {
                    autoStart : true,
                    hideOnClose : true,
                    axis: 'x'
                },
            });
        })
    </script>
@endpush