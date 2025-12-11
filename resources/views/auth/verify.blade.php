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
                ">{{ __('Verificar el Vínculo del Heraldo') }}</div>

                <div class="card-body p-4">
                    
                    {{-- Mensaje de éxito al reenviar --}}
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert" style="background-color: #4CAF5033; border-color: #4CAF50; color: #C8E6C9;">
                            {{ __('Un nuevo juramento de verificación ha sido enviado a tu dirección de correo electrónico.') }}
                        </div>
                    @endif

                    <p style="color: var(--ds-text-light);">
                        {{ __('Antes de continuar, por favor, revisa tu correo en busca de la misiva de verificación.') }}
                    </p>
                    
                    <p style="color: var(--ds-text-light);">
                        {{ __('Si la misiva no llegó a tu inventario') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline" 
                                style="color: var(--ds-highlight-gold); text-decoration: none; font-weight: bold;">
                                {{ __('haz clic aquí para solicitar otro juramento.') }}
                            </button>
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection