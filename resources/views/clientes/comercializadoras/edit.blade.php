@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Editar comercializadora</h2>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($comercializadora, [
                        'route' => ['comercializadoras.update', $comercializadora],
                        'method' => 'put',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {{ Form::label('logo', 'Logo') }}
                            @if (!empty($comercializadora->logo))
                                <a href="{{ $comercializadora->logo }}" target="_blank">ver logo</a>
                            @endif
                            {{ Form::file('logo', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {{ Form::label('logo_negativo', 'logo negativo') }}
                            @if (!empty($comercializadora->logo_negativo))
                                <a href="{{ $comercializadora->logo_negativo }}" target="_blank">ver logo negativo</a>
                            @endif
                            {{ Form::file('logo_negativo', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('nombre', 'Nombre', ['class' => 'form-label']) !!}
                            {!! Form::text('nombre', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Nombre comercializadora',
                                'required' => 'required',
                            ]) !!}
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
                    </div>

                    {{ Form::submit('Actualizar', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <a href="{{ route('comercializadoras.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
