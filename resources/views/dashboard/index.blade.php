@extends('layouts.app')

@section('content')

<style>



</style>

<div class="container-fluid ">
    <div class="row row-cols-2">

        <!-- Klientai -->
        <div class="col col-md" >
            <div class="card" style="height: 86vh;">
                <div class="card-header">
                    <div style="float: left">
                        <strong style="font-size: 16pt" title="Čia rodomos šio mėnesio užduotys arba vėluojančios užduotys" >Darbas su klientais</strong> 
                    </div> 
                </div>

                <div class="card-body" style="overflow-y: scroll;">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table" style="table-layout: fixed;">
                        <thead class="thead-light">
                            <tr>
                                <th>Klientas</th>
                                <th>Tipas</th>
                                <th>Pavadinimas</th>
                                <th>Iki kada atlikti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td><a  href="{{ route('clients.show', $task->client_id) }}">{{ $task->client_name }}</a></td>
                                    <td>{{ $task->type_name }}</td>
                                    <td><a href="{{ route('tasks.edit', $task->id) }}" >{{ $task->task_name }}</a></td>
                                    <td>{{ $task->task_datetime }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- Mėnuo -->
        <div class="col col-md">
            <div  style="height: 86vh;">
                
                <div class="row">

                    <div class="col col-md card card-stats" style="height: 25vh; ">
                        <div class="card-body"> 
                            <center>
                                <div class="col" style="font-size: 18pt"> 
                                    <i class="fas fa-euro-sign" style="color: green; font-size: 20pt" ></i> {{ __("Pardavimai") }}
                                </div>
                                <br>
                                <div id="sales_progress">
                                </div>

                            </center>
                        </div>
                    </div>

                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;

                    <div class="col col-md card card-stats " >
                        <div class="card-body"> 
                            <center>
                                <div class="col" style="font-size: 18pt"> 
                                    <i class="fas fa-phone-volume" style="color: #11cdef; font-size: 20pt" ></i> {{ __("Skambučiai") }}
                                </div>
                                <br>
                                <div id="calls_progress">
                                </div>

                            </center>
                        </div>
                    </div>

                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;

                    <div class="col col-md card card-stats " >
                        <div class="card-body"> 
                            <center>
                                <div class="col" style="font-size: 18pt"> 
                                    <i class="fas fa-handshake" style="color: #115fef; font-size: 20pt" ></i> {{ __("Susitikimai") }}
                                </div>
                                <br>
                                <div id="meeting_progress">
                                </div>

                            </center>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col col-md card card-stats" style="height: 58vh; ">
                        <br>
                        <div class="card-body">
                            <div class="card bg-default" id="chartContainer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $('#sales_progress').circleProgress({
        max: {{ $salesTotal[0]->count }},
        value: {{ $salesWon[0]->count }},
        indeterminateText: 0,
        animationDuration: 1800
    });

    $('#calls_progress').circleProgress({
        max: {{ $callsTotal[0]->count }},
        value: {{ $callsWon[0]->count }},
        indeterminateText: 0,
        animationDuration: 1800

    });

    $('#meeting_progress').circleProgress({
        max: {{ $meetsTotal[0]->count }},
        value: {{ $meetsWon[0]->count }},
        indeterminateText: 0,
        animationDuration: 1800,
    });

    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: "Metinė pardavimų statistika"
        },
        axisX:{ 
            valueFormatString: "YYYY-M"
        },
        data: [{        
            type: "spline",
            xValueFormatString: "YYYY-M",
            yValueFormatString: "#0.00\"€\"",
            indexLabelFontSize: 16,
            dataPoints: [
                { y: {{ $yearlySales[0]['price'] }}, x: new Date({{ $yearlySales[0]['year']  }}, {{ $yearlySales[0]['month']  }}) },
                { y: {{ $yearlySales[1]['price'] }}, x: new Date({{ $yearlySales[1]['year']  }}, {{ $yearlySales[1]['month']  }}) },
                { y: {{ $yearlySales[2]['price'] }}, x: new Date({{ $yearlySales[2]['year']  }}, {{ $yearlySales[2]['month']  }}) },
                { y: {{ $yearlySales[3]['price'] }}, x: new Date({{ $yearlySales[3]['year']  }}, {{ $yearlySales[3]['month']  }}) },
                { y: {{ $yearlySales[4]['price'] }}, x: new Date({{ $yearlySales[4]['year']  }}, {{ $yearlySales[4]['month']  }}) },
                { y: {{ $yearlySales[5]['price'] }}, x: new Date({{ $yearlySales[5]['year']  }}, {{ $yearlySales[5]['month']  }}) },
                { y: {{ $yearlySales[6]['price'] }}, x: new Date({{ $yearlySales[6]['year']  }}, {{ $yearlySales[6]['month']  }}) },
                { y: {{ $yearlySales[7]['price'] }}, x: new Date({{ $yearlySales[7]['year']  }}, {{ $yearlySales[7]['month']  }}) },
                { y: {{ $yearlySales[8]['price'] }}, x: new Date({{ $yearlySales[8]['year']  }}, {{ $yearlySales[8]['month']  }}) },
                { y: {{ $yearlySales[9]['price'] }}, x: new Date({{ $yearlySales[9]['year']  }}, {{ $yearlySales[9]['month']  }}) },
                { y: {{ $yearlySales[10]['price'] }}, x: new Date({{ $yearlySales[10]['year']  }}, {{ $yearlySales[10]['month']  }}) },
                { y: {{ $yearlySales[11]['price'] }}, x: new Date({{ $yearlySales[11]['year']  }}, {{ $yearlySales[11]['month']  }}) },
                { y: {{ $yearlySales[12]['price'] }}, x: new Date({{ $yearlySales[12]['year']  }}, {{ $yearlySales[12]['month']  }}) },
            ]
        }]
});
chart.render();

</script>

@endsection