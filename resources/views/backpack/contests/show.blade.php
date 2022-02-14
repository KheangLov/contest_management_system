@extends(backpack_view('layouts.top_left'))

@section('header')
    <section class="container-fluid d-print-none">
        <div class="float-right">
            @if ($crud->buttons()->where('stack', 'line')->count())
                @include('crud::inc.button_stack', ['stack' => 'line'])
            @endif
            <a href="javascript: window.print();" class="btn btn-sm btn-link">
                <i class="la la-print"></i>
            </a>
        </div>
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
            @if ($crud->hasAccess('list'))
            <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><em class="la la-angle-double-left"></em> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <span><b>@lang('custom.title'):</b></span>
                        </div>
                        <div class="col-sm-8">
                            <span>{!! $entry->TitleLang !!}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <span><b>@lang('custom.description'):</b></span>
                        </div>
                        <div class="col-sm-8">
                            <span>{!! $entry->DescriptionLang !!}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            @forelse ($entry->questions as $question)
                                <ul class="list-group mb-3 rounded-0 border-0 shadow-sm">
                                    <li class="list-group-item bg-secondary rounded-0 border-0" aria-disabled="true">
                                        <h6 class="m-0 font-weight-bold">{!! $question->TitleLang !!}</h6>
                                    </li>
                                    @forelse ($question->answers as $answer)
                                        <li class="list-group-item rounded-0 border-0" aria-disabled="true">
                                            <p class="d-inline-block m-0{{ $question->answer_id == $answer->id ? ' bg-success' : '' }}">
                                                - {!! $answer->TitleLang !!}
                                            </p>
                                        </li>
                                    @empty
                                        <li class="list-group-item rounded-0 border-0" aria-disabled="true">
                                            <p class="m-0">- No answers</p>
                                        </li>
                                    @endforelse
                                </ul>
                            @empty
                                <p>No questions</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('after_styles')
    @stack('crud_fields_styles')

@endpush

@push('after_scripts')
    @stack('crud_fields_scripts')
@endpush

