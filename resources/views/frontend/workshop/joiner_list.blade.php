<div class="blog-item">
    <h2>{{trans('custom.list_joiners')}}</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{trans('custom.first_name')}}</th>
                <th scope="col">{{trans('custom.last_name')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entry->ListWorkShopJoiner as $key => $joiner)
                <tr>
                    <th scope="row">{{$key + 1}}</th>
                    <td>{{$joiner->first_name}}</td>
                    <td>{{$joiner->last_name}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>