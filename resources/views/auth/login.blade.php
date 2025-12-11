@extends('template.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            {{-- Card principal con estilo DS --}}
            <div class="card" style="
                background-color: #1a1a1a; /* ds-bg-dark */
                border: 2px solid var(--ds-highlight-gold);
                box-shadow: 0 0 10px rgba(255, 204, 0, 0.3);
                color: #FFFFFF; /* ds-text-light */
            ">
                <div class="card-header" style="
                    background-color: #333333; /* Color de encabezado oscuro */
                    color: var(--ds-highlight-gold);
                    font-size: 1.5rem;
                    border-bottom: 1px solid var(--ds-highlight-gold);
                    text-align: center;
                ">{{ __('Acceder al Reino') }}</div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Campo Email --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end" style="color: var(--ds-text-light);">{{ __('Correo del Heraldo') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    style="background-color: #2b2b2b; color: #FFFFFF; border: 1px solid #555555;">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Campo Contraseña --}}
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end" style="color: var(--ds-text-light);">{{ __('Contraseña de Vínculo') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"
                                    style="background-color: #2b2b2b; color: #FFFFFF; border: 1px solid #555555;">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Recordarme --}}
                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                        style="background-color: #555555; border-color: #777777;">

                                    <label class="form-check-label" for="remember" style="color: var(--ds-text-light);">
                                        {{ __('Mantener la Flama Viva') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de Acción --}}
                        <div class="row mb-0 mt-4">
                            <div class="col-md-8 offset-md-4 d-flex justify-content-between align-items-center">
                                
                                {{-- Botón de Login (Estilo DS) --}}
                                <button type="submit" class="btn ds-btn px-4" style="
                                    background-color: var(--ds-highlight-gold);
                                    color: #000000;
                                    font-weight: bold;
                                    border: none;
                                    transition: background-color 0.3s;
                                ">
                                    {{ __('Encender el Vínculo') }}
                                </button>

                                {{-- Botón Olvidó Contraseña --}}
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}" style="color: #999999;">
                                        {{ __('¿Has Perdido tu Recuerdo?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection