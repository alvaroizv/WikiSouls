<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Objeto;
use App\Models\Region;
use App\Models\Enemigo;

class Zona extends Model
{
    protected $table = "zona";
    protected $fillable = ['nombre','descripcion','tamanyo','region_id',"image"];


    function getPath(): string {
        $path = url('assets/img/afeitado.jpg');
        if($this->image != null &&
                file_exists(storage_path('app/public') . '/' . $this->image)) {
            $path = url('storage/' . $this->image);
        }
        return $path;
    }
    public function enemigos(){
        return $this->hasMany(Enemigo::class);
    }

    public function objetos(){
        return $this->hasMany(Objeto::class);
    }

    public function region(){
    return $this->belongsTo(Region::class); 
    }
  
}