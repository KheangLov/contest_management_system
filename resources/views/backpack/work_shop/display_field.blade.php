
<div>
    <h2><strong> {{ $entry->TitleLang }}</strong></h2><br>

    <p><strong>Date Time:</strong> {{ $entry->StartDateFormat }} <strong>To</strong> {{ $entry->EndDateFormat }}</p>

    <p>{!! $entry->DescriptionLang !!}</p>
</div>

