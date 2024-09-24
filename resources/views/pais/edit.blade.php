@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Editar pais</h2>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($pais, ['route' => ['paises.update', $pais], 'method' => 'put']) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-3">
                            {!! Form::label('codigo', 'Codigo', ['class' => 'form-label']) !!}
                            {!! Form::text('codigo', null, [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-3">
                            {!! Form::label('nombre', 'Nombre', ['class' => 'form-label']) !!}
                            {!! Form::text('nombre', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-3">
                            {!! Form::label('moneda', 'Moneda', ['class' => 'form-label']) !!}
                            {!! Form::text('moneda', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-3">
                            {!! Form::label('decimales', 'Cantidad de decimales', ['class' => 'form-label']) !!}
                            {!! Form::number('decimales', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h4>Información SEO</h4>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('lang', 'Lang', ['class' => 'form-label']) !!}
                            {!! Form::text('lang', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('locale', 'Locale', ['class' => 'form-label']) !!}
                            {!! Form::text('locale', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('language', 'Language', ['class' => 'form-label']) !!}
                            {!! Form::text('language', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('geo_region', 'Geo region', ['class' => 'form-label']) !!}
                            {!! Form::text('geo_region', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('geo_position', 'Geo position', ['class' => 'form-label']) !!}
                            {!! Form::text('geo_position', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('geo_placename', 'Geo placename', ['class' => 'form-label']) !!}
                            {!! Form::text('geo_placename', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{ Form::submit('Actualizar', ['class' => 'btn btn-primary']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <a href="{{ route('paises.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
