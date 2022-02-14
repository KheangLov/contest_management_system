<a
    href="{{ backpack_url('registered_contest/create') }}?contest_id={{ $entry->getKey() }}"
    class="btn btn-sm btn-link text-success{{ request()->has('trashed') && request()->trashed ? ' d-none' : '' }}"
    data-button-type="registered_contest"
    title="{{ trans('custom.register_contest') }}"
    data-toggle="tooltip"
    data-placement="bottom"
    target="_blank"
>
    <i class="las la-file-alt"></i>
</a>

@push('after_scripts') @if (request()->ajax()) @endpush @endif
    <script>
        if (typeof elementRegContest == 'undefined') {
            var elementRegContest = $("[data-button-type=registered_contest]");
            elementRegContest.tooltip();
        }
    </script>
@endpush
