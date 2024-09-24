@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Editar proveedor</h2>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($proveedor, [
                        'route' => ['proveedores.update', $proveedor],
                        'method' => 'put',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('nombre', 'Nombre', ['class' => 'form-label']) !!}
                            {!! Form::text('nombre', null, [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('nombre_slug', 'Slug', ['class' => 'form-label']) !!}
                            {!! Form::text('nombre_slug', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        {{-- <div class="form-group col-12 col-md-4">
                            {!! Form::label('funcion_api', 'Función api', ['class' => 'form-label']) !!}
                            {!! Form::text('funcion_api', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div> --}}
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('tipo_conversion', 'Tipo de conversión', ['class' => 'form-label']) !!}
                            {!! Form::text('tipo_conversion', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('politica_privacidad', 'Política de privacidad', ['class' => 'form-label']) !!}
                            {!! Form::text('politica_privacidad', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {{ Form::label('logo', 'Logo') }}
                            @if (!empty($proveedor->logo))
                                <a href="{{ $proveedor->logo }}" target="_blank">ver logo</a>
                            @endif
                            {{ Form::file('logo', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {{ Form::label('logo_negativo', 'logo negativo') }}
                            @if (!empty($proveedor->logo_negativo))
                                <a href="{{ $proveedor->logo_negativo }}" target="_blank">ver logo negativo</a>
                            @endif
                            {{ Form::file('logo_negativo', ['class' => 'form-control']) }}
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
            <a href="{{ route('proveedores.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
