<div class="all-title-box">
    <div class="container text-center">
        <h1>{{ $breadcrumbs['title'] ?? ''}}</h1>
        @if (isset($breadcrumbs['items']))
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent justify-content-center py-0">
                    @foreach ($breadcrumbs['items'] as $text => $link)
                        <li class="breadcrumb-item{{ $loop->last ? ' active' : '' }}">
                            <a href="{{ $link }}" class="{{ !$loop->last ? 'text-white breadcrumb-custom-dec' : 'text-muted' }} breadcrumb-custom">
                                {{ $text }}
                            </a>
                        </li>
                    @endforeach
                </ol>
            </nav>
        @endif
    </div>
</div>
