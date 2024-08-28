@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar oferta de banco</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'prestamos.store']) !!}
                    <div class="row">
                        <div class="row">
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('categoria', 'Categoria', ['class' => 'form-label']) !!}
                                {!! Form::select('categoria', $categorias->pluck('nombre', 'id'), null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('banca', 'Banco', ['class' => 'form-label']) !!}
                                {!! Form::select('banca', $operadorasList, null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            {{-- <div class="form-group col-12 col-md-4">
                                {!! Form::label('banca', 'Prestadora', ['class' => 'form-label']) !!}
                                {!! Form::select('banca', $prestadoras->pluck('nombre', 'id'), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div> --}}
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('titulo', 'Titulo', ['class' => 'form-label']) !!}
                                {!! Form::text('titulo', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('selector1', 'Selector', ['class' => 'form-label']) !!}
                                {!! Form::text('selector1', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('valorMaximo', 'valor Máximo', ['class' => 'form-label']) !!}
                                {!! Form::number('valorMaximo', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('parrilla_1', 'Parrilla 1', ['class' => 'form-label']) !!}
                                {!! Form::text('parrilla_1', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('parrilla_2', 'Parrilla 2', ['class' => 'form-label']) !!}
                                {!! Form::text('parrilla_2', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('parrilla_3', 'Parrilla 3', ['class' => 'form-label']) !!}
                                {!! Form::text('parrilla_3', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('parrilla_4', 'Parrilla 4', ['class' => 'form-label']) !!}
                                {!! Form::text('parrilla_4', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('url_redirct', 'Url redirección', ['class' => 'form-label']) !!}
                                {!! Form::text('url_redirct', null, [
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
                                {!! Form::label('estado', 'Estado', ['class' => 'form-label']) !!}
                                {!! Form::select('estado', $states->pluck('name', 'id'), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('emisor', 'Emisor', ['class' => 'form-label']) !!}
                                {!! Form::select('emisor', ['' => 'Seleccione...'] + $emisor->pluck('nombre', 'id')->toArray(), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <hr>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('inteses_anual', 'Interés anual (E.A)', ['class' => 'form-label']) !!}
                                {!! Form::text('inteses_anual', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('interes_mensual', 'Interés mensual', ['class' => 'form-label']) !!}
                                {!! Form::text('interes_mensual', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('ingresos_minimos', 'Ingresos mínimos', ['class' => 'form-label']) !!}
                                {!! Form::text('ingresos_minimos', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('descuento_comercio', 'Descuentos en comercios', ['class' => 'form-label']) !!}
                                {!! Form::select('descuento_comercio', $Sino->pluck('name', 'id'), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('apertura_cuenta', 'Apertura de cuenta', ['class' => 'form-label']) !!}
                                {!! Form::select('apertura_cuenta', $Sino->pluck('name', 'id'), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('disposicion_efectivo', 'Disposición gratuita de efectivo', ['class' => 'form-label']) !!}
                                {!! Form::select('disposicion_efectivo', $Sino->pluck('name', 'id'), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('cajeros', '¿Tiene cajeros?', ['class' => 'form-label']) !!}
                                {!! Form::select('cajeros', $Sino->pluck('name', 'id'), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('red_cajeros', 'Red  de cajeros', ['class' => 'form-label']) !!}
                                {!! Form::text('red_cajeros', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('retiros_costo', 'Retiros con costo', ['class' => 'form-label']) !!}
                                {!! Form::text('retiros_costo', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('avance_cajero', 'Avance en cajero', ['class' => 'form-label']) !!}
                                {!! Form::text('avance_cajero', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('avance_oficina', 'Avance en oficina', ['class' => 'form-label']) !!}
                                {!! Form::text('avance_oficina', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('cashback', 'Cashback', ['class' => 'form-label']) !!}
                                {!! Form::text('cashback', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('cuota_manejo_1', 'Cuota de manejo', ['class' => 'form-label']) !!}
                                {!! Form::text('cuota_manejo_1', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('cuota_manejo_2', 'Cuota de manejo 2', ['class' => 'form-label']) !!}
                                {!! Form::text('cuota_manejo_2', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('cuota_manejo_3', 'Cuota de manejo 3', ['class' => 'form-label']) !!}
                                {!! Form::text('cuota_manejo_3', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('programa_puntos', 'Programa de puntos', ['class' => 'form-label']) !!}
                                {!! Form::text('programa_puntos', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('compras_extranjero', 'Compras en el extranjero', ['class' => 'form-label']) !!}
                                {!! Form::select('compras_extranjero', $Sino->pluck('name', 'id'), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('reposicion_tarjeta', 'Reposición de tarjeta', ['class' => 'form-label']) !!}
                                {!! Form::select('reposicion_tarjeta', $Sino->pluck('name', 'id'), null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
