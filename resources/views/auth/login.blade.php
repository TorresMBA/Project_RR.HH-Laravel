@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-4 offset-md-4 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">Acceso a la Aplicacion</h1>
                </div>
            </div>
            <div class="panel-body">
                <form action="{{ route('login') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('email') ? 'alert alert-danger' : ''}}">
                        <label for="email">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Ingresa tu Email">
                        {!! $errors->first('email','<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('password') ? 'alert alert-danger' : ''}}">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Ingresa tu Password">
                        {!! $errors->first('password','<span class="help-block">:message</span>') !!}
                    </div>
                    <button class="btn btn-primary btn-block">Acceder</button>
                </form>
            </div>    
        </div>   
    </div>

@endsection
