@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar oferta fibra, movil y TV</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'parrillafibramoviltv.store']) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('operadora', 'Operadora', ['class' => 'form-label']) !!}
                            {!! Form::select('operadora', $operadorasList, null, [
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
                            {!! Form::label('landing_link', 'Landing link', ['class' => 'form-label']) !!}
                            {!! Form::text('landing_link', null, [
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
                            {!! Form::label('duracionContrato', 'Duración del contrato', ['class' => 'form-label']) !!}
                            {!! Form::text('duracionContrato', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('nombre_tarifa', 'Nombre de la tarifa', ['class' => 'form-label']) !!}
                            {!! Form::text('nombre_tarifa', null, [
                                'class' => 'form-control',
                                'placeholder' => 'nombre de la tarifa',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        {{-- <div class="form-group col-12 col-md-4">
                            {!! Form::label('landing_link', 'Landing link', ['class' => 'form-label']) !!}
                            {!! Form::text('landing_link', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div> --}}
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
                            {!! Form::label('meses_permanencia', 'Meses permanencia', ['class' => 'form-label']) !!}
                            {!! Form::selectRange('meses_permanencia', 0, 12, null, [
                                'class' => 'form-control',
                            ]) !!}

                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('precio', ' Precio', ['class' => 'form-label']) !!}
                            {!! Form::text('precio', null, ['class' => 'form-control', 'placeholder' => 'precio']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('precio_final', 'Precio final', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_final', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('num_meses_promo', 'meses de promoción', ['class' => 'form-label']) !!}
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
                            {!! Form::label(' GB', 'GB', ['class' => 'form-label']) !!}
                            {!! Form::text('GB', null, ['class' => 'form-control', 'placeholder' => 'GB oferta']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('MB_subida', 'Megas subida', ['class' => 'form-label']) !!}
                            {!! Form::text('MB_subida', null, ['class' => 'form-control', 'placeholder' => 'Megas subida']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('MB_bajada', 'Megas descarga', ['class' => 'form-label']) !!}
                            {!! Form::text('MB_bajada', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Megas descarga',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('tlf_fijo', 'Teléfono fijo', ['class' => 'form-label']) !!}
                            {!! Form::select('tlf_fijo', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('llamadas_ilimitadas', 'llamadas ilimitadas', ['class' => 'form-label']) !!}
                            {!! Form::select('llamadas_ilimitadas', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('red5g', '5g', ['class' => 'form-label']) !!}
                            {!! Form::select('red5g', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('coste_llamadas_minuto', 'Coste llamadas minuto', ['class' => 'form-label']) !!}
                            {!! Form::text('coste_llamadas_minuto', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('coste_establecimiento_llamada', 'Coste establecimiento llamada', ['class' => 'form-label']) !!}
                            {!! Form::text('coste_establecimiento_llamada', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('num_minutos_gratis', 'Minutos gratis', ['class' => 'form-label']) !!}
                            {!! Form::text('num_minutos_gratis', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('num_lineas_adicionales', 'Lineas adicionales', ['class' => 'form-label']) !!}
                            {!! Form::text('num_lineas_adicionales', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('GB_linea_adicional', 'GB lineas adicional', ['class' => 'form-label']) !!}
                            {!! Form::text('GB_linea_adicional', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('tipo_conexion_internet', 'tipo de conexión internet', ['class' => 'form-label']) !!}
                            {!! Form::text('tipo_conexion_internet', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('TV', 'TV', ['class' => 'form-label']) !!}
                            {!! Form::select('TV', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('Netflix', 'Netflix', ['class' => 'form-label']) !!}
                            {!! Form::select('Netflix', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('HBO', 'HBO', ['class' => 'form-label']) !!}
                            {!! Form::select('HBO', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('AmazonPrime', 'AmazonPrime', ['class' => 'form-label']) !!}
                            {!! Form::select('AmazonPrime', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('Filmin', 'Filmin', ['class' => 'form-label']) !!}
                            {!! Form::select('Filmin', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('DAZN', 'DAZN', ['class' => 'form-label']) !!}
                            {!! Form::select('DAZN', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('otros_canales_TV', 'otros_canales_TV', ['class' => 'form-label']) !!}
                            {!! Form::select('otros_canales_TV', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('fecha_expiracion', 'Fecha expiración', ['class' => 'form-label']) !!}
                            {!! Form::date('fecha_expiracion', \Carbon\Carbon::now(), [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('textoAdicional', 'Texto adicional', ['class' => 'form-label']) !!}
                            {!! Form::textarea('textoAdicional', null, ['class' => 'form-control editor','rows' => 2]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12 mt-3">
                            <h2>Información para Seo</h2>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('tituloSeo', 'Título Seo', ['class' => 'form-label']) !!}
                            {!! Form::text('tituloSeo', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('descripcionSeo', 'Descripción Seo', ['class' => 'form-label']) !!}
                            {!! Form::textarea('descripcionSeo', null, ['class' => 'form-control', 'rows' => 2]) !!}
                        </div>
                        <div class="col-12">
                            <b>Información de apps ilimitadas para Colombia</b>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('appsIlimitadas', 'Apps ilimitadas', ['class' => 'form-label']) !!}
                            {!! Form::select('appsIlimitadas', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('facebook', 'Facebook', ['class' => 'form-label']) !!}
                            {!! Form::select('facebook', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('messenger', 'Messenger', ['class' => 'form-label']) !!}
                            {!! Form::select('messenger', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('waze', 'Waze', ['class' => 'form-label']) !!}
                            {!! Form::select('waze', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('whatsapp', 'Whatsapp', ['class' => 'form-label']) !!}
                            {!! Form::select('whatsapp', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('twitter', 'X(twitter)', ['class' => 'form-label']) !!}
                            {!! Form::select('twitter', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('instagram', 'Instagram', ['class' => 'form-label']) !!}
                            {!! Form::select('instagram', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('tinder', 'Tinder+', ['class' => 'form-label']) !!}
                            {!! Form::select('tinder', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('lolamusic', 'Lola Music', ['class' => 'form-label']) !!}
                            {!! Form::select('lolamusic', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="col-12">
                            {!! Form::close() !!}
                            {!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
