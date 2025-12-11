<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Arma;
use App\Models\Escudo;
use App\Models\Zona;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Enemigo extends Model
{

    function getPath(): string {
        $path = url('assets/img/portada.jpg');
        if($this->image != null &&
                file_exists(storage_path('app/public') . '/' . $this->image)) {
            $path = url('storage/' . $this->image);
        }
        return $path;
    }
    protected $table = "enemigo";
    protected $fillable = ["nombre","vida_T","ataque_T","zona_id","arma_id","image"];

    //Relacion con tabla Arma
    public function arma() : BelongsTo {
        return $this->belongsTo('App\Models\Arma', arma_id);
    }

    //Relacion con tabla Zona
    public function zona() : BelongsTo{
        return $this->belongsTo('App\Models\Zona', zona_id);
    }
}
