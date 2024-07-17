@extends('layouts.app')
@section('content')
    <div class="row my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Ajustar Footer de página web</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($data, ['route' => ['paginaweb.update', $data], 'method' => 'put']) !!}
                    <div class="row">
                        {!! Form::hidden("pais", $pais, [
                                    'class' => 'form-control',
                                ]) !!}
                        @foreach (range(1, 5) as $numero)
                            <div class="form-group col-12 col-md-6">
                                {!! Form::label("titulo_$numero", "Título link $numero", ['class' => 'form-label']) !!}
                                {!! Form::text("titulo_$numero", null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-6">
                                {!! Form::label("enlace_$numero", "Enlace link $numero", ['class' => 'form-label']) !!}
                                {!! Form::text("enlace_$numero", null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{ Form::submit('Guardar', ['class' => 'btn btn-primary']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-12">
                <a href="{{ route('paises.index') }}" class="btn btn-dark">Volver</a>
            </div>
        </div>
    </div>
@endsection
