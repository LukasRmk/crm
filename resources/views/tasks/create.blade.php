@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><div style="float: left"> {{ __('Naujos užduoties pridėjimas') }} </div> 
                <div style="float: right">
                    @if (isset($_GET['sale']))
                        <a class="btn btn-primary" href="{{ route('sales.show', $_GET['sale']) }}" > <i class="fas fa-arrow-left"></i> </a> 
                    @else
                        <a class="btn btn-primary" href="{{ route('clients.show', $_GET['client']) }}" > <i class="fas fa-arrow-left"></i> </a> 
                    @endif 
                </div>
            </div>

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

                    <form action="{{ route('tasks.store') }}" method="POST">

                        @csrf
                        <div class="row">
                            <input type="hidden" name="client_id" value="{{ $_GET['client'] }}" class="form-control"  /><br>
                            <input type="hidden" name="added_by" value="{{ Auth::user()->id }}" class="form-control"  /><br>
                            
                            @if (isset($_GET['sale']))
                                <input type="hidden" name="sale_id" value="{{ $_GET['sale'] }}" class="form-control"  /><br>
                            @endif

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Užduoties tipas: </strong><br>
                                <select id="types" class="form_control" name="type_id">

                                    @foreach ($task_types->all() as $type)
                                        <option value="{{ $type->id }}" >{{ $type->type_name }}</option>
                                    @endforeach

                                </select><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Pavadinimas: </strong>
                                <input type="text" name="task_name" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Aprašymas: </strong>
                                <textarea name="task_description" class="form-control"> </textarea>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Laikas: </strong>
                                <input type="datetime-local" name="task_datetime" class="form-control"  /><br>
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

<script type="text/javascript">

    

</script>

@endsection

