@extends('layouts.app')

@section('content')

@if (Auth::guest())


<div class="container">
  <div class="jumbotron text-center">
    <h1>Welcome</h1>
    <p>This is a App for Dreametry Trello Task Counter</p>
    <p><a class="btn btn-lg btn-primary" href="/register" role="button">Register</a> <a class="btn btn-lg btn-success" href="/login" role="button">Login</a></p>
  </div>
</div>

    <script>
        $('#loading').hide();
    </script>
@else

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-defult">
                    <div class="panel-heading">Hi {{ Auth::user()->name }}</div>
                    <div class="panel-body">

                        <span class="label label-default">Owned Cards - {{$owned}}</span>
                        <span class="label label-default">Unassigned - {{$unassigned}}</span>
                        <span class="label label-default">Total Cards - {{$totalcards}}</span>
                    
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" style="height: 450px; overflow-y: auto;">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">L1 Task Cards</div>
                        <div class="panel-body">

                            <ul class="list-group">

                            @if (count($l1cards) > 0)
                                @foreach($l1cards as $l1card)
                                    <li class="list-group-item"><a href="{{$l1card['cardUrl']}}" target="_blank">{{$l1card['cardname']}}</a> - {{$l1card['board']}}</li>
                                @endforeach
                            @endif
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">L2 Task Cards</div>
                        <div class="panel-body">

                            <ul class="list-group">

                            @if (count($l2cards) > 0)
                                @foreach($l2cards as $l2card)
                                    <li class="list-group-item"><a href="{{$l2card['cardUrl']}}" target="_blank">{{$l2card['cardname']}}</a> - {{$l2card['board']}}</li>
                                @endforeach
                            @endif
                            </ul>

                        </div>
                        
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">L3 Task Cards</div>
                        <div class="panel-body">

                            <ul class="list-group">

                            @if (count($l3cards) > 0)
                                @foreach($l3cards as $l3card)
                                    <li class="list-group-item"><a href="{{$l3card['cardUrl']}}" target="_blank">{{$l3card['cardname']}}</a> - {{$l3card['board']}}</li>
                                @endforeach
                            @endif
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-danger">
                        <div class="panel-heading">L4 Task Cards</div>
                        <div class="panel-body">

                            <ul class="list-group">

                            @if (count($l4cards) > 0)
                                @foreach($l4cards as $l4card)
                                    <li class="list-group-item"><a href="{{$l4card['cardUrl']}}" target="_blank">{{$l4card['cardname']}}</a> - {{$l4card['board']}}</li>
                                @endforeach
                            @endif
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">L5 Task Cards</div>
                        <div class="panel-body">

                            <ul class="list-group">

                            @if (count($l5cards) > 0)
                                @foreach($l5cards as $l5card)
                                    <li class="list-group-item"><a href="{{$l5card['cardUrl']}}" target="_blank">{{$l5card['cardname']}}</a> - {{$l5card['board']}}</li>
                                @endforeach
                            @endif
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6" style="height: 450px; overflow-y: auto;">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Unlabeled Cards</div>
                        <div class="panel-body">

                            <ul class="list-group">

                            @if (count($nolabel) > 0)
                                @foreach($nolabel as $nl)
                                    <li class="list-group-item"><a href="{{$nl['cardUrl']}}" target="_blank">{{$nl['cardname']}}</a> - {{$nl['board']}}</li>
                                @endforeach
                            @endif

                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('#loading').hide();
    </script>
  

@endif

@endsection