@extends('layouts.app')
@section('content')
    @can('operadoras.view.btn-create')
        <div class="row justify-content-center my-4">
            <div class="col-12">
                <a href="{{ route('operadoras.create') }}" class="btn btn-primary">Nueva operadora</a>
            </div>
        </div>
    @endcan

    <div class="row justify-content-center my-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body overflow-auto">
                    @if (session('info'))
                        <div class="alert alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    <h4>Listado de operadoras</h4>
                    <table id="operadorasTable" class="table table-striped" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>id</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                @can('operadoras.view.btn-edit')
                                    <th></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($operadoras as $operadora)
                                <td class="align-middle">{{ $operadora->id }}</td>
                                <td class="align-middle">{{ $operadora->nombre }}</td>
                                <td class="align-middle">{{ $operadora->state->name }}</td>
                                @can('operadoras.view.btn-edit')
                                    <td>
                                        <a href="{{ route('operadoras.edit', $operadora) }}" class="btn btn-primary">Editar</a>
                                    </td>
                                @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
