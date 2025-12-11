@extends('template.main')

@section('title', 'Santuario del Enlace')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            {{-- Mensajes de Éxito/Status (Bloque Superior: Verificación/Notificaciones) --}}
            {{-- ... Bloque de Verificación y Notificaciones (Sin cambios) ... --}}
            
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success mb-4" role="alert" style="background-color: #4CAF5033; border-color: #4CAF50; color: #C8E6C9;">
                    <i class="fas fa-paper-plane me-2"></i> {{ __('Un nuevo vínculo de verificación ha sido enviado al correo electrónico que proporcionaste.') }}
                </div>
            @endif

            @if (session('status') && session('status') != 'verification-link-sent')
                <div class="alert alert-success mb-4" role="alert" style="background-color: #4CAF5033; border-color: #4CAF50; color: #C8E6C9;">
                    {{ session('status') }}
                </div>
            @endif

            @if (auth()->user()->hasVerifiedEmail())
                <div class="card mb-4" style="background-color: #1a1a1a; border: 2px solid #4CAF50; color: #FFFFFF; box-shadow: 0 0 10px rgba(76, 175, 80, 0.5);">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="color: #4CAF50;"><i class="fas fa-check-circle me-2"></i> {{ __('Vínculo Consolidado') }}</h5>
                        <p class="card-text" style="color: #CCCCCC;">{{ __('Tu alma está enlazada y tu juramento ha sido verificado.') }}</p>
                    </div>
                </div>
            @else
                <div class="card mb-4" style="background-color: #1a1a1a; border: 2px solid var(--ds-highlight-gold); color: #FFFFFF; box-shadow: 0 0 10px rgba(255, 204, 0, 0.5);">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="color: var(--ds-highlight-gold);"><i class="fas fa-exclamation-triangle me-2"></i> {{ __('Vínculo Pendiente') }}</h5>
                        <p class="card-text mb-3" style="color: #CCCCCC;">{{ __('Tu alma debe ser verificada para asegurar el Vínculo. Revisa tu correo electrónico para el mensaje de confirmación.') }}</p>
                        <form method="POST" action="{{ route('verification.resend') }}"> 
                            @csrf
                            <button type="submit" class="btn ds-btn-outline" style="background-color: transparent; color: var(--ds-highlight-gold); border-color: var(--ds-highlight-gold);">
                                {{ __('Re-enviar Vínculo de Verificación') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- BLOQUE DE INFORMACIÓN DEL USUARIO (dejamos este bloque intacto) --}}
            {{-- ... Bloque de Información del Usuario (Sin cambios) ... --}}
            <div class="card mb-4" style="background-color: #1a1a1a; border: 2px solid var(--ds-highlight-gold); box-shadow: 0 0 15px rgba(255, 204, 0, 0.4); color: #FFFFFF;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #333333; color: var(--ds-highlight-gold); font-size: 1.5rem; border-bottom: 2px solid var(--ds-highlight-gold); padding: 1rem;">
                    <div><i class="fas fa-user-circle me-2"></i> {{ __('Datos del Alma Enlazada') }}</div>
                    <a href="{{ route('home.edit') }}" class="btn ds-btn-outline" style="font-size: 0.8rem; padding: 0.3rem 0.8rem; background-color: transparent; color: var(--ds-highlight-gold); border-color: var(--ds-highlight-gold);">
                        <i class="fas fa-edit me-1"></i> {{ __('Editar Pacto') }}
                    </a>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush" style="background-color: transparent;">
                        <li class="list-group-item" style="background-color: transparent; border-color: #444;">
                            <strong>{{ __('Nombre:') }}</strong> <span style="color: white;">{{ Auth::user()->name }}</span>
                        </li>
                        <li class="list-group-item" style="background-color: transparent; border-color: #444;">
                            <strong>{{ __('Correo (Alma):') }}</strong> <span style="color: white;">{{ Auth::user()->email }}</span>
                        </li>
                        <li class="list-group-item" style="background-color: transparent; border-color: #444;">
                            <strong>{{ __('Fecha de Juramento:') }}</strong> <span style="color: white;">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- --------------------------------------- --}}
            {{-- CONTENIDO AMPLIADO: HOGUERA DEL SANTUARIO --}}
            {{-- --------------------------------------- --}}
            
            <div class="card" style="
                background-color: #1a1a1a; 
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
                    <i class="fas fa-fire me-2"></i> {{ __('Hoguera del Santuario: El Descanso del No Muerto') }}
                </div>

                <div class="card-body p-5" style="color: #CCCCCC;">
                    <div class="row">
                        
                        {{-- Columna 1: Estadísticas del Viaje --}}
                        <div class="col-md-6 mb-4">
                            <h4 style="color: var(--ds-highlight-gold); border-bottom: 1px dashed #555; padding-bottom: 0.5rem;">
                                <i class="fas fa-map-marked-alt me-2"></i> {{ __('Estadísticas del Viaje') }}
                            </h4>
                            <p>{{ __('Has accedido al Santuario del Enlace. Estás a salvo por ahora. El camino aún es largo...') }}</p>
                            
                            <ul class="list-group list-group-flush" style="background-color: transparent;">
                                <li class="list-group-item" style="background-color: #222; border-color: #444; color: #E0E0E0; display: flex; justify-content: space-between;">
                                    <span>{{ __('Almas Acumuladas :') }}</span>
                                    <span style="color: var(--ds-highlight-gold); font-weight: bold;">999</span>
                                </li>
                                <li class="list-group-item" style="background-color: #222; border-color: #444; color: #E0E0E0; display: flex; justify-content: space-between;">
                                    <span>{{ __('Nivel de Pacto :') }}</span>
                                    <span style="color: #FFC107; font-weight: bold;">3</span>
                                </li>
                                <li class="list-group-item" style="background-color: #222; border-color: #444; color: #E0E0E0; display: flex; justify-content: space-between;">
                                    <span>{{ __('Días en el Santuario:') }}</span>
                                    <span style="color: #FFFFFF; font-weight: bold;">{{ Auth::user()->created_at->diffForHumans(null, true) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <hr style="border-top: 1px solid #444; margin: 2rem 0;">
                    
                    <p class="text-center mt-4" style="font-style: italic; color: #888;">
                        {{ __('No te olvides de encender la hoguera y descansar un rato. El camino de los No Muertos es arduo.') }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection