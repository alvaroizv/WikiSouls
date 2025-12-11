<?php

namespace App\Http\Requests;

use App\Http\Requests\StoreZonaRequest; 
class EditZonaRequest extends StoreZonaRequest 
{
    public function rules(): array 
    {
        $rules = parent::rules(); 
        $id_a_ignorar = $this->zona->id; 

        $rules['nombre'] = 'required|string|max:255|unique:zona,nombre,' . $id_a_ignorar;

        return $rules;
    }
}