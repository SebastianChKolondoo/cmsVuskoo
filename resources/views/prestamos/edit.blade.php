@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Editar oferta de banca</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($tarifa, ['route' => ['prestamos.update', $tarifa], 'method' => 'put']) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('categoria', 'Categoria', ['class' => 'form-label']) !!}
                            {!! Form::select('categoria', $categorias->pluck('nombre','id'), null, ['class' => 'form-control']) !!}
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
