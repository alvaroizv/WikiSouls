@extends('template.main')

@section('title', 'Bestiario del Reino')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-md-12">

        <h2 style="color: var(--ds-highlight-gold);" class="mb-2">Registro de Fichas de Combate</h2>
        <p style="color: var(--ds-highlight-gold);"  class="mb-4">Un listado de todas las criaturas y adversarios catalogados en estas tierras.</p>

        <div class="d-flex justify-content-end mb-4">
            {{-- Enlace para crear un nuevo enemigo --}}
            <a href="{{ route('enemigos.create') }}" class="btn ds-btn px-4">
                Registrar Nuevo Adversario
            </a>
        </div>

        {{-- FICHAS DE BESTIARIO (Diseño tipo Acordeón/Medallón) --}}
        <div class="accordion" id="bestiaryAccordion">

            @forelse ($enemigos as $enemigo)
            <div class="accordion-item" style="background-color: #1a1a1a; border-color: #333333; margin-bottom: 10px;">

                {{-- ENCABEZADO MINIMALISTA (Siempre visible) --}}
                <h2 class="accordion-header" id="heading{{ $enemigo->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $enemigo->id }}" aria-expanded="false"
                        aria-controls="collapse{{ $enemigo->id }}"
                        style="background-color: #333333; color: var(--ds-text-light); border-bottom: 1px solid var(--ds-highlight-gold);">

                        <span class="me-3" style="color: var(--ds-highlight-gold); font-weight: bold;">
                            {{ $enemigo->nombre ?? 'Enemigo Sin Nombre' }}
                        </span>

                        <span class="badge me-2" style="background-color: #6a0000;">
                            Vida: {{ $enemigo->vida_T ?? '???' }}
                        </span>
                        <span class="badge me-2" style="background-color: #0d47a1;">
                            Ataque: {{ $enemigo->ataque_T ?? '???' }}
                        </span>

                        <span class="ms-auto me-3 small text-muted">
                            Zona: {{ $enemigo->zona->nombre ?? 'Desconocida' }}
                        </span>
                    </button>
                </h2>

                {{-- CUERPO DETALLADO (Se despliega al hacer clic) --}}
                <div id="collapse{{ $enemigo->id }}" class="accordion-collapse collapse"
                    aria-labelledby="heading{{ $enemigo->id }}" data-bs-parent="#bestiaryAccordion">
                    <div class="accordion-body" style="color: var(--ds-text-light);">
                        <div class="row">

                            {{-- Columna de Estadísticas Clave --}}
                            <div class="col-md-6 border-end" style="border-color: #444444 !important;">
                                <h5 style="color: var(--ds-highlight-gold);">Estadísticas Vitales</h5>
                                <ul class="list-unstyled small">
                                    <li><strong>❤️ Vida Total:</strong> {{ $enemigo->vida_T ?? 'N/A' }}</li>
                                    <li><strong>⚔️ Ataque Base:</strong> {{ $enemigo->ataque_T ?? 'N/A' }}</li>
                                    <li><strong>📍 Ubicación:</strong>
                                        <a href="{{ route('zonas.show', $enemigo->zona->id ?? '#') }}"
                                            style="color: #FFFFFF;">
                                            {{ $enemigo->zona->nombre ?? 'Territorio Raro' }}
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            {{-- Columna de Equipamiento --}}
                            <div class="col-md-6">
                                <h5 style="color: var(--ds-highlight-gold);">Equipamiento</h5>
                                <ul class="list-unstyled small">
                                    <li><strong>🗡️ Arma Equipada:</strong>
                                        {{ $enemigo->arma->nombre ?? 'Arma Desconocida' }} (ID:
                                        {{ $enemigo->arma_id ?? 'N/A' }})
                                    </li>
                                    <li><strong>📅 Último Registro:</strong>
                                        {{ $enemigo->updated_at?->format('Y-m-d') ?? 'N/A' }}</li>
                                </ul>
                            </div>

                        </div>
                        <hr style="border-color: #444444;">

                        {{-- Botones de Acción (ACTUALIZADO CON MODAL) --}}
                        <div class="d-flex justify-content-end mt-2">
                            <a href="{{ route('enemigos.show', $enemigo->id) }}"
                                class="btn btn-sm ds-btn-outline me-2">Detalles</a>
                            <a href="{{ route('enemigos.edit', $enemigo->id) }}"
                                class="btn btn-sm ds-btn-outline me-2">Editar Ficha</a>

                            {{-- Botón que lanza el Modal (TRIGGER) --}}
                            <button type="button" class="btn btn-sm btn-danger"
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmDeleteModal-{{ $enemigo->id }}">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="confirmDeleteModal-{{ $enemigo->id }}" tabindex="-1"
                aria-labelledby="confirmDeleteModalLabel-{{ $enemigo->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background-color: #242424; border: 1px solid var(--ds-border-grey);">

                        <div class="modal-header border-0" style="color: var(--ds-text-light);">
                            <h5 class="modal-title" id="confirmDeleteModalLabel-{{ $enemigo->id }}"
                                style="color: var(--ds-highlight-gold);">
                                ¡ALERTA! Acción Crítica
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar" style="filter: invert(1);"></button>
                        </div>

                        <div class="modal-body" style="color: var(--ds-text-light);">
                            <p>
                                Estás a punto de eliminar el registro del adversario {{ $enemigo->nombre }}.
                                Este acto no se puede revertir y afectará a todos los datos asociados.
                            </p>
                            <p class="text-danger small">
                                ¿Estás absolutamente seguro de que deseas extinguir esta flama?
                            </p>
                        </div>

                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                style="border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                                Cancelar
                            </button>

                            {{-- Formulario REAL de Eliminación (se envía al presionar) --}}
                            <form action="{{ route('enemigos.destroy', $enemigo->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ds-btn">
                                    Confirmar Eliminación
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <div class="alert alert-info text-center"
                style="background-color: #1a237e; color: #9fa8da; border-color: #9fa8da;">
                El Bestiario está vacío. No se han encontrado adversarios.
            </div>
            @endforelse
        </div> {{-- Fin acordeón --}}

    </div>
</div>
@endsection