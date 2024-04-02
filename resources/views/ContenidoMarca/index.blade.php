@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            @if (session('info'))
                <div class="alert alert-success">
                    {{ session('info') }}
                </div>
            @endif
        </div>
    </div>
    @can('operadoras.view.btn-create')
    @endcan
    <div class="row">
        <div class="col-12">
            <h4>Listado</h4>
        </div>
    </div>
    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1"
                aria-selected="true">Operadoras</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2"
                aria-selected="false">Comercializadoras</a>
        </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content p-3 bg-white">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <table id="operadorasTodasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Estado</th>
                        <th>Nombre</th>
                        @can('operadoras.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comercializadoras as $comercializadora)
                        <td class="align-middle">{{ $comercializadora->id }}</td>
                        <td class="align-middle">{{ $comercializadora->state->name }}</td>
                        <td class="align-middle">{{ $comercializadora->nombre }}</td>
                        @can('operadoras.view.btn-edit')
                            <td><a href="{{ route('Contenidomarcacreatecomercializadora', $comercializadora) }}"
                                    class="btn btn-primary">Editar contenido</a></td>
                        @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <table id="operadorasActivasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        @can('operadoras.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operadoras as $operadora)
                        @if ($operadora->estado == 1)
                            <td class="align-middle">{{ $operadora->id }}</td>
                            <td class="align-middle">{{ $operadora->nombre }}</td>
                            @can('operadoras.view.btn-edit')
                                <td><a href="{{ route('Contenidomarcacreateoperadora', $operadora) }}"
                                        class="btn btn-primary">Editar</a></td>
                            @endcan
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
            <table id="operadorasInactivasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        @can('operadoras.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operadoras as $operadora)
                        <td class="align-middle">{{ $operadora->id }}</td>
                        <td class="align-middle">{{ $operadora->nombre }}</td>

                        @can('operadoras.view.btn-edit')
                            <td><a href="{{ route('Contenidomarcacreateoperadora', $operadora) }}"
                                    class="btn btn-primary">Editar contenido</a></td>
                        @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
