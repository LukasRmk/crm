@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg">
            <div class="card">
                <div class="card-header"><div style="float: left"> <strong style="font-size:18pt" > {{ __('Klientų sąrašas') }} </strong> </div> <div style="float: right"> <a class="btn btn-primary" href="{{ route('clients.create') }}" > <i class="fas fa-plus"></i> </a> </div> </div>

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
                                <th>Šalis</th>
                                <th>Miestas</th>
                                <th>Adresas</th>
                            </tr>
                        </thead>

                        @foreach ($clients as $client)

                        <tr>
                            <td><a  href="{{ route('clients.show', $client->id) }}">{{ $client->name }}</a></td>
                            <td>{{ $client->country }}</td>
                            <td>{{ $client->town }}</td>
                            <td>{{ $client->address }}</td>
                        </tr>
                            
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection