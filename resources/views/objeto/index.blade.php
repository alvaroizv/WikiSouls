@extends('template.main')

@section('title', 'Índice de Objetos (Catálogo)')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12 col-md-12">

        <h2 style="color: var(--ds-highlight-gold);" class="mb-2">📜 Catálogo de Tesoros</h2>
        <p class="text-muted mb-4">Descubre los objetos y reliquias catalogados en las tierras del reino.</p>

        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('objetos.create') }}" class="btn ds-btn px-4">
                Forjar Nuevo Objeto
            </a>
        </div>

        <div class="row">
            @forelse ($objetos as $objeto)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100" style="background-color: #242424; border: 1px solid var(--ds-border-grey);">
                    <div class="card-body">

                        <h5 class="card-title mb-1" style="color: var(--ds-highlight-gold);">
                            {{ Str::limit($objeto->descripcion, 30, '...') }}
                        </h5>

                        <img src="{{ $objeto->getPath() }}"
                            alt="Mapa de la Zona: {{ $objeto->nombre ?? 'Objeto' }}"
                            class="img-fluid rounded shadow-lg mb-3"
                            style="max-height: 400px; object-fit: cover;">

                        <p class="card-text small mb-3" style="color: var(--ds-text-light);">
                            ID: {{ $objeto->id }} | Usos: <strong style="color: white;">{{ $objeto->usos }}</strong>
                        </p>

                        <hr style="border-color: #333333;">

                        <div class="mb-3">
                            <small style="color: var(--ds-text-light);">Ubicado en:</small><br>
                            @if ($objeto->zona)
                            <a href="{{ route('zonas.show', $objeto->zona->id) }}"
                                style="color: #ccc; font-weight: bold;">
                                {{ $objeto->zona->nombre }}
                            </a>
                            @else
                            <span class="text-muted">Zona Desconocida</span>
                            @endif
                        </div>

                        <p class="card-text small text-right" style="color: #666;">
                            Forjado: {{ $objeto->created_at?->format('d/m/y') ?? 'N/A' }}
                        </p>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('objetos.show', $objeto->id) }}" class="btn btn-sm ds-btn-outline">Ver</a>
                            <a href="{{ route('objetos.edit', $objeto->id) }}"
                                class="btn btn-sm ds-btn-outline">Editar</a>

                            {{-- FORMULARIO REAL DE ELIMINACIÓN --}}
                            <form id="delete-objeto-{{ $objeto->id }}" action="{{ route('objetos.destroy', $objeto->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                
                                {{-- BOTÓN QUE ABRE LA MODAL --}}
                                <button type="button" class="btn btn-sm btn-danger ds-btn-danger"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteObjetoModal_{{ $objeto->id }}">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN --}}
            <div class="modal fade" id="deleteObjetoModal_{{ $objeto->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="
                        background-color: #2c2c2c; 
                        border: 2px solid #a00;
                        box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);">
                        
                        <div class="modal-header" style="border-bottom: 1px solid #444; background-color: #333;">
                            <h5 class="modal-title text-danger" id="deleteModalLabel">
                                <i class="fas fa-exclamation-triangle me-2"></i> Destrucción de Reliquia
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
                        </div>
                        
                        <div class="modal-body text-light text-center p-4">
                            <p class="lead text-warning">
                                ¡Atención, alma! Esta reliquia se desvanecerá para siempre.
                            </p>
                            <p>
                                ¿Confirmas la destrucción de:
                                <strong style="color: var(--ds-highlight-gold);">{{ Str::limit($objeto->descripcion, 30, '...') }}</strong>?
                            </p>
                            <small class="text-muted">
                                El objeto será borrado del catálogo.
                            </small>
                        </div>
                        
                        <div class="modal-footer justify-content-between" style="border-top: 1px solid #444;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancelar / Retirada
                            </button>
                            
                            {{-- Botón que envía el formulario de eliminación --}}
                            <button type="button" class="btn ds-btn-danger" 
                                    onclick="document.getElementById('delete-objeto-{{ $objeto->id }}').submit();">
                                <i class="fas fa-skull-crossbones me-1"></i> Confirmar Destrucción
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center"
                    style="background-color: #3e2723; color: #ffab00; border-color: #ffab00;">
                    No se han encontrado objetos en el registro. ¡El catálogo está vacío!
                </div>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection