@extends('layouts.app')
@section('content')
    @can('comercializadoras.view.btn-create')
        <div class="row justify-content-center my-4">
            <div class="col-12">
                <a href="{{ route('comercializadoras.create') }}" class="btn btn-primary">Nuevo comercializadora</a>
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
                    <h4>Listado de comercializadoras</h4>
                    <table id="comercializadorasTable" class="table table-striped" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>id</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                @can('comercializadoras.view.btn-edit')
                                <th></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comercializadoras as $comercializadora)
                                <td class="align-middle">{{ $comercializadora->id }}</td>
                                <td class="align-middle">{{ $comercializadora->nombre }}</td>
                                <td class="align-middle">{{ $comercializadora->state->name }}</td>
                                @can('comercializadoras.view.btn-edit')
                                    <td>
                                        <a href="{{ route('comercializadoras.edit', $comercializadora) }}" class="btn btn-primary">Editar</a>
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
