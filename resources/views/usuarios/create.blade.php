@extends('layouts.app')
@section('content')

<div class="row">
  <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto">
    <div class="card">
      <div class="card-header">
        <h1>Nuevo usuario</h1>
      </div>
      <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
          @foreach($errors->all() as $error)
          - {{ $error }}<br>
          @endforeach
        </div>
        @endif
        <form action="{{ route('usuarios.store' ) }}" method="POST">
          <div class="form-row">
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="idNumber">Identificación</label>
              <input type="phone" class="form-control" name="idNumber">
            </div>

            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="name">Nombres</label>
              <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="lastname">Apellidos</label>
              <input type="text" class="form-control" name="lastname">
            </div>
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="phone">Teléfono</label>
              <input type="phone" class="form-control" name="phone">
            </div>
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="email">email</label>
              <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="date_birth">Fecha de nacimiento</label>
              <input type="date" class="form-control" name="date_birth">
            </div>
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="bank">Banco</label>
              <input type="text" class="form-control" name="bank">
            </div>
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="account">Tipo de cuenta</label>
              <input type="text" class="form-control" name="account">
            </div>
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="number_account">Número de cuenta</label>
              <input type="text" class="form-control" name="number_account">
            </div>
            <div class="form-group col-md-6 col-sm-12 col-xs-12">
              <label for="capacity">Capacidad de servicios</label>
              <input type="text" class="form-control" name="capacity">
            </div>
          </div>
          @csrf
          <div class="float-right">
            <button type="submit" class="btn btn-primary btn_save_info">Registrar</button>
        </form>
        <a class="btn btn-secondary" href="{{ route('usuarios.index') }}">Cancelar</a>
      </div>
    </div>
  </div>
</div>
</div>
@endsection