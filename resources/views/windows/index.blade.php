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

                    <table class="table table">
                        <thead class="thead-light">

                            <tr>
                                <th>Pavadinimas</th>
                                <th>Stadijos</th>
                            </tr>
                        </thead>

                        @foreach ($windows as $window)

                            <tr>
                                <td><a  href="{{ route('windows.edit', $window->id) }}">{{ $window->name }}</a></td>
                                <td><a class="btn btn-sm btn-success" title="Pridėti stadiją" href="{{ route('stages.create', ['window' => $window->id]) }}" ><i class="fas fa-plus"></i></a></td>
                            </tr>

                            @foreach($stages as $stage)
                                @if ($stage->window_id == $window->id)
                                    <tr style="background-color: rgb(245, 245, 245)">

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
                        
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection