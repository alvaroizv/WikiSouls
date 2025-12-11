@extends('template.main')

@section('title', 'Forjar Nueva Zona')

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
            <h2 style="color: var(--ds-highlight-gold);" class="mb-4">Forjar Nueva Zona</h2>
            <p class="text-muted mb-4">Define las características del nuevo territorio a explorar.</p>
            
            {{-- Formulario de Creación (SE AÑADE ENCTYPE) --}}
            <form action="{{ route('zonas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                
                {{-- CAMPO: Nombre de la Zona --}}
                <div class="mb-3">
                    <label for="nombre" class="form-label" style="color: var(--ds-text-light);">Nombre de la Zona</label>
                    <input type="text" 
                           class="form-control @error('nombre') is-invalid @enderror" 
                           id="nombre" 
                           name="nombre" 
                           value="{{ old('nombre') }}"
                           required
                           style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                    @error('nombre')
                        <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>

                {{-- CAMPO: image de la Zona --}}
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

                {{-- CAMPO: Región Perteneciente (region_id) --}}
                <div class="mb-3">
                <label for="region_id" class="form-label" style="color: var(--ds-text-light);">Región Perteneciente</label>
                <select class="form-select @error('region_id') is-invalid @enderror" 
                id="region_id" 
                name="region_id"
                required
              style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
        
              <option value="">Selecciona la Región...</option>
        
        @foreach ($regiones as $id => $nombre)
            <option value="{{ $id }}" {{ old('region_id') == $id ? 'selected' : '' }}>
                {{ $nombre }}
            </option>
        @endforeach
    </select>
    @error('region_id')
        <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
    @enderror
</div>

                {{-- CAMPO: Tamaño de la Zona --}}
                <div class="mb-3">
                    <label for="tamanyo" class="form-label" style="color: var(--ds-text-light);">Tamaño de la Zona</label>
                    
                    <select id="tamanyo" 
                            name="tamanyo" 
                            required 
                            class="form-control @error('tamanyo') is-invalid @enderror" 
                            style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                        
                        {{-- Opción por defecto --}}
                        <option value="" @if(old('tamanyo') == null) selected @endif disabled>-- Selecciona un tamaño de la zona --</option>
                        
                        {{-- Opciones ENUM fijas --}}
                        <option value="pequena" @if(old('tamanyo') == 'pequena') selected @endif>Pequeña</option>
                        <option value="mediana" @if(old('tamanyo') == 'mediana') selected @endif>Mediana</option>
                        <option value="gigante" @if(old('tamanyo') == 'gigante') selected @endif>Gigante</option>
                        
                    </select> 
                    
                    @error('tamanyo')
                        <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Campo descripcion (TextArea) --}}
                <div class="mb-4">
                    <label for="descripcion" class="form-label" style="color: var(--ds-text-light);">Descripción Detallada</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                              id="descripcion" 
                              name="descripcion" 
                              rows="4"
                              style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Botones de Acción --}}
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn ds-btn px-4">
                        Crear Zona
                    </button>
                    
                    {{-- Botón de Cancelar que regresa al índice de zonas --}}
                    <a href="{{ route('zonas.index') }}" class="btn btn-outline-secondary" 
                       style="border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection