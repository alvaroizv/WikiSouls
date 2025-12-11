@extends('template.main')

@section('title', 'Editar Zona: ' . $zona->nombre)

@section('content')
{{-- Nota: El bloque de diagnóstico se puede dejar mientras pruebas el update, luego se puede eliminar. --}}
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
        <h2 style="color: var(--ds-highlight-gold);" class="mb-4">Editar Zona: {{ $zona->nombre }}</h2>
        <p class="text-muted mb-4">Modifica las características del territorio.</p>

        <form action="{{ route('zonas.update', $zona) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 

            {{-- CAMPO: Nombre de la Zona --}}
            <div class="mb-3">
                <label for="nombre" class="form-label" style="color: var(--ds-text-light);">Nombre
                    de la Zona</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre"
                    value="{{ old('nombre', $zona->nombre) }}" required
                    style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                @error('nombre')
                <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">
                    {{ $message }}</div>
                @enderror
            </div>

            {{-- CAMPO: Región Perteneciente --}}
            <div class="mb-3">
                <label for="region_id" class="form-label" style="color: var(--ds-text-light);">Región
                    Perteneciente</label>
                <select class="form-select @error('region_id') is-invalid @enderror" id="region_id" name="region_id"
                    required
                    style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">


                    {{-- Determinamos qué ID debe estar seleccionado: old('region_id') o $zona->region_id --}}
                    @php
                    $selectedRegionId = old('region_id', $zona->region_id);
                    @endphp

                    <option value="">Selecciona la Región...</option>

                    @foreach ($regiones as $id => $nombre)
                    <option value="{{ $id }}" {{ $selectedRegionId == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                    @endforeach
                </select>
                @error('region_id')
                <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 p-3" style="border: 1px dashed #444; background-color: #1f1f1f;">
                <label class="form-label mb-3" style="color: var(--ds-text-light); font-weight: bold;">
                    Imagen de la Zona (Actual)
                </label>

                @if($zona->image)
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('storage/' . $zona->image) }}" alt="Imagen actual de {{ $zona->nombre }}" 
                             style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #555; margin-right: 15px;">
                        
                        <div>
                            <p class="mb-0" style="color: var(--ds-text-light-muted);">
                                Imagen activa.
                                <a href="{{ asset('storage/' . $zona->image) }}" target="_blank" style="color: var(--ds-highlight-gold);">Ver en grande</a>
                            </p>
                            <p class="mb-0 text-warning" style="font-size: var(--ds-font-small);">Sube un nuevo archivo abajo para reemplazarla.</p>
                        </div>
                    </div>
                @else
                    <p class="text-muted mb-3" style="font-style: italic;">No hay imagen asignada a esta zona.</p>
                @endif
                
                <hr style="border-top: 1px solid #333;">

                <label for="image" class="form-label mt-2" style="color: var(--ds-text-light);">Forjar nueva Imagen</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                    style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                
                <div id="imageHelp" class="form-text" style="color: var(--ds-text-light-muted);">
                    Máx. 2MB. Sube una nueva imagen para reemplazar la actual.
                </div>

                @error('image')
                <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">
                    {{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tamanyo" class="form-label" style="color: var(--ds-text-light);">Tamaño
                    de la Zona</label>

                <select id="tamanyo" name="tamanyo" required class="form-control @error('tamanyo') is-invalid @enderror"
                    style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">


                    {{-- Determinamos qué valor debe estar seleccionado: old('tamanyo') o $zona->tamanyo --}}
                    @php
                    $selectedTamanyo = old('tamanyo', $zona->tamanyo);
                    @endphp

                    <option value="" @if($selectedTamanyo==null) selected @endif disabled>--
                        Selecciona un tamaño de la zona --</option>

                    {{-- Opciones ENUM fijas --}}
                    <option value="pequena" @if($selectedTamanyo=='pequena' ) selected @endif>
                        Pequeña</option>
                    <option value="mediana" @if($selectedTamanyo=='mediana' ) selected @endif>
                        Mediana</option>
                    <option value="gigante" @if($selectedTamanyo=='gigante' ) selected @endif>
                        Gigante</option>

                </select>

                @error('tamanyo')
                <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">
                    {{ $message }}</div>
                @enderror
            </div>

            {{-- CAMPO: Descripción Detallada (TextArea) --}}
            <div class="mb-4">
                <label for="descripcion" class="form-label" style="color: var(--ds-text-light);">Descripción
                    Detallada</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                    name="descripcion" rows="4"
                    style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">{{ old('descripcion', $zona->descripcion) }}</textarea>
                @error('descripcion')
                <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">
                    {{ $message }}</div>
                @enderror
            </div>

            {{-- Botones de Acción --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn ds-btn px-4">
                    Guardar Cambios
                </button>

                {{-- Botón de Cancelar que regresa al índice de zonas --}}
                <a href="{{ route('zonas.show', $zona) }}" class="btn btn-outline-secondary"
                    style="border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                    Descartar
                </a>
            </div>

        </form>
    </div>
</div>
@endsection