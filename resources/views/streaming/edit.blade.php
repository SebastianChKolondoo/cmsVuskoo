@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Editar oferta streaming</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($streaming, ['route' => ['streaming.update', $streaming], 'method' => 'put']) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('nombre_tarifa', 'Nombre plataforma', ['class' => 'form-label']) !!}
                            {!! Form::text('nombre_tarifa', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {{ Form::label('logo', 'logo') }}
                            @if (!empty($streaming->logo))
                                <a href="{{ $streaming->logo }}" target="_blank">ver logo</a>
                            @endif
                            {{ Form::file('logo', ['class' => 'form-control']) }}
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
                            {!! Form::label('landingLead', 'Url redirección ', ['class' => 'form-label']) !!}
                            {!! Form::text('landingLead', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('categoria', 'Categoria ', ['class' => 'form-label']) !!}
                            {!! Form::text('categoria', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('recomendaciones', 'Recomendaciones', ['class' => 'form-label']) !!}
                            {!! Form::textarea('recomendaciones', null, [
                                'class' => 'form-control',
                                'rows' => 2
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('titulo_relativo_1', 'Titulo relativo #1', ['class' => 'form-label']) !!}
                            {!! Form::text('titulo_relativo_1', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('precio_relativo_1', 'Precio titulo relativo #1', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_relativo_1', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('titulo_relativo_2', 'Titulo relativo #2', ['class' => 'form-label']) !!}
                            {!! Form::text('titulo_relativo_2', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('precio_relativo_2', 'Precio titulo relativo #2', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_relativo_2', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('titulo_relativo_3', 'Titulo relativo #3', ['class' => 'form-label']) !!}
                            {!! Form::text('titulo_relativo_3', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('precio_relativo_3', 'Precio titulo relativo #3', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_relativo_3', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('parrilla_bloque_1', 'característica #1', ['class' => 'form-label']) !!}
                            {!! Form::text('parrilla_bloque_1', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('precio_parrilla_bloque_1', 'Precio característica #1', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_parrilla_bloque_1', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('parrilla_bloque_2', 'característica #2', ['class' => 'form-label']) !!}
                            {!! Form::text('parrilla_bloque_2', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('precio_parrilla_bloque_2', 'Precio característica #2', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_parrilla_bloque_2', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('parrilla_bloque_3', 'característica #3', ['class' => 'form-label']) !!}
                            {!! Form::text('parrilla_bloque_3', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('precio_parrilla_bloque_3', 'Precio característica #3', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_parrilla_bloque_3', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('parrilla_bloque_4', 'característica #4', ['class' => 'form-label']) !!}
                            {!! Form::text('parrilla_bloque_4', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('precio_parrilla_bloque_4', 'Precio característica #4', ['class' => 'form-label']) !!}
                            {!! Form::text('precio_parrilla_bloque_4', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('permanencia', 'Meses permanencia', ['class' => 'form-label']) !!}
                            {!! Form::selectRange('permanencia', 0, 12, null, [
                                'class' => 'form-control',
                            ]) !!}

                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('promocion', 'Promoción', ['class' => 'form-label']) !!}
                            {!! Form::text('promocion', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('fecha_expiracion', 'Fecha expiración', ['class' => 'form-label']) !!}
                            {!! Form::date('fecha_expiracion', \Carbon\Carbon::now(), [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-6">
                            {!! Form::label('pais', 'Visible en', ['class' => 'form-label']) !!}
                            {!! Form::select('pais', $paises->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {!! Form::submit('Guardar cambios', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
