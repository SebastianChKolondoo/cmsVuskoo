@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Operadoras</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Total: {{ $operadoras }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Activas: {{ $operadorasOn }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Comercializadoras</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Total: {{ $comercializadoras }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Activas: {{ $comercializadorasOn }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Fibra</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Total: {{ $fibra }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Activas: {{ $fibraOn }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Móvil</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Total: {{ $movil }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Activas: {{ $movilOn }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Fibra y móvil</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Total: {{ $fibraMovil }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Activas: {{ $fibraMovilOn }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Fibra, móvil y TV</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Total: {{ $fibraMovilTv }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Activas: {{ $fibraMovilTvOn }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Luz</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Total: {{ $luz }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Activas: {{ $luzOn }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Gas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Total: {{ $gas }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Activas: {{ $gasOn }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Luz y gas</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Total: {{ $luzgas }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Activas: {{ $luzgasOn }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
