@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><div style="float: left"> <strong>{{ $client->name }} redagavimas </div> </strong> <div style="float: right"> <a class="btn btn-primary" href="{{ route('clients.show', $client->id) }}" > {{ __('Grįžti') }} </a> </div> </div>

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

                    <form action="{{ route('clients.update', $client->id) }}" method="POST">

                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Kliento pavadinimas: </strong>
                                <input type="text" name="name" value="{{ $client->name }}" class="form-control" /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Šalis: </strong>
                                <input type="text" name="country" value="{{ $client->country }}" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Miestas: </strong>
                                <input type="text" name="town" value="{{ $client->town }}" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Adresas: </strong>
                                <input type="text" name="address" value="{{ $client->address }}" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Pašto kodas: </strong>
                                <input type="text" name="postal_code" value="{{ $client->postal_code }}" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Svetainė: </strong>
                                <input type="text" name="web" value="{{ $client->web }}" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" >Atnaujinti</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection