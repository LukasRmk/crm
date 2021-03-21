@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><div style="float: left"> {{ __('Naujo pardavimo pridėjimas') }} </div> <div style="float: right"> <a class="btn btn-primary" href="{{ route('clients.show', $_GET['client_id']) }}" > <i class="fas fa-arrow-left"></i> </a> </div> </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Klaida!</strong> Patikrinkite įvestis.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('sales.store') }}" method="POST">

                        @csrf
                        <div class="row">
                            <input type="hidden" name="added_by" value="{{ Auth::user()->id }}" class="form-control"  /><br>
                            <input type="hidden" name="client_id" value="{{ $_GET['client_id'] }}" class="form-control"  /><br>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Pardavimo pavadinimas: </strong>
                                <input type="text" name="name" class="form-control" /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Kaina: </strong>
                                <input type="number" min="0" name="price" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Aprašymas: </strong>
                                <textarea name="info" class="form-control"></textarea> <br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Langas: </strong>
                                <select id="window" class="form_control" name="window">
                                    <option value="" >...</option>
                                    @foreach ($windows->all() as $window)
                                        <option value="{{ $window->id }}" >{{ $window->name }}</option>
                                    @endforeach

                                </select><br>
                            </div>
                            <br><br>
                            <div class="col-xs-12 col-sm-12 col-md-12" id="stage_div" hidden>
                                <strong> Stadija: </strong>
                                <select id="stage" class="form_control" name="stage">

                                    <option value="" >...</option>
                                    @foreach ($stages->all() as $stage)
                                        <option class="stageOption" value="{{ $stage->id }}" data-window={{ $stage->window_id }} >{{ $stage->name }}</option>
                                    @endforeach

                                </select><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" >Pridėti</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>

$('#window').on('change', function(){
    let window = $(this).val();

    $('#stage_div').removeAttr('hidden');
    $('#stage').val("");

    $('.stageOption').each(function(){
        
        if($(this).data('window') != window){
            $(this).prop('hidden', 'true');
        } else {
            $(this).removeAttr('hidden');
        }
    });
});

</script>

@endsection