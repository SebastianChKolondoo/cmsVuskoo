@extends('layouts.app')
@section('content')
    <div class="row my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar banco</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'bancos.store', 'enctype' => 'multipart/form-data']) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('nombre', 'Nombre', ['class' => 'form-label']) !!}
                            {!! Form::text('nombre', null, [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('telefono', 'Teléfono', ['class' => 'form-label']) !!}
                            {!! Form::text('telefono', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {{ Form::label('logo', 'Logo') }}
                            {{ Form::file('logo', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('estado', 'Estado', ['class' => 'form-label']) !!}
                            {!! Form::select('estado', $estados->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('pais', 'Visible en', ['class' => 'form-label']) !!}
                            {!! Form::select('pais', $paises->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::submit('Registrar', ['class' => 'btn btn-primary mt-3']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-12">
                <a href="{{ route('bancos.index') }}" class="btn btn-dark">Volver</a>
            </div>
        </div>
    </div>
@endsection
