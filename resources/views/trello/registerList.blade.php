@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Select Board</div>
                    <div class="panel-body" style="height: 300px; overflow-y: auto;">
                        <ul class="list-group">
                            @if(count($unRegBoards))
                                @foreach($unRegBoards as $unRegBoard)
                                    <li class="list-group-item"><a href="/registerlist/{{$unRegBoard['boardId']}}">{{$unRegBoard['boardName']}}</a> - {{$unRegBoard['organization']}}
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @if(count($regBoards))
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">Registered Boards</div>
                        <div class="panel-body" style="height: 300px; overflow-y: auto;">
                            <ul class="list-group">
                                
                                    @foreach($regBoards as $regBoard)
                                        <li class="list-group-item"><a href="/registerlist/{{$regBoard['boardId']}}" tooltip="Edit">{{$regBoard['boardName']}}</a> - {{$regBoard['organization']}}
                                        </li>
                                    @endforeach
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection