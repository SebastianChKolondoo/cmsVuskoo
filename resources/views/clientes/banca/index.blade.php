@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            @if (session('info'))
                <div class="alert alert-success">
                    {{ session('info') }}
                </div>
            @endif
            {{-- @can('banca.view.btn-create') --}}
                <a href="{{ route('bancos.create') }}" class="btn btn-primary">Nueva banca</a>
            {{-- @endcan --}}
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4>Listado de banca</h4>
        </div>
    </div>
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1"
                aria-selected="true">Todas</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content p-3 bg-white">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <table id="bancaTodasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Estado</th>
                        <th>Nombre</th>
                        <th>pais</th>
                        {{-- @can('banca.view.btn-edit') --}}
                            <th></th>
                        {{-- @endcan --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bancos as $banco)
                        <td class="align-middle">{{ $banco->id }}</td>
                        <td class="align-middle">{{ $banco->state->name }}</td>
                        <td class="align-middle">{{ $banco->nombre }}</td>
                        <td class="align-middle">{{ $banco->paises->nombre }}</td>
                        {{-- @can('banca.view.btn-edit') --}}
                            <td>
                                <a href="{{ route('bancos.edit', $banco) }}" class="btn btn-primary">Editar</a>
                            </td>
                        {{-- @endcan --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
