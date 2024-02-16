@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
        </div>
        <div class="col-12 col-md-6">
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
                    <div class="form-group">
                        {!! Form::label('numberDocument', 'Número de documento', ['class' => 'form-label']) !!}
                        {!! Form::text('numberDocument', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Número de documento',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('name', 'Nombres', ['class' => 'form-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombres', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('lastname', 'Apellido', ['class' => 'form-label']) !!}
                        {!! Form::text('lastname', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Apellidos',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'Email', ['class' => 'form-label']) !!}
                        {!! Form::email('email', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Email',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    @foreach ($roles as $role)
                        <div>
                            <label>
                                {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'my-1']) !!}
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                    {!! Form::submit('Guardar', ['class' => 'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
