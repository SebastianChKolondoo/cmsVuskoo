@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            @if (session('info'))
                <div class="alert alert-success">
                    {{ session('info') }}
                </div>
            @endif
            @can('paginawebmenu.view.btn-create')
                <a href="{{ route('paginawebmenu.create') }}" class="btn btn-primary">Nuevo menú</a>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4>Menú para pagina web</h4>
        </div>
    </div>
    <!-- Tab panes -->
    <div class="tab-content p-3 bg-white">
        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
            <table id="menuTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Pais</th>
                        @can('paginawebmenu.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <td class="align-middle">{{$item->id}}</td>
                    <td class="align-middle">{{$item->titulo}}</td>
                    <td class="align-middle">{{$item->paises->nombre}}</td>
                        @can('paginawebmenu.view.btn-edit')
                            <td>
                                <a href="{{ route('paginawebmenu.edit', $item) }}" class="btn btn-primary">Editar</a>
                            </td>
                        @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
