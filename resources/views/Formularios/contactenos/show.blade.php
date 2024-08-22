@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Ampliación de mensaje</h2>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($data, ['route' => ['formulariocontactenos.update', $data]]) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('name', 'Nombre', ['class' => 'form-label']) !!}
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
                                'disabled' => 'true'
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('email', 'Email', ['class' => 'form-label']) !!}
                            {!! Form::email('email', null, [
                                'class' => 'form-control',
                                'disabled' => 'true'
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('created_at', 'Fecha creación', ['class' => 'form-label']) !!}
                            {!! Form::text('created_at', null, [
                                'class' => 'form-control',
                                'disabled' => 'true'
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('message', 'Mensaje', ['class' => 'form-label']) !!}
                            {!! Form::textarea('message', null, [
                                'class' => 'form-control',
                                'disabled' => 'true',
                            ]) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <a href="{{ route('formulariocontactenos.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
