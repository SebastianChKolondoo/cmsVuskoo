@extends('layouts.app')
@section('content')
<div class="row justify-content-center my-4">
    <div class="col-12">
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">Nuevo usuario</a>
    </div>
</div>

<div class="row justify-content-center my-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body overflow-auto">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <h4>Listado de usuarios</h4>
                <table id="usuariosTable" class="table table-striped" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Cédula</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Compañia</th>
                            <th>Correo</th>
                            <th>Perfil</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                        <td class="align-middle">{{ $usuario->idNumber }}</td>
                        <td class="align-middle">{{ $usuario->name }} {{ $usuario->lastname }}</td>
                        <td class="align-middle">{{ $usuario->phone }}</td>
                        <td class="align-middle">{{ $usuario->company }}</td>
                        <td class="align-middle">{{ $usuario->email }}</td>
                        <td class="align-middle">{{ $usuario->role }}</td>
                        <td>
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-primary btn_save_info">Editar</a>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6"></td>
                            <td>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mx-auto text-center">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</div>
@endsection