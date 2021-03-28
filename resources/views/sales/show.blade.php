@extends('layouts.app')

@section('content')

@if ($message = Session::get('success'))
    <div class="alert alert-success" style="text-align: center">
        <p style="font-weight: bold; font-size: large"> {{ $message }} </p>
    </div>
@endif

@if ($task_message = Session::get('task_success'))
    <div class="alert alert-success" style="text-align: center">
        <p style="font-weight: bold; font-size: large"> {{ $task_message }} </p>
    </div>
@endif

@if ($task_message = Session::get('sale_success'))
    <div class="alert alert-success" style="text-align: center;">
        <p style="font-weight: bold; font-size: large"> {{ $task_message }} </p>
    </div>
@endif

@if ($task_message = Session::get('contact_success'))
    <div class="alert alert-success" style="text-align: center;">
        <p style="font-weight: bold; font-size: large"> {{ $task_message }} </p>
    </div>
@endif

<div class="container-fluid ">
    <div class="row row-cols-3">
        <div class="col col-sm-3">
            <!-- Kliento info -->
            <div class="row row-cols-1">
                <div class="col col-lg ">
                    <div class="card" style="height: 40vh;" >
                        <div class="card-header">
                            <div style="float: left">
                                <strong style="font-size: 16pt" >{{ $sale->name }}</strong> 
                            </div> 
                            <div style="float: right"> 
                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                    <i class="ni ni-settings-gear-65"></i>
                                    <a class="btn btn-sm btn-primary" href="{{ route('sales.edit', $sale->id) }}"><i class="far fa-edit"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Ar tikrai norite ištrinti pardavimą?')" ><i class="far fa-trash-alt"></i></button>
                                    <a class="btn btn-sm btn-primary" title="Klientas" href="{{ route('clients.show', $sale->client_id) }}" > <i class="fas fa-arrow-left"></i> </a>
                                </form>
                            </div> 
                        </div>

                        <div class="card-body" style="overflow-x: hidden">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="row">
                                <table class="table" style="table-layout: fixed;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Kaina (€)</th>
                                            <td><strong>{{ $sale->price }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Pardavėjas</th>
                                            <td><strong>{{ $sale->user_name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Langas</th>
                                            <td><strong>{{ $sale->window_name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Stadija</th>
                                            <td><strong>{{ $sale->stage_name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Statusas</th>
                                            <td><strong>{{ ($sale->status == 0) ? "Nebaigtas" : (($sale->status == 1) ? "Laimėtas" : (($sale->status == 2) ? "Pralaimėtas" : "")) }}</strong></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontaktai -->
            <div class="row row-cols-1">
                    
                <div class="col col-lg">
                    <div class="card" style="height: 42vh;">
                        <div class="card-header">
                            <div style="float: left">
                                <strong style="font-size: 16pt" >Kontaktai</strong> 
                            </div>
                            <div style="float: right">
                                <a title="Pridėti kontaktą" class="btn btn-sm btn-success" href="{{ route('contacts.create', ['client' => $sale->client_id]) }}"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body" style="overflow-y: scroll;">

                            @if(count($contacts) > 0)

                                @foreach ($contacts as $contact)
                                    <div class="card-body shadow" style="border-radius: 25px;" >
                                        <div style="float: left; font-size:11pt" ><b>{{ $contact->contact_name }}</b> </div> 
                                        <div style="float: right"> 
                                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn btn-sm btn-primary" href="{{ route('contacts.edit', $contact->id) }}"><i class="far fa-edit"></i></a>
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Ar tikrai norite ištrinti klientą?')" ><i class="far fa-trash-alt"></i></button>
                                            </form> 
                                        </div><br>
                                        <div style="font-size:11pt" >{{ $contact->position }} </div> 
                                        <div style="font-size:11pt"> {{ $contact->phone_no }} </div>
                                        <div style="font-size:11pt"> {{ $contact->email }} </div>
                                    </div>
                                    <br>
                                @endforeach
                            @else
                                <center><b style="color: #5e72e4" >Kontaktų nėra</b></center><br><br>
                            @endif
                            
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Užduotys -->
        <div class="col col-md" >
            <div class="card" style="height: 86vh;">
                <div class="card-header">
                    <div style="float: left">
                        <strong style="font-size: 16pt" >Pardavimo užduotys</strong> 
                    </div> 
                    <div style="float: right"> 
                        <a title="Planuoti užduotį" class="btn btn-sm btn-success" href="{{ route('tasks.create', ['client' => $sale->client_id, 'sale' => $sale->id]) }}"><i class="fas fa-plus"></i></a>
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
                                <th>Tipas</th>
                                <th>Pavadinimas</th>
                                <th>Iki kada atlikti</th>
                                <th>Atlikta</th>
                                <th>Tikslas</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)

                                <tr>
                                    <td>{{ $task->type_name }}</td>
                                    <td style="white-space: nowrap;overflow: hidden; text-overflow: ellipsis;" > <a href="{{ route('tasks.edit', [$task->id, 'sale'] ) }}"> {{ $task->task_name }} </a> </td>
                                    <td>
                                        <span class="status">{{ gmdate('Y-m-d H:i', strtotime($task->task_datetime))  }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-pill {{  ($task->task_completed == 1 ? 'badge-success' : 'badge-danger') }} ">{{  ($task->task_completed == 1 ? ' TAIP ' : ' NE ') }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-lg badge-pill {{  ($task->task_succesful == 1 ? 'badge-success' : 'badge-danger') }} ">{{  ($task->task_succesful == 1 ? ' TAIP ' : ' NE ') }}</span>
                                    </td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection