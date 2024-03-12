@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            <h2>Editar permiso</h2>
        </div>
        <div class="card col-6">
            <div class="card-body">
                @if (session('info'))
                    <div class="alert alert-success">
                        {{ session('info') }}
                    </div>
                @endif
                {!! Form::model($permiso, ['route' => ['permisos.update', $permiso], 'method' => 'put']) !!}
                <div class="form-group col-12">
                    {!! Form::label('name', 'Permiso', ['class' => 'form-label']) !!}
                    {!! Form::text('name', null, [
                        'class' => 'form-control',
                        'required' => 'required',
                    ]) !!}
                </div>
                <div class="form-group col-12">
                    @foreach ($roles as $rol)
                        <div>
                            <label>
                                {!! Form::checkbox('roles[]', $rol->id, null, ['class' => 'my-1']) !!}
                                {{ $rol->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="col-12">
                    {!! Form::submit('Guardar cambios', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
