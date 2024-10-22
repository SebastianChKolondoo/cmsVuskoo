@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Editar Blog</h2>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    {!! Form::model($data, [
                        'route' => ['blog.update', $data],
                        'method' => 'put',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    <div class="row">
                        <div class="col-12">
                            <h4>Información SEO</h4>
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('seo_titulo', 'Titulo SEO', ['class' => 'form-label']) !!}
                            {!! Form::text('seo_titulo', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('seo_descripcion', 'Descripción SEO', ['class' => 'form-label']) !!}
                            {!! Form::text('seo_descripcion', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h4>Información Blog</h4>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {{ Form::label('imagen', 'imagen') }}
                            @if (!empty($data->imagen))
                                <a href="{{ $data->imagen }}" target="_blank">ver imagen</a>
                            @endif
                            {{ Form::file('imagen', ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('pais', 'Visible en', ['class' => 'form-label']) !!}
                            {!! Form::select('pais', $paises->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('destacada', 'Destacada', ['class' => 'form-label']) !!}
                            {!! Form::select('destacada', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('estado', 'Estado', ['class' => 'form-label']) !!}
                            {!! Form::select('estado', $states->pluck('name', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('url_amigable', 'URL amigable', ['class' => 'form-label']) !!}
                            {!! Form::text('url_amigable', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-4">
                            {!! Form::label('categoria', 'Categoria', ['class' => 'form-label']) !!}
                            {!! Form::select('categoria', $categorias->pluck('nombre', 'id'), null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('migapan', 'Miga de pan', ['class' => 'form-label']) !!}
                            {!! Form::text('migapan', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('titulo', 'Titulo', ['class' => 'form-label']) !!}
                            {!! Form::text('titulo', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('contenido', 'Contenido', ['class' => 'form-label']) !!}
                            {!! Form::textarea('contenido', null, [
                                'class' => 'form-control editor',
                            ]) !!}
                        </div>
                        <div class="form-group col-12 col-md-12">
                            {!! Form::label('entradilla', 'Entradilla', ['class' => 'form-label']) !!}
                            {!! Form::textarea('entradilla', null, [
                                'class' => 'form-control editor',
                            ]) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            {{ Form::submit('Actualizar', ['class' => 'btn btn-primary']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <a href="{{ route('blog.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
