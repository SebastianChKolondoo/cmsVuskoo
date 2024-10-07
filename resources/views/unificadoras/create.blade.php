@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar oferta de Unificadora</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'unificadoras.store']) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4 d-none">
                            {!! Form::label('categoria', 'Categoria', ['class' => 'form-label']) !!}
                            {!! Form::select('categoria', $categorias->pluck('nombre', 'id'), null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('banca', 'Banco', ['class' => 'form-label']) !!}
                            {!! Form::select('banca', $operadorasList, null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
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
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <a href="{{ route('unificadoras.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
