@extends('layouts.app')

@section('content')
    <!-- Section: Design Block -->
    <section class="text-center">
        <!-- Background image -->
        <div class="p-5 bg-image"
            style="
        background-image: url('https://mdbootstrap.com/img/new/textures/full/171.jpg');
        height: 300px;
        ">
        </div>
        <!-- Background image -->

        <div class="card mx-4 mx-md-5 shadow-5-strong"
            style="
                    margin-top: -200px;

                    backdrop-filter: blur(30px);
            ">
            <div class="card-body py-5 px-md-5">

                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="fw-bold mb-5">Entrar</h2>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label class="form-label" for="form3Example3">Email</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label class="form-label" for="form3Example4">Senha</label>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">
                                Entrar
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link d-block" href="{{ route('password.request') }}">
                                    {{ __('Esqueceu sua senha?') }}
                                </a>
                            @endif

                            <!-- Register buttons -->
                            <div class="text-center">
                                <a class="btn btn-link" href="{{ route('register') }}">Criar Conta</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Design Block -->
@endsection


@section('css')
    <style>
        #yield-content {
            padding: 0!important;
        }
    </style>
@endsection
