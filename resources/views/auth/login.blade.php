@extends('layouts.app')
@section('content')
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Cms Vuskoo</h1>
                                </div>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group col-12">
                                        <input id="exampleInputEmail" type="email"
                                            class="form-control p-4  @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                    <div class="form-group col-12">
                                        <input id="exampleInputPassword" type="password" class="form-control p-4 "
                                            name="password" required autocomplete="email" autofocus>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Iniciar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-12 text-center pb-5">
                            <small>V 1.0 | 2024 | Todos los derechos reservados</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
