@extends('template.main')

@section('title', 'La Tierra de los No Muertos')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            {{-- SECCIÓN PRINCIPAL DE BIENVENIDA --}}
            <div class="card mb-5" style="
                background-color: #1a1a1a; 
                border: 2px solid var(--ds-highlight-gold);
                box-shadow: 0 0 20px rgba(255, 204, 0, 0.6);
                color: #FFFFFF;
            ">
                <div class="card-header text-center" style="
                    background-color: #333333;
                    color: var(--ds-highlight-gold);
                    font-size: 2.5rem;
                    border-bottom: 2px solid var(--ds-highlight-gold);
                    padding: 1.5rem;
                ">
                    <i class="fas fa-dungeon me-2"></i> {{ __('Lordran: El Reino de los Dioses y No Muertos') }}
                </div>

                <div class="card-body p-5 text-center">
                    <p class="lead" style="color: #CCCCCC; font-size: 1.2rem;">
                        {{ $welcomeMessage }}
                    </p>
                    
                    <p style="color: #AAAAAA;">
                        {{ __('El destino de la Primera Llama recae sobre tus hombros, Alma Enlazada. Utiliza el mapa de regiones para encontrar tu próximo santuario.') }}
                    </p>
                    
                    {{-- Botón de Llamada a la Acción (CTA) --}}
                    <a href="{{ route('regiones.index') }}" class="btn ds-btn-outline mt-4" style="
                        font-size: 1.2rem; 
                        padding: 0.8rem 2rem;
                        color: var(--ds-highlight-gold);
                    ">
                        <i style="color: #FFFFFF" class="fas fa-map-marker-alt me-2"></i> {{ __('Explorar Regiones') }}
                    </a>
                </div>
            </div>

            {{-- ------------------------------------------------ --}}
            {{-- SECCIÓN AMPLIADA: INTRODUCCIÓN AL LORE DE REGIONES --}}
            {{-- ------------------------------------------------ --}}
            
            <h3 class="text-center mb-4" style="color: #BBBBBB; font-style: italic; border-bottom: 1px dashed #444; padding-bottom: 10px;">
                {{ __('Relatos de la Ceniza: Lugares de Poder') }}
            </h3>

            <blockquote class="blockquote text-center mb-5 p-3" style="border-left: 5px solid var(--ds-highlight-gold); background-color: #222222; color: #CCCCCC;">
                <p class="mb-0">{{ __('"Si buscas la verdad, debes aventurarte más allá del Santuario. Cada región es un testigo de la historia, una tumba de un señor, o el recuerdo de una era ya extinguida. La llama te guiará, pero el camino lo forjas tú."') }}</p>
                <footer class="blockquote-footer mt-2" style="color: #888888;">Narrador de la Hoguera</footer>
            </blockquote> 
        </div>
    </div>
</div>
@endsection