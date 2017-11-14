@extends('layouts.app')

@section('content')


<div class="container" id="data">

    <div class="row">
        <div class="col-md-5 col-md-offset-4 well">

            <button class="btn btn-primary" type="button" id="todo">
                To Do <span class="badge">{{ $todo }}</span>
            </button>
            <button class="btn btn-primary" type="button" id="rev">
                For Review <span class="badge">{{ $rev }}</span>
            </button>
            <button class="btn btn-primary" type="button" id="done">
                Done <span class="badge">{{ $done }}</span>
            </button>
            <button class="btn btn-primary" type="button" id="paid">
                Paid <span class="badge">{{ $paid }}</span>
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6" style="height: 450px; overflow-y: auto;">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">L1 Task Cards</div>
                    <div class="panel-body">

                      

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">L2 Task Cards</div>
                    <div class="panel-body">

                        <ul class="list-group" id="l2_task">

                        </ul>

                    </div>
                    
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">L3 Task Cards</div>
                    <div class="panel-body">

                        <ul class="list-group" id="l3_task">

                        </ul>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">L4 Task Cards</div>
                    <div class="panel-body">

                        <ul class="list-group" id="l4_task">

                        </ul>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">L5 Task Cards</div>
                    <div class="panel-body">

                        <ul class="list-group" id="l5_task">

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

                        <ul class="list-group" id="nol_task">

                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>

    <script>
        $('#data').hide();

        var interval = setInterval(function () {
           
            $.get('/taskload', function(json){
                $("#l1_task").empty();
                $("#l2_task").empty();
                $("#l3_task").empty();
                $("#l4_task").empty();
                $("#l5_task").empty();
                $("#nol_task").empty();
                $("#todo").empty();
                $("#rev").empty();
                $("#done").empty();
                $("#paid").empty();

                for(i = 0; i < json["l1cards"].length; i++){
                    
                    var list = "<li class=\"list-group-item\"><a href=\""+json["l1cards"][i]["cardUrl"]+"\" target=\"_blank\">"+json["l1cards"][i]["cardname"]+"</a> - "+json["l1cards"][i]["status"]+"</li>";
                    $("#l1_task").append(list);
                
                }

                for(i = 0; i < json["l2cards"].length; i++){
                    
                    var list = "<li class=\"list-group-item\"><a href=\""+json["l2cards"][i]["cardUrl"]+"\" target=\"_blank\">"+json["l2cards"][i]["cardname"]+"</a> - "+json["l2cards"][i]["status"]+"</li>";
                    $("#l2_task").append(list);
                
                }

                for(i = 0; i < json["l3cards"].length; i++){
                    
                    var list = "<li class=\"list-group-item\"><a href=\""+json["l3cards"][i]["cardUrl"]+"\" target=\"_blank\">"+json["l3cards"][i]["cardname"]+"</a> - "+json["l3cards"][i]["status"]+"</li>";
                    $("#l3_task").append(list);
                
                }

                for(i = 0; i < json["l4cards"].length; i++){
                    
                    var list = "<li class=\"list-group-item\"><a href=\""+json["l4cards"][i]["cardUrl"]+"\" target=\"_blank\">"+json["l4cards"][i]["cardname"]+"</a> - "+json["l4cards"][i]["status"]+"</li>";
                    $("#l4_task").append(list);
                
                }

                for(i = 0; i < json["l5cards"].length; i++){
                    
                    var list = "<li class=\"list-group-item\"><a href=\""+json["l5cards"][i]["cardUrl"]+"\" target=\"_blank\">"+json["l5cards"][i]["cardname"]+"</a> - "+json["l5cards"][i]["status"]+"</li>";
                    $("#l5_task").append(list);
                
                }

                for(i = 0; i < json["nolabel"].length; i++){
                    
                    var list = "<li class=\"list-group-item\"><a href=\""+json["nolabel"][i]["cardUrl"]+"\" target=\"_blank\">"+json["nolabel"][i]["cardname"]+"</a> - "+json["nolabel"][i]["status"]+"</li>";
                    $("#nol_task").append(list);
                
                }

                $('#todo').append('To Do <span class="badge">'+json["count"]["todo"]+'</span>');
                $('#rev').append('For Review <span class="badge">'+json["count"]["rev"]+'</span>');
                $('#done').append('Done <span class="badge">'+json["count"]["done"]+'</span>');
                $('#paid').append('Paid <span class="badge">'+json["count"]["paid"]+'</span>');

                $('#loading').hide();
                $('#data').show()
            });
        }, 1000);
        
    </script>

@endsection