@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div style="float: left;">
                        <strong style="font-size: 16pt;" >&nbsp;Vartotojo profilis</strong> 
                    </div> 
                    <div style="float: right"> 
                        <a class="btn btn-primary" href="{{ route('user.edit', $user->id) }}">Redaguoti</a>
                    </div> 
                </div>

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
                    <div class="row">
                        <img class="shadow-lg" src="{{ URL::asset('avatars/'.$user->avatar) }}" alt="Avatar" style="margin-left: auto; margin-right: auto; width: 200px; height:200px; float:left; border-radius:50%; margin-bottom: 15px; {{ $userLevel->border }} " > 
                        <table class="table" style="table-layout: fixed;">
                            <thead class="thead-light">
                                <tr>
                                    <th>Vartotojo vardas</th>
                                    <td><strong>{{ $user->name }}</strong></td>
                                </tr>
                                <tr>
                                    <th>El. paštas</th>
                                    <td><strong>{{ $user->email }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Sistemos vartotojas nuo</th>
                                    <td><strong>{{ $user->created_at }}</strong></td>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Xp info -->
            <div class="card">
                <div class="card-header">
                    <div style="float: left;">
                        <strong style="font-size: 16pt;" >&nbsp;Pasiekimai</strong> 
                    </div> 
                </div>

                <div class="card-body">
                    <center>
                        <div style="font-size: 20pt"> 
                            Vartotojo Lygis <br>
                            <strong style="font-size: 30pt">{{ $userLevel->level }}</strong><br>

                            <div class="progress-wrapper">
                                <div class="progress-info">
                                  <div class="progress-label">
                                    <span><b>Lygio progresas</b></span>
                                  </div>
                                  <div class="progress-percentage">
                                    <span>{{ $user->user_xp }} / {{ $nextLevel }}</span>
                                  </div>
                                </div>
                                <div class="progress">
                                  <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($user->user_xp * 100) / $nextLevel }}%;"></div>
                                </div>
                            </div>

                        </div>
                    </center>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection