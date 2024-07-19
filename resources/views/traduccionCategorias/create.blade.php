@extends('layouts.app')
@section('content')
    <div class="row my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar categoria</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'categorias.store']) !!}
                    <div class="row">
                        {{-- @foreach ($paises as $pais) --}}
                            <div class="form-group col-12 col-md-4">
                                {!! Form::label("nombre", "Nombre categoria", ['class' => 'form-label']) !!}
                                {!! Form::text("nombre", null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        {{-- @endforeach --}}
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
                <a href="{{ route('categorias.index') }}" class="btn btn-dark">Volver</a>
            </div>
        </div>
    </div>
@endsection
