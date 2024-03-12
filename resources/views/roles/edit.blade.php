@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Editar rol</h2>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($rol, ['route' => ['roles.update', $rol], 'method' => 'put']) !!}
                    <div class="form-group col-12">
                        {!! Form::label('name', 'Rol', ['class' => 'form-label']) !!}
                        {!! Form::text('name', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Rol',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="form-group col-12">
                        {{ Form::label('permisos', 'Permisos asignados') }}
                        @foreach ($permisos as $permiso)
                            <div class="form-check">
                                {{ Form::checkbox('permisos[]', $permiso->name, $rol->hasPermissionTo($permiso), ['class' => 'form-check-input']) }}
                                {{ Form::label($permiso->name, $permiso->name, ['class' => 'form-check-label']) }}
                            </div>
                        @endforeach
                    </div>

                    {{ Form::submit('Guardar cambios', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <a href="{{ route('roles.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
