@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Editar cupón</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($tarifa, ['route' => ['cupones.update', $tarifa], 'method' => 'put']) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('comercio', 'Comercio', ['class' => 'form-label']) !!}
                            {!! Form::select('comercio', $comercios->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        {{-- <div class="form-group col-12 col-md-4">
                            {!! Form::label('pais', 'Visible en', ['class' => 'form-label']) !!}
                            {!! Form::select('pais', $paises->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div> --}}
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('estado', 'Estado', ['class' => 'form-label']) !!}
                            {!! Form::select('estado', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('destacada', 'Destacada', ['class' => 'form-label']) !!}
                            {!! Form::select('destacada', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('tipoCupon', 'Tipo de cupón', ['class' => 'form-label']) !!}
                            {!! Form::select('tipoCupon', $tipoCupon->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('titulo', 'Título', ['class' => 'form-label']) !!}
                            {!! Form::text('titulo', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('descripcion', 'Descripción', ['class' => 'form-label']) !!}
                            {!! Form::text('descripcion', null, [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('label', 'Promoción', ['class' => 'form-label']) !!}
                            {!! Form::text('label', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div id="field_codigo_cupon" class="form-group col-12 col-md-4">
                            {!! Form::label('CodigoCupon', 'Codigo del cupón', ['class' => 'form-label']) !!}
                            {!! Form::text('CodigoCupon', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        {{-- <div class="form-group col-12 col-md-4">
                            {!! Form::label('source', 'Source', ['class' => 'form-label']) !!}
                            {!! Form::text('source', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div> --}}
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('url', 'Url de cupón', ['class' => 'form-label']) !!}
                            {!! Form::text('url', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        {{-- <div class="form-group col-12 col-md-4">
                            {!! Form::label('url', 'Url', ['class' => 'form-label']) !!}
                            {!! Form::text('url', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('merchant_home_page', 'Merchant home page', ['class' => 'form-label']) !!}
                            {!! Form::text('merchant_home_page', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('deeplink', 'Deeplink', ['class' => 'form-label']) !!}
                            {!! Form::text('deeplink', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div> --}}
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('TiempoCupon', '¿Tiene expiración?', ['class' => 'form-label']) !!}
                            {!! Form::select('TiempoCupon', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div id="field_fecha_inicial" class="form-group col-12 col-md-4">
                            {!! Form::label('fecha_inicial', 'Fecha inicial', ['class' => 'form-label']) !!}
                            {!! Form::date('fecha_inicial', \Carbon\Carbon::parse($tarifa->fecha_inicial)->format('Y-m-d'), [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div id="field_fecha_final" class="form-group col-12 col-md-4">
                            {!! Form::label('fecha_final', 'Fecha final', ['class' => 'form-label']) !!}
                            {!! Form::date('fecha_final', \Carbon\Carbon::parse($tarifa->fecha_final)->format('Y-m-d'), [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('textoAdicional', 'Texto adicional', ['class' => 'form-label']) !!}
                            {!! Form::textarea('textoAdicional', null, ['class' => 'form-control editor', 'rows' => 2]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {!! Form::submit('Actualizar', ['class' => 'btn btn-primary', 'id' => 'btn-save']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
