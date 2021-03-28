@extends('layouts.app')

@section('content')

<div class="container-fluid">
    
    <div class="card">

        <div id="hidden_header" style="height: 8vh; position:absolute; z-index:5; display:none" >
            <div id="sale_lost" style="float: left; width: 50%; height: 100%; display: flex; justify-content: center; align-items: center; border: 3px #f5365c dashed; border-radius: 16px; background-color: #f1a3b2">
                <b id="sale_lost">{{ __("PRALAIMĖTAS") }}</b> 
            </div>
            <div id="sale_won" style="float: right; width: 50%; height: 100%; display: flex; justify-content: center; align-items: center; border: 3px #2dce42 dashed; border-radius: 16px; background-color: #a2f3ad">
                <b id="sale_won">{{ __("LAIMĖTAS") }}</b>
            </div>
        </div>

        <div class="card-header" id="card_header" style="height: 8vh">
            <div style="float: left">
                <strong>Langas:</strong> &nbsp; 
                <select id="window" class="form_control" name="window">
                    <option value="" >...</option>
                    @foreach ($windows->all() as $window)
                        <option value="{{ $window->id }}" >{{ $window->name }}</option>
                    @endforeach

                </select>
                &nbsp; 
                <strong>Pardavėjas:</strong> &nbsp; 
                <select id="seller" class="form_control" name="window">
                    <option value="0" >Visi</option>
                    @foreach ($users->all() as $user)
                        <option value="{{ $user->id }}" {{ ($user->id == Auth::user()->id ) ? 'selected' : '' }} >{{ $user->name }}</option>
                    @endforeach

                </select>
                &nbsp; 
                &nbsp; 
                <button type="button" id="show" class="btn btn-sm btn-primary"><i class="fas fa-search"></i>  Rodyti pardavimus</button>
                &nbsp;
            </div>
            <div style="float: right">
                <a title="Langų nustaymai" class="btn btn-sm btn-light" href="{{ route('windows.index') }}" ><i class="fas fa-cogs"></i></a>
            </div>
        </div>

        <div class="card-body" style="height: 75vh" id="sales">

        </div>
    </div>

</div>

<input type="hidden" id="picked_id" />
<input type="hidden" id="sale_id" />

<script>

var width = document.getElementById('card_header').offsetWidth;
$('#hidden_header').css("width", width);

$( window ).resize(function() {
    var width = document.getElementById('card_header').offsetWidth;
    $('#hidden_header').css("width", width);
});

toastr.options = {
    "debug": false,
    "positionClass": "toast-bottom-right",
    "onclick": null,
    "fadeIn": 300,
    "fadeOut": 1000,
    "timeOut": 5000,
    "extendedTimeOut": 1000,
    "newestOnTop": false
}

    $('#show').on('click', function(){
        let seller = $('#seller').val();
        let window = $('#window').val();

        if(window){

            $.ajax({
                type: "GET",
                url: "sales/getSalesWindow/" + window + "/" + seller,
                success: function(data){
                    $('#sales').html(data.window);

                    $('[id*="table_to_sort_" ]').sortable({  
                        scrollSpeed: 10,
                        connectWith: ".table_to_sort",
                        items: "tbody > tr:not(tfoot > tr)",
                        helper: "clone",
                        cursor: "move",
                        placeholder: 'marker',
                        start: function(event, ui) { 
                            var movedEl = $(ui.item).attr('value');
                            $('#picked_id').val(movedEl);
                            $('#sale_id').val(movedEl);
                            $('#hidden_header').show("slide");
                        },
                        receive: function (event, ui) { 
                            var movedEl = $('#picked_id').val();
                            var addedTo = $(this).closest('table').attr('stage_id');

                            $('body').one('mousemove', function(evt){
                                var status = evt.target.id;

                                if(status != 'sale_won' && status != 'sale_lost'){
                                    $.ajax({
                                        type: "GET",
                                        url: "sales/setNewStage/" + movedEl + "/" + addedTo,
                                        success:function(data){
                                            toastr.success("Pardavimo stadija atnaujinta!");
                                        }
                                    })
                                }
                            });

                        },
                        update: function(event, ui){ 
                            var table = $(this).attr('id');
                            var order = [];

                            $("#" + table + " tbody tr").each(function() {
                                order.push(this.id);
                            });

                            var order = order.join("!");

                            if(order){
                                $.ajax({
                                    type: "GET",
                                    url: "sales/setNewOrder/" + order,
                                    success:function(data){
                                        console.log("done");
                                    }
                                })
                            }

                            
                        },
                        stop: function(){
                            var sale = $('#picked_id').val();

                            $('body').one('mousemove', function(evt){
                                var status = evt.target.id;

                                if(status == 'sale_won'){

                                    console.log(status);
                                    $.ajax({
                                        type: "GET",
                                        url: "sales/setStatus/1/" + sale,
                                        success:function(data){
                                            toastr.success("Pardavimas laimėtas!");
                                        }
                                    })

                                } else if(status == 'sale_lost'){

                                    console.log(status);
                                    $.ajax({
                                        type: "GET",
                                        url: "sales/setStatus/2/" + sale,
                                        success:function(data){
                                            toastr.error("Pardavimas pralaimėtas!");
                                        }
                                    })

                                }

                                if(status == 'sale_won' || status == 'sale_lost'){
                                    $('#sale_' + sale).hide("slow");
                                    $('#sale_' + sale).parent().css("display", "none");

                                }

                            });

                            

                            $('#hidden_header').hide("slide");
                        }
                    });
                }
            });

        } else {
            toastr.error("Pasirinkite langą!");
        }
    });

</script>

@endsection