@extends('template.main')

@section('title', 'Forjar Nuevo Objeto')

@section('content')
{{-- BLOQUE DE DIAGNÓSTICO --}}
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

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <h2 style="color: var(--ds-highlight-gold);" class="mb-4">Forjar Nuevo Objeto</h2>
        <p class="text-muted mb-4">Define las características del tesoro o ítem recién descubierto.</p>

        {{-- Formulario de Creación (SE AÑADE ENCTYPE) --}}
        <form action="{{ route('objetos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                    <label for="nombre" class="form-label" style="color: var(--ds-text-light);">Nombre del Objeto</label>
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
            {{-- CAMPO: Zona Perteneciente (zona_id) --}}
            <div class="mb-3">
                <label for="zona_id" class="form-label" style="color: var(--ds-text-light);">Zona de Origen</label>
                <select class="form-select @error('zona_id') is-invalid @enderror" id="zona_id" name="zona_id" required
                    style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">

                    <option value="">Selecciona la Zona...</option>

                    @foreach ($zonas as $id => $nombre)
                    <option value="{{ $id }}" {{ old('zona_id') == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                    @endforeach
                </select>
                @error('zona_id')
                <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                    <label for="image" class="form-label" style="color: var(--ds-text-light);">Subir Mapa/Imagen del Objeto</label>
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
            </div>
            {{-- CAMPO: Usos/Cargas (uso) --}}
            <div class="mb-3">
                <label for="usos" class="form-label" style="color: var(--ds-text-light);">Usos o Cargas
                    Disponibles</label>
                <input type="number" class="form-control @error('usos') is-invalid @enderror" id="usos"
                    name="usos" value="{{ old('usos') }}" required min="1"
                    style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                @error('usos')
                <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                @enderror
            </div>

            {{-- CAMPO: Descripción Detallada (TextArea) --}}
            <div class="mb-4">
                <label for="descripcion" class="form-label" style="color: var(--ds-text-light);">Descripción Detallada
                    del Objeto</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                    name="descripcion" rows="4" required
                    style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                @enderror
            </div>

            {{-- Botones de Acción --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn ds-btn px-4">
                    Crear Objeto
                </button>

                {{-- Botón de Cancelar que regresa al índice de objetos --}}
                <a href="{{ route('objetos.index') }}" class="btn btn-outline-secondary"
                    style="border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection