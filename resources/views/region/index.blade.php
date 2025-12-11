@extends('template.main')

@section('title', 'Lista de Regiones')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 style="color: var(--ds-highlight-gold);">🗺️ Compendio de Regiones</h2>
        
        <a href="{{ route('regiones.create') }}" class="btn ds-btn">
            + Añadir Nueva Región
        </a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
             
            @foreach ($regiones as $region)
                <div class="col">
                    <a href="{{ route('regiones.zona', ['region' => $region->id]) }}" 
                       class="ds-card-link" 
                       style="text-decoration: none; display: block; height: 100%;">
                        
                        <div class="card ds-card h-100 p-3">
                            <div class="card-body p-0">
                                
                                {{-- Título de la Región --}}
                                <h5 class="card-title text-uppercase mb-3" 
                                    style="color: var(--ds-highlight-gold); font-size: 1.2rem;">
                                    {{ $region->nombre }}
                                </h5>
                                <img src="{{ $region->getPath() }}"
                    alt="Mapa de la Zona: {{ $region->nombre }}"
                    class="img-fluid rounded shadow-lg"
                    style="max-height: 400px; object-fit: cover;">
                                <hr style="border-color: var(--ds-border-grey); margin: 10px 0;">
    
                                {{-- Población --}}
                                <p class="card-text mb-2" style="font-size: var(--ds-font-small);">
                                    <strong>Población Estimada:</strong> {{ $region->poblacion ?? 'Desconocida' }}
                                </p>
                                
                                {{-- Dificultad --}}
                                <p class="card-text mb-4" style="font-size: var(--ds-font-small);">
                                    Dificultad: @php
                                        // Ejemplo de lógica simple para asignar color según dificultad
                                        $diff_class = match(strtolower($region->dificultad ?? 'n/a')) {
                                            'facil' => 'success',
                                            'media' => 'warning',
                                            'dificil' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge text-uppercase bg-{{ $diff_class }} border border-{{ $diff_class }}">
                                        {{ $region->dificultad ?? 'N/A' }}
                                    </span>
                                </p>
    
                                {{-- Pie de la Card (Acción) --}}
                                <div class="mt-auto pt-2 border-top" style="border-color: var(--ds-border-grey) !important;">
                                    <small class="text-muted text-uppercase" style="color: var(--ds-highlight-gold) !important;">
                                        ➡️ Ver Zonas y Peligros
                                    </small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
    </div>
@endsection