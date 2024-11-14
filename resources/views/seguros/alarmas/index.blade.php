@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            @if (session('info'))
                <div class="alert alert-success">
                    {{ session('info') }}
                </div>
            @endif
            @can('parrillaalarmas.view.btn-create')
                <a href="{{ route('alarmas.create') }}" class="btn btn-primary">Nueva oferta</a>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4>Listado de ofertas</h4>
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
                        <th>Activo</th>
                        <th>Cliente</th>
                        {{-- <th>Oferta</th> --}}
                        <th>Visible en</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td class="align-middle">{{ $item->id }}</td>
                            <td class="align-middle">{{ $item->state->name }}</td>
                            <td class="align-middle">{{ optional($item->proveedores)->nombre }}</td>
                            {{-- <td class="align-middle">{{ $item->item }}</td> --}}
                            <td class="align-middle">{{ optional($item->paises)->nombre }}</td>
                            <td>
                                @can('parrillaalarmas.view.btn-edit')
                                    <a href="{{ route('alarmas.edit', $item) }}" class="btn btn-primary">Editar</a>
                                @endcan
                               {{--  @can('parrillaalarmas.view.btn-duplicate')
                                    <a href="{{ route('alarmasDuplicate', $item) }}" class="btn btn-warning">Duplicar</a>
                                @endcan --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <table id="parrillamovilTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Cliente</th>
                        {{-- <th>Oferta</th> --}}
                        <th>Visible en</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        @if ($item->estado == 1)
                            <tr>
                                <td class="align-middle">{{ $item->id }}</td>
                                <td class="align-middle">{{ optional($item->proveedores)->nombre ?? 'Not Available' }}</td>
                                {{-- <td class="align-middle">{{ $item->item }}</td> --}}
                                <td class="align-middle">{{ optional($item->paises)->nombre }}</td>
                                <td>
                                    @can('parrillaalarmas.view.btn-edit')
                                        <a href="{{ route('parrillamovil.edit', $item) }}" class="btn btn-primary">Editar</a>
                                    @endcan
                                    @can('parrillaalarmas.view.btn-duplicate')
                                        <a href="{{ route('parrillamovilDuplicate', $item) }}"
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
            <table id="parrillamovilTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Cliente</th>
                        {{-- <th>Oferta</th> --}}
                        <th>Visible en</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        @if ($item->estado == 2)
                            <tr>
                                <td class="align-middle">{{ $item->id }}</td>
                                <td class="align-middle">{{ optional($item->proveedores)->nombre ?? 'Not Available' }}</td>
                                {{-- <td class="align-middle">{{ $item->item }}</td> --}}
                                <td class="align-middle">{{ optional($item->paises)->nombre }}</td>
                                <td>
                                    @can('parrillaalarmas.view.btn-edit')
                                        <a href="{{ route('parrillamovil.edit', $item) }}" class="btn btn-primary">Editar</a>
                                    @endcan
                                    @can('parrillaalarmas.view.btn-duplicate')
                                        <a href="{{ route('parrillamovilDuplicate', $item) }}"
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
