@push('before_styles')
    <link rel="stylesheet" href="{{ asset('/vendor/translation/css/main.css') }}">
    <style>
        .panel, .panel-body th {
            color: #495057!important;
        }

        .sidebar li.nav-item {
            padding: 0 !important;
        }

        ul {
            display: block !important;
        }
    </style>
@endpush

@push('after_scripts')
    <script src="{{ asset('/vendor/translation/js/app.js') }}"></script>
@endpush
