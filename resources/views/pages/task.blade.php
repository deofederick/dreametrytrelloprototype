@extends('layouts.app')

@section('content')
<div class="col-md-6 col-md-offset-3 well">

   
    <button class="btn btn-primary" type="button">
        To Do <span class="badge">{{ $todo }}</span>
    </button>
    <button class="btn btn-primary" type="button">
        For Review <span class="badge">{{ $rev }}</span>
    </button>
    <button class="btn btn-primary" type="button">
        Done <span class="badge">{{ $done }}</span>
    </button>
    <button class="btn btn-primary" type="button">
        Paid <span class="badge">{{ $paid }}</span>
    </button>
    <button class="btn btn-primary" type="button">
        other <span class="badge">{{ $unreglist }}</span>
    </button>
</div>

    <script>
        $.get('/load', function(json){
            console.log(json);
        });
    </script>

    
@endsection