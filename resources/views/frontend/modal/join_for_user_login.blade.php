<div class="modal fade" id="modelConfirmUserAlreadyLogin{{$id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header tit-up text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title p-0">Are sure to join this workshop?</h2>
            </div>
            <div class="modal-body customer-box text-center">
                <div class="row">
                    <div class="col-sm-12">
                        <form role="form" class="form-horizontal" aria-label="form" method="POST" action="{{ route('workshop.joiner') }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="workshop_id" value="{{ $id }}">

                            <button type="submit" class="btn btn-light btn-radius btn-brd grd1">Yes</button>
                            <a class="btn btn-light btn-radius btn-brd grd1" data-dismiss="modal" aria-hidden="true">No</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- {{dd(Auth::)}} --}}