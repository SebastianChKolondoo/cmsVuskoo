@extends('layouts.app')
@section('content')
    <div class="row justify-content-center my-4">
        <div class="col-12">
            @if (session('info'))
                <div class="alert alert-success">
                    {{ session('info') }}
                </div>
            @endif
            @can('blog.view.btn-create')
                <a href="{{ route('blog.create') }}" class="btn btn-primary">Nuevo blog</a>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h4>Listado de blog</h4>
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
            <table id="blogTodasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>titulo</th>
                        <th>Categoria</th>
                        @can('blog.view-btn-edit')
                            <th>Acciones</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <td class="align-middle">{{ $item->id }}</td>
                        <td class="align-middle">{{ $item->titulo }}</td>
                        <td class="align-middle">{{ $item->categorias->nombre }}</td>
                        @can('blog.view-btn-edit')
                        <td class="d-flex">
                                <a href="blogPreview/{{$item->id}}" target="_blank" class="btn btn-warning mx-1">Preview</a>
                                <a href="{{ route('blog.edit', $item) }}" class="btn btn-primary mx-1">Editar</a>
                            </td>
                        @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
