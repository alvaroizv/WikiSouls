@extends('template.main') {{-- *** IMPORTANTE: Cambiado a tu layout principal *** --}}

@section('title', 'Forjar Pacto')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-lg-8 col-md-10">
        
        @if (session('status'))
            {{-- Muestra el mensaje de éxito del HomeController --}}
            <div class="alert alert-success mb-4" role="alert" style="background-color: #4CAF5033; border-color: #4CAF50; color: #C8E6C9;">
                <i class="fas fa-hammer me-2"></i> {{ session('status') }}
            </div>
        @endif

        {{-- Panel Principal: Edición de Datos --}}
        <div class="card" style="
            background-color: #1a1a1a; /* Fondo oscuro */
            border: 2px solid var(--ds-highlight-gold);
            box-shadow: 0 0 15px rgba(255, 204, 0, 0.4);
            color: #FFFFFF;
        ">
            <div class="card-header" style="
                background-color: #333333;
                color: var(--ds-highlight-gold);
                font-size: 1.8rem;
                border-bottom: 2px solid var(--ds-highlight-gold);
                text-align: center;
                padding: 1rem;
            ">
                <i class="fas fa-scroll me-2"></i> {{ __('Editar Plegarias y Juramentos') }}
            </div>

            <div class="card-body p-5">
                <form method="POST" action="{{ route('home.update') }}">
                    @csrf
                    @method('put') {{-- Utiliza el método PUT/PATCH para actualizar --}}

                    {{-- Nombre --}}
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end" style="color: #AAAAAA;">{{ __('Nombre del Portador') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name', Auth::user()->name) }}" required autocomplete="name" autofocus
                                style="background-color: #333333; border-color: #555555; color: #FFFFFF;"
                            >
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end" style="color: #AAAAAA;">{{ __('Correo del Alma') }}</label>
                        <div class="col-md-6">
                            <input id="email" type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="email"
                                style="background-color: #333333; border-color: #555555; color: #FFFFFF;"
                            >
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    
                    <hr style="border-top: 1px solid #444; margin: 2rem 0;">

                    {{-- Contraseña Actual (Juramento Antiguo) --}}
                    <div class="row mb-3">
                        <label for="currentpassword" class="col-md-4 col-form-label text-md-end" style="color: #AAAAAA;">{{ __('Juramento Antiguo') }}</label>
                        <div class="col-md-6">
                            <input id="currentpassword" type="password" 
                                class="form-control @error('currentpassword') is-invalid @enderror" 
                                name="currentpassword" autocomplete="off"
                                style="background-color: #333333; border-color: #555555; color: #FFFFFF;"
                            >
                            <small class="text-muted" style="color: #777 !important;">{{ __('Requerido solo para cambiar la contraseña.') }}</small>
                            @error('currentpassword')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Nueva Contraseña (Nuevo Juramento) --}}
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end" style="color: #AAAAAA;">{{ __('Nuevo Juramento') }}</label>
                        <div class="col-md-6">
                            <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" autocomplete="new-password"
                                style="background-color: #333333; border-color: #555555; color: #FFFFFF;"
                            >
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirmar Nueva Contraseña --}}
                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end" style="color: #AAAAAA;">{{ __('Confirmar Nuevo Juramento') }}</label>
                        <div class="col-md-6">
                            <input id="password-confirm" type="password" 
                                class="form-control" 
                                name="password_confirmation" autocomplete="new-password"
                                style="background-color: #333333; border-color: #555555; color: #FFFFFF;"
                            >
                        </div>
                    </div>

                    {{-- Botón de Envío --}}
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn ds-btn-outline">
                                <i class="fas fa-fire me-1"></i> {{ __('Forjar Pacto') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection