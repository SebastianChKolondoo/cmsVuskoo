@extends('layouts.app')
@section('content')
    @can('gas.view.btn-create')
        <div class="row justify-content-center my-4">
            <div class="col-12">
                <a href="{{ route('parrillagas.create') }}" class="btn btn-primary">Nueva oferta</a>
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
                    <h4>Listado de parrilla gas</h4>
                    <table id="parrillagasTable" class="table table-striped" style="width:100%">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>id</th>
                                <th>Estado</th>
                                <th>comercializadora</th>
                                <th>Oferta</th>
                                <th>Precio</th>
                                <th>Visible en</th>
                                @can('gas.view.btn-edit')
                                    <th></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tarifas as $tarifa)
                                <td class="align-middle">{{ $tarifa->id }}</td>
                                <td class="align-middle">{{ $tarifa->state->name ?? 'Not Available' }}</td>
                                <td class="align-middle">{{ $tarifa->comercializadoras->nombre ?? 'Not Available' }}</td>
                                <td class="align-middle">{{ $tarifa->nombre_tarifa }}</td>                                
                                <td class="align-middle">{{ $tarifa->precio }}</td>
                                <td class="align-middle">{{ $tarifa->pais }}</td>
                                @can('gas.view.btn-edit')
                                    <td>
                                        <a href="{{ route('parrillagas.edit', $tarifa) }}" class="btn btn-primary">Editar</a>
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
