@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar operadora</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'operadoras.store']) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Nombre operadora', ['class' => 'form-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre operadora', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('logo', 'Logo', ['class' => 'form-label']) !!}
                        {!! Form::text('logo', null, ['class' => 'form-control', 'placeholder' => 'Logo']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('negativo', 'Logo negativo', ['class' => 'form-label']) !!}
                        {!! Form::text('negativo', null, ['class' => 'form-control', 'placeholder' => 'Logo negativo']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('politica', 'Nombre operadora', ['class' => 'form-label']) !!}
                        {!! Form::text('politica', null, ['class' => 'form-control', 'placeholder' => 'Enlace externo a politica de privacidad']) !!}
                    </div>
                    @foreach ($estados as $estado)
                        <div>
                            <label>
                                {!! Form::radio('estado', $estado->id, null, ['class' => 'my-1', 'required'=> 'required']) !!}
                                {{ $estado->name }}
                            </label>
                        </div>
                    @endforeach
                    {!! Form::submit('Registrar', ['class' => 'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-6">
            <a href="{{ route('operadoras.index') }}" class="btn btn-light">Volver</a>
        </div>
    </div>
@endsection
