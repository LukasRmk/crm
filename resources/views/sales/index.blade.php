@extends('layouts.app')

@section('content')

<div class="container-fluid">
    
    <div class="card">
        <div class="card-header" style="height: 8vh">
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
                    <option value="0" >...</option>
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

<input type="text" id="picked_id" />
<input type="text" id="sale_id" />

<script>

$(document).ready( function() {

    $('#show').on('click', function(){
        let seller = $('#seller').val();
        let window = $('#window').val();

        if(window){

            $.ajax({
                type: "GET",
                url: "sales/getSalesWindow/" + window + "/" + seller,
                success: function(data){
                    $('#sales').html(data.window);

                    $('[id*="sortable_"]').sortable({  
                        scroll: true, 
                        scrollSensitivity: 100, 
                        placeholder: 'marker',
                        scrollSpeed: 10,
                        connectWith: ".sortable",
                        items: "tbody > tr:not(tfoot > tr)",
                        helper: "clone",
                        cursor: "move",
                        start: function(event, ui) { 
                            var movedEl = $(ui.item).attr('value');
                            $('#picked_id').val(movedEl);
                            $('#sale_id').val(movedEl);
                        },
                        receive: function (event, ui) { 
                            var movedEl = $('#picked_id').val();
                            var addedTo = $(this).closest('table').attr('stage_id');
                        },
                        update: function(event, ui){ 
                            var table = $(this).attr('id');
                            var stage = $(this).attr('stage_id');
                        }
                    });
                }
        })

        } else {
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

            toastr.error("Pasirinkite langą!");
        }
    });

});

</script>

@endsection