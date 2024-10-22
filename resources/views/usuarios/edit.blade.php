@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Editar usuario</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($user, ['route' => ['user.update', $user], 'method' => 'put']) !!}
                    <div class="row">
                        {{-- <div class="form-group col-12 col-md-4">
                            {!! Form::label('password', 'Contraseña', ['class' => 'form-label']) !!}
                            {!! Form::text('password', null, [
                                'class' => 'form-control',
                                'required' => 'required'
                            ]) !!}
                        </div> --}}
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('name', 'Nombres', ['class' => 'form-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombres', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('lastname', 'Apellido', ['class' => 'form-label']) !!}
                            {!! Form::text('lastname', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Apellidos',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('email', 'Email', ['class' => 'form-label']) !!}
                            {!! Form::email('email', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Email',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('roles', 'Rol', ['class' => 'form-label']) !!}
                            {!! Form::select('roles', $roles->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="col-12">
                            {!! Form::submit('Guardar cambios', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-12">
            <a href="{{ route('user.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
