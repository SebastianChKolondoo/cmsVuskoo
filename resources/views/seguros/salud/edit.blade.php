@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Editar tarifa</h2>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    <a class="btn btn-warning mb-3" target="_blank" href="{{ url('https://www.vuskoo.com/'.$oferta->paises->codigo.'/seguros/comparador-tarifas-seguros-salud/' . $oferta->slug_tarifa . '-' . $oferta->id) }}">Ver oferta en vuskoo.com</a>
                    {!! Form::model($oferta, [
                        'route' => ['segurossalud.update', $oferta],
                        'method' => 'put',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('proveedor', 'Proveedor', ['class' => 'form-label']) !!}
                            {!! Form::select('proveedor', $proveedores->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-8">
                            {!! Form::label('slug_tarifa', 'Slug de la tarifa', ['class' => 'form-label']) !!}
                            {!! Form::text('slug_tarifa', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('selector_1', 'Tiempo', ['class' => 'form-label']) !!}
                            {!! Form::text('selector_1', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('precio_1', 'Precio', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_1', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('divisa_1', 'Divisa', ['class' => 'form-label']) !!}
                            {!! Form::text('divisa_1', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('selector_2', 'Tiempo', ['class' => 'form-label']) !!}
                            {!! Form::text('selector_2', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('precio_2', 'Precio', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_2', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('divisa_2', 'Divisa', ['class' => 'form-label']) !!}
                            {!! Form::text('divisa_2', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        {{-- <div class="form-group col-12 col-md-4">
                            {!! Form::label('funcion_api', 'Función api', ['class' => 'form-label']) !!}
                            {!! Form::text('funcion_api', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div> --}}
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('parrilla_1', 'parrilla_1', ['class' => 'form-label']) !!}
                            {!! Form::text('parrilla_1', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('parrilla_2', 'parrilla_2', ['class' => 'form-label']) !!}
                            {!! Form::text('parrilla_2', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('parrilla_3', 'parrilla_3', ['class' => 'form-label']) !!}
                            {!! Form::text('parrilla_3', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('parrilla_4', 'parrilla_4', ['class' => 'form-label']) !!}
                            {!! Form::text('parrilla_4', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('copago', 'Copago', ['class' => 'form-label']) !!}
                            {!! Form::select('copago', $estados->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('url_redirct', 'url_redirct', ['class' => 'form-label']) !!}
                            {!! Form::text('url_redirct', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('destacada', 'destacada', ['class' => 'form-label']) !!}
                            {!! Form::select('destacada', $estados->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('estado', 'Activo', ['class' => 'form-label']) !!}
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
            <a href="{{ route('segurossalud.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
