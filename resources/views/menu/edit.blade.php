@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Editar menú</h2>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($menu, ['route' => ['paginawebmenu.update', $menu], 'method' => 'put']) !!}
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('titulo', 'Nombre menú', ['class' => 'form-label']) !!}
                            {!! Form::text('titulo', null, [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('urlTitulo', 'Url', ['class' => 'form-label']) !!}
                            {!! Form::text('urlTitulo', null, [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('pais', 'Visible en', ['class' => 'form-label']) !!}
                            {!! Form::select('pais', $paises->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    {{ Form::submit('Actualizar', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-12 mt-5 mb-2">
            <h2>Editar Submenú</h2>
        </div>
        @foreach ($items as $item)
            <div class="col-12 my-1">
                <div class="card">
                    <div class="card-body">
                        {!! Form::model($item, ['route' => ['paginawebsubmenu.update', $item], 'method' => 'put']) !!}
                        <div class="row">
                            {!! Form::hidden('idMenu', null, [
                                'class' => 'form-control',
                                'required' => 'required',
                            ]) !!}
                            <div class="form-group col-12 col-md-5">
                                {!! Form::label('nombre', 'Nombre SubMenú', ['class' => 'form-label']) !!}
                                {!! Form::text('nombre', null, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="form-group col-12 col-md-5">
                                {!! Form::label('url', 'Url SubMenú', ['class' => 'form-label']) !!}
                                {!! Form::text('url', null, [
                                    'class' => 'form-control',
                                    'required' => 'required',
                                ]) !!}
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    {!! Form::label('orden', 'Orden SubMenú', ['class' => 'form-label']) !!}
                                    {!! Form::select('orden', range(0, 10), null, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                {{ Form::submit('Actualizar', ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <a href="{{ route('paginawebmenu.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
