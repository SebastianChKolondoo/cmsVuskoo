@extends('layouts.app')

@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Traducción de {{ $categoria->nombre }}</h2>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    @foreach ($traducciones as $traduccion)
                        {!! Form::model($traduccion, ['route' => ['traduccionCategorias.update', $traduccion], 'method' => 'put']) !!}
                        <div class="row">
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label('nombre', $traduccion->paises->nombre, ['class' => 'form-label']) !!}
                                {!! Form::text('nombre', $traduccion->nombre, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-12">
                                {{ Form::submit('Actualizar', ['class' => 'btn btn-primary']) }}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <a href="{{ route('traduccionCategorias.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
