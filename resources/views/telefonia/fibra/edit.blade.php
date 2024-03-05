@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Editar oferta fibra</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($tarifa, ['route' => ['parrillafibra.update', $tarifa], 'method' => 'put']) !!}
                    <div class="form-group">
                        {!! Form::label('operadora', 'Operadora', ['class' => 'form-label']) !!}
                        {!! Form::select('operadora', $operadoras->pluck('nombre', 'id'), null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('estado', 'Estado', ['class' => 'form-label']) !!}
                        @foreach ($states as $state)
                            <div>
                                <label>
                                    {!! Form::radio('estado', $state->id, null, ['class' => 'my-1', 'required' => 'required']) !!}
                                    {{ $state->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        {!! Form::label('nombre_tarifa', 'Nombre de la tarifa', ['class' => 'form-label']) !!}
                        {!! Form::text('nombre_tarifa', null, [
                            'class' => 'form-control',
                            'placeholder' => 'nombre de la tarifa',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('parrilla_bloque_1', 'característica #1', ['class' => 'form-label']) !!}
                        {!! Form::textarea('parrilla_bloque_1', null, [
                            'class' => 'form-control',
                            'placeholder' => 'característica #1',
                            'rows' => 2,
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('parrilla_bloque_2', 'característica #2', ['class' => 'form-label']) !!}
                        {!! Form::textarea('parrilla_bloque_2', null, [
                            'class' => 'form-control',
                            'placeholder' => 'característica #2',
                            'rows' => 2,
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('parrilla_bloque_3', 'característica #3', ['class' => 'form-label']) !!}
                        {!! Form::textarea('parrilla_bloque_3', null, [
                            'class' => 'form-control',
                            'placeholder' => 'característica #3',
                            'rows' => 2,
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('parrilla_bloque_4', 'característica #4', ['class' => 'form-label']) !!}
                        {!! Form::textarea('parrilla_bloque_4', null, [
                            'class' => 'form-control',
                            'placeholder' => 'característica #4',
                            'rows' => 2,
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('meses_permanencia', 'Meses permanencia', ['class' => 'form-label']) !!}
                        {!! Form::selectRange('meses_permanencia', 0, 12, null, [
                            'class' => 'form-control',
                        ]) !!}

                    </div>
                    <div class="form-group">
                        {!! Form::label('precio', ' Precio', ['class' => 'form-label']) !!}
                        {!! Form::text('precio', null, ['class' => 'form-control', 'placeholder' => 'precio']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('precio_final', 'Precio final', ['class' => 'form-label']) !!}
                        {!! Form::text('precio_final', null, [
                            'class' => 'form-control',
                            'placeholder' => 'precio_final',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('num_meses_promo', 'meses de promoción', ['class' => 'form-label']) !!}
                        {!! Form::selectRange('num_meses_promo', 0, 12, null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('promocion', 'Promoción', ['class' => 'form-label']) !!}
                        {!! Form::text('promocion', null, [
                            'class' => 'form-control',
                            'placeholder' => 'promocion',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('MB_subida', 'Megas subida', ['class' => 'form-label']) !!}
                        {!! Form::number('MB_subida', null, ['class' => 'form-control', 'placeholder' => 'Megas subida']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('MB_bajada', 'Megas descarga', ['class' => 'form-label']) !!}
                        {!! Form::text('MB_bajada', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Megas descarga',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('tlf_fijo', 'Teléfono fijo', ['class' => 'form-label']) !!}
                        @foreach ($states as $state)
                            <div>
                                <label>
                                    {!! Form::radio('tlf_fijo', $state->id, 2, ['class' => 'my-1']) !!}
                                    {{ $state->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        {!! Form::label('fecha_expiracion', 'Fecha expiración', ['class' => 'form-label']) !!}
                        {!! Form::date('fecha_expiracion', \Carbon\Carbon::now(), [
                            'class' => 'form-control',
                            'placeholder' => 'fecha de expiración',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('pais', 'Visible en', ['class' => 'form-label']) !!}
                        {!! Form::select('pais', $paises->pluck('nombre', 'id'), null, [
                            'class' => 'form-control',
                        ]) !!}
                        {!! Form::submit('Actualizar', ['class' => 'btn btn-primary mt-3']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endsection
