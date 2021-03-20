@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><div style="float: left"> <strong> Užduoties {{ $task->name }} redagavimas </div> </strong> <div style="float: right"> 
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Ar tikrai norite ištrinti užduotį?')" ><i class="far fa-trash-alt"></i></button>
                        <a class="btn btn-primary" href="{{ route('clients.show', $task->client_id) }}" > <i class="fas fa-arrow-left"></i> </a> 
                    </form>
                </div> </div>

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

                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">

                        @csrf
                        @method('PUT')
                        <div class="row">
                            <input type="hidden" name="type_id" value="{{ $task->type_id }}" class="form-control" /><br>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Užduoties tipas: </strong>
                                {{ $task_type[0]->type_name }}
                            </div><br><br>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Užduoties pavadinimas: </strong>
                                <input type="text" name="task_name" value="{{ $task->task_name }}" class="form-control" /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Aprašymas: </strong>
                                <textarea name="task_description" class="form-control"> {{ $task->task_description }} </textarea> <br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Atlikti iki: </strong>
                                <input type="datetime-local" name="task_datetime" value="{{ date('Y-m-d\TH:i', strtotime($task->task_datetime)) }}" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Užduotis atlikta: </strong>
                                <label >
                                    <label class="custom-toggle">
                                        <input type="hidden" value="0" name="task_completed">
                                        <input type="checkbox" value="1" name="task_completed" {{  ($task->task_completed == 1 ? ' checked' : '') }} >
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="Ne" data-label-on="Taip"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Tikslas pasiektas: </strong>
                                <label >
                                    <label class="custom-toggle">
                                        <input type="hidden" value="0" name="task_succesful">
                                        <input type="checkbox" value="1" name="task_succesful" {{  ($task->task_succesful == 1 ? ' checked' : '') }} >
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="Ne" data-label-on="Taip"></span>
                                    </label>
                                </label>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" >Atnaujinti</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

            <div class="card">
                <div class="card-header"><div style="float: left"> <strong> Užduoties {{ $task->name }} komentarai </div> </strong> </div>

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

                    @if ($comment_message = Session::get('comment_success'))
                        <div class="alert alert-success">
                            <p> {{ $comment_message }} </p>
                        </div>
                    @endif
                    
                    <!-- Komentar7 atvaizdavimas -->
                    @if(count($task_comments) > 0)
                        @foreach ($task_comments as $comment)
                            <div class="card-body shadow" style="border-radius: 25px;" >
                                <div style="float: left" ><b>{{ $comment->name }}:</b> </div> 
                                <div style="float: right"> 
                                    <form action="{{ route('destroyComment', $comment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" ><i class="far fa-trash-alt"></i></button>
                                    </form> 
                                </div><br>

                                <pre style="font-family: Open Sans, sans-serif">{{ $comment->comment }}</pre>
                                <b>{{ $comment->created_at }}</b>
                            </div>
                            <br>
                        @endforeach
                    @else

                        <center><b style="color: #5e72e4" >Komentarų nėra</b></center><br><br>

                    @endif


                    <form action="{{ route('storeComment') }}" method="POST">

                        @csrf
                        @method('PUT')
                        <div class="row">
                            <input type="hidden" name="task_id" value="{{ $task->id }}" class="form-control" /><br>
                            <input type="hidden" name="added_by" value="{{ Auth::user()->id }}" class="form-control" /><br>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Naujas komentaras: </strong>
                                <textarea name="comment" class="form-control" ></textarea> <br>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-success" >Pridėti komentarą</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection