@extends('layouts.app')
@section('content')
    <div class="row my-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>Registrar menú</h2>
                </div>
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::open(['route' => 'paginawebmenu.store', 'enctype' => 'multipart/form-data']) !!}
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
                    <div class="row">
                        <div class="col-12 mb-5 d-flex justify-content-end">
                            <button class="btn btn-dark" id="additemmenu" type="button">Agregar subMenú</button>
                        </div>
                    </div>
                    <div id="contenedorItemSubmenu">
                        <div class="row nuevoSubmenu">
                            <div class="col-12 col-md-5">
                                <div class="form-group">
                                    {!! Form::label('nombresubmenu_0', 'Nombre SubMenú 1', ['class' => 'form-label']) !!}
                                    {!! Form::text('nombresubmenu_0', null, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <div class="form-group">
                                    {!! Form::label('urlsubmenu_0', 'Url SubMenú 1', ['class' => 'form-label']) !!}
                                    {!! Form::text('urlsubmenu_0', null, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="form-group">
                                    {!! Form::label('ordensubmenu_0', 'Orden SubMenú 1', ['class' => 'form-label']) !!}
                                    {!! Form::select('ordensubmenu_0', range(0, 10), 1, [
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                <a href="{{ route('paginawebmenu.index') }}" class="btn btn-dark">Volver</a>
            </div>
        </div>
    </div>
@endsection
