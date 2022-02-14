@if ($crud->hasAccess('clone'))
	<a
        href="javascript:void(0)"
        onclick="cloneEntry(this)"
        data-route="{{ url($crud->route.'/'.$entry->getKey().'/clone') }}"
        class="btn btn-sm btn-link"
        data-button-type="clone"
        title="{{ trans('backpack::crud.clone') }}"
        data-toggle="tooltip"
        data-placement="bottom"
    >
        <i class="la la-copy"></i>
    </a>
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
	if (typeof cloneEntry != 'function') {
      var element = $("[data-button-type=clone]");
      element.unbind('click');
      element.tooltip();


	  function cloneEntry(button) {
	      // ask for confirmation before deleting an item
	      // e.preventDefault();
	      var button = $(button);
	      var route = button.attr('data-route');

          $.ajax({
              url: route,
              type: 'POST',
              success: function(result) {
                  // Show an alert with the result
                  new Noty({
                    type: "success",
                    text: "{!! trans('backpack::crud.clone_success') !!}"
                  }).show();

                  // Hide the modal, if any
                  $('.modal').modal('hide');

                  if (typeof crud !== 'undefined') {
                    crud.table.draw(false);
                  }
              },
              error: function(result) {
                  // Show an alert with the result
                  new Noty({
                    type: "warning",
                    text: "{!! trans('backpack::crud.clone_failure') !!}"
                  }).show();
              }
          });
      }
	}

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue('cloneEntry');
</script>
@if (!request()->ajax()) @endpush @endif