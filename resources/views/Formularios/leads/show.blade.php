@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Ampliación de lead</h2>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($data, ['route' => ['formularioleads.update', $data]]) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('landing', 'Landing', ['class' => 'form-label']) !!}
                            {!! Form::text('landing', null, [
                                'class' => 'form-control',
                                'disabled' => 'true',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('urlOffer', 'Url Oferta', ['class' => 'form-label']) !!}
                            {!! Form::email('urlOffer', null, [
                                'class' => 'form-control',
                                'disabled' => 'true',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('company', 'Compañia', ['class' => 'form-label']) !!}
                            {!! Form::text('company', null, [
                                'class' => 'form-control',
                                'disabled' => 'true',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('idOferta', 'ID de oferta', ['class' => 'form-label']) !!}
                            {!! Form::text('idOferta', null, [
                                'class' => 'form-control',
                                'disabled' => 'true',
                            ]) !!}
                        </div>
                        @if ($data->ip != '')
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('ip', 'IP', ['class' => 'form-label']) !!}
                                {!! Form::text('ip', null, [
                                    'class' => 'form-control',
                                    'disabled' => 'true',
                                ]) !!}
                            </div>
                        @endif
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('phone', 'Teléfono', ['class' => 'form-label']) !!}
                            {!! Form::text('phone', null, [
                                'class' => 'form-control',
                                'disabled' => 'true',
                            ]) !!}
                        </div>
                        @if ($data->idResponse != '')
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('idResponse', 'Respuesta', ['class' => 'form-label']) !!}
                                {!! Form::text('idResponse', null, [
                                    'class' => 'form-control',
                                    'disabled' => 'true',
                                ]) !!}
                            </div>
                        @endif
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('acepta_politica_privacidad', 'Acepta política de privacidad', ['class' => 'form-label']) !!}
                            {!! Form::text('acepta_politica_privacidad', $data->politicaPrivacidad->name, [
                                'class' => 'form-control',
                                'disabled' => 'true',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('acepta_cesion_datos_a_proveedor', 'acepta cesión de datos', ['class' => 'form-label']) !!}
                            {!! Form::text('acepta_cesion_datos_a_proveedor', $data->cesionDatos->name, [
                                'class' => 'form-control',
                                'disabled' => 'true',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('acepta_comunicaciones_comerciales', 'acepta comunicación comercial', ['class' => 'form-label']) !!}
                            {!! Form::text('acepta_comunicaciones_comerciales', $data->comunicacionesComerciales->name, [
                                'class' => 'form-control',
                                'disabled' => 'true',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <a href="{{ route('formularioleads.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
