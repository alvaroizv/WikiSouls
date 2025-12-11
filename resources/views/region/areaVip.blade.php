@extends('template.main')

@section('title', 'Forja del Alma')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card" style="
                background-color: #1a1a1a; 
                border: 3px solid var(--ds-highlight-gold);
                box-shadow: 0 0 30px rgba(255, 204, 0, 0.8);
                color: #FFFFFF;
            ">
                <div class="card-header text-center" style="
                    background-color: #333333;
                    color: var(--ds-highlight-gold);
                    font-size: 2.5rem;
                    border-bottom: 3px solid var(--ds-highlight-gold);
                    padding: 1.5rem;
                ">
                    <i class="fas fa-hammer me-2"></i> {{ __('La Forja del Alma') }}
                </div>

                <div class="card-body p-5 text-center">
                    
                    <h2 class="mb-4" style="color: #CCCCCC;">
                        {{ __('Área de Almas Confirmadas') }}
                    </h2>

                    <p class="lead" style="color: #4CAF50; font-style: italic;">
                        {{ $mensajeVip }}
                    </p>
                    
                    <hr style="border-top: 1px solid #444;">

                    <p style="color: #AAAAAA;">
                        {{ __('Este santuario es exclusivo. Aquí puedes acceder a las herramientas más poderosas del Reino.') }}
                    </p>
                    
                    <div class="text-center mt-5">
    
                    <img src="{{ asset('storage/img/hoguera.gif') }}" alt="Hoguera Encendida" style="width: 700px; height: auto;">
    
                        <p style="color: #FFC107; font-style: italic;" class="mt-2">
                         {{ __('¡Hoguera encendida! Tu progreso está a salvo, Alma Enlazada.') }}
                        </p>
                    </div>
                </div>

                {{-- INICIO: SECCIÓN DE LISTA DE USUARIOS (ALMAS REGISTRADAS) --}}
                    <div class="mt-5 pt-3" style="border-top: 2px solid var(--ds-highlight-gold);">
                        <h3 class="mb-4" style="color: var(--ds-highlight-gold); text-align: left;">
                            <i class="fas fa-users me-2"></i> {{ __('Censo de Almas Enlazadas') }}
                        </h3>

                        @if ($usuarios->isEmpty())
                            <p class="text-warning">Aún no hay almas registradas en el santuario.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-dark table-striped table-hover" style="border-color: #444;">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="color: var(--ds-highlight-gold);"># ID</th>
                                            <th scope="col" style="color: var(--ds-highlight-gold);">Nombre de Alma</th>
                                            <th scope="col" style="color: var(--ds-highlight-gold);">Email</th>
                                            <th scope="col" style="color: var(--ds-highlight-gold);">Estado</th>
                                            <th scope="col" style="color: var(--ds-highlight-gold);">Registro</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usuarios as $user)
                                            <tr>
                                                <th scope="row" style="color: #bbb;">{{ $user->id }}</th>
                                                <td style="color: var(--ds-text-light);">{{ $user->name }}</td>
                                                <td style="color: var(--ds-text-light-muted); font-size: 0.9em;">{{ $user->email }}</td>
                                                <td>
                                                    @if ($user->email_verified_at)
                                                        <span class="badge bg-success" style="background-color: #4CAF50 !important;"><i class="fas fa-check-circle"></i> Verificado</span>
                                                    @else
                                                        <span class="badge bg-danger" style="background-color: #A00 !important;"><i class="fas fa-times-circle"></i> Pendiente</span>
                                                    @endif
                                                </td>
                                                <td style="color: #999; font-size: 0.8em;">{{ $user->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
            </div>

        </div>
    </div>
</div>
@endsection