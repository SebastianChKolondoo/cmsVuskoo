@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar permiso</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'permisos.store']) !!}
                    <div class="row">
                        <div class="form-group col-4">
                            {!! Form::label('name', 'Nombre permiso', ['class' => 'form-label']) !!}
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
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
                        <div class="col-12">
                            {!! Form::submit('Registar', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
