@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Perfil do Usuário') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nome') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('E-mail') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('Telefone') }}</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">{{ __('Endereço') }}</label>
                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" 
                                   name="address" value="{{ old('address', auth()->user()->address) }}">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Atualizar Perfil') }}
                            </button>
                        </div>
                    </form>

                    <hr>

                    <h5 class="mt-4">{{ __('Alterar Senha') }}</h5>
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">{{ __('Senha Atual') }}</label>
                            <input id="current_password" type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   name="current_password" required>
                            @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Nova Senha') }}</label>
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirmar Nova Senha') }}</label>
                            <input id="password_confirmation" type="password" class="form-control" 
                                   name="password_confirmation" required>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Alterar Senha') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
