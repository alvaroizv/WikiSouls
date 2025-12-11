<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enemigo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Arma extends Model
{

    function getPath(): string {
        $path = url('assets/img/portada.jpg');
        if($this->image != null &&
                file_exists(storage_path('app/public') . '/' . $this->image)) {
            $path = url('storage/' . $this->image);
        }
        return $path;
    }
    
    protected $table = "arma";
    protected $fillable = ["nombre","descripcion","ataque","image"];

    // Relacion con enemigos
    public function enemigos() : HasMany {
        return $this->hasMany('App\Models\Enemigo', id_enemigo);
    }
}
