@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg">
            <div class="card">
                <div class="card-header"><div style="float: left"> <strong style="font-size:18pt" > {{ __('Pardavimų langai') }} </strong> </div> <div style="float: right"> <a class="btn btn-primary" href="{{ route('windows.create') }}" > <i class="fas fa-plus"></i> </a> </div> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p> {{ $message }} </p>
                        </div>
                    @endif

                    @foreach ($windows as $window)
                    <br>
                    <table class="table table" id="{{ $window->id }}_sales_windows" data-window="{{ $window->id }}"  >
                        <thead class="thead-light">

                            <tr>
                                <th>Pavadinimas</th>
                                <th>Stadijos</th>
                            </tr>
                        </thead>
                        <tbody id="stage_body_{{ $window->id }}">

                                <tr id='window_{{ $window->id }}'>
                                    <td><a  href="{{ route('windows.edit', $window->id) }}">{{ $window->name }}</a></td>
                                    <td><a class="btn btn-sm btn-success" title="Pridėti stadiją" href="{{ route('stages.create', ['window' => $window->id]) }}" ><i class="fas fa-plus"></i></a></td>
                                </tr>

                                @foreach($stages as $stage)
                                    @if ($stage->window_id == $window->id)
                                        <tr style="background-color: rgb(245, 245, 245)" id="{{ $stage->id }}" data-window="{{ $window->id }}">

                                            <td></td>
                                            <td>
                                                <form action="{{ route('stages.destroy', $stage->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a  href="{{ route('stages.edit', $stage->id) }}"> {{ $stage->name }} </a> &nbsp; <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Ar tikrai norite ištrinti stadiją?')" ><i class="far fa-trash-alt"></i></button>
                                                </form> 
                                            </td>

                                        </tr>  
                                    @endif
                                @endforeach
                            
                        </tbody>
                    </table>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
$('[id*="_sales_windows"] tbody ').sortable({
    axis: "y",
    items: "tr:not('[id*=" + "window_" + "]')",
    cursor: "move",
    helper: "clone",
    placeholder: 'marker',
    update: function(event, ui){
        let window = $(this).parent().data('window');
        let stage = $(this).attr('id');

        var order = [];

        $("#" + stage +  " tr:not('[id*=" + "window_" + "]')").each(function() {
            order.push(this.id);
        });

        var order = order.join("!");

        $.ajax({
            type: "GET",
            url: "stages/updateStageOrder/" + order,
            success: function(data){
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
                toastr.success(data.success);
            }
        })
    }
});

</script>

@endsection