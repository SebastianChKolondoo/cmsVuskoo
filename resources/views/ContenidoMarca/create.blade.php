@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Contenido de marca</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model(['route' => ['contenidomarca.store']]) !!}
                    <div class="row">
                        {!! Form::hidden('id', $id, [
                            'class' => 'form-control',
                        ]) !!}
                        {!! Form::label('laborCampo', 'Edición de texto', ['class' => 'form-label']) !!}
                        {!! Form::textarea('laborCampo', null, [
                            'class' => 'form-control editor',
                        ]) !!}
                        <div class="col-12">
                            {!! Form::submit('Guardar información', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
