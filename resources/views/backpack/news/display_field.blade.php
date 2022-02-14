<div>
    <h2><strong> {{ $entry->TitleLang }}</strong></h2><br>

    <div class="row">
        <div class="col-6">
            <span>{{trans('custom.created_by')}}:</span> {{ optional($entry->user)->FullName.' '.$entry->CreatedAtFormat }}
        </div>
        <div class="col-6">
            <span>{{trans('custom.updated_by')}}:</span> {{ optional($entry->user)->FullName.' '.$entry->CreatedAtFormat }}
        </div>
    </div>

    <p>{!! $entry->DescriptionLang !!}</p>
</div>