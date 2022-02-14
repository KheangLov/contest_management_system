@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('backpack::base.welcome'),
        'content'     => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];

    Widget::add()->to('before_content')->type('div')->class('row')->content([
		// notice we use Widget::make() to add widgets as content (not in a group)
		Widget::make()
			->type('progress')
			->class('card border-0 text-white bg-primary')
			->progressClass('progress-bar')
			->value($userCount)
			->description(trans('custom.primary_dashboard_card'))
			->progress(100 * (int)$userCount / 1000)
			->hint(trans('custom.primary_dashboard_progress', ['count' => 1000 - $userCount])),
		// // alternatively, you can just push the widget to a "hidden" group
		Widget::make()
			->group('hidden')
		    ->type('progress')
		    ->class('card border-0 text-white bg-warning')
		    ->value($contest)
		    ->progressClass('progress-bar')
		    ->description(trans('custom.warning_dashboard_card'))
		    ->progress(30)
		    ->hint(trans('custom.warning_dashboard_progress')),
        // alternatively, to use widgets as content, we can use the same add() method,
		// but we need to use onlyHere() or remove() at the end
		Widget::add()
		    ->type('progress')
		    ->class('card border-0 text-white bg-success')
		    ->progressClass('progress-bar')
		    ->value($regContest)
		    ->description(trans('custom.success_dashboard_card'))
		    ->progress(80)
		    ->hint(trans('custom.success_dashboard_progress'))
		    ->onlyHere(),
		// // both Widget::make() and Widget::add() accept an array as a parameter
		// // if you prefer defining your widgets as arrays
	    Widget::make([
			'type' => 'progress',
			'class'=> 'card border-0 text-white bg-dark',
			'progressClass' => 'progress-bar',
			'value' => $workshop,
			'description' => trans('custom.progress_dashboard_card'),
			'progress' => (int)$workshop/75*100,
			'hint' => $workshop > 75 ? trans('custom.progress_dashboard_progress') : trans('custom.progress_dashboard_progress_second'),
		]),
	]);
@endphp

@section('content')
@endsection
