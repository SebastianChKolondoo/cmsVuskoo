@extends('layouts.app')

@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            @if (session('info'))
                <div class="alert alert-success">
                    {{ session('info') }}
                </div>
            @endif
            @can('prestamo.view.btn-create')
                <a href="{{ route('prestamos.create') }}" class="btn btn-primary">Nueva tarifa Colombia</a>
                {{-- <a href="{{ route('unificadoras.create') }}" class="btn btn-primary">Nueva tarifa Soluciones de deuda</a>
                <a href="{{ route('microcreditos.create') }}" class="btn btn-primary">Nueva tarifa Microcredito</a> --}}
                <a href="{{ route('tarifas.create', ['tipo' => 'soluciones_de_deuda']) }}" class="btn btn-primary">Nueva tarifa Soluciones de deuda</a>
                <a href="{{ route('tarifas.create', ['tipo' => 'microcredito']) }}" class="btn btn-primary">Nueva tarifa Microcredito</a>
                <a href="{{ route('tarifas.create', ['tipo' => 'prestamo']) }}" class="btn btn-primary">Nueva tarifa Préstamo</a>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4>Listado de finanzas</h4>
        </div>
    </div>

    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1"
                aria-selected="true">Todas</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tabColombia-tab" data-toggle="tab" href="#tabColombia" role="tab"
                aria-controls="tabColombia" aria-selected="false">Colombia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tabUnificadoras-tab" data-toggle="tab" href="#tabUnificadoras" role="tab"
                aria-controls="tabUnificadoras" aria-selected="false">Soluciones de deuda</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tabMicrocreditos-tab" data-toggle="tab" href="#tabMicrocreditos" role="tab"
                aria-controls="tabMicrocreditos" aria-selected="false">Microcréditos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tabPrestamos-tab" data-toggle="tab" href="#tabPrestamos" role="tab"
                aria-controls="tabPrestamos" aria-selected="false">Préstamos</a>
        </li>
    </ul>

    <div class="tab-content p-3 bg-white">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
            <table id="TodasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Banca</th>
                        <th>Titulo</th>
                        <th>Categoria</th>
                        <th>Pais</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $prestamo)
                        <tr>
                            <td class="align-middle">{{ $prestamo->id }}</td>
                            <td class="align-middle">{{ optional($prestamo->banco)->nombre }}</td>
                            <td class="align-middle">
                                {{ $prestamo->titulo != null ? $prestamo->titulo : $prestamo->parrilla_1 }}</td>
                            <td class="align-middle">{{ optional($prestamo->categorias)->nombre }}</td>
                            <td class="align-middle">{{ $prestamo->paises->nombre }}</td>
                            <td>
                                @can('prestamo.view.btn-edit')
                                    <a href="{{ route('prestamos.edit', $prestamo) }}" class="btn btn-primary">Editar</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="tabColombia" role="tabpanel">
            <table id="ColombiaTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Banca</th>
                        <th>Titulo</th>
                        <th>Categoria</th>
                        <th>Pais</th>
                        @can('prestamo.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $item)
                        @if ($item->categoria == 1 || $item->categoria == 2 || $item->categoria == 3)
                            <tr>
                                <td class="align-middle">{{ $item->id }}</td>
                                <td class="align-middle">{{ optional($item->banco)->nombre }}</td>
                                <td class="align-middle">
                                    {{ $item->titulo != null ? $item->titulo : $item->parrilla_1 }}</td>
                                <td class="align-middle">{{ optional($item->categorias)->nombre }}</td>
                                <td class="align-middle">{{ $item->paises->nombre }}</td>
                                <td>
                                    @can('prestamo.view.btn-edit')
                                        <a href="{{ route('prestamos.edit', $item) }}" class="btn btn-primary">Editar</a>
                                    @endcan
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="tabUnificadoras" role="tabpanel">
            <table id="UnificadorasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Banca</th>
                        <th>Titulo</th>
                        <th>Categoria</th>
                        <th>Pais</th>
                        @can('prestamo.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $item)
                        @if ($item->categoria == 4)
                            <tr>
                                <td class="align-middle">{{ $item->id }}</td>
                                <td class="align-middle">{{ optional($item->banco)->nombre }}</td>
                                <td class="align-middle">
                                    {{ $item->titulo != null ? $item->titulo : $item->parrilla_1 }}</td>
                                <td class="align-middle">{{ optional($item->categorias)->nombre }}</td>
                                <td class="align-middle">{{ $item->paises->nombre }}</td>
                                <td>
                                    @can('unificadoras.view.btn-edit')
                                        <a href="{{ route('microcreditos.edit', $item) }}" class="btn btn-primary">Editar</a>
                                    @endcan
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="tabMicrocreditos" role="tabpanel">
            <table id="MicrocreditosTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Banca</th>
                        <th>Titulo</th>
                        <th>Categoria</th>
                        <th>Pais</th>
                        @can('prestamo.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $item)
                        @if ($item->categoria == 5)
                            <tr>
                                <td class="align-middle">{{ $item->id }}</td>
                                <td class="align-middle">{{ optional($item->banco)->nombre }}</td>
                                <td class="align-middle">
                                    {{ $item->titulo != null ? $item->titulo : $item->parrilla_1 }}</td>
                                <td class="align-middle">{{ optional($item->categorias)->nombre }}</td>
                                <td class="align-middle">{{ $item->paises->nombre }}</td>
                                <td>
                                    @can('microcreditos.view.btn-edit')
                                        <a href="{{ route('microcreditos.edit', $item) }}" class="btn btn-primary">Editar</a>
                                    @endcan
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tabPrestamos" role="tabpanel">
            <table id="PrestamosTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Banca</th>
                        <th>Titulo</th>
                        <th>Categoria</th>
                        <th>Pais</th>
                        @can('prestamo.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $item)
                        @if ($item->categoria == 6)
                            <tr>
                                <td class="align-middle">{{ $item->id }}</td>
                                <td class="align-middle">{{ optional($item->banco)->nombre }}</td>
                                <td class="align-middle">
                                    {{ $item->titulo != null ? $item->titulo : $item->parrilla_1 }}</td>
                                <td class="align-middle">{{ optional($item->categorias)->nombre }}</td>
                                <td class="align-middle">{{ $item->paises->nombre }}</td>
                                <td>
                                    @can('microcreditos.view.btn-edit')
                                        <a href="{{ route('microcreditos.edit', $item) }}" class="btn btn-primary">Editar</a>
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
