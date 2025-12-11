@extends('template.main')

@section('title', 'Crear Nueva Región')

@section('content')
{{-- BLOQUE DE DIAGNÓSTICO (PON ESTO AQUÍ) --}}
    @if ($errors->any())
        <div style="background-color: #a00; color: white; padding: 15px; margin-bottom: 20px; border: 2px solid gold;">
            <h3>🛡️ ERROR DE VALIDACIÓN: Lista Completa</h3>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- FIN BLOQUE DE DIAGNÓSTICO --}}
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <h2 style="color: var(--ds-highlight-gold);" class="mb-4">Forjar Nueva Región</h2>
            <p class="text-muted mb-4">Introduce los datos del nuevo territorio a explorar.</p>
            <form action="{{ route('regiones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="mb-3">
                    <label for="nombre" class="form-label" style="color: var(--ds-text-light);">Nombre de la Región</label>
                    <input type="text" 
                           class="form-control" 
                           id="nombre" 
                           name="nombre" 
                           value="{{ old('nombre') }}"
                           style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                    @error('nombre')
                        <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="poblacion" class="form-label" style="color: var(--ds-text-light);">Población Estimada</label>
                    <input type="number"
                           min="0" 
                           class="form-control" 
                           id="poblacion" 
                           name="poblacion"
                           style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                    @error('poblacion')
                        <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label" style="color: var(--ds-text-light);">Subir Mapa/image de la Zona</label>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/*"
                           style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                    @error('image')
                        <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="dificultad" class="form-label" style="color: var(--ds-text-light);">Nivel de Dificultad</label>
                    <select class="form-select" 
                            id="dificultad" 
                            name="dificultad"
                            required
                            style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                        <option value="">Selecciona la dificultad...</option>
                        <option value="facil">Baja (Para Cenizos Novatos)</option>
                        <option value="media">Media (Desafío Equilibrado)</option>
                        <option value="dificil">Alta (Peligro Extremo)</option>
                    </select>
                    @error('dificultad')
                        <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Botones de Acción --}}
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn ds-btn px-4">
                        Crear Región
                    </button>
                    
                    {{-- Botón de Cancelar que regresa al índice de regiones --}}
                    <a href="{{ route('regiones.index') }}" class="btn btn-outline-secondary" 
                       style="border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>
@endsection