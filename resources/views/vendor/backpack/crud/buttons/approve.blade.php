<a
    href="javascript:void(0)"
    onclick="checkApproveEntry(this)"
    data-route="{{ url($crud->route.'/approve/'.$entry->getKey()) }}"
    class="btn btn-sm btn-link text-success{{ request()->has('trashed') && request()->trashed ? ' d-none' : '' }}"
    data-button-type="check_approve"
    title="{{ trans('custom.approve') }}"
    data-toggle="tooltip"
    data-placement="bottom"
>
    <i class="las la-check"></i>
</a>

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
	if (typeof checkApproveEntry != 'function') {
        var element = $("[data-button-type=check_approve]");
        element.unbind('click');
        element.tooltip();

        function checkApproveEntry(button) {
            // ask for confirmation before deleting an item
            // e.preventDefault();
            var route = $(button).attr('data-route');

            swal({
                title: "{!! trans('custom.info') !!}",
                text: "{!! trans('custom.are_you_sure_to_approve_this_item') !!}",
                icon: "info",
                buttons: ["{!! trans('backpack::crud.cancel') !!}", "{!! trans('custom.approve') !!}"],
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
                                    text: "{!! '<strong>'.trans('custom.item_approved').'</strong><br>'.trans('custom.item_has_been_approved_successfully') !!}"
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
                                        title: "{!! trans('custom.item_not_approved') !!}",
                                        text: "{!! trans('custom.the_item_may_not_approved') !!}",
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
                                title: "{!! trans('custom.item_not_approved') !!}",
                                text: "{!! trans('custom.the_item_may_not_approved') !!}",
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
