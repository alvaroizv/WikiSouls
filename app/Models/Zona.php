<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Objeto;
use App\Models\Region;
use App\Models\Enemigo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zona extends Model
{
    protected $table = "zona";
    protected $fillable = ['nombre','descripcion','tamanyo','region_id',"image"];


    function getPath(): string {
        $path = url('assets/img/portada.jpg');
        if($this->image != null &&
                file_exists(storage_path('app/public') . '/' . $this->image)) {
            $path = url('storage/' . $this->image);
        }
        return $path;
    }

    //Relacion con tabla Enemigos
    public function enemigos() : HasMany {
        return $this->hasMany('App\Models\Enemigo', );
    }
    
    //Relacion con tabla Objetos
    public function objetos() : HasMany {
        return $this->hasMany('App\Models\Objeto');
    }

    //Relacion con tabla Regiones
    public function region() : BelongsTo{
    return $this->belongsTo('App\Models\Region', region_id); 
    }
  
}
