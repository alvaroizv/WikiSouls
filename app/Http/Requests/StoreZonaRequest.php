<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreZonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Define las reglas de validación que se aplican a la petición.
     */
    public function rules(): array
    {
        return [
            // Reglas de validación para la creación de Zona
            'nombre' => 'required|string|max:255|unique:zona,nombre', // Asumo 'zona' es el nombre de la tabla
            'descripcion' => 'required|string|max:1000',
            'tamanyo' => 'required|in:pequena,mediana,gigante', // Regla 'in' para opciones limitadas
            'region_id' => 'required|exists:region,id', // Asumo 'region' es el nombre de la tabla
            'image' => 'nullable|image|max:2048', // Imagen opcional, máx 2MB
        ];
    }

    /**
     * Define los nombres amigables de los atributos para los mensajes de error.
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'Nombre de la Zona',
            'descripcion' => 'Descripción',
            'tamanyo' => 'Tamaño',
            'region_id' => 'Región Asociada',
            'image' => 'Imagen de la Zona',
        ];
    }

    /**
     * Define los mensajes de error personalizados.
     */
    public function messages(): array
    {
        $required = 'Es obligatorio introducir el campo :attribute.';
        
        return [
            'nombre.required' => $required,
            'nombre.max' => 'La longitud máxima del :attribute es :max caracteres.',
            'nombre.unique' => 'El nombre de la zona es único. Esa zona ya existe en el mapa.',

            'descripcion.required' => $required,
            'descripcion.max' => 'La :attribute no puede exceder los :max caracteres.',

            'tamanyo.required' => $required,
            'tamanyo.in' => 'El campo :attribute debe ser uno de los siguientes: pequeña, mediana o gigante.',

            'region_id.required' => $required,
            'region_id.exists' => 'La :attribute seleccionada no está definida en el mundo.',

            'image.image' => 'El archivo debe ser una imagen válida.',
            'image.max' => 'La :attribute no puede pesar más de 2048 KB.',
        ];
    }
}