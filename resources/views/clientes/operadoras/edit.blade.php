@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Editar operadora</h2>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($operadora, ['route' => ['operadoras.update', $operadora], 'method' => 'put']) !!}
                    <div class="form-group">
                        {!! Form::label('nombre', 'Nombre', ['class' => 'form-label']) !!}
                        {!! Form::text('nombre', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Nombre operadora',
                            'required' => 'required',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {{ Form::label('estado', 'Estado') }}
                        @foreach ($estados as $estado)
                            <div class="form-check">
                                {{ Form::radio('estado', $estado->id, $estado->id == $operadora->estado, ['class' => 'form-check-input']) }}
                                {{ Form::label($estado->id, $estado->name, ['class' => 'form-check-label']) }}
                            </div>
                        @endforeach
                    </div>

                    {{ Form::submit('Actualizar', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-6">
            <a href="{{ route('operadoras.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
