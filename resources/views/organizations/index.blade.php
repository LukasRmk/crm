@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg">
            <div class="card">
                <div class="card-header"><div style="float: left"> <strong style="font-size:18pt" > {{ __('Organizacijų sąrašas') }} </strong> </div> <div style="float: right"> <a class="btn btn-primary" href="{{ route('organizations.create') }}" > <i class="fas fa-plus"></i> </a> </div> </div>

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
                                <th>Administratorius</th>
                                <th></th>
                            </tr>
                        </thead>

                        @foreach ($organizations as $organization)

                        <tr>
                            <td><a  href="{{ route('organizations.edit', $organization->id) }}">{{ $organization->name }}</a></td>
                            <td>{{ $organization->admin_name }}</td>
                            <td>
                                <form action="{{ route('organizations.destroy', $organization->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Ar tikrai norite ištrinti organizaciją?')" ><i class="far fa-trash-alt"></i></button>
                                </form> 
                            </td>
                        </tr>
                            
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection