<a
    href="javascript:void(0)"
    onclick="checkRejectEntry(this)"
    data-route="{{ url($crud->route.'/reject/'.$entry->getKey()) }}"
    class="btn btn-sm btn-link text-danger{{ request()->has('trashed') && request()->trashed ? ' d-none' : '' }}"
    data-button-type="check_reject"
    title="{{ trans('custom.reject') }}"
    data-toggle="tooltip"
    data-placement="bottom"
>
    <i class="las la-undo"></i>
</a>

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
	if (typeof checkRejectEntry != 'function') {
        var element = $("[data-button-type=check_reject]");
        element.unbind('click');
        element.tooltip();

        function checkRejectEntry(button) {
            // ask for confirmation before deleting an item
            // e.preventDefault();
            var route = $(button).attr('data-route');

            swal({
                title: "{!! trans('custom.warning') !!}",
                text: "{!! trans('custom.are_you_sure_to_reject_this_item') !!}",
                icon: "warning",
                buttons: ["{!! trans('backpack::crud.cancel') !!}", "{!! trans('custom.reject') !!}"],
                dangerMode: true
            }).then((value) => {
                if (value) {
                    $.ajax({
                        url: route,
                        type: 'POST',
                        success: function(result) {
                            if (result == 1) {
                                // Redraw the table
                                if (typeof crud != 'undefined' && typeof crud.table != 'undefined') {
                                    // Move to previous page in case of deleting the only item in table
                                    if(crud.table.rows().count() === 1) {
                                        crud.table.page("previous");
                                    }

                                    crud.table.draw(false);
                                }

                                // Show a success notification bubble
                                new Noty({
                                    type: "success",
                                    text: "{!! '<strong>'.trans('custom.item_rejected').'</strong><br>'.trans('custom.item_has_been_rejected_successfully') !!}"
                                }).show();

                                // Hide the modal, if any
                                $('.modal').modal('hide');
                            } else {
                                // if the result is an array, it means
                                // we have notification bubbles to show
                                if (result instanceof Object) {
                                    // trigger one or more bubble notifications
                                    Object.entries(result).forEach(function(entry, index) {
                                    var type = entry[0];
                                    entry[1].forEach(function(message, i) {
                                        new Noty({
                                            type: type,
                                            text: message
                                        }).show();
                                    });
                                    });
                                } else {// Show an error alert
                                    swal({
                                        title: "{!! trans('custom.item_not_rejected') !!}",
                                        text: "{!! trans('custom.the_item_may_not_rejected') !!}",
                                        icon: "error",
                                        timer: 4000,
                                        buttons: false,
                                    });
                                }
                            }
                        },
                        error: function(result) {
                            // Show an alert with the result
                            swal({
                                title: "{!! trans('custom.item_not_rejected') !!}",
                                text: "{!! trans('custom.the_item_may_not_rejected') !!}",
                                icon: "error",
                                timer: 4000,
                                buttons: false,
                            });
                        }
                    });
                }
            });
        }
	}

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue('deleteEntry');
</script>
@if (!request()->ajax()) @endpush @endif
