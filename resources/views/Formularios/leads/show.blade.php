@extends('layouts.app')

@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12 mb-3">
            <h2>Ampliación de lead</h2>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <p class="form-label"><b>Fecha:</b> {{ $data->created_at->format('d \d\e F \d\e Y ') }}</p>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <p class="form-label"><b>Landing:</b> {{ $data->landing }}</p>
                        </div>
                        <div class="col-12 col-md-12 mb-3">
                            <p class="form-label"><b>Url Oferta:</b> {{ $data->urlOffer }}</p>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            @if ($data->operadoras)
                                <p class="form-label"><b>Compañia:</b> {{ optional($data->operadoras)->nombre }}</p>
                            @endif
                            @if ($data->comercializadoras)
                                <p class="form-label"><b>Compañia:</b> {{ optional($data->comercializadoras)->nombre }}</p>
                            @endif
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <p class="form-label"><b>ID de oferta:</b> {{ $data->idOferta }}</p>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <p class="form-label"><b>IP:</b> {{ $data->ip }}</p>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <p class="form-label"><b>Teléfono:</b> {{ $data->phone }}</p>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <p class="form-label"><b>Respuesta:</b> {{ $data->idResponse }}</p>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <p class="form-label"><b>Acepta política de privacidad:</b>
                                {{ optional($data->politicaPrivacidad)->name ?? 'No' }}</p>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <p class="form-label"><b>Acepta cesión de datos:</b>
                                {{ optional($data->cesionDatos)->name ?? 'No' }}
                            </p>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <p class="form-label"><b>Acepta comunicación comercial:</b>
                                {{ optional($data->comunicacionesComerciales)->name ?? 'No' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <a href="{{ route('formularioleads.index') }}" class="btn btn-dark">Volver</a>
        </div>
    </div>
@endsection
