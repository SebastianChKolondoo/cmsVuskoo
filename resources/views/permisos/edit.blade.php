@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Editar de permisos</h2>
        </div>
        <div class="card col">
            <div class="card-body">
                @if (session('info'))
                    <div class="alert alert-success">
                        {{ session('info') }}
                    </div>
                @endif
                {!! Form::model($permiso, ['route' => ['permisos.update', $permiso], 'method' => 'put']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Permiso', ['class' => 'form-label']) !!}
                    {!! Form::text('name', null, [
                        'class' => 'form-control',
                        'placeholder' => 'Permiso',
                        'required' => 'required',
                    ]) !!}
                </div>
                @foreach ($roles as $rol)
                    <div>
                        <label>
                            {!! Form::checkbox('roles[]', $rol->id, null, ['class' => 'my-1']) !!}
                            {{ $rol->name }}
                        </label>
                    </div>
                @endforeach
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary mt-3']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-12">
        <a href="{{ route('permisos.index', $permiso) }}" class="btn btn-light">Volver</a>
    </div>
@endsection
