@extends('layouts.app')
@section('content')
    @can('parrillas.parrillaMovil.view.btn-create')
        <div class="row justify-content-center my-4">
            <div class="col-12">
                <a href="{{ route('parrillaMovil.create') }}" class="btn btn-primary">Nuevo trifa</a>
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
                    <h4>Listado de parrillaMovil</h4>
                    <table id="parrillaMovilTable" class="table table-striped" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>id</th>
                                <th>Operadora</th>
                                <th>Nombre</th>
                                <th>Parrilla 1</th>
                                <th>Parrilla 2</th>
                                <th>Parrilla 3</th>
                                <th>Parrilla 4</th>
                                <th>Precio</th>
                                <th>Visible en</th>
                                @can('parrillaMovil.view.btn-edit')
                                    <th></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tarifas as $tarifa)
                                <td class="align-middle">{{ $tarifa->id }}</td>
                                <td class="align-middle">{{ $tarifa->operadora }}</td>
                                <td class="align-middle">{{ $tarifa->nombre_tarifa }}</td>
                                <td class="align-middle">{{ $tarifa->parrilla_bloque_1 }}</td>
                                <td class="align-middle">{{ $tarifa->parrilla_bloque_2 }}</td>
                                <td class="align-middle">{{ $tarifa->parrilla_bloque_3 }}</td>
                                <td class="align-middle">{{ $tarifa->parrilla_bloque_4 }}</td>
                                <td class="align-middle">{{ $tarifa->precio }}</td>
                                <td class="align-middle">{{ $tarifa->pais }}</td>
                                @can('parrillaMovil.view.btn-edit')
                                    <td>
                                        <a href="{{ route('parrillaMovil.edit', $tarifa) }}" class="btn btn-primary">Editar</a>
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
