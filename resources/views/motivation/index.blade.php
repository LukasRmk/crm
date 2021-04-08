@extends('layouts.app')

@section('content')

<div class="container-fluid">
    
    <div class="card">

        <div class="card-header" id="card_header" style="height: 8vh">
            <div style="float: left">
                {{ __('Peržiūrėti geriausius') }} 
                &nbsp;
                <button type="button" data-period='year' class="btn btn-sm btn-primary show">Metų</button>
                <button type="button" data-period='month' class="btn btn-sm btn-primary show">Mėnesio</button>
                <button type="button" data-period='week' class="btn btn-sm btn-primary show">Savaitės</button>
                &nbsp;
                {{ __('darbuotojus') }} 
            </div>

            <div style="float: right">
                {{ __('Arba laikotarpio nuo ') }}
                <input type="date" value="{{ date('Y-m-d') }}" id="dateFrom" />
                {{ __(' iki') }}
                <input type="date" value="{{ date('Y-m-d') }}" id="dateTo" />
                <button type="button" data-period='custom' class="btn btn-sm btn-primary show"><i class="fas fa-search"></i> </button>

            </div>
        </div>

        <div class="card-body" style="height: 75vh" id="results">

        </div>
    </div>

</div>

<script>

    

    $(document).ready(function(){

        $('.show').on('click', function(){
            let period = $(this).data('period');

            let customFrom = $('#dateFrom').val();
            let customTo = $('#dateTo').val();

            $.ajax({
            type: "GET",
            url: "motivation/showResults/" + period + "/" + customFrom + "/" + customTo,
            success: function(data){

                $("#results").fadeOut(150, function() {
                    $(this).html((data.results)).fadeIn(150);
                });

            }
        })

        })

    })

</script>

@endsection