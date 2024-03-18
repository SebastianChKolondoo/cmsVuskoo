@extends('layouts.app')
@section('content')
    @can('operadoras.view.btn-create')
        <div class="row justify-content-center my-4">
            <div class="col-12">
                @if (session('info'))
                    <div class="alert alert-success">
                        {{ session('info') }}
                    </div>
                @endif
                <a href="{{ route('parrillafibramovil.create') }}" class="btn btn-primary">Nueva Oferta</a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-12">
            <h4>Listado de fibra y móvil</h4>
        </div>
    </div>
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1"
                aria-selected="true">Todas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2"
                aria-selected="false">Activas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3"
                aria-selected="false">Inactivas</a>
        </li>
    </ul>
    <div class="tab-content p-3 bg-white">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <table id="TodaslTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Estado</th>
                        <th>Operadora</th>
                        <th>Oferta</th>
                        <th>Visible en</th>
                        @can('fibramovil.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $tarifa)
                        <tr>
                            <td class="align-middle">{{ $tarifa->id }}</td>
                            <td class="align-middle">{{ $tarifa->state->name ?? 'Not Available' }}</td>
                            <td class="align-middle">{{ $tarifa->operadoras->nombre ?? 'Not Available' }}</td>
                            <td class="align-middle">{{ $tarifa->nombre_tarifa }}</td>
                            <td class="align-middle">{{ $tarifa->pais }}</td>
                            <td>
                                @can('fibramovil.view.btn-edit')
                                    <a href="{{ route('parrillafibramovil.edit', $tarifa) }}" class="btn btn-primary">Editar</a>
                                @endcan
                                @can('fibramovil.view.btn-duplicate')
                                    <a href="{{ route('parrillafibramovilDuplicate', $tarifa) }}"
                                        class="btn btn-warning">Duplicar</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <table id="ActivasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Operadora</th>
                        <th>Oferta</th>
                        <th>Visible en</th>
                        @can('fibramovil.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $tarifa)
                        @if ($tarifa->estado == 1)
                            <tr>
                                <td class="align-middle">{{ $tarifa->id }}</td>
                                <td class="align-middle">{{ $tarifa->operadoras->nombre ?? 'Not Available' }}</td>
                                <td class="align-middle">{{ $tarifa->nombre_tarifa }}</td>
                                <td class="align-middle">{{ $tarifa->pais }}</td>
                                <td>
                                    @can('fibramovil.view.btn-edit')
                                        <a href="{{ route('parrillafibramovil.edit', $tarifa) }}"
                                            class="btn btn-primary">Editar</a>
                                    @endcan
                                    @can('fibramovil.view.btn-duplicate')
                                        <a href="{{ route('parrillafibramovilDuplicate', $tarifa) }}"
                                            class="btn btn-warning">Duplicar</a>
                                    @endcan
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
            <table id="InactivasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Operadora</th>
                        <th>Oferta</th>
                        <th>Visible en</th>
                        @can('fibramovil.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $tarifa)
                        @if ($tarifa->estado == 2)
                            <tr>
                                <td class="align-middle">{{ $tarifa->id }}</td>
                                <td class="align-middle">{{ $tarifa->operadoras->nombre ?? 'Not Available' }}</td>
                                <td class="align-middle">{{ $tarifa->nombre_tarifa }}</td>
                                <td class="align-middle">{{ $tarifa->pais }}</td>
                                <td>
                                    @can('fibramovil.view.btn-edit')
                                        <a href="{{ route('parrillafibramovil.edit', $tarifa) }}"
                                            class="btn btn-primary">Editar</a>
                                    @endcan
                                    @can('fibramovil.view.btn-duplicate')
                                        <a href="{{ route('parrillafibramovilDuplicate', $tarifa) }}"
                                            class="btn btn-warning">Duplicar</a>
                                    @endcan
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
