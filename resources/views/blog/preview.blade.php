@extends('layouts.app')
@section('content')
    <style>
        .text-title {
            color: #19467c;
            font-size: 1.8rem;
            font-weight: bolder;
        }

        .text-date {
            color: #19467c;
            font-weight: bolder;
        }
    </style>
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h5>Preview del Blog</h5>
            <h3 class="text-date">{{ $data->url_amigable }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-5 mx-auto">
            <h6 class="text-date">Titulo SEO</h6>
            <p>{{ $data->seo_titulo }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-5 mx-auto">
            <h6 class="text-date">Descripción SEO</h6>
            <p>{{ $data->seo_descripcion }}</p>
        </div>
    </div>
    <div class="container mx-auto">
        <div class="card my-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-3">
                        <span>Blog / {{ $data->migapan }}</span>
                        <img src="{{ $data->imagen }}" alt="Imagen del blog" class="img-fluid w-100 mt-3">
                    </div>
                    <div class="col-12">
                        <h2 class="text-title">{{ $data->titulo }}</h2>
                    </div>
                    <div class="col">
                        <p>{!! $data->contenido !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
