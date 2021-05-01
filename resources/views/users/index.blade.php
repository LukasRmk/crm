@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg">
            <div class="card">
                <div class="card-header"><div style="float: left"> <strong style="font-size:18pt" > {{ __('Vartotojų sąrašas') }} </strong> </div> <div style="float: right"> <a class="btn btn-primary" href="{{ route('users.create') }}" > <i class="fas fa-plus"></i> </a> </div> </div>

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
                                <th></th>
                                <th>Vardas</th>
                                <th>El. paštas</th>
                                <th>Patirties taškai</th>
                                <th>Organizacija</th>
                                <th>Administratorius</th>
                                <th></th>
                            </tr>
                        </thead>

                        @foreach ($users as $user)

                        <tr>
                            <td><img src={{ asset('avatars/'.$user->avatar) }} alt='Avatar' style='width: 40px; height:40px; float:left; border-radius:50%;'></td>
                            <td><a  href="{{ route('users.adminEdit', $user->id) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->user_xp }}</td>
                            <td><a  href="{{ route('organizations.edit', $user->organization_id) }}">{{ $user->org_name }}</a></td>
                            <td>{{ $user->is_admin }}</td>
                            <td>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Ar tikrai norite ištrinti vartotoją?')" ><i class="far fa-trash-alt"></i></button>
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