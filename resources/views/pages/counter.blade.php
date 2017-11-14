@extends('layouts.app')

@section('content')

<div class="container" id="data">
    <div class="row" id="done">
        <div class="col-md-1 well">

        </div>
       
    </div>
</div>

<script>
    $('#loading').hide();
    var interval = setInterval(function () {
        $.get('/livecounter', function(json){
             for(i = 0; i < json.length; i++){

             }
        });
    }, 1000);
</script>
@endsection