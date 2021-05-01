@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><div style="float: left"> {{ __('Naujo vartotojo pridėjimas') }} </div> 
                <div style="float: right">
                    <a class="btn btn-primary" href="{{ route('users.index') }}" > <i class="fas fa-arrow-left"></i> </a> 
                </div>
            </div>

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

                    <form action="{{ route('users.store') }}" method="POST">

                        @csrf
                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Organizacija: </strong><br>
                                <select id="organization_id" class="form_control" name="organization_id">

                                    @foreach ($organizations->all() as $org)
                                        <option value="{{ $org->id }}" >{{ $org->name }}</option>
                                    @endforeach

                                </select><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Vardas: </strong>
                                <input type="text" name="name" class="form-control"  /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> El. paštas: </strong>
                                <input type="email" class="form-control" name="email"/><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <strong> Slaptažodis: </strong>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" /><br>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" >Pridėti</button>
                            </div>
                            <input type="hidden" name="avatar" value="default.jpg" class="form-control">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    

</script>

@endsection

