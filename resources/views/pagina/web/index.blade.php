@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            @if (session('info'))
                <div class="alert alert-success">
                    {{ session('info') }}
                </div>
            @endif
            {{-- @can('paginaweb.view.btn-create')
                <a href="{{ route('paginaweb.create') }}" class="btn btn-primary">Nueva configuración de footer</a>
            @endcan --}}
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4>Footer página web</h4>
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
            <table id="paginawebTodas" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Pais</th>
                        @can('paginaweb.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paises as $pais)
                        <td class="align-middle">{{ $pais->id }}</td>
                        <td class="align-middle">{{ $pais->nombre }}</td>
                        @can('paginaweb.view.btn-edit')
                            <td>
                                <a href="{{ route('paginaweb.edit', $pais) }}" class="btn btn-primary">Editar</a>
                            </td>
                        @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
