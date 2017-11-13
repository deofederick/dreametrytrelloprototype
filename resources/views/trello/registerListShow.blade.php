@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        
        @if($editable)
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Settup {{$boardid['board_name']}}</div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach($lists as $list)
                                <li class="list-group-item">{{$list['name']}}<a href="/registerlist/{{$list['id']}}/edit" class="btn btn-xs btn-warning pull-right">Edit</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
            </div>
        @else
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Settup {{$listsBoard['name']}}</div>
                    <div class="panel-body">
                        {!! Form::open(['action' => 'ListsController@store', 'method' => 'POST']) !!}
                        {!! Form::text('board_id', $boardid['id'], ['readonly' => true, 'hidden' => true]) !!}
                    <ul class="list-group">

                        <li class="list-group-item">
                            {!! Form::label('list','To do') !!}
                            {!! Form::text('todo', '1', ['readonly' => true, 'hidden' => true]) !!}

                            <select name="selecttodo">
                                <option value="">--Select--</option>
                            @foreach($lists as $list)

                                <option value="{{$list['id']}}">{{$list['name']}}</list>
                                
                            @endforeach
                            </select>

                        </li>

                        <li class="list-group-item">
                            {!! Form::label('list','For Review') !!}
                            {!! Form::text('forreview', '2', ['readonly' => true, 'hidden' => true]) !!}

                            <select name="selectforreview">
                                <option value="">--Select--</option>
                            @foreach($lists as $list)

                                <option value="{{$list['id']}}">{{$list['name']}}</list>
                                
                            @endforeach
                            </select>
                        </li>

                        <li class="list-group-item">
                            {!! Form::label('list','Done') !!}
                            {!! Form::text('done', '3', ['readonly' => true, 'hidden' => true]) !!}

                            <select name="selectdone">
                                <option value="">--Select--</option>
                            @foreach($lists as $list)

                                <option value="{{$list['id']}}">{{$list['name']}}</list>
                                
                            @endforeach
                            </select>
                        </li>

                        <li class="list-group-item">
                            {!! Form::label('list','Paid') !!}
                            {!! Form::text('paid', '4', ['readonly' => true, 'hidden' => true]) !!}

                            <select name="selectpaid">
                                <option value="">--Select--</option>
                            @foreach($lists as $list)

                                <option value="{{$list['id']}}">{{$list['name']}}</list>
                                
                            @endforeach
                            </select>
                        </li>
                    </ul>

                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

    <script>
        $('#loading').hide();
    </script>
  
@endsection
