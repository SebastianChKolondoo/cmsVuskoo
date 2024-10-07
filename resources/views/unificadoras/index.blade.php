@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            @if (session('info'))
                <div class="alert alert-success">
                    {{ session('info') }}
                </div>
            @endif
            @can('unificadores.view.btn-create')
                <a href="{{ route('unificadoras.create') }}" class="btn btn-primary">Nueva tarifa</a>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4>Listado de Unificadoras</h4>
        </div>
    </div>
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1"
                aria-selected="true">Todas</a>
        </li>
    </ul>
    <div class="tab-content p-3 bg-white">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <table id="TodasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Banca</th>
                        <th>Titulo</th>
                        <th>Pais</th>
                        @can('unificadores.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tarifas as $data)
                        <tr>
                            <td class="align-middle">{{ $data->id }}</td>
                            <td class="align-middle">{{ optional($data->banco)->nombre }}</td>
                            <td class="align-middle">{{ $data->titulo != null ? $data->titulo : $data->parrilla_1 }}</td>
                            <td class="align-middle">{{ $data->paises->nombre }}</td>
                            <td>
                                @can('unificadores.view.btn-edit')
                                    <a href="{{ route('unificadoras.edit', $data) }}" class="btn btn-primary">Editar</a>
                                @endcan
                                {{-- @can('unificadores.view.btn-duplicate')
                                    <a href="{{ route('prestamosDuplicate', $prestamo) }}" class="btn btn-warning">Duplicar</a>
                                @endcan --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
