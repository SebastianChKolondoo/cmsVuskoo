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
        @can('traduccionCategorias.view.btn-create')
            {{-- <a href="{{ route('tipoCupones.create') }}" class="btn btn-primary">Nueva traducción</a> --}}
        @endcan
    </div>
    <div class="row">
        <div class="col-12">
            <h4>Traducciones de categorias</h4>
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
            <table id="categoriasTodasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>Categoria</th>
                        @can('traduccionCategorias.view.btn-edit')
                            <th></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <td class="align-middle">{{ $item->id }}</td>
                        <td class="align-middle">{{ $item->nombre }}</td>
                        {{-- <td class="align-middle">{{ $categoria->paises->nombre }}</td> --}}
                        @can('traduccionCategorias.view.btn-edit')
                            <td>
                                <a href="{{ route('traduccionCategorias.edit', $item) }}" class="btn btn-primary">Editar</a>
                            </td>
                        @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
