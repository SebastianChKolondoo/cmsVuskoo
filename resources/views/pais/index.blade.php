@extends('layouts.app')
@section('content')
    @can('paises.view.btn-create')
        <div class="row justify-content-center my-4">
            <div class="col-12">
                @if (session('info'))
                    <div class="alert alert-success">
                        {{ session('info') }}
                    </div>
                @endif
                <a href="{{ route('paises.create') }}" class="btn btn-primary">Nueva pais</a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-12">
            <h4>Listado de paises</h4>
        </div>
    </div>
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1"
                aria-selected="true">Todos</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content p-3 bg-white">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <table id="paisesTodasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Moneda</th>
                        @can('paises.view.btn-edit')
                        <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paises as $pais)
                        <td class="align-middle">{{ $pais->id }}</td>
                        <td class="align-middle">{{ $pais->nombre }}</td>
                        <td class="align-middle">{{ $pais->codigo }}</td>
                        <td class="align-middle">{{ $pais->moneda }}</td>
                        @can('paises.view-btn-edit')
                            <td>
                                <a href="{{ route('paises.edit', $pais) }}" class="btn btn-primary">Editar</a>
                            </td>
                        @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
