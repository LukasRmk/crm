@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div style="float: left">
                        <strong style="font-size: 20pt" >{{ $task->task_name }}</strong> 
                    </div> 
                    <div style="float: right"> 
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                            <a class="btn btn-info" href="{{ route('tasks.edit', $task->id) }}"><i class="far fa-edit"></i></a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" ><i class="far fa-trash-alt"></i></button>
                            <a class="btn btn-primary" href="{{ route('clients.show', $task->client_id) }}" > <i class="fas fa-arrow-left"></i> </a> 
                        </form>
                    </div> 
                </div>

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

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong> Tipas: </strong>
                            {{ $task_type[0]->type_name }}
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong> Pavadinimas: </strong>
                            {{ $task->task_name }}
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong> Aprašymas: </strong>
                            <pre>{{ $task->task_description }}</pre>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong> Atlikti iki: </strong>
                            {{ $task->task_datetime }}
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong> Atlikta: </strong>
                            {{ $task->task_completed }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection