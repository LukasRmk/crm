@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><div style="float: left"> <strong>{{ $sale->name }} redagavimas </div> </strong> <div style="float: right"> <a class="btn btn-primary" href="{{ route('sales.show', $sale->id) }}" > <i class="fas fa-arrow-left"></i> </a> </div> </div>

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

                    <form action="{{ route('sales.update', $sale->id) }}" method="POST">

                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Pardavimo pavadinimas: </strong>
                                <input type="text" name="name" value="{{ $sale->name }}" class="form-control" /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Aprašymas: </strong>
                                <textarea name="info" class="form-control">{{ $sale->info }}</textarea><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Kaina: </strong>
                                <input type="text" name="price" value="{{ $sale->price }}" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Langas: </strong>
                                {{ $sale->window_name }}
                                <br>
                            </div>
                            <br><br>
                            <div class="col-xs-12 col-sm-12 col-md-12" id="stage_div" >
                                <strong> Stadija: </strong>
                                {{ $sale->stage_name }}
                                <br>
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