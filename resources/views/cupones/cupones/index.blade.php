@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            @if (session('info'))
                <div class="alert alert-success">
                    {{ session('info') }}
                </div>
            @endif
            @can('cupones.view.btn-create')
                <a href="{{ route('cupones.create') }}" class="btn btn-primary">Nuevo cupón</a>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4>Listado de cupones</h4>
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
            <table id="TodasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Estado</th>
                        <th>Comercio</th>
                        <th>Nombre</th>
                        <th>Visible en</th>
                        @can('gas.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $tarifa)
                        <tr>
                            <td class="align-middle">{{ $tarifa->id }}</td>
                            <td class="align-middle">{{ $tarifa->state->name ?? 'Not Available' }}</td>
                            <td class="align-middle">{{ $tarifa->comercios->nombre ?? 'Not Available' }}</td>
                            <td class="align-middle">{{ $tarifa->label }}</td>
                            <td class="align-middle">{{ optional($tarifa->paises)->nombre }}</td>
                            <td>
                                @can('gas.view.btn-edit')
                                    <a href="{{ route('cupones.edit', $tarifa) }}" class="btn btn-primary">Editar</a>
                                @endcan
                                @can('gas.view.btn-duplicate')
                                    <a href="{{ route('cuponesDuplicate', $tarifa) }}" class="btn btn-warning">Duplicar</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <table id="activasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Comercio</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Visible en</th>
                        @can('gas.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $tarifa)
                        @if ($tarifa->estado == 1)
                            <tr>
                                <td class="align-middle">{{ $tarifa->id }}</td>
                                <td class="align-middle">{{ $tarifa->comercios->nombre ?? 'Not Available' }}</td>
                                <td class="align-middle">{{ $tarifa->nombre_tarifa }}</td>
                                <td class="align-middle">{{ optional($tarifa->categorias)->nombre }}</td>
                                <td class="align-middle">{{ optional($tarifa->paises)->nombre }}</td>
                                <td>
                                    @can('gas.view.btn-edit')
                                        <a href="{{ route('cupones.edit', $tarifa) }}" class="btn btn-primary">Editar</a>
                                    @endcan
                                    @can('gas.view.btn-duplicate')
                                        <a href="{{ route('cuponesDuplicate', $tarifa) }}" class="btn btn-warning">Duplicar</a>
                                    @endcan
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
            <table id="inactivasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Comercio</th>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Visible en</th>
                        @can('gas.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $tarifa)
                        @if ($tarifa->estado == 2)
                            <tr>
                                <td class="align-middle">{{ $tarifa->id }}</td>
                                <td class="align-middle">{{ $tarifa->comercios->nombre ?? 'Not Available' }}</td>
                                <td class="align-middle">{{ $tarifa->nombre_tarifa }}</td>
                                <td class="align-middle">{{ optional($tarifa->categorias)->nombre }}</td>
                                <td class="align-middle">{{ optional($tarifa->paises)->nombre }}</td>
                                <td>
                                    @can('gas.view.btn-edit')
                                        <a href="{{ route('cupones.edit', $tarifa) }}" class="btn btn-primary">Editar</a>
                                    @endcan
                                    @can('gas.view.btn-duplicate')
                                        <a href="{{ route('cuponesDuplicate', $tarifa) }}" class="btn btn-warning">Duplicar</a>
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
