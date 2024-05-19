@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar oferta luz y gas</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'parrillaluzgas.store']) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('comercializadora', 'Comercializadora', ['class' => 'form-label']) !!}
                            {!! Form::select('comercializadora', $comercializadoras->pluck('nombre', 'id'), null, [
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
                            {!! Form::label('nombre_tarifa', 'Nombre de la tarifa', ['class' => 'form-label']) !!}
                            {!! Form::text('nombre_tarifa', null, [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('landing_link', 'Landing link', ['class' => 'form-label']) !!}
                            {!! Form::text('landing_link', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('parrilla_bloque_1', 'característica #1', ['class' => 'form-label']) !!}
                            {!! Form::textarea('parrilla_bloque_1', null, [
                                'class' => 'form-control',
                                'rows' => 2,
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('parrilla_bloque_2', 'característica #2', ['class' => 'form-label']) !!}
                            {!! Form::textarea('parrilla_bloque_2', null, [
                                'class' => 'form-control',
                                'rows' => 2,
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('parrilla_bloque_3', 'característica #3', ['class' => 'form-label']) !!}
                            {!! Form::textarea('parrilla_bloque_3', null, [
                                'class' => 'form-control',
                                'rows' => 2,
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('parrilla_bloque_4', 'característica #4', ['class' => 'form-label']) !!}
                            {!! Form::textarea('parrilla_bloque_4', null, [
                                'class' => 'form-control',
                                'rows' => 2,
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('landing_dato_adicional', 'Landing dato adicional', ['class' => 'form-label']) !!}
                            {!! Form::text('landing_dato_adicional', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('luz_discriminacion_horaria', 'Discriminación horaria', ['class' => 'form-label']) !!}
                            {!! Form::select('luz_discriminacion_horaria', $states->pluck('name', 'id'), null, [
                            'class' => 'form-control',
                        ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('meses_permanencia', 'Meses permanencia', ['class' => 'form-label']) !!}
                            {!! Form::selectRange('meses_permanencia', 0, 12, null, [
                                'class' => 'form-control',
                            ]) !!}

                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('precio', ' Precio', ['class' => 'form-label']) !!}
                            {!! Form::text('precio', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('precio_final', 'Precio final', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_final', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('luz_precio_potencia_punta', 'Precio potencia punta', ['class' => 'form-label']) !!}
                            {!! Form::text('luz_precio_potencia_punta', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('luz_precio_potencia_valle', 'Precio potencia valle', ['class' => 'form-label']) !!}
                            {!! Form::text('luz_precio_potencia_valle', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('luz_precio_energia_punta', 'Precio energía punta', ['class' => 'form-label']) !!}
                            {!! Form::text('luz_precio_energia_punta', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('luz_precio_energia_llano', 'Precio energía llano', ['class' => 'form-label']) !!}
                            {!! Form::text('luz_precio_energia_llano', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('luz_precio_energia_valle', 'Precio energía valle', ['class' => 'form-label']) !!}
                            {!! Form::text('luz_precio_energia_valle', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('luz_precio_energia_24h', 'Precio energía 24h', ['class' => 'form-label']) !!}
                            {!! Form::text('luz_precio_energia_24h', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('energia_verde', 'Energía verde', ['class' => 'form-label']) !!}
                            {!! Form::select('energia_verde', $states->pluck('name', 'id'), null, [
                            'class' => 'form-control',
                        ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('gas_tipo_precio', 'Tipo precio', ['class' => 'form-label']) !!}
                            {!! Form::text('gas_tipo_precio', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('gas_precio_termino_fijo', 'Precio gas termino fijo', ['class' => 'form-label']) !!}
                            {!! Form::text('gas_precio_termino_fijo', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('gas_precio_energia', 'Precio gas energía', ['class' => 'form-label']) !!}
                            {!! Form::text('gas_precio_energia', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('num_meses_promo', 'Meses de promoción', ['class' => 'form-label']) !!}
                            {!! Form::selectRange('num_meses_promo', 0, 12, null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('promocion', 'Promoción', ['class' => 'form-label']) !!}
                            {!! Form::text('promocion', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('fecha_expiracion', 'Fecha expiración', ['class' => 'form-label']) !!}
                            {!! Form::date('fecha_expiracion', \Carbon\Carbon::now(), [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('coste_mantenimiento', 'Coste mantenimiento', ['class' => 'form-label']) !!}
                            {!! Form::text('coste_mantenimiento', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('coste_de_gestion', 'Coste de gestión', ['class' => 'form-label']) !!}
                            {!! Form::text('coste_de_gestion', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('pais', 'Visible en', ['class' => 'form-label']) !!}
                            {!! Form::select('pais', $paises->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('textoAdicional', 'Texto adicional', ['class' => 'form-label']) !!}
                            {!! Form::textarea('textoAdicional', null, ['class' => 'form-control','rows' => 2]) !!}
                        </div>
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
