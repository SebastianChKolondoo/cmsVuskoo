@extends('layouts.app')
@section('content')
    <div class="row my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar comercio</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'comercios.store']) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('name', 'Nombre comercio', ['class' => 'form-label']) !!}
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Nombre',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('politica_privacidad', 'Politica de privcidad', ['class' => 'form-label']) !!}
                            {!! Form::text('politica_privacidad', null, [
                                'class' => 'form-control',
                                'placeholder' => 'Enlace externo a politica de privacidad',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('estado', 'Estado', ['class' => 'form-label']) !!}
                            {!! Form::select('estado', $estados->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('pais', 'Visible en', ['class' => 'form-label']) !!}
                            {!! Form::select('pais[]', $paises->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                                'multiple' => 'multiple',
                                'id' => 'paisChange'
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('categoria', 'Categoria', ['class' => 'form-label']) !!}
                            {!! Form::select('categoria', $categorias->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::submit('Registrar', ['class' => 'btn btn-primary mt-3']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-12">
                <a href="{{ route('comercios.index') }}" class="btn btn-dark">Volver</a>
            </div>
        </div>
    </div>
@endsection
