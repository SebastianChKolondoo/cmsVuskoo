@extends('layouts.app')
@section('content')
    <div class="row my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar pais </h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'paises.store']) !!}
                    <div class="row">
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
                            {{ Form::submit('Crear', ['class' => 'btn btn-primary']) }}
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
