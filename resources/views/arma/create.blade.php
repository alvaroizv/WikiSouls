@extends('template.main')

@section('title', 'Forjar Nueva Arma')

@section('content')
    {{-- BLOQUE DE DIAGNÓSTICO (Muestra los errores de validación) --}}
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
            <h2 style="color: var(--ds-highlight-gold);" class="mb-4">Forjar Nueva Arma</h2>
            <p class="text-muted mb-4">Define el poder de ataque y la descripción de la nueva herramienta de combate.</p>
            
            {{-- Formulario de Creación --}}
            <form action="{{ route('armas.store') }}" method="POST">
                @csrf 
                
                {{-- CAMPO: Nombre --}}
                <div class="mb-3">
                    <label for="nombre" class="form-label" style="color: var(--ds-text-light);">Nombre del Arma</label>
                    <input type="text" 
                            class="form-control @error('nombre') is-invalid @enderror" 
                            id="nombre" 
                            name="nombre" 
                            value="{{ old('nombre') }}"
                            required
                            maxlength="100"
                            style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                    @error('nombre')
                        <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- CAMPO: Valor de Ataque --}}
                <div class="mb-3">
                    <label for="ataque" class="form-label" style="color: var(--ds-text-light);">Poder de Ataque (Daño Base)</label>
                    <input type="number" 
                            class="form-control @error('ataque') is-invalid @enderror" 
                            id="ataque" 
                            name="ataque" 
                            value="{{ old('ataque') }}"
                            required
                            min="1" 
                            max="999"
                            style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                    @error('ataque')
                        <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>

                {{-- CAMPO: Descripción Detallada (TextArea) --}}
                <div class="mb-4">
                    <label for="descripcion" class="form-label" style="color: var(--ds-text-light);">Descripción y Propiedades del Arma</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                id="descripcion" 
                                name="descripcion" 
                                rows="4"
                                required
                                style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Botones de Acción --}}
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn ds-btn px-4">
                        Crear Arma
                    </button>
                    
                    {{-- Botón de Cancelar que regresa al índice de armas --}}
                    <a href="{{ route('armas.index') }}" class="btn btn-outline-secondary" 
                        style="border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>
@endsection