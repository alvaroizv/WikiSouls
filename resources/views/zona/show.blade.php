@extends('template.main')

@section('title', $zona->nombre . ' - Enciclopedia')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-md-12">

        <h1 style="color: var(--ds-highlight-gold);" class="mb-2 display-4">{{ $zona->nombre }}</h1>
        <p class="text-muted mb-4">
            Entrada Enciclopédica del Reino | Forjada el
            {{ $zona->created_at?->format('d/m/Y') ?? 'Fecha desconocida' }}
        </p>

        <hr style="border-color: var(--ds-border-grey);">

        <div class="row">

            <div class="col-md-8">

                <img src="{{ $zona->getPath() }}"
                    alt="Mapa de la Zona: {{ $zona->nombre }}"
                    class="img-fluid rounded shadow-lg"
                    style="max-height: 400px; object-fit: cover;">

                <h3 class="mb-3" style="color: var(--ds-text-light);">📜 Historia y Descripción</h3>
                <div class="card p-3 mb-4" style="background-color: #242424; border-color: var(--ds-border-grey);">
                    <p style="color: var(--ds-text-light); white-space: pre-wrap;">{{ $zona->descripcion }}</p>
                </div>

                <h3 class="mb-3" style="color: var(--ds-text-light);">⚔️ Enemigos y Desafíos</h3>
                @if ($zona->enemigos->count() > 0)
                <ul class="list-group mb-4">
                    @foreach ($zona->enemigos as $enemigo)
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        style="background-color: #1a1a1a; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                        {{ $enemigo->nombre }}
                        <span class="badge rounded-pill"
                            style="background-color: var(--ds-highlight-gold); color: #1a1a1a;">
                            Nivel: {{ $enemigo->nivel ?? '??' }}
                        </span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted">Parece que esta zona aún no tiene enemigos catalogados. Cuidado con lo
                    inesperado...</p>
                @endif

                <h3 class="mb-3" style="color: var(--ds-text-light);">💎 Tesoros Encontrados</h3>
                @if ($zona->objetos->count() > 0)
                <ul class="list-group mb-4">
                    @foreach ($zona->objetos as $objeto)
                    <li class="list-group-item"
                        style="background-color: #1a1a1a; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                        {{ $objeto->nombre }}
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted">No se han descubierto objetos raros o tesoros en este territorio.</p>
                @endif

            </div>

            <div class="col-md-4">
                <div class="card p-3" style="background-color: #333333; border-color: var(--ds-highlight-gold);">
                    <h4 class="text-center mb-3" style="color: var(--ds-highlight-gold);">
                        📍 Datos de la Zona
                    </h4>
                    <ul class="list-unstyled mb-0" style="color: var(--ds-text-light);">

                        <li class="mb-2">
                            <strong>Región Perteneciente:</strong>
                            <br>
                            <a href="{{ route('regiones.zona', $zona->region) }}"
                                style="color: var(--ds-highlight-gold);">
                                {{ $zona->region->nombre }}
                            </a>
                        </li>

                        <li class="mb-2">
                            <strong>Tamaño del Territorio:</strong>
                            <br>
                            <span class="badge p-2" style="background-color: #6a0000; color: white;">
                                {{ ucfirst($zona->tamanyo) }}
                            </span>
                        </li>

                        <li class="mb-2">
                            <strong>ID de Registro:</strong>
                            <span class="text-muted">{{ $zona->id }}</span>
                        </li>

                        <li class="mb-2">
                            <strong>Fecha de Forja:</strong>
                            <span class="text-muted">{{ $zona->created_at?->format('d M Y') ?? 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div> {{-- Fin row --}}

        <hr style="border-color: var(--ds-border-grey);">

        <div class="mt-4 text-center">
            <a href="{{ route('zonas.index') }}" class="btn ds-btn px-4">
                <i class="fas fa-arrow-left"></i> Volver al Índice
            </a>
        </div>

    </div>
</div>
@endsection
