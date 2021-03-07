@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><div style="float: left"> {{ __('Naujo kliento kontakto pridėjimas') }} </div> <div style="float: right"> <a class="btn btn-primary" href="{{ route('clients.show', $_GET['client']) }}" > {{ __('Grįžti') }} </a> </div> </div>

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

                    <form action="{{ route('contacts.store') }}" method="POST">

                        @csrf
                        <div class="row">
                            <input type="hidden" name="client_id" value="{{ $_GET['client'] }}" class="form-control"  /><br>
                            <input type="hidden" name="added_by" value="{{ Auth::user()->id }}" class="form-control"  /><br>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Vardas: </strong>
                                <input type="text" name="contact_name" class="form-control" /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Pareigos: </strong>
                                <input type="text" name="position" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> El. paštas: </strong>
                                <input type="text" name="email" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Telefono numeris: </strong>
                                <input type="text" name="phone_no" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" >Sukurti</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection