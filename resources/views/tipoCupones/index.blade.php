@extends('layouts.app')
@section('content')
    @can('tipoCupones.view.btn-create')
        <div class="row justify-content-center my-4">
            <div class="col-12">
                @if (session('info'))
                    <div class="alert alert-success">
                        {{ session('info') }}
                    </div>
                @endif
                <a href="{{ route('tipoCupones.create') }}" class="btn btn-primary">Nuevo tipo cupón</a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-12">
            <h4>Listado de tipo de cupones</h4>
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
            <table id="tipoCuponesTodasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        @can('tipoCupones.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipoCupones as $tipoCupon)
                        <td class="align-middle">{{ $tipoCupon->id }}</td>
                        <td class="align-middle">{{ $tipoCupon->nombre }}</td>
                        @can('tipoCupones.view.btn-edit')
                            <td>
                                <a href="{{ route('tipoCupones.edit', $tipoCupon) }}" class="btn btn-primary">Editar</a>
                            </td>
                        @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
