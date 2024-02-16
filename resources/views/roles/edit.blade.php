@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Editar de rol</h2>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($rol, ['route' => ['roles.update', $rol], 'method' => 'put']) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Rol', ['class' => 'form-label']) !!}
                        {!! Form::text('name', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Rol',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    @foreach ($permisos as $permiso)
                        <div>
                            <label>
                                {!! Form::checkbox('permisos[]', $permiso->id, null, ['class' => 'my-1']) !!}
                                {{ $permiso->name }}
                            </label>
                        </div>
                    @endforeach
                    {!! Form::submit('Guardar', ['class' => 'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-12 mt-3">
            <a href="{{ route('roles.index', $permiso) }}" class="btn btn-light">Volver</a>
        </div>
    </div>
@endsection
