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
                            <span><b>@lang('custom.question'):</b></span>
                        </div>
                        <div class="col-sm-8">
                            <span>{!! $entry->DescriptionLang !!}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <span><b>@lang('custom.answer'):</b></span>
                        </div>
                        <div class="col-sm-8">
                            @if($entry->FaqByParentId)
                                @foreach ($entry->FaqByParentId as $answer)
                                    <p class="border-bottom">{!! $answer->description !!}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            {{-- <span><b>@lang('custom.answer'):</b></span> --}}
                        </div>
                        <div class="col-sm-8">
                            <form  method="GET" action="{{ route('faq_answer') }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control border" name="answer_message" placeholder="{{trans('custom.answer')}}" id="answer_message" cols="30" rows="2"></textarea>
                                        </div>
                                        <input type="hidden" name="parent_id" value="{{$entry->id}}" />
                                    </div>
                                    <div class="col-md-12 post-btn">
                                        <button type="submit" class="btn btn-success"><span>{{trans('custom.answer')}}</span></button>
                                    </div>
                                </div>
                            </form>
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

