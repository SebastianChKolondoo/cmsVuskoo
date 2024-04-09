@extends('layouts.app')
@section('content')
    @can('streaming.view.btn-create')
        <div class="row justify-content-center my-4">
            <div class="col-12">
                @if (session('info'))
                    <div class="alert alert-success">
                        {{ session('info') }}
                    </div>
                @endif
                <a href="{{ route('streaming.create') }}" class="btn btn-primary">Nueva streaming</a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-12">
            <h4>Listado de streaming</h4>
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
                        <th>Plataforma</th>
                        <th>Visible en</th>
                        @can('streaming.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dato)
                        <tr>
                            <td class="align-middle">{{ $dato->id }}</td>
                            <td class="align-middle">{{ $dato->state->name ?? 'Not Available' }}</td>
                            <td class="align-middle">{{ $dato->nombre_tarifa }}</td>
                            <td class="align-middle">{{ optional($dato->paises)->nombre }}</td>
                            <td>
                                @can('streaming.view.btn-edit')
                                    <a href="{{ route('streaming.edit', $dato) }}" class="btn btn-primary">Editar</a>
                                @endcan
                                {{-- @can('streaming.view.btn-duplicate')
                        <a href="{{ route('streamingDuplicate', $dato) }}" class="btn btn-warning">Duplicar</a>
                        @endcan --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <table id="parrillastreamingTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Plataforma</th>
                        <th>Visible en</th>
                        @can('streaming.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dato)
                        @if ($dato->estado == 1)
                            <tr>
                                <td class="align-middle">{{ $dato->id }}</td>
                                <td class="align-middle">{{ $dato->nombre_tarifa }}</td>
                                <td class="align-middle">{{ optional($dato->paises)->nombre }}</td>
                                <td>
                                    @can('streaming.view.btn-edit')
                                        <a href="{{ route('streaming.edit', $dato) }}" class="btn btn-primary">Editar</a>
                                    @endcan
                                    {{-- @can('streaming.view.btn-duplicate')
                        <a href="{{ route('streamingDuplicate', $dato) }}" class="btn btn-warning">Duplicar</a>
                        @endcan --}}
                                </td>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
            <table id="parrillastreamingTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Plataforma</th>
                        <th>Visible en</th>
                        @can('streaming.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $dato)
                        @if ($dato->estado == 2)
                            <tr>
                                <td class="align-middle">{{ $dato->id }}</td>
                                <td class="align-middle">{{ $dato->nombre_tarifa }}</td>
                                <td class="align-middle">{{ optional($dato->paises)->nombre }}</td>
                                <td>
                                    @can('streaming.view.btn-edit')
                                        <a href="{{ route('streaming.edit', $dato) }}" class="btn btn-primary">Editar</a>
                                    @endcan
                                    {{-- @can('movil.view.btn-duplicate')
                        <a href="{{ route('streamingDuplicate', $dato) }}" class="btn btn-warning">Duplicar</a>
                        @endcan --}}
                                </td>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
