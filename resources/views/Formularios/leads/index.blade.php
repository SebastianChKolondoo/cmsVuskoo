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
    <div class="row">
        <div class="col-12">
            <h4>Registro de leads</h4>
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
            <table id="paisesTodasTable" class="table table-striped" style="width:100%">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>id</th>
                        <th>landing</th>
                        {{-- <th>Company</th> --}}
                        <th>producto</th>
                        <th>Fecha creación</th>
                        @can('formularioleads.view-btn-show')
                            <th>&nbsp;</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <td class="align-middle">{{ $item->id }}</td>
                        <td class="align-middle">{{ $item->landing }}</td>
                        {{-- <td class="align-middle">{{ $item->Company }}</td> --}}
                        <td class="align-middle">{{ $item->producto }}</td>
                        <td class="align-middle">{{ $item->created_at }}</td>
                        @can('formularioleads.view-btn-show')
                        <td>
                                <a href="{{ route('formularioleads.show', $item) }}" class="btn btn-primary">Ver</a>
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
