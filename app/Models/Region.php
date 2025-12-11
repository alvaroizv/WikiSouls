<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{

    function getPath(): string {
        $path = url('assets/img/portada.jpg');
        if($this->image != null &&
                file_exists(storage_path('app/public') . '/' . $this->image)) {
            $path = url('storage/' . $this->image);
        }
        return $path;
    }
    protected $table = "region";
    protected $fillable = ["nombre","poblacion","dificultad","image"];

    //Relacion con tabla zona
    public function zonas() : HasMany{
        return $this->hasMany('App\Models\Zona', id_zona);
    }

}
