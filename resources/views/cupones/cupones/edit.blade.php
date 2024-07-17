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
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('pais', 'Visible en', ['class' => 'form-label']) !!}
                            {!! Form::select('pais', $paises->pluck('nombre', 'id'), null, [
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('categoria', 'Categoria', ['class' => 'form-label']) !!}
                            {!! Form::select('categoria', $categorias->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
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
                            {!! Form::label('tipoCupon', 'Tipo de cupon', ['class' => 'form-label']) !!}
                            {!! Form::select('tipoCupon', $tipoCupon->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div id="field_codigo_cupon" class="form-group col-12 col-md-4">
                            {!! Form::label('CodigoCupon', 'Código de cupón', ['class' => 'form-label']) !!}
                            {!! Form::text('CodigoCupon', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('nombre_tarifa', 'Nombre de la tarifa', ['class' => 'form-label']) !!}
                            {!! Form::text('nombre_tarifa', null, [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('landing_link', 'URL redireccion', ['class' => 'form-label']) !!}
                            {!! Form::text('landing_link', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        {{-- <div class="form-group col-12 col-md-4">
                            {!! Form::label('pagina_final', 'URL redireccion final', ['class' => 'form-label']) !!}
                            {!! Form::text('pagina_final', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div> --}}
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('descuento', 'Descuento', ['class' => 'form-label']) !!}
                            {!! Form::text('descuento', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('codigo', 'Codigo', ['class' => 'form-label']) !!}
                            {!! Form::text('codigo', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('TiempoCupon', '¿Tiene expiración?', ['class' => 'form-label']) !!}
                            {!! Form::select('TiempoCupon', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div id="field_fecha_expiracion" class="form-group col-12 col-md-4">
                            {!! Form::label('fecha_expiracion', 'Fecha expiración', ['class' => 'form-label']) !!}
                            {!! Form::date('fecha_expiracion', \Carbon\Carbon::parse($tarifa->fecha_expiracion)->format('Y-m-d'), [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('descripcion', 'Descripción', ['class' => 'form-label']) !!}
                            {!! Form::textarea('descripcion', null, [
                                'class' => 'form-control',
                                'rows' => 2,
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('textoAdicional', 'Texto adicional', ['class' => 'form-label']) !!}
                            {!! Form::textarea('textoAdicional', null, ['class' => 'form-control editor', 'rows' => 2]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
