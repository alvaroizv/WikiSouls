<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Zona;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Objeto extends Model
{

    function getPath(): string {
        $path = url('assets/img/portada.jpg');
        if($this->image != null &&
                file_exists(storage_path('app/public') . '/' . $this->image)) {
            $path = url('storage/' . $this->image);
        }
        return $path;
    }
    protected $table = "objeto";
    protected $fillable = ["nombre","usos","zona_id","descripcion","image"];

    //Relacion con tabla zona
    public function zona() : BelongsTo {
        return $this->belongsTo('App\Models\Zona', zona_id);
    }
}
