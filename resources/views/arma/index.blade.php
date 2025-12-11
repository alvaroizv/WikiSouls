@extends('template.main')

@section('title', 'Índice de Armas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-md-12">

        <h2 style="color: var(--ds-highlight-gold);" class="mb-2">⚔️ Registro del Arsenal</h2>
        <p class="text-muted mb-4">Catálogo de todas las armas y herramientas de combate forjadas y descubiertas.</p>

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('armas.create') }}" class="btn ds-btn px-4">
                Forjar Nueva Arma
            </a>
        </div>

        <div class="list-group">

            @forelse ($armas as $arma)
            <div class="list-group-item list-group-item-action mb-3"
                style="background-color: #242424; border: 1px solid var(--ds-border-grey); border-radius: 8px;">

                <div class="d-flex w-100 justify-content-between align-items-center">

                    <div class="d-flex flex-column flex-grow-1 me-3 p-2">
                        
                        <h5 class="mb-1" style="color: var(--ds-highlight-gold);">
                            {{ $arma->nombre ?? Str::limit($arma->descripcion, 40, '...') }} 
                        </h5>

                        <p class="mb-2 small text-muted">
                            {{ Str::limit($arma->descripcion ?? 'Sin descripción.', 80, '...') }}
                        </p>
                        
                        @if ($arma->enemigos->count() > 0)
                            <div class="small mt-1 p-1 rounded" style="background-color: #3e2723; color: #ffab00;">
                                En Uso por: @foreach ($arma->enemigos as $enemigo)
                                    <span class="badge bg-danger">{{ $enemigo->nombre }}</span>
                                @endforeach
                            </div>
                        @else
                            <div class="small mt-1 p-1 rounded" style="background-color: #1b5e20; color: #c8e6c9;">
                                Estado: Libre (No equipada)
                            </div>
                        @endif
                        
                        <p class="mb-1 mt-2 small text-muted">
                            ID: {{ $arma->id }} | Forjada: {{ $arma->created_at?->format('d/m/Y') ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="d-flex flex-column align-items-end p-2">

                        <div class="text-center mb-3">
                            <span class="badge p-2" style="background-color: #6a0000; font-size: 1em;">
                                ⚔️ ATAQUE: {{ $arma->ataque }}
                            </span>
                        </div>
                        
                        <a href="{{ route('armas.show', $arma->id) }}" class="btn btn-sm ds-btn-outline mb-1 w-100">Ver Ficha</a>

                        <div class="d-flex mt-1">
                            <a href="{{ route('armas.edit', $arma->id) }}" class="btn btn-sm ds-btn-outline me-2">Editar</a>

                            {{-- FORMULARIO REAL DE ELIMINACIÓN --}}
                            <form id="delete-arma-{{ $arma->id }}" action="{{ route('armas.destroy', $arma) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')

                                @if ($arma->enemigos->count() > 0)
                                    {{-- Caso 1: Deshabilitado (El arma está en uso) --}}
                                    <button type="button" class="btn btn-danger btn-sm" disabled 
                                            title="No puedes eliminar un arma que está en uso por un enemigo.">
                                        <i class="fas fa-trash-alt"></i> Usada
                                    </button>
                                @else
                                    {{-- Caso 2: Botón que ABRE la Modal de Confirmación --}}
                                    <button type="button" class="btn btn-danger ds-btn-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal_{{ $arma->id }}">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN (Específica para cada arma) --}}
            <div class="modal fade" id="deleteModal_{{ $arma->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="
                        background-color: #2c2c2c; 
                        border: 2px solid #a00;
                        box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);">
                        
                        <div class="modal-header" style="border-bottom: 1px solid #444; background-color: #333;">
                            <h5 class="modal-title text-danger" id="deleteModalLabel">
                                <i class="fas fa-exclamation-triangle me-2"></i> Destrucción de Ítem
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                        </div>
                        
                        <div class="modal-body text-light text-center p-4">
                            <p class="lead text-warning">
                                ¡Atención, alma! Esta acción no se puede deshacer.
                            </p>
                            <p>
                                ¿Estás seguro de que deseas destruir el arma:
                                <strong style="color: var(--ds-highlight-gold);">"{{ $arma->nombre }}"</strong>?
                            </p>
                            <small class="text-muted">
                                Perderás todos los datos asociados a este ítem.
                            </small>
                        </div>
                        
                        <div class="modal-footer justify-content-between" style="border-top: 1px solid #444;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancelar / Retirada
                            </button>
                            
                            <button type="button" class="btn ds-btn-danger" 
                                    onclick="document.getElementById('delete-arma-{{ $arma->id }}').submit();">
                                <i style="color: white"  class="fas fa-skull-crossbones me-1"></i> Confirmar Destrucción
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            @empty
            <div class="alert alert-warning text-center"
                style="background-color: #3e2723; color: #ffab00; border-color: #ffab00;">
                No se han encontrado armas en el arsenal. ¡Es hora de ir a la fragua!
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection