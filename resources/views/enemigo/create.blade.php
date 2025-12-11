@extends('template.main')

@section('title', 'Registrar Nuevo Adversario')

@section('content')
{{-- BLOQUE DE DIAGNÓSTICO DE ERRORES --}}
@if ($errors->any() || session('error'))
<div style="background-color: #a00; color: white; padding: 15px; margin-bottom: 20px; border: 2px solid gold;">
    <h3>🛡️ ERROR DE VALIDACIÓN: Lista Completa</h3>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        @if(session('error'))
        <li>{{ session('error') }}</li>
        @endif
    </ul>
</div>
@endif

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <h2 style="color: var(--ds-highlight-gold);" class="mb-4">Registrar Nuevo Adversario</h2>
        <p style="color: var(--ds-text-light);" class="mb-4">Define las estadísticas y el origen del nuevo
            enemigo.</p>

        {{-- Formulario de Creación (APUNTA A enemigos.store) --}}
        <form action="{{ route('enemigos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- CAMPO: Nombre del Enemigo (nombre) --}}
            <div class="mb-3">
                <label for="nombre" class="form-label" style="color: var(--ds-text-light);">Nombre del
                    Enemigo</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre"
                    value="{{ old('nombre') }}" required
                    style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                @error('nombre')
                <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}
                </div>
                @enderror
            </div>

            {{-- GRUPO: Vida y Ataque (en una sola fila con columnas internas para mejor layout) --}}
            <div class="row">
                {{-- CAMPO: Vida Total (vida_T) --}}
                <div class="col-md-6 mb-3">
                    <label for="vida_T" class="form-label" style="color: var(--ds-text-light);">Vida Total</label>
                    <input type="number" class="form-control @error('vida_T') is-invalid @enderror" id="vida_T"
                        name="vida_T" value="{{ old('vida_T') }}" required min="1"
                        style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                    @error('vida_T')
                    <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>

                {{-- CAMPO: Ataque Total (ataque_T) --}}
                <div class="col-md-6 mb-3">
                    <label for="ataque_T" class="form-label" style="color: var(--ds-text-light);">Ataque Total</label>
                    <input type="number" class="form-control @error('ataque_T') is-invalid @enderror" id="ataque_T"
                        name="ataque_T" value="{{ old('ataque_T') }}" required min="0"
                        style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                    @error('ataque_T')
                    <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- CAMPO: Zona Perteneciente (zona_id) --}}
            <div class="mb-3">
                <label for="zona_id" class="form-label" style="color: var(--ds-text-light);">Zona de
                    Aparición</label>
                <select class="form-select @error('zona_id') is-invalid @enderror" id="zona_id" name="zona_id" required
                    style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">

                    <option value="">Selecciona la Zona...</option>

                    {{-- $zonas debe ser pasado desde el controlador --}}
                    @foreach ($zonas as $id => $nombre)
                    <option value="{{ $id }}" {{ old('zona_id') == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                    @endforeach
                </select>
                @error('zona_id')
                <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}
                </div>
                @enderror
            </div>

            {{-- CAMPO: Arma (arma_id) --}}
            <div class="mb-3">
                <label for="arma_id" class="form-label" style="color: var(--ds-text-light);">Arma
                    Equipada</label>
                <select class="form-select @error('arma_id') is-invalid @enderror" id="arma_id" name="arma_id" required
                    style="background-color: #242424; border-color: var(--ds-border-grey); color: var(--ds-text-light);">

                    <option value="">Selecciona el Arma...</option>

                    {{-- $armas debe ser pasado desde el controlador --}}
                    @foreach ($armas as $id => $nombre)
                    <option value="{{ $id }}" {{ old('arma_id') == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                    @endforeach
                </select>
                @error('arma_id')
                <div class="text-danger mt-1" style="font-size: var(--ds-font-small);">{{ $message }}
                </div>
                @enderror
            </div>

            {{-- Botones de Acción --}}
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn ds-btn px-4">
                    Registrar Adversario
                </button>

                {{-- Botón de Cancelar que regresa al índice de enemigos --}}
                <a href="{{ route('enemigos.index') }}" class="btn btn-outline-secondary"
                    style="border-color: var(--ds-border-grey); color: var(--ds-text-light);">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection