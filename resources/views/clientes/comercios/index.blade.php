@extends('layouts.app')
@section('content')
    @can('comercios.view.btn-create')
        <div class="row justify-content-center my-4">
            <div class="col-12">
                @if (session('info'))
                    <div class="alert alert-success">
                        {{ session('info') }}
                    </div>
                @endif
                <a href="{{ route('comercios.create') }}" class="btn btn-primary">Nueva comercio</a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-12">
            <h4>Listado de comercios</h4>
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
    <!-- Tab panes -->
    <div class="tab-content p-3 bg-white">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <table id="comerciosTodasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Estado</th>
                        <th>Nombre</th>
                        <th>Pais</th>
                        @can('comercios.view.btn-edit')
                        <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comercios as $comercio)
                        <td class="align-middle">{{ $comercio->id }}</td>
                        <td class="align-middle">{{ $comercio->state->name }}</td>
                        <td class="align-middle">{{ $comercio->nombre }}</td>
                        <td class="align-middle">{{ $comercio->paises->nombre }}</td>
                        @can('comercios.view.btn-edit')
                            <td>
                                <a href="{{ route('comercios.edit', $comercio) }}" class="btn btn-primary">Editar</a>
                            </td>
                        @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <table id="comerciosActivasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Pais</th>
                        @can('comercios.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comercios as $comercio)
                        @if ($comercio->estado == 1)
                            <td class="align-middle">{{ $comercio->id }}</td>
                            <td class="align-middle">{{ $comercio->nombre }}</td>
                            <td class="align-middle">{{ $comercio->paises->nombre }}</td>
                            @can('comercios.view.btn-edit')
                                <td>
                                    <a href="{{ route('comercios.edit', $comercio) }}" class="btn btn-primary">Editar</a>
                                </td>
                            @endcan
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
            <table id="comerciosInactivasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Pais</th>
                        @can('comercios.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comercios as $comercio)
                        @if ($comercio->estado == 2)
                            <td class="align-middle">{{ $comercio->id }}</td>
                            <td class="align-middle">{{ $comercio->nombre }}</td>
                            <td class="align-middle">{{ $comercio->paises->nombre }}</td>
                            @can('comercios.view.btn-edit')
                                <td>
                                    <a href="{{ route('comercios.edit', $comercio) }}" class="btn btn-primary">Editar</a>
                                </td>
                            @endcan
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
