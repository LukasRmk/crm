@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><div style="float: left"> {{ __('Naujos organizacijos kūrimas') }} </div> <div style="float: right"> <a class="btn btn-primary" href="{{ route('organizations.index') }}" > <i class="fas fa-arrow-left"></i> </a> </div> </div>

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

                    <form action="{{ route('organizations.update', $organization->id) }}" method="POST">

                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Pavadinimas: </strong>
                                <input type="text" name="name" class="form-control" value="{{ $organization->name }}" /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Organizacijos administratorius: </strong>
                                <select id="admin" class="form-control" name="admin">

                                    <option value="0" >...</option>
                                    @foreach ($users->all() as $user)
                                        <option value="{{ $user->id }}" {{ (($user->id == $organization->admin) ? 'selected' : '' ) }} >{{ $user->name }}</option>
                                    @endforeach

                                </select><br><br>
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