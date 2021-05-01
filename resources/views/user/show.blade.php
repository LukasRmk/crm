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
                        <a class="btn btn-primary" href="{{ route('user.edit', $user->id) }}"><i class="far fa-edit"></i></a>
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
                                    <span>{{ ($user->user_xp < $nextLevel) ? $user->user_xp . "/" . $nextLevel : $user->user_xp}}</span>
                                  </div>
                                </div>
                                <div class="progress">
                                  <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($user->user_xp * 100) / $nextLevel }}%;"></div>
                                </div>
                            </div>

                        </div>
                        <br>

                        <div>
                            <div class="card-body shadow" style="border-radius: 25px;font-size: 14pt" >
                                <div style="float: middle;" ><b> {{ __('Periodiniai laimėjimai') }}</b></div> 
                                <i class='fas fa-medal' style='color: silver'></i>{{ count($second) }}&nbsp;&nbsp;
                                <i class='fas fa-medal' style='color: gold'></i>{{ count($first) }}&nbsp;&nbsp;
                                <i class='fas fa-medal' style='color: #CD7F32'></i>{{ count($third) }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <div>
                                <br>
                                @foreach ($achievements as $achievement)
                                    <div class="card-body shadow" style="border-radius: 25px;" >
                                        <div style="float: left" ><b>{{ $achievement->name }}</b> </div> 

                                        <div style="float: right; font-size: 20pt"> 
                                            @switch($achievement->achievement_type)
                                                @case(1) 
                                                    <i class="far fa-id-badge" style="color: #5e72e4"></i>
                                                    @break
                                                @case(2)
                                                @case(3)
                                                    <i class="fas fa-euro-sign" style="color: green" ></i>
                                                    @break
                                                @case(4)
                                                @case(5)
                                                    <i class="fas fa-phone-volume" style="color: #11cdef" ></i>
                                                    @break
                                                @case(6)
                                                @case(7)
                                                    <i class="fas fa-handshake" style="color: #115fef" ></i>
                                                    @break
                                            
                                                @default
                                                    
                                            @endswitch
                                        </div><br>
        
                                        <pre style="font-family: Open Sans, sans-serif">{{ $achievement->info }}</pre>
                                        <div class="progress-percentage">
                                            <span>{{ ($achievement->progress > $achievement->count) ? $achievement->count : $achievement->progress }} / {{ $achievement->count }}</span>
                                          </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-{{ ($achievement->progress >= $achievement->count ? 'green' : 'primary') }}" role="progressbar" style="width: {{ ($achievement->progress * 100) / $achievement->count }}%;"></div>
                                        </div>
                                    </div>
                                    <br>
                                @endforeach
                            </div>

                        </div>

                    </center>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection