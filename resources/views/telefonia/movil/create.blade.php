@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar oferta móvil</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'parrillamovil.store']) !!}
                    <div class="row">
                        <div class="form-group col-4">
                            {!! Form::label('operadora', 'Operadora', ['class' => 'form-label']) !!}
                            {!! Form::select('operadora', $operadoras->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('estado', 'Estado', ['class' => 'form-label']) !!}
                            {!! Form::select('estado', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('destacada', 'Destacada', ['class' => 'form-label']) !!}
                            {!! Form::select('destacada', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('nombre_tarifa', 'Nombre de la tarifa', ['class' => 'form-label']) !!}
                            {!! Form::text('nombre_tarifa', null, [
                                'class' => 'form-control',
                                'placeholder' => 'nombre de la tarifa',
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('parrilla_bloque_1', 'característica #1', ['class' => 'form-label']) !!}
                            {!! Form::textarea('parrilla_bloque_1', null, [
                                'class' => 'form-control',
                                
                                'rows' => 2,
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('parrilla_bloque_2', 'característica #2', ['class' => 'form-label']) !!}
                            {!! Form::textarea('parrilla_bloque_2', null, [
                                'class' => 'form-control',
                                
                                'rows' => 2,
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('parrilla_bloque_3', 'característica #3', ['class' => 'form-label']) !!}
                            {!! Form::textarea('parrilla_bloque_3', null, [
                                'class' => 'form-control',
                                
                                'rows' => 2,
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('parrilla_bloque_4', 'característica #4', ['class' => 'form-label']) !!}
                            {!! Form::textarea('parrilla_bloque_4', null, [
                                'class' => 'form-control',
                               
                                'rows' => 2,
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('meses_permanencia', 'Meses permanencia', ['class' => 'form-label']) !!}
                            {!! Form::selectRange('meses_permanencia', 0, 12, null, [
                                'class' => 'form-control',
                            ]) !!}

                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('precio', ' Precio', ['class' => 'form-label']) !!}
                            {!! Form::text('precio', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('precio_final', 'Precio final', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_final', null, [
                                'class' => 'form-control',
                                
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('num_meses_promo', 'meses de promoción', ['class' => 'form-label']) !!}
                            {!! Form::selectRange('num_meses_promo', 0, 12, null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('promocion', 'Promoción', ['class' => 'form-label']) !!}
                            {!! Form::text('promocion', null, [
                                'class' => 'form-control',

                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label(' GB', 'GB', ['class' => 'form-label']) !!}
                            {!! Form::text('GB', null, ['class' => 'form-control', 'placeholder' => 'GB oferta']) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('llamadas_ilimitadas', 'llamadas ilimitadas', ['class' => 'form-label']) !!}
                            {!! Form::select('llamdas_ilimitadas', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('coste_llamadas_minuto', 'Coste llamadas minuto', ['class' => 'form-label']) !!}
                            {!! Form::text('coste_llamadas_minuto', null, [
                                'class' => 'form-control',
                                
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('coste_establecimiento_llamada', 'Coste establecimiento llamada', ['class' => 'form-label']) !!}
                            {!! Form::text('coste_establecimiento_llamada', null, [
                                'class' => 'form-control',
                                
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('num_minutos_gratis', 'Minutos gratis', ['class' => 'form-label']) !!}
                            {!! Form::text('num_minutos_gratis', null, [
                                'class' => 'form-control',
                                
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('fecha_expiracion', 'Fecha expiración', ['class' => 'form-label']) !!}
                            {!! Form::date('fecha_expiracion', \Carbon\Carbon::now(), [
                                'class' => 'form-control',
                                
                            ]) !!}
                        </div>
                        <div class="form-group col-4">
                            {!! Form::label('pais', 'Visible en', ['class' => 'form-label']) !!}
                            {!! Form::select('pais', $paises->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="col-12">
                            {!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        @endsection
