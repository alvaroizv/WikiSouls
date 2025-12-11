@extends('template.main')

{{-- Título dinámico: Usa el nombre de la región si está disponible, sino usa el título general --}}
@section('title', isset($region) ? 'Zonas de ' . $region->nombre : 'Índice General de Zonas')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4" style="color: var(--ds-highlight-gold);">
            {{-- Encabezado dinámico --}}
            @if (isset($region))
            Zonas dentro de: {{ $region->nombre }}
            @else
            Mapa del Mundo
            @endif
        </h1>

        {{-- Mostrar Mensajes Flash (Éxito/Error) --}}
        @if (session('success'))
        <div class="alert alert-success border-0 mb-4" role="alert" style="background-color: #388e3c; color: white;">
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger border-0 mb-4" role="alert" style="background-color: #d32f2f; color: white;">
            {{ session('error') }}
        </div>
        @endif

        {{-- Botón para Crear Nueva Zona --}}
        <div class="d-flex justify-content-end mb-4">
            {{-- Si estamos en una región, pasamos su ID para crear una zona asociada --}}
            <a href="{{ route('zonas.create', isset($region) ? ['region_id' => $region->id] : []) }}"
                class="btn ds-btn px-4">
                + Forjar Nueva Zona
            </a>
        </div>

        {{-- Inicio de la Tabla de Zonas --}}
        @if ($zonas->isEmpty())
        <div class="alert alert-warning border-0" role="alert" style="background-color: #ffc107; color: #343a40;">
            No hay zonas registradas. Es hora de explorar.
        </div>
        @else
        <div class="table-responsive ds-container">
            <table class="table table-dark table-striped table-hover mb-0"
                style="border: 1px solid var(--ds-border-grey);">
                <thead style="background-color: #343a40; border-bottom: 2px solid var(--ds-highlight-gold);">
                    <tr>
                        <th scope="col" style="color: var(--ds-highlight-gold);"># ID</th>
                        <th scope="col" style="color: var(--ds-highlight-gold);">Nombre de la Zona</th>
                        <th scope="col" style="color: var(--ds-highlight-gold);">Tamaño</th>
                        <th scope="col" style="color: var(--ds-highlight-gold);">Descripción (Extracto)</th>

                        {{-- Solo mostramos la región si estamos viendo todas las zonas --}}
                        @if (!isset($region))
                        <th scope="col" style="color: var(--ds-highlight-gold);">Región Asociada</th>
                        @endif

                        <th scope="col" style="color: var(--ds-highlight-gold);">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($zonas as $zona)
                    <tr>
                        <th scope="row">{{ $zona->id }}</th>
                        <td>
                            <a href="{{ route('zonas.show', $zona->id) }}"
                                style="color: var(--ds-text-light); text-decoration: none;">
                                {{ $zona->nombre }}
                            </a>
                        </td>
                        {{-- CAMPO: tamanyo --}}
                        <td>{{ $zona->tamanyo ?? 'N/A' }}</td>

                        {{-- CAMPO: descripcion (Mostramos un extracto) --}}
                        <td>{{ Str::limit($zona->descripcion, 40) ?? 'Sin descripción' }}</td>

                        {{-- Región Asociada (Condicional) --}}
                        @if (!isset($region))
                        <td>
                            @if ($zona->region)
                                <a href="{{ route('regiones.show', $zona->region->id) }}" style="color: var(--ds-text-light);">
                                    {{ $zona->region->nombre }}
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        @endif

                        <td>
                            {{-- Botón Ver --}}
                            <a href="{{ route('zonas.show', $zona->id) }}" class="btn btn-sm ds-btn"
                                title="Ver Detalles">
                                Ver
                            </a>

                            {{-- LÓGICA DE AUTORIZACIÓN: EDITAR Y ELIMINAR --}}
                            @if (auth()->check() && $zona->user_id === auth()->id())
                                {{-- Botón Editar (Visible solo para el creador) --}}
                                <a href="{{ route('zonas.edit', $zona->id) }}" class="btn btn-sm ds-btn"
                                    title="Editar Zona">
                                    Editar
                                </a>

                                {{-- Botón Eliminar (Visible solo para el creador) --}}
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar Zona"
                                    data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $zona->id }}">
                                    Eliminar
                                </button>
                            @else
                                {{-- Si el usuario está logueado pero NO es el creador --}}
                                @if (auth()->check())
                                    <button type="button" class="btn btn-sm btn-secondary" disabled 
                                            title="Solo el creador (ID: {{ $zona->user_id }}) puede editar/eliminar.">
                                        <i class="fas fa-lock me-1"></i> Bloqueado
                                    </button>
                                @else
                                    {{-- Si el usuario no está logueado --}}
                                    <span class="text-muted small ms-2">Acceso restringido</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    
                    {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN (dentro del bucle) --}}
                    <div class="modal fade" id="confirmDeleteModal-{{ $zona->id }}" tabindex="-1"
                        aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content"
                                style="background-color: #2c2c2c; border: 2px solid #a00; box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);">

                                <div class="modal-header border-0" style="background-color: #333;">
                                    <h5 class="modal-title text-danger" id="confirmDeleteModalLabel">
                                        <i class="fas fa-exclamation-triangle me-2"></i> Destrucción de Zona
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Cerrar" style="filter: invert(1);"></button>
                                </div>

                                <div class="modal-body text-light text-center p-4">
                                    <p class="lead text-warning">
                                        ¡Atención! Este acto es irreversible.
                                    </p>
                                    <p>
                                        Estás a punto de eliminar la zona:
                                        <strong style="color: var(--ds-highlight-gold);">"{{ $zona->nombre }}"</strong>.
                                    </p>
                                    <p class="text-danger small">
                                        **Se eliminarán todos los datos asociados (enemigos, objetos, etc.).**
                                    </p>
                                </div>

                                <div class="modal-footer justify-content-between" style="border-top: 1px solid #444;">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancelar
                                    </button>

                                    {{-- Formulario ÚNICO de Eliminación que se envía con el botón de Confirmar --}}
                                    <form action="{{ route('zonas.destroy', $zona->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn ds-btn-danger">
                                            <i class="fas fa-skull-crossbones me-1"></i> Confirmar Destrucción
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Botón de regreso si estamos dentro de una región --}}
        @if (isset($region))
        <div class="mt-4">
            <a href="{{ route('regiones.index') }}" class="btn btn-outline-secondary"
                style="border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                ← Volver al Índice de Regiones
            </a>
        </div>
        @endif
    </div>
</div>
@endsection